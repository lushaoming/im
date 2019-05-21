<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/20
 * Time: 9:23
 */
namespace App\Http\Controllers;

use App\Http\Common\Gateway;
use App\Http\Common\WebSocket;
use App\Http\Services\Chat;
use Illuminate\Http\Request;
use App\Http\Common\Message;

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
        $username = $_REQUEST['username'];
        $clientId = $_REQUEST['client_id'];
        $gateway = new Gateway();
        $gateway->bindUid($clientId ,$username);
        return 1;
    }



    public function sendMsg(Request $request)
    {
        $fromUser = $_REQUEST['from_user'];
        $toUser = $_REQUEST['to_user'];
        $msgType = $_REQUEST['msg_type'];
        $msg = $_REQUEST['msg'];
        $msgId = Chat::createMsgId();
        $now = date('Y-m-d H:i:s');
        $msgData = [
            'msg_id' => $msgId,
            'msg_type' => $msgType,
            'from_user' => $fromUser,
            'to_user' => $toUser,
            'msg' => $msg,
            'send_time' => $now,
        ];
//        var_dump(Message::getInstance()->getClientIdByUid($toUser));exit;
        // 用户在线，发送消息
        if (WebSocket::userIsOnline($toUser)) {
            $clientId = Message::getInstance()->getClientIdByUid($toUser)[0];
            Message::getInstance()->sendMessageToClient('chat', $clientId, $msgData);
            $msgData['is_pull'] = 2;
        }
        $msgData['create_time'] = $now;
        if (Chat::saveChatLog($msgData)) {
            return json_encode(['code' => 200]);
        } else {
            return json_encode(['code' => 400]);
        }

    }

    public function login(Request $request)
    {
        return json_encode(['code' => 200, 'data' => ['user_id' => 'asd546d4sf', 'username' => 'lushao', 'nickname' => '卢绍明']]);
    }
}