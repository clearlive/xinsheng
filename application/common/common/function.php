<?php
/**
 
  
 
 

 

 
 */

use think\Db;
/**
 * 生成验证码
 */
function WSTVerify(){
	$Verify = new \verify\Verify();
    $Verify->length   = 4;
    $Verify->entry();
}
/**
 * 核对验证码
 */
function WSTVerifyCheck($code){
	$verify = new \verify\Verify();
	return $verify->check($code);
}
/**
 * 生成数据返回值
 */
function WSTReturn($msg,$status = -1,$data = []){
	$rs = ['status'=>$status,'msg'=>$msg];
	if(!empty($data))$rs['data'] = $data;
	return $rs;
}

/**
 * 检测字符串不否包含
 * @param $srcword 被检测的字符串
 * @param $filterWords 禁用使用的字符串列表
 * @return boolean true-检测到,false-未检测到
 */
function WSTCheckFilterWords($srcword,$filterWords){
	$flag = true;
	if($filterWords!=""){
		$filterWords = str_replace("，",",",$filterWords);
		$words = explode(",",$filterWords);
		for($i=0;$i<count($words);$i++){
			if(strpos($srcword,$words[$i]) !== false){
				$flag = false;
				break;
			}
		}
	}
	return $flag;
}

/**
 * 中国网建短信服务商
 * @param string $phoneNumer  手机号码
 * @param string $content     短信内容
 */
function WSTSendSMS($phoneNumer,$content){
	$url = 'http://utf8.sms.webchinese.cn/?Uid='.WSTConf("CONF.smsKey").'&Key='.WSTConf("CONF.smsPass").'&smsMob='.$phoneNumer.'&smsText='.$content;
	$ch=curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置否输出到页面
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30 ); //设置连接等待时间
	curl_setopt($ch, CURLOPT_ENCODING, "gzip" );
	$data=curl_exec($ch);
	curl_close($ch);
	return $data;
}


/**
 * 获取指定的全局配置
 */
function WSTConf($key,$v = ''){


	if(is_null($v)){
		if(array_key_exists('applicationCONF',$GLOBALS) && array_key_exists($key,$GLOBALS['applicationCONF'])){
		    unset($GLOBALS['applicationCONF'][$key]);
		}
	}else if($v === ''){
	

		if(array_key_exists('applicationCONF',$GLOBALS)){
			$conf = $GLOBALS['applicationCONF'];
			$ks = explode(".",$key);

			for($i=0,$k=count($ks);$i<$k;$i++){
				if(array_key_exists($ks[$i],$conf)){
					$conf = $conf[$ks[$i]];
				}else{
					return null;
				}
			}

			return $conf;
		}
	}else{
		return $GLOBALS['applicationCONF'][$key] = $v;
	}
	return null;
}

//php获取中文字符拼音首字母
function WSTGetFirstCharter($str){
	if(empty($str)){
		return '';
	}
	$fchar=ord($str{0});
	if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
	$s1=iconv('UTF-8','gb2312',$str);
	$s2=iconv('gb2312','UTF-8',$s1);
	$s=$s2==$str?$s1:$str;
	if(empty($s{1})){
		return '';
	}
	$asc=ord($s{0})*256+ord($s{1})-65536;
	if($asc>=-20319 && $asc<=-20284) return 'A';
	if($asc>=-20283 && $asc<=-19776) return 'B';
	if($asc>=-19775 && $asc<=-19219) return 'C';
	if($asc>=-19218 && $asc<=-18711) return 'D';
	if($asc>=-18710 && $asc<=-18527) return 'E';
	if($asc>=-18526 && $asc<=-18240) return 'F';
	if($asc>=-18239 && $asc<=-17923) return 'G';
	if($asc>=-17922 && $asc<=-17418) return 'H';
	if($asc>=-17417 && $asc<=-16475) return 'J';
	if($asc>=-16474 && $asc<=-16213) return 'K';
	if($asc>=-16212 && $asc<=-15641) return 'L';
	if($asc>=-15640 && $asc<=-15166) return 'M';
	if($asc>=-15165 && $asc<=-14923) return 'N';
	if($asc>=-14922 && $asc<=-14915) return 'O';
	if($asc>=-14914 && $asc<=-14631) return 'P';
	if($asc>=-14630 && $asc<=-14150) return 'Q';
	if($asc>=-14149 && $asc<=-14091) return 'R';
	if($asc>=-14090 && $asc<=-13319) return 'S';
	if($asc>=-13318 && $asc<=-12839) return 'T';
	if($asc>=-12838 && $asc<=-12557) return 'W';
	if($asc>=-12556 && $asc<=-11848) return 'X';
	if($asc>=-11847 && $asc<=-11056) return 'Y';
	if($asc>=-11055 && $asc<=-10247) return 'Z';
	return null;
}

/**
 * 设置当前页面对象
 * @param int 0-用户  1-商家
 */
function WSTLoginTarget($target = 0){
	$WST_USER = session('WST_USER');
	$WST_USER['loginTarget'] = $target;
	session('WST_USER',$WST_USER);
}
/**
 * 邮件发送函数
 * @param string to      要发送的邮箱地址
 * @param string subject 邮件标题
 * @param string content 邮件内容
 * @return array
 */
function WSTSendMail($to, $subject, $content) {
	$mail = new \phpmailer\phpmailer();
    // 装配邮件服务器
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = WSTConf("CONF.mailSmtp");
    $mail->SMTPAuth = WSTConf("CONF.mailAuth");
    $mail->Username = WSTConf("CONF.mailUserName");
    $mail->Password = WSTConf("CONF.mailPassword");
    $mail->CharSet = 'utf-8';
    // 装配邮件头信息
    $mail->From = WSTConf("CONF.mailAddress");
    $mail->AddAddress($to);
    $mail->FromName = WSTConf("CONF.mailSendTitle");
    $mail->IsHTML(true);
    // 装配邮件正文信息
    $mail->Subject = $subject;
    $mail->Body = $content;
    // 发送邮件
    $rs =array();
    if (!$mail->Send()) {
    	$rs['status'] = 0;
    	$rs['msg'] = $mail->ErrorInfo;
        return $rs;
    } else {
    	$rs['status'] = 1;
        return $rs;
    }
}

/**
 * 获取系统配置数据
 */
function WSTConfig(){
	$rs = cache('WST_CONF');
	if(!$rs){
		$rv = Db::name('sys_configs')->field('fieldCode,fieldValue')->select();
		$rs = [];
		foreach ($rv as $v){
			$rs[$v['fieldCode']] = $v['fieldValue'];
		}
		//获取风格
        $styles = Db::name('styles')->where(['isUse'=>1])->field('styleSys,stylePath,id')->select();
        if(!empty($styles)){
	        foreach ($styles as $key => $v) {
		        $rs['wst'.$v['styleSys'].'Style'] = $v['stylePath'];
		        $rs['wst'.$v['styleSys'].'StyleId'] = $v['id'];
	        }
        }
		//获取上传文件目录配置
		$data = Db::name('datas')->where('catId',3)->column('dataVal');
		foreach ($data as $key => $v){
			$data[$key] = str_replace('_','',$v);
		}
		$rs['wstUploads'] = $data;
		if(WSTConf('CONF.mallLicense')=='')$rs['mallSlogan'] = $rs['mallSlogan']."  ".base64_decode('UG93ZXJlZCBCeSBXU1RNYXJ0');
		cache('WST_CONF',$rs,31536000);
	}
	return $rs;
} 

/**
 * 判断手机号格式是否正确
 */
function WSTIsPhone($phoneNo){
	$reg = "/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/";
	$rs = \think\Validate::regex($phoneNo,$reg);
	return $rs;
}

/**
 * 检测登录账号是否可用
 * @param $key 要检测的内容
 */
