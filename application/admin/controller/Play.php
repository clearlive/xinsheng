<?php
namespace application\admin\controller;
use application\admin\model\Play as M;

/**
 *  
 *  游戏控制器
 */

class Play extends Base{


	public function playlist()
	{
		if(input('post.')){
			$m = new M();
			$res = $m->getlist();
			return $res;
		}else{
			return $this->fetch("list");
		}
		
	}


	/**
	 * 新增
	 * @author lukui  2017-10-08
	 */
	public function add()
	{
		if(input('post.')){
			$m = new M();
			$res = $m->add();
			if($res){
				return WSTReturn('操作成功！',1);
			}else{
				return WSTReturn('操作失败，请重试！');
			}
		}else{
			return $this->fetch();
		}
		
		
	}

	/**
	 * 修改
	 * @author lukui  2017-10-08
	 * @return [type] [description]
	 */
	public function toEdit()
	{
		$playId = input('get.id');
		
		$data = db('play')->where('playId',$playId)->find();
		
		$this->assign('data',$data);
		return $this->fetch('add');
	}

	/**
	 * 删除
	 * @author lukui  2017-10-08
	 * @return [type] [description]
	 */
	public function del()
	{
		
		$playId = input('post.id');

		$map['isdelete'] = 1;
		$map['playId'] = $playId;
		$ids = db('play')->update($map);
		
		if($ids){
			return WSTReturn('操作成功！',1);
		}else{
			return WSTReturn('操作失败，请重试！',-1);
		}
	}


	public function conf()
	{
		

		$id = input('get.id');

		$play = db('play')->where('playId',$id)->find();
		if(!$play) $this->error('参数错误！');

		$playconf = db('play_'.$play['playCode'])->find();
		$this->assign($play);
		$this->assign('data',$playconf);
		return $this->fetch($play['playCode']);
	}


	/**
	 * 红包配置
	 * @author lukui  2017-10-09
	 * @return [type] [description]
	 */
	public function playconf()
	{
		
		$post = input('post.');

		$playCode = $post['playCode'];
		unset($post['playCode']);
		
		$ids = db('play_'.$playCode)->update($post);
		if($ids){
			return WSTReturn('操作成功！',1);
		}else{
			return WSTReturn('操作失败，请重试！',-1);
		}
	}
















}









?>