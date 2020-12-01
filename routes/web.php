<?php

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

Route::get('/', function () {


    $twitterMockApi=  new \App\Library\Twitter\TwitterMockApi(1);

    $adapter = new \App\Library\Twitter\TwitterAdapter($twitterMockApi);

    $tweets =  $adapter->getTweets();

    dd($tweets);


});

