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
    return view('app.download');
});

Route::get('debug', function () {
    return view('debug.index');
});

Route::any('chat/bind', 'ChatController@bind');
Route::any('chat/login', 'ChatController@login');

Route::any('chat/send-msg', 'ChatController@sendMsg');