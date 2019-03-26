<?php
namespace application\home\controller;
use application\home\model\Payments as M;
/**
 

 
 

 
 支付与回调

 返回
 1、调转url
 2、二维码显示url
 3、显示图片
 4、form自动提交
 */
use think\Controller;
class Payments extends Controller{

    //*********************************秒冲宝开始***********************************
	public function e(){
		return 'ok';
	}
	
    public function mcb_pay($data,$payment,$paytype)
    {
        
        $payConfig = json_decode($payment['payConfig'],1);

        $type = $payConfig[$paytype];

        if(!$type){
            return WSTReturn('暂时无法使用',-1);
        }

        $back_url =  url('home/users/index','','',true,true);
        
        //http://mcbpay.cv09.cn

        $url = $payConfig['mcb_paydomail']."/pay/pay.php?appid=".$payConfig['mcb_appid']."&typ=$type&money=".$data['bpprice']."&payno=".$data['balance_sn'].'&back_url='.$back_url;
        
        return WSTReturn(1,1,$url);
    }

    public function mcbconf()
    {
		error_reporting( 0 );
		file_put_contents( dirname( __FILE__ ).'/log_req.txt', var_export($_REQUEST, true), FILE_APPEND );
        $map['payName'] = 'mcb';
        $payment = db('payments')->where($map)->find();
        //cache('mcbconf',$_REQUEST);
        
        $_data = $_REQUEST;
        
        //软件接口配置
        $key_="JHesdekjersb";//接口KEY  自己修改下 软件上和这个设置一样就行
        $md5key="538b3c39fe6db0844ba78ddfb51f3b57sb";//MD5加密字符串 自己修改下 软件上和这个设置一样就行
        //软件接口地址 http://域名/mcbpay/apipay.php?payno=#name&tno=#tno&money=#money&sign=#sign&key=接口KEY
    
        $getkey=$_data['key'];//接收参数key
        $tno=$_data['tno'];//接收参数tno 交易号
        $payno=$_data['payno'];//接收参数payno 一般是用户名 用户ID
        $money=$_data['money'];//接收参数money 付款金额
        $sign=$_data['sign'];//接收参数sign
        $typ=(int)$_data['typ'];//接收参数typ
        if($typ==1){
            $typname='手工充值';
        }else if($typ==2){
            $typname='支付宝充值';
        }else if($typ==3){
            $typname='财付通充值';
        }else if($typ==4){
            $typname='手Q充值';
        }else if($typ==5){
            $typname='微信充值';
        }
        
        if(!$tno)exit('没有订单号');
        if(!$payno)exit('没有付款说明');
        if($getkey!=$key_)exit('KEY错误');
        //if(strtoupper($sign)!=strtoupper(md5($tno.$payno.$money.$md5key)))exit('签名错误');
    //************以下代码自己写   
        //查询数据库 交易号tno是否存在  tno数据库充值表增加个字段 长度50 存放交易号
        //

        //$this->notify_ok_dopay($payno, $money);
        //
        
        $recharge = db('recharge')->where('balance_sn',$payno)->find();
        if(!$recharge){
            $this->error('参数错误！');
        }

        

        if($recharge['bptype'] != 3){
            
            exit('该订单已充值');
        }

        
        
        $res = $this->notify_ok_dopay($payno,$money);
        
        exit('1');
    }
    //*********************************秒冲宝结束***********************************























    public function notify_ok_dopay($order_no,$order_amount)
    {
        
        if(!$order_no || !$order_amount){
            
            return false;
        }

        $recharge = db('recharge')->where('balance_sn',$order_no)->find();
        
        if(!$recharge){
            
            return false;
        }
   
        if($recharge['bpprice'] > $order_amount)
		{
            return false;
        }
        

        if($recharge['bptype'] != 3){
            
            return true;
        }
        $_edit['bpid'] = $recharge['bpid'];
        $_edit['bptype'] = 1;
        $_edit['isverified'] = 1;
        $_edit['cltime'] = time('Y-m-d H:i:s');
        $_edit['bpbalance'] = $recharge['bpbalance']+$recharge['bpprice'];
        
        $is_edit = db('recharge')->update($_edit);

        if($recharge['reg_par'] > 0){
            $addmoney = round( ($recharge['bpprice'] - $recharge['reg_par']) ,2);
        }else{
            $addmoney = $recharge['bpprice'];
        }
        
        if($is_edit){
            // add money
            $_ids=db('users')->where('userId',$recharge['uid'])->setInc('userMoney',$addmoney);
            if($_ids){
                //资金日志
                $lm = [];
                $lm['targetType'] = 12;
                $lm['targetId'] = $recharge['uid'];
                $lm['dataId'] = $recharge['bpid'];
                $lm['dataSrc'] = getsrc();
                $lm['remark'] = '充值';
                $lm['moneyType'] = 2;
                $lm['money'] = $addmoney;
                $lm['payType'] = 0;
                $lm['createTime'] = date('Y-m-d H:i:s',time());
                db('log_moneys')->insert($lm);
            }
            
            return true;
        }else{
            
            return false;
        }

    }


