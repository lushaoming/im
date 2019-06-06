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
Route::any('test', 'TestController@index');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', 'NoAuthController@register');
Route::get('/create-random-name', 'NoAuthController@createRandomName');

Route::post('/upload/image', 'UploadController@image');
Route::get('/image/check/{path}', 'NoAuthController@checkImageExist');
Route::get('/image/{path}', 'NoAuthController@getImage');

Route::post('/sms/send', 'NoAuthController@sendSMS');

// 人脸检测-图片上传
Route::any('/baiduapi/face-recognition', 'BaiduCloudController@faceRecognition');
// 人脸检测-图片base64
Route::any('/baiduapi/face-recognition-base64', 'BaiduCloudController@faceRecognitionBase64');
// 轮播图
Route::get('/get-carousel', 'NoAuthController@getCarousel');

Route::get('/article/{id}', 'ArticleController@index');