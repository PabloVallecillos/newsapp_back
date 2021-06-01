<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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

Route::group(['prefix' => '{lang}'], function () {

    Route::group(['middleware' => 'throttle:2,1'], function () {

    });
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('user/logged', [UserController::class, 'getUserLogged'])->name('api.user.logged');
        Route::post('user/profile/edit/{user}', [UserController::class, 'update'])->name('api.user.profile.edit');
//        Route::apiResource('user', UserController::class);
    });
});

