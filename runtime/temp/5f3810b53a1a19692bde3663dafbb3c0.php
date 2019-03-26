<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\users\edit.html";i:1513907837;s:74:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/admin\view\base.html";i:1508807744;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__STATIC__/plugins/webuploader/webuploader.css?v=<?php echo $v; ?>" />

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
<form id="userForm" autocomplete="off" >
<table class='wst-form wst-box-top'>
  <tr>

<?php if(((int)$data['userId']>0)): ?>
 
<tr>
    <th>上级关系<font color='red'>*</font>：</th>
    <td>
        <?php echo $myups; ?>
    </td>
 </tr>
      
          
<?php endif; ?>

      <th width='150'>账号<font color='red'>*</font>：</th>


          <td width='370'>
            <?php if(($data['userId']>0)): ?>
              <?php echo $data['loginName']; else: ?>
              <input type="text" class="ipt" id="loginName" name="loginName"  />
            <?php endif; ?>
              
          </td>
          <td rowspan="5">
            <div id="preview" >
                <img src="<?php if($data['userPhoto']==''): ?>/<?php echo WSTConf('CONF.userLogo'); else: ?><?php echo $data['userPhoto']; endif; ?>"  height="150" />
            </div>
            <div id='adFilePicker' style="margin-left:40px;">上传头像</div>
            <input type="hidden" id="userPhoto" class="ipt" />
            <span id='uploadMsg'></span>

          </td>
       </tr>
       <?php if(((int)$data['userId']==0) ||  $userinfos['uq'] == 0): ?>
         <tr>
          <?php if(((int)$data['userId']==0)): ?>
            <th>密码<font color='red'>*</font>：</th>
            <td><input type="password" id='loginPwd' class='ipt' maxLength='20' value='' data-rule="登录密码: required;length[6~20]" data-target="#msg_loginPwd"/></td>
          <?php else: ?>
            <th>密码：</th>
            <td><input type="password" id='loginPwd' class='ipt' maxLength='20' value='' /></td>
          <?php endif; ?>
         </tr>
       
       <tr>
          <th>用户名<font color='red'>*</font>：</th>
          <td>
              <input type="text" class="ipt" id="userName" name="userName" value="<?php echo $data['userName']; ?>" />
          </td>
       </tr>
    <?php endif; ?>
       
          <tr>
            <th>身份<font color='red'>*</font>：</th>
            <td>
            <?php if(((int)$data['userId']==0)): ?>
                <input type="hidden" class="ipt" id="uq" name="uq" value="<?php echo $uq; ?>">
                <?php if(is_array($userQuery) || $userQuery instanceof \think\Collection): $i = 0; $__LIST__ = $userQuery;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($uq == $vo['utype']): ?>
                <p><?php echo $vo['rankName']; ?></p>
                <?php endif; endforeach; endif; else: echo "" ;endif; else: ?>
              <p><?php echo getquname($data['uq']); ?></p>
            
            <?php endif; ?>
            </td>
         </tr>
<?php if(((int)$data['userId']==0) && $userinfos['uq'] == 0): ?>
          <tr>
            <th>选择归属<font color='red'>*</font>：</th>
            <td>
              
                <?php if(in_array($uq,array(USERTYPE2,USERTYPE3,USERTYPE4))): ?>
                <select class="ipt" name="par101" id="par101">
                  <option value="">请选择<?php echo $userQuery[3]['rankName']; ?></option>
                  <?php if(is_array($userlist) || $userlist instanceof \think\Collection): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $vo['userId']; ?>"><?php echo $vo['userName']; ?></option>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <?php endif; if(in_array($uq,array(USERTYPE3,USERTYPE4))): ?>
                <select class="ipt" name="par102" id="par102">
                  <option value="">请选择<?php echo $userQuery[2]['rankName']; ?></option>
                </select>
                <?php endif; if(in_array($uq,array(USERTYPE4))): ?>
                <select class="ipt" name="par103" id="par103">
                  <option value="">请选择<?php echo $userQuery[1]['rankName']; ?></option>
                </select>
                <?php endif; if(in_array($uq,array(USERTYPE1))): ?>
                <p>归属平台</p>
                <?php endif; ?>

            </td>
         </tr>

         

<?php else: if(((int)$data['userId']==0) && $userinfos['uq'] == 101): ?>
<tr>
    <th>选择归属<font color='red'>*</font>：</th>
    <td>
      
      <select class="ipt" name="par101" id="par101">
        <option value="">请选择<?php echo $userQuery[3]['rankName']; ?></option>
        <option value="<?php echo $userinfos['userId']; ?>"><?php echo $userinfos['userName']; ?></option>
      </select>

      <?php if(in_array($uq,array(USERTYPE3,USERTYPE4))): ?>
      <select class="ipt" name="par102" id="par102">
        <option value="">请选择<?php echo $userQuery[2]['rankName']; ?></option>
      </select>
      <?php endif; if(in_array($uq,array(USERTYPE4))): ?>
      <select class="ipt" name="par103" id="par103">
        <option value="">请选择<?php echo $userQuery[1]['rankName']; ?></option>
      </select>
      <?php endif; ?>

  </td>
