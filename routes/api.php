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

// Profiles API
Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/profiles/archived', [ProfileController::class, 'archived']);
Route::post('/profiles', [ProfileController::class, 'store']);
Route::put('/profiles/{profile}', [ProfileController::class, 'update']);
Route::delete('/profiles/{profile}', [ProfileController::class, 'destroy']);
Route::post('/profiles/{profile}/archive', [ProfileController::class, 'archive']);
Route::post('/profiles/{profile}/unarchive', [ProfileController::class, 'unarchive']);
