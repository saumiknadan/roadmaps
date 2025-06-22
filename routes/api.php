<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;

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
    dd(Auth::user());
    return $request->user();
});

// Authentication
Route::post('register', [RegisterController::class, 'store'])->name('api.register');
Route::post('login', [LoginController::class, 'store'])->name('api.login');
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth:sanctum')->name('api.logout');

