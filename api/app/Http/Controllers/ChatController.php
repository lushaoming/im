<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/20
 * Time: 9:23
 */
namespace App\Http\Controllers;

use App\Http\Common\Gateway;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function message(Request $request)
    {

    }

    /**
     * 绑定用户
     * @param Request $request
     */
    public function bind(Request $request)
    {
        $username = $_POST['username'];
        $clientId = $_POST['client_id'];
        $gateway = new Gateway();
        $gateway->bindUid($clientId ,$username);
        return 1;
    }

    public function checkUserIsOnline(Request $request)
    {
        $username = $_POST['username'];
        $gateway = new Gateway();
        $isOnline = $gateway->isUidOnline($username);
        if ($isOnline) return 1;
        return 0;
    }

    public function login(Request $request)
    {
        return json_encode(['code' => 200, 'data' => ['user_id' => 'asd546d4sf', 'username' => 'lushao', 'nickname' => '卢绍明']]);
    }
}