<?php

use App\Http\Controllers\KarirController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UserController::class, 'index'])->name('login');
    Route::post('login', [UserController::class, 'customLogin'])->name('login.post');
    Route::get('register', [UserController::class, 'register'])->name('register');
    Route::post('register', [UserController::class, 'customRegistration'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('signout', [UserController::class, 'logout'])->name('logout');

});
