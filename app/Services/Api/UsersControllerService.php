<?php

namespace App\Services\Api;

use App\Clusters\Api\UsersControllerInterface;
use App\Http\Requests\Api\UsersControllerRequests\MakePaymentRequest;
use App\Http\Requests\Api\UsersControllerRequests\UpdateProfile;
use App\Http\Requests\Api\UsersControllerRequests\UpdateRequest;
use App\Models\User;
use App\Models\UserPayment;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersControllerService implements UsersControllerInterface
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
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->user->whereNot('id', Auth::user()->id)->get();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MakePaymentRequest $request
     * @return JsonResponse
     */
    public function pay(MakePaymentRequest $request): JsonResponse
    {
        $user = $this->userPayment->create(['payed' => $request->sum, 'user_id' => Auth::user()->id]);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->user->findOrFail($id);
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $user = $this->user->findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = $this->user->findOrFail($id);
        $user->delete();
        return response()->json($user, 200);
    }
}
