<?php

namespace App\Services\Api\Auth;

use App\Clusters\Api\Auth\AuthControllerInterface;
use App\Http\Requests\Api\UsersControllerRequests\UpdateProfile;
use App\Models\UserPayment;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\Auth\AuthControllerRequests\LoginRequest;
use App\Http\Requests\Api\Auth\AuthControllerRequests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthControllerService implements AuthControllerInterface
{

    /**
     * @var User
     */
    private User $user;

    /**
     * @var UserPayment
     */
    private UserPayment $userPayment;

    /**
     * @param User $user
     * @param UserPayment $userPayment
     */
    public function __construct(
        User        $user,
        UserPayment $userPayment
    )
    {
        $this->user = $user;
        $this->userPayment = $userPayment;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->all())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response()->json([
            'status' => 'success',
            'user' => auth()->user(),
            'authorisation' => [
                'token' => $accessToken,
                'type' => 'bearer',
            ]
        ]);

    }

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(Auth::user()->load(['payments' => function ($q) {
            $q->whereNot('payed', 0);
        }]), 200);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $this->userPayment->create(['user_id' => $user->id]);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfile $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfile $request): JsonResponse
    {
        $user = Auth::user()->update($request->all());
        return response()->json($user, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

}
