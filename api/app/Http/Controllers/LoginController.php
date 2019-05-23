<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/22
 * Time: 15:30
 */
namespace App\Http\Controllers;

use App\Http\Common\Token;
use App\Http\Services\Chat;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $res = Chat::login($username, $password);
        if ($res === false) return json_encode(['code' => 400]);
        $data = ['user_id' => $res->id,
            'username' => $res->username,
            'nickname' =>  $res->nickname,
            'the_half' =>  $res->the_half,
            'the_half_name' =>  $res->the_half_name,
            'gender' => $res->gender,
        ];
        $token = Token::create($data, 30 * 86400);
        $data['token'] = $token;
        return json_encode(['code' => 200, 'data' => $data]);
    }
}