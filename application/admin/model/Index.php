<?php 
namespace application\admin\model;
use think\Db;
/**
 
  
 
 

 

 
 * 系统业务处理
 */
class Index extends Base{
    /**
	 * 清除缓存
	 */
	public function clearCache(){
		$dirpath = WSTRootPath()."/runtime/cache";
		$isEmpty = WSTDelDir($dirpath);
		return $isEmpty;
	}
	/**
	 * 获取基础统计信息
	 */
	public function summary($uids){
		$data = [];
		//统计
		$map_ac = array();
		
		if(!empty($uids)) {
			$map_ut['userId'] = $map_ac['targetId'] = $map_rc['uid']  = $map_cs['targetId'] = array('in',$uids);
		}

		$map_ut['createTime'] = array('like',date('Y-m-d').'%');
		$map_ut['dataFlag'] = 1;
		$data['tody']['userType0'] = Db::name('users')->where($map_ut)->count();

		unset($map_ut['createTime']);
		$data['tody']['userType1'] = Db::name('users')->where($map_ut)->count();

		$map_cs['createTime'] = array('like',date('Y-m-d').'%');
		$data['tody']['cash'] = Db::name('cash_draws')->where($map_cs)->sum('money');

		$map_cs['cashSatus'] = 0;
		$data['tody']['shenhecash'] = Db::name('cash_draws')->where($map_cs)->sum('money');


		$data['tody']['allcash'] = Db::name('cash_draws')->where($map_ac)->sum('money');

		$map_rc['bptype'] = array('neq',3);
		$map_rc['createTime'] = array('like',date('Y-m-d').'%');
		$data['tody']['rech'] = Db::name('recharge')->where($map_rc)->sum('bpprice');
		unset($map_rc['createTime']);
		$data['tody']['allrech'] = Db::name('recharge')->where($map_rc)->sum('bpprice');

		
		$rs = Db::query('select VERSION() as sqlversion');
		$data['MySQL_Version'] = $rs[0]['sqlversion'];
		return $data;
	}
	
    /**
	 * 保存授权码
	 */
	public function saveLicense(){
		$data = [];
		$data['fieldValue'] = input('license');
	    $result = model('SysConfigs')->where('fieldCode','mallLicense')->update($data);
		if(false !== $result){
			cache('WST_CONF',null);
			return WSTReturn("操作成功",1);
		}
		return WSTReturn("操作失败");
	}
}