<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\users\list.html";i:1511747764;s:74:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\base.html";i:1508807744;}*/ ?>
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
	
   <div id="query" style="float:left;">
   		会员类型:
   		<select name="uq" id="uq" class="query" >
   			<option value="0">默认不选</option>
   			<?php if(is_array($userQuery) || $userQuery instanceof \think\Collection): $i = 0; $__LIST__ = $userQuery;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $vo['utype']; ?>"><?php echo $vo['rankName']; ?></option>
   			<?php endforeach; endif; else: echo "" ;endif; ?>
   			
   		</select>
   			
   		会员账号:<input type="text" name="loginName1"  placeholder='账号' id="loginName1" class="query" />
   		手机号码:<input type="text" name="loginPhone" placeholder='手机号码' id="loginPhone" class="query" />
   		
	   		
	   		<input type="button" class="btn btn-blue" onclick="javascript:userQuery()" value="查询">

            <div class="user_order">
               <a class="order0" href="javascript:initGrid('order',0);">默认排序</a>
               <a class="order1" href="javascript:initGrid('order',1);">账号金额</a>
               <a class="order2" href="javascript:initGrid('order',2);">投注金额</a>
               <a class="order3" href="javascript:initGrid('order',3);">中奖金额</a>
               <a class="order4" href="javascript:initGrid('order',4);">返点</a>
               <a class="order5" href="javascript:initGrid('order',5);">在线会员</a>
            </div>
	</div>

	<br><br>

   <?php if(WSTGrant('HYGL_01')): if(is_array($userQuery) || $userQuery instanceof \think\Collection): $i = 0; $__LIST__ = $userQuery;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['utype'] > $userinfos['uq'] || ($userinfos['uq'] == 103 &&  $vo['utype'] >= $userinfos['uq'])): ?>
	   		<button class="btn btn-green " style="margin-right:5px"  onclick="javascript:location.href='<?=url("users/toEdit",array('uq'=>$vo['utype']))?>'">新增<?php echo $vo['rankName']; ?>+</button>
         <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>


   <div style="clear:both"></div>
</div>
<div id="maingrid"></div>
<script>
  $(function(){initGrid(0)});
</script>


<script src="__ADMIN__/users/users.js?v=<?php echo $v; ?>" type="text/javascript"></script>

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