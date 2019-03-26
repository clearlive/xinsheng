<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\main.html";i:1513040946;s:74:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\base.html";i:1508807744;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>后台管理中心 - <?php echo WSTConf('CONF.mallName'); ?></title>
<meta name="Keywords" content=""/>
<meta name="Description" content=""/> 
<link href="__ADMIN__/js/ligerui/skins/Aqua/css/ligerui-all.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" /> 
<link href="__STATIC__/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">

<link href="__ADMIN__/css/style.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />   
<script src="__STATIC__/js/jquery.min.js?v=<?php echo $v; ?>"></script>  
<script src="__ADMIN__/js/ligerui/js/ligerui.all.js?v=<?php echo $v; ?>" type="text/javascript"></script> 
<script type='text/javascript' src='__STATIC__/plugins/layer/layer.js?v=<?php echo $v; ?>'></script> 
<script src="__STATIC__/js/common.js?v=<?php echo $v; ?>"></script>
<script>
window.conf = {"ROOT":"__ROOT__","APP":"__APP__","STATIC":"__STATIC__","SUFFIX":"<?php echo config('url_html_suffix'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>",'GRANT':'<?php echo implode(",",session("WST_STAFF.privileges")); ?>'}
</script>
<script src="__ADMIN__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/jquery.validator.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="__STATIC__/plugins/validator/local/zh-CN.js?v=<?php echo $v; ?>"></script>
</head>
<body>

<div class="application-login-tips">
    <p>您好，<?php echo session('WST_STAFF.staffName'); ?>，欢迎使用 <?php echo WSTConf("CONF.mallName"); ?>。 您上次登录的时间是 <?php echo session('WST_STAFF.lastTime'); ?> ，IP 是 <?php echo session('WST_STAFF.lastIP'); ?></p>
</div>
<div id='application-version-tips' class='application-version-tips'>您有新的版本(<span id='application_version'>0.0.0</span>)可以下载啦~，<a id='application_down' href='' target='_blank'>点击</a>下载</div>
<div id='application-accredit-tips' class='application-accredit-tips'>系统检测到您未获取授权，点此<a target='_blank' href='http://www.application.net/index.php?c=License&a=index'>获取系统授权码</a></div>                
<table width='100%' border='0'>
   <tr>
     <td>
		<table class="wst-form wst-summary">
		  <tr>
		     <td class='wst-summary-head' colspan='4'>数据统计</td>
		  </tr>
		  <tr>
			 <td width="25%" align='right'>新增会员：</td>
			 <td width="25%"><?php echo $object['tody']['userType0']; ?></td>
			 <td width="25%" align='right'>总会员：</td>
			 <td><?php echo $object['tody']['userType1']; ?></td>
		  </tr>
		  <tr>
		     <td align='right'>今日入金：</td>
			 <td><?php echo $object['tody']['rech']; ?></td>
			 <td align='right'>总入金：</td>
		     <td><?php echo $object['tody']['allrech']; ?></td>
		  </tr>
		  <tr>
		     <td align='right'>今日出金：</td>
			 <td><?php echo $object['tody']['cash']; ?><span style='margin-left:25px;'>（待审核：<?php echo $object['tody']['shenhecash']; ?>）</span></td>
			 <td align='right'>总出金：</td>
		     <td><?php echo $object['tody']['allcash']; ?></td>
		  </tr>
		</table>

		<table class="wst-form wst-summary">
		  <tr>
		     <td class='wst-summary-head' colspan='4'>系统信息</td>
		  </tr>
		  
		 
		  <tr>
		     <td align='right'>服务器操作系统：</td>
			 <td><?php echo PHP_OS; ?></td>
			 <td align='right'>WEB服务器：</td>
		     <td ><?php echo \think\Request::instance()->server('SERVER_SOFTWARE'); ?></td>
		  </tr>
		  <tr>
		     <td align='right'>PHP版本：</td>
		     <td ><?php echo PHP_VERSION; ?></td>
			 <td align='right'>MYSQL版本：</td>
		     <td ><?php echo $object['MySQL_Version']; ?></td>
		  </tr>
		</table>
	</td>
	<td width='260' valign='top'>  
		
	</td>
	</tr>
</table>


<script src="__ADMIN__/js/main.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script>
function enterLicense(){
	location.href='<?php echo Url("admin/index/enterLicense"); ?>';
}
</script>

<script>
function showImg(opt){
	layer.photos(opt);
}
function showBox(opts){
	return WST.open(opts);
}

var uq = "<?php echo $userinfos['uq']; ?>";

</script>
</body>
</html>