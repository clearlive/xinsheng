<?php
namespace application\home\controller;
use application\common\model\Orders as M;
/**
 
  
 
 

 

 
 * 订单控制器
 */
class Orders extends Base{
    /**
    * 提交订单
    */
	public function submit(){
		$m = new M();
		$rs = $m->submit();
		return $rs;
	}


	public function index()
	{
		$m = new M();
		$rs = $m->userOrdersByPage('');

		$type = input('type')?input('type'):0;
		$this->assign('type',$type);
		$this->assign('list',$rs);
		//玩法
        $playlist = model('Play')->getlist();
        
        $this->assign('playlist',$playlist);

		return $this->fetch('orders/index');
	}

	public function getlist()
	{
		
		$m = new M();
		$rs = $m->userOrdersByPage('');
		$this->assign($rs);
		return WSTReturn("", 1,$rs);
	}

	//退货-返佣审核
	public function orderJson($type=null)
	{
		

		$m = new M();
		$map['orderId'] = input('id');
		$order = $m->where($map)->find();

		$goods = db('goods')->where(array('goodsId'=>$order['goodsId']))->find();

		if(!$order) $this->error('订单不存在');
		//if($order['iswin'] != 1) $this->error('订单不得退款');
		if($order['is_tihuo'] == 1) $this->error('订单已提货');
		if($order['is_tuihuo'] == 1) $this->error('订单已退货');
		if($order['is_duihuan'] == 1) $this->error('订单已兑换');

		//是否参与优惠券
		$cMoney = 0;
		if($order['csid']){
			$cs = db('couponsend')->where('csid',$order['csid'])->find();
			$coupon = db('coupon')->where('cid',$cs['cid'])->find();
			if($coupon) $cMoney = $coupon['cMoney'];
		}
		if($order['playtype'] == 0){
			$data['totalMoney'] = round($goods['shopPrice']*$order['orderNum'],2);
		}else{
			$data['totalMoney'] = round($goods['sjshopPrice']*$order['orderNum'],2);
		}

		$data['totalMoney'] = $data['totalMoney'] - $cMoney;
		
		$data['orderId'] = $map['orderId'];
		$data['depotId'] = $goods['goodsId'];
		$data['loginname'] = $this->users['loginName'];
		
		if(!$type){
			$this->success($data);
		}else{
			return $data;
		}
		
		


	}

	public function ajaxtuihuo()
	{
		
		$res = $this->orderJson( 1 );
		if(!$res) $this->error('订单不得退款');

		
		//更改订单状态
		$omap['orderId'] = $res['orderId'];
		$odata['is_tuihuo'] = 1;
		$oids = db('orders')->where($omap)->update($odata);
		if(!$oids) $this->error('订单处理失败，请联系管理员');
		//客户加钱
		$uids = db('users')->where('userId',$this->uid)->setInc('userMoney',$res['totalMoney']);
		if(!$uids) $this->error('资金处理失败，请联系管理员');
		//资金日志
		$lm = [];
        $lm['targetType'] = 3;
        $lm['targetId'] = $this->users['userId'];
        $lm['dataId'] = $res['orderId'];
        $lm['dataSrc'] = getsrc();
        $lm['remark'] = '用户退货';
        $lm['moneyType'] = 2;
        $lm['money'] = $res['totalMoney'];
        $lm['payType'] = 0;
        $lm['createTime'] = date('Y-m-d H:i:s',time());
        db('log_moneys')->insert($lm);
        $this->success('操作成功');
	}