</tr>

<?php endif; if(((int)$data['userId']==0) &&  $userinfos['uq'] == 102): ?>
<tr>
    <th>选择归属<font color='red'>*</font>：</th>
    <td>
      
      <select class="ipt" name="par102" id="par102">
        <option value="">请选择<?php echo $userQuery[2]['rankName']; ?></option>
        <option value="<?php echo $userinfos['userId']; ?>"><?php echo $userinfos['userName']; ?></option>
      </select>



      <?php if(in_array($uq,array(USERTYPE4))): ?>
      <select class="ipt" name="par103" id="par103">
        <option value="">请选择<?php echo $userQuery[1]['rankName']; ?></option>
      </select>
      <?php endif; ?>

  </td>
</tr>

<?php endif; if(((int)$data['userId']==0) ||  $userinfos['uq'] == 0): ?>
<tr>
          <th>状态<font color='red'>*</font>：</th>
          <td>
            <label><input type="radio" class="ipt" id="userStatus" name="userStatus" <?=($data['userStatus']==1)?'checked':'';?> value="1" />启用</label>
            <label><input type="radio" class="ipt" id="userStatus" name="userStatus" <?=($data['userStatus']==2)?'checked':'';?> value="2" />停用</label>
          </td>
       </tr>
 <?php endif; endif; if(($data['uq'] == 104 || $data['uq'] == 103)): ?>
    <tr>
        <th>类型<font color='red'>*</font>：</th>
        <td>
            <label><input type="radio" class="ipt" id="uq" name="uq" <?=($data['uq']==103)?'checked':'';?> value="103" />代理商</label>
            <label><input type="radio" class="ipt" id="uq" name="uq" <?=($data['uq']==104)?'checked':'';?> value="104" />客户</label>
        </td>
    </tr>
    <?php endif; if(((int)$data['userId']==0) ||  $userinfos['uq'] == 0): ?>
       <tr>
          <th>手机号码<font color='red'>*</font>：</th>
          <td>
              <input type="text" class="ipt" id="userPhone" name="userPhone" value="<?php echo $data['userPhone']; ?>" />
          </td>
       </tr>

      <?php if(((int)$userinfos['uq']==0)): ?>
       <!-- <tr>
          <th>会员余额：</th>
          <td>
              <input type="text" class="ipt" id="userMoney" name="userMoney" value="<?php echo $data['userMoney']; ?>" />
          </td>
       </tr> -->
      <?php endif; if($uq == 101 || $data['uq'] == 101 || $uq == 102 || $data['uq'] == 102): ?>
      <tr>
          <th>保证金：</th>
          <td>
              <input type="text" class="ipt" id="minMoney" name="minMoney" value="<?php echo $data['minMoney']; ?>" />
          </td>
       </tr>
      <?php endif; ?>
       
       <!-- <tr>
          <th>会员积分：</th>
          <td>
              <input type="text" class="ipt" id="userScore" name="userScore" value="<?php echo $data['userScore']; ?>" />
          </td>
       </tr> -->
 <?php endif; if((isset($data['uq']) && ( $data['uq'] != 104) && $userinfos['userId'] != $data['userId'] ) || ((int)$data['userId']==0 && $uq != 104)): ?>
       <tr>
          <th>红利比例：</th>
          <td>
              <input type="text" class="ipt" id="percent" name="percent" value="<?php echo $data['percent']; ?>" />%
          </td>
       </tr>
        <?php if((isset($data['uq']) && ( $data['uq'] != 103) ) || ((int)$data['userId']==0 && $uq != 103)): ?>
       <tr>
          <th>手续费比例：</th>
          <td>
              <input type="text" class="ipt" id="fee_percent" name="fee_percent" value="<?php echo $data['fee_percent']; ?>" />%
          </td>
       </tr>
       <?php endif; endif; ?>

       
       
  
  <tr>
     <td colspan='2' align='center'>
       <input type="hidden" name="id" id="userId" class="ipt" value="<?=(int)$data['userId']?>" />
       <input type="submit" value="提交" class='btn btn-blue' />
       <input type="button" onclick="javascript:history.go(-1)" class='btn' value="返回" />
     </td>
  </tr>
</table>
</form>
<script>
  var posturl = "<?php echo url('selectuser'); ?>";

$(function(){editInit()});

</script>



<script type='text/javascript' src='__STATIC__/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
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