<?php
namespace application\admin\model;
use think\Db;
/**
 
 
 * 订单业务处理类
 */
class Drorder extends Base{
	/**
	 * 获取用户订单列表
	 */
	public function pageQuery($orderStatus = 10000,$isAppraise = -1,$uids=array()){

		$where['o.isCode'] = 0;
		
		$orderNo = input('orderNo');
		
		
		if($orderNo!='')$where['orderNo'] = ['like','%'.$orderNo.'%'];
		

		//时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$where['o.createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}else{
			$stacerateTime = date('Y-m-d').' 08:00:00';
			$star = strtotime($stacerateTime);
			if(time() < $star){

				$stacerateTime = date('Y-m-d H:i:s',$star-24*60*60);
			}
			$endcerateTime = date('Y-m-d H:i:s',strtotime($stacerateTime)+24*60*60);
			$between = array($stacerateTime,$endcerateTime);
			$where['o.createTime'] = array('between time',$between);
		}


		//用户搜素
		$userinfo = input('userinfo');
		if($userinfo){
			$uqwhere['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');

			$uq = input('uq');
			$uid = 0;
			if($uq){
				$uid = db('users')->alias('us')->where($uqwhere)->value('userId');

				if($uq == 101 ){
					$where['us.par101'] = $uid;
				}elseif($uq == 102){
					$where['us.par102'] = $uid;
				}elseif ($uq == 103) {
					$where['us.par103'] = $uid;
				}elseif ($uq == 104) {
					$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
				}

			}else{
				$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
			}
			
		}
		
		$areaId1 = (int)input('areaId1');

		

		if(!empty($uids)) $where['o.userId'] = array('in',$uids);

		//是否兑换
		$isres = input('isres');
		if($isres){
			if($isres == 2) $isres = 0;
			$where['o.isres'] = $isres;
		}

		
		
		$page = $this->alias('o')
				->join('__USERS__ us','o.userId=us.userId','left')
				->join('__GOODS__ g','g.goodsId=o.goodsId')
				->where($where)
			    ->field('o.*,us.userName,us.par101,us.par102,us.par103,g.goodsName,g.goodsImg,play2,play2fee,play4,play4fee,play10,play10fee,userPhone')
				->order('o.createTime', 'desc')
				->paginate(input('pagesize/d'))->toArray();

		$order_type = config('order_type');


	    if(count($page['Rows'])>0){
	    	 foreach ($page['Rows'] as $key => $v){
	    	 	$page['Rows'][$key]['par101'] = GetTableValue('users',$v['par101'],'userName','userId');
	    	 	$page['Rows'][$key]['par102'] = GetTableValue('users',$v['par102'],'userName','userId');
	    	 	$page['Rows'][$key]['par103'] = GetTableValue('users',$v['par103'],'userName','userId');
	    	 	//玩法.
	            if($v['drtype'] != 10){
	                $page['Rows'][$key]['dd_type'] = $order_type[$v['sectionno']];
	            }else{
	                $page['Rows'][$key]['dd_type'] = $v['sectionno'];
	            }
	            //时时彩
	            $page['Rows'][$key]['sscnum'] = GetTableValue('play_ssc_data',$v['sscqishu'],'balls','issue');
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


	/**
	 * 统计
	 * @author lukui  2017-12-05
	 * @return [type] [description]
	 */
	public function tongji($uids)
	{
		
		//总流水
		$where['o.isCode'] = 0;
		
		$orderNo = input('orderNo');
		
		
		if($orderNo!='')$where['orderNo'] = ['like','%'.$orderNo.'%'];
		

		//时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$where['o.createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}else{
			$stacerateTime = date('Y-m-d').' 08:00:00';
			$star = strtotime($stacerateTime);
			if(time() < $star){

				$stacerateTime = date('Y-m-d H:i:s',$star-24*60*60);
			}
			$endcerateTime = date('Y-m-d H:i:s',strtotime($stacerateTime)+24*60*60);
			$between = array($stacerateTime,$endcerateTime);
			$where['o.createTime'] = array('between time',$between);
		}


		//用户搜素
		$userinfo = input('userinfo');
		if($userinfo){
			$uqwhere['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');

			$uq = input('uq');
			$uid = 0;
			if($uq){
				$uid = db('users')->alias('us')->where($uqwhere)->value('userId');

				if($uq == 101 ){
					$where['us.par101'] = $uid;
				}elseif($uq == 102){
					$where['us.par102'] = $uid;
				}elseif ($uq == 103) {
					$where['us.par103'] = $uid;
				}elseif ($uq == 104) {
					$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
				}

			}else{
				$where['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
			}
			
		}
		
		$areaId1 = (int)input('areaId1');

		

		if(!empty($uids)) $where['o.userId'] = array('in',$uids);

		//是否兑换
		$isres = input('isres');
		if($isres){
			if($isres == 2) $isres = 0;
			$where['o.isres'] = $isres;
		}

		
		
		$page = $this->alias('o')
				->join('__USERS__ us','o.userId=us.userId','left')
				->join('__GOODS__ g','g.goodsId=o.goodsId')
				->where($where)
			    ->field('o.*,play2,play2fee,play4,play4fee,play10,play10fee')
				->order('o.createTime', 'desc')
				->select();
		

		$data['liushui'] = 0;
		$data['shouxu'] = 0;
		$data['yingkui'] = 0;
		$data['duihuan'] = 0;
		$data['weiduihuan'] = 0;
		$data['yingdan'] = 0;
		$data['shudan'] = 0;
		$data['jinxing'] = 0;

		foreach ($page as $k => $v) {
			//总流水
			$data['liushui'] += $v['orderMoney'];
			//总手续费
			$shouxu = $v['play'.$v['drtype'].'fee']*$v['orderNum'];
			$data['shouxu'] += $shouxu;
			//总盈亏
			if($v['iswin'] != 0){
				$data['yingkui'] +=$v['winmoney']+$v['goods_par'];
			}
			//总/未兑换
			if($v['isres'] == 1){
				$data['duihuan'] = $data['duihuan'] +  $v['orderMoney']+$v['winmoney'];
			}elseif($v['isres'] == 0 && $v['iswin'] == 1){
				$data['weiduihuan'] = $data['weiduihuan'] + $v['orderMoney']+$v['winmoney'];
			}
			//总盈/输单数
			if($v['iswin'] == 1){
				$data['yingdan'] += $v['orderMoney'];
			}elseif($v['iswin'] == 2){
				$data['shudan'] += $v['orderMoney'];
			}
			//进行中
			if($v['isover'] == 0){
				$data['jinxing'] += $v['orderMoney'];
			}

		}


		return json_encode($data);


	}
}
