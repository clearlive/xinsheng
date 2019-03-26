<?php
namespace application\admin\model;
use think\Db;
/**
 
  
 
 

 

 
 * 登录日志业务处理
 */
class LogUserLogins extends Base{
    /**
	 * 分页
	 */
	public function pageQuery($uids){
		
		$startDate = input('get.startDate');
		$endDate = input('get.endDate');
		$userId = input('get.userId');

		$where = [];
		if(!empty($uids)) $where['l.userId'] = array('in',$uids);
		if($userId) $where['l.userId'] = $userId;

		if($startDate!='')$where['l.loginTime'] = ['>=',$startDate];
		if($endDate!='')$where[' l.loginTime'] = ['<=',$endDate];


		return $mrs = Db::name('LogUserLogins')->alias('l')->join('__USERS__ u',' l.userId=u.userId','left')
			->where($where)
			->field('l.*,u.userName')
			->order('l.loginId', 'desc')->paginate(input('pagesize/d'));
			
	}
}
