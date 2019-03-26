<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\upuser.html";i:1539414375;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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
    <title>支付宝账户-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
.card_line form { padding-bottom:30px; }
.card_line dl { width:100%; font-size:250%; padding:30px 5% 30px 5%; height:60px; line-height:60px; border-bottom:1px solid #ededed; }
.card_line dl dt { width:37%; text-align:right; }
.card_line dl dd { width:60%; }
.card_line dl dd input { width:100%; height:50px; border:0; color:#b5b5b5; }
.card_line dl dd input.tell { width:50%;  }
.card_line dl dd span { float:right; font-size:80%; border:1px solid #f94701; height:58px; line-height:58px; color:#f94701; border-radius:15px; padding:0 30px; }
.card_line dl dd select { width:100%; height:50px; border:0; color:#b5b5b5; }
.card_line h1 input { font-size:300%; color:#ffffff; width:90%; margin:3% 5% 5% 5%; padding:30px 0; background:#e34044; float:left; -webkit-appearance:none; vertical-align: middle;  border-radius:15px; }
.card_line p { width:90%; padding:7px 5%; font-size:180%; color:#e34044; }
</style>



<div class="card_line">
        <form action='' method='post' onsubmit='return checkform();'>
        <dl>
            <dt>流水比例（%）：</dt>
            <dd><input type="text" id="percent" value="" placeholder="请输入流水比例"/></dd>
        </dl>
        
        

        
        <h1><input type="submit" name="button" id="button" value="保存" /></h1>
        </form>
        <p>注：您给下级代理商的比例需小于自身比例，提交后不可修改</p>
       
        
    </div>  


    


	<div class="sub">
	    <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
	    <div><a href="<?php echo url('index/kaijiang'); ?>" class="a2 a_2">助手</a></div>
	    <div><a href="<?php echo url('index/paihang'); ?>" class="a3 a_3">排行</a></div>
	    <div><a href="<?php echo url('users/index'); ?>" class="a4 ">我的</a></div>
	</div>


    <script>
    
    function checkform() {
    	
    	var posturl = '';
    	var uid = "<?php echo $uid; ?>";
    	var percent = $('#percent').val();
    	var postdata = 'userId='+uid+'&percent='+percent;
    	$.post(posturl,postdata,function(res){
    		alert(res.msg);
    		if(res.status == 1){
    			history.go(-1);
    		}

    	})
    	return false;
    }



</script>


</body></html>

