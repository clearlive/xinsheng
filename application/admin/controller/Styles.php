<?php
namespace application\admin\controller;
use application\admin\model\Styles as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 风格配置控制器
 */
class Styles extends Base{
	
    public function index(){
        $m = new M();
        $rs = $m->getCats();
        $this->assign('cats',$rs);
    	return $this->fetch();
    }
    /**
     * 获取风格列表
     */
    public function listQueryBySys(){
        $m = new M();
        $rs = $m->listQuery();
        return WSTReturn('',1,$rs);
    }
    
    /**
     * 保存
     */
    public function changeStyle(){
    	$m = new M();
    	return $m->changeStyle();
    }
}
