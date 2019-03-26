<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\drcash.html";i:1539414375;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>提现-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
        h1 { background:#f3f3f3; color:#db4141; font-size:230%; padding:40px 3%; } 
        h2 { margin:0 auto; padding-top:40px; font-size:250%; }
        h2 a { color:#3399ff; }
        h3 { background:#f3f3f3; font-size:230%; padding:40px 3%; margin-top:50px; } 
        h4 { font-size:230%; padding:50px 5% 10px 5%; width:90%; margin:0 auto; } 
        h4 input { border:0; border-bottom:1px solid #000; font-size:250%; width:73%; padding-left:7%; margin:0 10%; background:url(http://mall.mfchong.com/2012_images/qqq.png) no-repeat left center; background-size:30%; }
        h5 { font-size:200%; padding:20px 15% 10px 15%; width:70%; margin:0 auto; text-align:center;  }
        h6 { font-size:300%; padding:30px 0; width:70%; margin:50px 15% 10px 15%; text-align:center; color:#ffffff; background:#db4141; border-radius:30px; }
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
    
    .charge_type{width:96%;padding:2% 2% 4% 2%;margin-bottom:20px;color:#888;}
    .charge_type_selected{background:#bbeeff;border:1px solid #55aaff;color:#555;}
    .type_li{width:75%;float:left;padding-left:10%;}
    
    .charge_type_noadd{width:96%;padding:2% 2% 4% 2%;margin-bottom:20px;color:#aaa;}
    .info{
        font-size:200%;
        margin: 5% 2%;
        text-indent:4rem;
        letter-spacing:5px;
        color: #666;
    }
    
</style>


    <h1>到账方式：</h1>
        
     <!--   <?php if(!$user_alipay): ?>
        <div class='charge_type_noadd'>
                <div class='type_li'>
                    <h2>您还没有添加支付宝</h2>
                    <br><span style='font-size:200%;'>（提现到支付宝，手续费<?php echo $tx_fee; ?>元）</span>
                </div>
                <div style='width:15%;float:right;'>
                    <h2>
                    <a href="<?php echo url('alipay_add'); ?>">添加</a>
                    </h2>
                </div>
                <div style='clear:both;'></div>
        </div>

        <?php else: ?>

        <div class="charge_type charge_type_selected" data="alipay">
                <div class="type_li">
                    <h2><?php echo $user_alipay['accNo']; ?></h2>
                    <br><span style="font-size:200%;">（提现到支付宝，手续费<?php echo $tx_fee; ?>元）</span>
                </div>
                <div style="width:15%;float:right;">
                    <h2>
                    <a href="<?php echo url('alipay_add'); ?>">修改</a>
                    </h2>
                </div>
                <div style="clear:both;"></div>
        </div> 
        <?php endif; ?>	-->
        
        <?php if(!$user_bank): ?>
        <div class='charge_type_noadd'>
                <div class='type_li'>
                    <h2>您还没有添加银行卡</h2>
                    <br><span style='font-size:200%;'>（提现到银行卡，手续费<?php echo $tx_fee; ?>元）</span>
                    
                </div>
                <div style='width:15%;float:right;'>
                    <h2>
                    <a href="<?php echo url('bank_add'); ?>">添加</a>
                    </h2>
                </div>
                <div style='clear:both;'></div>
        </div>
        <?php else: ?>
        <div class='charge_type charge_type_selected' data="bank">
                <div class='type_li'>
                    <h2><?php echo $user_bank['accNo']; ?></h2>
                    <br><span style='font-size:200%;'>（提现到银行卡，手续费<?php echo $tx_fee; ?>元）</span>
                    
                </div>
                <div style='width:15%;float:right;'>
                    <h2>
                    <a href="<?php echo url('bank_add'); ?>">修改</a>
                    </h2>
                </div>
                <div style='clear:both;'></div>
        </div>
        <?php endif; ?>

    
            
    
    
    
    <div style='clear:both;'></div>
    
    <h1>提款金额：</h1>
    <h5>可用余额<span class="c1"><?php echo $users['userMoney']; ?></span>元</h5>
    <h4><input type="text" id="money" style='text-align:center;' <?php if($users['userMoney'] < $mincash): ?> disabled="ture" <?php endif; ?> onkeyup='fee();'></h4>
    <h5 style='color:#aaa;'>手续费：￥<span id="fee_money">0.00</span> &nbsp;&nbsp;&nbsp;&nbsp; 实际到账：￥<span id="get_money">0.00</span></h5>
    <h6 id='charge_button' onclick='charge_now();'>提款</h6>


    
    <div>
        <p class="info"><?php echo WSTConf("CONF.cash_info"); ?></p>
    </div>
    
    

    <div class="md-modal" id="pay_success">
        <div class="md-content pay_success">
            <div class="pay_success_ok" style='text-align:center;'><img src="__STATIC__/drhome/images/ok.png" /></div>
            <h2 style='text-align:center;'>提现申请成功</h2>
            <div class="pay_success_line"><span onclick='window.location.href="<?php echo url("getuserflowing"); ?>";'>账户明细</span></div>
            <div class="pay_success_line"><span class="s1" onclick='window.location.href="<?php echo url("index"); ?>";'>个人中心</span></div>
        </div>
    </div>
    <div id='zhezhao' class="md-overlay"></div>
    
    <script>
        var intDiff=0;
        var account_now='<?php echo $users['userMoney']; ?>';
        var have_bank="<?php echo !empty($user_bank)?$user_bank['id']:0; ?>";
        var have_alipay="<?php echo !empty($user_alipay)?$user_alipay['id']:0; ?>";
        var mincash = "<?php echo $mincash; ?>";
        var tx_fee = "<?php echo $tx_fee; ?>";
        tx_fee = tx_fee/100;
        var charge_url="<?php echo url('home/Cashdraws/drawMoney'); ?>";
        $('#money').focus();
        $('.charge_type').click(function(){
            $(this).addClass('charge_type_selected').siblings().removeClass('charge_type_selected');
            fee();
        });
        $('.charge_type').eq(0).click();
        
        function charge_now(){
            if(have_bank==0 && have_alipay==0){
                alert('请先完善你的提款银行卡或支付宝信息');
                return false;
            }
            var money=$('#money').val();
            var charge_type=$(".charge_type_selected").attr('data');
            if(charge_type!='alipay' && charge_type!='bank'){
                alert('请选择到账方式');
                return false;
            }

            if(charge_type == 'alipay'){
                charge_type = 0;
                accId = have_alipay;
            }
            

            if(charge_type == 'bank'){
                charge_type = 1;
                accId = have_bank;
            }

            if(money == '' || money*1 < mincash*1){
                alert('提现金额必须大于等于'+mincash+'元！');
                $('#money').focus();
                return false;
            }

            if(money*1 > account_now*1){
                alert('提现金额必须小于等于'+account_now+'元！');
                $('#money').focus();
                return false;
            }
            
            
            if($('#charge_button').html()=='操作中...'){
                return false;
            }
            $('#charge_button').html('操作中...');
            var data={
                
                money:money,
                accId:accId,
                charge_type:charge_type
            }

            
            $.post(charge_url,data,function(msg){
                $('#charge_button').html('提现');
                if(msg.status=='1'){
                    show_div('pay_success');
                }else{
                    alert(msg.msg);
                }
            });
            
        }
        
        function change_now_callback(msg){
            $('#charge_button').html('提现');
            if(msg=='1'){
                show_div('pay_success');
            }else{
                alert(msg);
            }
            
        }
        function show_div(id){
            
            $('#'+id).show();
        }
        function hidden_div(id){
            $('#'+id).hide();
            
        }
        
        function fee(){
            var money=$('#money').val();
            money = money.replace(/[^0-9.]/g,'');
            
            if(money==''){
                $('#money').val(money);
                $('#fee_money').html('0.00');
                $('#get_money').html('0.00');
                return;
            }
            var charge_type=$(".charge_type_selected").attr('data');
            if(charge_type!='alipay' && charge_type!='bank'){
                alert('请先选择到账方式');
            }
            if(charge_type=='bank'){
                var fee=tx_fee;
                fee=toDecimal(fee);
                var get=money-fee;
                get=toDecimal(get);
            }else if(charge_type=='alipay'){
                var fee=tx_fee;
                fee=toDecimal(fee);
                var get=money-fee;
                get=toDecimal(get);
            }
            if(get < 0) get = 0;
            $('#money').val(money);
            $('#fee_money').html(fee.toFixed(2));
            $('#get_money').html(get.toFixed(2));
        }
        
        function toDecimal(x) {    
            var f = parseFloat(x);    
            if (isNaN(f)) {    
                return '';    
            }    
            f = Math.round(x*100)/100;    
            return f;    
        }    
    </script>




	<div class="sub">
	    <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
	    <div><a href="<?php echo url('index/kaijiang'); ?>" class="a2 a_2">助手</a></div>
	    <div><a href="<?php echo url('index/paihang'); ?>" class="a3 a_3">排行</a></div>
	    <div><a href="<?php echo url('users/index'); ?>" class="a4 ">我的</a></div>
	</div>

</body></html>

