<?php
namespace application\admin\controller;
/**
 
  
 
 

 

 
 * 基础控制器
 */
use think\Controller;
class Base extends Controller {
	public function __construct(){
		parent::__construct();
		$this->assign("v",time());

		$this->session = session("WST_STAFF");
		
		$this->uids = array();
		if($this->session['uq']) $this->uids = myuids($this->session['userId'],$this->session['uq']);
		if(!isset($this->session['userId'])){
			$this->session['userId'] = 0;
		}
		$this->assign('userinfos',$this->session);

		//dump(session("WST_STAFF"));exit;
	}
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
    	$replace['__ADMIN__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/application/admin/view';
        return $this->view->fetch($template, $vars, $replace, $config);
    }

	public function getVerify(){
		WSTVerify();
	}
	
	public function uploadPic(){
		return WSTUploadPic(1);
	}

	/**
    * 编辑器上传文件
    */
    public function editorUpload(){
        return WSTEditUpload(1);
    }
}