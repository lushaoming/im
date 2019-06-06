<!DOCTYPE html>
<html>
<head>
    <title>{{$info->title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入 Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <meta name="description" content="{{$info->title}}"/>

    <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<style>
    html {
        min-height: 100%; /* 非常重要 */
        position: relative;
    }
    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        color: red;
    }
</style>
</head>
<body>
<div class="header"></div>
<div style="margin-top: 10%;margin-left: 5%;margin-right: 5%;bottom: 5%;">
    <div style="text-align: center;font-size: 18px;">{{$info->title}}</div>
    <div>
        {!! $info->content !!}
    </div>
</div>

<div class="footer">
欢迎使用聊天宝
</div>
</body>
</html>