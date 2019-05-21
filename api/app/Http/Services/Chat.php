<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/21
 * Time: 15:10
 */
namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class Chat
{
    /**
     * 创建消息ID
     * @return string
     */
    public static function createMsgId()
    {
        return md5(time() . create_nonce(8));
    }

    /**
     * 保存聊天记录
     * @param $data
     * @return mixed
     */
    public static function saveChatLog($data)
    {
        return DB::table('bas_chat')->insertGetId($data);
    }
}