	public function changeGold()
	{
		
		$m = new M();
		$map['orderId'] = input('id');
		$order = $m->where($map)->find();

		$goods = db('goods')->where(array('goodsId'=>$order['goodsId']))->find();

		if(!$order) $this->error('订单不存在');
		if($order['iswin'] == 1) $this->error('订单不得兑换');
		if($order['is_tihuo'] == 1) $this->error('订单已提货');
		if($order['is_tuihuo'] == 1) $this->error('订单已退货');
		if($order['is_duihuan'] == 1) $this->error('订单已兑换');

		//订单没问题  兑换
		//更改订单状态
		$omap['orderId'] = $map['orderId'];
		$odata['is_duihuan'] = 1;
		$oids = db('orders')->where($omap)->update($odata);
		if(!$oids) $this->error('订单处理失败，请联系管理员');
		//客户加钱
		$jinbi = round($goods['shopPrice']*$order['orderNum'],2);
		$uids = db('users')->where('userId',$this->uid)->setInc('userScore',$jinbi);
		if(!$uids) $this->error('资金处理失败，请联系管理员');
		//资金日志
		$lm = [];
        $lm['targetType'] = 4;
        $lm['targetId'] = $this->users['userId'];
        $lm['dataId'] = $map['orderId'];
        $lm['dataSrc'] = getsrc();
        $lm['remark'] = '用户兑换金币';
        $lm['moneyType'] = 2;
        $lm['money'] = $jinbi;
        $lm['payType'] = 0;
        $lm['createTime'] = date('Y-m-d H:i:s',time());
        db('log_moneys')->insert($lm);
        $this->success('操作成功');

	}

	/**
	 * 提货
	 * @author lukui  2017-10-30
	 * @return [type] [description]
	 */
	public function tihuo()
	{
		$m = new M();
		$map['orderId'] = input('id');
		$hbmap['hbid'] = input('hbid');
		if($map['orderId']){
			$order = $m->where($map)->find();

			$goods = db('goods')->where(array('goodsId'=>$order['goodsId']))->find();

			if(!$order) $this->error('订单不存在');
			
			if($order['is_tihuo'] == 1) $this->error('订单已提货');
			if($order['is_tuihuo'] == 1) $this->error('订单已退货');
			if($order['is_duihuan'] == 1) $this->error('订单已兑换');

			$this->assign('goods',$goods);
			$this->assign('order',$order);

			//插入合并订单
			$hebing['uid'] = $this->uid;
			$hebing['orders'] = json_encode($map['orderId']);
			$hebing['createtime'] = date('Y-m-d H:i:s',time());
			$hebing['fee'] = $order['deliverMoney'];
			$hebing['zongjia'] = $order['goodsMoney'];
			$isset = db('order_hebing')->where('orders',$hebing['orders'])->find();
			if($isset){
				$hbid = $isset['hbid'];
			}else{
				$hbid = db('order_hebing')->insertGetId($hebing);
			}

			
			

		}elseif($hbmap['hbid']){
			$hbid = $hbmap['hbid'];
			$hborder = db('order_hebing')->where($hbmap)->find();
			if(!$hborder) $this->error('暂无订单信息');
			$arrorder = json_decode($hborder['orders'],1);
			foreach ($arrorder as $key => $v) {
				$order = $m->where('orderId',$v)->find();
				if($order['is_tihuo'] == 1) $this->error('订单已提货');
				if($order['is_tuihuo'] == 1) $this->error('订单已退货');
				if($order['is_duihuan'] == 1) $this->error('订单已兑换');

				$prders[] = db('orders')->alias('o')->field('o.orderNum,g.goodsName')
							->join('__GOODS__ g','o.goodsId=g.goodsId')
							->where('orderId',$v)->find();
			}
			$this->assign('prders',$prders);
			$this->assign('hborder',$hborder);

		}

		$this->assign('hbid',$hbid);
		

		$useraddress = db('useraddress')->where('uid',$this->uid)->find();
		$this->assign('uad',$useraddress);

		return $this->fetch('orders/tihuo');
	}

