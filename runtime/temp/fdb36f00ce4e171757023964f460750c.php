<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\logmoney\list.html";i:1512350624;s:74:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\base.html";i:1508807744;}*/ ?>
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

<div class="l-loading" style="display: block" id="wst-loading"></div>
<div class="wst-toolbar">
类型：  <select name="targetType" id="targetType" class='j-ipt'>
			<option value="">请选择</option>
			<option value="0">下单</option>
			<option value="1">用户结单分红</option>
			<option value="9">用户结单手续费</option>
			<option value="6">提现</option>
			<option value="7">PK获胜兑换</option>
			<option value="8">PK获胜兑换手续费</option>
			<option value="10">代理商流水返佣</option>

		</select>
订单id：<input type="text" name="dataId" value="<?php echo !empty($orderId)?$orderId:''; ?>"  placeholder='订单id' id="dataId" class='j-ipt'/>

用户：<input type="text" name="userName" value="<?php echo !empty($uid)?$uid:''; ?>" placeholder='用户名称/id/手机/昵称' id="targetId" class='j-ipt'/>

时间：<input type="text" style="margin:0px;vertical-align:baseline;" id="stacerateTime" name="stacerateTime" class="j-ipt" maxLength="20"  />
      &nbsp;-&nbsp;
      <input type="text" style="margin:0px;vertical-align:baseline;" id="endcerateTime" name="endcerateTime" class="j-ipt" maxLength="20"  />&nbsp;&nbsp;

<button class="btn btn-blue" onclick='javascript:loadGrid(0)'>查询</button>
<div style='clear:both'></div>
</div>
<div id="maingrid"></div>

<script src="/static/date/jquery.datetimepicker.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<link href="/static/date/jquery.datetimepicker.css?v=<?php echo $v; ?>" rel="stylesheet">



<script>
$(function(){
	
	<?php if($uid || $orderId): ?> 
		//$('#maingrid').html('');
		initGrid(1);
	<?php else: ?>
		initGrid();
	<?php endif; ?>
})


//时间选择器
$('#stacerateTime').datetimepicker();
$('#endcerateTime').datetimepicker();



</script>


<script src="__ADMIN__/logmoney/logmoney.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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