<?php
namespace application\home\controller;
use application\home\model\Goods as M;
use application\common\model\Goods as CM;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 商品控制器
 */
class Goods extends Base{
    /**
      * 批量删除商品
      */
     public function batchDel(){
        $m = new M();
        return $m->batchDel();
     }
    /**
     * 修改商品库存/价格
     */
    public function editGoodsBase(){
        $m = new M();
        return $m->editGoodsBase();
    }

    /**
    * 修改商品状态
    */
    public function changSaleStatus(){
        $m = new M();
        return $m->changSaleStatus();
    }
    /**
    * 批量修改商品状态 新品/精品/热销/推荐
    */
    public function changeGoodsStatus(){
         $m = new M();
        return $m->changeGoodsStatus();
    }
    /**
    *   批量上(下)架
    */
    public function changeSale(){
        $m = new M();
        return $m->changeSale();
    }
   /**
    *  上架商品列表
    */
   /*
	public function sale(){
		return $this->fetch('shops/goods/list_sale');
	}
    */
	/**
	 * 获取上架商品列表
	 */
	public function saleByPage(){
		$m = new M();
		$rs = $m->saleByPage();
		$rs['status'] = 1;
		return $rs;
	}
	/**
	 * 仓库中商品
	 */
    public function store(){
		return $this->fetch('shops/goods/list_store');
	}
    /**
	 * 审核中的商品
	 */
    public function audit(){
		return $this->fetch('shops/goods/list_audit');
	}
	/**
	 * 获取审核中的商品
	 */
    public function auditByPage(){
		$m = new M();
		$rs = $m->auditByPage();
		$rs['status'] = 1;
		return $rs;
	}
	/**
	 * 获取仓库中的商品
	 */
    public function storeByPage(){
		$m = new M();
		$rs = $m->storeByPage();
		$rs['status'] = 1;
		return $rs;
	}
	/**
	 * 违规商品
	 */
    public function illegal(){
		return $this->fetch('shops/goods/list_illegal');
	}
	/**
	 * 获取违规的商品
	 */
	public function illegalByPage(){
		$m = new M();
		$rs = $m->illegalByPage();
		$rs['status'] = 1;
		return $rs;
	}
	
	/**
	 * 跳去新增页面
	 */
    public function add(){
    	$m = new M();
    	$object = $m->getEModel('goods');
    	$object['goodsSn'] = WSTGoodsNo();
    	$object['productNo'] = WSTGoodsNo();
    	$object['goodsImg'] = WSTConf('CONF.goodsLogo');
    	$data = ['object'=>$object,'src'=>'add'];
    	return $this->fetch('shops/goods/edit',$data);
    } 
    
    /**
     * 新增商品
     */
    public function toAdd(){
    	$m = new M();
    	return $m->add();
    }
    
    /**
     * 跳去编辑页面
     */
    public function edit(){
    	$m = new M();
    	$object = $m->getById(input('get.id'));
        
    	if($object['goodsImg']=='')$object['goodsImg'] = WSTConf('CONF.goodsLogo');
    	$data = ['object'=>$object,'src'=>input('src')];
    	return $this->fetch('shops/goods/edit',$data);
    }
    
