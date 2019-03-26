<?php
namespace application\home\controller;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 错误处理控制器
 */
class Error extends Base{
    public function index(){
        echo "error/index";
        exit;
    	header("HTTP/1.0 404 Not Found");
        return $this->fetch('error_sys');
    }
}
