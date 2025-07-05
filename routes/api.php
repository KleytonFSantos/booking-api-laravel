<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\ApiRegisteredUserController;
use App\Http\Controllers\Booking\CancelBookingAction;
use App\Http\Controllers\Booking\CreateBookingAction;
use App\Http\Controllers\Booking\FindByRoomAction;
use App\Http\Controllers\Booking\FinishBookingAction;
use App\Http\Controllers\Booking\ListReservationAction;
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
Route::post('/register', ApiRegisteredUserController::class);

Route::prefix('booking')->middleware('auth:sanctum')->group(function () {
    Route::get('/', ListReservationAction::class)->name('bookingList');
    Route::get('/{room}', FindByRoomAction::class)->name('bookingByRoom');
    Route::post('', CreateBookingAction::class)->name('createBooking');
    Route::patch('/{reservation}/finish', FinishBookingAction::class)->name('finishBooking');
    Route::patch('/{reservation}', CancelBookingAction::class)->name('cancelBooking');
});
