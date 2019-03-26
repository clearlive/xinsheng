<?php
namespace application\home\controller;
/**
 
  
 
 

 

 
 * 商城消息控制器
 */
class Index extends Base{
	
    public function index(){

    	$categorys = model('GoodsCats')->getFloors();

    	$this->assign('floors',$categorys);
    	$this->assign('hideCategory',1);
        //首页通知
        $msg = db('messages')->where(array('msgType'=>0))->order('id desc')->find();
        //dump($msg);exit;
        $this->assign('msg',$msg);

        //首页产品
        $goods = db('goods')->where(array('isRecom'=>1,'dataFlag'=>1))->select();
        $this->assign('goods',$goods);


    	return $this->fetch('index');
    }
    /**
     * 保存目录ID
     */
    public function getMenuSession(){
    	$menuId = input("post.menuId");
    	$menuType = session('WST_USER.loginTarget');
    	session('WST_MENUID3'.$menuType,$menuId);
    } 
    /**
     * 获取用户信息
     */
    public function getSysMessages(){
    	$rs = model('Systems')->getSysMessages();
    	return $rs;
    }
    /**
     * 定位菜单以及跳转页面
     */
    public function position(){
    	$menuId = (int)input("post.menuId");
    	$menuType = ((int)input("post.menuType")==1)?1:0;
    	session('WST_MENUID3'.$menuType,$menuId);
    }

    public function orderinfo()
    {
        
        $list = db('orders')->field('createTime,orderId,userId')->order('orderId desc')->group('userId desc')->limit(100)->select();
        
        $arr = array();
        $db_users = db('users');
        foreach ($list as $key => $v) {
            $arr[$key]['orderDate'] = strtotime($v['createTime']).'000';
            $_user = $db_users->field('userPhoto,userName')->where('userId',$v['userId'])->find();
            $arr[$key]['headimgurl'] = '/'.$_user['userPhoto'];
            $arr[$key]['nick'] = $_user['userName'];
        }
        if(count($arr) < 100){
            $db_userfalse = db('userfalse');
            $count = 100-count($arr);
            $arrcount = count($arr);
            $uf = $db_userfalse->limit($count)->select();
            $time = time();
            foreach ($uf as $key => $v) {
                $keys = $key+$arrcount;
                $arr[$keys]['orderDate'] = ($time-$v['id']*5).'000';
                $arr[$keys]['headimgurl'] = $v['headimgurl'];
                $arr[$keys]['nick'] = $v['nick'];
            }
        }
        $res['Orderresult'] = $arr;
        return WSTreturn($res);

    }

    /**
    多人开奖
    **/
    public function kaijiang()
    {
        $ssc_list = ssc_list(1);
        
        $this->assign('ssc_list',$ssc_list);

        return $this->fetch('kaijiang');
    }

    public function ajax_kaijiang()
    {
        $page = input('page');
        $ssc_list = ssc_list($page);
        $html = '';
        foreach ($ssc_list as $key => $vo) {
            $html .='<div class="kjj">
                <div class="k_1">
                    <p>20'.$vo['issue'].'<span>期</span></p>
                    <blockquote>
                        <span>'.substr($vo['balls'],0,1).'</span>
                        <span>'.substr($vo['balls'],1,1).'</span>
                        <span>'.substr($vo['balls'],2,1).'</span>
                        <span class="s1">'.substr($vo['balls'],3,1).'</span>
                        <span class="s1">'.substr($vo['balls'],4,1).'</span>
                    </blockquote>
                </div>
                <div class="k_3">
                    <span class="cc1">'.$vo['isxiao'].'</span>
                    <span>|</span>
                    <span class="cc2">'.$vo['isdan'].'</span>
                </div>
                <div class="k_4"><span>'.$vo['four'].'</span></div>
                <div class="k_2"><span>'.substr($vo['balls'],4,1).'</span></div>
            </div>';
        }
        return $html;
    }

    


