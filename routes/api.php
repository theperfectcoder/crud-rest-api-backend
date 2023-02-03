<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/me', 'me')->middleware('auth:api');
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->middleware('auth:api');
    Route::put('/update-profile', 'updateProfile')->middleware('auth:api');
    Route::post('/refresh', 'refresh')->middleware('auth:api');
});

Route::controller(UsersController::class)->middleware('auth:api')->group(function () {
    Route::get('/users', 'index')->middleware('admin');
    Route::get('/user/{id}', 'show');
    Route::post('/pay', 'pay');
    Route::put('/user/{id}', 'update');
    Route::delete('/user/{id}', 'destroy');
});