function WSTCheckLoginKey($val,$userId = 0){
    if($val=='')return WSTReturn("登录账号不能为空");
    if(!WSTCheckFilterWords($val,WSTConf("CONF.registerLimitWords"))){
    	return WSTReturn("登录账号包含非法字符");
    }
    $dbo = Db::name('users')->where(["loginName|userEmail|userPhone"=>['=',$val],'dataFlag'=>1]);
    if($userId>0){
    	$dbo->where("userId", "<>", $userId);
    }
    $rs = $dbo->count();
    if($rs==0){
    	return WSTReturn("该登录账号可用",1);
    }
    return WSTReturn("对不起，登录账号已存在");
}

/**
 * 生成随机数账号
 */
function WSTRandomLoginName($loginName){
	$chars = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
    //简单的派字母
    foreach ($chars as $key =>$c){
    	$crs = WSTCheckLoginKey($loginName."_".$c);
    	if($crs['status']==1)return $loginName."_".$c;
    }
    //随机派三位数值
    for($i=0;$i<1000;$i++){
    	$crs = $this->WSTCheckLoginKey($loginName."_".$i);
    	if($crs['status']==1)return $loginName."_".$i;
    }
    return '';
}

/**
 * 删除一维数组里的多个key
 */
function WSTUnset(&$data,$keys){
    if($keys!='' && is_array($data)){
        $key = explode(',',$keys);
        foreach ($key as $v)unset($data[$v]);
    }
}
/**
 * 只允许一维数组里的某些key通过
 */
function WSTAllow(&$data,$keys){
    if($keys!='' && is_array($data)){
        $key = explode(',',$keys);
        foreach ($data as $vkeys =>$v)if(!in_array($vkeys,$key))unset($data[$vkeys]);
    }
}

/**
 * 字符串替换
 * @param string $str     要替换的字符串
 * @param string $repStr  即将被替换的字符串
 * @param int $start      要替换的起始位置,从0开始
 * @param string $splilt  遇到这个指定的字符串就停止替换
 */
function WSTStrReplace($str,$repStr,$start,$splilt = ''){
	$newStr = substr($str,0,$start);
	$breakNum = -1;
	for ($i=$start;$i<strlen($str);$i++){
		$char = substr($str,$i,1);
		if($char==$splilt){
			$breakNum = $i;
			break;
		}
		$newStr.=$repStr;
	}
	if($splilt!='' && $breakNum>-1){
		for ($i=$breakNum;$i<strlen($str);$i++){
			$char = substr($str,$i,1);
			$newStr.=$char;
		}
	}
	return $newStr;
}

/**
 * 获取指定商品分类的子分类列表
 */
function WSTGoodsCats($parentId = 0,$isFloor = -1){
	$dbo = Db::name('goods_cats')->where(['dataFlag'=>1, 'isShow' => 1,'parentId'=>$parentId]);
	if($isFloor!=-1)$db0>where('isFloor',$isFloor);
	return $dbo->field("catName,catId")->order('catSort asc')->select();
}


/**
 * 上传图片
 * 需要生成缩略图： isThumb=1
 * 需要加水印：isWatermark=1
 * pc版缩略图： width height
 * 手机版原图：mWidth mHeight
 * 缩略图：mTWidth mTHeight
 * 判断图片来源：fromType 0：商家/用户   1：平台管理员
 */
function WSTUploadPic($fromType=0){
	$fileKey = key($_FILES);
	$dir = Input('post.dir');
	if($dir=='')return json_encode(['msg'=>'没有指定文件目录！','status'=>-1]);
	$dirs = WSTConf("CONF.wstUploads");
   	if(!in_array($dir, $dirs)){
   		return json_encode(['msg'=>'非法文件目录！','status'=>-1]);
   	}
   	// 上传文件
    $file = request()->file($fileKey);
    if($file===null){
    	return json_encode(['msg'=>'上传文件不存在或超过服务器限制','status'=>-1]);
    }
    $validate = new \think\Validate([
	    ['fileMime','fileMime:image/png,image/gif,image/jpeg,image/x-ms-bmp','只允许上传jpg,gif,png,bmp类型的文件'],
	    ['fileExt','fileExt:jpg,jpeg,gif,png,bmp','只允许上传后缀为jpg,gif,png,bmp的文件'],
	    ['fileSize','fileSize:2097152','文件大小超出限制'],//最大2M
	]);
	$data = ['fileMime'  => $file,
	    	 'fileSize' => $file,
	         'fileExt'=> $file
	        ];
	if (!$validate->check($data)) {
	    return json_encode(['msg'=>$validate->getError(),'status'=>-1]);
	}
    $info = $file->rule('uniqid')->move(ROOT_PATH.'/upload/'.$dir."/".date('Y-m'));
    if($info){
    	$filePath = $info->getPathname();
    	$filePath = str_replace(ROOT_PATH,'',$filePath);
    	$filePath = str_replace('\\','/',$filePath);
    	$name = $info->getFilename();
    	$filePath = str_replace($name,'',$filePath);
    	//原图路径
    	$imageSrc = trim($filePath.$name,'/');
    	//图片记录
    	WSTRecordImages($imageSrc, (int)$fromType);
    	//打开原图
    	$image = \image\Image::open($imageSrc);
    	//缩略图路径 手机版原图路径 手机版缩略图路径
    	$thumbSrc = $mSrc = $mThumb = null;
    	//手机版原图宽高
    	$mWidth = min($image->width(),(int)input('mWidth',700));
		$mHeight = min($image->height(),(int)input('mHeight',700));
		//手机版缩略图宽高
		$mTWidth = min($image->width(),(int)input('mTWidth',250));
		$mTHeight = min($image->height(),(int)input('mTHeight',250));

    	/****************************** 生成缩略图 *********************************/
    	$isThumb = (int)input('isThumb');
    	if($isThumb==1){
    		//缩略图路径
    		$thumbSrc = str_replace('.', '_thumb.', $imageSrc);
    		$image->thumb((int)input('width',min(300,$image->width())), (int)input('height',min(300,$image->height())),2)->save($thumbSrc,$image->type(),90);
    		//是否需要生成移动版的缩略图
    		$suffix = WSTConf("CONF.wstMobileImgSuffix");
    		if(!empty($suffix)){
    			$image = \image\Image::open($imageSrc);
    			$mSrc = str_replace('.',"$suffix.",$imageSrc);
    			$mThumb = str_replace('.', '_thumb.',$mSrc);
    			$image->thumb($mWidth, $mHeight)->save($mSrc,$image->type(),90);
    			$image->thumb($mTWidth, $mTHeight, 2)->save($mThumb,$image->type(),90);
    		}


    	}
    	/***************************** 添加水印 ***********************************/
    	$isWatermark=(int)input('isWatermark');
    	if($isWatermark==1 && (int)WSTConf('CONF.watermarkPosition')!==0){
	    	//取出水印配置
	    	$wmWord = WSTConf('CONF.watermarkWord');//文字
	    	$wmFile = trim(WSTConf('CONF.watermarkFile'),'/');//水印文件
	    	$wmPosition = (int)WSTConf('CONF.watermarkPosition');//水印位置
	    	$wmSize = ((int)WSTConf('CONF.watermarkSize')!=0)?WSTConf('CONF.watermarkSize'):'20';//大小
	    	$wmColor = (WSTConf('CONF.watermarkColor')!='')?WSTConf('CONF.watermarkColor'):'#000000';//颜色必须是16进制的
	    	$wmOpacity = ((int)WSTConf('CONF.watermarkOpacity')!=0)?WSTConf('CONF.watermarkOpacity'):'100';//水印透明度
	    	//是否有自定义字体文件
	    	$customTtf = $_SERVER['DOCUMENT_ROOT'].WSTConf('CONF.watermarkTtf');
	    	$ttf = is_file($customTtf)?$customTtf:EXTEND_PATH.'/verify/verify/ttfs/3.ttf';
	        $image = \image\Image::open($imageSrc);
	    	if(!empty($wmWord)){//当设置了文字水印 就一定会执行文字水印,不管是否设置了文件水印
		    	
	    		//执行文字水印
	    		$image->text($wmWord, $ttf, $wmSize, $wmColor, $wmPosition)->save($imageSrc);
	    		if($thumbSrc!==null){
	    			$image->thumb((int)input('width',min(300,$image->width())), (int)input('height',min(300,$image->height())),2)->save($thumbSrc,$image->type(),90);
	    		}
	    		//如果有生成手机版原图
	    		if(!empty($mSrc)){
	    			$image = \image\Image::open($imageSrc);
	    			$image->thumb($mWidth, $mHeight)->save($mSrc,$image->type(),90);
	    			$image->thumb($mTWidth, $mTHeight, 2)->save($mThumb,$image->type(),90);
	    		}
	    	}elseif(!empty($wmFile)){//设置了文件水印,并且没有设置文字水印
	    		//执行图片水印
	    		$image->water($wmFile, $wmPosition, $wmOpacity)->save($imageSrc);
	    		if($thumbSrc!==null){
	    			$image->thumb((int)input('width',min(300,$image->width())), (int)input('height',min(300,$image->height())),2)->save($thumbSrc,$image->type(),90);
	    		}
	    		//如果有生成手机版原图
	    		if($mSrc!==null){
	    			$image = \image\Image::open($imageSrc);
	    			$image->thumb($mWidth, $mHeight)->save($mSrc,$image->type(),90);
	    			$image->thumb($mTWidth, $mTHeight,2)->save($mThumb,$image->type(),90);
	    		}
	    	}
    	}
    	//判断是否有生成缩略图
    	$thumbSrc = ($thumbSrc==null)?$info->getFilename():str_replace('.','_thumb.', $info->getFilename());
		$filePath = ltrim($filePath,'/');
		// 用户头像上传宽高限制
		$isCut = (int)input('isCut');
		if($isCut){
			$imgSrc = $filePath.$info->getFilename();
			$image = \image\Image::open($imgSrc);
			$size = $image->size();//原图宽高
			$w = $size[0];
			$h = $size[1];
			$rate = $w/$h;
			if($w>$h && $w>500){
				$newH = 500/$rate;
				$image->thumb(500, $newH)->save($imgSrc,$image->type(),90);
			}elseif($h>$w && $h>500){
				$newW = 500*$rate;
				$image->thumb($newW, 500)->save($imgSrc,$image->type(),90);
			}
		}
        return json_encode(['status'=>1,'savePath'=>$filePath,'name'=>$info->getFilename(),'thumb'=>$thumbSrc]);
    }else{
        //上传失败获取错误信息
        return $file->getError();
    }    
}
/**
 * 上传文件
 */
