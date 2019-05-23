<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/22
 * Time: 17:29
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function publish(Request $request)
    {
        $list = DB::table('bas_app_version')->where('status', 1)->orderBy('id', 'DESC')->get();
        foreach ($list as &$v) {
            $v->publish_date = date('Y-m-d', strtotime($v->publish_date));
        }
        return view('app.publish', [
            'list' => $list
        ]);
    }

    public function checkVersion(Request $request)
    {
        $version = $request->input('version');
        $newest = DB::table('bas_app_version')->where('status',1)->orderBy('id', 'DESC')->value('app_version');
        if ($version == $newest) return json_encode(['code' => 1]);
        return json_encode(['code' => 0, 'newest_version' => $newest]);
    }
}