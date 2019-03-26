<?php
namespace application\admin\model;
use think\Db;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 订单业务处理类
 */
class Orders extends Base{
	/**
	 * 获取用户订单列表
	 */
	public function pageQuery($orderStatus = 10000,$isAppraise = -1,$uids=array()){
		$where = ['o.dataFlag'=>1];
		if($orderStatus!=10000){
			$where['orderStatus'] = $orderStatus;
		}
		$orderNo = input('orderNo');
		$shopName = input('shopName');
		$payType = (int)input('payType',-1);
		$deliverType = (int)input('deliverType',-1);
		if($isAppraise!=-1)$where['isAppraise'] = $isAppraise;
		if($orderNo!='')$where['orderNo'] = ['like','%'.$orderNo.'%'];
		if($shopName!='')$where['shopName|shopSn'] = ['like','%'.$shopName.'%'];

		//时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$where['o.createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}
		//玩法搜索
		$playtype = input('playtype');
		
		if($playtype != 10000 && $playtype != NULL){
			$where['o.playtype'] = $playtype;
		}
		

		//用户搜素
		$userinfo = input('userinfo');
		if($userinfo){
			$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
		}
		
		$areaId1 = (int)input('areaId1');

		if($areaId1>0){
			$where['s.areaIdPath'] = ['like',"$areaId1%"];
			$areaId2 = (int)input("areaId1_".$areaId1);
			if($areaId2>0)$where['s.areaIdPath'] = ['like',$areaId1."_"."$areaId2%"];
			$areaId3 = (int)input("areaId1_".$areaId1."_".$areaId2);
			if($areaId3>0)$where['s.areaId'] = $areaId3;
		}

		if(!empty($uids)) $where['o.userId'] = array('in',$uids);

		if($deliverType!=-1)$where['o.deliverType'] = $deliverType;
		if($payType!=-1)$where['o.payType'] = $payType;
		$page = $this->alias('o')->join('__SHOPS__ s','o.shopId=s.shopId','left')
				->join('__USERS__ us','o.userId=us.userId','left')
				->join('__PLAY__ p','o.playtype=p.playId','left')
				->where($where)
			    ->field('o.orderId,o.orderNo,s.shopName,s.shopId,s.shopQQ,s.shopWangWang,o.goodsMoney,o.totalMoney,o.realTotalMoney,o.orderStatus,o.userName,o.deliverType,payType,payFrom,o.orderStatus,orderSrc,o.createTime,us.userName,o.userId,o.playtype,p.playName,p.playCode,us.par101,us.par102,us.par103,o.winmoney,o.is_tuihuo,o.is_tihuo,o.is_duihuan,o.is_over,o.iswin')
				->order('o.createTime', 'desc')
				->paginate(input('pagesize/d'))->toArray();

	    if(count($page['Rows'])>0){
	    	 foreach ($page['Rows'] as $key => $v){
	    	 	 $page['Rows'][$key]['payType'] = WSTLangPayType($v['payType']);
	    	 	 $page['Rows'][$key]['deliverType'] = WSTLangDeliverType($v['deliverType']==1);
	    	 	 $page['Rows'][$key]['status'] = WSTLangOrderStatus($v['orderStatus']);
	    	 	 $page['Rows'][$key]['par101'] = GetTableValue('users',$v['par101'],'userName','userId');
	    	 	 $page['Rows'][$key]['par102'] = GetTableValue('users',$v['par102'],'userName','userId');
	    	 	 $page['Rows'][$key]['par103'] = GetTableValue('users',$v['par103'],'userName','userId');
	    	 }
	    }
	    
	    return $page;
	}
	
