<?php
namespace application\admin\model;
use think\Db;


/**
* 游戏模型
*/
class Play extends Base
{
	
	
	/**
	 * 新增
	 * @author lukui  2017-10-08
	 */
	public function add()
	{
		
		$post = input('post.');
		if(!$post) return ;

		
		if($post["playId"] == 0 ) {
			unset($post["playId"]);
			$res = $this->insert($post);

		}else{
			$res = $this->update($post);
		}
		return $res;
		
	}

	/**
	 * 获取列表
	 * @author lukui  2017-10-08
	 * @return [type] [description]
	 */
	public function getlist()
	{
		
		$map['isdelete'] = 0;
		$res = $this->where($map)->paginate();
		return $res;
	}


}

?>