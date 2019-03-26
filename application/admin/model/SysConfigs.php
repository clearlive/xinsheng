<?php
namespace application\admin\model;
/**
 
  
 
 

 

 
 * 商城配置业务处理
 */
use think\Db;
class SysConfigs extends Base{
	/**
	 * 获取商城配置
	 */
	public function getSysConfigs(){
		$rs = $this->field('fieldCode,fieldValue')->select();
		$rv = [];
		foreach ($rs as $v){
			$rv[$v['fieldCode']] = $v['fieldValue'];
		}
		return $rv;
	}

	
    /**
	 * 编辑
	 */
	public function edit(){
		$list = $this->field('configId,fieldCode,fieldValue')->select();
		Db::startTrans();
        try{
			foreach ($list as $key =>$v){
				$code = trim($v['fieldCode']);
				$val = Input('post.'.trim($v['fieldCode']));
			    //启用图片
				if(substr($val,0,7)=='upload/' && strpos($val,'.')!==false){
					WSTUseImages(1, $v['configId'],$val, 'sys_configs','fieldValue');
				}
				$this->update(['fieldValue'=>$val],['fieldCode'=>$code]);
			}
			Db::commit(); 
			cache('WST_CONF',null);
			return WSTReturn("操作成功", 1);
        }catch (\Exception $e) {
        	print_r($e);
		    Db::rollback();
		}
		return WSTReturn("操作失败", 1);
	}

	/**
	 * 列表
	 */
	public function adddata(){
		$data = input('post.');

		$isset = $this->where('fieldCode',$data['fieldCode'])->find();

		if($isset){
			return WSTReturn('此配置已存在');
		}


		$ids = $this->insert($data);
		if($ids){
			return WSTReturn('新增成功',1);
		}else{
			return WSTReturn('新增失败');
		}


	}
	
}