    /**
	 * 获取用户退款订单列表
	 */
	public function refundPageQuery(){
		$where = ['o.dataFlag'=>1];
		$where['orderStatus'] = ['in',[-1,-4]];
		$where['o.payType'] = 1;
		$orderNo = input('orderNo');
		$shopName = input('shopName');
		$deliverType = (int)input('deliverType',-1);
		$areaId1 = (int)input('areaId1');
		$areaId2 = (int)input('areaId2');
		$areaId3 = (int)input('areaId3');
		$isRefund = (int)input('isRefund',-1);
		if($orderNo!='')$where['orderNo'] = ['like','%'.$orderNo.'%'];
		if($shopName!='')$where['shopName|shopSn'] = ['like','%'.$shopName.'%'];
		if($areaId1>0)$where['s.areaId1'] = $areaId1;
		if($areaId2>0)$where['s.areaId2'] = $areaId2;
		if($areaId3>0)$where['s.areaId3'] = $areaId3;
		if($deliverType!=-1)$where['o.deliverType'] = $deliverType;
		if($isRefund!=-1)$where['o.isRefund'] = $isRefund;
		$page = $this->alias('o')->join('__SHOPS__ s','o.shopId=s.shopId','left')
		     ->join('__ORDER_REFUNDS__ orf ','o.orderId=orf.orderId','left') 
		     ->where($where)
		     ->field('o.orderId,o.orderNo,s.shopName,s.shopId,s.shopQQ,s.shopWangWang,o.goodsMoney,o.totalMoney,o.realTotalMoney,
		              o.orderStatus,o.userName,o.deliverType,payType,payFrom,o.orderStatus,orderSrc,orf.refundRemark,isRefund,o.createTime')
			 ->order('o.createTime', 'desc')
			 ->paginate(input('pagesize/d'))->toArray();
	    if(count($page['Rows'])>0){
	    	 foreach ($page['Rows'] as $key => $v){
	    	 	 $page['Rows'][$key]['payType'] = WSTLangPayType($v['payType']);
	    	 	 $page['Rows'][$key]['deliverType'] = WSTLangDeliverType($v['deliverType']==1);
	    	 	 $page['Rows'][$key]['status'] = WSTLangOrderStatus($v['orderStatus']);
	    	 }
	    }
	    return $page;
	}
	/**
	 * 获取退款资料
	 */
	public function getInfoByRefund(){
		return $this->where(['orderId'=>(int)input('get.id'),'isRefund'=>0,'orderStatus'=>['in',[-1,-4]]])
		         ->field('orderNo,orderId,goodsMoney,totalMoney,realTotalMoney,deliverMoney,payType,payFrom,tradeNo')
		         ->find();
	}
	/**
	 * 退款
	 */
	public function orderRefund(){
		$id = (int)input('post.id');
		$content = input('post.content');
		if($id==0)return WSTReturn("操作失败!");
		$order = $this->where(['orderId'=>(int)input('post.id'),'payType'=>1,'isRefund'=>0,'orderStatus'=>['in',[-1,-4]]])
		         ->field('userId,orderNo,orderId,goodsMoney,totalMoney,realTotalMoney,deliverMoney,payType,payFrom,tradeNo')
		         ->find();
		if(empty($order))return WSTReturn("该订单不存在或已退款!");
		Db::startTrans();
        try{
			$order->isRefund = 1;
			$order->save();
			//修改用户账户金额
			Db::name('users')->where('userId',$order->userId)->setInc('userMoney',$order->realTotalMoney);
			//创建资金流水记录
			$lm = [];
			$lm['targetType'] = 0;
			$lm['targetId'] = $order->userId;
			$lm['dataId'] = $order->orderId;
			$lm['dataSrc'] = 1;
			$lm['remark'] = '订单【'.$order->orderNo.'】退款¥'.$order->realTotalMoney."。".(($content!='')?"【退款备注】：".$content:'');
			$lm['moneyType'] = 1;
			$lm['money'] = $order->realTotalMoney;
			$lm['payType'] = 0;
			$lm['createTime'] = date('Y-m-d H:i:s');
			model('LogMoneys')->save($lm);
			//创建退款记录
			$data = [];
			$data['orderId'] = $id;
			$data['refundRemark'] = $content;
			$data['refundTime'] = date('Y-m-d H:i:s');
			$rs = Db::name('order_refunds')->insert($data);
			if(false !== $rs){
				//发送一条用户信息
				WSTSendMsg($order['userId'],"您的退款订单【".$order['orderNo']."】已处理，请留意账户到账情况。".(($content!='')?"【退款备注：".$content."】":""),['from'=>1,'dataId'=>$id]);
				Db::commit();
				return WSTReturn("操作成功",1); 
			}
        }catch (\Exception $e) {

            Db::rollback();
        }
		return WSTReturn("操作失败，请刷新后再重试"); 
	}
	
	
	/**
	 * 获取订单详情
	 */
	public function getByView($orderId){
		$orders = $this->alias('o')->join('__PLAY__ p ','o.playtype=p.playId','left')
		               ->where('o.dataFlag=1 and o.orderId='.$orderId)
		               ->field('o.*,p.playName,p.playCode')->find();
		if(empty($orders))return WSTReturn("无效的订单信息");
		
		//获取订单商品
		$orders['goods'] = Db::name('order_goods')->where('orderId',$orderId)->order('id asc')->select();

		$orders['playinfo'] = Db::name('play_'.$orders['playCode'].'_order')->where('id',$orders['playid'])->find();
		//玩法
		if($orders['playCode'] == 'jiou'){

			$balls = Db::name('play_ssc_data')->where('issue',$orders['playinfo']['issue'])->value('balls');
			$orders['balls'] = $balls;
			
		}
		return $orders;
	}
}
