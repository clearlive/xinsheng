<?php
namespace application\home\controller;
use application\common\model\ShopCats as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 门店分类控制器
 */
class Shopcats extends Base{

	/**
	 * 列表
	 */
	public function index(){
		$m = new M();
		$list = $m->getCatAndChild(session('WST_USER.shopId'),input('post.parentId/d'));
		$this->assign('list',$list);
		return $this->fetch("shops/shopcats/list");
	}
	
    /**
     * 修改名称
     */
    public function editName(){
    	$m = new M();
    	$rs = array();
    	if(input('post.id/d')>0){
    		$rs = $m->editName();
    	}
    	return $rs;
    }
    /**
     * 修改排序
     */
    public function editSort(){
    	$m = new M();
    	$rs = array();
    	if(input('post.id/d')>0){
    		$rs = $m->editSort();
    	}
    	return $rs;
    }
    /**
     * 批量保存商品分类
     */
    public function batchSaveCats(){
    	$m = new M();
    	$rs = $m->batchSaveCats();
    	return $rs;
    }
    /**
     * 删除操作
     */
    public function del(){
    	$m = new M();
    	$rs = $m->del();
    	return $rs;
    }
    
    /**
     * 列表查询
     */
    public function listQuery(){
    	$m = new M();
    	$list = $m->listQuery((int)session('WST_USER.shopId'),input('post.parentId/d'));
    	$rs = array();
    	$rs['status'] = 1;
    	$rs['list'] = $list;
    	return $rs;
    }
    
    public function changeCatStatus(){
    	$m = new M();
    	$rs = $m->changeCatStatus();
    	return $rs;
    }
	
}
