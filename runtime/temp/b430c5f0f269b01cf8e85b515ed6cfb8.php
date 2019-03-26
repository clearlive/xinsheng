<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\goods_detail.html";i:1550123910;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>详情-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
        var http = '/';
        var SysSecond=parseInt(150608700000);
        //var openlog_url='';
        
        var daojishi_reload_url=window.location.href;
        var chongzhi_url=  "<?php echo url('users/drrecharge'); ?>";
        var shopping_url= "<?php echo url('drorder/add'); ?>";
        
        var goods_id='<?php echo $goods["goodsId"]; ?>';
        var account_now='<?php echo $users['userMoney']; ?>';
        var daojishi="<?php echo $ssc_time; ?>";
        
		<?php if($lh == 0): ?>
			var drtype = 2;
		<?php else: ?>
			var drtype = 'lh';
		<?php endif; ?>
    </script>
    <style>
        .xiala { width:100%; padding:10px 0 0px 0; }
        .sewv{position: relative;width:93%;display: inline-block;vertical-align: middle; background:#ffffff; padding:0 2% 0 5%; font-size:210%;border-bottom: 1px solid #d6d6d6; border-top: 1px solid #d6d6d6; }
        .sewvtop{width:100%;height:40px; line-height:100px; cursor:pointer;overflow: hidden; z-index:1000000; }
        .sewvtop span { color:#f16925; }
        .sewvtop:hover{}
        .sewvtop>span{float:left;width:80%;height:40px;white-space:pre;text-overflow:ellipsis;overflow: hidden;line-height:40px;vertical-align: middle;}
        .sewvtop>em{float:right; margin-right:1%;width: 40px;height: 40px;vertical-align: middle;}
        .sewvbm{width: 100%;position: absolute;left: 0;top: 100px;display: none; background:#ffffff; z-index:1000000;border-bottom: 1px solid #d6d6d6; }
        .sewvbm>li{cursor:pointer;width:90%;height:40px;line-height:40px; padding:0 5%;}
        .sewvbm>li:hover{}
        .sewvbm li span {  color:#f16925; }
        .lbaxztop2{animation: rotatete 0.3s linear forwards;}
        .lbaxztop1{animation: rotatete2 0.3s linear forwards;}
        @keyframes rotatete{
            from{transform: rotate(0deg);}
            to{transform: rotate(180deg);}
        }

        @keyframes rotatete{
            from{transform: rotate(0deg);}
            to{transform: rotate(180deg);}
        }

        @-moz-keyframes rotatete2{
            from{transform: rotate(180deg);}
            to{transform: rotate(0deg);}
        }
        @keyframes rotatete2{
            from{transform: rotate(180deg);}
            to{transform: rotate(0deg);}
        }

       #pay_success {

            width: 94%;
            margin:0 3%;
            background: #fff;
            border-top-left-radius:10px;
            border-top-right-radius:10px;
            position:fixed;
            display: none;
            bottom:20%;
            z-index: 2000000000;
            -moz-opacity: 1;
            opacity: 1;
            filter: alpha(opacity=100);
            -webkit-box-shadow:0 0 10px #000000;
            -moz-box-shadow:0 0 10px #000000;
            box-shadow:0 0 10px #000000;
        }
.pay_success{padding-bottom:200px;}
        .pay_success div { padding-top:0; width:100%; float:left; margin:auto;text-align:center; }
        .pay_success .pay_success_ok { padding:100px 0 30px 0; }
        .pay_success h2 { color:#7ed224; font-size:250%; padding-bottom:30px; }
        .pay_success .pay_success_line { padding-bottom:80px; text-align:center; float:left; width:100%; height:90px; line-height:90px; margin-top:40px; }
        .pay_success .pay_success_line span { border:1px solid #e34044; background:#ffffff; color:#e34044; padding:30px 100px; border-radius:15px; font-size:200%; }
        .pay_success .pay_success_line span.s1 { border:1px solid #e34044; background:#e34044; color:#ffffff; }
	
	<?php if($lh == 0): ?>
		.tabs2 li{
			width:33.33% !important;
		}
	<?php else: ?>
		.tabs2 li{
			width:100% !important;
		}
	<?php endif; ?>
	
    </style>

<div class="wrapper">


    <div class="details">
        <dl>
                        <dt><img src="__ROOT__/<?php echo $goods['sjgoodsImg']; ?>"></dt>
            <dd>
                <h1><div class="fl"><?php echo $goods['goodsName']; ?></div>
                <?php if($isopen == 1): ?>
                    <div class="fnTimeCountDown fr">
                        <span class="hour"></span><i>:</i>
                        <span class="mini"></span><i>:</i>
                        <span class="sec"></span><i>:</i>
                        <span class="hm"></span>
                    </div>
                <?php else: ?>
                <div  class="fnTimeCountDown fr">停止秒杀</div>
                <?php endif; ?>
                </h1>
                <h2>
                    <div class="fl">夺宝价：¥</div>
					<?php if($lh == 0): ?>
					<span class="c1"><?php echo $goods['play10']; ?></span><span class="c2">/</span>
                    <span class="c1"><?php echo $goods['play4']; ?></span><span class="c2">/</span>
                    <span class="c1"><?php echo $goods['play2']; ?></span>
					<?php else: ?>
					<span class="c1"><?php echo $goods['play2']; ?></span><span class="c2"></span>
					<?php endif; ?>
                    
                    <div class="fr">累计数：<?php echo $goods['saleNum']; ?>单</div></h2>
            </dd>
        </dl>
    </div>


    <div class="xiala">
        <div class="sewv" id="openlog_div">

            <div class="sewvtop"><span>第 20<?php echo $ssc_list[0]['issue']; ?> 期 <?php echo $ssc_list[0]['balls']; ?>( <?php echo $ssc_list[0]['isxiao']; ?> | <?php echo $ssc_list[0]['isdan']; ?> | <?php echo $ssc_list[0]['four']; ?> )</span><em class="lbaxztop">
                <img width="40px" src="/static/drhome/images/selebom.png"></em></div>
            <ul class="sewvbm">
                
                <?php if(is_array($ssc_list) || $ssc_list instanceof \think\Collection): $key = 0; $__LIST__ = $ssc_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($key > 1): ?>
                <li><span>第 20<?php echo $vo['issue']; ?> 期 <?php echo $vo['balls']; ?>( <?php echo $vo['isxiao']; ?> | <?php echo $vo['isdan']; ?> | <?php echo $vo['four']; ?> ) </span></li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
              
            </ul>

        </div>
    </div>


    <div class="tname"><div>抢购榜单</div></div>

    <div style="padding:5px 0;background:#ffffff; border-bottom: 1px solid #d6d6d6; ">
        <ul class="slide-list js-slide-list">

            <?php if(is_array($bangdan) || $bangdan instanceof \think\Collection): $i = 0; $__LIST__ = $bangdan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

            <li>
                <dl>
                    
                    <dd>
                        <p>
                            <span class="c1"><?php echo substr($vo['userPhone'], 0,3); ?>****<?php echo substr($vo['userPhone'], -4); ?></span> 抢购 <span><?php echo $vo['orderNum']; ?></span> 单
                            <span style="color:#ccc;padding-left:5px;"><?php echo $vo['createTime']; ?></span>
                        </p>
                    </dd>
                </dl>

            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>

            

           </ul>
    </div>


    <div class="tabs" style="margin-top:30px;">
        <li><a name=".tab1" class="current">商品介绍</a></li>
        <li><a name=".tab2">参数规格</a></li>
        <li class="litwo"><a name=".tab3">售后保障</a></li>
    </div>

    <div class="content con">
        <div class="tab1 co" style="display: block;">
            <img src="/static/drhome/images/goods_jy_1.jpg">

        </div>
        <div class="tab2 co" style="display: none;">
            <p class="c1">主体</p>
            <p>类型：实体卡</p>
            <p>面值：</p>
        </div>

        <div class="tab3 co" style="display: none;">
            <p class="c1">售后服务：</p>
            <p>商品为在线充值卡或者实体购物卡所有卡券均为不记名不挂失卡券，请妥善保管，质量期：无质保。</p>
            <p class="c1">正品行货</p>
            <p>我们向您保证所售商品均为正品行货，京东自营商品开具机打发票或电子发票。</p>
            <p class="c1">补充说明</p>
            <p>因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>

        </div>
    </div>
</div>


<div class="cjbs" style="max-width:1024px;">
    <div><i class="c1">
            ¥
			<?php if($lh == 0): ?>
			<span><?php echo $goods['play10']; ?></span><span>/</span>
            <span><?php echo $goods['play4']; ?></span><span>/</span>
            <span><?php echo $goods['play2']; ?></span></i>
			<?php else: ?>
			<span class="c1"><?php echo $goods['play2']; ?></span><span class="c2"></span>
			<?php endif; ?>
			</div>
    <a id="ClickMe">马上购买</a>
</div>

<div class="csm1" style="max-width: 1024px !important;">
    <div class="close1"><a href="javascript:void(0)" id="closebt1">关闭</a></div>
    <div class="goodtxt">
        <!-- <p>（早上10:00-次日01:55）为正常销售时间，凌晨02:00-09:55为系统维护时间。</p> -->
        <p><strong>每期开奖共开出5个数字。</strong></p>

        <dl>
            <dt>双人玩法：</dt>
            <dd>双人玩法又分为大小玩法和单双玩法，双人玩法采用的是越南快5开奖号的最后一位（即个位，0-4为小，5-9为大）。</dd>
        </dl>
        <dl>
            <dt>四人玩法：</dt>
            <dd>四人玩法采用的是越南快5开奖号的后两位（即十位和个位，如后两位85为大单，26为小双）。</dd>
        </dl>
        <dl>
            <dt>十人玩法：</dt>
            <dd>十人玩法采用的是越南快5开奖号的最后一位（即个位）。</dd>
        </dl>
		       <!-- <dl>
            <dt>龙虎玩法：</dt>
            <dd>龙虎玩法采用的是越南快5开奖号的第一位(即万位)最后一位（即个位）。万位为龙,个位为虎（开奖结果出来万位和个位进行大小对比,如万位为8,个位为9.则开奖结果虎赢一次类推,如万位和个位相同为合）龙虎为2倍,合为9倍!</dd>
        </dl> -->
    </div>
</div>


<div id="code" style="max-width: 960px !important;">

    <div class="tabs tabs2" style="margin-top:5px;">
	<?php if($lh == 0): ?>
        <li>
            <a name=".tab4" onclick="drtype=2;" class="current">双人夺宝</a>
        </li>
        <li>
            <a name=".tab5" onclick="drtype=4;">四人夺宝</a>
        </li>
        <li class="litwo">
            <a name=".tab6" onclick="drtype=10;">十人夺宝</a>
        </li>
	<?php else: ?>
        <li >
            <a name=".tab8" class="current" onclick="drtype='lh';">龙虎</a>
        </li>
	<?php endif; ?>
    </div>

    <div class="content md-content">
<?php if($lh == 0): ?>
        <!--双人夺宝-->
        <div class="tab4" style="display: block;">
            <h1 id="two_type">
                <!-- <span><i data="4_<?php echo $goods['play2']; ?>" class="ifocus">大数</i></span>
                <span><i data="3_<?php echo $goods['play2']; ?>">小数</i></span> -->
                <span style="margin-left:27%;"><i data="1_<?php echo $goods['play2']; ?>">单数</i></span> 
                <span><i data="2_<?php echo $goods['play2']; ?>">双数</i></span>
            </h1>


            <center>
                <p>选择购买数量</p>
                <h4 id="two_num">
                    <span><i>5</i></span>
                    <span><i>10</i></span>
                    <span><i>20</i></span>
                    <span style="margin-top: 10px;"><i>40</i></span>
                    <span style="margin-top: 10px;"><i>80</i></span>
                </h4>

                <h5>
                    <span onclick="remove_num(&quot;two&quot;);"><i>-</i></span>
                    <span class="input"><input type="text" id="two_input_num" readonly="true" value="1" class="text"></span>
                    <span onclick="add_num(&quot;two&quot;);"><i>+</i></span>
                </h5>
            </center>
            <p class="mon">
					<span class="fl">
						本次购买将支付：<span>￥</span><span id="two_pay_money" class="c1"><?php echo $goods['play2']; ?></span>
						<br>我的账号余额：<span>￥</span><span class="c1 span_account_now"><?php echo $users['userMoney']; ?></span>
					</span>
                <span class="fr sm1">玩法说明</span>
            </p>

            <p class="mons">
                <span>你将购买第</span>
                <span class="c1"><?php echo ssc_sn(); ?></span>
                <span>期，剩余时间</span>
                <span class="fnTimeCountDown c1" data-end="2017/11/27 10:00:00">
                        <span class="hour">00</span><i>:</i>
                        <span class="mini">24</span><i>:</i>
                        <span class="sec">44</span><i>:</i>
                        <span class="hm">44</span>
                    </span>
            </p>

            <h6>
                <input type="button" name="button" id="two_button" value="余额不足，去充值" onclick="sell_now(&quot;two&quot;);">
            </h6>
        </div>

        <!--四人夺宝-->
        <div class="tab5" style="display: none;">

            <h2 id="four_type">
                <span><i data="6_<?php echo $goods['play4']; ?>" class="ifocus">大单</i></span>
                <span><i data="8_<?php echo $goods['play4']; ?>">大双</i></span>
                <span><i data="5_<?php echo $goods['play4']; ?>">小单</i></span>
                <span><i data="7_<?php echo $goods['play4']; ?>">小双</i></span>
            </h2>
            <center>
                <p>选择购买数量</p>
                <h4 id="four_num">
                    <span><i>5</i></span>
                    <span><i>10</i></span>
                    <span><i>20</i></span>
                    <span style="margin-top: 10px;"><i>40</i></span>
                    <span style="margin-top: 10px;"><i>80</i></span>
                </h4>
                <h5>
                    <span onclick="remove_num(&quot;four&quot;);"><i>-</i></span>
                    <span class="input"><input type="text" id="four_input_num" value="1" readonly="true" class="text"></span>
                    <span onclick="add_num(&quot;four&quot;);"><i>+</i></span>
                </h5>
            </center>

            <p class="mon">
					<span class="fl">
						本次购买将支付：<span>￥</span><span id="four_pay_money" class="c1"><?php echo $goods['play4']; ?></span>
						<br>我的账号余额：<span>￥</span><span class="c1 span_account_now"><?php echo $users['userMoney']; ?></span>
					</span>
                <span class="fr sm1">玩法说明</span>
            </p>

            <p class="mons">
                <span>你将购买第</span>
                <span class="c1"><?php echo ssc_sn(); ?></span>
                <span>期，剩余时间</span>
                <span class="fnTimeCountDown c1" data-end="2017/11/27 10:00:00">
                        <span class="hour">00</span><i>:</i>
                        <span class="mini">24</span><i>:</i>
                        <span class="sec">44</span><i>:</i>
                        <span class="hm">44</span>
                    </span>
            </p>

            <h6><input type="button" name="button" id="four_button" value="余额不足，去充值" onclick="sell_now(&quot;four&quot;);"></h6>


        </div>

        <!--十人夺宝-->
        <div class="tab6" style="display: none;">
            <h3 id="ten_type">
                <span><i data="9_<?php echo $goods['play10']; ?>" class="ifocus" val="10">1</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="11">2</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="12">3</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="13">4</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="14">5</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="15">6</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="16">7</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="17">8</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="18">9</i></span>
                <span><i data="9_<?php echo $goods['play10']; ?>" val="9">0</i></span>
            </h3>
            <center>
                <p>选择购买数量</p>
                <h4 id="ten_num">
                    <span><i>5</i></span>
                    <span><i>10</i></span>
                    <span><i>20</i></span>
                    <span style="margin-top: 10px;"><i>40</i></span>
                    <span style="margin-top: 10px;"><i>80</i></span>
                </h4>
                <h5>
                    <span onclick="remove_num(&quot;ten&quot;);"><i>-</i></span>
                    <span class="input"><input type="text" id="ten_input_num" value="1" readonly="true" class="text"></span>
                    <span onclick="add_num(&quot;ten&quot;);"><i>+</i></span>
                </h5>
            </center>
            <p class="mon">
					<span class="fl">
						本次购买将支付：<span>￥</span><span id="ten_pay_money" class="c1"><?php echo $goods['play10']; ?></span>
						<br>我的账号余额：<span>￥</span><span class="c1 span_account_now"><?php echo $users['userMoney']; ?></span>
					</span>
                <span class="fr sm1">玩法说明</span>
            </p>

            <p class="mons">
                <span>你将购买第</span>
                <span class="c1"><?php echo ssc_sn(); ?></span>
                <span>期，剩余时间</span>
                <span class="fnTimeCountDown c1" data-end="2017/11/27 10:00:00">
                        <span class="hour"></span><i>:</i>
                        <span class="mini"></span><i>:</i>
                        <span class="sec"></span><i>:</i>
                        <span class="hm"></span>
                    </span>
            </p>

            <h6><input type="button" name="button" id="ten_button" value="余额不足，去充值" onclick="sell_now(&quot;ten&quot;);"></h6>
        </div>
<?php else: ?>
        <!--龙虎夺宝-->
        <div class="tab8" style="display: black;">
                <h2 id="lh_type">
                    <span style="width: 33.33%"><i data="long_<?php echo $goods['playlh']; ?>" class="ifocus">龙</i></span>
                    <span style="width: 33.33%"><i data="he_<?php echo $goods['playlh']; ?>">和</i></span>
                    <span style="width: 33.33%"><i data="hu_<?php echo $goods['playlh']; ?>">虎</i></span>
                </h2>
            <center>
                <p>选择购买数量</p>
                <h4 id="lh_num">
                    <span><i>5</i></span>
                    <span><i>10</i></span>
                    <span><i>20</i></span>
                </h4>
                <h5>
                    <span onclick="remove_num(&quot;lh&quot;);"><i>-</i></span>
                    <span class="input"><input type="text" id="lh_input_num" value="1" readonly="true" class="text"></span>
                    <span onclick="add_num(&quot;lh&quot;);"><i>+</i></span>
                </h5>
            </center>
            <p class="mon">
					<span class="fl">
						本次购买将支付：<span>￥</span><span id="lh_pay_money" class="c1"><?php echo $goods['play10']; ?></span>
						<br>我的账号余额：<span>￥</span><span class="c1 span_account_now"><?php echo $users['userMoney']; ?></span>
					</span>
                <span class="fr sm1">玩法说明</span>
            </p>

            <p class="mons">
                <span>你将购买第</span>
                <span class="c1"><?php echo ssc_sn(); ?></span>
                <span>期，剩余时间</span>
                <span class="fnTimeCountDown c1" data-end="2017/11/27 10:00:00">
                        <span class="hour"></span><i>:</i>
                        <span class="mini"></span><i>:</i>
                        <span class="sec"></span><i>:</i>
                        <span class="hm"></span>
                    </span>
            </p>

            <h6><input type="button" name="button" id="lh_button" value="余额不足，去充值" onclick="sell_now(&quot;lh&quot;);"></h6>
        </div>
<?php endif; ?>

    </div>
</div>


<div id="pay_success">
    <div class="md-content pay_success">
        <div class="pay_success_ok" style="text-align:center;"><img src="/static/drhome/images/ok.png"></div>
        <h2 style="text-align:center;">恭喜你，购卡成功</h2>
        <div class="pay_success_line"><span onclick="go_mylist();">查看订单</span></div>
        <div class="pay_success_line"><span class="s1" onclick="continue_shopping();">继续购买</span></div>
    </div>
</div>



<div id="goodcover"></div>
<script src="__STATIC__/drhome/js/popup.js"></script>
<script type="text/javascript">


    $(document).ready(function(){
        loadTab();//切换

        init_openlog_click();//load_openlog();
        $(".fnTimeCountDown").fnTimeCountDown("");
        /*双人夺宝*/
        $('#two_type i').click(function(){
            $('#two_type i').removeClass('ifocus');
            $(this).addClass('ifocus');
            
        });


        $('#two_num i').click(function(){
            $('#two_num i').removeClass('ifocus');
            $(this).addClass('ifocus');
            var num=$(this).html();
            $('#two_input_num').val(num);
            change_money_total('two');
            
        });


        /*四人夺宝*/
        $('#four_type i').click(function(){
            $('#four_type i').removeClass('ifocus');
            $(this).addClass('ifocus');
            

        });


        $('#four_num i').click(function(){
            $('#four_num i').removeClass('ifocus');
            $(this).addClass('ifocus');
            var num=$(this).html();
            $('#four_input_num').val(num);
            change_money_total('four');
        });

        /*十人夺宝*/
        $('#ten_type i').click(function(){
            var thisclass=$(this).attr('class');
            if(thisclass=='ifocus'){
                if($('#ten_type .ifocus').length==1){
                    return;
                };
                $(this).removeClass('ifocus');
            }else{
                $(this).addClass('ifocus');
            }
            change_money_total('ten');
            
        });


        $('#ten_num i').click(function(){
            $('#ten_num i').removeClass('ifocus');
            $(this).addClass('ifocus');
            var num=$(this).html();
            $('#ten_input_num').val(num);
            change_money_total('ten');
        });


        /*龙虎夺宝*/
        $('#lh_type i').click(function(){
            $('#lh_type i').removeClass('ifocus');
            $(this).addClass('ifocus');


        });


        $('#lh_num i').click(function(){
            $('#lh_num i').removeClass('ifocus');
            $(this).addClass('ifocus');
            var num=$(this).html();
            $('#lh_input_num').val(num);
            change_money_total('lh');
        });

        init_data();

    });

    function load_openlog(){
        var callback='callback_load_openlog(msg);';
        ajax_post(openlog_url,{},callback);
    }

    function callback_load_openlog(msg){

        msg = '';

        $('#openlog_div').html(msg);
        init_openlog_click();
    }

    function init_openlog_click(){
        //子导航展开收缩
        $(".sewvtop").click(function(){

            $(this).find("em").parents(".sewv").siblings().children(".sewvtop").find("em");
            $(this).next(".sewvbm").toggle().parents(".sewv").siblings().find(".sewvbm").hide();

            var currentclass=$(this).find("em").attr("class");

            if(currentclass=='lbaxztop2' || currentclass==''){
                $(this).find("em").removeClass('lbaxztop2').addClass('lbaxztop');
            }else{
                $(this).find("em").removeClass('lbaxztop').addClass('lbaxztop2');
            }
        });

    }

    function init_data(){
        $('#two_type i').eq(0).click();
        change_money_total('two');
        $('#four_type i').eq(0).click();
        change_money_total('four');
        $('#ten_type i').eq(0).click();
        change_money_total('ten');
        $('#lh_type i').eq(0).click();
        change_money_total('lh');
    }

    function remove_num(type){
        var current_num=parseInt($('#'+type+'_input_num').val());
        if(current_num<2){return false;}
        var new_num=current_num-1;
        $('#'+type+'_input_num').val(new_num);
        change_money_total(type);
    }

    function add_num(type){
        var current_num=parseInt($('#'+type+'_input_num').val());
        //if(current_num>19){return false;}
        var new_num=current_num+1;
        $('#'+type+'_input_num').val(new_num);
        change_money_total(type);
    }

    function change_money_total(type){
        var type_price=$('#'+type+'_type .ifocus').attr('data');
		if(!type_price) return;
        var num=$('#'+type+'_input_num ').val();
        var type_price_arr=type_price.split('_');
        var price=type_price_arr[1];
        var money=num*price;
        if(type=='ten'){
            var number_num=$('#ten_type .ifocus').length;
            money=money*number_num;
        }
        $('#'+type+'_pay_money').html(money);

        if(money>account_now){
            $('#'+type+'_button').val('余额不足，去充值');
        }else{
            $('#'+type+'_button').val('购买');
        }
    }

    function sell_now(type){
        if($('#'+type+'_button').val()=='购买中'){
            return false;
        }
        $('#'+type+'_button').val('购买中');


        var type_price=$('#'+type+'_type .ifocus').attr('data');
        var num=$('#'+type+'_input_num ').val();
        var type_price_arr=type_price.split('_');

        var price=type_price_arr[1];
        var money=num*price;
        if(type=='ten'){
            var number_num=$('#ten_type .ifocus').length;
            money=money*number_num;

        }
        $('#'+type+'_pay_money').html(money);

        if(money>account_now){
            window.location.href=chongzhi_url;
            return false;
        }

        var order_type=type_price_arr[0];
        var number='';
        if(type=='ten'){
            number=',';
            var number_obj=$('#ten_type .ifocus');
            $.each(number_obj,function(i,v){
                number+=$(this).attr('val')+',';
            });

            order_type = number;
        }

        var data={
            ordernum:num,
            sectionno:order_type,
            goodsId:goods_id,
            drtype:drtype
        };

        var callback='sell_now_callback(msg,"'+type+'",'+money+');';
        ajax_post(shopping_url,data,callback);

    }

    function sell_now_callback(msg,type,money){
        $('#'+type+'_button').val('购买');
        if(msg=='1'){
            account_now=account_now-money;
            $('.span_account_now').html(account_now);
            show_div('pay_success');
        }else{
            alert(msg);
        }
    }


    function show_div(id){
        $('#code').hide();
        $('#'+id).show();
    }
    function hidden_div(id){
        $('#'+id).hide();
        $('#goodcover').hide();
    }

    function go_mylist(){

        setTimeout(function () {

            window.location.href='<?php echo url("users/dingdan"); ?>';

        },2000);

    }

    function continue_shopping(){
        hidden_div('pay_success');
        change_money_total('two');
        change_money_total('four');
        change_money_total('ten');
    }

    


</script>








</body></html>