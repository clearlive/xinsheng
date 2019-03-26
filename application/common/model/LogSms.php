<?php
namespace application\common\model;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 短信日志类
 */


require_once $_SERVER['DOCUMENT_ROOT'].'/extend/dayu2.0/vendor/autoload.php';
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;
Config::load();
class LogSms extends Base{

	public function sendSMS($smsSrc,$phoneNumber,$content,$smsFunc,$verfyCode){

		//return WSTReturn("短信发送成功!".$verfyCode,1);

		$USER = session('WST_USER');
		$userId = empty($USER)?0:$USER['userId'];
		$ip = request()->ip();
		
		//检测短信验证码验证是否正确
		if(WSTConf("CONF.smsVerfy")==1 && 1==2){
			$smsverfy = input("post.smsVerfy");
			$rs = WSTVerifyCheck($smsverfy);
			if(!$rs){
				return WSTReturn("验证码不正确!");
			}
		}
		//检测是否超过每日短信发送数
		$date = date('Y-m-d');
		$smsRs = $this->field("count(smsId) counts,max(createTime) createTime")
			 		  ->where(["smsPhoneNumber"=>$phoneNumber])
		 	          ->whereTime('createTime', 'between', [$date.' 00:00:00', $date.' 23:59:59'])->find();
		if($smsRs['counts']>(int)WSTConf("CONF.smsLimit")){
			return WSTReturn("请勿频繁发送短信验证!");
		}
		if($smsRs['createTime'] !='' && ((time()-strtotime($smsRs['createTime']))<120)){
			return WSTReturn("请勿频繁发送短信验证!");
		}
		//检测IP是否超过发短信次数
		$ipRs = $this->field("count(smsId) counts,max(createTime) createTime")
					 ->where(["smsIP"=>$ip])
					 ->whereTime('createTime', 'between', [$date.' 00:00:00', $date.' 23:59:59'])->find();
		if($ipRs['counts']>(int)WSTConf("CONF.smsLimit")){
			return WSTReturn("请勿频繁发送短信验证!");
		}
		if($ipRs['createTime']!='' && ((time()-strtotime($ipRs['createTime']))<120)){
			return WSTReturn("请勿频繁发送短信验证!");
		}


		

		if(!$verfyCode){
			return false;
		}

		if(!$phoneNumber){
			return false;
		}

		//短信运营商
		$smsCod =  WSTConf("CONF.smsCod");
		//短信宝
		if($smsCod == 2){
			$res = $this->duanxinbao($verfyCode,$phoneNumber);
		//阿里
		}elseif($smsCod == 1){
			$res = $this->alisms($verfyCode,$phoneNumber);
		}

		return $res;
		
	}

	/**
	 * 短信宝
	 * @author lukui  2017-12-07
	 * @param  [type] $verfyCode   [description]
	 * @param  [type] $phoneNumber [description]
	 * @return [type]              [description]
	 */
	public function duanxinbao($verfyCode,$phoneNumber)
	{
		
		$content = '您的验证码为'.$verfyCode.'，在10分钟内有效。';
		
		$smsapi = "http://api.smsbao.com/"; //短信网关
		$user = WSTConf("CONF.smsKey"); //短信平台帐号
		$pass = md5(WSTConf("CONF.smsPass")); //短信平台密码
		$content="【".WSTConf("CONF.smsName")."】".$content;//要发送的短信内容
		$phone = $phoneNumber;
		$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
		
		$result =file_get_contents($sendurl) ;
		
		

		
		if($result != 0){
			return WSTReturn("短信发送失败!");
		}else{
			return WSTReturn("短信发送成功!",1);
		}
	}

