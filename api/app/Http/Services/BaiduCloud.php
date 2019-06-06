<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/6/4
 * Time: 11:53
 */
namespace App\Http\Services;

use App\Http\Common\ApiCommon;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\VarDumper\Dumper\esc;

class BaiduCloud
{
    private  $appId = 'kW6DdHOS3aR55p8bkwFosF8y';
    private  $secretKey = 'BLw2FPDAsG7rI7EQ3XOZnHsGwibEhG7g';
    private $apiDomain = 'https://aip.baidubce.com';
    private static $instance = null;
    public static $faceDetect = 1;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function getAccessToken()
    {
        $accessFile = ROOT_PATH . '/../access_token.json';

        $data = file_get_contents($accessFile);
        $data = json_decode($data, true);
        if (!empty($data) && $data['expires_time'] - 1800 > time() ) {
            return $data['access_token'];
        }

        $url = $this->apiDomain . "/oauth/2.0/token?grant_type=client_credentials&client_id={$this->appId}&client_secret={$this->secretKey}";
        $res = ApiCommon::httpCurl($url);
        $res = json_decode($res, true);
        $res['expires_time'] = time() + $res['expires_in'];
        file_put_contents($accessFile, json_encode($res));
        return $res['access_token'];
    }

    public function faceDetect($username, $path)
    {
        $imageData = file_get_contents($path);
        $imageBase64 = base64_encode($imageData);
        var_dump(mb_strlen($imageBase64));
        $url = $this->apiDomain . '/rest/2.0/face/v2/detect?access_token=' . $this->getAccessToken();
        $headers = ['Content-Type:application/x-www-form-urlencoded'];
        $params = ['image' => $imageBase64, 'max_face_num' => 1, 'face_fields' => 'age,beauty,expression,faceshape,gender,glasses,landmark,race,qualities'];
        $res = ApiCommon::httpCurl($url, true, $params, $headers);

        $this->saveLog($username, self::$faceDetect, $res);
        return json_decode($res, true);
    }

    public function faceDetectUseBase64($username, $base64)
    {
        $url = $this->apiDomain . '/rest/2.0/face/v2/detect?access_token=' . $this->getAccessToken();
        $headers = ['Content-Type:application/x-www-form-urlencoded'];
        $params = ['image' => $base64, 'max_face_num' => 1, 'face_fields' => 'age,beauty,expression,faceshape,gender,glasses,landmark,race,qualities'];
        $res = ApiCommon::httpCurl($url, true, $params, $headers);

        // 保存图片
        $basePath = ROOT_PATH . '/../storage/app/public/';
        $path = 'images/'.date('Y').'/'.date('m') . '/'.date('d') . '/';
        if (!file_exists($basePath.$path)) {
            mkdir($basePath.$path, 0777, true);
        }
        $filename = BaiduCloud::getInstance()->getImageName();
        file_put_contents($basePath.$path.$filename, base64_decode($base64));
        $imageId = Image::saveImage($path.$filename);

        $id = $this->saveLog($username, self::$faceDetect, $res, $imageId);
        $data = json_decode($res, true);
        $data['log_id'] = $id;
        return $data;
    }

    /**
     * 保存日志
     * @param string $username  用户名
     * @param int    $type      类型
     * @param string $data      数据
     * @return int 记录ID
     */
    public function saveLog($username, $type, $data, $imageId = null)
    {
        $code = create_nonce(6);
        $insertData = [
            'username' => $username,
            't_type' => $type,
            'data' => $data,
            'create_time' => date('Y-m-d H:i:s'),
            'image_id' => $imageId,
            'code' => $code
        ];
        DB::table('bas_baidu_api_log')->insert($insertData);
        return $code;
    }

    public function getImageName()
    {

        return time().create_nonce(4) . '.jpg';
    }
}