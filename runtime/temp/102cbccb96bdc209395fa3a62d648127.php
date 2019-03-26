<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\index\index.html";i:1547626322;s:84:"C:\UPUPW_ANK_W64\WebRoot\Vhosts\duobao_hk/application/home\view\home\header_top.html";i:1537516410;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
     
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection"> 
    <title>首页-<?php echo WSTConf('CONF.mallName'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no;"> 
    <meta content="user-scalable=no" name="viewport">
    <!-- <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0">-->
     <!-- <meta name="format-detection" content="telephone=no"> -->
    <link  media="all" rel="stylesheet" href="__STATIC__/static/front/css/bootstrap.css">
    <link  media="all" rel="stylesheet" href="__STATIC__/static/front/css/style.css">
    <link  media="all" rel="stylesheet" href="__STATIC__/static/front/css/font-awesome.css">
    <link  media="all" rel="stylesheet" href="__STATIC__/static/front/css/idangerous.swiper.css">
    <link  media="all" rel="stylesheet" href="__STATIC__/static/front/css/nav.css" type="text/css"> 

    <script type="text/javascript" src="__STATIC__/static/front/js/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="__STATIC__/static/front/js/bootstrap.js"></script>
    <script type="text/javascript" src="__STATIC__/static/front/js/idangerous.swiper.js"></script>
    <script type="text/javascript" src="__STATIC__/static/web/alerts/layer.js"></script> 


</head>
<body>
<style>
    .container-fluid{
        margin-bottom: 100px;
    }
    .thumbnail{
        padding: 12px !important;
    }
    .thumbnail .caption{
        font-size: 30px !important;
    }
    .thumbnail h5{
        font-size: 30px !important;
        line-height: 50px !important;
        text-align: center !important; 
        /* margin:  */
    }
    .thumbnail img{
        height: 500px;
    }

</style>
    <div class="banner"> 
      <!-- 代码开始 -->
      <div class="swiper-container">
        <div class="swiper-wrapper"> 
         
          <div class="swiper-slide"> <img src="__STATIC__/static/mallImg/top_1.png" border="0"> </div>
          <div class="swiper-slide"> <img src="__STATIC__/static/mallImg/top_2.png" border="0"> </div>
        
   
          
        </div>
      </div>
      <div class="pagination"></div>
     </div>
     <script type="text/javascript">
        $(function(){
          var mySwiper = $('.swiper-container').swiper({
            //Your options here:
            mode:'horizontal',
            loop: true,
            autoplay : 5000,
            pagination: '.pagination'
            //etc..
          });
        })
           
        </script> 
        
      <!-- 代码结束 --> 
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 er-pic">
            <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
            
            <!-- <div class="col-xs-12">
                <a href="__STATIC__/hqfront/signIn">
                    <img src="__STATIC__/static/front/images/daysignin.png" style="width:30px;height:30px" alt=""/>&nbsp;&nbsp;
                    <span style="color: #c40000; font-size: 1.0em;">每日签到</span>
                </a>          
            </div> -->
            <a href="javascript:;"  class="calendar-hour calendar-hour-taken" style="height:70px;">
                <div class="col-xs-6" style="padding: 5px;">
                  <div class="thumbnail">
                          <img src="__STATIC__/static/mallImg/1.jpg" alt="" style=" border: 1px solid #e6e6e6;" onerror="this.style.display='none';">
                    <div class="caption">
                      <h5 >贵州茅台仁酒53度丹青殊荣500ml</h5>
                      <p style="text-align: left;">
                             <!-- <span style="color: #939393;">积分抵&nbsp;</span>
                              <span style="color: #c40000; font-size: 1.0em;">
                                  100
                              </span>&nbsp;<span style="color: #939393;">%</span> --> 
                              <span style="color: #c40000; font-size: 1.0em;">
                                  3900
                              </span>
                              <!-- <span style="color: #939393;">积分+</span>
                              <span style="color: #c40000; font-size: 1.0em;">0</span> -->
                              <span style="color: #939393;">元/瓶</span>
                               <br/>
                               <span style="color: #939393;">原价￥
                                  <del>6000.00</del>
                                    元/瓶
                              </span>
                      
                      </p>
                    </div>
                  </div>
                </div>
            </a>
        
            <a href="javascript:;"  class="calendar-hour calendar-hour-taken" style="height:70px;">
                <div class="col-xs-6" style="padding: 5px;">
                  <div class="thumbnail">
                          <img src="__STATIC__/static/mallImg/2.jpg" alt="" style=" border: 1px solid #e6e6e6;" onerror="this.style.display='none';">
                    <div class="caption">
                      <h5 >楼兰大古堡贵族酒庄原瓶限量版酒</h5>
                      <p style="text-align: left;">
    
                              <span style="color: #c40000; font-size: 1.0em;">
                                  1998
                              </span>
                              <span style="color: #939393;">元/瓶</span>
                               <br/>
                               <span style="color: #939393;">原价￥
                                  <del>2998.00</del>
                                    元/瓶
                              </span>
                      
                      </p>
                    </div>
                  </div>
                </div>
            </a>
        
            <a href="javascript:;"  class="calendar-hour calendar-hour-taken" style="height:70px;">
                <div class="col-xs-6" style="padding: 5px;">
                  <div class="thumbnail">
                          <img src="__STATIC__/static/mallImg/3.jpg" alt="" style=" border: 1px solid #e6e6e6;" onerror="this.style.display='none';">
                    <div class="caption">
                      <h5 >法国原瓶进口红酒</h5>
                      <p style="text-align: left;">
                             <!-- <span style="color: #939393;">积分抵&nbsp;</span>
                              <span style="color: #c40000; font-size: 1.0em;">
                                  100
                              </span>&nbsp;<span style="color: #939393;">%</span> --> 
                              <span style="color: #c40000; font-size: 1.0em;">
                                  998
                              </span>
                              <span style="color: #939393;">元/瓶</span>
                               <br/>
                               <span style="color: #939393;">原价￥
                                  <del>1999.00</del>
                                  元/瓶
                              </span>
                      
                      </p>
                    </div>
                  </div>
                </div>
            </a>
        
            <a href="javascript:;"  class="calendar-hour calendar-hour-taken" style="height:70px;">
                <div class="col-xs-6" style="padding: 5px;">
                  <div class="thumbnail">
                          <img src="__STATIC__/static/mallImg/4.jpg" alt="" style=" border: 1px solid #e6e6e6;" onerror="this.style.display='none';">
                    <div class="caption">
                      <h5 >原石酒庄干红葡萄酒</h5>
                      <p style="text-align: left;">
                          
                      
                            
                          
                             <!-- <span style="color: #939393;">积分抵&nbsp;</span>
                              <span style="color: #c40000; font-size: 1.0em;">
                                  100
                              </span>&nbsp;<span style="color: #939393;">%</span> --> 
                              <span style="color: #c40000; font-size: 1.0em;">
                                  2988
                              </span>
                              <span style="color: #939393;">元/瓶</span>
                               <br/>
                               <span style="color: #939393;">原价￥
                                  <del>6888.00</del>
                                  元/瓶
                               </span>
                      
                      </p>
                    </div>
                  </div>
                </div>
            </a>
        
            <a href="javascript:;"  class="calendar-hour calendar-hour-taken" style="height:70px;">
                <div class="col-xs-6" style="padding: 5px;">
                  <div class="thumbnail">
                          <img src="__STATIC__/static/mallImg/5.jpg" alt="" style=" border: 1px solid #e6e6e6;" onerror="this.style.display='none';">
                    <div class="caption">
                      <h5 >大红袍武夷山岩茶特级茶叶</h5>
                      <p style="text-align: left;">
                             <!-- <span style="color: #939393;">积分抵&nbsp;</span>
                              <span style="color: #c40000; font-size: 1.0em;">
                                  100
                              </span>&nbsp;<span style="color: #939393;">%</span> --> 
                              <span style="color: #c40000; font-size: 1.0em;">
                                  998
                              </span>
                              <span style="color: #939393;">元
                              </span>
                               <br/>
                               <span style="color: #939393;">原价￥
                                  <del>1888.00</del>
                              元
                              </span>
                      
                      </p>
                    </div>
                  </div>
                </div>
            </a>
        
            <a href="javascript:;"  class="calendar-hour calendar-hour-taken" style="height:70px;">
                <div class="col-xs-6" style="padding: 5px;">
                  <div class="thumbnail">
                          <img src="__STATIC__/static/mallImg/6.jpg" alt="" style=" border: 1px solid #e6e6e6;" onerror="this.style.display='none';">
                    <div class="caption">
                      <h5 >安徽铁观音高档木质礼盒装</h5>
                      <p style="text-align: left;">
                         
                        <span style="color: #c40000; font-size: 1.0em;">
                                  399
                              </span>
                              <span style="color: #939393;">元
                              </span>
                               <br/>
                               <span style="color: #939393;">原价￥
                                  <del>866.00</del>
                              元
                              </span>
                      
                      </p>
                    </div>
                  </div>
                </div>
            </a>
        
            <a href="javascript:;"  class="calendar-hour calendar-hour-taken" style="height:70px;">
                <div class="col-xs-6" style="padding: 5px;">
                  <div class="thumbnail">
                          <img src="__STATIC__/static/mallImg/7.jpg" alt="" style=" border: 1px solid #e6e6e6;" onerror="this.style.display='none';">
                    <div class="caption">
                      <h5 >清承堂大佛龙井绿茶礼盒装 </h5>
                      <p style="text-align: left;">
                             <!-- <span style="color: #939393;">积分抵&nbsp;</span>
                              <span style="color: #c40000; font-size: 1.0em;">
                                  100
                              </span>&nbsp;<span style="color: #939393;">%</span> --> 
                              <span style="color: #c40000; font-size: 1.0em;">
                                  666
                              </span>
                              <span style="color: #939393;">元
                              </span>
                               <br/>
                               <span style="color: #939393;">原价￥
                                  <del>1298.00</del>
                              元
                              </span>
                      
                      </p>
                    </div>
                  </div>
                </div>
            </a>
        
            <a href="javascript:;"  class="calendar-hour calendar-hour-taken" style="height:70px;">
                <div class="col-xs-6" style="padding: 5px;">
                  <div class="thumbnail">
                          <img src="__STATIC__/static/mallImg/8.jpg" alt="" style=" border: 1px solid #e6e6e6;" onerror="this.style.display='none';">
                    <div class="caption">
                      <h5 >新茶四大名茶佳节礼盒装</h5>
                      <p style="text-align: left;">
                             <!-- <span style="color: #939393;">积分抵&nbsp;</span>
                              <span style="color: #c40000; font-size: 1.0em;">
                                  100
                              </span>&nbsp;<span style="color: #939393;">%</span> --> 
                              <span style="color: #c40000; font-size: 1.0em;">
                                  968
                              </span>
                              <span style="color: #939393;">元
                              </span>
                               <br/>
                               <span style="color: #939393;">原价￥
                                  <del>1968.00</del>
                              元
                              </span>
                      
                      </p>
                    </div>
                  </div>
                </div>
            </a>
        
    </div>
      <div class="row"><div class="col-xs-12" style="height: 60px; "></div></div>
    </div></div></div>
    
    <!-- <div class="container-fluid" style="position:fixed; bottom: 0; width: 100%; z-index: 1;">
        <div class="row" style="background: #c40000; height: 44px; ">
            <div class="col-xs-3" style="padding: 0; margin: 0; line-height: 44px; text-align: center; border-right: 1px solid #fff; font-size: 1.1em;">
            <a href="<?php echo url('mall/index'); ?>" style=" color: #fff; text-decoration: none;">首页</a> </div>
            <div class="col-xs-3" style="padding: 0; margin: 0; line-height: 44px; text-align: center; border-right: 1px solid #fff; font-size: 1.1em">
            <a href="<?php echo url('mall/queryOrderList'); ?>" style=" color: #fff; text-decoration: none;">订单</a> </div>
                    <div class="col-xs-3" style="padding: 0; margin: 0; line-height: 44px; text-align: center; border-right: 1px solid #fff; font-size: 1.1em">
            <a href="<?php echo url('mall/queryMallCart'); ?>" style=" color: #fff; text-decoration: none;">购物车</a> </div>
                    <div class="col-xs-3" style="padding: 0; margin: 0; line-height: 44px; text-align: center; font-size: 1.1em">
            <a href="<?php echo url('mall/center'); ?>" style=" color: #fff; text-decoration: none;">我的</a> </div>
        </div>
    </div>  -->
    <div class="nav_bottom">
            <div><a href="<?php echo url('mall/index'); ?>" class="a1">首页</a></div>
            <div><a href="<?php echo url('mall/queryOrderList'); ?>" class="a5 a_5">订单</a></div>
            <div><a href="<?php echo url('mall/queryMallCart'); ?>" class="a6 a_6">购物车</a></div> 
            <div><a href="<?php echo url('users/center'); ?>" class="a4 a_4">我的</a></div>
    </div>
    <div class="modal fade in er-dl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <h4 class="modal-title" id="exampleModalLabel">请输入密码</h4>
          </div>
          <div class="modal-body" style="padding-bottom:0;">
              <div class="form-group">
                <label for="recipient-name" class="control-label">手机号</label>
                <input type="number" id="dengluPhone" value="18700712467" class="form-control" id="recipient-name">
              </div>
          </div>
          <div class="modal-body" style="padding-top:0; padding-bottom: 0;">
              <div class="form-group">
                <label for="recipient-name" class="control-label">密码</label>
                <input type="password" id="dengluCode" class="form-control" id="recipient-name">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="denglu();" class="btn btn-lg btn-danger btn-block">登录</button>
            <p class="help-block" style="margin-top:20px;"><a href="#" onclick="forget() ;">忘记密码？</a></p>
          </div>
           
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade in" id="dengjibin"></div>
    
            <script>
                $("#exampleModal").css("display","none") ;
                   $("#dengjibin").css("display","none") ;
            </script>
        
        
    </body>
    <!--分享--> 
     <script src="__STATIC__/static/web/js/jweixin-1.0.0.js"></script>
     <script src="__STATIC__/static/web/js/zepto.min.js"></script>
     <!-- 20160722 add 修改弹出alert 为 div 所有 alert 改为 layer.alert(消息内容) ; -->
    <SCRIPT src="__STATIC__/static/web/alerts/layer.js" type=text/javascript></SCRIPT>
    <script type="text/javascript">
      /*
       * 注意：
       * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
       * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
       * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
       *
       * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
       * 邮箱地址：weixin-open@qq.com
       * 邮件主题：【微信JS-SDK反馈】具体问题
       * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
       */
    //   wx.config({
    //       debug: false,
    //       appId:'wx01a4101a6e63725e',
    //       timestamp: '1537167001',
    //       nonceStr: '1ktFWOZYrDp5cHMY',
    //       signature: '5f6e3c4780cc4f9d7fce7718d28046b3db4aa2a8',
    //       jsApiList: [
    //         'onMenuShareTimeline',
    //         'onMenuShareAppMessage',
    //         'onMenuShareQQ',
    //         'onMenuShareWeibo',
    //         'onMenuShareQZone',
    //         'showMenuItems'
    //       ]
    //   });
     
    //   // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，
    //   //则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
    // wx.ready(function(){
    // wx.hideOptionMenu();
    // wx.showMenuItems({
    //     menuList: [
    //         'menuItem:share:appMessage',
    //         'menuItem:share:timeline'
    //         ] // 要显示的菜单项，所有menu项见附录3
    // });
    //   wx.onMenuShareTimeline({
    //         //title: '', // 分享标题
    //         title: '都市E购', // 分享标题
    //         link: 'http://www.xihanglu.com/wxobj/index.jsp?sharenum=B126&compnum=1612&memberId=920', // 分享链接
    //         //imgUrl: 'http://www.xihanglu.com:80__STATIC__/static/images/shareimg.jpg', // 分享图标
    //         imgUrl: 'http://www.xihanglu.com:80/__STATIC__/static/useImg/defaut_share.jpg', // 分享图标 20160715 按配置显示
    //          trigger: function (res) {
    //         //alert("分享到朋友圈"+res);
    //       },
    //         success: function (res) { 
    //             // 用户确认分享后执行的回调函数
    //            // alert("分享到朋友圈成功"+res);
    //            layer.alert("分享到朋友圈成功，坐等返佣吧。");
    //         },
    //         cancel: function (res) { 
    //             // 用户取消分享后执行的回调函数
    //            // alert("分享到朋友圈取消"+res);
    //         },
    //         fail: function (res) {
    //         //alert("分享到朋友圈失败"+JSON.stringify(res));
    //         layer.alert("分享到朋友圈失败，请稍候再试.");
    //       }
    //     });
    //     //alert('已注册获取“发送到朋友圈”状态事件');
    //     wx.onMenuShareAppMessage({
    //         //title: '', // 分享标题
    //          title: '都市E购', // 分享标题
    //         //desc: '这是一个很好的微盘', // 分享描述
    //         desc: '让购物更有乐趣', // 分享描述
    //         link: 'http://www.xihanglu.com/wxobj/index.jsp?sharenum=B126&compnum=1612&memberId=920', // 分享链接
    //         //imgUrl: 'http://www.xihanglu.com:80__STATIC__/static/images/shareimg.jpg', // 分享图标
    //         imgUrl: 'http://www.xihanglu.com:80/__STATIC__/static/useImg/defaut_share.jpg', // 分享图标 20160715 按配置显示
    //         type: '', // 分享类型,music、video或link，不填默认为link
    //         dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    //          trigger: function (res) {
    //         //alert("分享给我朋友"+res);
    //       },
    //         success: function (res) { 
    //             // 用户确认分享后执行的回调函数
    //            // alert("分享给我朋友成功"+res);
    //            layer.alert("分享给朋友成功，坐等返佣吧。");
    //         },
    //         cancel: function (res) { 
    //             // 用户取消分享后执行的回调函数
    //             // alert("分享给我朋友取消"+res);
    //         },
    //         fail: function (res) {
    //         //alert("分享给我朋友失败"+JSON.stringify(res));
    //             layer.alert("分享给朋友失败，请稍候再试.");
    //         }
    //     });
         
    //     //alert('已注册获取“发送给朋友”状态事件');
    
    //     wx.onMenuShareQQ({
    //         //title: '', // 分享标题
    //          title: '都市E购', // 分享标题
    //         //desc: '这是一个很好的微盘', // 分享描述
    //         desc: '让购物更有乐趣', // 分享描述
    //         link: 'http://www.xihanglu.com/wxobj/index.jsp?sharenum=B126&compnum=1612&memberId=920', // 分享链接
    //         //imgUrl: 'http://www.xihanglu.com:80__STATIC__/static/images/shareimg.jpg', // 分享图标
    //         imgUrl: 'http://www.xihanglu.com:80/__STATIC__/static/useImg/defaut_share.jpg', // 分享图标 20160715 按配置显示
    //         success: function (res) { 
    //            // 用户确认分享后执行的回调函数
    //          layer.alert("分享给QQ好友成功，坐等返佣吧。");
    //         },
    //         cancel: function (res) { 
    //            // 用户取消分享后执行的回调函数
    //         },
    //         fail: function (res) {
    //         //alert("分享给我朋友失败"+JSON.stringify(res));
    //             layer.alert("分享给QQ好友失败，请稍候再试.");
    //         }
    //     });
    //     wx.onMenuShareWeibo({
    //        // title: '', // 分享标题
    //         title: '都市E购', // 分享标题
    //         //desc: '这是一个很好的微盘', // 分享描述
    //         desc: '让购物更有乐趣', // 分享描述
    //         link: 'http://www.xihanglu.com/wxobj/index.jsp?sharenum=B126&compnum=1612&memberId=920', // 分享链接
    //         //imgUrl: 'http://www.xihanglu.com:80__STATIC__/static/images/shareimg.jpg', // 分享图标
    //         imgUrl: 'http://www.xihanglu.com:80/__STATIC__/static/useImg/defaut_share.jpg', // 分享图标 20160715 按配置显示
    //         success: function (res) { 
    //            // 用户确认分享后执行的回调函数
    //            layer.alert("分享到微博成功，坐等返佣吧。");
    //         },
    //         cancel: function (res) { 
    //             // 用户取消分享后执行的回调函数
    //         },
    //         fail: function (res) {
    //         //alert("分享给我朋友失败"+JSON.stringify(res));
    //             layer.alert("分享到微博失败，请稍候再试.");
    //         }
    //     });
    //     wx.onMenuShareQZone({
    //     //title: '', // 分享标题
    //      title: '都市E购', // 分享标题
    //     //desc: '这是一个很好的微盘', // 分享描述
    //     desc: '让购物更有乐趣', // 分享描述
    //     link: 'http://www.xihanglu.com/wxobj/index.jsp?sharenum=B126&compnum=1612&memberId=920', // 分享链接
    //     //imgUrl: 'http://www.xihanglu.com:80__STATIC__/static/images/shareimg.jpg', // 分享图标
    //     imgUrl: 'http://www.xihanglu.com:80/__STATIC__/static/useImg/defaut_share.jpg', // 分享图标 20160715 按配置显示
    //     success: function () { 
    //        // 用户确认分享后执行的回调函数
    //           layer.alert("分享到QQ空间成功，坐等返佣吧。");
    //     },
    //     cancel: function () { 
    //         // 用户取消分享后执行的回调函数
    //     },
    //         fail: function (res) {
    //         //alert("分享给我朋友失败"+JSON.stringify(res));
    //             layer.alert("分享到QQ空间失败，请稍候再试.");
    //         }
    //     });
    //   });
    
    //     wx.error(function(res){
        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看
        //，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
        //alert("");
        //alert("分享失败，请稍候再试."+res);
    // });
    </script>
    
    </html>
    