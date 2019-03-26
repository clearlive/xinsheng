<?php
namespace application\common\model;
use think\Db;

class Play extends Base{



	/**
	 * 获取列表
	 * @author lukui  2017-10-08
	 * @return [type] [description]
	 */
	public function getlist()
	{
		
		$map['isdelete'] = 0;
		$map['playStatus'] = 1;
		$res = $this->where($map)->paginate();
		return $res;
	}


}


?>