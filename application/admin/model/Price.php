<?php
namespace application\admin\model;
use think\Db;


/**
* 资金模型
*/
class Price extends Base
{
	
	
	public function pagequery($uids)
	{
		$where['uq'] = array('neq',104);

		//用户搜素
        $userinfo = input('userName');
        if($userinfo){
            $where['userId|userName|userPhone|loginName'] = array('like','%'.$userinfo.'%');
        }
		
		//时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');
        $between = array();

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$between = array('between time',array($stacerateTime,$endcerateTime));
		}
        if(empty($between)){
            $stacerateTime = date('Y-m-d', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
			$star = $stacerateTime.' 05:00:00';
			if(time() < strtotime($star)){

				$star = date('Y-m-d H:i:s',strtotime($star)-7*24*60*60);
			}
            $between = array('between time',array($star,date('Y-m-d H:i:s')));
        }
        
        $cash_map['createTime'] = $reck_map['createTime'] = $or_map['createTime'] = $hl_map['createTime'] = $sx_map['createTime'] = $between;
		
		if(!empty($uids)) $where['userId'] = array('in',$uids);

		$res = model('users')->where($where)
					->field(['userId','loginName','uq','userName','userMoney','userPhone','userEmail','userScore','createTime','userStatus','lastTime','usercode','percent','par101','par102','par103','oid','lastTime'])
					->order('userId desc')
					->paginate(input('pagesize/d'));


		$db_moeny = db('log_moneys');
		$db_orders = db('drorder');
		$db_recharge = db('recharge');
		$db_cash_draws = db('cash_draws');
		$db_users = db('users');
		$_uids = array();
		foreach ($res as $k => $v) {
			$_uids = array();
			$res[$k]['quname'] = getquname($v['uq']);
			$res[$k]['par101'] = GetTableValue('users',$v['par101'],'userName','userId');
    	 	$res[$k]['par102'] = GetTableValue('users',$v['par102'],'userName','userId');
    	 	$res[$k]['par103'] = GetTableValue('users',$v['par103'],'userName','userId');
    	 	$res[$k]['oid'] = GetTableValue('users',$v['oid'],'userName','userId');
            if($v['uq'] != 103){
                //总红利
                $hl_map['targetId'] = $v['userId'];
                $hl_map['targetType'] = 1;
                $res[$k]['hongli'] = $db_moeny->where($hl_map)->sum('money');
                //总手续费
                $sx_map['targetId'] = $v['userId'];
                $sx_map['targetType'] = 9;
                $res[$k]['shouxufee'] = $db_moeny->where($sx_map)->sum('money');
            }else{
                //总红利
                $res[$k]['hongli'] = 0;
                //总手续费
                $res[$k]['shouxufee'] = 0;
            }
    	 	

    	 	//该账号的所有下级客户
    	 	$_uids = myuids($v['userId'],$v['uq']);
            //dump($v['userId']);
            $_uidss = array();
            if(!empty($_uids)){

                $_usersinfo = $db_users->field('userId')->where(array('par101'=>array('in',$_uids)))->whereOr(array('par102'=>array('in',$_uids)))->whereOr(array('par103'=>array('in',$_uids)))->select();

                foreach ($_usersinfo as $key => $value) {
                    $_uidss[$key] = $value['userId'];
                }
                
            }
            $_uidss[] = $v['userId'];


    	 	//下级总订单
    	 	$or_map['userId'] = array('in',$_uidss);
    	 	$res[$k]['ordernum'] = $db_orders->where($or_map)->count();

			unset($or_map['iswin']);
    	 	//下级总盈亏
    	 	$res[$k]['sonfee'] = $db_orders->where($or_map)->sum('winmoney');

			$or_map['iswin'] = array('in',array(1,2));
			$res[$k]['shouxu'] = $db_orders->where($or_map)->sum('goods_par');

			$res[$k]['sonfee'] = $res[$k]['sonfee'] + $res[$k]['shouxu'];

    	 	//下级总入金
    	 	$reck_map['uid'] = array('in',$_uidss);
    	 	$reck_map['isverified'] = 1;
    	 	$res[$k]['sonrech'] = $db_recharge->where($reck_map)->sum('bpprice');

    	 	//下级总出金
    	 	$cash_map['targetId'] = array('in',$_uidss);
    	 	$cash_map['cashSatus'] = 1;
    	 	$res[$k]['soncash'] = $db_cash_draws->where($cash_map)->sum('money');

    	 	//自己总入金
    	 	$reck_map['uid'] = $v['userId'];
    	 	$reck_map['isverified'] = 1;
    	 	$res[$k]['selfrech'] = $db_recharge->where($reck_map)->sum('bpprice');

    	 	//自己总出金
    	 	$cash_map['targetId'] = $v['userId'];
    	 	$cash_map['cashSatus'] = 1;
    	 	$res[$k]['selfcash'] = $db_cash_draws->where($cash_map)->sum('money');

    	 	//客户总余额

    	 	$res[$k]['kehumoney'] = $db_users->where(array('userId'=>array('in',$_uidss),'dataFlag'=>1))->sum('userMoney');

    	 	//团队总余额
    	 	// $son_team = myuids($v['userId'],$v['uq'],array('in',array(101,102,103)));
    	 	// $res[$k]['teammoney'] = $db_users->where(array('userId'=>array('in',$son_team),'dataFlag'=>1))->sum('userMoney');
            
            
            if($v['uq'] == 103){
                //总流水
                $sx_map['targetId'] = $v['userId'];
                $sx_map['targetType'] = 10;
                $res[$k]['liushui'] = $db_moeny->where($sx_map)->sum('money');
            }else{
                $res[$k]['liushui'] = 0;
            }
            
    	 	
    	 	
    	 	
		}
		
		return $res;
	}

}

?>