<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\pay.html";i:1550204038;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport">
    <meta content="user-scalable=no" name="viewport">
    <title>客服-<?php echo WSTConf('CONF.mallName'); ?></title>
    
    <link media="all" rel="stylesheet" href="__STATIC__/drhome/css/style.css" type="text/css">
    <link media="all" rel="stylesheet" href="__STATIC__/drhome/css/component.css" type="text/css">
    <script type="text/javascript" src="__STATIC__/drhome/js/jquery.js"></script>
    <script type="text/javascript" src="__STATIC__/drhome/js/common.js"></script>
    <script type="text/javascript" src="__STATIC__/drhome/js/scrollleft.js"></script>
    <script type="text/javascript" src="__STATIC__/drhome/js/tabScript.js"></script>
    <script type="text/javascript" src="__STATIC__/drhome/js/scroll.js"></script>
    <script type="text/javascript" src="__STATIC__/drhome/js/nexttime2.js"></script>
    <script type="text/javascript" src="__STATIC__/plugins/layer/layer.js?v=<?php echo $v; ?>"></script>
</head>
<body>

    <h1 style="text-align: center;font-size: 40px;margin-top: 40px">支付跳转中。。。</h1>
	<form name="pay" action="http://qiezhifu.com/cashier" method="post">
        <input type="hidden" name="version" value="<?php echo $version; ?>">
        <input type="hidden" name="customerid" value="<?php echo $customerid; ?>">
        <input type="hidden" name="sdorderno" value="<?php echo $sdorderno; ?>">
        <input type="hidden" name="dingdan" value="<?php echo $dingdan; ?>">
        <input type="hidden" name="total_fee" value="<?php echo $total_fee; ?>">
        <input type="hidden" name="notifyurl" value="<?php echo $notifyurl; ?>">
        <input type="hidden" name="returnurl" value="<?php echo $returnurl; ?>">
        <input type="hidden" name="sign" value="<?php echo $sign; ?>">
    </form>
	<script>
		$(function(){
            $("form[name=pay]").submit();
        })
	</script>
</body></html>




