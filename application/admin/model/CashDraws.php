<?php
namespace application\admin\model;
use think\Db;
/**
 
  
 
 

 

 
 * 提现分类业务处理
 */
class CashDraws extends Base{
	/**
	 * 分页
	 */
	public function pageQuery($uids){
		$cashNo = input('cashNo');
		$cashSatus = input('cashSatus',-1);
        $where = [];
        if(in_array($cashSatus,[0,1,2]))$where['cashSatus'] = $cashSatus;
        if(!empty($uids)) $where['targetId'] = array('in',$uids);
        if($cashNo!='')$where['cashNo'] = ['like','%'.$cashNo.'%'];



        //时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$where['cd.createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}


		//用户搜素
		$userinfo = input('userName');
		if($userinfo){
			$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
		}

        $list = $this->alias('cd')->field('cd.*,us.userName')
        		->join('__USERS__ us','us.userId=cd.targetId')
        		->where($where)->order('cashId desc')->paginate(input('pagesize/d'))->toArray();

        
        
        foreach ($list["Rows"] as $k => $v) {
        	
        	$list["Rows"][$k]['ups'] = myups($v['targetId'],1);
        }
        return $list;
	}

	/**
	 * 获取提现详情
	 */
	public function getById(){
		$id = (int)input('id');
		return $this->get($id);
	}

	/**
	 * 处理提现
	 */
	public function handle(){
		$id = (int)input('cashId');
		$cash = $this->get($id);
		if(empty($cash))return WSTReturn('无效的提现申请记录');
		$user = model('users')->get($cash->targetId);
		if($user->lockMoney<$cash->money)return WSTReturn('操作失败，被冻结的金额小于提现金额');
		Db::startTrans();
		try{
            $cash->cashSatus = (int)input('cashSatus');
            $cash->cashRemarks = input('cashRemarks');
            $cash->doTime = date('Y-m-d H:i:s',time());

            $result = $cash->save();

            if(false != $result && $cash->cashSatus == 1){

            	$user->lockMoney = $user->lockMoney-$cash->money;
            	$user->save();
            	/*
            	//创建一条流水记录
            	$lm = [];
				$lm['targetType'] = 6;
				$lm['targetId'] = $cash->targetId;
				$lm['dataId'] = $id;
				$lm['dataSrc'] = 3;
				$lm['remark'] = '提现申请单【'.$cash->cashNo.'】申请提现¥'.$cash->money.'。'.(($cash->cashRemarks!='')?"【操作备注】：".$cash->cashRemarks:'');
				$lm['moneyType'] = 0;
				$lm['money'] = $cash->money;
				$lm['payType'] = 0;
				$lm['createTime'] = date('Y-m-d H:i:s');
				model('LogMoneys')->save($lm);
				*/
				//发送信息信息
				WSTSendMsg($cash->targetId,"您的提现申请单【".$cash->cashNo."】已通过，请留意您的账户信息",['from'=>5,'dataId'=>$id]);
				Db::commit();
				return WSTReturn('操作成功!',1);
            }elseif(false != $result && $cash->cashSatus == 2){

            	$user->lockMoney = $user->lockMoney-$cash->money;
            	$user->userMoney = $user->userMoney+$cash->money;
            	$user->save();

            	//创建一条流水记录
            	$lm = [];
				$lm['targetType'] = 6;
				$lm['targetId'] = $cash->targetId;
				$lm['dataId'] = $id;
				$lm['dataSrc'] = getsrc();
				$lm['remark'] = '提现拒绝';
				$lm['moneyType'] = 0;
				$lm['money'] = $cash->money;
				$lm['payType'] = 0;
				$lm['createTime'] = date('Y-m-d H:i:s');
				model('LogMoneys')->save($lm);


            	Db::commit();
            	return WSTReturn('操作成功!',1);
            }
		}catch (\Exception $e) {
            Db::rollback();
        }
		return WSTReturn('操作失败!',-1);
	}
}
