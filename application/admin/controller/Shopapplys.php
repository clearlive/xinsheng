<?php
namespace application\admin\controller;
use application\admin\model\ShopApplys as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 店铺申请控制器
 */
class Shopapplys extends Base{
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
     * 获取菜单
     */
    public function get(){        
    	$m = new M();
    	return $m->get((int)Input("post.id"));
    }
    /**
     * 跳去处理页面
     */
    public function toHandle(){
    	$m = new M();
    	$rs = $m->getById((int)Input("get.id"));
    	$this->assign("object",$rs);
    	return $this->fetch("edit");
    }
    /**
     * 编辑菜单
     */
    public function handle(){
    	$m = new M();
    	return $m->handle();
    }
    /**
     * 删除菜单
     */
    public function del(){
    	$m = new M();
    	return $m->del();
    }
}
