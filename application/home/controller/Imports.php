<?php
namespace application\home\controller;
use application\home\model\Imports as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 默认控制器
 */
class Imports extends Base{
	/**
	 * 数据导入首页
	 */
	public function index(){
		return $this->fetch('shops/import');
	}
	
    /**
     * 上传商品数据
     */
    public function importGoods(){
    	$rs = WSTUploadFile();
		if(json_decode($rs)->status==1){
			$m = new M();
    	    $rss = $m->importGoods($rs);
    	    return $rss;
		}
    	return $rs;
    }
}
