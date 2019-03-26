<?php 

namespace application\admin\controller;
use application\admin\model\Recharge as M;
/**
* 
*/
class Recharge extends Base
{
	
	public function index(){

    	return $this->fetch("list");
    }


    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        return $m->pageQuery($this->uids);
    }


    /**
     * @return mixed
     * 统计
     */
    public function tongji()
    {

        $m = new M();
        return $m->tongji($this->uids);
    }
}

 ?>