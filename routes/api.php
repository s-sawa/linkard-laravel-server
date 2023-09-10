<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile/me', [ProfileController::class, 'show'])->name('profile.me');
    Route::post('/profile/me', [ProfileController::class, 'store'])->name('profile.me');
    Route::post('/logout', LogoutController::class)->name('logout');
    
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});