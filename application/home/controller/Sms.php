<?php
namespace application\home\controller;

use think\Controller;
class Sms extends Controller{


	public function testsend()
	{
		$code = 458645;
		$res = $this->sendsms( $code ,15769272583);
		dump($res);
	}

	/**
	 * 短信宝 http://www.smsbao.com/
	 */
	
	public function sendsms( $code ,$phone)
	{
		$conf = getconf('');

		if(!$code){
			return false;
		}

		if(!$phone){
			return false;
		}

		$content = '您的验证码为'.$code.'，在10分钟内有效。';
		
		$smsapi = "http://api.smsbao.com/"; //短信网关
		$user = $conf['msm_appkey']; //短信平台帐号
		$pass = md5($conf['msm_secretkey']); //短信平台密码
		$content="【".$conf['msm_SignName']."】".$content;//要发送的短信内容
		$phone = $phone;
		$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
		
		$result =file_get_contents($sendurl) ;
		if($result != 0){
			return false;
		}else{
			return true;
		}

	}
}