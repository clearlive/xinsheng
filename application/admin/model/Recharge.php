<?php
namespace application\admin\model;
use think\Db;
/**
 
  
 
 

 

 
 * 充值分类业务处理
 */
class Recharge extends Base{

	public function pageQuery($uids)
	{
		$where = array();
		if(!empty($uids)) $where['rc.uid'] = array('in',$uids);
		$where['bptype'] = array('neq',3);
		
		$bpid = input('bpid');   //订单号
        if($bpid)$where['bpid'] = ['like','%'.$bpid.'%'];
        
		//时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$where['rc.createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}


		//用户搜素
		$userinfo = input('userName');
		if($userinfo){
			$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
		}


		$list = $this->alias('rc')->field('rc.*,us.userName')
        		->join('__USERS__ us','us.userId=rc.uid')
        		->where($where)->order('bpid desc')->paginate(input('pagesize/d'))->toArray();


        
        foreach ($list["Rows"] as $k => $v) {
        	
        	$list["Rows"][$k]['ups'] = myups($v['uid'],1);
        }
        return $list;
	}

	/**
	 * 统计
	 */
	public function tongji($uids){
		$where = array();
		if(!empty($uids)) $where['rc.uid'] = array('in',$uids);
		$where['bptype'] = array('neq',3);

		//时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$where['rc.createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}


		//用户搜素
		$userinfo = input('userName');
		if($userinfo){
			$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
		}

		$res['allchongzhi'] = $this->alias('rc')->field('rc.*,us.userName')
			->join('__USERS__ us','us.userId=rc.uid')
			->where($where)->sum('bpprice');

		$res['allshouxu'] = $this->alias('rc')->field('rc.*,us.userName')
			->join('__USERS__ us','us.userId=rc.uid')
			->where($where)->sum('reg_par');
		$res['alldaozhang'] = $res['allchongzhi'] - $res['allshouxu'];

		return $res;


	}





}





