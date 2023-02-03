<?php

namespace App\Http\Controllers\Api;

use App\Clusters\Api\UsersControllerInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UsersControllerRequests\CreateRequest;
use App\Http\Requests\Api\UsersControllerRequests\MakePaymentRequest;
use App\Http\Requests\Api\UsersControllerRequests\UpdateProfile;
use App\Http\Requests\Api\UsersControllerRequests\UpdateRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends Controller
{

    /**
     * @var UsersControllerInterface
     */
    private UsersControllerInterface $usersController;

    /**
     * @param UsersControllerInterface $usersController
     */
    public function __construct(
        UsersControllerInterface $usersController
    )
    {
        $this->usersController = $usersController;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->usersController->index();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return $this->usersController->show($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MakePaymentRequest $request
     * @return JsonResponse
     */
    public function pay(MakePaymentRequest $request): JsonResponse
    {
        return $this->usersController->pay($request);
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
        return $this->usersController->update($request, $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfile $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfile $request): JsonResponse
    {
        return $this->usersController->updateProfile($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->usersController->destroy($id);
    }
}
