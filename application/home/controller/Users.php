<?php
namespace application\home\controller;
use application\common\model\Users as MUsers;
use application\common\model\LogSms;
/**
 

 
 

 
 * 用户控制器
 */
use think\Controller;
class Users extends Controller{
    public function __construct(){
        parent::__construct();

        $webisopen = WSTConf('CONF.webisopen');
        if(!$webisopen){
            $this->redirect("/error.html");
        }
        
        $this->assign("v",time());
		
		$USER = session('WST_USER');
		
        if($USER && isset($USER['userId'])){
            
            $users = db('users')->where('userId',$USER['userId'])->find();
            
            $this->assign('users',$users);
            $this->uid = $USER['userId'];
            $this->users = $users;
        }

        $request = request();
        $controller = $request->controller();
        $action = $request->action();
        $this->assign('controller',$controller);
        $this->assign('action',$action);
        
        //时时彩倒计时
        $this->ssc_time = get_ssr_time(1);
        $this->assign('ssc_time',$this->ssc_time);
        
    }
	/**
     * 去登录
     */
	public function login(){
		$USER = session('WST_USER');
		//如果已经登录了则直接跳去用户中心
		if(!empty($USER) && $USER['userId']!=''){
			$this->redirect("users/index");
		}
		$loginName = cookie("loginName");
		if(!empty($loginName)){
			$this->assign('loginName',cookie("loginName"));
		}else{
			$this->assign('loginName','');
		}
		
		if(iswechat() && WSTConf('CONF.iswxlogin') == 1){
    		//微信浏览器 微信登录
			
    		if(session('wx_info')){
				
    			$wx_info = session('wx_info');
				
    			$data['openid'] = $wx_info['openid'];
    			$checkuser = model('users')->where($data)->find();
				
    			//判断是否已经注册
    			if($checkuser){  //已经注册直接记录session
    				//记录登录日志
					$ip = request()->ip();
					$data = array();
					$data["userId"] = $checkuser['userId'];
					$data["loginTime"] = date('Y-m-d H:i:s');
					$data["loginIp"] = $ip;

					$data["chrome"] = get_broswer();
					$data["address"] = GetIpLookup($ip,1);
					$data["OS"] = get_os();
					$data["isMobile"] = isMobile();
					
					db('log_user_logins')->insert($data);
					session('wx_info',null);
					session('WST_USER',$checkuser);
					$this->redirect("users/index");
                    
    			}else{  //未注册 
    				$res = model('users')->wx_regist($wx_info);
					
					
					
					session('wx_info',null);
					
					if($res['status'] == -1){
						$this->error($res['msg']);
					}
					$this->redirect('users/addpwd');
    			}
    		}else{
    			$this->redirect('wechat/get_wx_userinfo');
    			
    		}

    	}
		
		return $this->fetch('user_login');
	}

    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        $style = WSTConf('CONF.wstPCStyle')?WSTConf('CONF.wsthomeStyle'):WSTConf('CONF.homePath');
        $replace['__STYLE__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/application/home/view/'.WSTConf('CONF.homePathStyle');
        return $this->view->fetch($style."/".$template, $vars, $replace, $config);
    }
	
	
	public  function addpwd(){
		$this->redirect("users/index");
		return $this->fetch('addpwd');
	}
		    
    /**
	 * 用户退出
	 */
	public function logout(){
		session('WST_USER',null);
		session('wx_info',null);
		setcookie("loginPwd", null);

		return WSTReturn("",1);
	}
	
	/**
     * 用户注册
     * 
     */
	public function regist(){
		$loginName = session("loginName");
		if(!empty($loginName)){
			$this->assign('loginName',session("loginName"));
		}else{
			$this->assign('loginName','');
		}

        $fid = session("fid");
        if(!empty($fid)){
            $usercode = db('users')->where('userId',session('fid'))->value('usercode');
            $this->assign('usercode',$usercode);
        }else{
            $this->assign('usercode','');
        }

        

		return $this->fetch('regist');
	}
	
	
	/**
	 * 新用户注册
	 */
	public function toRegist(){
		$m = new MUsers();
		$rs = $m->regist();
		return $rs;
	
	}
	
	/**
	 * 新用户注册
	 */
	public function towxRegist(){
		$m = new MUsers();
		$rs = $m->wxregist($this->uid);
		return $rs;
	
	}
	
	/**
	 * 验证登陆
	 *
	 */
	public function checkLogin(){
		$m = new MUsers();
        $rs = $m->checkLogin();
    	return $rs;
	}

	/**
	 * 获取验证码
	 */
	public function getPhoneVerifyCode(){
		$userPhone = input("post.userPhone");
        $isres = input("post.isres",0);
		$rs = array();
		if(!WSTIsPhone($userPhone)){
			return WSTReturn("手机号格式不正确!");
			exit();
		}
		$m = new MUsers();
		$rs = $m->checkUserPhone($userPhone,(int)session('WST_USER.userId'));
		if($rs["status"]!=1 && $isres == 0){
			return WSTReturn("手机号已存在!");
			exit();
		}
		$phoneVerify = rand(100000,999999);

        $m = new LogSms();
        $msg = '';
        
        $rv = $m->sendSMS(0,$userPhone,$msg,'getPhoneVerifyCode',$phoneVerify);
        /*
		$msg = "欢迎您注册成为".WSTConf("CONF.mallName")."会员，您的注册验证码为:".$phoneVerify."，请在10分钟内输入。【".WSTConf("mallName")."】";
		$m = new LogSms();
		$rv = $m->sendSMS(0,$userPhone,$msg,'getPhoneVerifyCode',$phoneVerify);
        */
		if($rv['status']==1){
			session('VerifyCode_userPhone',$phoneVerify);
			session('VerifyCode_userPhone_Time',time());
		}
		return $rv;
	}
	
	
	/**
	 * 判断手机或邮箱是否存在
	 */
	public function checkLoginKey(){
		$m = new MUsers();
		if(input("post.loginName"))$val=input("post.loginName");
		if(input("post.userPhone"))$val=input("post.userPhone");
		if(input("post.userEmail"))$val=input("post.userEmail");
		$rs = WSTCheckLoginKey($val);
		if($rs["status"]==1){
			return array("ok"=>"");
		}else{
			return array("error"=>$rs["msg"]);
		}
	}
	
	/**
	 * 判断邮箱是否存在
	 */
	public function checkEmail(){
		$data = $this->checkLoginKey();
		if(isset($data['error']))$data['error'] = '对不起，该邮箱已存在';
		return $data;
	}
	
	/**
	 * 判断用户名是否存在/忘记密码
	 */
	public function checkFindKey(){
		$m = new MUsers();
		$userId = (int)session('WST_USER.userId');
		$rs = WSTCheckLoginKey(input("post.loginName"),$userId);
		if($rs["status"]==1){
			return array("error"=>"该用户不存在！");
		}else{
			return array("ok"=>"");
		}
	
	}
	
	/**
	 * 跳到用户注册协议
	 */
	public function protocol(){
		return $this->fetch("user_protocol");
	}
	
	/**
	 * 用户中心
	 */
	public function index(){
		session('WST_MENID0',0);
		session('WST_MENUID30',0);
        //佣金
        $map['targetType'] = 1;
        $map['targetId'] = $this->uid;
        $yongjin = db('log_moneys')->where($map)->sum('money');
        if(!$yongjin) $yongjin = 0;

        //今日数据
        $db_drorder = db('drorder');
        $jr_map['userId'] = $this->uid;
        $jinri['canyu'] = $db_drorder->where($jr_map)->wheretime('createTime','d')->count();
        
        $jr_map['iswin'] = 1;
        $jinri['win'] = $db_drorder->where($jr_map)->wheretime('createTime','d')->count();

        $jr_map['iswin'] = 2;
        $jinri['loss'] = $db_drorder->where($jr_map)->wheretime('createTime','d')->count();

        $this->assign('jinri',$jinri);
        $this->assign('yongjin',$yongjin);
		return $this->fetch('users/index');
	}
	

	/**
	* 跳去修改个人资料
	*/
	public function edit(){
		$m = new MUsers();
		//获取用户信息
		$userId = (int)session('WST_USER.userId');
        $data = $m->getById($userId);
        $this->assign('data',$data);
		return $this->fetch('users/user_edit');
	}
	
