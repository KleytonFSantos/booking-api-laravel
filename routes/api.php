<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Booking\CreateBookingAction;
use App\Http\Controllers\Booking\FindByRoomAction;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    try {
        return $request->user();
    } catch (Exception $e) {
        dd($e);
    }
});

Route::post('/login', ApiAuthController::class);

Route::prefix('booking')->group(function () {
    Route::get('/{room}', FindByRoomAction::class)->name('bookingByRoom');
    Route::post('', CreateBookingAction::class)->name('createBooking');
});