    /**
     * 编辑商品
     */
    public function toEdit(){
    	$m = new M();
    	return $m->edit();
    }
    /**
     * 删除商品
     */
    public function del(){
    	$m = new M();
    	return $m->del();
    }
    /**
     * 获取商品规格属性
     */
    public function getSpecAttrs(){
    	$m = new M();
    	return $m->getSpecAttrs();
    }
    /**
     * 进行商品搜索
     */
    public function search(){
    	//获取商品记录
    	$m = new M();
    	$data = [];
    	$data['isStock'] = Input('isStock/d');
    	$data['isNew'] = Input('isNew/d');
    	$data['orderBy'] = Input('orderBy/d');
    	$data['order'] = Input('order/d',1);
    	$data['keyword'] = input('keyword');
    	$data['sprice'] = Input('sprice/d');
    	$data['eprice'] = Input('eprice/d');

        $data['areaId'] = (int)Input('areaId');
        $aModel = model('home/areas');

        // 获取地区
        $data['area1'] = $aModel->listQuery(); // 省级
        // 默认地区信息
        $data['area2'] = $aModel->listQuery(440000); // 广东的下级
        $data['area3'] = $aModel->listQuery(440100); // 广州的下级

        // 如果有筛选地区 获取上级地区信息
        if($data['areaId']!==0){
            $areaIds = $aModel->getParentIs($data['areaId']);
            /*
              2 => int 440000
              1 => int 440100
              0 => int 440106
            */
            $selectArea = [];
            $areaName = '';
            foreach($areaIds as $k=>$v){
                $a = $aModel->getById($v);
                $areaName .=$a['areaName'];
                $selectArea[] = $a;
            }
            // 地区完整名称
            $selectArea['areaName'] = $areaName;
            // 当前选择的地区
            $data['areaInfo'] = $selectArea;

            $data['area2'] = $aModel->listQuery($areaIds[2]); // 广东的下级
 
            $data['area3'] = $aModel->listQuery($areaIds[1]); // 广州的下级
        }
        

    	$data['goodsPage'] = $m->pageQuery();
    	return $this->fetch("goods_search",$data);
    }
    
    /**
     * 获取商品列表
     * 之前的
     */
    public function old_lists(){
    	$catId = Input('cat/d');
    	$goodsCatIds = model('GoodsCats')->getParentIs($catId);
    	reset($goodsCatIds);
    	//填充参数
    	$data = [];
    	$data['catId'] = $catId;
    	$data['isStock'] = Input('isStock/d');
    	$data['isNew'] = Input('isNew/d');
    	$data['orderBy'] = Input('orderBy/d');
    	$data['order'] = Input('order/d',1);
    	$data['sprice'] = Input('sprice');
    	$data['eprice'] = Input('eprice');
    	$data['attrs'] = [];

        $data['areaId'] = (int)Input('areaId');
        $aModel = model('home/areas');

        // 获取地区
        $data['area1'] = $aModel->listQuery(); // 省级
        // 默认地区信息
        $data['area2'] = $aModel->listQuery(440000); // 广东的下级
        $data['area3'] = $aModel->listQuery(440100); // 广州的下级

        // 如果有筛选地区 获取上级地区信息
        if($data['areaId']!==0){
            $areaIds = $aModel->getParentIs($data['areaId']);
            /*
              2 => int 440000
              1 => int 440100
              0 => int 440106
            */
            $selectArea = [];
            $areaName = '';
            foreach($areaIds as $k=>$v){
                $a = $aModel->getById($v);
                $areaName .=$a['areaName'];
                $selectArea[] = $a;
            }
            // 地区完整名称
            $selectArea['areaName'] = $areaName;
            // 当前选择的地区
            $data['areaInfo'] = $selectArea;

            $data['area2'] = $aModel->listQuery($areaIds[2]); // 广东的下级
 
            $data['area3'] = $aModel->listQuery($areaIds[1]); // 广州的下级
        }
        

        

    	$vs = input('vs');
    	$vs = ($vs!='')?explode(',',$vs):[];
    	foreach ($vs as $key => $v){
    		if($v=='' || $v==0)continue;
    		$v = (int)$v;
    		$data['attrs']['v_'.$v] = input('v_'.$v);
    	}
    	$data['vs'] = $vs;
    	$data['brandFilter'] = model('Brands')->listQuery((int)current($goodsCatIds));
    	$data['brandId'] = Input('brand/d');
    	$data['price'] = Input('price');
    	//封装当前选中的值
    	$selector = [];
    	//处理品牌
    	if($data['brandId']>0){
    		foreach ($data['brandFilter'] as $key =>$v){
    			if($v['brandId']==$data['brandId'])$selector[] = ['id'=>$v['brandId'],'type'=>'brand','label'=>"品牌","val"=>$v['brandName']];
    		}
    		unset($data['brandFilter']);
    	}
    	//处理价格
    	if($data['sprice']!='' && $data['eprice']!=''){
    		$selector[] = ['id'=>0,'type'=>'price','label'=>"价格","val"=>$data['sprice']."-".$data['eprice']];
    	}
        if($data['sprice']!='' && $data['eprice']==''){
        	$selector[] = ['id'=>0,'type'=>'price','label'=>"价格","val"=>$data['sprice']."以上"];
    	}
        if($data['sprice']=='' && $data['eprice']!=''){
        	$selector[] = ['id'=>0,'type'=>'price','label'=>"价格","val"=>"0-".$data['eprice']];
    	}
    	//处理已选属性
    	$goodsFilter = model('Attributes')->listQueryByFilter($catId);
    	$ngoodsFilter = [];
    	foreach ($goodsFilter as $key =>$v){
    		if(!in_array($v['attrId'],$vs))$ngoodsFilter[] = $v;
    	}
    	if(count($vs)>0){
    		foreach ($goodsFilter as $key =>$v){
    			if(in_array($v['attrId'],$vs)){
    				foreach ($v['attrVal'] as $key2 =>$vv){
    					if($vv==input('v_'.$v['attrId']))$selector[] = ['id'=>$v['attrId'],'type'=>'v_'.$v['attrId'],'label'=>$v['attrName'],"val"=>$vv];;
    				}
    			}
    		}
    	}
    	$data['selector'] = $selector;
    	$data['goodsFilter'] = $ngoodsFilter;
    	//获取商品记录
    	$m = new M();
    	$data['priceGrade'] = $m->getPriceGrade($goodsCatIds);
    	$data['goodsPage'] = $m->pageQuery($goodsCatIds);
    	return $this->fetch("goods_list",$data);
    }

