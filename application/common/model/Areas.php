<?php
namespace application\common\model;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 地区类
 */
class Areas extends Base{
	
 	/**
	   * 获取所有城市-根据字母分类
	   */
	public function getCityGroupByKey(){
		$rs = array();
	  	$rslist = $this->where('isShow=1 AND dataFlag = 1 AND areaType=1')->field('id,name,areaKey')->order('areaKey, areaSort')->select();
	  	foreach ($rslist as $key =>$row){
	  		$rs[$row["areaKey"]][] = $row;
	  	}
	  	return $rs;
	}
	/**
	 * 获取城市列表
	 */
	public function getCitys(){
        return $this->where('isShow=1 AND dataFlag = 1 AND areaType=1')->field('id,name')->order('areaKey, areaSort')->select();
	}
	
	public function getArea($id2){
		$rs = $this->where(["isShow"=>1,"dataFlag"=>1,"areaType"=>1,"id"=>$id2])->field('id,name,areaKey')->find();
		return $rs;
	}
	/**
	 *  获取地区列表
	 */
	public function listQuery($pid = 0){
		$pid = ($pid>0)?$pid:(int)input('pid');
		return $this->where(['isShow'=>1,'dataFlag'=>1,'pid'=>$pid])->field('id,name,pid')->order('areaSort desc')->select();
	}
	/**
	 *  获取指定对象
	 */
    public function getById($id){
		return $this->where(["id"=>(int)$id])->find()->toArray();
	}
    /**
	 * 根据子分类获取其父级分类
	 */
	public function getParentIs($id,$data = array()){
		$data[] = $id;
		$pid = $this->where('id',$id)->value('pid');
		if($pid==0){
			krsort($data);
			return $data;
		}else{
			return $this->getParentIs($pid, $data);
		}
	}
	/**
	 * 获取自己以及父级的地区名称
	 */
	public function getParentNames($id,$data = array()){
		$areas = $this->where('id',$id)->field('pid,name')->find();
		$data[] = $areas['name'];
		if((int)$areas['pid']==0){
			krsort($data);
			return $data;
		}else{
			return $this->getParentNames((int)$areas['pid'], $data);
		}
	}
}
