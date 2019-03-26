<?php
namespace application\admin\model;
use think\Db;


class OrderHebing extends Base{

	/**
	 * 获取合并订单列表
	 */
	public function pageQuery(){
		$map = array();

		//时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$map['oh.createtime'] = array('between time',array($stacerateTime,$endcerateTime));
		}


		//用户搜素
		$userinfo = input('userinfo');
		if($userinfo){
			$map['us.userId|us.userName|us.userPhone|us.loginName'] = array('like','%'.$userinfo.'%');
		}

		//dump($map);
		$page = $this->alias('oh')->field('oh.*,us.userName,usa.*,usa.uid as userId,oh.createtime as ohcreatetime')
				->join('__USERS__ us','oh.uid=us.userId','left')
				->join('__USERADDRESS__ usa','oh.uid=usa.uid','left')
				->where($map)
				->order('oh.hbid', 'desc')
				->paginate(input('pagesize/d'))->toArray();
		
		
		return $page;
	}


	/**
	 * 获取合并订单详情
	 */
	public function getByView($orderId){
		
		$info = $this->where('hbid',$orderId)->find();
		if(!$info) return WSTReturn("无效的订单信息");

		$orderarr = json_decode($info['orders']);
        if(!is_array($orderarr)) {
            $_oid = $orderarr;
            $orderarr = array();
            $orderarr[0] = $_oid;
        }
        $orderlist = array();
        $db_orders =  db('orders');

        foreach ($orderarr as $key => $value) {
            $orderlist[$key] = $db_orders->alias('o')->field('o.*,g.goodsName,g.goodsImg,g.shopPrice')
                        ->join('__GOODS__ g','o.goodsId=g.goodsId')
                        ->where('orderId',$value)->find();
        }
        
        $data['info'] = $info;
        $data['orderlist'] = $orderlist;
        $data['address'] = db('useraddress')->where('uid',$info['uid'])->find();
        
        
		return $data;
	}

}