function WSTUploadFile(){
	$fileKey = key($_FILES);
	$dir = Input('post.dir');
	if($dir=='')return json_encode(['msg'=>'没有指定文件目录！','status'=>-1]);
	$dirs = WSTConf("CONF.wstUploads");
   	if(!in_array($dir, $dirs)){
   		return json_encode(['msg'=>'非法文件目录！','status'=>-1]);
   	}
   	//上传文件
    $file = request()->file($fileKey);
    if($file===null){
    	return json_encode(['msg'=>'上传文件不存在或超过服务器限制','status'=>-1]);
    }
    $validate = new \think\Validate([
	    ['fileExt','fileExt:xls,xlsx,xlsm','只允许上传后缀为xls,xlsx,xlsm的文件']
	]);
	$data = ['fileExt'=> $file];
	if (!$validate->check($data)) {
	    return json_encode(['msg'=>$validate->getError(),'status'=>-1]);
	}
    $info = $file->rule('uniqid')->move(ROOT_PATH.'/upload/'.$dir."/".date('Y-m'));
    //保存路径
    $filePath = $info->getPathname();
	$filePath = str_replace(ROOT_PATH,'',$filePath);
	$filePath = str_replace('\\','/',$filePath);
	$name = $info->getFilename();
	$filePath = str_replace($name,'',$filePath);
	if($info){
		return json_encode(['status'=>1,'name'=>$info->getFilename(),'route'=>$filePath]);
	}else{
		//上传失败获取错误信息
		return $file->getError();
	}
}
/**
 * 生成默认商品编号/货号
 */
function WSTGoodsNo($pref = ''){
	return $pref.(round(microtime(true),4)*10000).mt_rand(0,9);
}
/**
 * 获取订单统一流水号
 */
function WSTOrderQnique(){
	return (round(microtime(true),4)*10000).mt_rand(1000,9999);
}


/**
* 图片管理
* @param $imgPath    图片路径
* @param $fromType   0：用户/商家 1：平台管理员
* 
*/
function WSTRecordImages($imgPath, $fromType){
	$data = [];
	$data['imgPath'] = $imgPath;
	if(file_exists($imgPath)){
		$data['imgSize'] = filesize($imgPath); //返回字节数 imgsize/1024 k  	imgsize/1024/1024 m
	}
	//获取表名
	$table = explode('/',$imgPath);
	$data['fromTable'] = $table[1];
	$data['fromType'] = (int)$fromType; 
	//根据类型判断所有者
	$data['ownId'] = ((int)$fromType==0)?(int)session('WST_USER.userId'):(int)session('WST_STAFF.staffId');
	$data['isUse'] = 0; //默认不使用
	$data['createTime'] = date('Y-m-d H:i:s');

	//保存记录
	Db::name('images')->insert($data);

}
/**
* 启用图片
* @param $fromType 0：  用户/商家 1：平台管理员
* @param $dataId        来源记录id
* @param $imgPath       图片路径,要处理多张图片时请传入一位数组,或用","连接图片路径
* @param $fromTable     该记录来自哪张表
* @param $imgFieldName  表中的图片字段名称
*/
function WSTUseImages($fromType, $dataId, $imgPath, $fromTable='', $imgFieldName=''){
	if(empty($imgPath))return;

	$image['fromType'] = (int)$fromType;
	//根据类型判断所有者
	$image['ownId'] = ((int)$fromType==0)?(int)session('WST_USER.userId'):(int)session('WST_STAFF.staffId');
	$image['dataId'] = (int)$dataId;

	$image['isUse'] = 1;//标记为启用
	if($fromTable!=''){
		$tmp = ['',''];
		if(strpos($fromTable,'-')!==false){
			$tmp = explode('-',$fromTable);
			$fromTable = str_replace('-'.$tmp[1],'',$fromTable);
		}
		$image['fromTable'] = str_replace('_','',$fromTable.$tmp[1]);
	}

	$imgPath = is_array($imgPath)?$imgPath:explode(',',$imgPath);//转数组


	//用于与旧图比较
	$newImage = $imgPath;

	// 不为空说明执行修改
	if($imgFieldName!=''){
		//要操作的表名  $fromTable;
		// 获取`$fromTable`表的主键
		$prefix = config('database.prefix');
		$tableName = $prefix.$fromTable;
		$pk = Db::getTableInfo("$tableName", 'pk');
		// 取出旧图
		$oldImgPath = model("$fromTable")->where("$pk",$dataId)->value("$imgFieldName"); 
		// 转数组
		$oldImgPath = explode(',', $oldImgPath);

		// 1.要设置为启用的文件
		$newImage = array_diff($imgPath, $oldImgPath);
		// 2.要标记为删除的文件
		$oldImgPath = array_diff($oldImgPath, $imgPath);
		//旧图数组跟新图数组相同则不需要继续执行
		if($newImage!=$oldImgPath)WSTUnuseImage($oldImgPath);
	}
	if(!empty($newImage)){
		Db::name('images')->where(['imgPath'=>['in',$newImage]])->update($image);
	}
}

