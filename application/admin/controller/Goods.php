<?php
namespace application\admin\controller;
use application\admin\model\Goods as M;
use application\common\model\Goods as HM;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 商品控制器
 */
class Goods extends Base{
   /**
	* 查看上架商品列表
	*/
	public function index(){
    	//$this->assign("areaList",model('areas')->listQuery(0));
		return $this->fetch('list_sale');
	}
   /**
    * 批量删除商品
    */
    public function batchDel(){
        $m = new M();
        return $m->batchDel();
    }

    /**
    * 设置违规商品
    */
    public function illegal(){
        $m = new M();
        return $m->illegal();
    }
    /**
     * 通过商品审核
     */
    public function allow(){
        $m = new M();
        return $m->allow();
    }
	/**
	 * 获取上架商品列表
	 */
	public function saleByPage(){
		$m = new M();
		$rs = $m->saleByPage();
		$rs['status'] = 1;
		return $rs;
	}
	
    /**
	 * 审核中的商品
	 */
    public function auditIndex(){
    	$this->assign("areaList",model('areas')->listQuery(0));
		return $this->fetch('goods/list_audit');
	}
	/**
	 * 获取审核中的商品
	 */
    public function auditByPage(){
		$m = new M();
		$rs = $m->auditByPage();
		$rs['status'] = 1;
		return $rs;
	}
   /**
	 * 审核中的商品
	 */
    public function illegalIndex(){
    	$this->assign("areaList",model('areas')->listQuery(0));
		return $this->fetch('list_illegal');
	}
    /**
	 * 获取违规商品列表
	 */
	public function illegalByPage(){
		$m = new M();
		$rs = $m->illegalByPage();
		$rs['status'] = 1;
		return $rs;
	}
    
    /**
     * 跳去编辑页面
     */
    public function toView(){

    	$m = new M();
    	$object = $m->getById(input('get.id'));
    	if($object['goodsImg']=='')$object['goodsImg'] = WSTConf('CONF.goodsLogo');
    	$data = ['object'=>$object];
    	return $this->fetch('default/shops/goods/edit',$data);
    }
    
    /**
     * 编辑商品
     */
    public function toEdit(){

    	$m = new HM();
        $object = $m->getById(input('get.id'));
        
        if($object['goodsImg']=='')$object['goodsImg'] = WSTConf('CONF.goodsLogo');
        $data = ['object'=>$object,'src'=>input('src')];
        
        return $this->fetch('goods/addgoods',$data);
    }

    public function toEdits()
    {
        $m = new HM();
        return $m->edit();

    }

    public function toadds()
    {
        
        $m = new HM();
        return $m->add();
    }
    /**
     * 删除商品
     */
    public function del(){
    	$m = new M();
    	return $m->del();
    }

    /*
    添加产品
    */
    public function addgoods()
    {
        
        $m = new M();
        $m->addgoods();
        //$m = new M();
        $object = $m->getEModel('goods');
        $object['goodsSn'] = WSTGoodsNo();
        $object['productNo'] = WSTGoodsNo();
        $object['goodsImg'] = WSTConf('CONF.goodsLogo');
        $data = ['object'=>$object,'src'=>'addgoods'];

        return $this->fetch('goods/addgoods',$data);
    }
}
