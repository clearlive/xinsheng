<?php
namespace application\admin\controller;
use application\admin\model\SysConfigs as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 商城配置控制器
 */
class Sysconfigs extends Base{
	
    public function index(){
    	$m = new M();
    	$object = $m->getSysConfigs();
    	$this->assign("object",$object);
    	//$this->assign("areaList",model('areas')->listQuery(0));
    	return $this->fetch("edit");
    }
    
    /**
     * 保存
     */
    public function edit(){
    	$m = new M();
    	return $m->edit();
    }


    /**
     * 列表
     */
    public  function adddata(){
        $m = new M();
        return $m->adddata();
    }
}
