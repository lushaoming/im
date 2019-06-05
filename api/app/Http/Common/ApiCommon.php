<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/28
 * Time: 17:41
 */

namespace App\Http\Common;

use Illuminate\Http\Request;

class ApiCommon
{
    public static function ajaxReturn($code = 200, $data = [], $msg = 'OK')
    {
        echo json_encode(['code' => $code, 'msg' => $msg, 'data' => $data]);exit;
    }

    public static function get_var($key)
    {
        return \request()->input($key, '');
    }

    /**
     * @param $key
     * @param string $msg
     * @param bool $isAllowZero 是否允许0，默认是
     * @return array|string
     */
    public static function get_not_empty_var($key, $msg = '', $isAllowZero = true)
    {
        $value = \request()->input($key, '');
        $msg = $msg ? $msg : "参数{$key}不能为空";
        if ($isAllowZero) {
            if (empty($value) && $value !== '0') {
                ApiCommon::ajaxReturn(501, [], $msg);
            }
        } else {
            if (empty($value)) {
                ApiCommon::ajaxReturn(501, [], $msg);
            }
        }
        return $value;
    }

    public static function httpCurl($url, $isPost = false, $postParam = [], $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($isPost === true) {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postParam);
        }

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}