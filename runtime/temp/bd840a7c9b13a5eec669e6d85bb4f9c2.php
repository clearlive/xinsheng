<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\myteam.html";i:1539414375;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>我的团队-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
.tabs li {
    width: 50% !important;
}
.sons .sonsp{
	font-size: 200%;
}
.sons{
	margin: 1.5rem;
}
dl.tx { width:96%; padding:50px 2%; font-size:200%; border-bottom:1px solid #e2e2e2; }
dl.tx dt { width:60%; }
dl.tx dt p { color:#212121; line-height:50px; padding-bottom:7px; }
dl.tx dt blockquote { color:#999999; padding-bottom:7px; }
dl.tx dd { width:40%; text-align:right; font-size:150%; padding-top:17px; }
dl.tx dd.t { color:#e34145; }
</style>

<div class="">
	<div class="tabs" style="margin-top:0;">
		 <li>
            <a href="<?php echo url('myteam',array('type'=>1)); ?>" <?php if($type == 1): ?> class="current" <?php endif; ?>>我的客户</a>
        </li>
        <li>
            <a href="<?php echo url('myteam',array('type'=>2)); ?>" <?php if($type == 2): ?> class="current" <?php endif; ?>>我的代理商</a>
        </li>
	</div>
</div>

<div class="sons">
	<?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	
	<dl class="tx">
	    <dt><p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $vo['userName']; ?></font></font></p><blockquote><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $vo['createTime']; ?></font></font></blockquote></dt>
		<?php if($type == 1): ?>
	    <dd class="t"><font style="vertical-align: inherit;"><a href="<?php echo url('upuser',array('uid'=>$vo['userId'])); ?>"><font style="vertical-align: inherit;">升级为代理商</font></a></font></dd>
	    <?php elseif($type == 2): ?>
	    <dd class="t"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">比例：<?php echo $vo['percent']; ?>%</font></font></dd>
	    <?php endif; ?>
	    <br><br><br><br>
		<p style="font-size:120%">今日流水 <?php echo $vo['todyls']; ?> 历史流水：<?php echo $vo['allls']; ?> </p>
	</dl>
	
		
	<?php endforeach; endif; else: echo "" ;endif; ?>
</div>

	<div class="sub">
	    <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
	    <div><a href="<?php echo url('index/kaijiang'); ?>" class="a2 a_2">助手</a></div>
	    <!-- <div><a href="<?php echo url('index/paihang'); ?>" class="a3 a_3">排行</a></div> -->
	    <div><a href="<?php echo url('users/index'); ?>" class="a4 ">我的</a></div>
	</div>

</body></html>

