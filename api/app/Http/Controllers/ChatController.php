<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/20
 * Time: 9:23
 */
namespace App\Http\Controllers;

use App\Http\Common\Gateway;
use App\Http\Common\Token;
use App\Http\Common\WebSocket;
use App\Http\Services\Chat;
use Illuminate\Http\Request;
use App\Http\Common\Message;

class ChatController extends BaseController
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

    public function getUserInfo(Request $request)
    {

    }



    public function sendMsg(Request $request)
    {
        $msgId = $request->input("msg_id");
        $fromUser = $request->input('username');
        $toUser = $request->input('to_user');
        $msgType = $request->input('msg_type');
        $msg = $request->input('msg');
        $fromName = $request->input('from_name');
        $toName = $request->input('to_name');
        $now = date('Y-m-d H:i:s');
        $msgData = [
            'msg_id' => $msgId,
            'msg_type' => $msgType,
            'from_user' => $fromUser,
            'from_name' => $fromName,
            'to_user' => $toUser,
            'to_name' => $toName,
            'msg' => $msg,
            'send_time' => $now,
        ];
        // 用户在线，发送消息
        if (WebSocket::userIsOnline($toUser)) {
            $clientId = Message::getInstance()->getClientIdByUid($toUser)[0];
            Message::getInstance()->sendMessageToClient('chat', $clientId, $msgData);
            $msgData['is_pull'] = 2;
        } else {
            $msgData['is_pull'] = 1;
        }

        if ($id = Chat::saveChatLog($msgData)) {
            return json_encode(['code' => 200, 'id' => $id, 'msg_id' => $msgId, 'is_pull' => $msgData['is_pull']]);
        } else {
            return json_encode(['code' => 400]);
        }

    }

    public function pullMsg(Request $request)
    {
        $halfname = $request->input('halfname');
        $list = Chat::pullMessage($this->username, $halfname);
        return json_encode(['code' => 200, 'list' => $list, 'count' => count($list)]);
    }

    public function getAllChatMsg(Request $request)
    {
        $username = $request->input('username');
        $halfname = $request->input('halfname');
        $list = Chat::getUserAllMsg($username, $halfname);
        return json_encode(['code' => 200, 'data' => $list, 'count' => count($list)]);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function checkConnection(Request $request)
    {
        $username = $request->input('username');
        if (WebSocket::userIsOnline($username)) return json_encode(['code' => 0]);
        else return json_encode(['code' => 1]);
    }



}