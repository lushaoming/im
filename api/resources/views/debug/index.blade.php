<!DOCTYPE html>
<html>
<head>
    <title>调试信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入 Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<div style="width: 100%;">
    <pre>
    <br />
    <b>Fatal error</b>:  Uncaught TypeError: Return value of Reolink\Models\SaleCountryFactory::getCurrentCountry() must be an instance of Reolink\Models\SaleCountry, null returned in /www/develop-vhosts/website/wp-content/plugins/reolink_core/models/SaleCountryFactory.php:1106
    Stack trace:
    #0 /www/develop-vhosts/website/wp-content/plugins/reolink_core/custom-posts/WC_Product.php(207): Reolink\Models\SaleCountryFactory-&gt;getCurrentCountry()
    #1 /www/develop-vhosts/website/wp-includes/class-wp-hook.php(298): Reolink\Posts\WC_Product::getProductPrice('7.99', Object(WC_Product_Variation))
    #2 /www/develop-vhosts/website/wp-includes/plugin.php(203): WP_Hook-&gt;apply_filters('7.99', Array)
    #3 /www/develop-vhosts/website/wp-content/plugins/woocommerce/includes/abstracts/abstract-wc-product.php(859): apply_filters('woocommerce_get...', '7.99', Object(WC_Product_Variation))
    #4 /www/develop-vhosts/website/wp-content/plugins/woocommerce/includes/abstracts/abstract-wc-product.php(806): WC_Product-&gt;get_price()
    #5 /www/develop-vhosts/website/wp-conten in <b>/www/develop-vhosts/website/wp-content/plugins/reolink_core/models/SaleCountryFactory.php</b> on line <b>1106</b><br />
    <br />
    <b>Fatal error</b>:  Uncaught TypeError: Return value of Reolink\Models\SaleCountryFactory::getCurrentCountry() must be an instance of Reolink\Models\SaleCountry, null returned in /www/develop-vhosts/website/wp-content/plugins/reolink_core/models/SaleCountryFactory.php:1106
    Stack trace:
    #0 /www/develop-vhosts/website/wp-content/plugins/reolink_core/custom-posts/WC_Product.php(207): Reolink\Models\SaleCountryFactory-&gt;getCurrentCountry()
    #1 /www/develop-vhosts/website/wp-includes/class-wp-hook.php(298): Reolink\Posts\WC_Product::getProductPrice('7.99', Object(WC_Product_Variation))
    #2 /www/develop-vhosts/website/wp-includes/plugin.php(203): WP_Hook-&gt;apply_filters('7.99', Array)
    #3 /www/develop-vhosts/website/wp-content/plugins/woocommerce/includes/abstracts/abstract-wc-product.php(859): apply_filters('woocommerce_get...', '7.99', Object(WC_Product_Variation))
    #4 /www/develop-vhosts/website/wp-content/plugins/woocommerce/includes/abstracts/abstract-wc-product.php(806): WC_Product-&gt;get_price()
    #5 /www/develop-vhosts/website/wp-conten in <b>/www/develop-vhosts/website/wp-content/plugins/reolink_core/models/SaleCountryFactory.php</b> on line <b>1106</b><br />
</pre>
</div>

<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
<script src="https://code.jquery.com/jquery.js"></script>
</body>
</html>