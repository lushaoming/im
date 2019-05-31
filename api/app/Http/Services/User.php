<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/29
 * Time: 10:12
 */
namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class User
{
    public static $table = 'bas_user';

    /**
     * @param $username
     * @param $password
     * @param $nickname
     * @param $gender
     * @param string $halfname
     * @return mixed
     */
    public static function userRegister($username, $password, $nickname, $gender, $halfname = '')
    {
        $data = [
            'username' => $username,
            'password' => md5($password),
            'nickname' => $nickname,
            'gender' => $gender,
            'the_half' => $halfname,
            'create_time' => date('Y-m-d H:i:s')
        ];
        return DB::table(self::$table)->insertGetId($data);
    }

    public static function checkUsername($username)
    {
        if (mb_strlen($username) < 4 || mb_strlen($username) > 10) return false;
        if (!preg_match('/^[a-z]{1}[a-z0-9]{3,9}$/', $username)) return false;
        return true;
    }

    public static function checkPassword($password)
    {
        if (mb_strlen($password) < 6 || mb_strlen($password) > 12) return false;
        return true;
    }

    public static function getUserInfoByUsername($username)
    {
        return DB::table(self::$table)->where('username', $username)->where('status', 1)->first();
    }
}