	/**
    * 修改
    */
    public function toEdit(){
        $m = new MUsers();
        $rs = $m->edit();
        return $rs;
    }
    /**
     * 安全设置页
     */
    public function security(){
    	//获取用户信息
    	$m = new MUsers();
    	$data = $m->getById((int)session('WST_USER.userId'));
    	if($data['userPhone']!='')$data['userPhone'] = WSTStrReplace($data['userPhone'],'*',3);
    	if($data['userEmail']!='')$data['userEmail'] = WSTStrReplace($data['userEmail'],'*',2,'@');
    	$this->assign('data',$data);
    	return $this->fetch('users/security/index');
    }
    /**
     * 修改邮箱页
     */
    public function editEmail(){
    	//获取用户信息
    	$userId = (int)session('WST_USER.userId');
    	$m = new MUsers();
    	$data = $m->getById($userId);
    	if($data['userEmail']!='')$data['userEmail'] = WSTStrReplace($data['userEmail'],'*',2,'@');
    	$this->assign('data',$data);
    	$process = 'One';
    	$this->assign('process',$process);
    	if($data['userEmail']){
    		return $this->fetch('users/security/user_edit_email');
    	}else{
    		return $this->fetch('users/security/user_email');
    	}
    }
    /**
     * 发送验证邮件/绑定邮箱
     */
    public function getEmailVerify(){
    	$userEmail = input('post.userEmail');
    	if(!$userEmail){
    		return WSTReturn('请输入邮箱!',-1);
    	}
    	$code = input("post.verifyCode");
    	$process = input("post.process");
    	if(!WSTVerifyCheck($code)){
    		return WSTReturn('验证码错误!',-1);
    	}
    	$rs = WSTCheckLoginKey($userEmail,(int)session('WST_USER.userId'));
    	if($rs["status"]!=1){
    		return WSTReturn("邮箱已存在!");
    		exit();
    	}
    	$key = base64_encode($userEmail."_".session('WST_USER.userId')."_".time()."_".$process.'_'.md5(session('WST_USER.loginSecret')));
    	$url = url('home/users/emailEdit',array('key'=>$key),true,true);
    	$html="您好，会员 ".session('WST_USER.loginName')."：<br>
		您在".date('Y-m-d H:i:s')."发出了绑定邮箱的请求,请点击以下链接进行绑定邮箱:<br>
		<a href='".$url."'>".$url."</a><br>
		<br>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中。<br>
		该验证邮件有效期为30分钟，超时请重新发送邮件。<br>
		<br><br>*此邮件为系统自动发出的，请勿直接回复。";
    	$sendRs = WSTSendMail($userEmail,'绑定邮箱',$html);
    	if($sendRs['status']==1){
    		return WSTReturn('发送成功',1);
    	}else{
    		return WSTReturn($sendRs['msg'],-1);
    	}
    }
    /**
     * 绑定邮箱
     */
    public function emailEdit(){
    	$USER = session('WST_USER');
		if(empty($USER) && $USER['userId']==''){
			$this->redirect("home/users/login");
		}
    	$key = input('param.');
    	if($key['key']=='')$this->error('连接已失效！');
    	$key = $key['key'];
    	$key = base64_decode($key);
    	$key = explode('_',$key);
        $loginKey = md5(session('WST_USER.loginSecret'));
        if($loginKey!==$key[4])$this->error('无效的请求！');
    	if(time()>floatval($key[2])+30*60)$this->error('连接已失效！');
    	if(intval($key[1])==0)$this->error('无效的用户！');
    	$rs = WSTCheckLoginKey($key[1],(int)session('WST_USER.userId'));
    	if($rs["status"]!=1){
    		$this->error('邮箱已存在!');
    		exit();
    	}
    	$m = new MUsers();
    	$rs = $m->editEmail($key[1],$key[0]);
    	if($rs['status'] == 1){
    		$process = 'Three';
    		$this->assign('process',$process);
    		if($key[3]=='Two'){
    			return $this->fetch('users/security/user_edit_email');
    		}else{
    			return $this->fetch('users/security/user_email');
    		}
    	}
    	$this->error('绑定邮箱失败');
    }
    /**
     * 发送验证邮件/修改邮箱
     */
    public function getEmailVerifyt(){
    	$m = new MUsers();
    	$data = $m->getById(session('WST_USER.userId'));
    	$userEmail = $data['userEmail'];
    	if(!$userEmail){
    		return WSTReturn('请输入邮箱!',-1);
    	}
    	$code = input("post.verifyCode");
    	if(!WSTVerifyCheck($code)){
    		return WSTReturn('验证码错误!',-1);
    	}
    	$key = base64_encode("0_".session('WST_USER.userId')."_".time()."_".md5(session('WST_USER.loginSecret')));
    	$url = url('home/users/emailEditt',array('key'=>$key),true,true);
    	$html="您好，会员 ".session('WST_USER.loginName')."：<br>
		您在".date('Y-m-d H:i:s')."发出了修改邮箱的请求,请点击以下链接进行修改邮箱:<br>
		<a href='".$url."'>".$url."</a><br>
		<br>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中。<br>
		该验证邮件有效期为30分钟，超时请重新发送邮件。<br>
		<br><br>*此邮件为系统自动发出的，请勿直接回复。";
    	$sendRs = WSTSendMail($userEmail,'修改邮箱',$html);
    	if($sendRs['status']==1){
    		return WSTReturn('发送成功',1);
    	}else{
    		return WSTReturn($sendRs['msg'],-1);
    	}
    }
    /**
     * 修改邮箱
     */
    public function emailEditt(){
    	$USER = session('WST_USER');
    	if(empty($USER) && $USER['userId']!=''){
    		$this->redirect("home/users/login");
    	}
    	$key = input('param.');
    	if($key['key']=='')$this->error('连接已失效！');
    	$key = $key['key'];
    	$key = base64_decode($key);
        $loginKey = md5(session('WST_USER.loginSecret'));
    	$key = explode('_',$key);
        if($loginKey!= $key[3])$this->error('无效的请求！');
    	if(time()>floatval($key[2])+30*60)$this->error('连接已失效！');
    	if(intval($key[1])==0)$this->error('无效的用户！');
    	$m = new MUsers();
    	$data = $m->getById($key[1]);
    	if($data['userId']==session('WST_USER.userId')){
    		$process = 'Two';
    		$this->assign('process',$process);
    		return $this->fetch('users/security/user_edit_email');
    	}
        $this->error('无效的用户！');
    }
    /**
     * 修改手机页
     */
    public function editPhone(){
    	//获取用户信息
    	$userId = (int)session('WST_USER.userId');
    	$m = new MUsers();
    	$data = $m->getById($userId);
    	if($data['userPhone']!='')$data['userPhone'] = WSTStrReplace($data['userPhone'],'*',3);
    	$this->assign('data',$data);
    	$process = 'One';
    	$this->assign('process',$process);
    	if($data['userPhone']){
    		return $this->fetch('users/security/user_edit_phone');
    	}else{
    		return $this->fetch('users/security/user_phone');
    	}
    }
    /**
     * 跳到发送手机验证
     */
    public function toApply(){
    	return $this->fetch("user_verify_phone");
    }
    /**
     * 绑定手机/获取验证码
     */
    public function getPhoneVerifyo(){
    	$userPhone = input("post.userPhone");
    	if(!WSTIsPhone($userPhone)){
    		return WSTReturn("手机号格式不正确!");
    		exit();
    	}
    	$rs = array();
    	$m = new MUsers();
    	$rs = WSTCheckLoginKey($userPhone,(int)session('WST_USER.userId'));
    	if($rs["status"]!=1){
    		return WSTReturn("手机号已存在!");
    		exit();
    	}
    	$phoneVerify = rand(100000,999999);
    	$msg = "欢迎您".WSTConf("CONF.mallName")."会员，正在操作绑定手机，您的校验码为:".$phoneVerify."，请在10分钟内输入。【".WSTConf("mallName")."】";
    	$m = new LogSms();
    	$rv = $m->sendSMS(0,$userPhone,$msg,'getPhoneVerify',$phoneVerify);
    	if($rv['status']==1){
    		$USER = '';
    		$USER['userPhone'] = $userPhone;
    		$USER['phoneVerify'] = $phoneVerify;
    		session('Verify_info',$USER);
    		session('Verify_userPhone_Time',time());
    		return WSTReturn('短信发送成功!',1);
    	}
    	return $rv;
    }
    /**
     * 绑定手机
     */
    public function phoneEdito(){
    	$phoneVerify = input("post.Checkcode");
    	$process = input("post.process");
    	$timeVerify = session('Verify_userPhone_Time');
    	if(!session('Verify_info.phoneVerify') || time()>floatval($timeVerify)+10*60){
    		return WSTReturn("校验码已失效，请重新发送！");
    		exit();
    	}
   		if($phoneVerify==session('Verify_info.phoneVerify')){
   			$m = new MUsers();
   			$rs = $m->editPhone((int)session('WST_USER.userId'),session('Verify_info.userPhone'));
   			if($process=='Two'){
   				$rs['process'] = $process;
   			}else{
   				$rs['process'] = '0';
   			}
   			return $rs;
   		}
   		return WSTReturn("校验码不一致，请重新输入！");
    }
    public function editPhoneSu(){
    	$pr = input("get.pr");
    	$process = 'Three';
    	$this->assign('process',$process);
	    if($pr == 'Two'){
	    	return $this->fetch('users/security/user_edit_phone');
	    }else{
	    	return $this->fetch('users/security/user_phone');
	    }
    }
    /**
     * 修改手机/获取验证码
     */
    public function getPhoneVerifyt(){
    	$m = new MUsers();
    	$data = $m->getById(session('WST_USER.userId'));
    	$userPhone = $data['userPhone'];
    	$phoneVerify = rand(100000,999999);
    	$msg = "欢迎您".WSTConf("CONF.mallName")."会员，正在操作修改手机，您的校验码为:".$phoneVerify."，请在10分钟内输入。【".WSTConf("mallName")."】";
    	$m = new LogSms();
    	$rv = $m->sendSMS(0,$userPhone,$msg,'getPhoneVerify',$phoneVerify);
     	if($rv['status']==1){
	    	$USER = '';
	    	$USER['userPhone'] = $userPhone;
	    	$USER['phoneVerify'] = $phoneVerify;
	    	session('Verify_info2',$USER);
	    	session('Verify_userPhone_Time2',time());
	    	return WSTReturn('短信发送成功!',1);
    	}
    	return $rv;
    }
    /**
     * 修改手机
     */
    public function phoneEditt(){
    	$phoneVerify = input("post.Checkcode");
    	$timeVerify = session('Verify_userPhone_Time2');
    	if(!session('Verify_info2.phoneVerify') || time()>floatval($timeVerify)+10*60){
    		return WSTReturn("校验码已失效，请重新发送！");
    		exit();
    	}
    	if($phoneVerify==session('Verify_info2.phoneVerify')){
    		return WSTReturn("验证成功",1);
    	}
    	return WSTReturn("校验码不一致，请重新输入！",-1);
    }
    public function editPhoneSut(){
    	$process = 'Two';
    	$this->assign('process',$process);
    	if(session('Verify_info2.phoneVerify')){
    		return $this->fetch('users/security/user_edit_phone');
    	}
        $this->error('地址已失效，请重新验证身份');
    }
    
