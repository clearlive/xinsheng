<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:91:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\users\pkxiangqing.html";i:1512094910;s:80:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header.html";i:1539605639;}*/ ?>
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

<div class="wrapper">
    <div class="pkname">
        <p>开奖期号：20<?php echo $ssc['issue']; ?></p>
        <p>
            开奖结果：<?php echo $ssc['balls']; ?> ( <?php echo $ssc['isxiao']; ?> | <?php echo $ssc['isdan']; ?> | <?php echo $ssc['four']; ?> )			</p>
    </div>
    <div class="tit"></div>


    <div class="bok">
        <p>订单编号：<?php echo $dingdan['orderNo']; ?></p>
        <p>匹配数量：<?php echo $duishou['orderNum']; ?></p>
        <div class="pklist">

            


            <div class="div_1">
                <div class="ddd">
                    <div class="hh"></div>
                    <div class="shuzi">
                        <?php echo $dd_type; ?>						</div>
                </div>
                <p><?php echo substr($dingdan['userName'],0,3); ?>****<?php echo substr($dingdan['userName'],-4); ?></p>
                

            </div>


            <div class="div_2">VS</div>

                        <div class="div_3">
                <div class="ddd">
                    <div class="hh"></div>
                    <div class="shuzi">
                        <?php echo $ds_type; ?>						</div>
                </div>
                <p><?php echo substr($duishou['userName'],0,3); ?>****<?php echo substr($duishou['userName'],-4); ?></p>

            </div>
        </div>
    </div>



</div>
</body></html>