/**
* 编辑器图片记录
* @param $fromType 0：  用户/商家 1：平台管理员
* @param $dataId        来源记录id
* @param $oldDesc       旧商品描述
* @param $newDesc       新商品描述
* @param $fromTable     该记录来自哪张表
*/
function WSTEditorImageRocord($fromTable, $dataId, $oldDesc, $newDesc){
		//编辑器里的图片
		$rule = '/src="\/(upload.*?)"/';
	    // 获取旧的src数组
	    preg_match_all($rule,$oldDesc,$images);
	    $oldImgPath = $images[1];

	    preg_match_all($rule,$newDesc,$images);  
	    // 获取新的src数组
	    $imgPath = $images[1];
		// 1.要设置为启用的文件
		$newImage = array_diff($imgPath, $oldImgPath);
		// 2.要标记为删除的文件
		$oldImgPath = array_diff($oldImgPath, $imgPath);
		//旧图数组跟新图数组相同则不需要继续执行
		if($newImage!=$oldImgPath){
			//标记新图启用
			WSTUseImages($fromTable, $dataId, $newImage);
			//标记旧图删除
			WSTUnuseImage($oldImgPath);
		}
}

/**
* 标记删除图片
*/
function WSTUnuseImage($fromTable, $field = '' , $dataId = 0){
	if($fromTable=='')return;
	$imgPath = $fromTable;
	if($field!=''){
		$prefix = config('database.prefix');
		$tableName = $prefix.$fromTable;
		$pk = Db::getTableInfo("$tableName", 'pk');
		// 取出旧图
		$imgPath = model("$fromTable")->where("$pk",$dataId)->value("$field");
	}
	if(!empty($imgPath)){
		$imgPath = is_array($imgPath)?$imgPath:explode(',',$imgPath);//转数组
		Db::name('images')->where(['imgPath'=>['in',$imgPath]])->setField('isUse',0);
	}
}
/**
 * 获取系统根目录
 */
function WSTRootPath(){
	return dirname(dirname(dirname(dirname(__File__))));
}
/**
 * 切换图片
 * @param $imgurl 图片路径
 * @param $imgType 图片类型    0:PC版大图   1:PC版缩略图       2:移动版大图    3:移动版缩略图
 * 图片规则  
 * PC版版大图 :201635459344.jpg
 * PC版版缩略图 :201635459344_thumb.jpg
 * 移动版大图 :201635459344_m.jpg
 * 移动版缩略图 :201635459344_m_thumb.jpg
 */
function WSTImg($imgurl,$imgType = 1){
	$m = WSTConf('CONF.wstMobileImgSuffix');
	$imgurl = str_replace($m.'.','.',$imgurl);
	$imgurl = str_replace($m.'_thumb.','.',$imgurl);
	$imgurl = str_replace('_thumb.','.',$imgurl);
	$img = '';
	switch ($imgType){
		case 0:$img =  $imgurl;break;
		case 1:$img =  str_replace('.','_thumb.',$imgurl);break;
		case 2:$img =  str_replace('.',$m.'.',$imgurl);break;
		case 3:$img =  str_replace('.',$m.'_thumb.',$imgurl);break;
	}
	return ((file_exists(WSTRootPath()."/".$img))?$img:$imgurl);
}

/**
 * 根据送货城市获取运费
 * @param $cityId 送货城市Id
 * @param @shopIds 店铺ID
 */
function WSTOrderFreight($shopId,$cityId){
	$goodsFreight = ['total'=>0,'shops'=>[]];
	$rs = Db::name('shops')->alias('s')->join('__SHOP_FREIGHTS__ sf','s.shopId=sf.shopId','left')
	     ->where('s.shopId',$shopId)->field('s.freight,sf.freightId,sf.freight freight2')->find();
    return ((int)$rs['freightId']>0)?$rs['freight2']:$rs['freight'];
}
/**
 * 生成订单号
 */
function WSTOrderNo(){
    $orderId = Db::name('orderids')->insertGetId(['rnd'=>time()]);
    

	return $orderId.time().rand(1000,9999);
}
/**
 * 高精度数字相加
 * @param $num
 * @param number $i 保留小数位
 */
function WSTBCMoney($num1,$num2,$i=2){
	$num = bcadd($num1, $num2, $i);
	return (float)$num;
}
/**
 * 获取支付方式
 */
function WSTLangPayType($v){
	return ($v==1)?"在线支付":"货到付款";
}
/**
 * 收货方式
 */
function WSTLangDeliverType($v){
	return ($v==1)?"自提":"送货上门";
}
/**
 * 订单状态
 */
function WSTLangOrderStatus($v){
	switch($v){
		case -3:return '用户拒收';
		case -2:return '待支付';
		case -1:return '已取消';
		case 0:return '待发货';
		case 1:return '待收货';
		case 2:return '已收货';
	}
}
/**
 * 积分来源
 */
function WSTLangScore($v){
    switch($v){
		case 1:return '商品订单';
		case 2:return '评价订单';
	}
}
/**
 * 资金来源
 */
function WSTLangMoneySrc($v){
    switch($v){
		case 1:return '商品订单';
		case 2:return '订单结算';
		case 3:return '提现申请';
	}
}
/**
 * 积分来源
 */
function WSTLangComplainStatus($v){
    switch($v){
		case 0:return '等待处理';
		case 1:return '等待应诉人应诉';
		case 2:return '应诉人已应诉';
		case 3:return '等待仲裁';
		case 4:return '已仲裁';
	}
}
/**
 * 支付来源
 */
function WSTLangPayFrom($v){
    switch($v){
		case 1:return '支付宝';
		case 2:return '微信';
	}
}
/**
 * 获取业务数据内容
 */
function WSTDatas($catId,$id = 0){
	$rs = Db::name('datas')->order('catId asc,dataSort asc,id asc')->cache(31536000)->select();
	$data = [];
	foreach ($rs as $key =>$v){
		$data[$v['catId']][$v['dataVal']] = $v;
	}
	if(isset($data[$catId])){
		if($id==0)return $data[$catId];
		return isset($data[$catId][$id])?$data[$catId][$id]:'';
	}
	return [];
}
/**
 * 截取字符串
 */
function WSTMSubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = false){
	$newStr = '';
	if (function_exists ( "mb_substr" )) {
		if ($suffix){
			$newStr = mb_substr ( $str, $start, $length, $charset )."...";
		}else{
			$newStr = mb_substr ( $str, $start, $length, $charset );
		}
	} elseif (function_exists ( 'iconv_substr' )) {
		if ($suffix){
			$newStr = iconv_substr ( $str, $start, $length, $charset )."...";
		}else{
			$newStr = iconv_substr ( $str, $start, $length, $charset );
		}
	}
	if($newStr==''){
	$re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all ( $re [$charset], $str, $match );
	$slice = join ( "", array_slice ( $match [0], $start, $length ) );
	if ($suffix)
		$newStr = $slice;
	}
	return $newStr;
}
function WSTScore($score,$users,$type = 5,$len = 0,$total = 1){
	if((int)$score==0)return $type;
	switch($type){
		case 5:return round($score/$total/$users,0);
		case 10:return round($score/$total*2/$users,$len);
		case 100:return round($score/$total*2/$users,$len);
	}
}
function WSTShopEncrypt($shopId){
	return md5(base64_encode("application".date("Y-m-d").$shopId));
}
/**
 * 根据子分类循环获取其父级分类
 */
function WSTGoodsCatPath($catId, $data = []){
    if($catId==0)return $data;
    $data[] = $catId;
	$parentId = Db::name('goods_cats')->where('catId',$catId)->value('parentId');
	if($parentId==0){
		krsort($data);
		return $data;
	}else{
		return WSTGoodsCatPath($parentId, $data);
	}
}
/**
 * 提供原生分页处理
 */
