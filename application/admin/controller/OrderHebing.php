<?php
namespace application\admin\controller;
use application\admin\model\OrderHebing as M;
/**
 
  
 
 

 

 
 * 订单控制器
 */
class OrderHebing extends Base{
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

    public function fahuo()
    {
        
        $post = input('post.');
        if (isset($post['exname'])) {
            $static = 1;
        }else{
            $static = $post['_static'];
            unset($post['_static']);
        }
        if(!$post) return  WSTReturn("无效的订单信息");

        //处理订单
        $db_orders = db('orders');
        $hborder = db('order_hebing')->where('hbid',$post['hbid'])->find();
        $arrorder = json_decode($hborder['orders'],1);
        $_time = date('Y-m-d H:i:s',time());
        if(!is_array($arrorder)) {
            $_oid = $arrorder;
            $arrorder = array();
            $arrorder[0] = $_oid;
        }
        foreach ($arrorder as $k => $v) {
            $_data['orderId'] = $v;
            $_data['hbstatic'] = $static;
            $db_orders->update($_data);
        }
        

        $post['static'] = $static;
        $ids = db('order_hebing')->update($post);

        if ($ids) {
            return  WSTReturn("处理成功",1);
        }else{
            return  WSTReturn("处理失败");
        }
        
    }



    
   
}
