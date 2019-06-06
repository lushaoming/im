<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/6/5
 * Time: 17:55
 */
namespace App\Http\Controllers;

use App\Http\Services\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->route('id');
        $info = Article::getInstance()->getInfo($id);
        if (empty($info)) {
            return view('article.error', [
                'error' => '文章不存在'
            ]);
        } else {
            return view('article.index', [
                'info' => $info,
            ]);
        }
    }
}