<?php
namespace application\home\controller;

use application\home\controller\Base;

class Mall extends Base{
	

    /**
     * 首页
     */
    public function index(){   

        return $this->fetch('index/index');
    } 
    
    /**
     * 订单
     */
    public function queryOrderList(){   

        return $this->fetch('index/queryOrderList');
    } 
    
    /**
     * 购物车
     */
    public function queryMallCart(){   
        // $arr['mch_id'] = 123;//商户号 （由平台分配 必填）
        // $arr['out_trade_no'] = 'cs'.time().rand(00000,99999);//订单号 （必填）
        // $arr['total_fee'] =0.1; //金额 （必填）
        // $arr['notify_url'] = '';  //回调地址  有效的可访问的url地址 （必填）
        // $arr['pay_type'] =5; // 5快捷（必填）
        // $arr['nonce_str'] = mt_rand(time(), time() + rand());//随机字符串 （必填）
        // $arr['body'] = '商品描述测试商品';  //商品描述 （必填）
        // $arr['front_url'] = 'http://www.baidu.com';  //前台通知地址   有效的可访问的url地址
        // ksort($arr);//对arr排序
        // var_dump($arr);

        // echo "<br><br>";
        // $temp = "";
        // foreach ($arr as $x => $x_value) {
        //     if ($x_value != null) {
        //         $temp = $temp . $x . "=" . $x_value . "&";
        //     }
        // }
        // var_dump($temp);
        // exit;
        return $this->fetch('index/queryMallCart');
    } 
    
   
    /**
     * 地址
     */
    public function address(){   

        return $this->fetch('index/address');
    } 
    


}
