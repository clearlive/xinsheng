<?php
namespace application\admin\controller;
use application\admin\model\HomeMenus as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 前台菜单控制器
 */
class Homemenus extends Base{
	
    public function index(){
    	return $this->fetch("list");
    }
    
    /**
     * 获取菜单列表
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
    	return $m->getById((int)input("post.menuId"));
    }
    /**
     * 新增菜单
     */
    public function add(){
    	$m = new M();
    	return $m->add();
    }
    /**
     * 编辑菜单
     */
    public function edit(){
    	$m = new M();
    	return $m->edit();
    }
    /**
     * 删除菜单
     */
    public function del(){
    	$m = new M();
    	return $m->del();
    }
    
    /**
     * 显示隐藏
     */
    public function setToggle(){
    	$m = new M();
    	return $m->setToggle();
    }
    
    /**
    * 修改排序
    */ 
    public function changeSort(){
        $m = new M();
        return $m->changeSort();
    }
}
