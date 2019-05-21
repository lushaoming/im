<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/21
 * Time: 15:14
 */
namespace App\Http\Common;

class WebSocket
{
    public static function userIsOnline($username)
    {
        $gateway = new Gateway();
        $isOnline = $gateway->isUidOnline($username);
        if ($isOnline) return true;
        return false;
    }
}