    /**
    * 处理图像裁剪
    */
    public function editUserPhoto(){
        $imageSrc = trim(input('post.photoSrc'),'/');
        $image = \image\Image::open($imageSrc);
        $x = (int)input('post.x');
        $y = (int)input('post.y');
        $w = (int)input('post.w',150);
        $h = (int)input('post.h',150);
        $rs = $image->crop($w, $h, $x, $y, 150, 150)->save($imageSrc);
        if($rs){
            return WSTReturn('',1,$imageSrc);
            exit;
        }
        return WSTReturn('发生未知错误.',-1);

    }
    
    /**
     * 忘记密码
     */
    public function forgetPass(){
    	return $this->fetch('user_pass');
    }
    public function forgetPasst(){
    	if(time()<floatval(session('findPass.findTime'))+30*60){
	    	$userId = session('findPass.userId');
	    	$m = new MUsers();
	    	$info = $m->getById($userId);
	    	if($info['userPhone']!='')$info['userPhone'] = WSTStrReplace($info['userPhone'],'*',3);
	    	if($info['userEmail']!='')$info['userEmail'] = WSTStrReplace($info['userEmail'],'*',2,'@');
	    	$this->assign('forgetInfo',$info);
	    	return $this->fetch('forget_pass2');
    	}else{
    		$this->error('页面已过期！');
    	}
    }
    public function forgetPasss(){
    	$USER = session('findPass');
    	if(empty($USER) && $USER['userId']!=''){
    		$this->error('请在同一浏览器操作！');
    	}
    	$key = input('param.');
    	if($key['key']=='')$this->error('连接已失效！');
    	$key = $key['key'];
    	$keyFactory = new \org\Base64();
    	$key = $keyFactory->decrypt($key,(int)session('findPass.loginSecret'));
    	$key = explode('_',$key);
    	if(time()>floatval($key[2])+30*60)$this->error('连接已失效！');
    	if(intval($key[1])==0)$this->error('无效的用户！');
    	session('REST_userId',$key[1]);
    	session('REST_Time',$key[2]);
    	session('REST_success','1');
    	return $this->fetch('forget_pass3');
    }
    public function forgetPassf(){
    	return $this->fetch('forget_pass4');
    }
    /**
     * 找回密码
     */
    public function findPass(){
    	//禁止缓存
    	header('Cache-Control:no-cache,must-revalidate');
    	header('Pragma:no-cache');
    	$code = input("post.verifyCode");
    	$step = input("post.step/d");
    	switch ($step) {
    		case 1:#第一步，验证身份
    			if(!WSTVerifyCheck($code)){
    				return WSTReturn('验证码错误!',-1);
    			}
    			$loginName = input("post.loginName");
    			$rs = WSTCheckLoginKey($loginName);
    			if($rs["status"]==1){
    				return WSTReturn("用户名不存在!");
    				exit();
    			}
    			$m = new MUsers();
    			$info = $m->checkAndGetLoginInfo($loginName);
    			if ($info != false) {
    				session('findPass',array('userId'=>$info['userId'],'loginName'=>$loginName,'userPhone'=>$info['userPhone'],'userEmail'=>$info['userEmail'],'loginSecret'=>$info['loginSecret'],'findTime'=>time()));
    				return WSTReturn("操作成功",1);
    			}else return WSTReturn("用户名不存在!");
    			break;
    		case 2:#第二步,验证方式
    			if (session('findPass.loginName') != null ){
    				if(input("post.modes")==1){
    					if ( session('findPass.userPhone') == null) {
    						return WSTReturn('你没有预留手机号码，请通过邮箱方式找回密码！',-1);
    					}
    					$phoneVerify = input("post.Checkcode");
    					if(!$phoneVerify){
    						return WSTReturn('校验码不能为空!',-1);
    					}
    					return $this->checkfindPhone($phoneVerify);
    				}else{
    					if (session('findPass.userEmail')==null) {
    						return WSTReturn('你没有预留邮箱，请通过手机号码找回密码！',-1);
    					}
    					if(!WSTVerifyCheck($code)){
    						return WSTReturn('验证码错误!',-1);
    					}
    					return $this->getfindEmail();
    				}
    			}else $this->error('页面已过期！');
    			break;
    		case 3:#第三步,设置新密码
    			$resetPass = session('REST_success');
    			if($resetPass != 1)$this->error("页面已失效!");
    			$loginPwd = input("post.loginPwd");
    			$repassword = input("post.repassword");
    			if ($loginPwd == $repassword) {
    				$m = new MUsers();
    				$rs = $m->resetPass();
    				if($rs['status']==1){
    					return $rs;
    				}else{
    					return $rs;
    				}
    			}else return WSTReturn('两次密码不同！',-1);
    			break;
    		default:
    			$this->error('页面已过期！');
    			break;
    	}
    }
    /**
     * 手机验证码获取
     */
    public function getfindPhone(){
    	$smsVerfy = input("post.smsVerfy");
    	session('WST_USER',session('findPass.userId'));
    	if(session('findPass.userPhone')==''){
    		return WSTReturn('你没有预留手机号码，请通过邮箱方式找回密码！',-1);
    	}
    	$phoneVerify = rand(100000,999999);
    	$msg = "您正在重置登录密码，验证码为:".$phoneVerify."，请在10分钟内输入。【".WSTConf("mallName")."】";
    	$m = new LogSms();
    	session('WST_USER',null);
    	$rv = $m->sendSMS(0,session('findPass.userPhone'),$msg,'getPhoneVerify',$phoneVerify);
      	if($rv['status']==1){
	    	$USER = '';
	    	$USER['phoneVerify'] = $phoneVerify;
	    	$USER['time'] = time();
	    	session('findPhone',$USER);
	    	return WSTReturn('短信发送成功!',1);
    	}
    	return $rv;
    }
    /**
     * 手机验证码检测
     * -1 错误，1正确
     */
    public function checkfindPhone($phoneVerify){
    	if(!session('findPhone.phoneVerify') || time()>floatval(session('findPhone.time'))+10*60){
    		return WSTReturn("校验码已失效，请重新发送！");
    		exit();
    	}
    	if (session('findPhone.phoneVerify') == $phoneVerify ) {
    		$fuserId = session('findPass.userId');
    		if(!empty($fuserId)){
    			$rs['status'] = 1;
    			$keyFactory = new \org\Base64();
    			$key = $keyFactory->encrypt("0_".session('findPass.userId')."_".time(),(int)session('findPass.loginSecret'),30*60);
    			$rs['url'] = url('Home/Users/forgetPasss',array('key'=>$key),true,true);
    			return $rs;
    		}
    		return WSTReturn('无效用户',-1);
    	}
    	return WSTReturn('校验码错误!',-1);
    }
    /**
     * 发送验证邮件/找回密码
     */
    public function getfindEmail(){
    	$base64 = new \org\Base64();
    	$key = $base64->encrypt("0_".session('findPass.userId')."_".time(),(int)session('findPass.loginSecret'),30*60);
    	$url = url('Home/Users/forgetPasss',array('key'=>$key),true,true);
    	$html="您好，会员 ".session('findPass.loginName')."：<br>
		您在".date('Y-m-d H:i:s')."发出了重置密码的请求,请点击以下链接进行密码重置:<br>
		<a href='".$url."'>".$url."</a><br>
		<br>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中。<br>
		该验证邮件有效期为30分钟，超时请重新发送邮件。<br>
		<br><br>*此邮件为系统自动发出的，请勿直接回复。";
    	$sendRs = WSTSendMail(session('findPass.userEmail'),'密码重置',$html);
    	if($sendRs['status']==1){
    		return WSTReturn("操作成功",1);
    	}else{
    		return WSTReturn($sendRs['msg'],-1);
    	}
    }
    
