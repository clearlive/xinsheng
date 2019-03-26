<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:82:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\drorder\list.html";i:1551062232;s:74:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\base.html";i:1508807744;}*/ ?>
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




<br/>
订单编号：	<select name="isres" id="isres" class="j-ipt">
				<option value="0">默认不选</option>
				<option value="1">已兑换</option>
				<option value="2">未兑换</option>
			</select>&nbsp;&nbsp;

用户类型：	<select name="uq" id="uq" class="j-ipt">
				<option value="0">默认不选</option>
				<option value="101">运营中心</option>
				<option value="102">会员单位</option>
				<option value="103">代理商</option>
				<option value="104">客户</option>
			</select>&nbsp;&nbsp;

用户：<input type="text" name="userinfo"  placeholder='用户名称/id/手机/昵称' id="userinfo" class='j-ipt'/>&nbsp;&nbsp;

订单编号：<input type="text" name="orderNo"  placeholder='订单编号' id="orderNo" class='j-ipt'/>&nbsp;&nbsp;

时间：<input type="text" style="margin:0px;vertical-align:baseline;" id="stacerateTime" name="stacerateTime" class="j-ipt" maxLength="20"  />
      &nbsp;-&nbsp;
      <input type="text" style="margin:0px;vertical-align:baseline;" id="endcerateTime" name="endcerateTime" class="j-ipt" maxLength="20"  />&nbsp;&nbsp;

   <button class="btn btn-blue" onclick='javascript:loadGrid(0)'>查询</button>
	<span style="color:red"> 默认为早上7点到23点55分</span>
   <div style='clear:both'></div>

   <br>
   <div class="tongji">
   		<button class="btn btn-blue shuaxin_btn" onclick='javascript:shuaxin_btn(0)'>点击开始刷新</button>
		<span class="tjspan">总流水：<span class="liushui">...</span>元</span>
		<span class="tjspan">总手续费：<span class="shouxu">...</span>元</span>
		<span class="tjspan">总盈亏：<span class="yingkui">...</span>元</span>
		<span class="tjspan">总兑换：<span class="duihuan">...</span>元</span>
		<span class="tjspan">总未兑换：<span class="weiduihuan">...</span>元</span>
		<span class="tjspan">总盈：<span class="yingdan">...</span>元</span>
		<span class="tjspan">总输：<span class="shudan">...</span>元</span>
		<span class="tjspan">进行中：<span class="jinxing">...</span>元</span>
   </div>
   <br>
</div>
<div id="maingrid"></div>

<script src="/static/date/jquery.datetimepicker.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<link href="/static/date/jquery.datetimepicker.css?v=<?php echo $v; ?>" rel="stylesheet">
<script>

$(function(){initGrid();})
//时间选择器
$('#stacerateTime').datetimepicker();
$('#endcerateTime').datetimepicker();


var isshuaxin = 0;
var sxd;
// if(isshuaxin == 1){
// 	var sxd = setInterval('shuaxin()', 20000);
// }

</script>


<script src="__ADMIN__/drorder/drorder.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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