	/**
	 * 提货操作
	 * @author lukui  2017-10-30
	 * @return [type] [description]
	 */
	public function enterPickUP()
	{
		$m = new M();
		$map['hbid'] = input('hbid');
		$post = input('post.');
		if($map['hbid']){
			$hborder = db('order_hebing')->where($map)->find();
			$arrorder = json_decode($hborder['orders'],1);
			$_time = date('Y-m-d H:i:s',time());
			if(!is_array($arrorder)) {
				$_oid = $arrorder;
				$arrorder = array();
				$arrorder[0] = $_oid;
			}
			
			foreach ($arrorder as $key => $v) {
				$order = $m->where('orderId',$v)->find();
				if($order['is_tihuo'] == 1) $this->error('订单已提货');
				if($order['is_tuihuo'] == 1) $this->error('订单已退货');
				if($order['is_duihuan'] == 1) $this->error('订单已兑换');

				$hbdata = array();
				$hbdata['orderId'] = $v;
				$hbdata['hebingid'] = $hborder['hbid'];
				$hbdata['is_tihuo'] = 1;
				$hbdata['deliveryTime'] = date('Y-m-d H:i:s',time());
				$hbdata['userName'] = $post['userName'];
				$hbdata['userPhone'] = $post['userPhone'];
				$hbdata['userAddress'] = $post['userAddress'];
				$m->update($hbdata);

				
							
			}

			/*
			$order = $m->where($map)->find();

			$goods = db('goods')->where(array('goodsId'=>$order['goodsId']))->find();

			if(!$order) $this->error('订单不存在');
			
			if($order['is_tihuo'] == 1) $this->error('订单已提货');
			if($order['is_tuihuo'] == 1) $this->error('订单已退货');
			if($order['is_duihuan'] == 1) $this->error('订单已兑换');

			
			*/
		}

		if($this->users['userMoney'] < $hborder['fee']) $this->error('账户余额不足，请充值');
		

		//客户扣钱
		$uids = db('users')->where('userId',$this->uid)->setDec('userScore',$hborder['fee']);
		if(!$uids) $this->error('资金处理失败，请联系管理员');
		//资金日志
		$lm = [];
        $lm['targetType'] = 5;
        $lm['targetId'] = $this->users['userId'];
        $lm['dataId'] = $map['hbid'];
        $lm['dataSrc'] = getsrc();
        $lm['remark'] = '用户提货';
        $lm['moneyType'] = 1;
        $lm['money'] = $hborder['fee']*(-1);
        $lm['payType'] = 0;
        $lm['createTime'] = $_time;
        db('log_moneys')->insert($lm);

		
		

		//更新地址
		$address['uid'] = $this->uid;
		$address['username'] = $post['userName'];
		$address['phone'] = $post['userPhone'];
		$address['address'] = $post['userAddress'];
		$address['createtime'] = $_time;
		$isset = db('useraddress')->where('uid',$address['uid'])->find();
		if($isset){
			$addid = $isset['addid'];
			db('useraddress')->where('uid',$address['uid'])->update($address);
		}else{
			$addid = db('useraddress')->insert($address);
		}
		//合并订单
		$hborder['hbid'] = $post['hbid'];
		$hborder['ispay'] = 1;
		$hborder['addid'] = $addid;
		db('order_hebing')->update($hborder);



		$this->success('操作成功');
		

	}


	/**
	 * 合并订单
	 * @author lukui  2017-11-04
	 * @return [type] [description]
	 */
	public function hebingorder()
	{
		$m = new M();
		$post = input('post.');
		if(!$post){
			$this->error('非法操作');
		}

		$arrorder = explode(',', $post['orders']);
		$arrorder = array_filter($arrorder);

		$hborder['orders'] = json_encode($arrorder);
		$isset = db('order_hebing')->where('orders',$hborder['orders'])->find();
		if($isset){
			$hbids = $isset['hbid'];
		}else{
			$hborder['createtime'] = date('Y-m-d H:i:s',time());
			$hborder['uid'] = $this->uid;
			$hborder['fee'] = $post['fee'];
			$money = 0;
			foreach ($arrorder as $k => $v) {
				$money  += $m->where('orderId',$v)->value('goodsMoney');
			}
			$hborder['zongjia'] = $money;
			$hbids = db('order_hebing')->insertGetId($hborder);
		}
		
		if(!$hbids) {
			$this->error('合并订单出错！');

		}else{
			$this->success('合并订单成功','',$hbids);
		} 
		
	}


	
}