    /**
     * 加载登录小窗口
     */
    public function toLoginBox(){
    	return $this->fetch('box_login');
    }

    /**
    * 跳去修改支付密码页
    */
    public function editPayPass(){
        $m = new MUsers();
        //获取用户信息
        $userId = (int)session('WST_USER.userId');
        $data = $m->getById($userId);
        $this->assign('data',$data);
        return $this->fetch('users/security/user_pay_pass');
    }
    /**
    * 修改支付密码
    */
    public function payPassEdit(){
        $userId = (int)session('WST_USER.userId');
        $m = new MUsers();
        $rs = $m->editPayPass($userId);
        return $rs;
    }

    /**
     * 获取用户金额
     */
    public function getUserMoney(){
        $m = new MUsers();
        $rs = $m->getFieldsById((int)session('WST_USER.userId'),'userMoney,lockMoney,payPwd');
        $rs['isSetPayPwd'] = ($rs['payPwd']=='')?0:1;
        unset($rs['payPwd']);
        return WSTReturn('',1,$rs);
    }


    /**
     * 充值
     * @author lukui  2017-10-14
     * @return [type] [description]
     */
    public function recharge()
    {
        
        return $this->fetch('users/users/recharge');
    }

    /**
     * 提现
     * @author lukui  2017-10-14
     * @return [type] [description]
     */
    public function cash()
    {
        $mybank = db('cash_configs')->where('targetId',$this->uid)->find();
        
        // if(!$mybank){
        //     $this->error('请先绑定银行卡',url('mybank'));
        // }
        // $this->assign('mybank',$mybank);

        //银行卡
        $banks = db('banks')->where('dataFlag',1)->select();
        $this->assign('banks',$banks);

        return $this->fetch('users/users/cash');
    }

    /**
     * 修改密码
     * @author lukui  2017-10-14
     * @return [type] [description]
     */
    public function respass()
    {
        if(input('post.')){
            $post = input('post.');
            $users = $this->users;
            $data['loginPwd'] = md5($post['password'].$users['loginSecret']);
            $data['userId'] = $users['userId'];
            $ids = db('users')->update($data);
            if($ids){
                return WSTReturn("操作成功",1);
            }else{
                return WSTReturn("操作失败，或未作修改！",-1);
            }
            
            exit;
        }
        return $this->fetch('users/users/respass');
    }

    


    /**
     * 优惠券
     * @author lukui  2017-10-14
     */
    public function Coupon()
    {

        $where = array('cs.userId'=>$this->uid,'isUse'=>0);

        $dsylist = db('couponsend')->alias('cs')->field('cs.*,u.userName,c.cStatic,c.cTime,c.cMoney,cName')
                ->join('__USERS__ u','u.userId=cs.userId')
                ->join('__COUPON__ c','c.cid=cs.cid')
                ->where($where)
                ->order('csid desc')->select();

        $dsycount = count($dsylist);



        $where['isUse'] = 1;

        $ysylist = db('couponsend')->alias('cs')->field('cs.*,u.userName,c.cStatic,c.cTime,c.cMoney,cName')
                ->join('__USERS__ u','u.userId=cs.userId')
                ->join('__COUPON__ c','c.cid=cs.cid')
                ->where($where)
                ->order('csid desc')->select();

        $ysycount = count($ysylist);

        $this->assign('dsylist',$dsylist);
        $this->assign('dsycount',$dsycount);
        $this->assign('ysylist',$ysylist);
        $this->assign('ysycount',$ysycount);

        return $this->fetch('users/users/Coupon');
    }

    

    //我的银行卡
    public function mybank()
    {
        $mybank = db('cash_configs')->where('targetId',$this->uid)->find();
        $this->assign('mybank',$mybank);

        //银行卡
        $banks = db('banks')->where('dataFlag',1)->select();
        $this->assign('banks',$banks);

        //地区
        $province = db('areas')->where(array('pid'=>0))->select();

        
        
        $this->assign('province',$province);
        return $this->fetch('users/users/mybank');
    }

    /**
     * 获取城市
     * @return [type] [description]
     */
    public function getarea()
    {

        $id = input('id');
        if(!$id){
            return false;
        }

        $list = db('areas')->where('pid',$id)->select();
        $data = '<option value="">请选择</option>';
        foreach ($list as $k => $v) {
            $data .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
        }
        echo $data;

    }

    /**
     * 添加、修改银行卡
     * @author lukui  2017-10-15
     * @return [type] [description]
     */
    public function dobanks()
    {
        
        $post = input('post.');
        foreach ($post as $k => $v) {
            if(!$v){
                $this->error('请完善信息！');
            }
        }
        $post['targetType'] = 0;
        $post['targetId'] = $this->uid;
        $post['accType'] = 3;

        if(isset($post['id'])){
            $ids = db('cash_configs')->update($post);
        }else{
            $ids = db('cash_configs')->insert($post);
        }
        if($ids){
            $this->success('操作成功');
        }else{
            $this->error('操作失败，或未作修改！');
        }

        
    }

    /*
    public function duihuan()
    {
        
        $map['isPoint'] = 1;
        $list = db('goods')->where($map)->select();
        $this->assign('list',$list);
        return $this->fetch('users/users/duihuan');
    }
    */


