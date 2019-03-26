<?php 
namespace application\admin\controller;
use application\admin\model\Price as M;
/**
* 资金报表
*/
class Price extends Base
{
	
	public function index()
	{
		
		return $this->fetch('list');
	}


	public function pagequery()
	{

		$m = new M();
        return $m->pageQuery($this->uids);
        
	}
}

 ?>