function WSTPager($total,$rs,$page,$size = 0){
	$pageSize = ($size>0)?$size:config('paginate.list_rows');
	$totalPage = ($total%$pageSize==0)?($total/$pageSize):(intval($total/$pageSize)+1);
	return ['Total'=>$total,'PerPage'=>$pageSize,'CurrentPage'=>$page,'TotalPage'=>$totalPage,'Rows'=>$rs];
}


/**
* 编辑器上传图片
*/
function WSTEditUpload($fromType){
    //PHP上传失败
    if (!empty($_FILES['imgFile']['error'])) {
        switch($_FILES['imgFile']['error']){
            case '1':
                $error = '超过php.ini允许的大小。';
                break;
            case '2':
                $error = '超过表单允许的大小。';
                break;
            case '3':
                $error = '图片只有部分被上传。';
                break;
            case '4':
                $error = '请选择图片。';
                break;
            case '6':
                $error = '找不到临时目录。';
                break;
            case '7':
                $error = '写文件到硬盘出错。';
                break;
            case '8':
                $error = 'File upload stopped by extension。';
                break;
            case '999':
            default:
                $error = '未知错误。';
        }
        return WSTReturn(1,$error);
    }

    $fileKey = key($_FILES);
	$dir = 'image'; // 编辑器上传图片目录
	$dirs = WSTConf("CONF.wstUploads");
   	if(!in_array($dir, $dirs)){
   		return json_encode(['error'=>1,'message'=>'非法文件目录！']);
   	}
   	// 上传文件
    $file = request()->file($fileKey);
    if($file===null){
    	return json_encode(["error"=>1,"message"=>'上传文件不存在或超过服务器限制']);
    }
    $validate = new \think\Validate([
	    ['fileMime','fileMime:image/png,image/gif,image/jpeg,image/x-ms-bmp','只允许上传jpg,gif,png,bmp类型的文件'],
	    ['fileExt','fileExt:jpg,jpeg,gif,png,bmp','只允许上传后缀为jpg,gif,png,bmp的文件'],
	    ['fileSize','fileSize:2097152','文件大小超出限制'],//最大2M
	]);
	$data = ['fileMime'  => $file,
	    	 'fileSize' => $file,
	         'fileExt'=> $file
	        ];
	if (!$validate->check($data)) {
	    return json_encode(['message'=>$validate->getError(),'error'=>1]);
	}
    $info = $file->rule('uniqid')->move(ROOT_PATH.'/upload/'.$dir."/".date('Y-m'));
    if($info){
    	$filePath = $info->getPathname();
    	$filePath = str_replace(ROOT_PATH,'',$filePath);
    	$filePath = str_replace('\\','/',$filePath);
    	$name = $info->getFilename();
    	$imageSrc = trim($filePath,'/');
    	//图片记录
    	WSTRecordImages($imageSrc, (int)$fromType);
    	return json_encode(array('error' => 0, 'url' => $filePath));
	}
}
/**
 * 转义单引号
 */
function WSTHtmlspecialchars($v){
	return htmlspecialchars($v,ENT_QUOTES);
}

/**
* 发送商城消息
* @param int 	$to 接受者d
* @param string $content 内容
* @param array  $msgJson 存放json数据
*/
function WSTSendMsg($to,$content,$msgJson=[],$msgType = 1){
	$message = [];
	$message['msgType'] = $msgType;
	$message['sendUserId'] = 1;
	$message['createTime'] = date('Y-m-d H:i:s');
	$message['msgStatus'] = 0;
	$message['dataFlag'] = 1;

	$message['receiveUserId'] = $to;
	$message['msgContent'] = $content;
	$message['msgJson'] = json_encode($msgJson);
	Db::name('messages')->insert($message);

}

/**
 * 获取分类的佣金
 */
function WSTGoodsCommissionRate($goodsCatId){
	$cats = Db::name('goods_cats')->where('catId',$goodsCatId)->field('parentId,commissionRate')->find();
	if(empty($cats)){
		return 0;
	}else{
		if((float)$cats['commissionRate']>=0)return (float)$cats['commissionRate'];
		return WSTGoodsCommissionRate($cats['parentId']);
	}
}

function WSTFormatIn($split,$str){
	$strdatas = explode($split,$str);
	$data = array();
	for($i=0;$i<count($strdatas);$i++){
		$data[] = (int)$strdatas[$i];
	}
	$data = array_unique($data);
	return implode($split,$data);
}

//获取会员类型名称
function getquname($utype)
{
	if(!$utype){
		return false;
	}

	$name = db('UserRanks')->where(['utype'=>$utype])->value('rankName');

	return $name;
}

/**
 * 获取游戏一个字段信息
 * @author lukui  2017-10-12
 * @return [type] [description]
 */
function getplayonedata($playId,$field)
{
	
	if(!$playId || !$field){
		return false;
	}
	$res = db('play')->where('playId',$playId)->value($field);
	return $res;
}

/**
 * 获取Table数据
 * @author lukui  2017-10-12
 * @param  [type] $tablename 数据表名称
 * @param  [type] $id        id
 * @param  [type] $value     要获取的值
 */
function GetTableValue($tablename,$id,$value,$thisid)
{
	
	$res = db($tablename)->where($thisid,$id)->value($value);
	return $res;
}

//curl获取数据
function curlfun($url, $params = array(), $method = 'GET')
{
	
	$header = array();
	$opts = array(CURLOPT_TIMEOUT => 10, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_HTTPHEADER => $header);

	/* 根据请求类型设置特定参数 */
	switch (strtoupper($method)) {
		case 'GET' :
			$opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
			$opts[CURLOPT_URL] = substr($opts[CURLOPT_URL],0,-1);
			
			break;
		case 'POST' :
			//判断是否传输文件
			$params = http_build_query($params);
			$opts[CURLOPT_URL] = $url;
			$opts[CURLOPT_POST] = 1;
			$opts[CURLOPT_POSTFIELDS] = $params;
			break;
		default :
			
	}

	/* 初始化并执行curl请求 */
	$ch = curl_init();
	curl_setopt_array($ch, $opts);
	$data = curl_exec($ch);
	$error = curl_error($ch);
	curl_close($ch);
	
	if($error){
		$data = null;
	}
	
	return $data;

}

/**
 * 获取本期时时彩期数
 * @author lukui  2017-10-14
 * @return [type] [description]
 */
 
