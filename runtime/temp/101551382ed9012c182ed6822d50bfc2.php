<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\center.html";i:1539597238;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>个人中心-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
.my_code{
	vertical-align: top;
    width: 20%;
    border: 10px solid #FFE;
    border-radius: 22px;
}
.sub div { 
    width:25% !important;
}
</style>

<div class="wrapper">


    <div class="gezx">
        <dl class="gface">
            <dd><a href="javascript:logout();" class="logout">退出 </a> <a href="<?php echo url('editPass'); ?>" class="logout">修改密码  |</a> </dd>
			<dd><img class="my_code" src="<?php echo $users['userPhoto']; ?>"></dd>
            <dd><?php echo $users['userName']; ?></dd>
            <dd>ID：<?php echo $users['userId']; ?></dd>
        </dl>
        <!-- <ul> -->
            <!-- <li style="background:none;width:50%"><p>累计获胜</p><p class="ff"><?php echo $users['allWin']; ?></p></li> -->
            <!-- <li><p>佣金</p><p class="ff"><?php echo $yongjin; ?></p></li> -->
            <!-- <li style="width:50%"><p>余额</p><p class="ff"><?php echo $users['userMoney']; ?></p></li> -->
        <!-- </ul> -->
        <div class="cz">
            <!-- <a href="<?php echo url('drrecharge'); ?>">充值</a>
            <a href="<?php echo url('drcash'); ?>">提现</a> -->
        </div>
        <!-- <div class="day">
            <div>今日参与：<?php echo $jinri['canyu']; ?></div>
            <div>今日获胜：<?php echo $jinri['win']; ?></div>
            <div>今日失败：<?php echo $jinri['loss']; ?></div>
        </div> -->

    </div>


    <div class="gclass">
        <a href="<?php echo url('mall/queryOrderList'); ?>" class="g1">我的订单</a>
        <a href="<?php echo url('mall/queryMallCart'); ?>" class="g2">购物车</a>
        <a href="javascript:;" class="g3">收货地址</a>

    </div>
    <div class="gclass">
        <a href="<?php echo url('qianbao'); ?>" class="g4">我的钱包</a>
        <!--<a href="<?php echo url('gzh'); ?>" class="g81">关注我</a> -->
        <a href="<?php echo url('index/index'); ?>" class="g9">抢购商城</a>
    </div>
   
</div>
<div class="sub">
        <div><a href="<?php echo url('mall/index'); ?>" class="a1 a_1">首页</a></div>
        <div><a href="<?php echo url('mall/queryOrderList'); ?>" class="a5 a_5">订单</a></div>
        <div><a href="<?php echo url('mall/queryMallCart'); ?>" class="a6 a_6">购物车</a></div> 
        <div><a href="<?php echo url('users/center'); ?>" class="a4">我的</a></div>
</div>


<script>
function logout(){
    if(confirm("退出？")){
        $.get("<?php echo url('logout'); ?>",function(){
            alert('已退出');
            window.location.href="<?php echo url('login'); ?>";
        })
    }
    

}
</script>


</body></html>