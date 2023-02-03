<?php

namespace App\Http\Controllers\Api\Auth;

use App\Clusters\Api\Auth\AuthControllerInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthControllerRequests\LoginRequest;
use App\Http\Requests\Api\Auth\AuthControllerRequests\RegisterRequest;
use App\Http\Requests\Api\UsersControllerRequests\UpdateProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @var AuthControllerInterface
     */
    private AuthControllerInterface $authsController;

    /**
     * @param AuthControllerInterface $authsController
     */
    public function __construct(
        AuthControllerInterface $authsController
    )
    {
        $this->authsController = $authsController;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authsController->login($request);
    }

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->authsController->me();
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->authsController->register($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfile $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfile $request): JsonResponse
    {
        return $this->authsController->updateProfile($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        return $this->authsController->logout($request);
    }

}
