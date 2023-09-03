<?php

use App\Http\Controllers\Auth\ApiAuthController;
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
