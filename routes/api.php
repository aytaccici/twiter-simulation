<?php

use Illuminate\Http\Request;


Route::post('/v1/auth/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login'])->name('auth.login');
Route::post('/v1/auth/register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register'])->name('auth.register');
Route::post('/v1/auth/verify', [\App\Http\Controllers\Api\Auth\AuthController::class, 'verify'])->name('auth.validate');


//Api Check Middleware Guard

Route::middleware('api.check')->group(function () {

    //User Bilgilerini Goruntuler
    Route::get('v1/auth/me', [\App\Http\Controllers\Api\Auth\AuthController::class, 'me'])->name('auth.me');

    Route::post('v1/tweets/fetch', [\App\Http\Controllers\Api\Tweet\TweetController::class, 'fetchMyTweets'])->name('tweet.move');

    Route::get('v1/tweets', [\App\Http\Controllers\Api\Tweet\TweetController::class, 'index'])->name('tweet.index');
    Route::get('v1/tweets/me', [\App\Http\Controllers\Api\Tweet\TweetController::class, 'me'])->name('tweet.me');
    Route::get('v1/tweets/{userName}', [\App\Http\Controllers\Api\Tweet\TweetController::class, 'getUserTweetsByName'])->name('tweet.username');
    Route::put('v1/tweets/{id}', [\App\Http\Controllers\Api\Tweet\TweetController::class, 'publish'])->name('tweet.publish');


});
