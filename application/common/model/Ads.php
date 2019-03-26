<?php
namespace application\common\model;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 广告类
 */
class Ads extends Base{
	public function recordClick(){
		$id = (int)input('id');
		return $this->where("adId=$id")->setInc('adClickNum');
	}
}
