<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
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


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);


Route::group(["middleware" => "auth:sanctum"], function () {


    // Route::apiResources([
    //     'user' => UserController::class,
    //     'roles' => RoleController::class,
    // ]);


    Route::group(["prefix" => "user"], function () {
        Route::get('/', [UserController::class, 'index'])->middleware("permission:show user");
        Route::post('/', [UserController::class, 'store'])->middleware("permission:create user");
        Route::get('/{user}', [UserController::class, 'show'])->middleware("permission:show user");
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware("permission:remove user");
        Route::patch('/{user}', [UserController::class, 'update'])->middleware("permission:update user");
    });

    Route::group(['prefix' => 'roles', 'middleware' => 'role_or_permission:admin|update user|create user'], function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{role}', [RoleController::class, 'show']);
        Route::patch('/{role}', [RoleController::class, 'update']);
        Route::delete('/{role}', [RoleController::class, 'destroy']);
    });
});