    //我的历史升级记录
    public function jsoulist()
    {
        $map['playtype'] = 1;
        $map['is_over'] = array('neq',0);
        $list = db('orders')->alias('o')->join('__SHOPS__ s','o.shopId=s.shopId','left')
                     ->join('__GOODS__ gs','gs.goodsId=o.goodsId','left')
                     ->join('__PLAY_JIOU_ORDER__ pjo','pjo.id=o.playid','left')
                     ->where($map)
                     ->field('o.*,gs.goodsImg,gs.shopPrice,gs.goodsName,gs.sjgoodsImg,gs.sjshopPrice,gs.sjgoodsName,pjo.issue,pjo.otype')
                     ->order('o.createTime', 'desc')
                     ->paginate(input('pagesize/d'))->toArray();
        //dump($list);exit;
        $this->assign('list',$list["Rows"]);

        return $this->fetch('users/users/jsoulist');
    }

    //我的历史红包记录
    public function hongbaolist()
    {
        
        $map['playtype'] = 2;
        $map['is_over'] = array('neq',0);
        $map['o.userId'] = $this->uid;
        $list = db('orders')->alias('o')->join('__SHOPS__ s','o.shopId=s.shopId','left')
                     ->join('__GOODS__ gs','gs.goodsId=o.goodsId','left')
                     ->where($map)
                     ->field('o.*,gs.goodsImg,gs.shopPrice,gs.goodsName,gs.sjgoodsImg,gs.sjshopPrice,gs.sjgoodsName')
                     ->order('o.createTime', 'desc')
                     ->paginate(input('pagesize/d'))->toArray();
        //dump($list);exit;
        $this->assign('list',$list["Rows"]);

        return $this->fetch('users/users/hongbaolist');
    }

    //我的合并订单
    public function hebinglist()
    {
        $list = db('order_hebing')->where('uid',$this->uid)->order('hbid desc')->select();
        $db_orders = db('orders');
        foreach ($list as $k => $v) {
            $orderarr = json_decode($v['orders']);
            if(!is_array($orderarr)) {
                $_oid = $orderarr;
                $orderarr = array();
                $orderarr[0] = $_oid;
            }
            $orderlist = array();
            foreach ($orderarr as $key => $value) {
                $orderlist[$key] = $db_orders->alias('o')->field('o.orderNum,g.goodsName,g.goodsImg,shopPrice')
                            ->join('__GOODS__ g','o.goodsId=g.goodsId')
                            ->where('orderId',$value)->find();
            }
            $list[$k]['orderlist'] = $orderlist;
            $list[$k]['ordernum'] = count($orderarr);
        }

        
        $this->assign('list',$list);
        return $this->fetch('users/users/hebinglist');
    }

    /**
     * 确认收货
     * @author lukui  2017-11-05
     * @return [type] [description]
     */
    public function queren()
    {
        
        $post = input('post.');
        $static = 3;
        if(!$post) return  WSTReturn("无效的订单信息");

        //处理订单
        $db_orders = db('orders');
        $hborder = db('order_hebing')->where('hbid',$post['hbid'])->find();
        $arrorder = json_decode($hborder['orders'],1);
        $_time = date('Y-m-d H:i:s',time());
        if(!is_array($arrorder)) {
            $_oid = $arrorder;
            $arrorder = array();
            $arrorder[0] = $_oid;
        }
        foreach ($arrorder as $k => $v) {
            $_data['orderId'] = $v;
            $_data['hbstatic'] = $static;
            $db_orders->update($_data);
        }
        

        $post['static'] = $static;
        $ids = db('order_hebing')->update($post);

        if ($ids) {
            return  WSTReturn("处理成功",1);
        }else{
            return  WSTReturn("处理失败");
        }
    }


    /**
     * 忘记密码
     * @author lukui  2017-11-12
     * @return [type] [description]
     */
    public function findpassword()
    {
        $post = input('post.');
        if($post){
            
            $mobileCode = input("post.mobileCode");
            $nameType = (int)input("post.nameType");

            if($nameType==3){//手机号码
                
                $verify = session('VerifyCode_userPhone');
                $startTime = (int)session('VerifyCode_userPhone_Time');
            if((time()-$startTime)>120){
    			return WSTReturn("验证码已超过有效期!");
    		}
                if($mobileCode=="" || $verify != $mobileCode){
                    return WSTReturn("验证码错误!");
                }
                
            }else{
                WSTReturn("非法操作");
            }


            $users = db('users')->where('userPhone',$post['loginName'])->find();
            if(!$users) WSTReturn("手机号不存在");

            $data['loginPwd'] = md5($post['loginPwd'].$users['loginSecret']);
            $data['userId'] = $users['userId'];
            $ids = db('users')->update($data);
            if($ids){
                return WSTReturn("操作成功",1);
            }else{
                return WSTReturn("操作失败，或未作修改！",-1);
            }
            


            exit;

        }
        
        return $this->fetch('findpassword');
    }










    /**
    充值
    **/
    public function drrecharge()
    {
        //充值建议
        $rech_jianyi =  WSTConf('CONF.rech_jianyi');
        $rech_jianyi = explode('-', $rech_jianyi);
        

        //充值配置
        $map['enabled'] = 1;

        $payment = db('payments')->where($map)->order('payOrder')->select();

        foreach ($payment as $k => $v) {
            $payment[$k]['Configs'] = json_decode($v['payConfig'],1);
        }
        
        

        $this->assign('payment',$payment);
        $this->assign('rech_jianyi',$rech_jianyi);
        return $this->fetch('users/drrecharge');
    }


    //订单
    public function dingdan($type=1,$uid=0)
    {
        if(!$uid) $uid = $this->uid;
        $this->assign('uid',$uid);
        $this->assign('type',$type);
        return $this->fetch('users/dingdan'); 
        
    }


