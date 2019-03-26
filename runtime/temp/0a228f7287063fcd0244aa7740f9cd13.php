<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:84:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\user_login.html";i:1539605806;s:78:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\base.html";i:1511845378;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>用户登录-<?php echo WSTConf('CONF.mallName'); ?><?php echo WSTConf('CONF.mallTitle'); ?></title>




<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"> 
<meta name = "format-detection" content = "telephone=no">


<style>
html{
    max-width: 640px;
    margin: 0px auto;
}
</style>
   
<!--css-->
<link rel="stylesheet" href="__STATIC__/drhome/css/common.css">
<link rel="stylesheet" href="__STATIC__/drhome/css/style.css">



<!--css-->


<link rel="stylesheet" href="__STATIC__/drhome/css/user_login.css">
<link rel="stylesheet" href="__STATIC__/drhome/css/login.css">
<style type="text/css">

</style>



<script type="text/javascript" src="__STATIC__/drhome/js/jquery.js?v=<?php echo $v; ?>"></script>

<!--js-->

<script type="text/javascript" src="__STATIC__/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/layer/layer.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='__STATIC__/js/common.js?v=<?php echo $v; ?>'></script>

<!--js-->


<script type='text/javascript' src='__STYLE__/js/common.js?v=<?php echo $v; ?>'></script>

<script>

window.conf = {
		"ROOT"      : "__ROOT__", 
		"APP"       : "__APP__", 
		"STATIC"    : "__STATIC__", 
		"SUFFIX"    : "<?php echo config('url_html_suffix'); ?>", 
		"SMS_VERFY" : "<?php echo WSTConf('CONF.smsVerfy'); ?>",
    	"SMS_OPEN"  : "<?php echo WSTConf('CONF.smsOpen'); ?>",
    	"GOODS_LOGO": "<?php echo WSTConf('CONF.goodsLogo'); ?>",
    	"SHOP_LOGO" : "<?php echo WSTConf('CONF.shopLogo'); ?>",
    	"MALL_LOGO" : "<?php echo WSTConf('CONF.mallLogo'); ?>",
    	"USER_LOGO" : "<?php echo WSTConf('CONF.userLogo'); ?>",
    	"IS_LOGIN"  : "<?php if((int)session('WST_USER.userId')>0): ?>1<?php else: ?>0<?php endif; ?>",
    	"TIME_TASK" : "1"
	}

</script>


</head>


<body>






<!-- <div class="m-simpleHeader" id="dvHeader">
    <a href="javascript:history.back(-1);" data-pro="back" data-back="true" class="m-simpleHeader-back"><i style="color:red" class="ico ico-back"></i></a>
    <h1 style="color:red">用户登录</h1>
</div> -->
<div class="m-login">


    <div class="m-login-tips" id="tips">
		<img style="margin: 0 auto; width: 60%;" src="__STATIC__/static/mallImg/login.png" alt="" srcset="">
	</div>
	

    <div class="zzanniu">
		<div class="m-login-form w-form">
			<div class="w-form-item m-login-form-account w-inputBar w-bar">
				<div class="w-bar-label">
					<i class="iconfont"></i>
				</div>
				<a data-pro="clear" href="javascript:void(0);" class="w-bar-input-clear">×</a>
				<div class="w-bar-control">
					<input placeholder="帐号登录" autocapitalize="off" data-pro="input" class="w-bar-input" type="text" name="zhanghao" value="" id="loginName">
				</div>
			</div>
			<div class="w-form-item m-login-form-password w-inputBar w-bar">
				<div class="w-bar-label">
					<i class="iconfont"></i>
				</div>
				<a data-pro="clear" href="javascript:void(0);" class="w-bar-input-clear">×</a>
				<div class="w-bar-control">
					<input placeholder="请输入密码" autocapitalize="off" data-pro="input" class="w-bar-input" type="password" name="mima" value="" id="loginPwd">
				</div>
			</div>
			<div class="m-login-menu" id="autoCmpl" style="display:none;">
			</div>
		</div>
		<div class="m-login-tips-bottom" id="tipsBottom">
		</div>
		<div class="m-login-submit">
			<button class="w-button w-button-main" data-pro="submit" onclick="frmsubmit()" id="btnLogin">登 录</button>
		</div>
		<div class="m-login-link">
			<a href="<?php echo url('Users/regist'); ?>" id="aReg">马上注册</a>
			<a href="<?php echo url('Users/editPass'); ?>" id="regist" class="aside">忘记密码？</a>
		</div>
	</div>





</div>




<button class="w-button w-button-round w-button-backToTop" style="display:none;" id="backToTop" onclick="window.scrollTo(0, 0);">返回顶部</button>









<script type="text/javascript">
	

	
	

		 $(function(){
	        $("input").focus(function(){
	            $("h4").html("");
	        });
	        var s = $("#msg").val();
	        if(s != "" && s == 2){
	        	alert("账号被冻结,请联系管理员");
	        }
	        if(s != "" && s == 3){
	        	alert("账号或密码输入错误");
	        }
	    })

	    //点击登录
	    function frmsubmit()
			{

				if(document.getElementById('loginName').value.length==0 )
				{
					alert('您需要完整填写用户名');
					//$("#uidspan").html("<font color='red' size='4px'>您需要完整填写用户名!</font>");
					return;
				}
				if(document.getElementById('loginPwd').value.length==0 )
				{
					alert('您需要完整填写密码');
					//$("#upwdspan").html("<font color='red' size='4px'>您需要完整填写密码!</font>");
					return;  
				}
				var remember = $("#remember").is(":checked");

				
				var params = WST.getParams('.w-bar-input');
				var typ = 1;
				params.typ = typ; 
				var ll = WST.msg('正在处理数据，请稍后...',{time:600000});
				$.post(WST.U('home/users/checkLogin'),params,function(data,textStatus){
					var json = WST.toJson(data);
				
					if(json.status=='1'){
						if(typ==2){
							location.href=WST.U('home/shops/index');
						}else if(typ==1){
							location.href=WST.U('home/mall/index');
						}else{
							parent.location.reload();
						}
					}else{
						layer.close(ll);
						WST.msg(json.msg, {icon: 5});
						WST.getVerify('#verifyImg');
					}
					
				});
				return true;
				
			}
	    
	   /*  function success(){
	        if(frmtel('#login_phone')&&frmpwd('#login_mima')){
	            window.location.href="index.html";
	        }
	    } */
	    
	    $(document).on('focus','input',function(e){
	    	$("#upwdspan").html("");	
	    	$("#uidspan").html("");
	    });

	


</script>



