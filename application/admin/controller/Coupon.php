<?php 

namespace application\admin\controller;
use application\admin\model\Coupon as M;

/**
* 优惠券
*/
class Coupon extends Base
{
	
	public function index()
	{
		
		return $this->fetch();
	}


	public function pagequery()
	{
		
		$m = new M();
        return $m->pageQuery();
	}

	/**
	 * 新增 或者修改页面
	 * @author lukui  2017-11-19
	 * @return [type] [description]
	 */
	public function edit()
	{
		$m = new M();
        
        if(input('id')){
        	$object = $m->where('cid',input('id'))->find();
        }else{
        	$object = $m->getEModel('coupon');
        }
        


        $assign = ['data'=>$object];
        

        return $this->fetch("edit",$assign);
	}

	/**
	 * 新增 或者修改操作
	 * @author lukui  2017-11-19
	 */
	public function add()
	{
		
		$m = new M();
        
        
        return $m->add();
	}


	/**
	 * 发送记录列表页面
	 * @author lukui  2017-11-19
	 * @return [type] [description]
	 */
	public function sendlist()
	{
		
		return $this->fetch();
	}

	/**
	 * 发送记录
	 * @author lukui  2017-11-19
	 * @return [type] [description]
	 */
	public function sendpage()
	{
		
		$m = new M();
        return $m->sendpage();
	}
	public function sends()
	{
		return false;
		$users = db('users')->field('userId')->where('uq',104)->select();
		$coupon = db('coupon')->where('cStatic',1)->select();
		$data = array();
		$i = 0;
		foreach ($users as $k => $v) {
			foreach ($coupon as $key => $value) {
				
				$data['userId'] = $v['userId'];
				$data['cid'] = $value['cid'];
				$data['csStatic'] = 1;
				$data['sendTime'] = date('Y-m-d H:i:s');
				$data['endTime'] = date('Y-m-d H:i:s',time()+$value['cTime']*24*60*60);
				$i++;
				
				db('couponsend')->insert($data);
			}
		}
		//dump($data);
		exit;
	}


	/**
	 * 删除发送记录
	 * @author lukui  2017-11-19
	 * @return [type] [description]
	 */
	public function delcs()
	{
		
		$post = input('post.');
		if(!$post['csid']) return WSTReturn('参数错误');
		$ids = db('couponsend')->where($post)->delete();
		if($ids){
			return WSTReturn('删除成功',1);
		}else{
			return WSTReturn('删除失败',1);
		}
		
	}
	













}

 ?>