    /**最新参与记录*/
   public function index_order($page=1)
   {
        $where = array();
		/*
	   $list = db('drorder')->alias('o')->field('o.*,u.userName,g.goodsName,u.userPhone,userPhoto')
                ->join('__USERS__ u','u.userId=o.userId')
                ->join('__GOODS__ g','g.goodsId=o.goodsId')
                ->where($where)->group('orderNo')->order('drid desc')->limit(($page-1)*10,$page*10)->select();
		*/
		$where['drid'] = array( 'gt', 430000 );
		$list = db('drorder')->where($where)->group('orderNo')->order('drid desc')->limit(($page-1)*10,$page*10)->select();
		foreach( $list as $k => $v )
		{
			$u = db('users')->where('userId='.$v['userId'] )->find();
			$goods = db('goods')->where('goodsId='.$v['goodsId'] )->find();
			 
			$list[$k]['userPhoto'] = $u['userPhoto'];
			$list[$k]['userName'] = $u['userName'];
			$list[$k]['userPhone'] = $u['userPhone'];
			$list[$k]['goodsName'] = $goods['goodsName'];
			
			
		}
        if(!$list){
            exit(0);
        }
		

        $html = '';

        foreach ($list as $k => $v){
            $html .= '<li><a href="'.url('users/dingdan',array('uid'=>$v['userId'])).'">
                        </a><dl><a href="'.url('users/dingdan',array('uid'=>$v['userId'])).'">
                            <dt><img src="'.getuser_photo($v['userPhoto']).'"></dt>
                            </a><dd><a href="'.url('users/dingdan',array('uid'=>$v['userId'])).'">
                                <p><span>'.substr($v['userPhone'], 0,3).'****'.substr($v['userPhone'], -4).'</span></p>
                                </a><p style="color:#999;"><a href="'.url('users/dingdan',array('uid'=>$v['userId'])).'">
                                    </a><a style="color:#999;">抢购</a> <a style="color:red;">'.$v['orderNum'].'</a> '.$v['goodsName'].'</p>
                            </dd>
                        </dl>
                        <i>'.$v['createTime'].'</i>
                    </li>';
        }
        
        die($html);

   }

   /**最新获奖记录*/
   public function index_orderwin($page=1)
   {
       
       $where = array();
       $where['iswin'] = 1;
        $list = db('drorder')->alias('o')->field('o.*,u.userName,g.goodsName,userPhone,userPhoto')
                ->join('__USERS__ u','u.userId=o.userId')
                ->join('__GOODS__ g','g.goodsId=o.goodsId')
                ->where($where)->order('drid desc')->limit(($page-1)*10,$page*10)->select();

        if(!$list){
            exit(0);
        }

        $html = '';

        foreach ($list as $k => $v){
            $html .= '<li><a href="'.url('users/dingdan',array('uid'=>$v['userId'])).'">
                        </a><dl><a href="'.url('users/dingdan',array('uid'=>$v['userId'])).'">
                            <dt><img src="'.getuser_photo($v['userPhoto']).'"></dt>
                            </a><dd><a href="'.url('users/dingdan',array('uid'=>$v['userId'])).'">
                                <p><span>'.substr($v['userPhone'], 0,3).'****'.substr($v['userPhone'], -4).'</span></p>
                                </a><p style="color:#999;"><a href="'.url('users/dingdan',array('uid'=>$v['userId'])).'">
                                    </a><a style="color:#999;">获胜</a> <a style="color:red;">'.$v['orderNum'].'</a> '.$v['goodsName'].'</p>
                            </dd>
                        </dl>
                        <i>'.$v['createTime'].'</i>
                    </li>';
        }
        
        die($html);
   }
   



   /**
    多人排行
    $type 1日 2周 3月
    **/
    public function paihang($type=1)
    {
        $db_drorder = db('drorder');

        $map['o.iswin'] = 1;

        switch ($type) {
            case '1':
                $map['o.createTime'] = array('>=',date('Y-m-d').' 00:00:00');
				$ctime = 60*60;
                break;
            case '2':
                $map['o.createTime'] = array('>=',date("Y-m-d",strtotime("-1 week Monday")).' 00:00:00');
				$ctime = 60*60*24;
                break;
            case '3':
                $map['o.createTime'] = array('>=',date("Y-m").'-01 00:00:00');
				$ctime = 60*60*24;
                break;
            
            default:
                $map['o.createTime'] = array('>=',date('Y-m-d').' 00:00:00');
                break;        
            }
        
        $cachelist = cache('paihang'.$type);
		if($cachelist){
			$list = $cachelist;
			
		}else{
			$list = $db_drorder->alias('o')->field('o.drid,o.userId,sum(o.orderNum) as sumNum,u.userName,userPhoto,userPhone')
                ->join('__USERS__ u','u.userId=o.userId')
                ->group('o.userId')->order('sumNum desc')
                ->where($map)->limit(40)->select();
			
			cache('paihang'.$type,$list,$ctime);
		}

        
        

        
        $this->assign('type',$type);
        $this->assign('list',$list);
        return $this->fetch('paihang');
    }




}