    public function ajaxdingdan($page = 1,$uid=0,$type=1)
    {
        $where['o.userId'] = $uid;
        $tody = date('Y-m-d');
        $where['o.createTime'] = array('>=',$tody);
        if($type == 2){
            $where['o.iswin'] = 1;
        }elseif ($type == 3) {
            $where['o.iswin'] = 2;
        }elseif($type == 4 && $uid == $this->uid){
            $where['o.isres'] = 1;
        }elseif($type == 5 && $uid == $this->uid){
            $where['o.iswin'] = 1;
            $where['o.isres'] = 0;
            unset($where['o.createTime']);
        }
        
        $list = db('drorder')->alias('o')->field('o.*,u.userName,g.goodsName,g.goodsImg')
                ->join('__USERS__ u','u.userId=o.userId')
                ->join('__GOODS__ g','g.goodsId=o.goodsId')
                ->where($where)->order('drid desc')->limit(($page-1)*5,$page*5)->select();
        
        if(!$list){
            die(0);
        }

        $html = '';
        $order_type = config('order_type');
        foreach ($list as $k => $v) {

            if($v['iswin'] == 1 || $v['iswin'] == 2){
                $haoma = db('play_ssc_data')->where(array('issue'=>$v['sscqishu']))->value('balls');
            }

            //玩法.
            if($v['drtype'] != 10){
                $dd_type = $order_type[$v['sectionno']];
            }else{
                $dd_type = $v['sectionno'];
            }
            $wanfa = '【尾数:'.$dd_type.'】';
           
            $html .= '<li>
                    <p class="jname">
                        <span class="fl">订单编号：'.$v['orderNo'].'</span>
                        <span class="fr">'.$v['createTime'].'</span>
                    </p>
                    <dl class="kjname">
                        <dt><img src="/'.$v['goodsImg'].'"></dt>
                        <dd>
                            <h1>'.$v['goodsName'].'</h1>
                            <h2>参与玩法：<span class="c1">'.$wanfa.'× '.$v['orderNum'].'</span></h2>
                            <h2>购买金额：<span class="c1"> ￥'.$v['orderMoney'].'</span></h2>
                            <h2>开奖期号：<span class="c1"> 20'.$v['sscqishu'].'</span></h2>';

            if($v['iswin'] == 1 ){

                $isduihuan = '';
                if($v['isres']  == 0 && $this->uid == $v['userId']){
                    $isduihuan = '<span class="fr duihuans"><a href="javascript:;" onclick="duihuan('.$v['drid'].')">兑换</a></span>';
                }elseif($v['isres']  == 1 && $this->uid == $v['userId']){
                    $isduihuan = '<span class="fr"><a href="javascript:;" onclick="duihuan('.$v['drid'].')">已兑换</a></span>';
                }

                $html .= '<h2>开奖号码：<span class="c1"> '.$haoma.'</span></h2>
                        </dd>
                    </dl>
                    <p class="ok">
                        <span class="fl">恭喜胜利</span>
                        '.$isduihuan.'
                        <span class="fr"><a href="'.url('goods/detail',array('id'=>$v['goodsId'])).'">再次购买</a></span>
                        <span class="fr"><a href="'.url('pkxiangqing',array('id'=>$v['drid'])).'">PK详情</a></span>
                    </p>
                </li>';
            }elseif($v['iswin'] == 2){
                $html .= '<h2>开奖号码：<span class="c1"> '.$haoma.'</span></h2>
                        </dd>
                    </dl>
                    <p class="ok">
                        <span class="fl nook">再接再厉</span>
                        <span class="fr"><a href="'.url('goods/detail',array('id'=>$v['goodsId'])).'">再次购买</a></span>
                        <span class="fr"><a href="'.url('pkxiangqing',array('id'=>$v['drid'])).'">PK详情</a></span>
                    </p>
                </li>';
            }else{
                /*$_time = strtotime($v['createTime']);
                $h = date('H',$_time);
                if($h >= 22 || $h < 2){

                    $_i = ((5-(date('i',$_time)%5))-1)*60;
                    if($_i<0) $_i = 0;
                    $_s = 60 - date('i',$_time);
                    $_alls = $_s + $_i;
                    $_time = $_time + $_alls;
                    $djs = date('Y-m-d H:i:s',$_time);

                }elseif($h >= 10 || $h < 22){
                    
                    $_i = ((10-(date('i',$_time)%10))-1)*60;
                    if($_i<0) $_i = 0;
                    $_s = 60 - date('i',$_time);
                    $_alls = $_s + $_i;
                    $_time = $_time + $_alls;
                    $djs = date('Y-m-d H:i:s',$_time);
                }else{
                    $djs = date('Y-m-d').' 10:00:00';
                }*/
				$_time = strtotime($v['createTime']);
                $h = date('H',$_time);
                $i = date('i',$_time);
                if($h >= 7 && $h < 23 || $h == 23 && $i < 55){

                    $_i = ((5-(date('i',$_time)%5))-1)*60;
                    if($_i<0) $_i = 0;
                    $_s = 60 - date('i',$_time);
                    $_alls = $_s + $_i;
                    $_time = $_time + $_alls;
                    $djs = date('Y-m-d H:i:s',$_time);

                }else{
                    $djs = date('Y-m-d').' 7:00:00';
                }
                $html .= '<h2>开奖号码：<span class="c1">  待揭晓...</span></h2>
                        </dd>
                    </dl>
                    <p class="ok">
                        <span class="fl waiting fnTimeCountDown"><span class="hour">00</span><i>:</i>
                                            <span class="mini">00</span><i>:</i>
                                            <span class="sec">00</span><i>:</i>
                                            <span class="hm">00</span>
                                            </span><script>var daojishi = "'.$djs.'";daojishi_start();</script>
                        <span class="fr"><a href="'.url('goods/detail',array('id'=>$v['goodsId'])).'">再次购买</a></span>
                    </p>
                </li>';
            }
            
        }

        die($html);
        
    }

    /**
     * 赢利后自动一键兑换
     * @author lukui  2017-12-02
     * @return [type] [description]
     */
    public function yj_duihuans()
    {
        
        $map['userId'] = $this->uid;
        $map['iswin'] = 1;
        $map['isover'] = 1;
        $map['isres'] = 0;
        $list = db('drorder')->where($map)->select();
        if(!$list) return WSTReturn('暂无可兑换订单');

        foreach ($list as $key => $value) {
            $res = $this->dr_duihuans($value['drid']);
            if($res['status'] == -1){
                return $res;
            }
        }
        return WSTReturn('兑换成功！',1);
            


    }

    /**
     * 赢利后手动兑换
     * @author lukui  2017-12-02
     * @return [type] [description]
     */
    public function dr_duihuans($drid=0)
    {
        

        if(!$drid) $drid = input('post.drid');
        
        if(!$drid) return WSTReturn('参数错误');

        $drorder = db('drorder');
        $dingdan = $drorder->where('drid',$drid)->find();
        if(!$dingdan) return WSTReturn('订单不存在');

        if($dingdan['iswin'] != 1 || $dingdan['isover'] != 1) return WSTReturn('此订单不可兑换');

        if($dingdan['isres'] != 0) return WSTReturn('此订单已兑换');

        if($dingdan['userId'] != $this->uid) return WSTReturn('非法操作！');
        
        //兑换----------------------------------
        $dh_fee = WSTConf('CONF.dh_fee');
        if(!$dh_fee) $dh_fee = 0;
        
        //总价
        $allWin = (float)($dingdan['orderMoney'] + $dingdan['winmoney']);
        //到账
        $daozhang = round($allWin*(100-$dh_fee)/100,2);
        //手续费
        $shouxu = $allWin - $daozhang;

        //改订单状态
        $_dingdan['drid'] = $dingdan['drid'];
        $_dingdan['isres'] = 1;
        $ids = $drorder->update($_dingdan);
        if(!$ids) return WSTReturn('系统错误:001');

        //给客户加钱
        db('users')->where('userId',$dingdan['userId'])->setInc('userMoney',$daozhang);
        //资金日志
        $lm = [];
        $lm['targetType'] = 7;
        $lm['targetId'] = $dingdan['userId'];
        $lm['dataId'] = $dingdan['drid'];
        $lm['dataSrc'] = getsrc();
        $lm['remark'] = 'PK获胜兑换';
        $lm['moneyType'] = 2;
        $lm['money'] = $allWin;
        $lm['payType'] = 0;
        $lm['createTime'] = date('Y-m-d H:i:s',time());
        db('log_moneys')->insert($lm);

        //赢利后手续费拼接日志数组
        $lm['targetType'] = 8;
        $lm['moneyType'] = 1;
        $lm['remark'] = 'PK获胜兑换手续费';
        $lm['money'] = $shouxu*(-1);
        db('log_moneys')->insert($lm);


        return WSTReturn('兑换成功！',1);

        
           
    }

    /**pk详情**/
    public function pkxiangqing($id)
    {
        $order_type = config('order_type');
        
        //订单
        $dingdan = db('drorder')->alias('o')->field('o.*,u.userName')
                ->join('__USERS__ u' ,'u.userId=o.userId')
                ->where('drid',$id)->find();
        if(!$dingdan) exit;
        
        if($dingdan['drtype'] != 10){
            $dd_type = $order_type[$dingdan['sectionno']];
        }else{
            $dd_type = $dingdan['sectionno'];
        }
        
        //对手
        $map['orderNo'] = $dingdan['orderNo'];
        $map['drid'] = array('neq',$id);
        $duishou = db('drorder')->alias('o')->field('o.*,u.userName')
                ->join('__USERS__ u' ,'u.userId=o.userId')
                ->where($map)->find();
        if(!$duishou) exit;
        if($duishou['drtype'] != 10){
            $ds_type = $order_type[$duishou['sectionno']];
        }else{
            $ds_type = $duishou['sectionno'];
        }

        //时时彩
        $ssc = db('play_ssc_data')->where('issue',$dingdan['sscqishu'])->find();
        if(!$ssc) exit;

        
        $ssc = get_ssc_info($ssc);

        $this->assign('ssc',$ssc);
        $this->assign('dingdan',$dingdan);
        $this->assign('duishou',$duishou);
        $this->assign('dd_type',$dd_type);
        $this->assign('ds_type',$ds_type);

        return $this->fetch('users/pkxiangqing');
    }

    /**
     * 兑换记录
     * @author lukui  2017-12-02
     * @return [type] [description]
     */
    public function duihuan()
    {
        
        
    }

    /**客服**/
    public function kefu()
    {
        return $this->fetch('users/kefu');
    }
    /**APP下载**/
    public function app()
    {
        return $this->fetch('users/app');
    }

