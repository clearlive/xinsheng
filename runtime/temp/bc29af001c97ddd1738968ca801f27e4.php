<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:82:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\kaijiang.html";i:1550560004;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>

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
    <title>开奖记录-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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

<script>
var http = 'http://duoren.cc/';
var user_id='';
var SysSecond=parseInt(150608700000);
var get_next_open_time_url= http + 'kaijiang.php';

var daojishi_reload_url=window.location.href;
var daojishi="<?php echo $ssc_time; ?>";
</script>
	<div class="wrapper">
    	<div class="kjktop">

            <div class="fr" style="margin-right: 30%">
            <span class="">下次开奖时间：</span>
            
            <span class="fnTimeCountDown">
                    <span class="hour"></span><i>:</i>
                    <span class="mini"></span><i>:</i>
                    <span class="sec"></span><i>:</i>
                    <span class="hm"></span>
            </span>
                
            </div>
        </div>
		<div class="kjtop">
        	<div class="kt2">
            	<div><img src="/static/drhome/images/cx.png"></div>
				<div style="padding-left:10px;">公平公正<br>无法作弊</div>
			</div>
        	<!-- <div class="kt1"><p>全天24小时</p><p>五分钟开奖</p></div> -->
        	<div class="kt1"><p>7:00-23:55</p><p>五分钟开奖</p></div>
        	<!-- <div class="kt1"><p>10:00-22:00</p><p>十分钟开奖</p></div> -->
        </div>
        
		 <div class="kj">
        	<div class="k_1" style="line-height:2.8;">开奖号码</div>
        	<div class="k_3">双人<br><span>(个位)</span></div>
        	<div class="k_4">四人<br><span>(后两位)</span></div>
        	<div class="k_2">十人<br><span>(个位)</span></div>
			<!-- <div class="k_5" style="line-height:2.8;">龙虎</div> -->
        </div>
        
        <?php if(is_array($ssc_list) || $ssc_list instanceof \think\Collection): $key = 0; $__LIST__ = $ssc_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
		<div class="kjj">
        
        <p class="kjjpq">20<?php echo $vo['issue']; ?><span>期</span> <span style="float:right;margin-right:2rem"> <?php echo date("Y-m-d H:i:s",$vo['createtime']); ?></span></p>
        
                <div class="k_1">

                    
                    <blockquote>
                        <span><?php echo substr($vo['balls'],0,1); ?></span>
                        <span><?php echo substr($vo['balls'],1,1); ?></span>
                        <span><?php echo substr($vo['balls'],2,1); ?></span>
                        <span class="s1"><?php echo substr($vo['balls'],3,1); ?></span>
                        <span class="s1"><?php echo substr($vo['balls'],4,1); ?></span>
                    </blockquote>
                </div>
                <div class="k_3">
                   <!-- <span class="cc1"><?php echo $vo['isxiao']; ?></span> -->

                    <span>|</span>

                    <span class="cc2"><?php echo $vo['isdan']; ?></span>

                </div>

                <div class="k_4"><span><?php echo $vo['four']; ?></span></div>
                <div class="k_2"><span><?php echo substr($vo['balls'],4,1); ?></span></div>
				
				<!-- <div class="k_5"><span>
					<?php if(substr($vo['balls'],0,1) == substr($vo['balls'],4,1)): ?>
						和
					<?php elseif(substr($vo['balls'],0,1) > substr($vo['balls'],4,1)): ?>
						龙
					<?php else: ?>
						虎
					<?php endif; ?>
				</span></div> -->
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>

            <input type="hidden" id="list_biao"> 
            <div class="more" id="get_more" onclick="load_list();" style="height:150px;">加载更多</div>
        
 </div>
    </div>
	<div class="sub">
        <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
        <div><a href="<?php echo url('kaijiang'); ?>" class="a2 ">开奖</a></div>
       <!-- <div><a href="<?php echo url('paihang'); ?>" class="a3 a_3">排行</a></div> -->
        <div><a href="<?php echo url('users/index'); ?>" class="a4 a_4">我的</a></div>
	</div>
        

<script>
var load_list_url= "<?php echo url('ajax_kaijiang'); ?>";
var intDiff=0;
var end_id = 2;
$(function(){
	//load_list(1);
	
	$(".fnTimeCountDown").fnTimeCountDown("");
   
});

function load_list(){
	$('#get_more').html('正在加载中...');
	var data={page:end_id}
	var callback='load_list_callback(msg)';
	//alert(load_list_url);
	ajax_post(load_list_url,data,callback);
}
	
function load_list_callback(msg){

    if (!msg){
        load_list(1);
    }
    end_id++;
	//$('#get_more').remove();
	$('#list_biao').before(msg);
}



</script>



</body></html>