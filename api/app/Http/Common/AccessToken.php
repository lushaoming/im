<?php
/**
 * Desc:
 * User: Ming
 * Date: 2019/1/18
 * Time: 6:18 PM
 */

namespace App\Http\Common;
use App\Http\Services\ApiCore;

class AccessToken
{
    private $app_id = 'wx1e19cdd018a18f62';
    private $app_secret = '9e1eb529860207253d53749bf840d0ff';
    private $file_path = '../../.access_token.json';

    public function getToken()
    {
        $data = file_get_contents($this->file_path);
        if ($data && $data['expire_time'] > time() + 600) {// token还有10分钟以上才过期，就继续使用
            return $data['access_token'];
        }
        return $this->create_token();
    }

    public function create_token()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->app_id}&secret={$this->app_secret}";
        $res = $this->curl_get($url);
        $res = json_decode($res, true);
        if (!empty($res['errcode'])) {
            echo $res['errmsg'];exit;
        }
        $res['expire_time'] = time() + 7200;
        file_put_contents($this->file_path, json_encode($res));
        return $res['access_token'];
    }

    public function curl_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new Exception("curl出错，错误码:$error");
        }
    }
}