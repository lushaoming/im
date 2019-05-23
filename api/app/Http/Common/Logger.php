<?php
/**
 * 日志
 * User: Shannon
 * Date: 2019/1/28
 * Time: 18:10
 */
namespace App\Http\Common;

class Logger
{
    private static $instance = null;
    // 日志保存路径
    private $path = ROOT_PATH . '/../storage/logs';

    // 禁止实例化
    private function __construct()
    {
    }

    // 禁止克隆
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    // 单例
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    public function save($data)
    {
        $path = $this->path . '/' . date('Ymd') . '.txt';

        // 数组进行json_decode操作
        if (is_array($data)) $data = json_encode($data);
        $data = '[' . date('Y-m-d H:i:s') . ']' . ' ' . $data . PHP_EOL;
        file_put_contents($path, $data, FILE_APPEND);
    }
}