<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:88:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\bank_add.html";i:1539418142;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>银行卡账户-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
body { background:#f7f7f7; }
.card_line { background:#ffffff; margin:3% 0; width:100%; float:left; padding:10px 0 30px 0; }
.card_line form { padding-bottom:30px; float:left; }
.card_line dl { width:90%; font-size:250%; padding:30px 5% 30px 5%; height:60px; line-height:60px; border-bottom:1px solid #ededed; }
.card_line dl dt { width:25%; text-align:right; }
.card_line dl dd { width:75%; }
.card_line dl dd input { width:100%; height:50px; border:0; color:#b5b5b5; }
.card_line dl dd input.tell { width:50%;  }
.card_line dl dd span { float:right; font-size:80%; border:1px solid #f94701; height:58px; line-height:58px; color:#f94701; border-radius:15px; padding:0 30px; }
.card_line dl dd select { width:100%; height:50px; border:0; color:#b5b5b5; }
.card_line h1 input { font-size:300%; color:#ffffff; width:90%; margin:3% 5% 0 5%; padding:30px 0; background:#e34044; float:left; -webkit-appearance:none; vertical-align: middle;  border-radius:15px; }
.card_line p { width:90%; padding:7px 5%; font-size:180%; color:#e34044; }
</style>


	<div class="card_line">
		<form action='' method='post' onsubmit='return checkform();'>
        <dl>
            <dt>持卡人：</dt>
            <dd><input id="accUser" type="text" name="textfield" value="<?php echo !empty($accUser)?$accUser:'请输入持卡人姓名'; ?>" onfocus="if (value =='请输入持卡人姓名'){value =''}" onblur="if (value ==''){value='请输入持卡人姓名'}"/></dd>
        </dl>
        <dl>
            <dt>银行：</dt>
            <dd>
			<select id='accTargetId' name="select">
				
                <option value="0">请选择</option>
    				<?php if(is_array($banks) || $banks instanceof \think\Collection): $i = 0; $__LIST__ = $banks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<option <?php if(isset($accTargetId) && $accTargetId == $vo['bankId']): ?> selected="selected" <?php endif; ?>  value="<?php echo $vo['bankId']; ?>"><?php echo $vo['bankName']; ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
									
				               
			</select>
            </dd>
        </dl>
        <dl>
            <dt>开户行：</dt>
            <dd><input type="text" name="textfield" id="address" value="<?php echo !empty($address)?$address:'输入开户行'; ?>" onfocus="if (value =='输入开户行'){value =''}" onblur="if (value ==''){value='输入开户行'}"/></dd>
        </dl>
        <dl>
            <dt>卡号：</dt>
            <dd><input type="text" name="textfield" id="accNo" value="<?php echo !empty($accNo)?$accNo:'请输入16或19位银行卡号'; ?>" onfocus="if (value =='请输入16或19位银行卡号'){value =''}" onblur="if (value ==''){value='请输入16或19位银行卡号'}"/></dd>
        </dl>
        
		
        <h1><input type="submit" name="button" id="button" value="保存" /></h1>
        </form>
        <p>注：</p>
        <p>1.如果你不知道开户行，请拨打卡所属客户电话进行查询。</p>
        <p>2.仅支持借记卡，不支持信用卡</p>
    </div>	

	<div class="sub">
	    <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
	    <div><a href="<?php echo url('index/kaijiang'); ?>" class="a2 a_2">助手</a></div>
	    <div><a href="<?php echo url('index/paihang'); ?>" class="a3 a_3">排行</a></div>
	    <div><a href="<?php echo url('users/index'); ?>" class="a4 ">我的</a></div>
	</div>


	<script>
	var mycard_url="<?php echo url('index'); ?>";
    var mycard_add_url="<?php echo url(''); ?>";
    var targetId = 0;
    var id = 0;
    <?php if(isset($targetId)): ?>
        targetId = "<?php echo $targetId; ?>"
        id = "<?php echo $id; ?>"
    <?php endif; ?>
	function checkform(){
		var accUser=$('#accUser').val();
		if(accUser=='请输入持卡人姓名'){
			alert('请输入持卡人姓名');
			return false;
		}
		
		var accTargetId=$('#accTargetId').val();
		if(accTargetId=='0'){
			alert('请选择银行');
			return false;
		}
		var address=$('#address').val();
		if(address=='输入开户行'){
			alert('请输入开户行');
			return false;
		}
		
		var accNo=$('#accNo').val();
		if(accNo=='请输入16或19位银行卡号'){
			alert('请输入银行卡号');
			return false;
		}
		
		var phone_code=$('#phone_code').val();
		if(phone_code=='请输入短信验证码'){
			alert('请输入短信验证码');
			return false;
		}
		
		var data={
			accUser:accUser,
			accTargetId:accTargetId,
			address:address,
			accNo:accNo,
			targetId:targetId,
			id:id,
			targetType:1,
		};
		
		
		
		$.post(mycard_add_url,data,function(msg){
			if(msg.status==1){
                alert('操作成功');
                window.location.href=mycard_url;
            }else{
                alert(msg.msg);
            }
		});
		return false;
	}
	


	
</script>


</body></html>

