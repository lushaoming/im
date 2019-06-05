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
    public function index(Request $request)
    {
        echo '{"code":200,"msg":"OK","data":{"log_id":3127369080,"result_num":1,"result":[{"face_probability":0.97999999999999998,"rotation_angle":-2,"yaw":2.4900000000000002,"pitch":-3.6800000000000002,"roll":-4.1299999999999999,"location":{"left":125,"top":155,"width":159,"height":145},"landmark":[{"x":170.34999999999999,"y":179.71000000000001},{"x":238.09,"y":176.41},{"x":202.08000000000001,"y":210.72},{"x":204.34999999999999,"y":250.09999999999999}],"landmark72":[{"x":127.83,"y":202.13},{"x":130.96000000000001,"y":223.47999999999999},{"x":136.13,"y":244.91},{"x":144.69999999999999,"y":266.05000000000001},{"x":163.13,"y":284.76999999999998},{"x":186.16999999999999,"y":294.88},{"x":208.27000000000001,"y":297.23000000000002},{"x":230.78,"y":293.95999999999998},{"x":254.47999999999999,"y":283.80000000000001},{"x":273.87,"y":263.18000000000001},{"x":281.42000000000002,"y":240.69999999999999},{"x":284.97000000000003,"y":218.06},{"x":286.79000000000002,"y":195.44},{"x":153.52000000000001,"y":184},{"x":160.16999999999999,"y":176.53},{"x":168.31,"y":174.06},{"x":176.80000000000001,"y":175.94},{"x":184.16,"y":184.00999999999999},{"x":176.68000000000001,"y":185.28},{"x":168.37,"y":186.18000000000001},{"x":160.19999999999999,"y":185.88999999999999},{"x":170.34999999999999,"y":179.71000000000001},{"x":142,"y":169.78},{"x":150.56999999999999,"y":157.43000000000001},{"x":162.91999999999999,"y":153.83000000000001},{"x":175.05000000000001,"y":154.28},{"x":186.34,"y":161.90000000000001},{"x":174.93000000000001,"y":161.88},{"x":163.19999999999999,"y":161.88},{"x":152.19,"y":164.25},{"x":222.93000000000001,"y":181.86000000000001},{"x":229.47999999999999,"y":173.49000000000001},{"x":237.63,"y":170.50999999999999},{"x":246.16,"y":172.38999999999999},{"x":253.75,"y":179.06999999999999},{"x":247.05000000000001,"y":181.80000000000001},{"x":238.71000000000001,"y":182.97},{"x":230.55000000000001,"y":182.75},{"x":238.09,"y":176.41},{"x":216.44,"y":160.16999999999999},{"x":227.5,"y":151.16},{"x":240,"y":149.59999999999999},{"x":253.27000000000001,"y":152.13},{"x":264.13999999999999,"y":163.25999999999999},{"x":252.38999999999999,"y":158.78999999999999},{"x":240.53999999999999,"y":157.84999999999999},{"x":228.53,"y":159.15000000000001},{"x":193.38,"y":183.80000000000001},{"x":191.16999999999999,"y":195.84},{"x":188.63,"y":208.08000000000001},{"x":184.19999999999999,"y":223.31999999999999},{"x":194.06999999999999,"y":221.80000000000001},{"x":212.93000000000001,"y":221},{"x":224.03,"y":221.71000000000001},{"x":218.30000000000001,"y":206.94},{"x":215.55000000000001,"y":194.72999999999999},{"x":212.49000000000001,"y":182.80000000000001},{"x":202.08000000000001,"y":210.72},{"x":177.38999999999999,"y":251.80000000000001},{"x":188.69999999999999,"y":243.22},{"x":203.62,"y":241.24000000000001},{"x":219.13,"y":242.18000000000001},{"x":232.96000000000001,"y":249.72},{"x":219.68000000000001,"y":257.04000000000002},{"x":204.36000000000001,"y":259.68000000000001},{"x":189.47999999999999,"y":258.25},{"x":190.13,"y":249.12},{"x":203.91999999999999,"y":248.37},{"x":218.78,"y":248.06999999999999},{"x":218.13,"y":250.44},{"x":204.03,"y":250.72},{"x":190.59,"y":251.59999999999999}],"qualities":{"blur":0,"illumination":174,"completeness":1,"occlusion":{"left_eye":0,"right_eye":0,"nose":0,"mouth":0,"left_cheek":0,"right_cheek":0.01,"chin":0},"type":{"human":0.98999999999999999,"cartoon":0.01}},"age":22,"beauty":70.920000000000002,"expression":1,"expression_probablity":0.98999999999999999,"faceshape":[{"type":"square","probability":0.76000000000000001},{"type":"triangle","probability":0.029999999999999999},{"type":"oval","probability":0.050000000000000003},{"type":"heart","probability":0},{"type":"round","probability":0.14999999999999999}],"gender":"female","gender_probability":1,"glasses":0,"glasses_probability":1,"race":"yellow","race_probability":1}]}}';
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