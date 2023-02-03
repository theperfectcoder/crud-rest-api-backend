<?php

namespace App\Clusters\Api;

use App\Http\Requests\Api\UsersControllerRequests\MakePaymentRequest;
use App\Http\Requests\Api\UsersControllerRequests\UpdateProfile;
use App\Http\Requests\Api\UsersControllerRequests\UpdateRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

interface UsersControllerInterface
{

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param MakePaymentRequest $request
     * @return JsonResponse
     */
    public function pay(MakePaymentRequest $request): JsonResponse;

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse;

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse;

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse;

}
