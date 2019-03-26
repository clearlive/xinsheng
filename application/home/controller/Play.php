<?php
namespace application\home\controller;

/**
* 玩具控制器
*/
class Play extends Base
{
	
	/**
	 * 红包游戏显示控制器
	 * @author lukui  2017-10-09
	 * @return [type] [description]
	 */
	public function goplay()
	{
		$get = $_GET;
		if(!$get){
			$this->error('参数错误1');
		}
		//判断订单是否存在
		$orders = db('orders')->where('orderId',$get['orderId'])->find();
		if(!$orders){
			$this->error('参数错误2');
		}
		//订单是否参加活动
		if($orders['playtype'] || $orders['playid']){
			$this->error('此订单已失效');
		}
		$play = db('play')->where('playCode',$get['code'])->find();
		if(!$play){
			$this->error('参数错误3');
		}

		$goods = db('goods')->where('goodsId',$orders['goodsId'])->find();
		

		switch ($get['code']) {
			case 'hongbao':
				return $this->hongbao($get,$orders,$play,$goods);
				break;
			case 'jiou':
				return $this->jiou($get,$orders,$play,$goods);
				break;
			default:
				# code...
				break;
		}
		
	}


	//***************************************红包游戏-开始******************************************

	public function hongbao($get,$orders,$play,$goods)
	{

		$this->assign('orders',$orders);
		$this->assign('goods',$goods);
		return $this->fetch('play/hongbao');
	}

	public function hongbaoadd()
	{
		
		$post = input('post.');

		$orders = db('orders')->where('orderId',$post['orderId'])->find();
		$goods = db('goods')->where('goodsId',$orders['goodsId'])->find();
		if(!$orders){
			return WSTReturn('订单不存在',-1);
		}

		$hongbao = db('play_hongbao')->find();

		
		$rand = rand(1,100)/100;

		//赢利
		if($hongbao['winpoint'] > $rand){
			$orderdata['iswin'] = $hbdata['iswin'] = 1;
			$orderdata['winmoney'] = $hbdata['winmoney'] = round(($goods['sjshopPrice']-$goods['shopPrice'])*$orders['orderNum'],2);

			//给用户加钱
			$addmoney = $orders['goodsMoney']+$orderdata['winmoney'];
			$ids = db('users')->where('userId',$orders['userId'])->setInc('userMoney',$addmoney);
			if(!$ids) return WSTReturn('系统错误，请稍后！',-1);
			//扣费拼接日志数组
			$lm = [];
			$lm['targetType'] = 7;
			$lm['targetId'] = $orders['userId'];
			$lm['dataId'] = $orders['orderId'];
			$lm['dataSrc'] = getsrc();
			$lm['remark'] = '红包游戏赢利结算';
			$lm['moneyType'] = 2;
			$lm['money'] = $addmoney;
			$lm['payType'] = 0;
			$lm['createTime'] = date('Y-m-d H:i:s',time());
			db('log_moneys')->insert($lm);

			
			$res['iswin'] = 1; 
		//亏损
		}else{
			$orderdata['iswin'] = $hbdata['iswin'] = 0;
			$orderdata['winmoney'] = $hbdata['winmoney'] = round(($goods['shopPrice'])*$orders['orderNum'],2)*-1;;
			
			$res['iswin'] = 0;
		}
		$hbdata['createtime'] = time();
		$hbdata['orderId'] = $orders['orderId'];
		$hbdata['userId'] = $orders['userId'];

		$playid = db('play_hongbao_order')->insertGetId($hbdata);

		$orderdata['playtype'] = $hongbao['playId'];
		$orderdata['playid'] = $playid;
		$orderdata['orderId'] = $post['orderId'];
		$orderdata['is_over'] = 1;
		db('orders')->update($orderdata);
		
		$res['goods'] = $goods;
		return WSTReturn($res,1);

		
	}


	//***************************************红包游戏-结束******************************************


	//***************************************猜奇偶游戏-开始******************************************

	/**
	 * 时时彩列表
	 * @author lukui  2017-10-13
	 * @return [type] [description]
	 */
	public function ssclist()
	{
		
		$list = db('play_ssc_data')->order('issue desc')->limit('0,100')->select();
		$this->assign('ssclist',$list);
		return $this->fetch('play/ssclist');
	}

	public function jiou($get,$orders,$play,$goods)
	{
		$ssclist = db('play_ssc_data')->order('issue desc')->limit('0,10')->select();

		$this->assign('ssclist',$ssclist);
		$this->assign('orders',$orders);
		$this->assign('goods',$goods);
		return $this->fetch('play/jiou');
	}

	public function addjiou()
	{
		
		$post = input('post.');
		if(!$post){
			return WSTReturn(参数错误,-1);
		}

		$orders = db('orders')->where('orderId',$post['orderId'])->find();
		if(!$orders){
			return WSTReturn('订单不存在',-1);
		}

		if($orders['playtype'] || $orders['playid'] ){
			return WSTReturn('订单已操作',-1);
		}

		$jiou_data['otype'] = $post['direction'];
		$jiou_data['orderId'] = $post['orderId'];
		$jiou_data['createtime'] = time();
		$jiou_data['issue'] = ssc_sn();

		$ids = db('play_jiou_order')->insertGetId($jiou_data);

		$order_data['playtype'] = 1;
		$order_data['playid'] = $ids;
		$order_data['orderId'] = $post['orderId'];

		$_ids = db('orders')->update($order_data);
		if($_ids){
			return WSTReturn('下单成功,你的期数是'.$jiou_data['issue'],1);
		}else{
			return WSTReturn('系统错误，请稍后！',-1);
		}
	}



}