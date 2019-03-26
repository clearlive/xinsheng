<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:87:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\dingdan.html";i:1539414754;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>

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
    <title>夺宝记录-<?php echo WSTConf('CONF.mallName'); ?></title>
    
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
    <script>

        

        var SysSecond=parseInt(1512047400);
        //var get_next_open_time_url='http://mall.mfchong.com/index.php?routeurl=index-index-get_next_open_time';
        var daojishi_reload_url=window.location.href;

        var uid='<?php echo $uid; ?>';
        var status='0';
        var load_list_url= "<?php echo url('ajaxdingdan'); ?>";
        var type = '<?php echo $type; ?>';
        //var daojishi="<?php echo $ssc_time; ?>";

    </script>
    <style>
        body { background:#f6f6f6; }

        <?php if($uid == $users['userId']): ?>
            .tabs li {
                width: 20% !important;
            }
        <?php endif; ?>
    </style>

<div class="wrapper">
    <div class="tabs" style="margin-top:0;">
        <li>
            <a href="<?php echo url('dingdan',array('type'=>1,'uid'=>$uid)); ?>" <?php if($type == 1): ?> class="current" <?php endif; ?>>所有订单</a>
        </li>
        <li>
            <a href="<?php echo url('dingdan',array('type'=>2,'uid'=>$uid)); ?>" <?php if($type == 2): ?> class="current" <?php endif; ?>>获胜订单</a>
        </li>
        <?php if($uid == $users['userId']): ?>
        <li>
            <a href="<?php echo url('dingdan',array('type'=>3,'uid'=>$uid)); ?>" <?php if($type == 3): ?> class="current" <?php endif; ?>>失败订单</a>
        </li>
        
        <li >
            <a href="<?php echo url('dingdan',array('type'=>4,'uid'=>$uid)); ?>" <?php if($type == 4): ?> class="current" <?php endif; ?>>已兑换</a>
        </li>
        <li >
            <a href="<?php echo url('dingdan',array('type'=>5,'uid'=>$uid)); ?>" <?php if($type == 5): ?> class="current" <?php endif; ?>>未兑换</a>
        </li>
        <?php else: ?>
        <li class="litwo">
            <a href="<?php echo url('dingdan',array('type'=>3,'uid'=>$uid)); ?>" <?php if($type == 3): ?> class="current" <?php endif; ?>>失败订单</a>
        </li>
        <?php endif; ?>

    </div>
    <div class="content">
        <div class="tab1">
            <ul class="jilu">
                <script> var end_id = 1 </script><input type="hidden" id="list_biao">

                <div class="more" id="get_more" onclick="load_list();" style="height:150px;">加载更多</div>
            </ul>
        </div>

    </div>

    

</div>
<?php if($uid == $users['userId']): ?>
<div class="dd_btn">
    <div class="btn_div"><a href="javascript:yijiandh();" class="duihuan">一键兑换 98折</a></div>
    <div class="btn_div"><a href="javascript:alert('联系客服QQ：<?php echo WSTConf('CONF.serviceQQ'); ?>');" class="tihuo">一键提货</a></div>
</div>
<script>

function yijiandh() {
    if($('.dd_btn .btn_div .duihuan').text() == '兑换中……'){
        alert('兑换中……');
        return;
    }
    if(confirm("一键兑换已获胜订单")){
        $('.dd_btn .btn_div .duihuan').text('兑换中……');
        var posturl = "<?php echo url('yj_duihuans'); ?>";
        $.post(posturl,'',function(data){
            alert(data.msg);
            if(data.status == 1){
                window.history.go(0);
            }else{
                $('.dd_btn .btn_div .duihuan').text('一键兑换 98折');
            }

        })
    }  
}

</script>
<?php endif; ?>
<div class="sub">
        <div><a href="<?php echo url('home/index/index'); ?>" class="a1 a_1">首页</a></div>
        <div><a href="<?php echo url('index/kaijiang'); ?>" class="a2 a_2">助手</a></div>
        <div><a href="<?php echo url('users/index'); ?>" class="a4 ">我的</a></div>
</div>
<script>

    var need_daojishi=false;
    var end_id = 1;
    $(function(){

        if (typeof end_id =="undefined"){

            end_id = 1;
        }

        load_list();
    });

    function load_list(){
        $('#get_more').html('正在加载中...');
        var data={page:end_id,uid:uid,type:type}
        var callback='load_list_callback(msg)';
        ajax_post(load_list_url,data,callback);
    }

    function load_list_callback(msg){
        $('#list_biao').before(msg);
        if (!msg){
            $('#get_more').remove();
            exit;
        }

        //$('#get_more').remove();
        
        $('#get_more').html('加载更多');
        end_id++;
    }

    function daojishi_start(){
        if(need_daojishi==true){return;}
        need_daojishi=true;
        //alert(daojishi);
        $(".fnTimeCountDown").fnTimeCountDown("");
    }


/**
 * 兑换
 * @author lukui  2017-12-02
 * @param  {[type]} drid [description]
 * @return {[type]}      [description]
 */
function duihuan(drid) {
    var posturl = "<?php echo url('dr_duihuans'); ?>";
    var param = {'drid':drid};
    $.post(posturl,param,function(data){
        
        alert(data.msg);
        if(data.status == 1){
            window.history.go(0);
        }
    })

}

</script>





</body></html>