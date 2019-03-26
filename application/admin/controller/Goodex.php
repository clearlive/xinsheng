<?php
namespace application\admin\controller;
/**
 

 
 * 商品控制器
 */
class Goodex extends Base{
    
    /**
    * 查看上架运费设置
    */
    public function index(){
        //$this->assign("areaList",model('areas')->listQuery(0));
        return $this->fetch('index');
    }
}
