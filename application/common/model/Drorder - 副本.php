<?php
namespace application\common\model;
use think\Db;
/**
 
 
 

 
 * 订单业务处理类
 */
class Drorder extends Base{

	public function add($arr = array(),$iscode = 0)
	{
		if($arr){
			$post = $arr;
			$userId = $post['userId'];
		}else{
			$post = input('param.');
			$userId = (int)session('WST_USER.userId');
		}

		$isopen  = isopen();
		if($isopen != 1){
			echo '已休市';exit;
		}
		
		$db_goods = db('goods');
		
		$users = db('users')->where('userId',$userId)->find();
		$goods = $db_goods->where('goodsId',$post['goodsId'])->find();

		if($users['uq'] != 103 && $users['uq'] != 104){
			echo '您的身份不可下单';exit;
		}
		

		//判断用户状态
		if($users['userStatus'] != 1 && $iscode == 0){
			//return WSTReturn('用户被冻结');
			echo '用户被冻结';exit;
		}
		//判断库存
		if($goods['goodsStock'] < $post['ordernum']){
			//return WSTReturn('库存不足');
			echo '库存不足';exit;
		}

		//时时彩期数
		$ssc_sn = ssc_sn();

		//风控
		$s2_maxnum = WSTConf("CONF.s2_maxnum");
		$s4_maxnum = WSTConf("CONF.s4_maxnum");
		$s10_maxnum = WSTConf("CONF.s10_maxnum");

		$smap['userId'] = $userId;
		$smap['drtype'] = $post['drtype'];
		$smap['sscqishu'] = $ssc_sn;
		$num = $this->where($smap)->sum('orderNum');
		if($users['isCode'] == 0){

		
			if($post['drtype'] == 2 && $num+$post['ordernum'] > $s2_maxnum){
				echo '最大下单数量为'.$s2_maxnum.'，您已下'.$num.'单';exit;
			}elseif($post['drtype'] == 4 && $num+$post['ordernum'] > $s4_maxnum){
				echo '最大下单数量为'.$s4_maxnum.'，您已下'.$num.'单';exit;
			}elseif($post['drtype'] == 10 && $num+$post['ordernum'] > $s10_maxnum){
				echo '最大下单数量为'.$s10_maxnum.'，您已下'.$num.'单';exit;
			}

		}

		


		//拼接下单数组
		$orderNo = WSTOrderNo();
		$order['orderNo'] = $orderNo;
		$order['userId'] = $userId;
		$order['goodsId'] = $post['goodsId'];
		$order['orderNum'] = $post['ordernum'];
		$order['orderMoney'] = round($goods['play'.$post['drtype']]*$order['orderNum'],2);
		$order['sscqishu'] = $ssc_sn;
		$order['drtype'] = $post['drtype'];
		$order['sectionno'] = $post['sectionno'];
		$order['createTime'] = date('Y-m-d H:i:s');
		$order['isCode'] = $iscode;
		$order['isClear'] = isset($post['isClear'])?$post['isClear']:0;
		$order['goods_par'] = $goods['play'.$post['drtype'].'fee']*$order['orderNum'];

		//更新产品下单数量
		$g_data = $order['orderNum'];


		if($post['drtype'] == 2 || $post['drtype'] == 4){
			
			//判断余额
			if($users['userMoney'] < $order['orderMoney']  && $iscode == 0){
				//return WSTReturn('余额不足');
				echo '余额不足';exit;
			}

			//下单
			$orderId = $this->insertGetId($order);

			if(!$orderId) {
				echo '下单失败';exit;
			}


			//匹配对手
			//双人
			if($order['drtype'] == 2){
				$order2 = $order;
				$order2['userId'] = rand(1,1000);
				$order2['isCode'] = 1;
				$order2['orderNum'] = rand(1,20);
				$order2['orderMoney'] = round($goods['play'.$order['drtype']]*$order2['orderNum'],2);
				if($order['sectionno'] == 1) $arr2 = array(2,3,4);
				if($order['sectionno'] == 2) $arr2 = array(1,3,4);
				if($order['sectionno'] == 3) $arr2 = array(2,1,4);
				if($order['sectionno'] == 4) $arr2 = array(2,3,1);
				$order2['sectionno'] = $arr2[rand(0,2)];
				$this->insert($order2);
				
				$g_data += $order2['orderNum'];

			//四人	
			}elseif($order['drtype'] == 4){
				$order4 = $order;
				$order4['userId'] = rand(1,1000);
				$order4['isCode'] = 1;
				$order4['orderNum'] = rand(1,20);
				$order4['orderMoney'] = round($goods['play'.$order['drtype']]*$order4['orderNum'],2);
				if($order['sectionno'] == 5) $arr4 = array(6,7,8);
				if($order['sectionno'] == 6) $arr4 = array(5,7,8);
				if($order['sectionno'] == 7) $arr4 = array(5,6,8);
				if($order['sectionno'] == 8) $arr4 = array(5,6,7);
				$order4['sectionno'] = $arr4[rand(0,2)];
				$this->insert($order4);
				$g_data += $order4['orderNum'];
			}

			//更新产品下单数量
			$post['goodsId'];
			$db_goods->where('goodsId',$post['goodsId'])->setInc('saleNum',$g_data);

			if($iscode == 0){
				//下单成功扣费
				$editMoney = $order['orderMoney'];
				$setmoney = Db::name('users')->where('userId', $userId)->setDec('userMoney', $editMoney);

				if(!$setmoney){
					$this->where('orderId',$orderId)->delete();
					//return WSTReturn('订单扣费失败');
					echo '订单扣费失败';exit;
				}

				//users 表下注 增加
				Db::name('users')->where('userId', $userId)->setInc('allTouzhu', $editMoney);

				//扣费拼接日志数组
				$lm = [];
				$lm['targetType'] = 0;
				$lm['targetId'] = $userId;
				$lm['dataId'] = $orderId;
				$lm['dataSrc'] = getsrc();
				$lm['remark'] = '用户下单扣费';
				$lm['moneyType'] = 1;
				$lm['money'] = $editMoney*(-1);
				$lm['payType'] = 0;
				$lm['createTime'] = $order['createTime'];
				Db::name('log_moneys')->insert($lm);
			}
			
			
			echo 1;exit;



		}elseif($post['drtype'] == 10){
			
			$sectionno = array_filter(explode(',', $post['sectionno']));
			//总价
			$editMoney =  round($order['orderMoney']*count($sectionno),2);

			//判断余额
			if($users['userMoney'] < $editMoney && $iscode == 0){
				//return WSTReturn('余额不足');
				echo '余额不足';exit;
			}


			foreach ($sectionno as $k => $v) {
				$order['orderNo'] = WSTOrderNo();
				$order['sectionno'] = ($v-9);

				$this->insert($order);
				//匹配
				$order10 = $order;
				$order10['userId'] = rand(1,1000);
				$order10['isCode'] = 1;
				$order10['orderNum'] = rand(1,20);
				$order10['sectionno'] = get_duinum($order['sectionno']);
				$order10['orderMoney'] = round($goods['play'.$order['drtype']]*$order10['orderNum'],2);

				$orderId = $this->insertGetId($order10);
				if($iscode == 0){
					//扣费拼接日志数组
					$lm = [];
					$lm['targetType'] = 0;
					$lm['targetId'] = $userId;
					$lm['dataId'] = $orderId;
					$lm['dataSrc'] = getsrc();
					$lm['remark'] = '用户下单扣费';
					$lm['moneyType'] = 1;
					$lm['money'] = $order['orderMoney']*(-1);
					$lm['payType'] = 0;
					$lm['createTime'] = $order['createTime'];
					Db::name('log_moneys')->insert($lm);
				}
			}
			if($iscode == 0){
				//下单成功扣费
				$setmoney = Db::name('users')->where('userId', $userId)->setDec('userMoney', $editMoney);

				if(!$setmoney){
					echo '订单扣费失败';exit;
				}
			}

			echo 1;exit;
		}

		
		

		
	}


}


?>