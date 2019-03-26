<?php
namespace application\admin\model;
use think\Db;
/**
 
  
 
 

 

 
 * 会员业务处理
 */
class Users extends Base{
	/**
	 * 分页
	 */
	public function pageQuery($uids){

		/******************** 查询 ************************/
		$where = [];
		$where['dataFlag'] = 1;
		$lName = input('get.loginName1');
		$phone = input('get.loginPhone');
		$email = input('get.loginEmail');
		$uType = input('get.userType');
		$uq = input('get.uq');
		$order = input('order');
		$parid = input('parid');
		
		//$where['isCode'] = 0; 

		$uStatus = input('get.userStatus1');
		if(!empty($lName))
			$where['loginName|userName'] = ['like',"%$lName%"];
		if(!empty($phone))
			$where['userPhone'] = ['like',"%$phone%"];
		if(!empty($email))
			$where['userEmail'] = ['like',"%$email%"];
		if(is_numeric($uType))
			$where['userType'] = ['=',"$uType"];
		if(is_numeric($uStatus))
			$where['userStatus'] = ['=',"$uStatus"];
		if(is_numeric($uq) && $uq != 0)
			$where['uq'] = ['=',"$uq"];

		if(!empty($uids)) $where['userId'] = array('in',$uids);

		/********************* 排序 ***************************/

		switch ($order) {
			case '0':	//默认排序
				$order = 'userId desc';
				break;
			case '1':	//账号金额
				$order = 'userMoney desc';
				break;
			case '2':	//投注金额
				$order = 'allTouzhu desc';
				break;
			case '3':	//中奖金额
				$order = 'allWin desc';
				break;
			case '4':	//返点
				$order = 'allRes desc';
				break;
			case '5':	//在线会员
				$order = 'lastTime desc';
				break;
			
			default:
				$order = 'userId desc';
				break;
		}

		/********************* 下级 ***************************/

		if($parid){
			$uq = $this->where('userId',$parid)->value('uq');
			if($uq != 104){
				$uids = myuids($parid,$uq);
				foreach ($uids as $key => $value) {
					if($value == $parid) unset($uids[$key]);
				}
				$where['userId'] = array('in',$uids);
			}
			
		}

		
		/********************* 取数据 *************************/
		$rs = $this->where($where)
					->field(['userPhoto','userId','loginName','uq','userName','userMoney','userPhone','userEmail','userScore','createTime','userStatus','lastTime','usercode','percent','par101','par102','par103','oid','lastTime','allWin','allRes','allTouzhu','allPloss','minMoney'])
					->order($order)
					->paginate(input('pagesize/d'));

		foreach ($rs as $k => $v) {
			
			$rs[$k]['quname'] = getquname($v['uq']);
			$rs[$k]['par101'] = GetTableValue('users',$v['par101'],'userName','userId');
			$rs[$k]['par102'] = GetTableValue('users',$v['par102'],'userName','userId');
			$rs[$k]['par103'] = GetTableValue('users',$v['par103'],'userName','userId');
			$rs[$k]['oid'] = GetTableValue('users',$v['oid'],'userName','userId');
			//$rs[$k]['par101'] = '';//GetTableValue('users',$v['par101'],'userName','userId');
    	 	//$rs[$k]['par102'] = '';//GetTableValue('users',$v['par102'],'userName','userId');
    	 	//$rs[$k]['par103'] = '';//GetTableValue('users',$v['par103'],'userName','userId');
    	 	//$rs[$k]['oid'] = '';//GetTableValue('users',$v['oid'],'userName','userId');
		}
		return $rs;
	}
	public function getById($id){
		return $this->get(['userId'=>$id]);
	}
	/**
	 * 新增
	 */
	public function add(){
		$data = input('post.');

		$data['createTime'] = date('Y-m-d H:i:s');
		$data["loginSecret"] = rand(1000,9999);
    	$data['loginPwd'] = md5($data['loginPwd'].$data['loginSecret']);
    	$data['usercode'] = getRandomString(4);

    	$session = session("WST_STAFF");
    	

    	if($session['uq'] == 0){
    		//验证红利
    		if(!isset($data['percent'])) $data['percent'] = 0;
			$checkres = checkhongli($data['userId'],$data['percent'],$data['uq'],$data);
			if(isset($checkres['status']) && $checkres['status'] == -1) return $checkres;

	    	WSTUnset($data,'userId');

	    	//判断身份
	    	if(in_array($data['uq'],array(USERTYPE2,USERTYPE3,USERTYPE4)) && (!isset($data['par101']) || empty($data['par101'])) ){
	    		return WSTReturn('请选择'.USERTYPE1NAME,-1);
	    	}
	    	if(in_array($data['uq'],array(USERTYPE3,USERTYPE4)) && (!isset($data['par102']) || empty($data['par102'])) ){
	    		return WSTReturn('请选择'.USERTYPE2NAME,-1);
	    	}
	    	if(in_array($data['uq'],array(USERTYPE4)) && (!isset($data['par103']) || empty($data['par103'])) ){
	    		return WSTReturn('请选择'.USERTYPE3NAME,-1);
	    	}

	    	if(isset($data['par103']) && !empty($data['par103'])){
	    		$data['oid'] = $data['par103'];
	    	}elseif(isset($data['par102']) && !empty($data['par102'])){
	    		$data['oid'] = $data['par102'];
	    	}elseif(isset($data['101']) && !empty($data['101'])){
	    		$data['oid'] = $data['101'];
	    	}else{
	    		$data['oid'] = 0;
	    	}
	    	
	    	
    	}else{
    		
    		$thisuser = db('users')->where('userId',$session['userId'])->find();
    		//$data['par101'] = $data['par102'] = $data['par103'] = 0;
    		if($session['uq'] == 101){
    			$data['par101'] = $session['userId'];
    		}
    		if($session['uq'] == 102){
    			$data['par101'] = $thisuser['par101'];
    			$data['par102'] = $session['userId'];
    		}
    		if($session['uq'] == 103){
    			$data['par101'] = $thisuser['par101'];
    			$data['par102'] = $session['par102'];
    			$data['par103'] = $session['userId'];
    		}

    		if(isset($data['par103']) && $data['par103']>0){
    			$data['oid'] = $data['par103'];
    		}elseif(isset($data['par102']) && $data['par102']>0){
    			$data['oid'] = $data['par102'];
    		}elseif(isset($data['par101']) && $data['par101']>0){
    			$data['oid'] = $data['par101'];
    		}
    		
    		
    		//验证红利
    		if(!isset($data['percent'])) $data['percent'] = 0;
			$checkres = checkhongli($session['userId'],$data['percent'],$data['uq'],$data,$thisuser);
			if(isset($checkres['status']) && $checkres['status'] == -1) return $checkres;

			$data['oid'] = $session['userId'];
			
    	}

    	//验证手续费
    	if(!isset($data['fee_percent'])) $data['fee_percent'] = 0;
    	if($data['uq'] == 101 && ($data['fee_percent'] > 100 || $data['fee_percent'] < 0 || !is_numeric($data['fee_percent'] )) ) return WSTReturn('手续费在0-100之间');
    	if($data['uq'] == 102){
    		//所属运营中心
    		$yy_fee = $this->where('userId',$data['par101'])->value('fee_percent');
    		if($yy_fee < $data['fee_percent']){
    			return WSTReturn('手续费小于'.$yy_fee.'%');
    		}

    	}
    	
    	
    	
    	//分配比例
    	
    	Db::startTrans();
		try{
			$result = $this->validate('Users.add')->allowField(true)->save($data);
			$id = $this->userId;
	        if(false !== $result){
	        	WSTUseImages(1, $id, $data['userPhoto']);
	        	Db::commit();
	        	return WSTReturn("新增成功", 1);
	        }
		}catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('新增失败',-1);
        }	
	}
    /**
	 * 编辑
	 */
	public function edit(){
		$Id = (int)input('post.userId');
		
		$data = input('post.');

		
		
		$u = $this->where('userId',$Id)->field('loginSecret')->find();
		if(!isset($data['percent'])) $data['percent'] = 0;
		if(getFloatLength($data['percent']) > 2 || !is_numeric($data['percent'])) return WSTReturn('红利请输入2位小数只内的数字');

		//自己
		$myself = $this->where('userId',$Id)->find();
		//父级
		$fatheruq = $this->where('userId',$myself['oid'])->find();

		//验证红利
		$checkres = checkhongli($data['userId'],$data['percent'],'',array(),$fatheruq);
		
		if(isset($checkres['status']) && $checkres['status'] == -1) return $checkres;


		//验证手续费
    	if(!isset($data['fee_percent'])) $data['fee_percent'] = 0;
    	if(getFloatLength($data['fee_percent']) > 2 || !is_numeric($data['fee_percent'])) return WSTReturn('手续费请输入2位小数只内的数字');
		
    	if($myself['uq'] == 101 && ($data['fee_percent'] > 100 || $data['fee_percent'] < 0 || !is_numeric($data['fee_percent'] )) ) return WSTReturn('手续费在0-100之间');
    	if($myself['uq'] == 102){
    		//所属运营中心
    		$yy_fee = $this->where('userId',$myself['par101'])->value('fee_percent');
    		if($yy_fee < $data['fee_percent']){
    			return WSTReturn('手续费小于'.$yy_fee.'%');
    		}

    	}

    	

		if(empty($u))return WSTReturn('无效的用户');
		//判断是否需要修改密码
		if(empty($data['loginPwd'])){
			unset($data['loginPwd']);
		}else{
    		$data['loginPwd'] = md5($data['loginPwd'].$u['loginSecret']);
		}
		
		
		if($data['userPhoto'] == '') unset($data['userPhoto']);
		
		Db::startTrans();

		try{
			if(isset($data['userPhoto'])){
			    WSTUseImages(1, $Id, $data['userPhoto'], 'users', 'userPhoto');
			}
			
			WSTUnset($data,'createTime,userId');

		    $result = $this->update($data,['userId'=>$Id]);
		    
	        if(false !== $result){
	        	Db::commit();
	        	return WSTReturn("编辑成功", 1);
	        }
		}catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('编辑失败',-1);
        }
	}
	/**
	 * 删除
	 */
    public function del(){
	    $id = (int)input('post.id');
	    Db::startTrans();
	    try{
		    $data = [];
			$data['dataFlag'] = -1;
			/*
		    $result = $this->update($data,['userId'=>$id]);
	        if(false !== $result){
	        	WSTUnuseImage('users','userPhoto',$id);
	        	Db::commit();
	        	return WSTReturn("删除成功", 1);
	        }
	        */

	        $result = $this->where('userId',$id)->delete();//($data,['userId'=>$id]);
	        if(false !== $result){
	        	Db::commit();
	        	return WSTReturn("删除成功!", 1);
	        }

	    }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('编辑失败',-1);
        }
	}
	/**
	* 是否启用
	*/
	public function changeUserStatus($id, $status){
		$result = $this->update(['userStatus'=>(int)$status],['userId'=>(int)$id]);
		if(false !== $result){
        	return WSTReturn("删除成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	/**
	* 根据用户名查找用户
	*/
	public function getByName($name){
		return $this->field(['userId','loginName'])->where(['loginName'=>['like',"%$name%"]])->select();
	}
	/**
	* 获取所有用户id
	*/
	public function getAllUserId()
	{
		return $this->where('dataFlag',1)->column('userId');
	}

	/**
	* 用户详细信息
	*/
	public function userinfo()
	{
		$userId = input('userId');
		if(!$userId) exit;
		$resdata['user'] = $this->where('userId',$userId)->find();
		
		$field = ['userId','loginName','uq','userName','userMoney','userPhone','userEmail','userScore','createTime','userStatus','lastTime','usercode','percent','par101','par102','par103','oid','lastTime'];

		if($resdata['user']['uq'] == 101){
			$resdata['my102'] = $this->where(array('par101'=>$userId,'uq'=>102))->field($field)->select();
			$resdata['my103'] = $this->where(array('par101'=>$userId,'uq'=>103))->field($field)->select();
			$resdata['my104'] = $this->where(array('par101'=>$userId,'uq'=>104))->field($field)->select();
			$resdata['myson'] = array_merge(array_merge($resdata['my102'],$resdata['my103']),$resdata['my104']);
		}

		if($resdata['user']['uq'] == 102){
			$resdata['my103'] = $this->where(array('par102'=>$userId,'uq'=>103))->field($field)->select();
			$resdata['my104'] = $this->where(array('par102'=>$userId,'uq'=>104))->field($field)->select();
			$resdata['myson'] = array_merge($resdata['my104'],$resdata['my103']);
		}

		if($resdata['user']['uq'] == 103){
			$resdata['myson'] = $resdata['my104'] = $this->where(array('par103'=>$userId,'uq'=>104))->field($field)->select();
		}


		return $resdata;
		

	}




	public function tongji()
	{
		
		$uid = input('uid');
		
		$user = $this->where('userId',$uid)->find();

		if(!$user) $this->error('参数错误');

		$user['rech'] = userrech($uid);
		$user['cash'] = usercash($uid);
		
		return $user;
	}


	public function addmoney()
	{
		
		$post = input('post.');
		
		$map['userName|userPhone|loginName'] = $post['loginName'];
		$map['dataFlag'] = 1;
		$user = $this->where($map)->find();
		if(!$user){
			return WSTReturn('用户不存在');
		}

		$ids = $this->where('userId',$user['userId'])->setInc('userMoney',$post['addnum']);
		if(!$ids) return WSTReturn('资金修改失败');

		//充值日志
		$data['bptype'] = 2;
        $data['createTime'] = date('Y-m-d H:i:s');
        $data['bpprice'] = $post['addnum'];
        $data['remarks'] = '会员充值,后台手动增加金额';
        $data['uid'] = $user['userId'];
        $data['isverified'] = 1;
        $data['btime'] = date('Y-m-d H:i:s');
        $data['reg_par'] = 0;
        $data['balance_sn'] = $user['userId'].time().rand(111111,999999);
        $data['pay_type'] = '后台手动增加金额';
        $data['bpbalance'] = round($user['userMoney']+$post['addnum'],2);
        $ids = db('recharge')->insertGetId($data);

		//资金日志
        $lm = [];
        $lm['targetType'] = 11;
        $lm['targetId'] = $user['userId'];
        $lm['dataId'] = 0;
        $lm['dataSrc'] = getsrc();
        $lm['remark'] = '后台手动增加金额';
        $lm['moneyType'] = 2;
        $lm['money'] = $post['addnum'];
        $lm['payType'] = 0;
        $lm['createTime'] = date('Y-m-d H:i:s',time());
        db('log_moneys')->insert($lm);

        return WSTReturn('资金修改成功',1);

	}
	
}
