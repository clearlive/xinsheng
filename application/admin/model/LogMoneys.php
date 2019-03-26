<?php
namespace application\admin\model;
use think\Db;
/**
 
  
 
 

 

 
 * 红利业务处理
 */
class LogMoneys extends Base{
	/**
	 * 分页
	 */
	public function pageQuery($uids){

		$where['targetType'] = array('in',array(1,9,10));

		$targetId = input('targetId');
		$dataId = input('dataId');
        
        if($targetId) $where['targetId'] = $targetId;
        if($dataId) $where['dataId'] = $dataId;

        //时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$where['lm.createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}


		//用户搜素
		$userinfo = input('userName');
		if($userinfo){
			$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
		}


		if(!empty($uids)) $where['targetId'] = array('in',$uids);
		
        $list = $this->alias('lm')->field('lm.*,us.userName')
        		->join('__USERS__ us','us.userId=lm.targetId')
        		->where($where)->order('id desc')->paginate(input('pagesize/d'))->toArray();

        foreach ($list["Rows"] as $k => $v) {
        	
        	$list["Rows"][$k]['ups'] = myups($v['targetId'],1);
        }

        return $list;

	}


	/**
	 * 分页
	 */
	public function AllpageQuery($uids){

		//$where['targetType'] = 1;
		$where = array();
		$targetId = input('targetId');
		$dataId = input('dataId');
		$targetType = input('targetType');
        
        if($targetId || $targetId === '0') $where['targetId'] = $targetId;
        
        if($targetType || $targetType === '0') $where['targetType'] = $targetType;

        //时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$where['lm.createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}


		//用户搜素
		$userinfo = input('userName');
		if($userinfo){
			$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
		}

        //dump($where);exit;
        if(!empty($uids)) $where['targetId'] = array('in',$uids);
        
        
        $list = $this->alias('lm')->field('lm.*,us.userName')
        		->join('__USERS__ us','us.userId=lm.targetId')
        		->where($where)->order('id desc')->paginate(input('pagesize/d'))->toArray();

        foreach ($list["Rows"] as $k => $v) {
        	
        	$list["Rows"][$k]['ups'] = myups($v['targetId'],1);
        }

        return $list;

	}

}