	/**支付**/
    public function pay()
    {
        $post = input('get.');
        if(!$post){
            $this->error('参数错误！');
        }

        if(!$post['total_fee']){
            return WSTReturn('参数错误！',-1);
        }
        $uid = $this->uid;
        $user = $this->users;
     
        $version = '2.0';
        $customerid = '10961';//用户编号
        $sdorderno = time()+mt_rand(1000,9999);//商户订单号 默认时间戳【可以任意输入】
        $dingdan = $uid.'_'.date('YmdHis');//平台订单号  108这个是玩家账号ID 请进行修改  禁止使用玩家账号
        $shuzi=rand(10,99); //金额随机小数点
        $total_fee = $_GET['total_fee'].'.'.$shuzi;//订单金额 <!--禁止自己输入带小数点 比如 100.00 /0.1-->
        $notifyurl = 'http://'.$_SERVER['HTTP_HOST'].'/home/payments/notify';//服务器异步通知页面路径【一定注意 https http 】--可以这里写死
        $returnurl = 'http://'.$_SERVER['HTTP_HOST'].'/home/users/index';//页面跳转同步通知页面路径【一定注意 https http 】--可以这里写死
        $userkey='a31b25fd047a484a4cacd76142a325adf1f77059';//在后台 接入信息 里面拿接入密钥
        $sign=md5('version='.$version.'&customerid='.$customerid.'&total_fee='.$total_fee.'&sdorderno='.$sdorderno.'&notifyurl='.$notifyurl.'&returnurl='.$returnurl.'&'.$userkey);//MD5密钥

        
        // echo $uid."<br>";
        // echo $user['userMoney']."<br>";
        // exit;

        //充值类型
        $nowtime = date('Y-m-d H:i:s');
        //插入充值数据
        $data['bptype'] = 3;   //正在充值
        $data['createTime'] = $nowtime;
        $data['bpprice'] = $total_fee;
        $data['remarks'] = '会员充值';
        $data['uid'] = $uid;
        $data['isverified'] = 0;
        $data['btime'] = $nowtime;
        $data['reg_par'] = round(0.01*$data['bpprice'],2); //手续费
        $data['balance_sn'] =$dingdan;  //订单编号
        // $data['pay_type'] = $post['paytype'];
        $data['bpbalance'] = $user['userMoney'];
        $ids = db('recharge')->insertGetId($data);
        if(!$ids){
            return WSTReturn('网络异常！',-1);
        }

        $this->assign('version',$version);
        $this->assign('customerid',$customerid);
        $this->assign('sdorderno',$sdorderno);
        $this->assign('dingdan',$dingdan);
        $this->assign('total_fee',$total_fee);
        $this->assign('notifyurl',$notifyurl);
        $this->assign('returnurl',$returnurl);
        $this->assign('sign',$sign);
        return $this->fetch('users/pay');

    }
	
	
	
    /**
     * 钱包
     * @author lukui  2017-12-02
     * @return [type] [description]
     */
    public function qianbao()
    {
        
        return $this->fetch('users/qianbao');
    }

    /**
     * 资金明细
     * @author lukui  2017-10-14
     * @return [type] [description]
     */
    public function getUserFlowing()
    {
        $list = db('log_moneys')->where('targetId',$this->uid)->order('id desc')->limit(100)->select();
        $this->assign('list',$list);
        return $this->fetch('users/getUserFlowing');
    }

    /**
     * 提现
     * @author lukui  2017-12-02
     * @return [type] [description]
     */
    public function drcash()
    {
        //支付宝账号
        $user_alipay = db('cash_configs')->where(array('targetId'=>$this->uid,'targetType'=>0))->find();

        //银行卡账号
        $user_bank = db('cash_configs')->where(array('targetId'=>$this->uid,'targetType'=>1))->find();

        $this->assign('user_alipay',$user_alipay);
        $this->assign('user_bank',$user_bank);

        $mincash = WSTConf('CONF.mincash');
        $this->assign('mincash',$mincash);

        $tx_fee = WSTConf('CONF.tx_fee');
        $this->assign('tx_fee',$tx_fee);

        return $this->fetch('users/drcash');
    }

    /**
     * 添加支付宝
     * @author lukui  2017-12-02
     * @return [type] [description]
     */
    public function alipay_add()
    {
        if(input('post.')){
            $post = input('post.');
            
            return $this->docashconf($post);
            exit;
            
        }
        $user_alipay = db('cash_configs')->where(array('targetId'=>$this->uid,'targetType'=>0))->find();
        $this->assign($user_alipay);
        return $this->fetch('users/alipay_add');
    }

    /**
     * 添加银行卡账户
     * @author lukui  2017-12-02
     * @return [type] [description]
     */
    public function bank_add()
    {
        if(input('post.')){
            $post = input('post.');
            return $this->docashconf($post);
            exit;
           
            
        }
        $banks = db('banks')->where('dataFlag',1)->select();
        $this->assign('banks',$banks);
        $user_bank = db('cash_configs')->where(array('targetId'=>$this->uid,'targetType'=>1))->find();
        $this->assign($user_bank);
        return $this->fetch('users/bank_add');
    }

    public function docashconf($post)
    {
        $post['createTime'] = date('Y-m-d H:i:s');
        if(isset($post['id']) && $post['id'] > 0){
            
            $ids = db('cash_configs')->where('id',$post['id'])->update($post);
        }else{
            $post['targetId'] = $this->uid;
            $ids = db('cash_configs')->insert($post);
        }
        
        if($ids){
            return WSTReturn('操作成功',1);
        }else{
            return WSTReturn('操作失败，请重试');
        }
    }


    /**
     * 分享
     * @author lukui  2017-10-15
     * @return [type] [description]
     */
    public function share()
    {
        
        $uid = $this->uid;
        if(!isset($uid) || $uid <= 0 ){
            $this->redirect('index/index');
        }
        

        

        
        if($this->users['uq'] == 104){
            $par103 = $this->users['par103'];
			$par102 = $this->users['par102'];
			$par101 = $this->users['par101'];
			if($par103){
				$oid = $par103;
			}elseif($par102){
				$oid = $par102;
			}elseif($par101){
				$oid = $par101;
			}else{
				$oid = $this->uid;
			}
            $useryqm = db('users')->where('userId',$oid)->value('usercode');
        }else{
            $oid = $uid;
            $useryqm = $this->users['usercode'];
        }

        
        //$code_domain = getconf('code_domain');
        $mycode = url('home/index/index','',true,true).'?fid='.$oid;
        

        //邀请二维码
        //$code = 'http://pan.baidu.com/share/qrcode?w=500&h=560&url='.$mycode;
		$code = 'http://qr.topscan.com/api.php?&w=450&text='.$mycode;
        $imgdir = 'usercode/'.$uid.'_code.png';
        $img = file_get_contents($code); 
        file_put_contents($imgdir,$img); 
        
        
       
        $dir = $_SERVER['DOCUMENT_ROOT'].'/'.GetTableValue('ads',76,'adFile','adId');
        $img = $_SERVER['DOCUMENT_ROOT'].'/'.$imgdir;
        
        $savename = 'usercode/'.$uid.'.jpeg';
        
        $postion = array(320,930);
        waterpic($dir,$img,$savename,$postion,100);
        unlink($img);
        $path = "/usercode/".$uid.'.jpeg';

        $this->assign('path',$path);
        $this->assign('useryqm',$useryqm);
        
        return $this->fetch('users/share');
    }

    /**
     * 我的团队
     * @author lukui  2017-12-04
     * @param  integer $type 1我的客户2我的代理商
     * @return [type]        [description]
     */
    public function myteam($type=1)
    {
        
        if(!$type) $type = 1;

        $map['oid'] = $this->uid;
        if($type == 1){
            $map['uq'] = 104;
        }else{
            $map['uq'] = 103;
        }
        $list = db('users')->where($map)->order('userId desc')->select();

        $db_drorder = db('drorder');
        foreach ($list as $k => $v) {
            //今日流水
            $list[$k]['todyls'] = $db_drorder->where('userId',$v['userId'])->wheretime('createTime','d')->sum('orderMoney');
            //历史流水
            $list[$k]['allls'] = $db_drorder->where('userId',$v['userId'])->sum('orderMoney');
        }

        $this->assign('list',$list);
        $this->assign('type',$type);
        return $this->fetch('users/myteam');
    }
   /**
     * 关注我
     * gzh
     */
    public function gzh(){

        return $this->fetch('users/gzh');
    }
    /**
     * 升级会员为代理商
     * @author lukui  2017-12-04
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public function upuser($uid=0)
    {
        if (!$uid) {
            exit;
        }

        if(input('post.')){
            $post = input('post.');

            //user
            $user = db('users')->where('userId',$post['userId'])->find();
            if(!$user) return WSTReturn('用户不存在');

            if($user['uq'] != 104) return WSTReturn('不可操作此用户');

            if($post['percent'] <= 0) $post['percent'] = 0;

            if($post['percent'] > $this->users['percent'])  return WSTReturn('最大比例'.$this->users['percent']);

            $post['uq'] = 103;

            $ids = db('users')->update($post);
            if ($ids) {
                return WSTReturn('操作成功',1);
            }else{
                return WSTReturn('操作失败，请重试');
            }
            
            exit;
        }




        $this->assign('uid',$uid);
        return $this->fetch('users/upuser');
    }


    /**
    佣金明细
    */
    public function yongjin()
    {
        $map['targetId'] = $this->uid;
        $map['targetType'] = 10;
        $list = db('log_moneys')->where($map)->order('id desc')->limit(100)->select();
        $this->assign('list',$list);
        return $this->fetch('users/yongjin');
    }



