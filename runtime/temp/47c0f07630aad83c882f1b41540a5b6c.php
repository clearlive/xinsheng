<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\index.html";i:1539605945;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
</style>
<div class="wrapper">


    <div class="gezx">
        <dl class="gface">
            <dd><a href="javascript:logout();" class="logout">退出 </a> <a href="<?php echo url('editPass'); ?>" class="logout">修改密码  |</a> </dd>
            <dd><img class="my_code" src="<?php echo $users['userPhoto']; ?>"></dd>
            <dd><?php echo $users['userName']; ?></dd>
            <dd>ID：<?php echo $users['userId']; ?></dd>
        </dl>
        <ul>
            <li style="background:none;width:50%"><p>累计获胜</p><p class="ff"><?php echo $users['allWin']; ?></p></li>
            <!-- <li><p>佣金</p><p class="ff"><?php echo $yongjin; ?></p></li> -->
            <li style="width:50%"><p>余额</p><p class="ff"><?php echo $users['userMoney']; ?></p></li>
        </ul>
        <div class="cz">
            <a href="<?php echo url('drrecharge'); ?>">充值</a>
            <a href="<?php echo url('drcash'); ?>">提现</a>
        </div>
        <div class="day">
            <div>今日参与：<?php echo $jinri['canyu']; ?></div>
            <div>今日获胜：<?php echo $jinri['win']; ?></div>
            <div>今日失败：<?php echo $jinri['loss']; ?></div>
        </div>

    </div>


    <div class="gclass">
        <a href="<?php echo url('dingdan',array('uid'=>$users['userId'])); ?>" class="g1">我的订单</a>
        <a href="<?php echo url('dingdan',array('uid'=>$users['userId'],'type'=>4)); ?>" class="g2">兑换记录</a>
        <a href="<?php echo url('kefu'); ?>" class="g3">联系客服</a>

    </div>
    <div class="gclass">
        <a href="<?php echo url('qianbao'); ?>" class="g4">我的钱包</a>
        <a href="<?php echo url('share'); ?>" class="g5">我要赚钱</a>
        <a href="<?php echo url('home/news/index',array('articleId'=>34)); ?>" class="g6">新手入门</a>
    </div>
    <div class="gclass">
       <a href="<?php echo url('myteam'); ?>" class="g7">我的团队</a> 
       <a href="<?php echo url('mall/index'); ?>" class="g10">折扣商城</a>
       <a href="<?php echo url('app'); ?>" class="g11">APP下载</a>
    </div>
</div>
<div class="sub">
    <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
    <div><a href="<?php echo url('index/kaijiang'); ?>" class="a2 a_2">助手</a></div>
    <!--<div><a href="<?php echo url('index/paihang'); ?>" class="a3 a_3">排行</a></div> -->
    <div><a href="<?php echo url('users/index'); ?>" class="a4 ">我的</a></div>
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