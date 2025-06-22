<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    // Role Controller
    Route::put('role-archived/{id}', [RoleController::class, 'archived']);
    Route::resource("role", RoleController::class);

    // User Controller
    Route::put('user-archived/{id}', [UserController::class, 'archived']);
    Route::resource("user", UserController::class);

    // auth controller
    Route::patch('changepassword', [AuthController::class, 'changedPassword']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::patch('resetpassword/{id}', [AuthController::class, 'resetPassword']);
});