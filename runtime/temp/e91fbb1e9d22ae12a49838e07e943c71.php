<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:81:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\paihang.html";i:1539414427;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>排行-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
    <div class="wrapper">
    
    <div class="tabs0">
		<li>
				<a href="<?php echo url('paihang',array('type'=>1)); ?>" <?php if($type == 1): ?> class="current" <?php endif; ?>>日榜</a>
		</li>
		<li>
				<a href="<?php echo url('paihang',array('type'=>2)); ?>" <?php if($type == 2): ?> class="current" <?php endif; ?>>周榜</a>
		</li>
		<li class="litwo">
				<a href="<?php echo url('paihang',array('type'=>3)); ?>" <?php if($type == 3): ?> class="current" <?php endif; ?>>月榜</a>
		</li>
	</div>
        
        
		<div class="content">
			<div class="tab1">
            
			<ul class="phb">

                <?php if(is_array($list) || $list instanceof \think\Collection): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($key <= 3): ?>
				<li onclick="window.location.href='<?php echo url('users/dingdan',array('uid'=>$vo['userId'])); ?>'">
					<p class="face"><img src="<?php echo getuser_photo($vo['userPhoto']); ?>"></p>
                    <p class="no"><?php echo $key; ?></p>
                    <p class="name0"><?php echo substr($vo['userPhone'], 0,3); ?>****<?php echo substr($vo['userPhone'], -4); ?></p>
                    <p class="danshu">已中奖：<?php echo $vo['sumNum']; ?>单</p>
                </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>	                
            </ul>

            <?php if(is_array($list) || $list instanceof \think\Collection): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($key > 3): ?>
			<dl class="bzb" onclick="window.location.href='<?php echo url('users/dingdan',array('uid'=>$vo['userId'])); ?>'">
           	  <dt class="d1"><?php echo $key; ?></dt>
				<dd class="c1"><img src="<?php echo getuser_photo($vo['userPhoto']); ?>"></dd>
                <dd class="c2">
                	<i class="fl"><?php echo substr($vo['userPhone'], 0,3); ?>****<?php echo substr($vo['userPhone'], -4); ?></i>
                    <i class="fr">已中奖：<?php echo $vo['sumNum']; ?>单</i>
                </dd>
            </dl>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
			   

			               
		</div>
        
    </div>
    
    <div class="sub">
       <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
        <div><a href="<?php echo url('kaijiang'); ?>" class="a2 a_2">助手</a></div>
        <div><a href="<?php echo url('paihang'); ?>" class="a3 ">排行</a></div>
        <div><a href="<?php echo url('users/index'); ?>" class="a4 a_4">我的</a></div>
	</div>
    



</div></body></html>