	 /**
    充值添加到数据库bdyf
    **/
    public function addpaybdyf()
    {
         
        $post = input('get.');
        if(!$post){
            $this->error('参数错误！');
        }

        if(!$post['paytype'] || !$post['bpprice']){
            return WSTReturn('参数错误！',-1);
        }

        
        $uid = $this->uid;
        $user = $this->users;
        $nowtime = date('Y-m-d H:i:s');
        //充值类型
        $paybanlance_no = $uid.time().rand(111111,999999);
        
		 
        //插入充值数据
        $data['bptype'] = 3;
        $data['createTime'] = $nowtime;
        $data['bpprice'] = $post['bpprice'];
        $data['remarks'] = '会员充值';
        $data['uid'] = $uid;
        $data['isverified'] = 0;
        $data['btime'] = $nowtime;
        $data['reg_par'] = round(0.01*$post['bpprice'],2);
        $data['balance_sn'] =$paybanlance_no;
        $data['pay_type'] = $post['paytype'];
        $data['bpbalance'] = $user['userMoney'];
        $ids = db('recharge')->insertGetId($data);
        if(!$ids){
            return WSTReturn('网络异常！',-1);
        }
        $data['bpid'] = $ids;
		$paytype = 'A23';
		$tradetype = 'sm';
		if($post['paytype'] == 'mcb_alipay'){
			$paytype = 'A23';
			$tradetype = 'sm';
		}
		if($post['paytype'] == 'mcb_wxpay'){
			$paytype = 'Z23';
			$tradetype = 'sm';
		}
	 	$param = array(
			'amount'=> $post['bpprice']*100,	   //金额分为单位,这个表示30元
			'mch_id'=> '20001',                    //商户号 换成我司分配的商户号
			'notify_url'=> 'http://www.intface.cn/home/payments/bdyf_back', //填回调异步通知地址
			'out_trade_no'=> $paybanlance_no,		   //订单号必须唯一
			'mch_create_ip'=>$_SERVER["REMOTE_ADDR"],//IP地址
			'time_start'=>date("YmdHms"),    	   //IP日期
			'body'=>'00',                     	   //默认 
			'attach'=>'00',                        //默认00
			'nonce_str'=>'123456',                 //默认
			'trade_type'=>$paytype,                //目前开通 
			'paytype'=>$tradetype,                 //快捷传kj,支付宝wap传wap,微信H5传wap 支付宝扫码传sm 微信扫码传sm
			'back_url'=>'http://www.baidu.com',    //默认
		);
		$param['sign'] = $this->makeSignature($param, '20001abc');//10001abc 这个是密钥 需要替换我司分配的对应的密钥
		$url_param = $this->arrayToKeyValueString($param);
        $respdata = file_get_contents('http://www.yazang.top/api/quickkj/pay?'.$url_param);
		file_put_contents("C:/data.txt",'http://www.yazang.top/api/quickkj/pay?'.$url_param); 
		echo $respdata;
		//echo $respdata;
    }
	
	/*
     * 生成签名，$args为请求参数，$key为私钥
     */
	public function makeSignature($args, $key){
		if(isset($args['sign'])) {
			$oldSign = $args['sign'];
			unset($args['sign']);
		} else {
			$oldSign = '';
		}
        ksort($args);
        $requestString = '';
        foreach($args as $k => $v) {
            $requestString .= $k . '='.($v);
            $requestString .= '&';
        }
        $requestString = substr($requestString,0,strlen($requestString)-1);
        $newSign = md5( $requestString."&key=".$key);
        return $newSign;
    }
	
	/*
     * 签名转换
     */
	public function arrayToKeyValueString($param){
		$str = '';
		foreach($param as $key => $value) {
			$str = $str . $key .'=' . $value . '&';
		}
		return $str;
	}
	
    /**
    充值添加到数据库
    **/
    public function addpay()
    {

		
        $post = input('post.');
        if(!$post){
            $this->error('参数错误！');
        }

        if(!$post['paytype'] || !$post['bpprice']){
            return WSTReturn('参数错误！',-1);
        }

        
        $uid = $this->uid;
        $user = $this->users;
        $nowtime = date('Y-m-d H:i:s');


        //充值类型
        $typearr = explode('_', $post['paytype']);
        $str = substr($post['paytype'],0, strlen($typearr[0]));
        $map['payCode'] =  $str;
        $map['enabled'] = 1;
        
        $payment = db('payments')->where($map)->find();

        //手续费
        $payConfig = json_decode($payment['payConfig'],1);
        if(isset($payConfig[$typearr[0].'_sxf'])){
            $_sxf = $payConfig[$typearr[0].'_sxf'];
        }else{
            $_sxf = 0;
        }


        //插入充值数据
        $data['bptype'] = 3;
        $data['createTime'] = $nowtime;
        $data['bpprice'] = $post['bpprice'];
        $data['remarks'] = '会员充值';
        $data['uid'] = $uid;
        $data['isverified'] = 0;
        $data['btime'] = $nowtime;
        $data['reg_par'] = round(($_sxf/100)*$post['bpprice'],2);
        $data['balance_sn'] = $uid.time().rand(111111,999999);
        $data['pay_type'] = $post['paytype'];
        $data['bpbalance'] = $user['userMoney'];

        $ids = db('recharge')->insertGetId($data);
        if(!$ids){
            return WSTReturn('网络异常！',-1);
        }
        $data['bpid'] = $ids;
        
        
        if(!$payment){
            return WSTReturn('支付渠道不存在',-1);
        }
        
        

        

        $Pay = controller('Payments');
        switch ($str) {
            case 'mcb':
                return $Pay->mcb_pay($data,$payment,$post['paytype']);
                break;
            
            default:
                return WSTReturn('支付渠道方法不存在',-1);
                break;
        }
        

    }



    /**
    * 跳去修改密码页
    */
    public function editPass(){

        $userId = (int)session('WST_USER.userId');
        $data = array();
        if($userId){
            $m = new MUsers();
            //获取用户信息
            $data = $m->getById($userId);
        }
        $this->assign('data',$data);
        return $this->fetch('user_pass');
    }
    /**
    * 修改密码
    */
    public function passedit(){
        //$userId = (int)session('WST_USER.userId');
        $m = new MUsers();
        $rs = $m->editPass();
        return $rs;
    }
    //  2018-09-20 增加    
    /**
	 * 用户中心
	 */
	public function center(){
		session('WST_MENID0',0);
		session('WST_MENUID30',0);
        //佣金
        $map['targetType'] = 1;
        $map['targetId'] = $this->uid;
        $yongjin = db('log_moneys')->where($map)->sum('money');
        if(!$yongjin) $yongjin = 0;

        //今日数据
        $db_drorder = db('drorder');
        $jr_map['userId'] = $this->uid;
        $jinri['canyu'] = $db_drorder->where($jr_map)->wheretime('createTime','d')->count();
        
        $jr_map['iswin'] = 1;
        $jinri['win'] = $db_drorder->where($jr_map)->wheretime('createTime','d')->count();

        $jr_map['iswin'] = 2;
        $jinri['loss'] = $db_drorder->where($jr_map)->wheretime('createTime','d')->count();

        $this->assign('jinri',$jinri);
        $this->assign('yongjin',$yongjin);
		return $this->fetch('users/center');
	}


}

