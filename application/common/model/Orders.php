<?php
namespace application\common\model;
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
	 * 提交订单
	 */
	public function submit(){
		$post = input('post.');
		$userId = (int)session('WST_USER.userId');
		$users = db('users')->where('userId',$userId)->find();
		$goods = db('goods')->where('goodsId',$post['goodsId'])->find();

		
		
		
		//判断用户状态
		if($users['userStatus'] != 1){
			return WSTReturn('用户被冻结');
		}
		//判断库存
		if($goods['goodsStock'] < $post['num']){
			return WSTReturn('库存不足');
		}

		if($post['goodsId'] == 1 && $users['isNew'] != 1){
			return WSTReturn('此产品为新用户体验产品，您已体验');
		}
		
		
		//拼接下单数组
		$orderNo = WSTOrderNo();
		$orderScore = 0;
		$order = [];
		$order['orderNo'] = $orderNo;
		$order['userId'] = $userId;
		$order['shopId'] = 1;
		$order['goodsId'] = $post['goodsId'];
		$order['payType'] = $post['type'];
		$order['orderStatus'] = 0;
		$order['isPay'] = 1;
		$order['orderNum'] = $post['num'];
		$order['goodsMoney'] = $goods['shopPrice']*$order['orderNum'];
		$order['deliverType'] = $post['freight'] > 0?1:0;
		$order['deliverMoney'] = $post['freight'];
		$order['totalMoney'] = round(($order['goodsMoney']+$order['deliverMoney']),2);
		$order['realTotalMoney'] = $order['totalMoney'];
		$order['needPay'] = $order['realTotalMoney'];
		$order['orderScore'] = 0;//积分
		$order['isInvoice'] = 0;
		$order['invoiceClient'] = 0;
		$order['createTime'] = date('Y-m-d H:i:s');

		//优惠券
		if(isset($post['couponids']) && !empty($post['couponids'])){
			$cs = db('couponsend')->where('csid',$post['couponids'])->find();
			if(!$cs) return WSTReturn('优惠券不存在');
			if($cs['isUse'] == 1) return WSTReturn('优惠券已使用');

			$coupon = db('coupon')->where('cid',$cs['cid'])->find();
			if(!$coupon) return WSTReturn('优惠券不存在!');
			if($coupon['cStatic'] != 1) return WSTReturn('优惠券暂时无法使用!');
			if($coupon['cUse'] > $goods['shopPrice']) return WSTReturn('商品单价满'.$coupon['cUse'].'才能使用');

			$order['needPay'] = round($order['needPay']-$coupon['cMoney'],2);
			$editMoney = round($order['goodsMoney']-$coupon['cMoney'],2);
			
			$order['csid'] = $cs['cid'];

		}else{
			$editMoney = $order['goodsMoney'];
		}
		//判断余额
		if($users['userMoney'] < $order['needPay']){
			return WSTReturn('余额不足');
		}

		//下单
		$orderId = $this->insertGetId($order);

		//优惠券
		if(isset($post['couponids']) && !empty($post['couponids'])){
			
			$_cs['isUse'] = 1;
			$_cs['useTime'] = date('Y-m-d H:i:s');
			$_cs['orderId'] = $orderId;
			$_cs['csid'] = $post['couponids'];
			db('couponsend')->update($_cs);

		}

		//下单成功扣费
		
		$setmoney = Db::name('users')->where('userId', $userId)->setDec('userMoney', $editMoney);

		if(!$setmoney && $order['goodsId'] != 1){
			$this->where('orderId',$orderId)->delete();
			return WSTReturn('订单扣费失败');
		}

		//users 表下注 增加
		Db::name('users')->where('userId', $userId)->setInc('allTouzhu', $editMoney);

		if($order['goodsId'] == 1){
			Db::name('users')->where('userId', $userId)->update(array('isNew'=>0));
		}

		//扣费拼接日志数组
		$lm = [];
		$lm['targetType'] = 0;
		$lm['targetId'] = $userId;
		$lm['dataId'] = $orderId;
		$lm['dataSrc'] = getsrc();
		$lm['remark'] = '用户下单扣费';
		$lm['moneyType'] = 1;
		$lm['money'] = $editMoney;
		$lm['payType'] = 0;
		$lm['createTime'] = $order['createTime'];
		Db::name('log_moneys')->insert($lm);
		
		$res['goodsId'] = $post['goodsId'];
		$res['ordersId'] = $orderId;
		

		return WSTReturn($res,1);

		exit;
		
		
	}



	/**
	 * 获取用户订单列表
	 */
	public function userOrdersByPage($orderStatus,$isAppraise = -1){
		$userId = (int)session('WST_USER.userId');
		$type = input('type')?input('type'):0;

		$where = ['o.userId'=>$userId,'o.dataFlag'=>1];

		switch ($type) {
			case '0':
				
				break;
			case '1':
				$where['playtype'] = array('neq',0);
				$where['is_over'] = 0;
				break;
			case '2':
				$where['playtype'] = array('neq',0);
				$where['is_over'] = 1;
				break;
			case '3':
				$where['playtype'] = array('eq',0);
				break;
			default:
				# code...
				break;
		}
		
		$page = $this->alias('o')->join('__SHOPS__ s','o.shopId=s.shopId','left')
		             ->join('__ORDER_COMPLAINS__ oc','oc.orderId=o.orderId','left')
		             ->join('__ORDER_REFUNDS__ orf','orf.orderId=o.orderId and orf.refundStatus!=-1','left')
		             ->join('__GOODS__ gs','gs.goodsId=o.goodsId','left')
		             ->where($where)
		             ->field('o.*,oc.complainId,orf.id refundId,gs.goodsImg,gs.shopPrice,gs.goodsName,gs.sjgoodsImg,gs.sjshopPrice,gs.sjgoodsName')
			         ->order('o.createTime', 'desc')
			         ->paginate(input('pagesize/d'))->toArray();
	    if(count($page['Rows'])>0){

	    	 $orderIds = [];
	    	 foreach ($page['Rows'] as $v){
	    	 	 $orderIds[] = $v['orderId'];
	    	 }
	    	 $goods = Db::name('order_goods')->where('orderId','in',$orderIds)->select();
	    	 $goodsMap = [];
	    	 foreach ($goods as $v){
	    	 	 $v['goodsSpecNames'] = str_replace('@@_@@','、',$v['goodsSpecNames']);
	    	 	 $goodsMap[$v['orderId']][] = $v;
	    	 }
	    	 $db_order_hebing = db('order_hebing');

	    	 foreach ($page['Rows'] as $key => $v){
	    	 	 //$page['Rows'][$key]['list'] = $goodsMap[$v['orderId']];
	    	 	 $page['Rows'][$key]['isComplain'] = 1;
	    	 	 if(($v['complainId']=='') && ($v['payType']==0 || ($v['payType']==1 && $v['orderStatus']!=2))){
	    	 	 	$page['Rows'][$key]['isComplain'] = '';
	    	 	 }
	    	 	 $page['Rows'][$key]['payTypeName'] = WSTLangPayType($v['payType']);
	    	 	 $page['Rows'][$key]['deliverType'] = WSTLangDeliverType($v['deliverType']==1);
	    	 	 $page['Rows'][$key]['status'] = WSTLangOrderStatus($v['orderStatus']);
	    	 	 if($v['hebingid'] != 1 ){
	    	 	 	$page['Rows'][$key]['hebingorder'] = $db_order_hebing->where('hbid',$v['hebingid'])->find();
	    	 	 }
	    	 }
	    }

	    return $page;
	}
	
}
