<?php
namespace application\admin\model;
use think\Db;
/**
 
  
 
 

 

 
 * 提现分类业务处理
 */
class Coupon extends Base{
	/**
	 * 分页
	 */
	public function pageQuery(){

        $where = array();
        return $this->where($where)->order('cid desc')->paginate(input('pagesize/d'))->toArray();

	}


	public function add()
	{
		$data = input('post.');
		foreach ($data as $k => $v) {
			if($k != 'cid' && $k != 'cStatic' && !$v){
				return WSTReturn('请正确填写');
			}
		}
		
		if($data['cid']){
			$ids = $this->update($data);
		}else{
			$data['createTime'] = date('Y-m-d H:i:s');
			$ids = $this->insert($data);
		}

		if($ids){
			return WSTReturn('操作成功',1);
		}else{
			return WSTReturn('操作失败',1);
		}
		
	}


	public function getById($id){

		return $this->get(['cid'=>$id]);
	}

	public function sendpage()
	{
		
		$where = array();

		$list = db('couponsend')->alias('cs')->field('cs.*,u.userName,c.cStatic,c.cTime,c.cMoney,cName')
				->join('__USERS__ u','u.userId=cs.userId')
				->join('__COUPON__ c','c.cid=cs.cid')
		        ->where($where)
		        ->order('csid desc')->paginate(input('pagesize/d'))->toArray();

        return $list;


	}






}



?>