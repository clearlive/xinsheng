<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\index.html";i:1539414489;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>首页-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
    
        var daojishi="<?php echo $ssc_time; ?>";
    </script>
    <style>
        body { background:#f0f0f0; }
    </style>

    <div class="scrollleftdiv">
        <div class="ico"></div>
        <div class="scrollleft" id="topscroll" style="overflow: hidden; position: relative;"></div>

    </div>

    
	<div class="topbanner" onclick="window.location.href='<?php echo GetTableValue('ads',81,'adURL','adId'); ?>'"><img src="__ROOT__/<?php echo GetTableValue('ads',81,'adFile','adId'); ?>"></div>
    

	<div class="nav">
		<span class="n1">公平时彩</span>
		<span class="n2">公平公正</span>
		<span class="n3">全网最低</span>
	</div>
    <div class="wrapper">

        <?php if(is_array($goods) || $goods instanceof \think\Collection): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    	<div class="main">
            <a href='<?php echo Url("home/goods/detail",array('id'=>$vo["goodsId"],'lh'=>0)); ?>'>
                <dl>
                    <dt><img src="__ROOT__/<?php echo WSTImg($vo['goodsImg']); ?>"></dt>
                    <dd>
                        <h1><?php echo $vo['goodsName']; ?></h1>
                        <h2>
                            <span>双人：<i>¥<?php echo $vo['play2']; ?></i></span>
                            <span>四人：<i>¥<?php echo $vo['play4']; ?></i></span>
                            <span>十人：<i>¥<?php echo $vo['play10']; ?></i></span>
                        </h2>
                        <h3>
                        <?php if($isopen == 1): ?>
                        <div class="djs fnTimeCountDown fl">
                            <span class="hour"></span><i>:</i>
                            <span class="mini"></span><i>:</i>
                            <span class="sec"></span><i>:</i>
                            <span class="hm"></span>
                        </div>
                        <?php else: ?>
                        <div>停止秒杀</div>
                        <?php endif; ?>
                        <em>点击抢购</em>
                        </h3>
                    </dd>
                </dl>
            </a>
	    </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
		

		
<!--		<div class="index_ten">
			<p class="lh_title"> 龙虎斗 </p>
			<?php if(is_array($goods) || $goods instanceof \think\Collection): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="ten_goods" onclick="location.href='<?php echo Url("home/goods/detail",array('id'=>$vo["goodsId"],'lh'=>1)); ?>'">
				<img src="__ROOT__/<?php echo WSTImg($vo['goodsImg']); ?>">
				<h1><?php echo $vo['goodsName']; ?></h1>
				<?php if($isopen == 1): ?>
				<div class="djs fnTimeCountDown fl">
					<span class="hour"></span><i>:</i>
					<span class="mini"></span><i>:</i>
					<span class="sec"></span><i>:</i>
					<span class="hm"></span>
				</div>
				<?php else: ?>
				<div class="djsz">停止秒杀</div>
				<?php endif; ?>
				<em>点击抢购</em>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>-->
		

        
    	

            
        <div class="tabs tabs1" style="margin-top:30px;">
            <li><a name=".tab1" class="current">最新参与记录</a></li>
            <li class="litwo"><a name=".tab2">最新获奖记录</a></li>
        </div>

        <div class="content">
            <div class="tab1" style="display: block;">
                <ul class="list_lh1">

                    
                    
                   
                    <input type="hidden" id="order_list_biao">
                <a id="get_more" href="javascript:void(0);" onclick="load_order_list();" class="more">加载更多</a>
                </ul>
            </div>
            <div class="tab2" style="display: none;">
                <ul class="list_lh1">
                    
                    

                <input type="hidden" id="order_win_list_biao">
                <a id="get_more_2" href="javascript:void(0);" onclick="load_order_win_list();" class="more">加载更多</a>
                </ul>

            </div>
        </div>

    </div>
	 <div class="sub">
		<div><a href="<?php echo url('home/index/index'); ?>" class="a1">首页</a></div>
		<div><a href="<?php echo url('kaijiang'); ?>" class="a2 a_2">开奖</a></div>
		<!--	<div><a href="<?php echo url('paihang'); ?>" class="a3 a_3">排行</a></div> -->
		<div><a href="<?php echo url('users/index'); ?>" class="a4 a_4">我的</a></div>
	</div>
     <script type="text/javascript">
	 var end_id = 1 
     var end_win_id = 1 
	var daojishi_reload_url = "<?php echo url('home/index/index'); ?>"
	//顶部滚动
    
	//切换
	$(function(){

	    if (typeof end_id =="undefined"){

            end_id = 1;
        }
        if (typeof end_win_id =="undefined"){

            end_id = 1;
        }

		loadTab();
		load_order_list();
		load_order_win_list(end_win_id);
        load_new_order_callback();//load_new_order();
		$(".fnTimeCountDown").fnTimeCountDown("");
	});
	function load_order_list(){
		
        var get_url = "<?php echo url('index_order'); ?>";
        get_url = get_url+"?page="+end_id;
        $.get(get_url,function(data){
            
            load_order_list_callback(data);
        })
	}
	
	function load_order_list_callback(msg){
	    if (!msg){
            //load_order_list(end_id);
        }

		//$('#get_more').remove();
		$('#order_list_biao').before(msg);
        end_id++;
	}
	function load_order_win_list(){
		
        var get_url = "<?php echo url('index_orderwin'); ?>";
        get_url = get_url+"?page="+end_win_id;
        $.get(get_url,function(data){
            
            load_order_win_list_callback(data);
        })
	}
	
	function load_order_win_list_callback(msg){
        if (!msg){
            //load_order_win_list(end_win_id);
        }

		//$('#get_more_2').remove();
		$('#order_win_list_biao').before(msg);
        end_win_id++;
	}
//	function load_new_order(){
//
//		var callback='load_new_order_callback(msg)';
//
//		ajax_post(load_new_order_url,{},callback);
//
//	}

    function load_new_order_callback(msg){

        msg = '<ul><li><?php echo $msg['msgContent']; ?></li></ul>';

        $('#topscroll').html(msg);
         $("#topscroll").imgscroll({
                speed: 8,    //滚动速度
                amount: 0,    //滚动过渡时间
                width: 1,     //滚动步数
                dir: "left"   // "left" 或 "up" 向左或向上滚动
            });
    }



    
    </script> 
	

</body></html>