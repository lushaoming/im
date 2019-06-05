<?php
/**
 * Desc: 文件上传
 * Auth: Shaoming Lu<lushao1012@163.com>
 * Date: 2018/12/13
 * Time: 17:26
 */
namespace App\Http\Controllers;
use App\Http\Common\ApiCommon;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @title 图片上传
     */
    public function image(Request $request)
    {
        if ($request->hasFile('uploadFile') && $request->file('uploadFile')->isValid()) {
            $photo = $request->file('uploadFile');
            $extension = $photo->extension();
            $save_path = 'public/uploads/' . $this->getDate();
            $store_result = $photo->store($save_path);// 自动重命名
//            $store_result = $photo->storeAs('image', 'test.jpg');

            $path = mb_substr($store_result, 7);
            $output = [
                'extension' => $extension,
                'path' => $path,
                'path_base64' => base64_encode($path),
                'full_path' => API_DOMAIN . '/api/image/' . base64_encode($path),
            ];
            ApiCommon::ajaxReturn(OK_CODE, $output);
        }
        ApiCommon::ajaxReturn(ERR_CODE, [], "upload error");
    }

    public function getDate()
    {
        return date('Y') . '/' . date('m') . '/' . date('d');
    }
}