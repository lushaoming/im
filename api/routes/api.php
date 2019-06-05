<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', 'NoAuthController@register');
Route::get('/create-random-name', 'NoAuthController@createRandomName');

Route::post('/upload/image', 'UploadController@image');
Route::get('/image/check/{path}', 'NoAuthController@checkImageExist');
Route::get('/image/{path}', 'NoAuthController@getImage');

Route::post('/sms/send', 'NoAuthController@sendSMS');


Route::get('/baiduapi/face-recognition', 'BaiduCloudController@faceRecognition');
// 轮播图
Route::get('/get-carousel', 'NoAuthController@getCarousel');