function ssc_sn()
{
	$time = time();
	$str = date('ymd',$time);
	$start_time = strtotime(date('Y-m-d',$time).'7:00:00');
	// 5分钟↓
	$_str = floor(($time-$start_time)/60/5);


	$h = date('H',$time);
	$i = date('i',$time);

	$startdate = "2019-2-15";
	$nowdate = date('Y-m-d', time());

	$date0=floor((strtotime($nowdate)-strtotime($startdate))/86400);

	if($h >= 7 && $h < 23 || $h == 23 && $i < 55){
		$m0 = $date0*203 + 108009135;
		$_str =$m0 + $_str + 1;
	}else{
		$_str = 0;
	}
	
	return $_str;
}
function ssc_sn_20190219()
{
	$time = time();
	$str = date('ymd',$time);
	$start_time = strtotime(date('Y-m-d',$time).' 00:00:00');
	// 5分钟↓
	$_str = (string)ceil(($time-$start_time)/60/5);
	
	if((date('H',$time) == 23 && date('i',$time) >= 55)){
		$_str = 288;
	}elseif((date('H',$time) == 0 &&  date('i',$time) < 5)){
		$_str = 1;
	}

	


	// var_dump($_str);
	// die;

	// $time = time();
	// $start_time = strtotime(date('Y-m-d',$time).' 10:00:00');

	// $str = date('ymd',$time);
	// if(date('H',$time) >= 22){
	// 	$start_time1 = strtotime(date('Y-m-d',$time).' 22:00:00');
	// 	$_str1 = ceil(($start_time1-$start_time)/60/10)+24;
	// 	$_str2 = ceil(($time-$start_time1)/60/5);
	// 	$_str = (string)($_str1 + $_str2);
	// 	if(date('i',$time) % 5 ==0){
	// 		//$_str++;
	// 	}
	// }elseif((date('H',$time) == 23 && date('i',$time) >= 55)){
	// 	$_str = 120;
	// }elseif((date('H',$time) == 0 &&  date('i',$time) < 5)){
	// 	//$str = date('ymd',$time-24*60*60);
	// 	$_str = 1;
	// }elseif(date('H',$time) <= 2){
	// 	$start_time = strtotime(date('Y-m-d',$time));
	// 	$_str = (string)(ceil(($time-$start_time)/60/5));

	// 	if(date('i',$time) % 5 ==0){
	// 		//$_str++;
	// 	}

	// }elseif(date('H',$time) > 2 && date('H',$time) < 10){
	// 	$_str = 24;
	// }else{
	// 	$_str = (string)(ceil(($time-$start_time)/60/10)+24);
	// 	if(date('i',$time) % 10 ==0){
	// 		//$_str++;
	// 	}
	// }
	
	

	if($_str < 10){
		$_str = '00'.$_str;
	}elseif($_str < 100){
		$_str = '0'.$_str;
	}
	
	$sn = $str.$_str;
	return $sn;
}


/**
 * 是否开市
 * @author lukui  2017-12-10
 * @return [type] [description]
 */
function isopen()
{
	$h = date('H');
	$i = date('i');
	$isopen = 1;
	if($h >= 7 && $h < 23 || $h == 23 &&  $i < 55){
		$isopen = 1;
	}else{
		$isopen = 0;
	}
	return $isopen;
}
// function isopen()
// {
// 	$h = date('H');
// 	$i = date('i');
// 	$isopen = 1;
// 	if($h >= 2 && $h <= 9){
// 		if($h == 9 &&  $i > 50){
// 			$isopen = 1;
// 		}else{
// 			$isopen = 0;
// 		}
// 	}
// 	return $isopen;
// }

/**
* 为图片添加水印
* @static public
* @param string $source 原文件名
* @param string $water 水印图片
* @param string $$savename 添加水印后的图片名
* @param string $postion 水印的具体位置 leftbottom rightbottom lefttop righttop center <新增>
* @param string $alpha 水印的透明度
* @return void
*/
function waterpic($source, $water, $savename, $postion, $alpha)
{
	//检查文件是否存在
    if (!file_exists($source) || !file_exists($water)) return false;
    
    //图片信息
    $sInfo = getimagesize($source);
    $wInfo = getimagesize($water);
    

    $sInfo["width"] = $sInfo[0];
    $sInfo["height"] = $sInfo[1];
    $sInfo["type"] = substr($sInfo['mime'],6);

    $wInfo["width"] = $wInfo[0];
    $wInfo["height"] = $wInfo[1];
    $wInfo["type"] = substr($wInfo['mime'],6);


    
    //如果图片小于水印图片，不生成图片
    if ($sInfo["width"] < $wInfo["width"] || $sInfo['height'] < $wInfo['height']) return false; //建立图像 
    $sCreateFun = "imagecreatefrom" . $sInfo['type']; 
    $sImage = $sCreateFun($source);

    $wCreateFun = "imagecreatefrom" . $wInfo['type'];
    $wImage = $wCreateFun($water); //设定图像的混色模式 
    imagealphablending($wImage, true); //图像位置,默认为右下角右对齐
    //$posArr = $this->WaterPostion($postion,$sInfo,$wInfo); //新增
    $posArr = $postion;
    
    imagecopymerge($sImage, $wImage, $posArr[0], $posArr[1], 0, 0, $wInfo['width'], $wInfo['height'], $alpha);

    //输出图像
    $ImageFun = 'Image' . $sInfo['type'];

    //如果没有给出保存文件名，默认为原图像名
    if (!$savename) {
        $savename = $source;
        @unlink($source);
    }
    
    $ImageFun($sImage, $savename);
    imagedestroy($sImage);
}

/**
 * 获取城市列表
 * @author lukui  2017-07-03
 * @return [type] [description]
 */
function getarea($id)
{

	$name = db('areas')->where('id',$id)->value('name');
	return $name;

}

/**
 * 生成随机字符串
 * @author lukui  2017-10-21
 * @param  [type] $len   [description]
 * @param  [type] $chars [description]
 * @return [type]        [description]
 */

function getRandomString($len, $chars=null)  
{  
	/*
    if (is_null($chars)) {  
        $chars[0] = "abcdefghijklmnopqrstuvwxyz";  
        $chars[1] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $chars[2] = "0123456789";
    }  
    $_arr = array(0,1,2);
    
    for ($i = 0, $str = ''; $i < $len; $i++) { 

    	
    	$_num = array_rand($_arr);
    	

	    
	    $str_arr = $chars[$_num];
	    
    	$lc = strlen($str_arr)-1; 
        $str .= $str_arr[mt_rand(0, $lc)];
        unset($_arr[$_num]);
        if(empty($_arr)){
        	$_arr = array(0,1,2);
        }
        
    } 
    */
   	
    $str = rand(100000,999999);
    $isset = db('users')->where(array('usercode'=>$str))->find();
    if($isset){
    	getRandomString($len);
    }else{
    	return ($str);
    }
    
}

function guishu($userId)
{
	$db_users = db('users');
	if(!$userId) return false;
	$users = $db_users->where('userId',$userId)->find();

	if(!$users) return false;
	$_user['par101'] = $db_users->where('userId',$users['par101'])->find();
	$_user['par102'] = $db_users->where('userId',$users['par102'])->find();
	$_user['par103'] = $db_users->where('userId',$users['par103'])->find();
	return $_user;
}

function orderguishu($userId)
{
	$_user = guishu($userId);

	$res = $_user['par101']['userName'].'->'.$_user['par102']['userName'].'->'.$_user['par103']['userName'];
	return $res;
}

//验证红利
//客户不需要，运营中心0-100
function checkhongli($userId,$percent,$uq=0,$data=array(),$thisuser=array())
{

	if($percent <0 || $percent > 100){
		return WSTReturn('红利为100内的正数',-1);

	}
	$db_users = db('users');
	if(!$uq) {
		$uq = $db_users ->where('userId',$userId)->value('uq');
	}
	if(!$data){
		$data = guishu($userId);
	}else{
		if($uq == 103){
			$par102 = $data['par102'];
			unset($data['par102']);
			$data['par102']['userId'] = $par102;
		}
		if($uq == 102){
			$par101 = $data['par101'];
			unset($data['par101']);
			$data['par101']['userId'] = $par101;
		}
		
		
	}

	if(empty($thisuser)){
		//return;
	}

	if($uq == 103 && isset($thisuser['uq']) && $thisuser['uq'] == 103){	//代理商开通代理 看自己是百分之多少
		$daili_max = WSTConf("CONF.daili_max");
		if($daili_max < $percent) return WSTReturn('不得大于直接上级的红利比例：'.$daili_max .'%',-1);
		if($thisuser['percent'] < $percent) return WSTReturn('不得大于直接上级的红利比例：'.$thisuser['percent'] .'%',-1);
	}elseif($uq == 103){	//代理商看他上级是百分之多少
		$daili_max = WSTConf("CONF.daili_max");
		if($daili_max < $percent) return WSTReturn('不得大于直接上级的红利比例：'.$daili_max .'%',-1);
		$user103 = $db_users->where('userId',$data['par102']['userId'])->value('percent');
		if($user103 < $percent) return WSTReturn('不得大于直接上级的红利比例：'.$user103.'%',-1);
	}elseif($uq == 102){	//会员单位看他上级是百分之多少
		$user102 = $db_users->where('userId',$data['par101']['userId'])->value('percent');
		if($user102 < $percent) return WSTReturn('不得大于直接上级的红利比例：'.$user102.'%',-1);
	}elseif($uq == 104 && $percent != 0){
		return WSTReturn('客户红利请输0',-1);
	}
}


