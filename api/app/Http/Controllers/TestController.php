<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/5/25
 * Time: 15:09
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TestController extends Controller
{
    public function info(Request $request)
    {

    }

    public function excel(Request $request)
    {
        $filename = ROOT_PATH.'/excel/locale_code.xlsx';
        # 根据文件名自动创建 适用于不知道文件后缀时xls还是xlsx的情况
//        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);

        // 如果确定文件后缀，直接创建，性能高一点
//        $reader = IOFactory::createReader('Xlsx');

        // 甚至可以直接指定reader实现创建 性能又会优于上面一丢丢
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);// 可以额外设定只读模式，让工具只读取数据，不处理样式，性能会更好
        $spreedsheet = $reader->load($filename);

        $sheet = $spreedsheet->getSheet(0);

        $rows = $sheet->getHighestRow();
        $temp = [];
        for ($i = 1; $i <= $rows; $i++) {
            $temp[$i-1]['country_name'] = $sheet->getCell("A{$i}")->getValue();
            $temp[$i-1]['country_code'] = $sheet->getCell("B{$i}")->getValue();
            $temp[$i-1]['language_support_priority'] = $sheet->getCell("C{$i}")->getValue();
            $temp[$i-1]['locale_code'] = $sheet->getCell("D{$i}")->getValue();
            $apiCode = $sheet->getCell("E{$i}")->getValue();
            $apiCode = str_replace('-', '_', $apiCode);
            $temp[$i-1]['api_locale_code'] = $apiCode;
        }

        $isEmptyTable = DB::table('bas_country_locale')->first();
        if ($isEmptyTable) {
            exit('Import Error: Table `bas_country_locale` is not empty!');
        }
//        DB::table('bas_country_locale')->insert($temp);
        echo 'success';
//        var_dump($temp);
    }

    public function exportToFile()
    {
        $filename = ROOT_PATH . '/excel/locale_code.php';
        $data = include $filename;
        // 新创建Spreadsheet对象
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // 获取活动的sheet
        $sheet = $spreadsheet->getActiveSheet();

        // 写入第一行数据
        $sheet->setCellValue('A1', 'Region');
        $sheet->setCellValue('B1', 'Region Code');
        $sheet->setCellValue('C1', 'Language Support Priority');
        $sheet->setCellValue('D1', 'Locale Code');
        $sheet->setCellValue('E1', 'BCP-47 code for REST APIs');

        foreach ($data as $k => $v) {
            $index = $k + 2;
            $sheet->setCellValue("A{$index}", $v['country_name']);
            $sheet->setCellValue("B{$index}", $v['country_code']);
            $sheet->setCellValue("C{$index}", $v['language_support_priority']);
            $sheet->setCellValue("D{$index}", $v['locale_code']);
            $sheet->setCellValue("E{$index}", $v['api_locale_code']);
        }

        $writer = new Xlsx($spreadsheet);
        $saveName = 'locale_code_'.date('YmdHis').'.xlsx';
        // 这是保存成一个文件
//        $writer->save( ROOT_PATH . '/excel/'.$saveName);


        # 添加对应的header头部 其中xxxxx.xls为下载时的文件名
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$saveName.'"');
        header('Cache-Control:max-age=0');
        $writer->save('php://output');
    }
}