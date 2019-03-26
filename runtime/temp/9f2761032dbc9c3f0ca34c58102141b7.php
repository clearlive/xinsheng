<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:87:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\qianbao.html";i:1539414375;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>钱包-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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


	<style>
		h1 , h2 , h3 , h4 , h5 .more { width:94%; overflow:hidden; padding:0 3%;}
		.more { text-align:right; background:#f7f8f8; padding:15px 3%;  width:94%;height:60px; line-height:60px; }
		.more a { color:#db4141; text-shadow:2px 2px 2px #ffffff; }
		h1 {  color:#db4141; font-size:1000%; font-family:Arial; text-align:center; padding:15% 3% 0 3%; }
		h2 {  color:#db4141; font-size:200%; text-align:center; padding:15px 3% 0 3%; }
		h6 {  color:#db4141; font-size:200%; text-align:center; padding:25px 3% 0 3%; }
		h3 { width:600px; margin:10% auto 0 auto; }
		h3 a { display:block; color:#ffffff; font-size:300%; background:#db4141; width:600px; text-align:center; height:80px; line-height:80px; padding:20px 0; border-radius:30px; }
		h4 { width:600px; margin:5% auto 0 auto; }
		h4 a { display:block; color:#666666; font-size:300%; background:#e4e4e4; width:600px; height:70px; line-height:70px;text-align:center; padding:20px 0; border-radius:30px; }
		h5 { color:#1296db; font-size:200%; text-align:center; margin-top:8%; }
		h5 a { color:#1296db; padding:3% ;  }
	</style>

	<div class="more"><a href="<?php echo url('getUserFlowing'); ?>">明细</a></div>
	<h1><?php echo $users['userMoney']; ?></h1>
    <h2>账户余额（元）</h2>
		
    <h3><a href="<?php echo url('drrecharge'); ?>">充值</a></h3>
    <h4><a href="<?php echo url('drcash'); ?>">提现</a></h4>
	
    <!-- <h5><a  href="<?php echo url('mybank'); ?>">银行卡管理</a></h5> -->


	<div class="sub">
	    <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
	    <div><a href="<?php echo url('index/kaijiang'); ?>" class="a2 a_2">助手</a></div>
	    <!-- <div><a href="<?php echo url('index/paihang'); ?>" class="a3 a_3">排行</a></div>  -->
	    <div><a href="<?php echo url('users/index'); ?>" class="a4 ">我的</a></div>
	</div>

</body></html>


