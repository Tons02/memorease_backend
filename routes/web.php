<?php

use App\Http\Controllers\Api\LotController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::get('/test-auth', function () {
    return auth()->user();
})->middleware('auth:sanctum');


Route::get('/videos/{folder}/{filename}', [LotController::class, 'streamVideo'])
    ->middleware(['throttle:60,1', 'stream.video'])
    ->where('folder', 'lot|cemeteries|messages');
