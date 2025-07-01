<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CemeteriesController;
use App\Http\Controllers\Api\LotController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('registration', [AuthController::class, 'registration']);


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return response()->json(['message' => 'Email verified successfully.']);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

// Resend verification email
Route::post('email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified.'], 400);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => 'Verification email sent.']);
})->middleware(['auth:sanctum', 'throttle:6,1']);


Route::get("cemeteries", [CemeteriesController::class, 'index']);
Route::get("lot", [LotController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {

    // Role Controller
    Route::put('role-archived/{id}', [RoleController::class, 'archived']);
    Route::resource("role", RoleController::class);

    // User Controller
    Route::put('user-archived/{id}', [UserController::class, 'archived']);
    Route::resource("user", UserController::class);

    // Cemeteries Controller
    Route::put('cemeteries-archived/{id}', [CemeteriesController::class, 'archived']);
    Route::post("cemeteries", [CemeteriesController::class, 'store']);
    Route::patch("cemeteries/{id}", [CemeteriesController::class, 'update']);

    // Lot Controller
    Route::put('lot-archived/{id}', [LotController::class, 'archived']);
    Route::post("lot", [LotController::class, 'store']);
    Route::patch("lot/{id}", [LotController::class, 'update']);


    // auth controller
    Route::patch('changepassword', [AuthController::class, 'changedPassword']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::patch('resetpassword/{id}', [AuthController::class, 'resetPassword']);
});
