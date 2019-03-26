<?php
namespace application\common\model;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 系统配置类
 */
class SysConfigs extends Base{
	
	/**
	 * 获取商城配置文件
	 */
	public function loadConfigs(){
		
		$rs = $this->field('fieldCode,fieldValue')->order("parentId asc,fieldSort asc")->select();
		$configs = array();
		if(count($rs)>0){
			foreach ($rs as $key=>$v){
				if($v['fieldCode']=="hotSearchs"){
					$fieldValue = str_replace("，",",",$v['fieldValue']);
					$configs[$v['fieldCode']] = explode(",",$fieldValue);
				}else{
					$configs[$v['fieldCode']] = $v['fieldValue'];
				}
			}
		}
		unset($rs);
		return $configs;
	}
}
