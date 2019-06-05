<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/6/4
 * Time: 11:52
 */
namespace App\Http\Controllers;

use App\Http\Common\ApiCommon;
use App\Http\Services\BaiduCloud;
use App\Http\Services\Image;

class BaiduCloudController extends Controller
{
    public function faceRecognition()
    {
        $pathBase64 = ApiCommon::get_not_empty_var('path_base64', '图片为空');
        $imagePath = base64_decode($pathBase64);
        $imageFullPath = Image::getFullPath($imagePath);
        if (!file_exists($imageFullPath)) {
            ApiCommon::ajaxReturn(400, [], '图片为空');
        }
        $username = ApiCommon::get_not_empty_var('username');
        $res = BaiduCloud::getInstance()->faceDetect($username, $imageFullPath);
        ApiCommon::ajaxReturn(200, $res);
    }
}