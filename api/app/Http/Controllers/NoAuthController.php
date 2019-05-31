<?php
/**
 * 此类无需校验token
 * User: Shannon
 * Date: 2019/5/28
 * Time: 17:35
 */
namespace App\Http\Controllers;

use App\Http\Common\ApiCommon;
use App\Http\Common\Logger;
use App\Http\Common\RedisWriter;
use App\Http\Services\Image;
use App\Http\Services\RandName;
use App\Http\Common\SMS;
use App\Http\Services\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoAuthController extends Controller
{
    /**
     * 生成随机名字
     * @param Request $request
     */
    public function createRandomName(Request $request)
    {
        $name = RandName::createRandomName();
        ApiCommon::ajaxReturn(OK_CODE, $name);
    }

    public function register(Request $request)
    {
        $username = ApiCommon::get_not_empty_var('username');
        $password = ApiCommon::get_not_empty_var('password');
        $nickname = ApiCommon::get_not_empty_var('nickname');
        $gender = ApiCommon::get_not_empty_var('gender');
        $halfname = ApiCommon::get_var('halfname');

        if (!User::checkUsername($username)) ApiCommon::ajaxReturn(ERR_CODE, [], '账号格式为4-10位小写字母或数字（字母开头）');
        if (!User::checkPassword($password)) ApiCommon::ajaxReturn(ERR_CODE, [], '密码为6-12位');

        $userInfo = User::getUserInfoByUsername($username);
        if ($userInfo) ApiCommon::ajaxReturn(ERR_CODE, [], '你输入的账号已被注册');
        if ($halfname) {
            $halfInfo = User::getUserInfoByUsername($halfname);
            if (!$halfInfo) ApiCommon::ajaxReturn(ERR_CODE, [], '对方账号不存在');
            if ($halfInfo->gender == $gender) ApiCommon::ajaxReturn(ERR_CODE, [], '对方的性别跟你一样哦，请更换性别');
        }

        $userId = User::userRegister($username, $password, $nickname, $gender, $halfname);
        ApiCommon::ajaxReturn();
    }

    /**
     * 获取系统设置
     */
    public function getSystemConfig()
    {
        $list = DB::table('bas_sys_config')->get();
        ApiCommon::ajaxReturn(OK_CODE, $list);
    }

    /**
     * 检查图片是否存在
     * @param Request $request
     */
    public function checkImageExist(Request $request)
    {
        $imagePath = $request->route('path');
        $imagePath = base64_decode($imagePath);
        $imageFullPath = Image::getFullPath($imagePath);
        if (!file_exists($imageFullPath)) {
            ApiCommon::ajaxReturn(400, [], '图片已删除');
        }
        ApiCommon::ajaxReturn();
    }

    /**
     * 读取图片，防止通过链接直接读取
     * @param Request $request
     */
    public function getImage(Request $request)
    {
        $imagePath = $request->route('path');
        $imagePath = base64_decode($imagePath);
        $imageFullPath = Image::getFullPath($imagePath);
        if (!file_exists($imageFullPath)) {
            ApiCommon::ajaxReturn(400, [], '图片已删除');
        }
        Image::getImage($imageFullPath, 100);
//        Image::delete($imageFullPath);
    }

    public function sendSMS()
    {
        $mobile = ApiCommon::get_not_empty_var('mobile', '手机号码不能为空');
        $cacheKey = SMS::getCacheKey($mobile);

        $timeLeft = SMS::canSend($mobile);
        if (IS_LIVE) {
            if ($timeLeft > 0)ApiCommon::ajaxReturn(400, [], '为了防止资源浪费，执行短信发送限制，请在' . $timeLeft . '秒后重试');
        }

        $code = SMS::createCode();
        $ttl = 1800;
        RedisWriter::getIntance()->write($cacheKey, $code, $ttl);
        $result = Sms::send($mobile, $code, $ttl, IS_LIVE ? false : true);

        if ($result === true) {
            $msg = '短信发送成功';
            $now = time();
            $ret = ['time' => $now, 'time_limit' => SMS_SEND_TIME_LIMIT];
            if (!IS_LIVE) $msg = "短信发送成功，验证码为：{$code}（测试环境不真实发送短信且没有发送频率限制，如有倒计时，可刷新后再试）";
            // 设置发送时间缓存，用于限制发送频率
            RedisWriter::getIntance()->write(SMS::getSmsLimitCacheKey($mobile), $now, SMS_SEND_TIME_LIMIT);
            ApiCommon::ajaxReturn(200, $ret, $msg);
        } else {
            ApiCommon::ajaxReturn(400, [], '短信发送失败');
        }
    }

}