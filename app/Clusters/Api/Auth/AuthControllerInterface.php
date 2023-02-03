<?php

namespace App\Clusters\Api\Auth;

use App\Http\Requests\Api\Auth\AuthControllerRequests\LoginRequest;
use App\Http\Requests\Api\Auth\AuthControllerRequests\RegisterRequest;
use App\Http\Requests\Api\UsersControllerRequests\UpdateProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AuthControllerInterface
{

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse;

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse;

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfile $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfile $request): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse;

}