function myuids($uid ,$uq ,$usertype=array())
{

	if(!$uid) return false;
	if(!$uq) $uq = Db::name('users')->where('userId',$uid)->value('uq');

	if(!empty($usertype) && is_array($usertype)) $map['uq'] = $usertype;
	$map['par'.$uq] = $uid;
	
	$users = Db::name('users')->field('userId')->where($map)->select();

	$uids[0] = $uid;
	if($users){
		foreach ($users as $k => $v) {
			$uids[$k+1] = $v['userId'];
		}
	}

	return $uids;
}


function getsrc()
{

	$request = request();
    $visit = strtolower($request->module()."/".$request->controller()."/".$request->action());
	return $visit;
}


/**
 * 我的所有上级用户id
 * @param  [type] $userId [description]
 * @return [type]      [description]
 */
function myupoid($userId)
{



	if(!$userId){
		return false;
	}
	$map['userId'] = $userId;
	$map['uq'] = 103;

	$user = db('users')->field('userId,oid,userName,percent')->where($map)->find();

	if($user['userId'] == $user['oid']){
		return false;
	}
	
	$list = array();
	if($user){
		$list[] = $user;

		$user = myupoid($user["oid"]);
		if(is_array($user) && !empty($user)){
			$list = array_merge($list,$user);
		}


	}


	return $list;

}


/**
 * 用户充值总额
 * @author lukui  2017-11-21
 * @param  [type] $uid [description]
 * @return [type]      [description]
 */
function userrech($uid,$where=array())
{
	$where['bptype'] = 1;
	$where['uid'] = $uid;
	

	$sum = db('recharge')->where($where)->sum('bpprice');
	if(!$sum) $sum = 0;
	return $sum;
}
/**
 * 用户提现总额
 * @author lukui  2017-11-21
 * @param  [type] $uid [description]
 * @return [type]      [description]
 */
function usercash($uid,$where=array())
{
	$where['cashSatus'] = 1;
	$where['targetId'] = $uid;
	

	$sum = db('cash_draws')->where($where)->sum('money');
	if(!$sum) $sum = 0;
	return $sum;
}

/**
 * 我的所有上级
 * @author lukui  2017-11-21
 * @param  [type] $uid   [description]
 * @param  [type] $isstr 返回类型 默认 uids 1则返回字符串
 * @return [type]        [description]
 */
function myups($uid,$isstr=0)
{
	if(!$uid) return;
	$uids = upuids($uid);
	if(empty($uids)) return;
	if($isstr == 1){
		krsort($uids);
		$str = '';
		foreach ($uids as $key => $val) {
			$str .= $val["userName"];
			if($key != 0) $str .='->';
		}
		return ($str);
	}else{
		return $uids;
	}
	

}

function upuids($uid)
{
	if(!$uid){
		return false;
	}
	$map['userId'] = $uid;
	

	$user = db('users')->field('userId,oid,userName')->where($map)->find();

	if($user['userId'] == $user['oid']){
		return false;
	}
	
	$list = array();
	if($user){
		$list[] = $user;
		$user = upuids($user["oid"]);
		if(is_array($user) && !empty($user)){
			$list = array_merge($list,$user);
		}


	}


	return $list;

}


function getgoods($goodsId,$value = null)
{
	$goods = db('goods')->where('goodsId',$goodsId)->find();
	if(!$goods) return false;

	if($value){
		return $goods[$value];
	}else{
		return $goods;
	}
}



/**  
 * 获取客户端浏览器信息 添加win10 edge浏览器判断  
 * @param  null   
 * @return string   
 */  
function get_broswer(){  
     $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串  
     if (stripos($sys, "Firefox/") > 0) {  
         preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);  
         $exp[0] = "Firefox";  
         $exp[1] = $b[1];  //获取火狐浏览器的版本号  
     } elseif (stripos($sys, "Maxthon") > 0) {  
         preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);  
         $exp[0] = "傲游";  
         $exp[1] = $aoyou[1];  
     } elseif (stripos($sys, "MSIE") > 0) {  
         preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);  
         $exp[0] = "IE";  
         $exp[1] = $ie[1];  //获取IE的版本号  
     } elseif (stripos($sys, "OPR") > 0) {  
             preg_match("/OPR\/([\d\.]+)/", $sys, $opera);  
         $exp[0] = "Opera";  
         $exp[1] = $opera[1];    
     } elseif(stripos($sys, "Edge") > 0) {  
         //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配  
         preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);  
         $exp[0] = "Edge";  
         $exp[1] = $Edge[1];  
     } elseif (stripos($sys, "Chrome") > 0) {  
             preg_match("/Chrome\/([\d\.]+)/", $sys, $google);  
         $exp[0] = "Chrome";  
         $exp[1] = $google[1];  //获取google chrome的版本号  
     } elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){  
         preg_match("/rv:([\d\.]+)/", $sys, $IE);  
             $exp[0] = "IE";  
         $exp[1] = $IE[1];  
     }else {  
        $exp[0] = "未知浏览器";  
        $exp[1] = "";   
     }  
     return $exp[0].'('.$exp[1].')';  
}  



/**  
 * 获取客户端操作系统信息包括win10  
 * @param  null   
 * @return string   
 */  
function get_os(){  
$agent = $_SERVER['HTTP_USER_AGENT'];  
    $os = false;  
   
    if (preg_match('/win/i', $agent) && strpos($agent, '95'))  
    {  
      $os = 'Windows 95';  
    }  
    else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))  
    {  
      $os = 'Windows ME';  
    }  
    else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))  
    {  
      $os = 'Windows 98';  
    }  
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent))  
    {  
      $os = 'Windows Vista';  
    }  
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent))  
    {  
      $os = 'Windows 7';  
    }  
      else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent))  
    {  
      $os = 'Windows 8';  
    }else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent))  
    {  
      $os = 'Windows 10';#添加win10判断  
    }else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent))  
    {  
      $os = 'Windows XP';  
    }  
    else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent))  
    {  
      $os = 'Windows 2000';  
    }  
    else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent))  
    {  
      $os = 'Windows NT';  
    }  
    else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent))  
    {  
      $os = 'Windows 32';  
    }  
    else if (preg_match('/linux/i', $agent))  
    {  
      $os = 'Linux';  
    }  
    else if (preg_match('/unix/i', $agent))  
    {  
      $os = 'Unix';  
    }  
    else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent))  
    {  
      $os = 'SunOS';  
    }  
    else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent))  
    {  
      $os = 'IBM OS/2';  
    }  
    else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent))  
    {  
      $os = 'Macintosh';  
    }  
    else if (preg_match('/PowerPC/i', $agent))  
    {  
      $os = 'PowerPC';  
    }  
    else if (preg_match('/AIX/i', $agent))  
    {  
      $os = 'AIX';  
    }  
    else if (preg_match('/HPUX/i', $agent))  
    {  
      $os = 'HPUX';  
    }  
    else if (preg_match('/NetBSD/i', $agent))  
    {  
      $os = 'NetBSD';  
    }  
    else if (preg_match('/BSD/i', $agent))  
    {  
      $os = 'BSD';  
    }  
    else if (preg_match('/OSF1/i', $agent))  
    {  
      $os = 'OSF1';  
    }  
    else if (preg_match('/IRIX/i', $agent))  
    {  
      $os = 'IRIX';  
    }  
    else if (preg_match('/FreeBSD/i', $agent))  
    {  
      $os = 'FreeBSD';  
    }  
    else if (preg_match('/teleport/i', $agent))  
    {  
      $os = 'teleport';  
    }  
    else if (preg_match('/flashget/i', $agent))  
    {  
      $os = 'flashget';  
    }  
    else if (preg_match('/webzip/i', $agent))  
    {  
      $os = 'webzip';  
    }  
    else if (preg_match('/offline/i', $agent))  
    {  
      $os = 'offline';  
    }  
    else  
    {  
      $os = '未知操作系统';  
    }  
    return $os;    
}  

