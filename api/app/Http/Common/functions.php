<?php
/**
 * Desc: 公共方法，可在框架任何地方直接使用
 * Auth: Shaoming Lu<lushao1012@163.com>
 * Date: 2018/9/27
 * Time: 15:57
 */

function p($var)
{
    echo '<pre>';
    var_dump($var);exit;
}

function getUserId()
{
    echo 1;
}

function pwd_md5($pwd)
{
    $key = 'lushaoming5201314';
    return md5($pwd . $key);
}

// md5加密用户ID
function md5_user_id()
{
    $key = 'ijaoidjhOIHIU98UHUITijOIIUuiohUIHiuh';
    return md5($key . time() . mt_rand(1000, 9999));

}

// 根据php语句高亮显示代码
function highlight($str)
{
    return highlight_string($str);
}

// 返回单词的个数
function count_word($str)
{
    return str_word_count($str);
}

// 由$str1转换成$str2所需的最少编辑操作次数
function min_edit_number($str1, $str2)
{
    return  levenshtein($str1, $str2);
}

// 返回一个多维数组，里面包含了所有定义过的变量
function get_all_defined_vars()
{
    return get_defined_vars();
}

/**
 * 把字符串按照 PHP 代码来计算，该字符串必须是合法的 PHP 代码，且必须以分号结尾
 * 该函数对于在数据库文本字段中供日后计算而进行的代码存储很有用
 * @param string $string 原始包含变量名的字符串，如：'Hello, {$name}'
 * @param array $param   参数，应该与$string中的变量保持一致，如： ['name' => '小明']
 * @return mixed 返回解析了变量的字符串
 */
function eval_string($string, $param)
{
    extract($param);
    eval("\$string = \"$string\";");
    return $string;
}

/**
 * 处理时间格式
 * @param integer $time   时间戳
 * @param string  $format 时间格式
 * @return false|string
 */
function deal_time_format($time, $format = 'Y-m-d H:i:s')
{
    return date($format, $time);
}

function deal_tree_data($data, $key)
{

}

/**
 * 获取一个随机字符串
 * @param int $length 字符串长度
 * @return string
 */
function create_nonce($length = 16)
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $return_str = '';
    for ($i = 0; $i < $length; $i ++) {
        $rant = mt_rand(0, mb_strlen($str) - 1);
        $return_str .= mb_substr($str, $rant, 1);
    }
    return $return_str;
}

/**
 * 隐藏邮箱账号
 * @param string $email 原始邮箱
 * @return bool|string
 */
function hide_email($email = '')
{
    $data = explode('@', $email);
    if (count($data) != 2) return false;
    if (mb_strlen($data[0]) > 3) {
        $data[0] = mb_substr($data[0], 0, 3) . '*****';
    }
    return $data[0] . $data[1];
}

/**
 * url参数转化成数组，value部分会url解码
 * @auth xieyang
 * @date 2018年5月10日 13:51:23
 * @param string
 * @return mixed
 */
function convert_url_array($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = urldecode($item[1]);
    }
    return $params;
}

/**
 * 数组转url格式
 * @param  [type] $array [description]
 * @return [type]        [description]
 */
function convert_array_url($array)
{
    return http_build_query($array);
}

function is_mobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

/**
 * curl操作
 * @param string $url    地址
 * @param bool   $isPost 是否post
 * @param array  $params post参数
 * @return bool|string
 */
function curl($url, $isPost = false, $params = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    if ($isPost === true) {
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    }

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

/**
 * @param $data
 * @param int $expire
 * @return string
 */
function create_csrf_token($data = [], $expire = 600)
{
    $now = time();
    $payload = [
        'header' => 'token',
        'time' => $now,
        'expire' => $expire,
        'data' => $data
    ];
    $arg = base64_encode(json_encode($payload));
    $token = $arg . '.' . md5($arg . CSRF_KEY);
    return $token;
}

function check_csrf_token($token)
{
    $args = explode('.', $token);
    if (count($args) != 2) return false;
    $payload = json_decode(base64_decode($args[0]), true);
    if (empty($payload)) return false;
    if (!isset($payload['time']) || $payload['time'] > time() || $payload['time'] < time() - $payload['expire']) return false;
    if ($args[1] != md5($args[0] . CSRF_KEY)) return false;
    return $payload['data'];
}

/**
 * 验证用户名，格式：英文大小写或数字
 * @param $username
 * @return false|int
 */
function check_username($username)
{
    $flag = '/^[A-Za-z0-9]{6,12}$/';
    return preg_match($flag, $username);
}

function check_password($password)
{
    if (strlen($password) < 6 || strlen($password) > 16) return false;
    return true;
}

function check_real_name($real_name)
{
    if (strlen($real_name) < 2 || strlen($real_name) > 16) return false;
    return true;
}

function hide_mobile($mobile)
{
    return substr($mobile, 0, 3) . '****' . substr($mobile, 7, 4);
}
