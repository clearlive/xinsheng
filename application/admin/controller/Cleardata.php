<?php 
namespace application\admin\controller;

/**
* 清除数据
*/
class Cleardata extends Base
{
	
	public function index()
	{
	

		return $this->fetch();
	}


	/**
	 * 数据备份到服务器
	 * @author lukui  2017-02-17
	 * @return [type] [description]
	 */
	public function backupsbase()
	{

		$type=input("tp");
        $name=input("name");
        $sql=new \org\Baksql(\think\Config::get("database"));
        switch ($type)
        {
        case "backup": //备份
          return $sql->backup();
          break;
        case "dowonload": //下载
          $sql->downloadFile($name);
          break;
        case "restore": //还原
          return $sql->restore($name);
          break;
        case "del": //删除
          return $sql->delfilename($name);
          break;
        default: //获取备份文件列表
            return $this->fetch("db_bak",["list"=>$sql->get_filelist()]);

        }


	}

	public function pageQuery()
	{
		
			$file = $data = array();
		$dir = "./databak/";
		$file = scandir($dir);
		unset($file[0]);
		unset($file[1]);
		$i = 1;
		foreach ($file as $key => $value) {
			$data[$key]['filename'] = $value;
			$data[$key]['id'] = $i;
			$handle = fopen($dir.$value,"r");
			$fstat= fstat($handle);
			$data[$key]['size'] = round($fstat["size"]/1024,2)."kb";
			$data[$key]['time'] = date("Y-m-d H:i:s",$fstat["mtime"]);
			$i++;
		}
		rsort($data);

		$res['Rows'] = $data;
		return $res;

	}

	/**
	 * 清除数据
	 * @author lukui  2017-11-12
	 * @return [type] [description]
	 */
	public function clear()
	{
		
		$post = input('post.');
		if(!$post['ctype']) return WSTReturn('请选择类型');
		if(!$post['stacerateTime']) return WSTReturn('请选择开始时间');
		if(!$post['endcerateTime']) return WSTReturn('请选择结束时间');
		//时间搜索
		$stacerateTime = input('stacerateTime');
		$endcerateTime = input('endcerateTime');

		if($stacerateTime){
			if(!$endcerateTime){
				$endcerateTime = date('Y-m-d H:i:s',time());
			}
			$between['createTime'] = array('between time',array($stacerateTime,$endcerateTime));
		}

		$ids = '';

		//清除
		if($post['ctype'] == 1){
			$ids =db('log_moneys')->where($between)->delete();
			$dbname = 'log_moneys';
		}elseif($post['ctype'] == 2){
			$ids =db('orders')->where($between)->delete();
			$dbname = 'orders';
		}elseif($post['ctype'] == 3){
			$ids =db('order_hebing')->where($between)->delete();
			$dbname = 'order_hebing';
		}elseif($post['ctype'] == 4){
			$ids =db('recharge')->where($between)->delete();
			$dbname = 'recharge';
		}elseif($post['ctype'] == 5){
			$ids =db('cash_draws')->where($between)->delete();
			$dbname = 'cash_draws';
		}else{
			return WSTReturn('非法操作');
		}
		if($ids){
			//清除日志
			
			$_data['userId'] = $this->session['staffId'];
			$_data['stacerateTime'] = $stacerateTime;
			$_data['endcerateTime'] = $endcerateTime;
			$_data['createTime'] = date('Y-m-d H:i:s',time());
			$_data['dbname'] = $dbname;
			db('log_clear')->insert($_data);
			
			return WSTReturn('操作成功',1);
		}else{
			return WSTReturn('操作失败');
		}
		
		//dump($between);
	}


}

 ?>