    /**
     * 产品列表页
     */
    public function lists()
    {
        $catid = input('id/d',366);
        $catlist = model('GoodsCats')->where(array('parentId'=>0,"dataFlag"=>1))->select();
        $goodsCatIds = model('GoodsCats')->listQuery($catid);

        $catarr[0] = $catid;
        $i = 1;
        foreach ($goodsCatIds as $k => $v) {
            $catarr[$i] =  $v['catId'];
            $i++;
        }
        
        $thiscat =  model('GoodsCats')->where(array('catId'=>$catid ))->find();
        
        $map['goodsCatId'] = array('in',$catarr);
        //$map['isHot'] = 0;
        $goods = db('goods')->where($map)->order('goodsid desc')->select();
        
        

        $this->assign('goods',$goods);
        $this->assign('catlist',$catlist);
        $this->assign('catid',$catid);
        $this->assign('thiscat',$thiscat);
        return $this->fetch("goods_list");
    }
    
    /**
     * 查看商品详情
     */
    public function detail(){
		
    	$m = new M();
        $id = input('id/d',0);
		
    	$goods = $m->getBySale($id);
		
    	if(!empty($goods)){

            $ssc_list = ssc_list();
           
	    	$this->assign('goods',$goods);
            $this->assign('ssc_list',$ssc_list);

            //抢购榜单
            $where = array();
			
           /* $bangdan = db('drorder')->alias('o')->field('o.*,u.userName,g.goodsName,userPhone')
                    ->join('__USERS__ u','u.userId=o.userId')
                    ->join('__GOODS__ g','g.goodsId=o.goodsId')
                    ->where($where)->order('drid desc')->limit(0,20)->select();
			*/
			$bangdan = db('drorder')->where($where)->order('drid desc')->limit(0,20)->select();
			#$where['drid'] = array('gt', 440000 );
			foreach( $bangdan as $k => $v )
			{
				$u = db('users')->where('userId='.$v['userId'] )->find();
				$goods = db('goods')->where('goodsId='.$v['goodsId'] )->find();
				 
				$bangdan[$k]['userName'] = $u['userName'];
				$bangdan[$k]['userPhone'] = $u['userPhone'];
				$bangdan[$k]['goodsName'] = $goods['goodsName'];
				
				
			}
            $this->assign('bangdan',$bangdan);
			$lh = input('lh/d',0);
			$this->assign('lh',$lh);
			 
	    	return $this->fetch("goods_detail");
    	}else{
    		return $this->fetch("error_lost");
    	}
    }
    /**
     * 预警库存
     */
    public function stockwarnbypage(){
    	return $this->fetch("shops/stockwarn/list");
    }
    /**
     * 获取预警库存列表
     */
    public function stockByPage(){
    	$m = new M();
    	$rs = $m->stockByPage();
    	$rs['status'] = 1;
    	return $rs;
    }
    /**
     * 修改预警库存
     */
    public function editwarnStock(){
    	$m = new M();
    	return $m->editwarnStock();
    }
    
