<?php
namespace application\common\model;
use think\Db;
/**
 
  
 
 

 

 
 * 提现流水业务处理器
 */
class CashDraws extends Base{
     /**
      * 获取列表
      */
      public function pageQuery($targetType,$targetId){
      	  $type = (int)input('post.type',-1);
          $where = [];
          $where['targetType'] = (int)$targetType;
          $where['targetId'] = (int)$targetId;
          if(in_array($type,[0,1]))$where['moneyType'] = $type;
          return $this->where($where)->order('cashId desc')->paginate()->toArray();
      }

      /**
       * 申请提现_old
       */
      public function drawMoney(){
          $userId = (int)session('WST_USER.userId');
          $money = (float)input('money');


          
          $accId = (int)input('accId');

          $charge_type = (int)input('charge_type');

          //提现时间
          
          $cashday = WSTConf("CONF.cashday");
          $cashtime = WSTConf("CONF.cashtime");

          $cashday_arr = explode('-',$cashday);
          $cashtime_arr = explode('-',$cashtime);

          $cashday_arr=array_filter($cashday_arr);
          $cashtime_arr=array_filter($cashtime_arr);

          $cash_time = '周'.str_replace('-','、',$cashday).'；每日'.$cashtime.'点';

          $day = date('w');
          if($day == 0) $day = 7;

          $hour = date('H');

          if(!in_array($day,$cashday_arr)) return WSTReturn('提现时间：'.$cash_time);
          if(count($cashtime_arr) == 2 && ($cashtime_arr[0] >= $hour || $cashtime_arr[1] < $hour) ) return WSTReturn('提现时间：'.$cash_time);

          
          

          $mincash = WSTConf("CONF.mincash");
          $maxcash = WSTConf("CONF.maxcash");
          if($money<$mincash || $money > $maxcash)return WSTReturn('提取金额区间：'.$mincash.'至'.$maxcash);


          if($money<=0)return WSTReturn('提取金额必须大于0');



          //加载提现账号信息
          if($charge_type == 1){
            $acc = Db::name('cash_configs')->alias('cc')
                   ->join('__BANKS__ b','cc.accTargetId=b.bankId')->where(['cc.dataFlag'=>1,'id'=>$accId])
                   ->field('b.bankName,cc.*')->find();
           }else{
              $acc = Db::name('cash_configs')->where(array('id'=>$accId))->find();
              $acc['bankName'] = '支付宝';
           }
          
          if(empty($acc))return WSTReturn('提现账号不存在');
          $areas = model('areas')->getParentNames($acc['accAreaId']);

          //加载用户
          $user = model('users')->get($userId);

          if(isset($user['minMoney']) && $user['userMoney'] - $money < $user['minMoney']){
            return WSTReturn('账户需保留最低金额'.$user['minMoney']);
          }
          
          
          if($money>$user->userMoney)return WSTReturn('提取金额不能大于用户余额');

          //去除手续费
          $tx_fee = WSTConf('CONF.tx_fee');
          $_money = $money;
          //$money = round($money-$tx_fee,2);


          //减去要提取的金额
          $user->userMoney = $user->userMoney-$money;
          $user->lockMoney = $user->lockMoney+$money;
          Db::startTrans();
          try{
             $result = $user->save();
             if(false !==$result){
                //创建提现记录
                $data = [];
                $data['targetType'] = 0;
                $data['targetId'] = $userId;
                $data['money'] = $money;
                $data['accType'] = 3;
                $data['accTargetName'] = $acc['bankName'];
                $data['accAreaName'] = implode('',$areas).$acc['address'];
                $data['accNo'] = $acc['accNo'];
                $data['accUser'] = $acc['accUser'];
                $data['cashSatus'] = 0;
                $data['cash_type'] = $charge_type;
                $data['cashConfigId'] = $accId;
                $data['createTime'] = date('Y-m-d H:i:s');
                $this->save($data);
                $this->cashNo = $this->cashId.(fmod($this->cashId,7));
                $this->save();


                //扣费拼接日志数组
                $lm = [];
                $lm['targetType'] = 6;
                $lm['targetId'] = $userId;
                $lm['dataId'] = $this->cashNo;
                $lm['dataSrc'] = getsrc();
                $lm['remark'] = '提现';
                $lm['moneyType'] = 1;
                $lm['money'] = $_money*(-1);
                $lm['payType'] = 0;
                $lm['createTime'] = date('Y-m-d H:i:s',time());
                db('log_moneys')->insert($lm);


                Db::commit();
                return WSTReturn('提现申请成功，请留意系统信息',1);
             }
          }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('提现申请失败',-1);
          }
          
          

      }


      



     
}
