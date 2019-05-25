<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/25
 * Time: 14:37
 */
namespace App\Http\Controllers;

class LoveController extends Controller
{
    public function index()
    {
        // echo '因为某人生气了，所以此链接已关闭！';exit;
        return view('love.index');
    }
}