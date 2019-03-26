<?php
namespace application\common\model;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 快递业务处理类
 */
use think\Db;
class Express extends Base{
    /**
	 * 获取快递列表
	 */
    public function listQuery(){
         return $this->where('dataFlag',1)->select();
    }
}
