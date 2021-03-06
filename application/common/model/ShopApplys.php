<?php
namespace application\common\model;
/**
 
 * application多用户商城
 * 版权所有 2016-2066 广州商淘信息科技有限公司，并保留所有权利。
 * 官网地址:http://www.application.net
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 
 

 
 * 门店申请类
 */
class ShopApplys extends Base{
	
	 /**
     * 查询手机是否存在
     */
    public function checkShopPhone(){
    	$shopPhone = input("post.userPhone2");
    	if($shopPhone=='')return WSTReturn("请输入手机号码");
    	$rs = $this->where("phoneNo",$shopPhone)
    				->where(["dataFlag"=>1])
    				->count();
    	if($rs==0){
    		return WSTReturn("",1);
    	}
    	return WSTReturn("手机号码已存在");
    }
	/**
	 * 添加门店申请记录
	 */
	public function addApply(){	
		$phoneNo = input("post.userPhone2");
		$applyDesc = input("post.remark");
		$crs = $this->checkShopPhone();
		if($crs['status']!=1){
			return WSTReturn("该手机已存在");
		}
		$mobileCode = input("post.mobileCode");
		$code = input("post.smsVerfy");
		
		$verify = session('VerifyCode_shopPhone');
		$startTime = (int)session('VerifyCode_shopPhone_Time');
		if((time()-$startTime)>120){
			return WSTReturn("验证码已超过有效期!");
		}
		if($mobileCode=="" || $verify != $mobileCode){
			return WSTReturn("验证码错误!");
		}
		$data = array();
		$data['userId'] = (int)session('WST_USER.userId');
		$data['phoneNo'] = $phoneNo;
		$data['applyDesc'] = $applyDesc;
		$data['applyStatus'] = 0;
		$data['dataFlag'] = 1;
		$data['createTime'] = date('Y-m-d H:i:s');
		$rs = $this->data($data)->save();
		if(false !== $rs){
			return WSTReturn("申请成功", 1);
		}else{
			return WSTReturn($this->getError());
		}
	}
}
