<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\regist.html";i:1539411945;s:78:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\base.html";i:1511845378;}*/ ?>
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
.timeTips {
    float: right;
    margin-top: -1.2rem;
    font-size: 0.2rem;
    background: #fff;
    color: #000;
    padding: 0.1rem;
    border: 0;
    border-radius: 0.2rem;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button{
	-webkit-appearance: none !important;
	margin: 0;
}
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






<div class="m-simpleHeader" id="dvHeader">
    <a href="javascript:history.back(-1);" data-pro="back" data-back="true" class="m-simpleHeader-back"><i style="color:red" class="ico ico-back"></i></a>
    <h1 style="color:red">用户注册</h1>
</div>
<div class="m-login">


    <div class="m-login-tips" id="tips"></div>
	
	<form id="reg_form"  method="post" autocomplete="off">

    <div class="zzanniu">
		<div class="m-login-form w-form">
			<div class="w-form-item m-login-form-account w-inputBar w-bar">
				<div class="w-bar-label">
					<i class="iconfont"></i>
				</div>
				<a data-pro="clear" href="javascript:void(0);" class="w-bar-input-clear">×</a>
				<div class="w-bar-control">
					<input placeholder="手机号" autocapitalize="off" data-pro="input" class="w-bar-input" type="number"  max="11" oninput="if(value.length>11) value=value.slice(0,11)" name="loginName" value="" id="loginName">
				</div>
			</div>


			<!--<div class="w-form-item m-login-form-account w-inputBar w-bar">
				<div class="w-bar-label"><i class="iconfont"></i></div>
				<a data-pro="clear" href="javascript:void(0);" class="w-bar-input-clear">×</a>
				<div class="w-bar-control">

				<input placeholder="请输入手机验证码" autocapitalize="off" id="mobileCode" data-pro="input" class="w-bar-input" type="text" name="mobileCode" style="width:50%;" value="">

				<div class="login_pwd">
			        <button id="timeTips" onclick="getPhoneVerifyCode();return false;"  class="wst-regist-obtain timeTips">获取短信验证码</button>    
			    </div>

				</div></div> -->
			
			


		


			<div class="w-form-item m-login-form-account w-inputBar w-bar">
				<div class="w-bar-label">
					<i class="iconfont"></i>
				</div>
				<a data-pro="clear" href="javascript:void(0);" class="w-bar-input-clear">×</a>
				<div class="w-bar-control">
					<input placeholder="姓名" autocapitalize="off" data-pro="input" class="w-bar-input" type="text" name="userName" value="" id="userName">
				</div>
			</div>
			<div class="w-form-item m-login-form-password w-inputBar w-bar">
				<div class="w-bar-label">
					<i class="iconfont"></i>
				</div>
				<a data-pro="clear" href="javascript:void(0);" class="w-bar-input-clear">×</a>
				<div class="w-bar-control">
					<input placeholder="请输入密码" autocapitalize="off" data-pro="input" class="w-bar-input" type="loginPwd" name="mima" value="" id="loginPwd">
				</div>
			</div>
			<div class="w-form-item m-login-form-password w-inputBar w-bar">
				<div class="w-bar-label">
					<i class="iconfont"></i>
				</div>
				<a data-pro="clear" href="javascript:void(0);" class="w-bar-input-clear">×</a>
				<div class="w-bar-control">
					<input placeholder="确认密码" autocapitalize="off" data-pro="input" class="w-bar-input" type="reUserPwd" name="mima" value="" id="reUserPwd">
				</div>
			</div>


			<div class="w-form-item m-login-form-account w-inputBar w-bar">
				<div class="w-bar-label">
					<i class="iconfont"></i>
				</div>
				<a data-pro="clear" href="javascript:void(0);" class="w-bar-input-clear">×</a>
				<div class="w-bar-control">
					<input placeholder="邀请码" autocapitalize="off" data-pro="input" class="w-bar-input" type="text" <?php if($usercode): ?> disabled="true" <?php endif; ?> name="usercode" value="<?php echo $usercode; ?>" id="usercode">
				</div>
			</div>

			
			
			<input type="hidden" name="nameType" id="nameType" class="w-bar-input" value="3">


			<div class="m-login-menu" id="autoCmpl" style="display:none;">
			</div>



		</div>
		<div class="m-login-tips-bottom" id="tipsBottom">
		</div>
		<div class="m-login-submit">
			<button class="w-button w-button-main" data-pro="submit" onclick="initRegist();return false" id="btnLogin">注册</button>
		</div>
		<div class="m-login-link">
			<a href="<?php echo url('Users/login'); ?>" id="aReg">马上登录</a>
			<!-- <a href="<?php echo url('Users/findPassword'); ?>" id="aForget" class="aside">忘记密码？</a> -->
		</div>
	</div>
	
	</form>




</div>




<button class="w-button w-button-round w-button-backToTop" style="display:none;" id="backToTop" onclick="window.scrollTo(0, 0);">返回顶部</button>










<script type="text/javascript">
	getVerify = function(img){
		$(img).attr('src',WST.U('admin/index/getVerify','rnd='+Math.random()));
	}


function initRegist(isres){
			var reg = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
			var phone=$('input[name=loginName]').val();
			if(!reg.test(phone)){
				layer.msg('手机号错误')
				return;
			}
	        var params = WST.getParams('.w-bar-input');
	        
	        var url = WST.U('home/users/toRegist');
	        $.post(url,params,function(data,textStatus){
	    		var json = WST.toJson(data);
	    		if(json.status>0){
	    			WST.msg('注册成功', {icon: 6}, function(){
	    				location.href=WST.U('home/mall/index');
	       			});
	    		}else{
	    			
	    			WST.getVerify('#verifyImg');
	    			WST.msg(json.msg, {icon: 5});
	    		}
	    		
	    	});
	  
}

var isSend = 1;

function getPhoneVerifyCode(){
	if(isSend == 0){
		layer.msg('请稍后...');
		return;
	}
	isSend = 0;
	var params = 'userPhone='+$('#loginName').val();
	layer.msg('正在发送短信，请稍后...',{time:600000});
	$.post(WST.U('home/users/getPhoneVerifyCode'),params,function(data,textStatus){
		var json = WST.toJson(data);
		console.log(json);
		if(json.status!=1){
			WST.msg(json.msg, {icon: 5});
			time = 0;
			isSend = false;
		}if(json.status==1){
			WST.msg('短信已发送，请注册查收');
			time = 120;
			$('#timeTips').css('width','100px');
			$('#timeTips').html('获取验证码120');
			$('#mobileCode').val(json.phoneVerifyCode);
			var task = setInterval(function(){
				time--;
				$('#timeTips').html('获取验证码'+time+"");
				if(time<=0){
					isSend = 1;						
					clearInterval(task);
					$('#timeTips').html("重新获取验证码");
				}
			},1000);
		}
	});
}

</script>



