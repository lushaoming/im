<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/6/5
 * Time: 17:58
 */
namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class Article
{
    private static $instance = null;
    private $table = 'bas_article';

    private function __construct(){}

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getInfo($id)
    {
        return DB::table($this->table)->where('id', $id)->where('status', 1)->first();
    }

}