	public function bdyf_back(){
		//out_trade_no=DD1527919127&out_channel_no=A4SM39Q1527919128201&respCode=00000&respMsg=%E4%BB%98%E6%AC%BE%E6%88%90%E5%8A%9F&sign=34264e5fdacda7b5925240bbfa302a71&attach=00&notifytime=2018-06-02+13%3A59%3A04.0
		$backdata  = file_get_contents("php://input");
		//file_put_contents("C:/data.txt",$backdata);
		$backcl    = explode('&',$backdata); 
		$respCode  = $backcl[2];//获取状态	 
		$respCodes = explode('=',$respCode);//获取状态编码
		$orderno   = $backcl[0];//获取订单号
		$ordernos  = explode('=',$orderno);//获取订单号编码
		//file_put_contents("C:/data1.txt",$ordernos[1]);
		if($respCodes[1] == '00000') {
			$balancetemp = db('recharge')->where('balance_sn',$ordernos[1])->where('isverified',0)->find();
			$a = $this->notify_ok_dopay($ordernos[1],$balancetemp['bpprice']);
            if(true){
               echo '{"status":true}';//通知平台
               exit;
            }
		}else{
			echo '{"status":false}';
			exit;
		}
	}
	public function notify(){
        $customerid = '10961';//用户编号
        $status=$_POST['status'];//0 支付失败 1 支付成功
        $customerid=$_POST['customerid'];//商户编号
        $sdorderno=$_POST['sdorderno'];//商户订单号
        $total_fee=$_POST['total_fee'];//交易金额
        $paytype=$_POST['paytype'];//支付类型
        $sdpayno=$_POST['sdpayno'];//平台订单号
        $sign=$_POST['sign'];//md5验证签名串
        $userkey='a31b25fd047a484a4cacd76142a325adf1f77059';//在后台 接入信息 里面拿接入密钥
        $mysign=md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);
        if($sign==$mysign){//md5签名是否相等
            if($status=='1'){//0 支付失败 1 支付成功
                $balancetemp = db('recharge')->where('balance_sn',$sdpayno)->where('isverified',0)->find();
                $a = $this->notify_ok_hui($sdpayno,$paytype,$balancetemp['bpprice']);
                echo 'success';//成功必须返回success        
            } else {
                echo 'fail';
                exit;
            }
        } else {
            echo 'signerr';
        }
    }

    public function notify_ok_hui($order_no,$paytype,$order_amount)
    {
        
        if(!$order_no || !$order_amount){
            
            return false;
        }

        $recharge = db('recharge')->where('balance_sn',$order_no)->find();
        
        if(!$recharge){
            
            return false;
        }
   
        if($recharge['bpprice'] > $order_amount)
		{
            return false;
        }
        

        if($recharge['bptype'] != 3){
            
            return true;
        }
        $_edit['bpid'] = $recharge['bpid'];
        $_edit['bptype'] = 1;
        $_edit['isverified'] = 1;
        $_edit['pay_type'] = $paytype;
        $_edit['cltime'] = time('Y-m-d H:i:s');
        $_edit['bpbalance'] = $recharge['bpbalance']+$recharge['bpprice'];
        
        $is_edit = db('recharge')->update($_edit);

        if($recharge['reg_par'] > 0){
            $addmoney = round( ($recharge['bpprice'] - $recharge['reg_par']) ,2);
        }else{
            $addmoney = $recharge['bpprice'];
        }
        
        if($is_edit){
            // add money
            $_ids=db('users')->where('userId',$recharge['uid'])->setInc('userMoney',$addmoney);
            if($_ids){
                //资金日志
                $lm = [];
                $lm['targetType'] = 12;
                $lm['targetId'] = $recharge['uid'];
                $lm['dataId'] = $recharge['bpid'];
                $lm['dataSrc'] = getsrc();
                $lm['remark'] = '充值';
                $lm['moneyType'] = 2;
                $lm['money'] = $addmoney;
                $lm['payType'] = 0;
                $lm['createTime'] = date('Y-m-d H:i:s',time());
                db('log_moneys')->insert($lm);
            }
            
            return true;
        }else{
            
            return false;
        }

    }
	
    public function test_not($info='')
    {
        
        dump(cache($info));
    }
}
