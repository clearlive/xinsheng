<?php
namespace application\admin\controller;
use application\admin\model\LogMoneys as M;
/**
 
  
 
 

 

 
 * 红利控制器
 */
class Hongli extends Base{

    public function index(){
      
      $this->assign('uid',input('uid'));
      $this->assign('orderId',input('orderId'));
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
