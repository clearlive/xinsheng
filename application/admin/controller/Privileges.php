<?php
namespace application\admin\controller;
use application\admin\model\Privileges as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 权限控制器
 */
class privileges extends Base{  
    /**
     * 获取权限列表
     */
    public function listQuery(){
    	$m = new M();
    	return $m->listQuery((int)Input("id"));
    }
    /**
     * 获取权限
     */
    public function get(){
    	$m = new M();
    	return $m->getById((int)Input("id"));
    }
    /**
     * 新增权限
     */
    public function add(){
    	$m = new M();
    	return $m->add();
    }
    /**
     * 编辑权限
     */
    public function edit(){
    	$m = new M();
    	return $m->edit();
    }
    /**
     * 删除权限
     */
    public function del(){
    	$m = new M();
    	return $m->del();
    }
    /**
     * 检测权限代码是否存在
     */
    public function checkPrivilegeCode(){
    	$m = new M();
    	return $m->checkPrivilegeCode();
    }
    /**
     * 获取角色的权限
     */
    public function listQueryByRole(){
    	$m = new M();
    	return $m->listQueryByRole((int)Input("id"));
    }
}
