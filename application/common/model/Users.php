<?php
namespace application\common\model;
use Think\Db;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 用户类
 */
class Users extends Base{
    /**
     * 用户登录验证
     */
    public function checkLogin(){
    	$loginName = input("post.loginName");
    	$loginPwd = input("post.loginPwd");
    	$code = input("post.verifyCode");
    	$rememberPwd = input("post.rememberPwd",1);
        /*
    	if(!WSTVerifyCheck($code) && strpos(WSTConf("CONF.captcha_model"),"4")>=0){
    		return WSTReturn('验证码错误!');
    	}
        */
    	$rs = $this->where("loginName|userEmail|userPhone",$loginName)
    				->where(["dataFlag"=>1, "userStatus"=>1])
    				->find();
    	if(!empty($rs)){
    		$userId = $rs['userId'];
    		//获取用户等级
	    	$rrs = Db::name('user_ranks')->where('startScore','<=',$rs['userTotalScore'])->where('endScore','>=',$rs['userTotalScore'])->field('rankId,rankName,rebate,userrankImg')->find();
	    	$rs['rankId'] = $rrs['rankId'];
	    	$rs['rankName'] = $rrs['rankName'];
	    	$rs['userrankImg'] = $rrs['userrankImg'];
    		if(input("post.typ")==2){
    			$shoprs=$this->where(["dataFlag"=>1, "userStatus"=>1,"userType"=>1,"userId"=>$userId])->find();
    			if(empty($shoprs)){
    				return WSTReturn('您还没申请店铺!');
    			}
    		}
    		if($rs['loginPwd']!=md5($loginPwd.$rs['loginSecret']))return WSTReturn("密码错误");
    		$ip = request()->ip();
    		$this->where(["userId"=>$userId])->update(["lastTime"=>date('Y-m-d H:i:s'),"lastIP"=>$ip]);
    		//如果是店铺则加载店铺信息
    		if($rs['userType']>=1){
    			$shop = model('shops')->where(["userId"=>$userId,"dataFlag" =>1])->find();
    			if(!empty($shop))$rs = array_merge($shop->toArray(),$rs->toArray());
    		}
    		//记录登录日志
    		$data = array();
    		$data["userId"] = $userId;
    		$data["loginTime"] = date('Y-m-d H:i:s');
    		$data["loginIp"] = $ip;

            $data["chrome"] = get_broswer();
			// $data["address"] = GetIpLookup($ip,1);
			$data["address"] = "";
            $data["OS"] = get_os();
            $data["isMobile"] = isMobile();
            
    		Db::name('log_user_logins')->insert($data);
    
    		$rd = $rs;
    		//记住密码
    		cookie("loginName", $loginName, time()+3600*24*90);
    		if($rememberPwd == "on"){
    			$datakey = md5($rs['loginName'])."_".md5($rs['loginPwd']);
    			$key = $rs['loginSecret'];
    			//加密
    			$base64 = new \org\Base64();
    			$loginKey = $base64->encrypt($datakey, $key);
    			cookie("loginPwd", $loginKey, time()+3600*24*90);
    		}else{
    			cookie("loginPwd", null);
    		}
    		session('WST_USER',$rs);
    		return WSTReturn("","1");
    	}
    	return WSTReturn("用户不存在");
    }
    
