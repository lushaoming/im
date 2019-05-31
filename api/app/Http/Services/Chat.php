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

    /**
     * 拉取未推送的聊天记录
     * @param $username
     * @param $halfname
     * @return mixed
     */
    public static function pullMessage($username, $halfname)
    {
        $sql = "SELECT * FROM  `bas_chat` WHERE `to_user`=? AND `from_user`=? AND is_pull=1";

        $list = DB::select($sql, [$username, $halfname]);
//        $list = DB::table('bas_chat')->where('from_user', $halfname)->where('to_user', $username)->where('is_pull', 1)->get();
        DB::table('bas_chat')->where('to_user', $username)->where('is_pull', 1)->update(['is_pull' => 2]);
        return $list;
    }

    public static function getUserInfo($username)
    {

    }

    public static function login($username, $password)
    {
        $password = md5($password.USER_PASSWORD_ENCRYPT_KEY);
        $user = DB::table('bas_user')->where('username', $username)->first();
        if (empty($user)) return false;
        if ($password != $user->password) return false;

        $user->the_half_name = '';
        // 查找另一半名字
        if ($user->the_half) {
            $halfNickname = DB::table('bas_user')->where('username', $user->the_half)->value('nickname');
            if ($halfNickname) $user->the_half_name = $halfNickname;
        }
        return $user;
    }

    /**
     * 获取用户的所有记录
     * @param string $username 用户名称
     * @param string $halfname 对方名称
     * @return mixed
     */
    public static function getUserAllMsg($username, $halfname)
    {
        $sql = "SELECT * FROM  `bas_chat` WHERE (`from_user`=? AND `to_user`=?) OR (`to_user`=? AND `from_user`=?)";
        return DB::select($sql, [$username, $halfname, $username, $halfname]);
    }
}