<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/8
 * Time: 18:38
 */
namespace App\Http\Common;

class SMS
{
    const VERIFY_CODE_CACHE_KEY = 'sms_verify_';
    const SMS_TIME_LIMIT = 'sms_time_limit_';
    const TOKEN_KEY = 'BD8I7nRndnbrV2QFTN6ZA8a5oQ8poO1M';

    public static function createCode($length = 6)
    {
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= mt_rand(0, 9);
        }
        return $code;
    }

    /**
     * 获取缓存key值
     * @param $mobile
     * @return string
     */
    public static function getCacheKey($mobile)
    {
        return self::VERIFY_CODE_CACHE_KEY . $mobile;
    }

    public static function getSmsLimitCacheKey($mobile)
    {
        return self::SMS_TIME_LIMIT . $mobile;
    }

    /**
     * 发送短信验证码
     * @param int $mobile 手机号码
     * @param int $code 验证码
     * @param int $ttl 有效期（秒）
     * @param bool $debug
     * @return bool
     */
    public static function send($mobile, $code, $ttl, $debug = false)
    {
        $now = time();
        $token = md5($now . self::TOKEN_KEY);
        $param = [
            'number' => $mobile,
            'code' => $code,
            'ttl' => $ttl,
            'time' => $now,
            'token' => $token,
        ];
        if ($debug) $param['debug'] = $debug;
        $url = SMS_DOMAIN . '/src/SMS.php';
        $res = curl($url, true, $param);
        $data = json_decode($res, true);
        if ($data['code'] == 200) return true;
        else return false;
    }

    /**
     * 校验验证码
     * @param int $mobile 手机号码
     * @param int $code   验证码
     * @return bool
     */
    public static function check($mobile, $code)
    {
        $cacheKey = Sms::getCacheKey($mobile);
        $sysCode = RedisWriter::getIntance()->read($cacheKey);
        if (empty($sysCode) || $sysCode != $code) return false;
        // 校验成功后删除缓存
        RedisWriter::getIntance()->delete($cacheKey);
        return true;
    }

    /**
     * 检查手机号码是否可以发送短信
     * @param $mobile
     * @return bool
     */
    public static function canSend($mobile)
    {
        $cacheKey = Sms::getSmsLimitCacheKey($mobile);
        $time = RedisWriter::getIntance()->read($cacheKey);
        $timeLeft = $time + SMS_SEND_TIME_LIMIT - time();
        if (empty($time) || $timeLeft <= 0) return 0;
        return $timeLeft;
    }
}