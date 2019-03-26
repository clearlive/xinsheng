<?php
namespace application\home\controller;
use application\common\model\Drorder as M;
/**
 
  
 
 

 

 
 * 订单控制器
 */
class Drorder extends Base{


	public function add()
	{
		
		$m = new M();
		$rs = $m->add();
		
	}


}

 ?>