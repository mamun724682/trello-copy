<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
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
Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('auth-user', [AuthController::class, 'authUser']);
        Route::get('logout', [AuthController::class, 'logout']);

        // Projects
        Route::apiResource('projects', ProjectController::class);

        // Users
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('api-users', [UserController::class, 'apiUsers'])->name('users.apiUsers');
    });
});
