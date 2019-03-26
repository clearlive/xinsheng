<?php
namespace application\home\controller;
/**
 
  
 
 

 

 
 * 基础控制器
 */
use think\Controller;
class Base extends Controller {

	public function __construct(){


		

		parent::__construct();
	
		$USER = session('WST_USER');
		// 这里有时花4秒
		$webisopen = WSTConf('CONF.webisopen');
		

		if(!$webisopen){
			$this->redirect("/error.html");
		}
		
		
		//如果已经登录了则直接跳去用户中心
		if(empty($USER) || $USER['userId']==''){
			if(input('fid')){
				session('fid',input('fid'));
				//dump(session('fid'));exit;
				if(iswechat() && WSTConf('CONF.iswxlogin') == 1){
					$this->redirect("users/login");
				}else{
					$this->redirect("users/regist");
				}
				
				exit;
			}else{
				$this->redirect("users/login");
				exit;
			}
			
		}
		//
	
	// die;
		$users = db('users')->where('userId',$USER['userId'])->find();
	
		if(!$users){
			session('WST_USER',null);
			setcookie("loginPwd", null);
			$this->redirect("users/login");
			exit;
		}
		if(!$users['userPhone']){
			#$this->redirect('users/addpwd');
		}
		
		$this->assign('users',$users);
		$this->uid = $USER['userId'];
		$this->users = $users;
		
		$this->assign("v",time());

		$request = request();
		$controller = $request->controller();
		$action = $request->action();
		$this->assign('controller',$controller);
		$this->assign('action',$action);

		//时时彩倒计时
		$ssc_time = get_ssr_time(1);
	
		$this->assign('ssc_time',$ssc_time);
		
		//是否开盘
		$isopen = isopen();
		$this->assign('isopen',$isopen);
		
	}

	protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
    	$style = WSTConf('CONF.wstPCStyle')?WSTConf('CONF.wsthomeStyle'):WSTConf('CONF.homePath');
        $replace['__STYLE__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/application/home/view/'.WSTConf('CONF.homePathStyle');
        return $this->view->fetch($style."/".$template, $vars, $replace, $config);
    }

	/**
	 * 上传图片
	 */
	public function uploadPic(){
		return WSTUploadPic(0);
	}
	/**
    * 编辑器上传文件
    */
    public function editorUpload(){
           return WSTEditUpload(0);
    }
	
	/**
	 * 获取验证码
	 */
	public function getVerify(){
		WSTVerify();
	}

}