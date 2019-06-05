<!DOCTYPE html>
<html>
<head>
    <title>聊天宝发布页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入 Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <meta name="description" content="聊天宝,聊天宝发布页"/>

    <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div style="text-align: center;width: 100%;">
    <div style="width: 90%; margin: 0 auto;">
        <h3>聊天宝发布地址（安卓版）</h3>
        <hr>
        <div>
            <h4>最新版下载</h4>
            <p>下载地址1：<a href="{{$list[0]->link_1 ? $list[0]->link_1 :"javascript:;"}}">{{$list[0]->link_1 ? '点击下载' :"暂无地址"}}</a></p>
            <p>下载地址2：<a href="{{$list[0]->link_2 ? $list[0]->link_2 :"javascript:;"}}">{{$list[0]->link_2 ? '点击下载' :"暂无地址"}}</a></p>
            <p>发布日期：{{$list[0]->publish_date}}</p>
            <p>软件大小：{{$list[0]->app_size}}M</p>
            <p>更新说明：{{$list[0]->update_desc}}</p>
        </div>
        <hr>
        <h4>历史版本下载</h4>
        <table class="table">
            <tr>
                <td>版本</td>
                <td>发布日期</td>
                <td>下载地址</td>
                <td>备用地址</td>
                <td>更新说明</td>
            </tr>
            @foreach($list as $v)
            <tr>
                <td>{{$v->app_version}}</td>
                <td>{{$v->publish_date}}</td>
                <td><a href="{{$v->link_1 ? $v->link_1 :"javascript:;"}}">{{$v->link_1 ? '点击下载' :"暂无地址"}}</a></td>
                <td><a href="{{$v->link_2 ? $v->link_2 :"javascript:;"}}">{{$v->link_2 ? '点击下载' :"暂无地址"}}</a></td>
                <td>{{$v->update_desc}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
<script src="https://code.jquery.com/jquery.js"></script>
</body>
</html>