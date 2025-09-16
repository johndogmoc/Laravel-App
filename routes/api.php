<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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

// Profile endpoints
Route::post('/submit', [ProfileController::class, 'store']);
Route::get('/profilelist', [ProfileController::class, 'display']);
Route::put('/profile/{id}', [ProfileController::class, 'update']);
Route::delete('/profile/{id}', [ProfileController::class, 'destroy']);

// Fallback for unknown API routes
Route::fallback(function () {
    return response()->json(['message' => 'not found'], 404);
});
