<?php

use Illuminate\Http\Request;


Route::post('/v1/auth/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login'])->name('auth.login');
Route::post('/v1/auth/register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register'])->name('auth.register');
Route::post('/v1/auth/verify', [\App\Http\Controllers\Api\Auth\AuthController::class, 'verify'])->name('auth.validate');


//Api Check Middleware Guard

Route::middleware('api.check')->group(function () {
    Route::get('v1/auth/me', [\App\Http\Controllers\Api\Auth\AuthController::class, 'me'])->name('auth.me');



});
