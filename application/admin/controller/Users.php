<?php
namespace application\admin\controller;
use application\admin\model\Users as M;
use application\admin\model\UserRanks;
/**
 
  
 
 

 

 
 * 会员控制器
 */
class Users extends Base{
	
    public function index(){
        //$userQuery = db('UserRanks')->where('dataFlag',1)->field(true)->order('rankId desc')->select();
        $m = new UserRanks;
        $userQuery = $m->pageQuery();
        
        $this->assign('userQuery',$userQuery);
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
     * 跳去编辑页面
     */
    public function toEdit(){
        $m = new M();
        $data = $this->get();
        $uq = input('uq',104);
        
        $assign = ['data'=>$data];
        $this->assign('uq',$uq);

        //会员类型
        $m = new UserRanks;
        $userQuery = $m->pageQuery();
        //dump($userQuery);
        $this->assign('userQuery',$userQuery);

        $Id = (int)input('id');
        $myups = myups($Id,1);
        $this->assign('myups',$myups);

        //顶级代理商 ID是4
        $userlist = db('users')->where(array('uq'=>USERTYPE1,'dataFlag'=>'1'))->field('userName,loginName,userId')->select();
        $this->assign('userlist',$userlist);
        
        return $this->fetch("edit",$assign);
    }
    /*
    * 获取数据
    */
    public function get(){
        $m = new M();
        return $m->getById((int)Input("id"));
    }
    /**
     * 新增
     */
    public function add(){
        $m = new M();
        return $m->add();
    }
    /**
    * 修改
    */
    public function edit(){
        $m = new M();
        return $m->edit();
    }
    /**
     * 删除
     */
    public function del(){
        $m = new M();
        return $m->del();
    }
    /**********************************************************************************************
      *                                             账号管理                                                                                                                              *
      **********************************************************************************************/
    /**
    * 账号管理页面
    */
    public function accountIndex(){
        return $this->fetch("account_list");
    }
    /**
     * 判断账号是否存在
     */
    public function checkLoginKey(){
    	$rs = WSTCheckLoginKey(Input('post.loginName'),Input('post.userId/d',0));
    	if($rs['status']==1){
    		return ['ok'=>$rs['msg']];
    	}else{
    		return ['error'=>$rs['msg']];
    	}
    }
    /**
    * 是否启用
    */
    public function changeUserStatus($id, $status){
        $m = new M();
        return $m->changeUserStatus($id, $status);
    }
    public function editAccount(){
        $m = new M();
        return $m->edit();
    }
    /**
    * 获取所有用户id
    */
    public function getAllUserId()
    {
        $m = new M();
        return $m->getAllUserId();
    }


    public function selectuser()
    {
        
        $map = input('post.');
        $map['dataFlag'] = 1;
        $userlist = db('users')->where($map)->field('userName,loginName,userId')->select();
        echo json_encode($userlist);

    }


    public function userinfo()
    {
        
        $m = new M();
        $info =  $m->userinfo();
        $this->assign('info',$info);
        return $this->fetch("userinfo");
    }


    /**
     * 用户菜单列表统计
     * @author lukui  2017-11-21
     * @return [type] [description]
     */
    public function tongji()
    {
        $m = new M();
        $info =  $m->tongji();
        $this->assign('info',$info);
        return $this->fetch("tongji");
    }

    //用户上分
    public function addmoney()
    {
        if(input('post.')){
            $m = new M();
            return $m->addmoney();
        }
        return $this->fetch("addmoney");
    }
}