	/**
	 * 阿里短信
	 * @author lukui  2017-12-07
	 * @param  [type] $verfyCode   [description]
	 * @param  [type] $phoneNumber [description]
	 * @return [type]              [description]
	 */
	public function alisms($code,$phone)
	{
		;
		// 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置雉短信接收号码
        $request->setPhoneNumbers($phone);

        // 必填，设置签名名称
        $request->setSignName(WSTConf("CONF.smsName"));

        // 必填，设置模板CODE
        $request->setTemplateCode(WSTConf("CONF.ALsmsCode"));

        // 可选，设置模板参数
        $templateParam = Array( "code"=>$code);

        if($templateParam) {
            $request->setTemplateParam(json_encode($templateParam));
        }

        // 暂时不支持多Region
        $region = "cn-hangzhou";
        // 服务结点
        $endPointName = "cn-hangzhou";
        // 短信API产品名
        $product = "Dysmsapi";
        // 短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        // 初始化用户Profile实例
        $profile = DefaultProfile::getProfile($region, WSTConf("CONF.ALsmsKey"), WSTConf("CONF.ALsmsPass"));

        // 增加服务结点
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

        $this->acsClient = new DefaultAcsClient($profile);
        
        // 发起访问请求
        $acsResponse = $this->acsClient->getAcsResponse($request);

        // 打印请求结果
        // var_dump($acsResponse);
        $array = json_decode(json_encode($acsResponse),TRUE);
        
        if(isset($array['Code']) && $array['Code'] == "OK"){
			return WSTReturn("短信发送成功!",1);
		}else{
			return WSTReturn("短信发送失败!");
		}
	}

	/**
	 * 写入并发送短讯记录
	 */
	/*
	public function sendSMS($smsSrc,$phoneNumber,$content,$smsFunc,$verfyCode){
		$USER = session('WST_USER');
		$userId = empty($USER)?0:$USER['userId'];
		$ip = request()->ip();
		
		//检测短信验证码验证是否正确
		if(WSTConf("CONF.smsVerfy")==1){
			$smsverfy = input("post.smsVerfy");
			$rs = WSTVerifyCheck($smsverfy);
			if(!$rs){
				return WSTReturn("验证码不正确!");
			}
		}
		//检测是否超过每日短信发送数
		$date = date('Y-m-d');
		$smsRs = $this->field("count(smsId) counts,max(createTime) createTime")
			 		  ->where(["smsPhoneNumber"=>$phoneNumber])
		 	          ->whereTime('createTime', 'between', [$date.' 00:00:00', $date.' 23:59:59'])->find();
		if($smsRs['counts']>(int)WSTConf("CONF.smsLimit")){
			return WSTReturn("请勿频繁发送短信验证!");
		}
		if($smsRs['createTime'] !='' && ((time()-strtotime($smsRs['createTime']))<120)){
			return WSTReturn("请勿频繁发送短信验证!");
		}
		//检测IP是否超过发短信次数
		$ipRs = $this->field("count(smsId) counts,max(createTime) createTime")
					 ->where(["smsIP"=>$ip])
					 ->whereTime('createTime', 'between', [$date.' 00:00:00', $date.' 23:59:59'])->find();
		if($ipRs['counts']>(int)WSTConf("CONF.smsLimit")){
			return WSTReturn("请勿频繁发送短信验证!");
		}
		if($ipRs['createTime']!='' && ((time()-strtotime($ipRs['createTime']))<120)){
			return WSTReturn("请勿频繁发送短信验证!");
		}
		$code = WSTSendSMS($phoneNumber,$content);
		$data = array();
		$data['smsSrc'] = $smsSrc;
		$data['smsUserId'] = $userId;
		$data['smsPhoneNumber'] = $phoneNumber;
		$data['smsContent'] = $content;
		$data['smsReturnCode'] = $code;
		$data['smsCode'] = $verfyCode;
		$data['smsIP'] = $ip;
		$data['smsFunc'] = $smsFunc;
		$data['createTime'] = date('Y-m-d H:i:s');
		$this->data($data)->save();
		if(intval($code)>0){
			return WSTReturn("短信发送成功!",1);
		}else{
			return WSTReturn("短信发送失败!");
		}
	}
	*/
}