	/**
	 * 获取商品浏览记录
	 */
	public function historyByGoods(){
		$rs = model('Tags')->historyByGoods(8);
		return WSTReturn('',1,$rs);
	}


    public function duihuancp()
    {
        $m = new M();
        $map['goodsId'] = input('id/d',0);
        $goods = $m->where($map)->find();
        if(!$goods)  $this->error('产品不存在');
        if($goods['isPoint'] != 1) $this->error('此产品非积分兑换产品');

        if(input('post.')){
            $post = input('post.');

            $suoxu = round($goods['pointPrice']*$post['num']);

            if($this->users['userScore'] < $suoxu) $this->error('金币不足');

            //插入兑换订单
            $_dh['userId'] = $this->users['userId'];
            $_dh['goodsId'] = $map['goodsId'];
            $_dh['num'] = $post['num'];
            $_dh['createTime'] = date('Y-m-d H:i:s',time());
            $_dhids = db('duihuan')->insertGetId($_dh);
            if(!$_dhids) $this->error('兑换订单插入失败，请重试');

            
            $ids = db('users')->where('userId',$this->users['userId'] )->setDec('userScore',$suoxu);
            if ($suoxu) {
                //积分日志
                $lm = [];
                $lm['targetType'] = 2;
                $lm['targetId'] = $this->users['userId'];
                $lm['dataId'] = $_dhids;
                $lm['dataSrc'] = getsrc();
                $lm['remark'] = '用户积分兑换';
                $lm['moneyType'] = 1;
                $lm['money'] = $suoxu;
                $lm['payType'] = 0;
                $lm['createTime'] = $_dh['createTime'];
                db('log_moneys')->insert($lm);

                $this->success('兑换成功');
            }else{
                $this->error('兑换失败，请重试！');
            }

            

            exit;
        }
        

        
        $this->assign('goods',$goods);
        return $this->fetch("duihuancp");
    }



    /**
    *  促销商品列表
    */
    public function sales(){

        $catid = input('id/d',366);
        $catlist = model('GoodsCats')->where(array('parentId'=>0,"dataFlag"=>1))->select();
        $goodsCatIds = model('GoodsCats')->listQuery($catid);

        $catarr[0] = $catid;
        $i = 1;
        foreach ($goodsCatIds as $k => $v) {
            $catarr[$i] =  $v['catId'];
            $i++;
        }
        

        $map['goodsCatId'] = array('in',$catarr);
        $map['isBest'] = 1;
        $map['isHot'] = 1;
        $map['dataFlag'] = 1;
        $goods = db('goods')->where($map)->order('goodsid desc')->select();
        
        

        $this->assign('goods',$goods);
        $this->assign('catlist',$catlist);
        $this->assign('catid',$catid);
        return $this->fetch("goods_salelist");
    }

}
