<?php
namespace application\home\controller;
use application\home\model\Settlements as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 结算控制器
 */
class Settlements extends Base{
	
    public function index(){
    	  return $this->fetch('shops/settlements/list');
    }

    /**
     * 获取结算单
     */
    public function pageQuery(){
        $m = new M();
        $rs = $m->pageQuery();
        return WSTReturn('',1,$rs);
    }
    /**
     * 获取待结算订单
     */
    public function pageUnSettledQuery(){
        $m = new M();
        $rs = $m->pageUnSettledQuery();
        return WSTReturn('',1,$rs);
    }
    /**
     * 结算订单
     */
    public function settlement(){
        $m = new M();
        return $m->settlement();
   } 
   /**
    * 获取已结算订单
    */
   public function pageSettledQuery(){
       $m = new M();
       $rs = $m->pageSettledQuery();
       return WSTReturn('',1,$rs);
   }
   /**
    * 查看结算详情
    */
   public function view(){
       $m = new M();
       $rs = $m->getById();
       $this->assign('object',$rs);
       return $this->fetch('shops/settlements/view');
   }
}