/**
 * IP获取城市信息
 * @author lukui  2017-11-24
 * @param  string  $ip  [description]
 * @param  integer $str [description]
 */
function GetIpLookup($ip = '',$str=0){  
    if(empty($ip)){  
        $ip = GetIp();  
    }  
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);  
    if(empty($res)){ return false; }  
    $jsonMatches = array();  
    preg_match('#\{.+?\}#', $res, $jsonMatches);  
    if(!isset($jsonMatches[0])){ return false; }  
    $json = json_decode($jsonMatches[0], true);  
    if(isset($json['ret']) && $json['ret'] == 1){  
        $json['ip'] = $ip;  
        unset($json['ret']);  
    }else{  
        return false;  
    }  
    if($str == 1){
    	return $json['province'].$json['city'];
    }else{
    	return $json; 
    }
    
     
} 

function isMobile()
{
        //return false;
            // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;

        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
                return true;
        }
            // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return 1;
            }
        }
                return 0;
     }


/**
 * 下期时时彩倒计时
 * @author lukui  2017-11-28
 * @param  [type] $type 1日期 2时间戳
 * @return [type]       [description]
 */
function get_ssr_time($type=1)
{
 	//最后一期时时彩
 	$last_ssc = db('play_ssc_data')->order('id desc')->limit(1)->find();
 	//下期时时彩期数
 	$ssc_sn = ssc_sn();
 	
 	/*
 	if( (date('H') >= 22 && date('i') >5) || date('H') <=2 ){
 		$last_time = $last_ssc['date'] + 300;
 	}elseif((date('H') >= 22 && date('i') <=5) || date('H') < 22 && date('H') >= 10 ){
 		$last_time = $last_ssc['date'] + 600;
 	}else{
 		$last_time = strtotime(date('Y-m-d',time()).' 10:00:00');
 	}
 	*/
 
 	$h = date('H');
 	$i = date('i');
 	
 	// if($h >= 22 || $h <= 2){
 		$_i = $i+(5-$i%5);

 		if($_i == 60){
 			$_i = '00';
 			$last_time = strtotime(date('Y-m-d H',time()).':'.$_i.':00');
 			$last_time = $last_time + 3600;
 		}else{
 			$last_time = strtotime(date('Y-m-d H',time()).':'.$_i.':00');
 		}
 		
 	// }else{
 	// 	$last_time = strtotime(date('Y-m-d',time()).' 10:00:00');
 	// }
 	// if($h >= 22 || $h <= 2){
 	// 	$_i = $i+(5-$i%5);

 	// 	if($_i == 60){
 	// 		$_i = '00';
 	// 		$last_time = strtotime(date('Y-m-d H',time()).':'.$_i.':00');
 	// 		$last_time = $last_time + 3600;
 	// 	}else{
 	// 		$last_time = strtotime(date('Y-m-d H',time()).':'.$_i.':00');
 	// 	}
 		
 	// }elseif($h < 22 && $h >= 10){
 	// 	$_i = $i+(10-$i%10);
 		
 	// 	if($_i == 60){
 	// 		$_i = '00';
 	// 		$last_time = strtotime(date('Y-m-d H',time()).':'.$_i.':00');
 	// 		$last_time = $last_time + 3600;
 	// 	}else{
 	// 		$last_time = strtotime(date('Y-m-d H',time()).':'.$_i.':00');
 	// 	}
 		
 	// }else{
 	// 	$last_time = strtotime(date('Y-m-d',time()).' 10:00:00');
 	// }


 	
 	$_TIME = date('Y/m/d H:i',$last_time).':00';
 	
 	
 	
 	if($type == 1){
 		return  $_TIME;
 	}else{
 		return  strtotime($_TIME);
 	}


 	
}

function ssc_list($page = 1)
{
	 //期数
	   $ssc_list = db('play_ssc_data')->order('issue desc')->limit(($page-1)*10,10)->select();
	   if(!$ssc_list) return false;
	   foreach ($ssc_list as $k => $v) {
	        $last1 = substr($v['balls'],-1);
	        $last2 = substr($v['balls'],-2,-1);
	        if($last1 <= 4){
	            $ssc_list[$k]['isxiao'] = '小';
	        }else{
	            $ssc_list[$k]['isxiao'] = '大';
	        }

	        if($last1%2 == 0){
	            $ssc_list[$k]['isdan'] = '双';
	        }else{
	            $ssc_list[$k]['isdan'] = '单';
	        }

	        if($last2 <= 4 && $last1%2 == 0){
	            $ssc_list[$k]['four'] = '小双';
	        }elseif($last2 > 4 && $last1%2 == 0){
	            $ssc_list[$k]['four'] = '大双';
	        }elseif($last2 <= 4 && $last1%2 == 1){
	            $ssc_list[$k]['four'] = '小单';
	        }else{
	            $ssc_list[$k]['four'] = '大单';
	        }
	       
	   }
	   return $ssc_list;
}

/**获取当前时时彩的开奖详情**/
function get_ssc_info($ssc)
{
	
	$last1 = substr($ssc['balls'],-1);
    $last2 = substr($ssc['balls'],-2,-1);
    if($last1 <= 4){
        $ssc['isxiao'] = '小';
    }else{
        $ssc['isxiao'] = '大';
    }

    if($last1%2 == 0){
        $ssc['isdan'] = '双';
    }else{
        $ssc['isdan'] = '单';
    }

    if($last2 <= 4 && $last1%2 == 0){
        $ssc['four'] = '小双';
    }elseif($last2 > 4 && $last1%2 == 0){
        $ssc['four'] = '大双';
    }elseif($last2 <= 4 && $last1%2 == 1){
        $ssc['four'] = '小单';
    }else{
        $ssc['four'] = '大单';
    }

    return $ssc;
    
}

/**
	10人玩法匹配对手买号
	*/
function get_duinum($num=0)
{
	$arr = array(0,1,2,3,4,5,6,7,8,9);

	$rand = rand(0,9);

	$str = $arr[$rand];

	$str = $str%10;

	if($str == $num){
		return get_duinum($num);
	}else{
		return $str;
	}
}

//计算小数点后位数
function getFloatLength($num) {
	$count = 0;

	$temp = explode ( '.', $num );

	if (sizeof ( $temp ) > 1) {
		$decimal = end ( $temp );
		$count = strlen ( $decimal );
	}

	return $count;
}
/**
 * 判断是否微信浏览器
 * @author lukui  2017-07-18
 * @return [type] [description]
 */
function iswechat(){
	if (strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
		return true;
	}else{
		return false;
	}
}
function getuser_photo($path){
	return $path;
	if(@fopen( $path, 'r' )){
		return $path;
	}else{
		return '/'.WSTConf('CONF.userLogo');
	}
}


/**
龙虎玩法匹配对手买号
 */
function get_duilh($num='long')
{
    $arr = array('long','hu','he');

    $rand = rand(0,2);

    $str = $arr[$rand];


    if($str == $num){
        return get_duilh($num);
    }else{
        return $str;
    }
}