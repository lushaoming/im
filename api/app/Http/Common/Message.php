<?php
/**
 * 向客户端发送即时消息
 * User: Shannon
 * Date: 2019/1/30
 * Time: 10:16
 */
namespace App\Http\Common;

use App\Http\Common\Gateway;

class Message
{
    private static $instance = null;
    private static $gatewayInstance = null;

    // 禁止被实例化
    private function __construct()
    {
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Message();
        }
        if (is_null(self::$gatewayInstance)) {
            self::$gatewayInstance = new Gateway();
        }
        return self::$instance;
    }

    /**
     * 发送消息到客户端
     * @param string $type 消息类型
     * @param string $client_id 客户端ID
     * @param mixed $message 消息内容
     * @param array  $other 其他信息
     */
    public function sendMessageToClient($type, $client_id, $message, $other = [])
    {
        $data = [
            'type' => $type,
            'msg' => $message,
            'other' => $other,
            'timestamp' => time(),
        ];
        self::$gatewayInstance->sendToClient($client_id, json_encode($data));
    }

    public function getClientIdByUid($uid)
    {
        return self::$gatewayInstance->getClientIdByUid($uid);
    }
}