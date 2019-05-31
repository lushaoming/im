<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/30
 * Time: 11:06
 */
namespace App\Http\Services;

class Image
{
    public static function getFullPath($path)
    {
        return UPLOAD_FILE_PATH . '/' . $path;
    }

    public static function getImage($path, $quality = 100)
    {
        $info = getimagesize($path);
        $imgExt = image_type_to_extension($info[2], false);
        $fun = "imagecreatefrom{$imgExt}";
        $imgInfo = $fun($path);
        $mine = image_type_to_mime_type(exif_imagetype($path));
        header('Content-Type:'.$mine);
        $getImageInfo = "image{$imgExt}";
        if ($imgExt == 'png') $quality = 9;
        $getImageInfo($imgInfo, null, $quality);
        imagedestroy($imgInfo);
    }

    public static function delete($path)
    {
        @unlink($path);
    }
}