<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:94:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\getUserFlowing.html";i:1539414375;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>资金列表-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
    body { background:#f5f5f5; }
    dl.tx { width:96%; padding:50px 2%; font-size:200%; border-bottom:1px solid #e2e2e2; }
    dl.tx dt { width:60%; }
    dl.tx dt p { color:#212121; line-height:50px; padding-bottom:7px; }
    dl.tx dt blockquote { color:#999999; padding-bottom:7px; }
    dl.tx dd { width:40%; text-align:right; font-size:150%; padding-top:17px; }
    dl.tx dd.t { color:#e34145; }
</style>

<?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
<dl class="tx">
    <dt><p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $vo['remark']; ?></font></font></p><blockquote><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $vo['createTime']; ?></font></font></blockquote></dt>
    <dd class="t"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $vo['money']; ?>元</font></font></dd>
</dl>
<?php endforeach; endif; else: echo "" ;endif; ?>



	<div class="sub">
	    <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
	    <div><a href="<?php echo url('index/kaijiang'); ?>" class="a2 a_2">助手</a></div>
	    <div><a href="<?php echo url('index/paihang'); ?>" class="a3 a_3">排行</a></div>
	    <div><a href="<?php echo url('users/index'); ?>" class="a4 ">我的</a></div>
	</div>

</body></html>

