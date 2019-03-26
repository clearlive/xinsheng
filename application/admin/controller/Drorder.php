<?php
namespace application\admin\controller;
use application\admin\model\Drorder as M;
/**
 
  
 
 

 

 
 * 订单控制器
 */
class Drorder extends Base{
	/**
	 * 订单列表
	 */
    public function index(){
    	return $this->fetch("list");
    }
    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        return $m->pageQuery((int)input('orderStatus',10000),'',$this->uids);
    }
   /**
    * 获取订单详情
    */
    public function view(){
        $m = new M();
        $rs = $m->getByView(Input("id/d",0));
        $this->assign("object",$rs);
        return $this->fetch("view");
    }

    /**
     * 统计
     * @author lukui  2017-12-05
     * @return [type] [description]
     */
    public function tongji()
    {
        
        $m = new M();
        return $m->tongji($this->uids);
    }
}
