<?php
/**
 * 分页
 * User: Shannon
 * Date: 2019/4/22
 * Time: 16:50
 */
namespace App\Http\Common;

class Paginate
{
    public static function html($currentPage = 1, $totalPage = 10)
    {
        $lastPageBtnEnabled = $currentPage == 1 ? ' ydc-disabled' : '';
        $nextPageBtnEnabled = $currentPage == $totalPage ? ' ydc-disabled' : '';
        $currentUrl = self::getCurrentUrl();
        if ($totalPage == 0) {
            $html = <<<HTML
<div class="ydc-pagination">
    <ol>
        <li class="ydc-previous-item">
            <button class="ydc-previous-item-btn-medium ydc-disabled">
                <span>上一页</span>
            </button>
        </li>
        <li>
            <button class="ydc-previous-item-btn-medium cur ydc-disabled">1</button>
        </li>
        <li class="ydc-previous-item">
            <button class="ydc-previous-item-btn-medium ydc-disabled">
                <span>下一页</span>
            </button>
        </li>
        <li class="ydc-item-quick">
            第<div class="ydc-item-quick-kun"><input type="number" aria-invalid="false" class=""></div>页
            <button style="margin-left:5px;" class="ydc-previous-item-btn-medium ydc-disabled">
                <span>跳转</span>
            </button>
        </li>
    </ol>
</div>';
HTML;
            return $html;
        }

        // 小于5页，页码全部显示
        if ($totalPage <= 5) {
            $html = <<<HTML
<div class="ydc-pagination">
    <ol>
        <li class="ydc-previous-item">
            <button class="ydc-previous-item-btn-medium{$lastPageBtnEnabled}" onclick="location.href='{$currentUrl}'">
                <span>上一页</span>
            </button>
        </li>
HTML;
            for ($i = 1; $i <= $totalPage; $i++) {
                $isCurrentPageClass = '';
                if ($i == $currentPage) $isCurrentPageClass = ' cur';
                $html .= <<<HTML
        <li>
            <button class="ydc-previous-item-btn-medium{$isCurrentPageClass}" onclick="location.href=''">{$i}</button>
        </li>
HTML;
            }
            $html .= <<<HTML
        <li class="ydc-previous-item">
            <button class="ydc-previous-item-btn-medium{$nextPageBtnEnabled}" onclick="location.herf='#'">
                <span>下一页</span>
            </button>
        </li>
        <li class="ydc-item-quick">
            第<div class="ydc-item-quick-kun"><input type="number" aria-invalid="false" class=""></div>页
            <button style="margin-left:5px;" class="ydc-previous-item-btn-medium">
                <span>跳转</span>
            </button>
        </li>
    </ol>
</div>
HTML;
        }

        // 总页数大于5
        if ($totalPage > 5) {

        }

        return $html;


    }

    public static function getCurrentUrl()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
            $scriptName=$_SERVER['REQUEST_URI'];
            $nowurl=$scriptName;
        }else{
            $scriptName=$_SERVER['PHP_SELF'];
            if(empty($_SERVER['QUERY_STRING'])){
                $nowurl=$scriptName;
            }else{
                $nowurl=$scriptName.'?'.$_SERVER['QUERY_STRING'];
            }
        }
//        if ()
        $path = substr($nowurl, 0, strpos($nowurl, '?'));
        $params = substr($nowurl, strrpos($nowurl, '?') + 1);
        return $nowurl;

    }
}