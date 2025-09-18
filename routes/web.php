<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Dedicated page to display the Names List
Route::get('/Lists', function () {
    return view('lists');
});

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
