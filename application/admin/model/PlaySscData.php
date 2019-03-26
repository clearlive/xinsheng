<?php
namespace application\admin\model;
use think\Db;



/**
* 时时彩数据模型
*/
class PlaySscData extends Base
{
	

	/**
	 * 分页数据
	 * @author lukui  2017-11-23
	 * @return [type] [description]
	 */
	public function pageQuery(){

		$where = array();

		$list = $this->where($where)->order('issue desc')->paginate(input('pagesize/d'))->toArray();
		foreach ($list["Rows"] as $k => $v) {
        	
        	@$list["Rows"][$k]['date'] = date('Y-m-d H:i:s',$v['date']);
        	@$list["Rows"][$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime']);
        }
		return $list;
	}


	public function sscinfo()
	{
		
		$id = input('id');
		if(!$id) return false;

		$info = $this->where('id',$id)->find();
		return $info;

	}

	/**
	 * 新增时时彩数据
	 * @author lukui  2017-11-23
	 */
	public function addData()
	{
		
		$data = $_GET;

		

		foreach ($data as $k => $v) {
			if(!$v || $v == ''){
				return WSTReturn('请正确填写');
			}
		}

		$issue_len = strlen($data['issue']);
		if($issue_len != 9) return WSTReturn('请正确填写时时彩期数');

		$balls_len = strlen($data['balls']);
		if($balls_len != 5) return WSTReturn('请正确填写开奖号');

		$data['date'] = strtotime($data['date']);
		$data['createtime'] = strtotime($data['createtime']);

		$data['lotName'] = '越南快5';

		if(isset($data['id'])){
			$ids = $this->update($data);
		}else{
			$isset = $this->where('issue',$data['issue'])->find();
			if($isset) return WSTReturn($data['issue'].'期已存在');

			$ids = $this->insert($data);
		}

		if ($ids) {
			return WSTReturn('操作成功',1);
		}else{
			return WSTReturn('操作失败');
		}
	}


}