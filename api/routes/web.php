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

Route::get('/', 'AppController@publish');

Route::get('debug', function () {
    return view('debug.index');
});

Route::any('chat/bind', 'ChatController@bind');
Route::any('chat/login', 'LoginController@login');

Route::any('chat/send-msg', 'ChatController@sendMsg');
Route::any('chat/pull-msg', 'ChatController@pullMsg');
Route::any('chat/get-all-chat-msg', 'ChatController@getAllChatMsg');
Route::any('chat/check-websocket-connection', 'ChatController@checkConnection');

Route::any('app/check-version', 'AppController@checkVersion');

Route::any('love', 'LoveController@index');