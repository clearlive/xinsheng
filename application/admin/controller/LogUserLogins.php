<?php
namespace application\admin\controller;
use application\admin\model\LogUserLogins as M;
/**
 
  
 
 

 

 
 * 登录日志控制器
 */
class LogUserLogins extends Base{
	
    public function index(){

    	return $this->fetch("list");
    }
    
    /**
     * 获取分页
     */
    public function pageQuery(){
    	$m = new M();
    	return $m->pageQuery($this->uids);
    }
}
