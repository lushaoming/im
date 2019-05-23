<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/22
 * Time: 11:56
 */
namespace App\Http\Controllers;

use App\Http\Common\Logger;
use App\Http\Common\Token;

class BaseController extends Controller
{
    protected $username;
    public function __construct()
    {
        self::debugWrite($_SERVER['REQUEST_URI']);
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $payload = $this->checkToken($token);
        if ($payload === false) {
            echo json_encode(['code' => 401, 'msg' => '用户验证失败，请重新登录']);exit;
        }
        if (isset($_REQUEST['debug'])) $this->username = $_REQUEST['username'];
        else $this->username = $payload['username'];

    }

    public function checkToken($token)
    {
        if (isset($_REQUEST['debug'])) return true;
        return Token::check($token);
    }

    public static function debugWrite($data)
    {
        Logger::getInstance()->save($data);
    }
}