<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CemeteriesController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\DeceasedController;
use App\Http\Controllers\Api\LotController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TermsAndAgreementController;
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
Route::get("reservation", [ReservationController::class, 'index']);
Route::get("deceased", [DeceasedController::class, 'index']);
Route::get("terms", [TermsAndAgreementController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
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
    // Route::match(['POST', 'PATCH'], "lot/{id}", [LotController::class, 'update']);

    // Reservation Controller
    Route::put('reservation-archived/{id}', [ReservationController::class, 'archived']);
    Route::post("reservation", [ReservationController::class, 'store']);
    Route::patch("reservation-cancel/{id}", [ReservationController::class, 'cancel']);
    Route::get("reservation-sales", [ReservationController::class, 'reservation_sales']);
    Route::get("reservation-status-counts", [ReservationController::class, 'total_number_of_reservation_this_month']);
    Route::patch("reservation-approve/{id}", [ReservationController::class, 'approve']);
    Route::patch("reservation-reject/{id}", [ReservationController::class, 'reject']);
    Route::match(['POST', 'PATCH'], 'deceased/{id}', [DeceasedController::class, 'update']);

    // Deceased Controller
    Route::put('deceased-archived/{id}', [DeceasedController::class, 'archived']);
    Route::post("deceased", [DeceasedController::class, 'store']);
    Route::patch("deceased/{id}", [DeceasedController::class, 'update']);

    // Terms and agreement Controller
    Route::put('terms-archived/{id}', [TermsAndAgreementController::class, 'archived']);
    Route::post("terms", [TermsAndAgreementController::class, 'store']);
    Route::patch("terms/{id}", [TermsAndAgreementController::class, 'update']);

    // auth controller
    Route::patch('changepassword', [AuthController::class, 'changedPassword']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::patch('resetpassword/{id}', [AuthController::class, 'resetPassword']);

    Route::get('/conversations', [ChatController::class, 'conversations']);
    Route::get('/conversations/{id}/messages', [ChatController::class, 'messages']);
    Route::post('/messages/send', [ChatController::class, 'send']);
    Route::post('/conversations/start', [ChatController::class, 'startPrivateChat']);
});
