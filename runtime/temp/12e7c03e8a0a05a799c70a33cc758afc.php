<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:90:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\drrecharge.html";i:1539578707;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>充值-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
    h1 { background:#f3f3f3; color:#db4141; font-size:230%; padding:30px 3%; }
    h3 { background:#f3f3f3; font-size:230%; padding:30px 3%; margin-top:50px; }
    h2 { width:800px; margin:0 auto; padding-top:10px; }
    h2 div { float:left; display:block;  margin:0 25px; background:#ffffff; font-size:230%;  height:100px; line-height:100px; margin-top:40px;  border-radius:10px; }
    h2 input {  width:198px; text-align:center; border-radius:0;   }


    ul.ui-choose { box-sizing: border-box; display: inline-block; border: 1px solid transparent; }
    li { float:left; display:block; width:208px; text-align:center; margin:0 25px; background:#ffffff;  border:1px solid #e1e1e1; font-size:230%;height:100px; line-height:100px; margin-top:40px;  border-radius:10px;  }
    .selected_li{ border:1px solid red;}
    h4 { font-size:230%; padding:10px 5%; width:90%; }
    h4 dl { width:100%;  border-bottom:1px solid #e3e3e3; padding:30px 0 30px 0; }


    .paytype_selected{
        background:url(__STATIC__/drhome/images/d2.png) no-repeat right center;
        background-size:10%;
    }

    .paytype_normal{
        background:url(__STATIC__/drhome/images/d1.png) no-repeat right center;
        background-size:10%;
    }


    h4 dl dt { width:15%; }
    h4 dl dt img { width:80%; border-radius:20px; }
    h4 dl dd { width:85%; padding-top:10px; }
    h4 dl dd p { font-size:100%; padding:5px 0 10px 0; }
    h4 dl dd blockquote { font-size:90%; color:#bababa; }

    .zff { width:100%; color:#ffffff; height:160px; line-height:160px; background:#db4141; font-size:300%; margin:0 auto; text-align:center; position:fixed; bottom:0;  }
    .pay_success { padding-bottom:100px; float:left; }
    .pay_success div { padding-top:0; width:100%; float:left; }
    .pay_success .pay_success_ok { padding:60px 0 10px 0; }
    .pay_success h2 { color:#7ed224; font-size:150%; padding-bottom:50px; }
    .pay_success .pay_success_line { padding-bottom:10px; text-align:center; float:left; width:100%; height:90px; line-height:90px; margin-top:40px; }
    .pay_success .pay_success_line span { border:1px solid #e34044; background:#ffffff; color:#e34044; padding:30px 100px; border-radius:15px; font-size:110%; }
    .pay_success .pay_success_line span.s1 { border:1px solid #e34044; background:#e34044; color:#ffffff; }

    .info{
        font-size:200%;
        margin: 5% 2%;
        text-indent:4rem;
        letter-spacing:5px;
        color: #666;
    }
</style>


<h1>选择充值金额</h1>
<h2>
    <ul class="ui-choose" id="uc_01">
        <?php if(is_array($rech_jianyi) || $rech_jianyi instanceof \think\Collection): $key = 0; $__LIST__ = $rech_jianyi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
        <li data="<?php echo $vo; ?>" <?php if($key == 1): ?> class="selected_li" <?php endif; ?> ><?php echo $vo; ?></li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <!-- <li data="auto"><input id="money_auto" type="text" value="其他金额" maxlength="8" onfocus="if (value ==&#39;其他金额&#39;){value =&#39;&#39;}" onblur="check_auto_money();"></li> -->
    </ul>
</h2>

<h3 style="display: none">支付方式选择</h3>
<h4 style="display: none">


    <?php if(is_array($payment) || $payment instanceof \think\Collection): $i = 0; $__LIST__ = $payment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;$voo = $vo['Configs'];foreach($voo as $kk=>$vv){if($vv != 0 &&  ( strstr($kk,'alipay') || strstr($kk,'alipaycode') || strstr($kk,'wxpay') ||  strstr($kk,'wxpaycode') || strstr($kk,'qqpay') || strstr($kk,'qqpaycode') || strstr($kk,'kjpay') || strstr($kk,'ylpay') )): ?>
        <dl class="paytype paytype_selected" data="<?php echo $kk; ?>">
            
                <?php if(strstr($kk,'alipay')): ?>
                    <dt><img src="__STATIC__/drhome/images/zfb.png"></dt>
                    <dd><p><?php echo $vo['payName']; ?>-宝支付</p><blockquote>使用支付宝支付</blockquote>
                <?php elseif(strstr($kk,'wxpay')): ?>
                    <dt><img src="__STATIC__/drhome/images/weixin.png"></dt>
                    <dd><p><?php echo $vo['payName']; ?>-微信</p><blockquote>使用支付微信</blockquote>
                <?php elseif(strstr($kk,'qqpay')): ?>
                    <dt><img src="__STATIC__/drhome/images/qq.png"></dt>
                    <dd><p><?php echo $vo['payName']; ?>-QQ</p><blockquote>使用支付QQ</blockquote>
                <?php elseif(strstr($kk,'alipaycode')): ?>
                    <dt><img src="__STATIC__/drhome/images/zfb.png"></dt>
                    <dd><p><?php echo $vo['payName']; ?>-宝支付扫码</p><blockquote>使用支付宝支付扫码</blockquote>
                <?php elseif(strstr($kk,'wxpaycode')): ?>
                    <dt><img src="__STATIC__/drhome/images/weixin.png"></dt>
                    <dd><p><?php echo $vo['payName']; ?>-微信扫码</p><blockquote>使用支付微信扫码</blockquote>
                <?php elseif(strstr($kk,'qqpaycode')): ?>
                    <dt><img src="__STATIC__/drhome/images/qq.png"></dt>
                    <dd><p><?php echo $vo['payName']; ?>-QQ扫码</p><blockquote>使用支付QQ扫码</blockquote>
                <?php elseif(strstr($kk,'kjpay')): ?>
                    <dt><img src="__STATIC__/drhome/images/kuaijie.png"></dt>
                    <dd><p><?php echo $vo['payName']; ?>-快捷</p><blockquote>使用支付快捷</blockquote>
                <?php elseif(strstr($kk,'ylpay')): ?>
                <dt><img src="__STATIC__/drhome/images/yinlian.png"></dt>
                    <dd><p><?php echo $vo['payName']; ?>-银联</p><blockquote>使用支付银联</blockquote>
                <?php endif; ?>
            </dd>
        </dl>
    <?php endif; }endforeach; endif; else: echo "" ;endif; ?>
    
</h4>

<div>
        <p class="info"><?php echo WSTConf("CONF.rechage_info"); ?></p>
    </div>
<div class="zff"  style="max-width: 1024px;" id="chongzhi_button" onclick="chongzhi_now();">立即充值</div>


<div id="zhezhao" class="md-overlay"></div>

<script>
    var auto_money='0.01';
    var money='100';
    var paytype='alipay';
    var account_add_action_url='http://pay.mfchong.com/pay/index.php?routeurl=pay-juci-action&user_id=8953';

    var account_mylist_url='https://mall.mfchong.com/index.php?routeurl=user-account-mylist';

    $('#uc_01 li').click(
        function(){
            $('#uc_01 li').removeClass('selected_li');
            $(this).addClass('selected_li');
            money=$(this).attr('data');
            if(money!='auto'){
                $('#money_auto').val('其他金额');

            }
        }
    );

    $('.paytype').click(
        function(){
            $('.paytype').removeClass('paytype_selected').addClass('paytype_normal');
            $(this).removeClass('paytype_normal').addClass('paytype_selected');
            paytype=$(this).attr('data');
        }
    );

    $('#uc_01 li').eq(0).click();
    $('.paytype').eq(0).click();

    function check_auto_money(){
        var money_auto=$('#money_auto').val();
        if (money_auto ==''){$('#money_auto').val('其他金额');}

       
    }

    function chongzhi_now(){
        if(money=='auto'){
            money=$('#money_auto').val();
            if(!checkit('money',money)){
                $('#money_auto').val(auto_money);
                money=auto_money;
            }
            if(money%10=='0'){
                alert('尊敬的用户，请勿整数充值，请重新选择金额，如充值：'+(parseInt(money)+2)+'元');
                return;
            }
        }

		if(paytype){
			// window.location.href="/home/users/addpaybdyf"+'?'+param;
            window.location.href="pay.html?total_fee="+money;

			return;
		}
            // window.location.href='pay/pay.php?total_fee='+money;
        // window.location.href= ('pay.php?y=pay&jine='+ money + '&paytype='+ 0);
        // $.post("<?php echo url('addpay'); ?>",param,function(res){
        //     //console.log(res);
        //     if(res.status == -1){
        //         alert(res.msg);
        //     }else{
        //         if(res.msg == 1){
        //             //console.log(res.data);
        //             location.href = res.data;
        //         }
        //     }
        // })

    }

    function chongzhi_now_callback(msg){
        //alert(msg);
        //alert(msg);
        if(msg=='来源错误' || msg=='充值金额错误' || msg=='系统繁忙'){
            alert(msg);
            huanyuan();
            return false;
        }

        //window.location.href=msg;
        //return;
        var weixin_data=eval(msg);
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest', weixin_data,
            function(res){
                if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                    show_div('pay_success');
                    huanyuan();
                }else{
                    huanyuan();
                }
            }
        );
    }

    function huanyuan(){
        $('#chongzhi_button').html('立即充值');
    }
    function show_div(id){
        $('#zhezhao').css('visibility','visible').css('opacity','9');
        $('#'+id).css('visibility','visible');
    }
    function hidden_div(id){
        $('#'+id).css('visibility','hidden');
        $('#zhezhao').css('visibility','hidden').css('opacity','0');
    }

    function go_mylist(){
        window.location.href=account_mylist_url;
    }

    function continue_chongzhi(){
        hidden_div('pay_success');
    }

</script>
</body></html>