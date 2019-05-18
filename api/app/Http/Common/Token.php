<?php
/**
 * 简单的token
 * User: Shannon
 * Date: 2019/4/20
 * Time: 16:53
 */
namespace App\Http\Common;

class Token
{
    private static $key = '3qV6b3Au1WVtSx5s07JkEllGL5SWwNMY';

    /**
     * @param $data
     * @param int $expire
     * @return string
     */
    public static function create($data = [], $expire = 600)
    {
        $now = time();
        $payload = [
            'header' => 'token',
            'time' => $now,
            'expire' => $expire,
            'data' => $data
        ];
        $arg = base64_encode(json_encode($payload));
        $token = $arg . '.' . md5($arg . self::$key);
        return $token;
    }

    public static function check($token)
    {
        $args = explode('.', $token);
        if (count($args) != 2) return false;
        $payload = json_decode(base64_decode($args[0]), true);
        if (empty($payload)) return false;
        if (!isset($payload['time']) || $payload['time'] > time() || $payload['time'] < time() - $payload['expire']) return false;
        if ($args[1] != md5($args[0] . self::$key)) return false;
        return $payload['data'];
    }
}