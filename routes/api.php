<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Booking\CancelBookingAction;
use App\Http\Controllers\Booking\CreateBookingAction;
use App\Http\Controllers\Booking\FindByRoomAction;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login_check', ApiAuthController::class);

Route::prefix('booking')->middleware('auth:sanctum')->group(function () {
    Route::get('/{room}', FindByRoomAction::class)->name('bookingByRoom');
    Route::post('', CreateBookingAction::class)->name('createBooking');
    Route::patch('/{reservation}', CancelBookingAction::class)->name('cancelBooking');
});
