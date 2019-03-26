<?php 

namespace application\admin\controller;
use application\admin\model\PlaySscData as M;

/**
* 	
*/
class Ssclist extends Base
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
     * 新增ssc数据
     * @author lukui  2017-11-23
     */
    public function add()
    {
    	$m = new M();
        $info =  $m->sscinfo();
        $this->assign('info',$info);
    	return $this->fetch("add");
    }

    public function adddata()
    {
    	
    	$m = new M();
        return $m->addData();
    }
}

 ?>