    /**
     * 会员注册
     */
    public function regist(){
    	
    	$data = array();
    	$data['loginName'] = input("post.loginName");
    	$data['loginPwd'] = input("post.loginPwd");
    	$data['reUserPwd'] = input("post.reUserPwd");
        $data['usercode'] = input("post.usercode");
        
    	$loginName = $data['loginName'];
    	//检测账号是否存在
    	$crs = WSTCheckLoginKey($loginName);
    	if($crs['status']!=1)return $crs;
    	if($data['loginPwd']!=$data['reUserPwd']){
    		return WSTReturn("两次输入密码不一致!");
    	}
        
    	foreach ($data as $key=>$v){
    		if($v ==''){
    			return WSTReturn("注册信息不完整!");
    		}
    	}
    	$nameType = (int)input("post.nameType");
    	$mobileCode = input("post.mobileCode");
    	$code = input("post.verifyCode");
    	if($nameType!=3 && !WSTVerifyCheck($code)){
    		return WSTReturn("验证码错误!");
    	}
    	if($nameType==3 && WSTConf("CONF.phoneVerfy")==1){//手机号码
    		$data['userPhone'] = $loginName;
    		$verify = session('VerifyCode_userPhone');
    		$startTime = (int)session('VerifyCode_userPhone_Time');
    		if((time()-$startTime)>120){
    			return WSTReturn("验证码已超过有效期!");
    		}
    		if($mobileCode=="" || $verify != $mobileCode){
    			return WSTReturn("验证码错误!");
    		}
    		$loginName = WSTRandomLoginName($loginName);
    	}else if($nameType==1){//邮箱注册
    		$data['userEmail'] = $loginName;
    		$unames = explode("@",$loginName);
    		$loginName = WSTRandomLoginName($unames[0]);
    		
    	}
    	if($loginName=='')return WSTReturn("注册失败!");//分派不了登录名
    	$data['loginName'] = $loginName;
    	unset($data['reUserPwd']);
    	unset($data['protocol']);
    	//检测账号，邮箱，手机是否存在
    	$data["loginSecret"] = rand(1000,9999);
    	$data['loginPwd'] = md5($data['loginPwd'].$data['loginSecret']);
    	$data['userType'] = 0;
    	$data['userPhone'] = input("post.loginName");
        $data['userName'] = input("post.userName");
    	$data['userQQ'] = "";
    	$data['userScore'] = 0;
    	$data['createTime'] = date('Y-m-d H:i:s');
    	$data['dataFlag'] = 1;
        //邀请码
        
        
        if(cookie('fid')){
            $data['usercode'] = $this->where('userId',cookie('fid'))->value('usercode');
            if(!$data['usercode']) return WSTReturn("该邀请码无效!");
			
			
        }

		
		$codeuser = $this->where('usercode',$data['usercode'])->find();
	
		if(!$codeuser) return WSTReturn("该邀请码无效!");
		if($codeuser['uq'] == 104){

			$data['par103'] = $codeuser['par103'];
			$data['par102'] = $codeuser['par102'];
			$data['par101'] = $codeuser['par101'];
			$data['oid'] = $codeuser['oid'];

		}elseif($codeuser['uq'] == 103){

			$data['par103'] = $codeuser['userId'];
			$data['par102'] = $codeuser['par102'];
			$data['par101'] = $codeuser['par101'];
			$data['oid'] = $codeuser['userId'];

		}elseif($codeuser['uq'] == 102){

			$data['par103'] = 0;
			$data['par102'] = $codeuser['userId'];
			$data['par101'] = $codeuser['par101'];
			$data['oid'] = $codeuser['userId'];
		}else{
			$data['par103'] = 0;
			$data['par102'] = 0;
			$data['par101'] = $codeuser['userId'];
			$data['oid'] = $codeuser['userId'];
		}
		
        

        
        
        
        $data['usercode'] = getRandomString(4);

        

    	Db::startTrans();
        try{
	    	$userId = $this->data($data)->save();
	    	if(false !== $userId){
	    		$data = array();
	    		$ip = request()->ip();
	    		$data['lastTime'] = date('Y-m-d H:i:s');
	    		$data['lastIP'] = $ip;
	    		$userId = $this->userId;
	    		$this->where(["userId"=>$userId])->update($data);
	    		//记录登录日志
	    		$data = array();
	    		$data["userId"] = $userId;
	    		$data["loginTime"] = date('Y-m-d H:i:s');
	    		$data["loginIp"] = $ip;
	    		Db::name('log_user_logins')->insert($data);
	    		$user = $this->get($userId);
	    		session('WST_USER',$user);
	    		Db::commit();
	    		return WSTReturn("",1);
	    	}
        }catch (\Exception $e) {
        	Db::rollback();
        }
    	return WSTReturn("注册失败!");
    }
	
	
	public function wx_regist($wx_info){
    	
    	$data = array();
    	$data['loginName'] = $wx_info['nickname'];
    	$data['loginPwd'] = '123456';
    	$data['reUserPwd'] = '123456';
        
    	$loginName = $data['loginName'];
    	//检测账号是否存在
    	//$crs = WSTCheckLoginKey($loginName);
    	//if($crs['status']!=1)return $crs;
    	if($data['loginPwd']!=$data['reUserPwd']){
    		return WSTReturn("两次输入密码不一致!");
    	}
        
    	
    	
    	
    	$data['loginName'] = $loginName;
    	unset($data['reUserPwd']);
    	//检测账号，邮箱，手机是否存在
    	$data["loginSecret"] = rand(1000,9999);
    	$data['loginPwd'] = md5($data['loginPwd'].$data['loginSecret']);
		$data['userPhoto'] = $wx_info['headimgurl'];
		$data['openid'] = $wx_info['openid'];
    	$data['userType'] = 0;
        $data['userName'] = $wx_info['nickname'];
    	$data['userQQ'] = "";
    	$data['userScore'] = 0;
    	$data['createTime'] = date('Y-m-d H:i:s');
    	$data['dataFlag'] = 1;
        //邀请码
        
        
        if(session('fid')){
            $data['usercode'] = $this->where('userId',session('fid'))->value('usercode');
            if(!$data['usercode']) return WSTReturn("该邀请码无效-!");
			
			$codeuser = $this->where('usercode',$data['usercode'])->find();
			
			if(!$codeuser) return WSTReturn("该邀请码无效--!");
			if($codeuser['uq'] == 104){

				$data['par103'] = $codeuser['par103'];
				$data['par102'] = $codeuser['par102'];
				$data['par101'] = $codeuser['par101'];

			}elseif($codeuser['uq'] == 103){

				$data['par103'] = $codeuser['userId'];
				$data['par102'] = $codeuser['par102'];
				$data['par101'] = $codeuser['par101'];

			}elseif($codeuser['uq'] == 102){

				$data['par103'] = 0;
				$data['par102'] = $codeuser['userId'];
				$data['par101'] = $codeuser['par101'];
			}else{

				$data['par101'] = $codeuser['userId'];
				$data['par102'] = 0;
				$data['par103'] = 0;

			}

			$data['oid'] = $codeuser['userId'];
			session('fid',null);
		}

        
        
        
        $data['usercode'] = getRandomString(4);

        //$data['userMoney'] = 100000;

    	Db::startTrans();
        try{
	    	$userId = $this->data($data)->save();
	    	if(false !== $userId){
	    		$data = array();
	    		$ip = request()->ip();
	    		$data['lastTime'] = date('Y-m-d H:i:s');
	    		$data['lastIP'] = $ip;
	    		$userId = $this->userId;
	    		$this->where(["userId"=>$userId])->update($data);
	    		//记录登录日志
	    		$data = array();
	    		$data["userId"] = $userId;
	    		$data["loginTime"] = date('Y-m-d H:i:s');
	    		$data["loginIp"] = $ip;
	    		Db::name('log_user_logins')->insert($data);
	    		$user = $this->get($userId);
	    		session('WST_USER',$user);
	    		Db::commit();
	    		return WSTReturn("",1);
	    	}
        }catch (\Exception $e) {
        	Db::rollback();
        }
    	return WSTReturn("注册失败!");
    }
	
	
	public function wxregist($uid){
		$_user = $this->where('userId',$uid)->find();
		$data = array();
    	$data['userPhone'] = input("post.loginName");
    	$data['loginPwd'] = input("post.loginPwd");
    	$data['reUserPwd'] = input("post.reUserPwd");
        $data['usercode'] = input("post.usercode");
        
    	$loginName = $data['userPhone'];
    	
    	
    	if($data['loginPwd']!=$data['reUserPwd']){
    		return WSTReturn("两次输入密码不一致!");
    	}
        
    	
    	$nameType = (int)input("post.nameType");
    	$mobileCode = input("post.mobileCode");
    	$code = input("post.verifyCode");
    	if($nameType!=3 && !WSTVerifyCheck($code)){
    		return WSTReturn("验证码错误!");
    	}
    	if($nameType==3 && WSTConf("CONF.phoneVerfy")==1){//手机号码
    		$data['userPhone'] = $loginName;
    		$verify = session('VerifyCode_userPhone');
    		$startTime = (int)session('VerifyCode_userPhone_Time');
    		if((time()-$startTime)>120){
            return WSTReturn("验证码已超过有效期!");
			}
    		if($mobileCode=="" || $verify != $mobileCode){
    			return WSTReturn("验证码错误!");
    		}
    		$loginName = WSTRandomLoginName($loginName);
    	}else if($nameType==1){//邮箱注册
    		$data['userEmail'] = $loginName;
    		$unames = explode("@",$loginName);
    		$loginName = WSTRandomLoginName($unames[0]);
    		
    	}
    	if($loginName=='')return WSTReturn("注册失败!");//分派不了登录名
    	$data['loginName'] = $loginName;
    	unset($data['reUserPwd']);
    	unset($data['protocol']);
    	//检测账号，邮箱，手机是否存在
    	
    	$data['loginPwd'] = md5($data['loginPwd'].$_user['loginSecret']);
    	$data['userPhone'] = input("post.loginName");
        //邀请码
        
        
        if(cookie('fid')){
            $data['usercode'] = $this->where('userId',cookie('fid'))->value('usercode');
            if(!$data['usercode']) return WSTReturn("该邀请码无效!");
        }
	
		if($data['usercode']){
			$codeuser = $this->where('usercode',$data['usercode'])->find();
        
			if(!$codeuser) return WSTReturn("该邀请码无效!");
			if($codeuser['uq'] == 104){

				$data['par103'] = $codeuser['par103'];
				$data['par102'] = $codeuser['par102'];
				$data['par101'] = $codeuser['par101'];

			}elseif($codeuser['uq'] == 103){

				$data['par103'] = $codeuser['userId'];
				$data['par102'] = $codeuser['par102'];
				$data['par101'] = $codeuser['par101'];

			}elseif($codeuser['uq'] == 102){

				$data['par103'] = 0;
				$data['par102'] = $codeuser['userId'];
				$data['par101'] = $codeuser['par101'];
			}else{

				$data['par101'] = $codeuser['userId'];
				$data['par102'] = 0;
				$data['par103'] = 0;

			}

			$data['oid'] = $codeuser['userId'];
			
			
			
		}
		unset($data['usercode']);
        $ids = $this->where('userId',$uid)->update($data);

		if($ids){
			return WSTReturn("",1);
		}else{
			return WSTReturn("注册失败!");
		}

    	
	}
    
