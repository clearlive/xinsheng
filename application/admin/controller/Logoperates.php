<?php
namespace application\admin\controller;
use application\admin\model\LogOperates as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 操作日志控制器
 */
class Logoperates extends Base{
	
    public function index(){
    	return $this->fetch("list");
    }
    
    /**
     * 获取分页
     */
    public function pageQuery(){
    	$m = new M();
    	return $m->pageQuery();
    }
    /**
     * 获取指定记录
     */
    public function get(){
    	$m = new M();
    	return $m->getById(input('id/d',0));
    }
}