    /**
     * 查询用户手机是否存在
     * 
     */
    public function checkUserPhone($userPhone,$userId = 0){
    	$dbo = $this->where(["dataFlag"=>1, "userPhone"=>$userPhone]);
    	if($userId>0){
    		$dbo->where("userId","<>",$userId);
    	}
    	$rs = $dbo->count();
    	if($rs>0){
    		return WSTReturn("手机号已存在!");
    	}else{
    		return WSTReturn("",1);
    	}
    }

    /**
     * 修改用户密码
     */
    public function editPass(){
    	$data = array();
        $post = input('post.');
        
    	$data["loginPwd"] = input("post.loginPwd");

    	if(!$data["loginPwd"]){
    		return WSTReturn('密码不能为空',-1);
    	}
        if($post['loginPwd'] != $post['loginPwd']){
            return WSTReturn('两次密码输入不同',-1);
        }



        $mobileCode = input("post.mobileCode");
        $verify = session('VerifyCode_userPhone');
        $startTime = (int)session('VerifyCode_userPhone_Time');
		if((time()-$startTime)>120){
            return WSTReturn("验证码已超过有效期!");
        }
        if($mobileCode=="" || $verify != $mobileCode){
            return WSTReturn("验证码错误!");
        }

        if(isset($post['userId']) && $post['userId'] > 0){
            $id = $post['userId'];
            $rs = $this->where('userId='.$id)->find();
        }else{
            $rs = $this->where('userPhone='.$post['userPhone'])->find();
            $id = $rs['userId'];
        }
        

    	//核对密码
    	if($rs){
    		$data["loginPwd"] = md5(input("post.loginPwd").$rs['loginSecret']);
            $rs = $this->update($data,['userId'=>$id]);
            if(false !== $rs){
                return WSTReturn("密码修改成功", 1);
            }else{
                return WSTReturn($this->getError(),-1);
            }
    	}else{
    		return WSTReturn("用户不存在");
    	}
    }
    /**
     * 修改用户支付密码
     */
    public function editPayPass($id){
        $data = array();
        $data["payPwd"] = input("post.newPass");
        if(!$data["payPwd"]){
            return WSTReturn('支付密码不能为空',-1);
        }
        $rs = $this->where('userId='.$id)->find();
        //核对密码
        if($rs['payPwd']){
            if($rs['payPwd']==md5(input("post.oldPass").$rs['loginSecret'])){
                $data["payPwd"] = md5($data["payPwd"].$rs['loginSecret']);
                $rs = $this->update($data,['userId'=>$id]);
                if(false !== $rs){
                    return WSTReturn("支付密码修改成功", 1);
                }else{
                    return WSTReturn("支付密码修改失败",-1);
                }
            }else{
                return WSTReturn('原始支付密码错误',-1);
            }
        }else{
            $data["payPwd"] = md5($data["payPwd"].$rs['loginSecret']);
            $rs = $this->update($data,['userId'=>$id]);
            if(false !== $rs){
                return WSTReturn("支付密码修改成功", 1);
            }else{
                return WSTReturn("支付密码修改失败",-1);
            }
        }
    }
   /**
    *  获取用户信息
    */
    public function getById($id){
    	$rs = $this->get(['userId'=>(int)$id]);
    	$rs['ranks'] = Db::name('user_ranks')->where('startScore','<=',$rs['userTotalScore'])->where('endScore','>=',$rs['userTotalScore'])->field('rankId,rankName,rebate,userrankImg')->find();
    	return $rs;
    }
    /**
     * 编辑资料
    */
    public function edit(){
    	$Id = (int)session('WST_USER.userId');
    	$data = input('post.');
    	WSTAllow($data,'brithday,trueName,userName,userId,userPhoto,userQQ,userSex');
    	Db::startTrans();
		try{
            if(isset($data['userPhoto']))
			     WSTUseImages(0, $Id, $data['userPhoto'],'users','userPhoto');
             
	    	$result = $this->allowField(true)->save($data,['userId'=>$Id]);
	    	if(false !== $result){
	    		Db::commit();
	    		return WSTReturn("编辑成功", 1);
	    	}
		}catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('编辑失败',-1);
        }	
    }
    /**
    * 绑定邮箱
     */
    public function editEmail($userId,$userEmail){
    	$data = array();
    	$data["userEmail"] = $userEmail;
		$rs = $this->update($data,['userId'=>$userId]);
		if(false !== $rs){
			return WSTReturn("",1);
		}else{
			return WSTReturn("",-1);
		}
    }
    /**
     * 绑定手机
     */
    public function editPhone($userId,$userPhone){
    	$data = array();
    	$data["userPhone"] = $userPhone;
    	$rs = $this->update($data,['userId'=>$userId]);
    	if(false !== $rs){
    		return WSTReturn("绑定成功", 1);
    	}else{
    		return WSTReturn($this->getError(),-1);
    	}
    }
    /**
     * 查询并加载用户资料
     */
    public function checkAndGetLoginInfo($key){
    	if($key=='')return array();
    	$rs = $this->where(["loginName|userEmail|userPhone"=>['=',$key],'dataFlag'=>1])->find();
    	return $rs;
    }
    /**
     * 重置用户密码
     */
    public function resetPass(){
    	if(time()>floatval(session('REST_Time'))+30*60){
    		return WSTReturn("连接已失效！", -1);
    	}
    	$reset_userId = (int)session('REST_userId');
    	if($reset_userId==0){
    		return WSTReturn("无效的用户！", -1);
    	}
    	$user = $this->where(["dataFlag"=>1,"userStatus"=>1,"userId"=>$reset_userId])->find();
    	if(empty($user)){
    		return WSTReturn("无效的用户！", -1);
    	}
    	$loginPwd = input("post.loginPwd");
    	if(trim($loginPwd)==''){
    		return WSTReturn("无效的密码！", -1);
    	}
    	$data['loginPwd'] = md5($loginPwd.$user["loginSecret"]);
    	$rc = $this->update($data,['userId'=>$reset_userId]);
    	if(false !== $rc){
    		return WSTReturn("修改成功", 1);
    	}
    	session('REST_userId',null);
    	session('REST_Time',null);
    	session('REST_success',null);
    	session('findPass',null);
    	return $rs;
    }
    
    /**
     * 获取用户可用积分
     */
    public function getFieldsById($userId,$fields){
    	return $this->where(['userId'=>$userId,'dataFlag'=>1])->field($fields)->find();
    }
}
