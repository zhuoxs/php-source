<?php

/**
 * 柚子门店微商城小程序模块小程序接口定义
 *
 * @author 厦门梵挚慧
 * @url
 */

defined('IN_IA') or exit('Access Denied');


class yzcyk_sunModuleWxapp extends WeModuleWxapp
{
    //获取用户是否该门店管理员还是核销员
    public function doPagegetUseridcard(){
        global  $_W,$_GPC;
        $openid=$_GPC['openid'];
        $store_id=$_GPC['store_id'];
        $store=pdo_get('yzcyk_sun_store',array('id'=>$store_id,'uniacid'=>$_W['uniacid'],'openid'=>$openid));
        if($store){
            echo 1;
        }else{
            $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid'=>$_W['uniacid'],'store_id'=>$store_id,'openid'=>$openid,'type'=>1));
            if($hxstaff){
                echo 2;
            }else{
                echo 0;
            }
        }
    }

    //删除核销人员
    public function doPagedelHxstaff(){
        global  $_W,$_GPC;
        $id=$_GPC['id'];
        pdo_delete('yzcyk_sun_hxstaff',array('id'=>$id,'uniacid'=>$_W['uniacid']));
    }
    //添加核销人员
    public function doPagesetHxstaff(){
        global  $_W,$_GPC;
        $openid=$_GPC['openid'];
        $store_id=$_GPC['store_id'];
        $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('type'=>1,'uniacid'=>$_W['uniacid'],'openid'=>$openid,'type'=>1));
        if($hxstaff){
            return $this->result(1,'该用户已经是核销人员');
            exit;
        }
        $hxstaff=array(
            'uniacid'=>$_W['uniacid'],
            'type'=>1,
            'openid'=>$openid,
            'store_id'=>$store_id,
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_hxstaff',$hxstaff);
        echo pdo_insertid();
    }
    //获取选择核销用户
    public function doPagegetUserXz(){
        global  $_W,$_GPC;
        $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        echo json_encode($user);
    }

    //获取核销人员
    public function doPagegetHxstaff(){
        global  $_W,$_GPC;
        $type=$_GPC['type']?$_GPC['type']:1;
        $cond['uniacid']=$_W['uniacid'];
        $cond['type']=$type;
        $cond['store_id']=$_GPC['store_id'];
        $hxstaff=pdo_getall('yzcyk_sun_hxstaff',$cond);
        if(!empty($hxstaff)){
            foreach($hxstaff as &$val){
                $user=pdo_get('yzcyk_sun_user', array('openid' =>$val['openid'],'uniacid' => $_W['uniacid']));
                $val['img']=$user['img'];
                $val['name']=$user['name'];
                $val['user_id']=$user['id'];
            }
        }
        echo json_encode($hxstaff);
    }


    //创建提现
    public function doPagesetWithDraw(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $money=$_GPC['money'];
        $store_id=$_GPC['store_id'];
        $wd_name=$_GPC['wd_name'];
        $wd_phone=$_GPC['wd_phone'];
        //判断商家
        $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$store_id,'openid'=>$openid));
        $withdrawset=pdo_get('yzcyk_sun_withdrawset',array('uniacid'=>$_W['uniacid']));
        if(!$withdrawset){
            return $this->result(1,'请先配置提现设置');
            exit;
        }
        if($withdrawset['is_open']!=1){
            return $this->result(1,'提现申请已关闭不能提现');
            exit;
        }
        if($money<1){
            return $this->result(1,'提现金额最少￥1');
            exit;
        }
        if($money<$withdrawset['min_money']){
            return $this->result(1,'最低提现金额为￥'.$withdrawset['min_money']);
            exit;
        }
        if(!$store){
            return $this->result(1,'商户不存在');
            exit;
        }
        if($store['money']<$money){
            return $this->result(1,'余额不足');
            exit;
        }
        //手续费
        $ratesmoney=0;
        if($withdrawset['wd_wxrates']>0){
            $ratesmoney=sprintf("%.2f",$withdrawset['wd_wxrates']/100*$money);
        }
        //平台抽取
        $paycommission=0;
        $rate=0;
        if($store['ptcc_rate']>0){
            $rate=$store['ptcc_rate'];
        }else if($withdrawset['cms_rates']){
            $rate=$withdrawset['cms_rates'];
        }
        $paycommission=sprintf("%.2f",$rate/100*$money);
        //实际提现金额
        $realmoney=sprintf("%.2f",$money-$ratesmoney-$paycommission);
        if($realmoney<1){
            return $this->result(1,'实际提现金额最少￥1');
            exit;
        }
        //增加提现记录
        $withdraw=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'wd_type'=>1,
            'wd_name'=>$wd_name,
            'wd_phone'=>$wd_phone,
            'money'=>$money,
            'realmoney'=>$realmoney,
            'paycommission'=>$paycommission,
            'ratesmoney'=>$ratesmoney,
            'store_id'=>$store_id,
            'store_name'=>$store['store_name'],
            'add_time'=>time(),
        );
        if($money>$withdrawset['avoidmoney']){
            $withdraw['is_state']=1;
        }else{
            $withdraw['is_state']=0;
        }
        pdo_insert('yzcyk_sun_withdraw',$withdraw);
        $withdraw_id=pdo_insertid();
        //减少商户金额
        pdo_update('yzcyk_sun_store',array('money -='=>$money),array('uniacid'=>$_W['uniacid'],'id'=>$store_id));
        //增加商户金额明细
        $mcd_memo="商家提现-提现总金额:￥$money;支付佣金:￥$paycommission;支付手续费:￥$ratesmoney;实际提现金额:￥$realmoney";
        $mercapdetails=array(
            'uniacid'=>$_W['uniacid'],
            'store_id'=>$store_id,
            'store_name'=>$store['store_name'],
            'mcd_type'=>2,
            'openid'=>$openid,
            'sign'=>2,
            'mcd_memo'=>$mcd_memo,
            'money'=>$money,
            'realmoney'=>$realmoney,
            'paycommission'=>$paycommission,
            'ratesmoney'=>$ratesmoney,
            'wd_id'=>$withdraw_id,
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_mercapdetails',$mercapdetails);
        //修改累计平台信息
        $platform=pdo_get('yzcyk_sun_platform',array('uniacid'=>$_W['uniacid']));
        if($platform){
            pdo_update('yzcyk_sun_platform',array('total_money +='=>$money,'total_realmoney +='=>$realmoney,'total_paycommission +='=>$paycommission,'total_ratesmoney +='=>$ratesmoney),array('uniacid'=>$_W['uniacid']));
        }else{
            $platform=array(
                'uniacid'=>$_W['uniacid'],
                'total_money'=>$money,
                'total_realmoney'=>$realmoney,
                'total_paycommission'=>$paycommission,
                'total_ratesmoney'=>$ratesmoney,
                'add_time'=>time(),
            );
            pdo_insert('yzcyk_sun_platform',$platform);
        }
        $withdraw=pdo_get('yzcyk_sun_withdraw',array('uniacid'=>$_W['uniacid'],'id'=>$withdraw_id));
        $arr=$this->tixian($withdraw);
        if($withdraw['is_state']==1){
             $msg['errmsg']='提现申请已提交,请等待审核';
        }else if($withdraw['is_state']==0){
             if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
                 $msg['errmsg']='提现成功请在微信钱包查看。';
             }else{
                 $msg['errmsg']='提现失败，原因'.$arr['err_code_des'].'请联系平台管理人员';
                 //提现失败返还
                 //增加商户金额
                 pdo_update('yzcyk_sun_store',array('money +='=>$money),array('uniacid'=>$_W['uniacid'],'id'=>$store_id));
                 //更新提现状态
                 pdo_update('yzcyk_sun_withdraw',array('return_status'=>1,'return_time'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw_id));
                 //增加商户金额明细
                 $mcd_memo="商家提现失败返还-提现总金额:￥$money;支付佣金:￥$paycommission;支付手续费:￥$ratesmoney;实际提现金额:￥$realmoney";
                 $mercapdetails=array(
                     'uniacid'=>$_W['uniacid'],
                     'store_id'=>$store_id,
                     'store_name'=>$store['store_name'],
                     'mcd_type'=>5,
                     'openid'=>$openid,
                     'sign'=>1,
                     'mcd_memo'=>$mcd_memo,
                     'money'=>$money,
                     'realmoney'=>$realmoney,
                     'paycommission'=>$paycommission,
                     'ratesmoney'=>$ratesmoney,
                     'wd_id'=>$withdraw_id,
                     'add_time'=>time(),
                 );
                 pdo_insert('yzcyk_sun_mercapdetails',$mercapdetails);

             }
        }
        echo json_encode($msg);
    }


    private function tixian($withdraw){
        global $_W;
        if($withdraw['is_state']==1){
            return false;
            exit;
        }
        if($withdraw['status']==1){
            return false;
            exit;
        }
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['mch_appid']=$system['appid'];
        $data['mchid'] =$system['mchid'];
        $data['nonce_str']=$this->createNoncestr();
        $data['partner_trade_no']=date("YmdHis") .rand(11111, 99999);
        $data['openid']=$withdraw['openid'];
        $data['check_name']='NO_CHECK';
        $data['amount']=$withdraw['realmoney']*100;
        $data['desc']='提现';
        $data['spbill_create_ip']=$_SERVER['REMOTE_ADDR'];
        $data['sign']=$this->getSign($data,$system['wxkey']);
        $xml=$this->postXmlCurl($data,$url);
        //保存报文信息
        pdo_update('yzcyk_sun_withdraw',array('baowen'=>$xml),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']));
        //添加报文记录
        $baowen=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$withdraw['openid'],
            'store_id'=>$withdraw['store_id'],
            'money'=>$withdraw['realmoney'],
            'baowen'=>$xml,
            'wd_id'=>$withdraw['id'],
            'add_time'=>time(),
            'request_data'=>json_encode($data),
        );
        pdo_insert('yzcyk_sun_withdraw_baowen',$baowen);
        //更改提现状态 商家明显提现状态
        $arr=xml2array($xml);
        if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
            pdo_update('yzcyk_sun_withdraw',array('status'=>1,'tx_time'=>time(),'request_time'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']));
            pdo_update('yzcyk_sun_mercapdetails',array('status'=>1),array('uniacid'=>$_W['uniacid'],'wd_id'=>$withdraw['id']));
        }else{
            pdo_update('yzcyk_sun_withdraw',array('status'=>2,'request_time'=>time(),'err_code'=>$arr['err_code'],'err_code_des'=>$arr['err_code_des']),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']));
            pdo_update('yzcyk_sun_mercapdetails',array('status'=>2),array('uniacid'=>$_W['uniacid'],'wd_id'=>$withdraw['id']));
        }
        return $arr;

    }

    //获取提现设置信息
    public function doPagegetWithDrawSet(){
        global $_W;
        $withdrawset=pdo_get('yzcyk_sun_withdrawset',array('uniacid'=>$_W['uniacid']));
        echo json_encode($withdrawset);
    }


    //获取入驻价格信息
    public function doPagegetStorelimit(){
        global $_W, $_GPC;
        $storelimit=pdo_getall('yzcyk_sun_storelimit',array('uniacid'=>$_W['uniacid']));
        echo json_encode($storelimit);
    }
    //激活码激活
    public function doPageuseActivationCode(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $code=$_GPC['code'];
        $activationcode=pdo_get('yzcyk_sun_activationcode',array('uniacid'=>$_W['uniacid'],'code'=>$code));
        if(empty($activationcode)){
            return $this->result(1,'激活码错误');
            exit;
        }
        if($activationcode['is_use']==1){
            return $this->result(1,'激活码已使用');
            exit;
        }
        //更新码状态
        pdo_update('yzcyk_sun_activationcode',array('use_time'=>time(),'is_use'=>1,'openid'=>$openid),array('id'=>$activationcode['id']));
        $data=array(
            'names'=>$_GPC['names'],
            'phone'=>$_GPC['phone'],
            'address'=>$_GPC['address'],
            'getPunchTaskDetail'=>$_GPC['address_detail'],
        );
        //更新车友卡信息
        pdo_update('yzcyk_sun_user',$data,array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        if($user['end_time']>time()){
            $begin_time=$user['end_time'];
            $end_time=intval(intval($begin_time)+60*60*24*$activationcode['num']);
            $end_time=strtotime(date('Y-m-d 23:59:59',$end_time));
        }else{
            $begin_time=time();
            $end_time=intval(intval($begin_time)+60*60*24*$activationcode['num']);
            $end_time=strtotime(date('Y-m-d 23:59:59',$end_time));
        }
        pdo_update('yzcyk_sun_user',array('is_vip'=>1,'end_time'=>$end_time),array('id'=>$user['id']));
        $vip_record=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'begin_time'=>$begin_time,
            'end_time'=>$end_time,
            'activationcode_id'=>$activationcode['id'],
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_vip_record',$vip_record);
        echo 1;

    }
    //活动商家入驻
    public function doPagesetStore(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $store_name=$_GPC['store_name'];
        $tel=$_GPC['tel'];
        $address=$_GPC['address'];
        $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'pay_status'=>1));
        if($store['pay_status']==1){
            return $this->result(1,'您已提交入驻信息,请等待审核');
            exit;
        }
        if($store['rz_status']==1){
            return $this->result(1,'您已经是入驻商家，直接从管理入口进入');
            exit;
        }
        if($store){
           // return $this->result(1,'用户只有一次申请入驻机会，请等待审核，如需入驻请联系客服');
           // exit;
            $data=array(
                'store_name'=>$store_name,
                'tel'=>$tel,
                'address'=>$address,
                'edit_time'=>time(),
                'storelimit_id'=>$_GPC['storelimit_id'],
            );
            pdo_update('yzcyk_sun_store',$data,array('id'=>$store['id']));
            $store_id=$store['id'];
        }else{
            $store=array(
                'uniacid'=>$_W['uniacid'],
                'openid'=>$openid,
                'store_name'=>$store_name,
                'tel'=>$tel,
                'address'=>$address,
                'add_time'=>time(),
                'storelimit_id'=>$_GPC['storelimit_id'],
            );
            pdo_insert('yzcyk_sun_store',$store);
            $store_id=pdo_insertid();
        }
        $storelimit=pdo_get('yzcyk_sun_storelimit',array('id'=>$_GPC['storelimit_id']));
        $order=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'orderformid'=>date("YmdHis") .rand(11111, 99999),//订单号
            'order_amount'=>$storelimit['money'],
            'order_lid'=>4,
            'pay_type'=>1,
            'store_id'=>$store_id,
            'storelimit_id'=>$_GPC['storelimit_id'],
        );
        pdo_insert('yzcyk_sun_order',$order);
        $order_id=pdo_insertid();
        echo $order_id;
    }
    //领取奖品
    public function doPagesetPunchReceiveRecord(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $task_id=$_GPC['task_id'];
        $prize_id=$_GPC['prize_id'];
        $task=pdo_get('yzcyk_sun_punch_task',array('uniacid'=>$_W['uniacid'],'id'=>$task_id));

        $prize=pdo_get('yzcyk_sun_punch_prize',array('uniacid'=>$_W['uniacid'],'id'=>$prize_id));
        if(empty($task)||empty($prize)){
            return $this->result(1,'系统错误');
            exit;
        }
        //判断能不能领取
        if($task['wc_num']<$prize['prize_day']){
            return $this->result(1,'没有完成任务不能领取奖励');
            exit;
        }
        //判断有没有领取过
        $receive=pdo_get('yzcyk_sun_punch_receive_record',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'task_id'=>$task_id,'prize_id'=>$prize_id));
        if($receive){
            return $this->result(1,'你已领取过');
            exit;
        }
        $coupon=pdo_get('yzcyk_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$prize['coupon_id'],'state' => 1));
        if(empty($coupon)){
            return $this->result(1, '优惠券不存在或已禁用' );
            exit;
        }
        if($coupon['num']-$coupon['yl_num']<=0){
            return $this->result(0, '优惠券已领光' );
            exit;
        }
        //领取到个人优惠券
        $orderfomrid=date("YmdHis") .rand(11111, 99999);
        $data=array(
            'uniacid'=>$_W['uniacid'],
            'uid'=>$openid,
            'store_id'=>$coupon['store_id'],
            'coupon_id'=>$prize['coupon_id'],
            'title'=>$coupon['title'],
            'sign'=>$coupon['sign'],
            'type'=>$coupon['type'],
            'm_price'=>$coupon['m_price'],
            'mj_price'=>$coupon['mj_price'],
            'lq_time'=>time(),
            'end_time'=>time()+$coupon['expiry_day']*60*60*24,
            'source'=>2,
            'orderformid'=>$orderfomrid,
        );
        //生成二维码
        $qrcode_path=$this->setEwm('1-'.$orderfomrid);
        $data['qrcode_path']=$qrcode_path;
        pdo_insert('yzcyk_sun_user_coupon', $data);
        $user_coupon_id=pdo_insertid();
        pdo_update('yzcyk_sun_coupon',array('yl_num +='=>1),array('id'=>$prize['coupon_id']));
        //增加记录
        $receive_record=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'task_id'=>$task_id,
            'prize_id'=>$prize_id,
            'day_num'=>$prize['prize_day'],
            'title'=>$coupon['title'],
            'store_id'=>$coupon['store_id'],
            'coupon_id'=>$coupon['id'],
            'add_time'=>time(),
            'user_coupon_id'=>$user_coupon_id,
        );
        pdo_insert('yzcyk_sun_punch_receive_record',$receive_record);
        echo 1;
    }
    //获取打卡日记
    public function doPagegetMyPunchRecord(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $task_id=$_GPC['task_id'];
        $task=pdo_get('yzcyk_sun_punch_task',array('uniacid'=>$_W['uniacid'],'id'=>$task_id,'openid'=>$openid));
        $baby=pdo_get('yzcyk_sun_baby',array('uniacid'=>$_W['uniacid'],'id'=>$task['baby_id']));
        $task['baby_name']=$baby['name'];
        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
        $record=pdo_getall('yzcyk_sun_punch_record',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'task_id'=>$task_id),array(),'','id desc',$limit);
        foreach($record as &$val){
            $val['punch_pic_arr']=explode(',',$val['punch_pic']);
        }
        $task['record']=$record;
        echo json_encode($task);
    }
    //创建打卡记录
    public function doPagesetPunchRecord(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $task_id=$_GPC['task_id'];
        $cond=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'task_id'=>$task_id,
            'year'=>date('Y'),
            'month'=>date('m'),
            'date'=>date('d'),
        );
        $record=pdo_get('yzcyk_sun_punch_record',$cond);
        if($record){
            return $this->result(1,'今日已打卡');
            exit;
        }
        $task=pdo_get('yzcyk_sun_punch_task',array('uniacid'=>$_W['uniacid'],'id'=>$task_id));
        if($task['wc_num']>=$task['task_num']){
            return $this->result(1,'你已完成目标,请不要打卡');
            exit;
        }
        $record=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'task_id'=>$task_id,
            'year'=>date('Y'),
            'month'=>date('m'),
            'date'=>date('d'),
            'punch_date'=>date('Y-m-d'),
            'punch_diary'=>$_GPC['punch_diary'],
            'punch_pic'=>$_GPC['punch_pic'],
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_punch_record',$record);
        //增加任务完成数加1
        pdo_update('yzcyk_sun_punch_task',array('wc_num +='=>1),array('uniacid'=>$_W['uniacid'],'id'=>$task_id));
        echo 1;

    }
    //获取领取礼物详情
    public function doPagegetReceivePunchPrizeDetail(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $task_id=$_GPC['task_id'];
        $prize_id=$_GPC['prize_id'];
        /*$task=pdo_get('yzcyk_sun_punch_task',array('uniacid'=>$_W['uniacid'],'id'=>$task_id));
        $prize=pdo_getall('yzcyk_sun_punch_prize',array('uniacid'=>$_W['uniacid'],'punch_id'=>$task['punch_id'],'task_day_id'=>$task['task_day_id']));
        if($prize['id']!=$prize_id){
            return $this->result(1,'系统错误');
            exit;
        }*/
        $prize=pdo_get('yzcyk_sun_punch_prize',array('uniacid'=>$_W['uniacid'],'id'=>$prize_id,'state'=>1));
        $coupon=pdo_get('yzcyk_sun_coupon',array('id'=>$prize['coupon_id']));
        $coupon['start_time_d']=date('Y-m-d',$coupon['start_time']);
        $coupon['end_time_d']=date('Y-m-d',$coupon['end_time']);
        $prize['coupon']=$coupon;
        $receive_record=pdo_get('yzcyk_sun_punch_receive_record',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'task_id'=>$task_id,'prize_id'=>$prize_id));
        if($receive_record){
            $prize['receive_status']=1;
            $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$receive_record['user_coupon_id']));
            $prize['begin_time_d']=date('Y-m-d',$user_coupon['lq_time']);
            $prize['end_time_d']=date('Y-m-d',$user_coupon['end_time']);
        }else{
            $prize['receive_status']=0;
        }
        echo json_encode($prize);
    }
    //获取创建任务详情和打卡信息
    public function doPagegetPunchTaskDetail(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $task_id=$_GPC['task_id'];
        $year=$_GPC['year'];
        $month=$_GPC['month'];
        $task=pdo_get('yzcyk_sun_punch_task',array('uniacid'=>$_W['uniacid'],'id'=>$task_id,'openid'=>$openid));
        $record=pdo_getall('yzcyk_sun_punch_record',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'task_id'=>$task_id,'year'=>$year,'month'=>$month),array(),'','id desc');
        foreach($record as &$val){
            $val['isSignIn']=true;
        }
        $task['record']=$record;
        $prize=pdo_getall('yzcyk_sun_punch_prize',array('uniacid'=>$_W['uniacid'],'punch_id'=>$task['punch_id'],'task_day_id'=>$task['task_day_id'],'state'=>1));

        foreach($prize as &$v){
            $receive_record=pdo_get('yzcyk_sun_punch_receive_record',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'task_id'=>$task_id,'prize_id'=>$v['id']));
            if($receive_record){
                $v['receive_status']=1;
                $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$receive_record['user_coupon_id']));
                $v['coupon_title']=$user_coupon['title'];
                $v['begin_time_d']=date('Y-m-d',$user_coupon['lq_time']);
                $v['end_time_d']=date('Y-m-d',$user_coupon['end_time']);
            }else{
                $v['receive_status']=0;
            }
        }
        $task['prize']=$prize;
        $task['baby_name']=pdo_getcolumn('yzcyk_sun_baby',array('uniacid'=>$_W['uniacid'],'id'=>$task['baby_id']),'name',1);
        echo json_encode($task);

    }
    //获取自己创建任务列表
    public function doPagegetMyPunchTaskList(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
        $task=pdo_getall('yzcyk_sun_punch_task',array('uniacid'=>$_W['uniacid'],'openid'=>$openid),array(),'','id desc',$limit);
        foreach($task as &$val){
            $val['wc_rate']=sprintf("%.2f",$val['wc_num']/$val['task_num']);
        }
        echo json_encode($task);
    }
    //创建任务目标
    public function doPagesetPunchTask(){
        global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $punch_id=$_GPC['punch_id'];
        $task_day_id=$_GPC['task_day_id'];
        $baby_id=$_GPC['baby_id'];
        $content=$_GPC['content'];
        $punch=pdo_get('yzcyk_sun_punch',array('uniacid'=>$_W['uniacid'],'id'=>$punch_id));
        $task_day=$this->getTaskNumByTaskDayId();
        $task=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'punch_id'=>$punch_id,
            'task_day_id'=>$task_day_id,
            'baby_id'=>$baby_id,
            'title'=>$punch['title'],
            'content'=>$content,
            'pic'=>$punch['pic'],
            'add_time'=>time(),
            'add_time_d'=>date('Y-m-d'),
            'task_num'=>$task_day['value'],
        );
        pdo_insert('yzcyk_sun_punch_task',$task);
        $id=pdo_insertid();
        echo 1;
    }
    //获取任务天数id对应任务天数
    private function getTaskNumByTaskDayId(){
        global $_W, $_GPC;
        $task_day=require_once 'inc/web/wxapp_task_day_config.php';
        $result = array_filter($task_day,function($v){
            global  $_GPC;
            if($v['id']==$_GPC['task_day_id']){
                return 1;
            }
        });
        $num=intval(array_keys($result)[0]);
        $result=$result[$num];
        return $result;
    }
    //获取任务详情
    public function doPagegetPunchDetail(){
        global $_W, $_GPC;
        $id=$_GPC['id'];
        $punch=pdo_get('yzcyk_sun_punch',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $task_day=require_once 'inc/web/wxapp_task_day_config.php';
        $punch['task_day']=$task_day;
        echo json_encode($punch);
    }
    //获取获取任务信息列表
    public function doPagegetPunchList(){
        global $_W, $_GPC;
        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
        $punch=pdo_getall('yzcyk_sun_punch',array('uniacid'=>$_W['uniacid']),array(),'','id desc',$limit);
        echo json_encode($punch);
    }
    //收藏和取消收藏故事会
    public function doPagesetStoryCollection(){
        global $_W, $_GPC;
        $id=$_GPC['id'];
        $openid=$_GPC['openid'];
        $collection=pdo_get('yzcyk_sun_story_collection',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'story_id'=>$id));
        if($collection['collect_status']==1){
            //取消收藏
            pdo_update('yzcyk_sun_story_collection',array('collect_status'=>0,'edit_time'=>time()),array('id'=>$collection['id']));
        }else{
            //收藏
            if(empty($collection)){
                $collection=array(
                    'uniacid'=>$_W['uniacid'],
                    'openid'=>$openid,
                    'story_id'=>$id,
                    'collect_status'=>1,
                    'add_time'=>1,
                );
                pdo_insert('yzcyk_sun_story_collection',$collection);
            }else{
                pdo_update('yzcyk_sun_story_collection',array('collect_status'=>1,'edit_time'=>time()),array('id'=>$collection['id']));
            }
        }
        echo 1;
    }

    //获取故事会详情页其他故事列表信息
    public function doPagegetStoryList(){
        global $_W, $_GPC;
        $id=$_GPC['id'];
        $openid=$_GPC['openid'];
        $cond['uniacid']=$_W['uniacid'];
        $story=pdo_get('yzcyk_sun_story',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $cond['album_id']=$story['album_id'];
        if($this->doPagecheckVipReturn()==0){
            $cond['is_vip']=0;
        }
        $story=pdo_getall('yzcyk_sun_story',$cond);
        echo json_encode($story);

    }
    //获取故事会信息
    public function doPagegetStory(){
        global $_W, $_GPC;
        $id=$_GPC['id'];
        $openid=$_GPC['openid'];
        $story=pdo_get('yzcyk_sun_story',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        pdo_update('yzcyk_sun_story',array('access_num +='=>1),array('uniacid'=>$_W['uniacid'],'id'=>$id));
        if($story['album_id']>0){
            pdo_update('yzcyk_sun_story_album',array('access_num +='=>1),array('uniacid'=>$_W['uniacid'],'id'=>$story['album_id']));
        }
        $story=pdo_get('yzcyk_sun_story',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $collection=pdo_get('yzcyk_sun_story_collection',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'story_id'=>$id));
        if($collection['collect_status']==1){
            $story['is_collect']=1;
        }else{
            $story['is_collect']=0;
        }
        echo json_encode($story);
    }
    //获取专辑信息
    public function doPagegetStoryAlbum(){
        global $_W, $_GPC;
        $id=$_GPC['id'];
        $album=pdo_get('yzcyk_sun_story_album',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $album['story']=pdo_getall('yzcyk_sun_story',array('uniacid'=>$_W['uniacid'],'album_id'=>$id));
        echo json_encode($album);
    }
    //获取分类下车友卡vip下专辑和故事
    public function doPagegetCategoryVipStory(){
        global $_W, $_GPC;
      /*  $category_id=$_GPC['catgory_id'];
        $cond=array();
        $cond['uniacid']=$_W['uniacid'];
        $cond['show_index']=0;
        $cond['show_st']=0;
        $cond['is_vip']=1;
        if($category_id){
            $cond['category_id']=$category_id;
        }
        $album=pdo_getall('yzcyk_sun_story_album',array('uniacid'=>$_W['uniacid'],'show_index'=>0,'show_st'=>1,'is_vip'=>0),array(),'','id desc','limit 2');
        $story=pdo_getall('yzcyk_sun_story',array('uniacid'=>$_W['uniacid'],'show_index'=>0,'show_st'=>1,'is_vip'=>0,'is_album'=>0),array(),'','id desc','limit 1');
        $data=array(
            'album'=>$album,
            'story'=>$story,
        );
        echo json_encode($data);*/
        $category_id=$_GPC['catgory_id'];
        $where=" a.uniacid={$_W['uniacid']} ";
        $where.=" and a.state=2 and a.is_vip=1 ";
        if($category_id){
            $where.=" and a.category_id=$category_id ";
        }
        $keyword=$_GPC['keyword'];
        $where1='';
        $where2='';
        if($keyword){
            $where1=" and a.title like '%$keyword%' ";
            $where2=" and b.title like '%$keyword%' ";
        }
        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
        $sql="SELECT * from ((SELECT a.id,a.uniacid,a.category_id,a.album_id,a.title,a.pic,a.is_album,a.access_num,a.file_path,a.file_link,a.sort,b.pic as album_pic,b.title as album_title,b.access_num as album_access_num from ims_yzcyk_sun_story a 
LEFT JOIN ims_yzcyk_sun_story_album b on a.album_id=b.id where $where  $where1  and a.album_id=0) UNION (SELECT a.id,a.uniacid,a.category_id,a.album_id,a.title,a.pic,a.is_album,a.access_num,a.file_path,a.file_link,a.sort,b.pic as album_pic,b.title as album_title,b.access_num as album_access_num from ims_yzcyk_sun_story a 
LEFT JOIN ims_yzcyk_sun_story_album b on a.album_id=b.id where $where $where2  and a.album_id>0 GROUP BY a.album_id)) as c ORDER BY c.sort desc,c.id desc $limit";
        $store = pdo_fetchall($sql);

        foreach($store as &$val){
            if(empty($val['access_num'])){
                $val['access_num']=0;
            }
            if(empty($val['album_access_num'])){
                $val['album_access_num']=0;
            }
        }
        echo json_encode($store);
    }
    //获取故事会分类信息
    public function doPagegetStoryCategory(){
        global $_W, $_GPC;
        $category=pdo_getall('yzcyk_sun_story_category',array('uniacid'=>$_W['uniacid']));
        echo json_encode($category);
    }
    //获取故事会页试听专辑和故事
    public function doPagegetStoryStStory(){
        global $_W, $_GPC;
      /*  $album=pdo_getall('yzcyk_sun_story_album',array('uniacid'=>$_W['uniacid'],'show_index'=>0,'show_st'=>1,'is_vip'=>0),array(),'','id desc','limit 2');
        $story=pdo_getall('yzcyk_sun_story',array('uniacid'=>$_W['uniacid'],'show_index'=>0,'show_st'=>1,'is_vip'=>0,'is_album'=>0,'state'=>2),array(),'','id desc','limit 1');
        $data=array(
            'album'=>$album,
            'story'=>$story,
        );*/
        $where=" a.uniacid={$_W['uniacid']} ";
        $show_index=$_GPC['show_index']?1:0;
        if($show_index>0){
            $where.=" and a.state=2 and a.is_vip=0 and a.show_index=1 ";
            $where1=" and b.is_vip=0 and b.show_index=1 ";
        }else{
            $where.=" and a.state=2 and a.is_vip=0";
            $where1=" and b.is_vip=0";
        }

        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
        $sql="SELECT * from ((SELECT a.id,a.uniacid,a.category_id,a.album_id,a.title,a.pic,a.is_album,a.access_num,a.file_path,a.file_link,a.sort,b.pic as album_pic,b.title as album_title,b.access_num as album_access_num from ims_yzcyk_sun_story a 
LEFT JOIN ims_yzcyk_sun_story_album b on a.album_id=b.id where $where and a.album_id=0) UNION (SELECT a.id,a.uniacid,a.category_id,a.album_id,a.title,a.pic,a.is_album,a.access_num,a.file_path,a.file_link,a.sort,b.pic as album_pic,b.title as album_title,b.access_num as album_access_num from ims_yzcyk_sun_story a 
LEFT JOIN ims_yzcyk_sun_story_album b on a.album_id=b.id where $where  $where1  and a.album_id>0 GROUP BY a.album_id)) as c ORDER BY c.sort desc,c.id desc $limit";
        $store = pdo_fetchall($sql);
        foreach($store as &$val){
            if(empty($val['access_num'])){
                $val['access_num']=0;
            }
            if(empty($val['album_access_num'])){
                $val['album_access_num']=0;
            }
        }
        echo json_encode($store);
    }
    //获取首页试听专辑和故事
    public function doPagegetIndexStStory(){
        global $_W, $_GPC;
        $album=pdo_getall('yzcyk_sun_story_album',array('uniacid'=>$_W['uniacid'],'show_index'=>1,'is_vip'=>0),array(),'','id desc','limit 2');
        $story=pdo_getall('yzcyk_sun_story',array('uniacid'=>$_W['uniacid'],'show_index'=>1,'is_vip'=>0,'is_album'=>0,'state'=>2),array(),'','id desc','limit 1');
        $data=array(
             'album'=>$album,
             'story'=>$story,
        );
        echo json_encode($data);
    }

    //删除订单
    public function doPagedelOrder(){
        global $_W, $_GPC;
        $uid=$_GPC['openid'];
        $order_id=$_GPC['order_id'];
        $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$order_id,'openid'=>$uid));
        if($order['order_status']!=3&&$order['order_status']!=7){
            return $this->result(1,'订单不能删除');
            exit;
        }
        if(empty($order)){
            return $this->result(1,'订单错误');
            exit;
        }
        pdo_update('yzcyk_sun_order',array('del_status'=>1,'del_time'=>time()),array('id'=>$order_id));
        echo 1;
    }

    //取消订单
    public function doPagecancelOrder(){
        global $_W, $_GPC;
        $uid=$_GPC['openid'];
        $order_id=$_GPC['order_id'];
        $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$order_id,'openid'=>$uid));
        if($order['pay_status']==1){
            return $this->result(1,'订单已支付不能取消订单');
            exit;
        }
        if(empty($order)){
            return $this->result(1,'订单错误');
            exit;
        }
        pdo_update('yzcyk_sun_order',array('order_status'=>7,'cancel_time'=>time()),array('id'=>$order_id));
        echo 1;
    }

    //获取订单详细信息
    public function doPagegetOrderDetail(){
        global $_W, $_GPC;
        $id=$_GPC['id'];
        $uid=$_GPC['openid'];
        $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$id,'openid'=>$uid));
        if($order){
            $order['detail']=pdo_getall('yzcyk_sun_order_detail',array('uniacid'=>$_W['uniacid'],'order_id'=>$order['id']));
            $order['add_time_d']=date('Y-m-d H:i',$order['add_time']);
            if(!empty($order['qrcode_path'])&&$order['pay_status']==1){
                $dir=IA_ROOT . '/attachment/.'.$order['qrcode_path'];
                if (!file_exists($dir)){
                    $qrcode_path=$this->setEwm('2-'.$order['orderformid']);
                    $order['qrcode_path']=$qrcode_path;
                    pdo_update('yzqzk_sun_order',array('qrcode_path'=>$qrcode_path),array('id'=>$id));
                }
            }
            if($order['pay_status']==1&&empty($order['qrcode_path'])){
                $qrcode_path=$this->setEwm('2-'.$order['orderformid']);
                $order['qrcode_path']=$qrcode_path;
                pdo_update('yzcyk_sun_order',array('qrcode_path'=>$qrcode_path),array('id'=>$id));
            }
            $order['pay_time_d']= $order['pay_time']?date('Y-m-d H:i',$order['pay_time']):'';
            $order['fahuo_time_d']=$order['fahuo_time']?date('Y-m-d H:i',$order['fahuo_time']):'';
            $order['queren_time_d']= $order['queren_time']?date('Y-m-d H:i',$order['queren_time']):'';
            if($order['activity_id']>0){
              $order['end_time_d']=pdo_getcolumn('yzcyk_sun_activity',array('uniacid'=>$_W['uniacid'],'id'=>$order['activity_id']),'hdendtime',1);
            }
        }
        return $this->result(0,'',$order);
    }

    //获取我的订单
    public function doPagegetMyOrder(){
        global $_W, $_GPC;
        $uid=$_GPC['openid'];
        $order_sign=$_GPC['order_sign'];
        if($order_sign==1){
            $cond['order_status']=0;
        }else if($order_sign==2){
            $cond['order_status']=1;
        }else if($order_sign==3){
            $cond['order_status']=3;
        }
        $cond['openid']=$uid;
        $cond['order_lid']=array(2,3);
        $cond['del_status']=0;
        $cond['uniacid']=$_W['uniacid'];
        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
        $order=pdo_getall('yzcyk_sun_order',$cond,array(),'','id desc',$limit);
        if($order){
            foreach($order as $k=>&$val){
                $val['detail']=pdo_getall('yzcyk_sun_order_detail',array('uniacid'=>$_W['uniacid'],'order_id'=>$val['id']));
            }
        }
        echo json_encode($order);
    }



    //获取我的优惠券详情
    public function doPagegetCouponDetail(){
        global $_W, $_GPC;
        $uid=$_GPC['openid'];
        $id=$_GPC['id'];
        if($uid){
            $cond['uid']=$uid;
        }
        $cond['id']=$id;
        $cond['uniacid']=$_W['uniacid'];
        $coupon=pdo_get('yzcyk_sun_user_coupon',$cond);
        $coupon['time']=date('Y.m.d H:i:s',$coupon['lq_time']).'-'.date('Y.m.d H:i:s',$coupon['end_time']);
        $coupon['remark']=pdo_getcolumn('yzcyk_sun_coupon', array('id' =>$coupon['coupon_id'],'uniacid' => $_W['uniacid']), 'remark',1);
        $coupon['info']=pdo_getcolumn('yzcyk_sun_coupon', array('id' =>$coupon['coupon_id'],'uniacid' => $_W['uniacid']), 'info',1);
        return $this->result(0,'',$coupon);
    }
    //获取用户可以使用的优惠券
    public function doPagegetUserCoupon(){
        global $_W, $_GPC;
        $uid=$_GPC['openid'];
        $m_price=$_GPC['m_price'];
        $store_id=$_GPC['store_id'];
        $user_coupon=pdo_getall('yzcyk_sun_user_coupon', array('uniacid' => $_W['uniacid'], 'uid' => $uid,'is_use'=>0,'m_price <='=>$m_price,'end_time >='=>time(),'store_id'=>$store_id,'type'=>1));
        foreach($user_coupon as &$val){
            $val['lq_time_d']=date('Y.m.d H:i:s',$val['lq_time']);
            $val['end_time_d']=date('Y.m.d H:i:s',$val['end_time']);
        }
        return $this->result(0, '',$user_coupon );
    }
    //获取用户我的优惠券列表
    public function doPagegetMyCoupon(){
        global $_W, $_GPC;
        $uid=$_GPC['openid'];
        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
       // $signs=$_GPC['signs']?$_GPC['signs']:1; 'sign'=>$signs
        $user_coupon=pdo_getall('yzcyk_sun_user_coupon', array('uniacid' => $_W['uniacid'], 'uid' => $uid),array(),'','id desc',$limit);
        foreach($user_coupon as &$val){
            $val['lq_time_d']=date('Y.m.d H:i:s',$val['lq_time']);
            $val['end_time_d']=date('Y.m.d H:i:s',$val['end_time']);
            $val['detail']=pdo_getall('yzcyk_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$val['coupon_id']));
        }
        return $this->result(0, '',$user_coupon );
    }
    //创建活动订单
    public function doPagesetOrder(){
        global $_W, $_GPC;
        $activity_id=$_GPC['activity_id'];
        $openid=$_GPC['openid'];
        $num=$_GPC['num']?$_GPC['num']:1;
        $baby_id=$_GPC['baby_id'];
        $name=$_GPC['name'];
        $phone=$_GPC['phone'];
        $coupon_id=$_GPC['coupon_id']=='undefined'?0:$_GPC['coupon_id'];
        $coupon_id=$coupon_id?$coupon_id:0;
        $formid=$_GPC['formId'];
        //获取活动信息
        $activity=pdo_get('yzcyk_sun_activity',array('uniacid'=>$_W['uniacid'],'id'=>$activity_id));
        //判断活动还有没有库存
        if($activity['num']<$num){
            return $this->result(1, '该活动已领取完，敬请期待下次' );
            exit;
        }
        if($activity['qzk_status']==1){
            if($this->doPagecheckVipReturn()==0){
                return $this->result(1, '该活动只有车友卡会员才能领取' );
                exit;
            }
            //判断用户有没有领取过
            $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'activity_id'=>$activity_id,'pay_status'=>1));
            if($order){
                return $this->result(1, '该活动只能领取1次' );
                exit;
            }

            //增加活动销量 减少库存
            pdo_update('yzcyk_sun_activity',array('sale_num +='=>1,'num -='=>1),array('id'=>$activity_id));
            //增加订单信息
            $order=array(
                'uniacid'=>$_W['uniacid'],
                'openid'=>$_GPC['openid'],
                'orderformid'=>date("YmdHis") .rand(11111, 99999),
                'activity_id'=>$activity_id,
                'baby_id'=>$baby_id,
                'name'=>$name,
                'phone'=>$phone,
                'order_lid'=>2,
                'pay_type'=>2,
                'pay_status'=>1,
                'pay_time'=>time(),
                'order_status'=>1,
                'add_time'=>time(),
                'store_id'=>$activity['store_id'],
            );
            pdo_insert('yzcyk_sun_order',$order);
            $order_id = pdo_insertid();
            //增加订单详情
            $order_detail=array(
                'uniacid'=>$_W['uniacid'],
                'order_id'=>$order_id,
                'openid'=>$_GPC['openid'],
                'activity_id'=>$activity_id,
                'title'=>$activity['title'],
                'common_price'=>$activity['common_price'],
                'qzk_price'=>$activity['qzk_price'],
                'num'=>1,
                'pic'=>$activity['pic'],
                'add_time'=>time(),
                'store_id'=>$activity['store_id'],
            );
            pdo_insert('yzcyk_sun_order_detail',$order_detail);

            //发送模板消息
            $param['openid']=$_GPC['openid'];
            $param['form_id']=$formid;
            $param['template_id']=pdo_getcolumn('yzcyk_sun_sms',array( 'uniacid' => $_W['uniacid']),'tid1',1);
            $param['page']='yzcyk_sun/pages/user/orderdet/orderdet?id='.$order_id;
            $gname='';
            $num='';
            $detail_sms=pdo_getall('yzcyk_sun_order_detail',array('order_id'=>$order_id,'uniacid'=>$_W['uniacid']));
            $coun_num=count($detail_sms)-1;
            foreach($detail_sms as $k=>$v){
                if($coun_num==$k){
                    $gname.=$v['title'];
                    $num.=$v['num'];
                }else{
                    $gname.=$v['title'].'|';
                    $num.=$v['num'].'|';
                }
            }
            $orderinfo=pdo_get('yzcyk_sun_order',array('id'=>$order_id));
            $param['keyword1']=$orderinfo['orderformid'];
            $param['keyword2']=$gname;
            $param['keyword3']=$num;
            $param['keyword4']=$orderinfo['order_amount'];
            $param['keyword5']=date('Y-m-d H:i');
            $this->setSendTemplate($param);

            return $this->result(0, '领取成功' );
            exit;
        }else if($activity['qzk_status']==0){
            //增加订单信息
             $coupon_price=0;
             if($coupon_id>0){
                 $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$coupon_id));
                 if(empty($user_coupon)){
                     return $this->result(1, '优惠券不存在' );
                     exit;
                 }
                 if($activity['store_id']!=$user_coupon['store_id']){
                     return $this->result(1, '优惠券门店不符合' );
                     exit;
                 }
                 if($user_coupon['is_use']==1){
                     return $this->result(1, '该优惠券已使用' );
                     exit;
                 }


             }
            if($this->doPagecheckVipReturn()==1){
                $unit_price=$activity['qzk_price'];
                $good_total_price=$activity['qzk_price']*$num;
            }else if($this->doPagecheckVipReturn()==0){
                $unit_price=$activity['common_price'];
                $good_total_price=$activity['common_price']*$num;
            }
            if($coupon_id>0){
                 if($good_total_price<$user_coupon['m_price']){
                     return $this->result(1, '该优惠券不符合满减条件不能使用' );
                     exit;
                 }
                $coupon_price=$user_coupon['mj_price'];
                //修改优惠券状态
                pdo_update('yzcyk_sun_user_coupon',array('is_use'=>1,'use_time'=>time()), array('id' =>$_GPC['coupon_id']));
            }
            $order_amount=sprintf("%.2f",$good_total_price-$coupon_price);
            $order=array(
                'uniacid'=>$_W['uniacid'],
                'openid'=>$_GPC['openid'],
                'orderformid'=>date("YmdHis") .rand(11111, 99999),
                'order_amount'=>$order_amount,
                'good_total_price'=>$good_total_price,
                'good_total_num'=>$num,
                'activity_id'=>$activity_id,
                'baby_id'=>$baby_id,
                'name'=>$name,
                'phone'=>$phone,
                'coupon_id'=>$coupon_id,
                'coupon_price'=>$coupon_price,
                'order_lid'=>3,
                'pay_type'=>1,
                'order_status'=>0,
                'add_time'=>time(),
                'store_id'=>$activity['store_id'],

            );
            pdo_insert('yzcyk_sun_order',$order);
            $order_id = pdo_insertid();
            //增加订单详情
            $order_detail=array(
                'uniacid'=>$_W['uniacid'],
                'order_id'=>$order_id,
                'openid'=>$_GPC['openid'],
                'activity_id'=>$activity_id,
                'title'=>$activity['title'],
                'common_price'=>$activity['common_price'],
                'qzk_price'=>$activity['qzk_price'],
                'unit_price'=>$unit_price,
                'num'=>$num,
                'total_price'=>$good_total_price,
                'pic'=>$activity['pic'],
                'add_time'=>time(),
                'store_id'=>$activity['store_id'],
            );
            pdo_insert('yzcyk_sun_order_detail',$order_detail);

            //========计算分销佣金 S===========
            include_once IA_ROOT . '/addons/yzcyk_sun/inc/func/distribution.php';
            $distribution = new Distribution();
            $distribution->order_id = $order_id;
            $distribution->money = $order_amount;
            $distribution->userid = $_GPC['openid'];
            $distribution->ordertype =3;
            $distribution->computecommission();
            //========计算分销佣金 E===========

            echo $order_id;
        }

    }
    //获取商圈列表信息
    public function doPagegetStoreDistrict(){
        global $_W, $_GPC;
        $store_district=pdo_getall('yzcyk_sun_store_district',array('uniacid'=>$_W['uniacid'],'state'=>1));
        echo json_encode($store_district);
    }
    //获取商家分类列表信息
    public function doPagegetStoreCategory(){
        global $_W, $_GPC;
        $store_category=pdo_getall('yzcyk_sun_store_category',array('uniacid'=>$_W['uniacid'],'state'=>1));
        echo json_encode($store_category);
    }
    //领取优惠券
    public function doPagereceiveCoupon(){
        global $_W, $_GPC;
        $uid=$_GPC['openid'];
        $gid= $_GPC['coupon_id'];//优惠券id
        $coupon=pdo_get('yzcyk_sun_coupon',array('uniacid' => $_W['uniacid'], 'state' => 1,'id'=>$gid));
        if(empty($coupon)){
            return $this->result(1, '优惠券不存在或已禁用' );
            exit;
        }
        if($coupon['num']-$coupon['yl_num']<=0){
            return $this->result(0, '优惠券已领光' );
            exit;
        }
        $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('uniacid' => $_W['uniacid'],'uid'=>$uid,'coupon_id'=>$gid));
        if(!empty($user_coupon)){
            return $this->result(3, '优惠券已领取' );
            exit;
        }
        //判断是不是车友卡vip才可以领取
        if($coupon['is_vip']==1){
            if($this->doPagecheckVipReturn()==0){
                return $this->result(1, '该优惠券只有车友卡会员才能领取' );
                exit;
            }
        }
        //生成二维码
        $orderfomrid=date("YmdHis") .rand(11111, 99999);
        $data=array(
            'uniacid'=>$_W['uniacid'],
            'uid'=>$uid,
            'store_id'=>$coupon['store_id'],
            'coupon_id'=>$gid,
            'title'=>$coupon['title'],
            'sign'=>$coupon['sign'],
            'type'=>$coupon['type'],
            'm_price'=>$coupon['m_price'],
            'mj_price'=>$coupon['mj_price'],
            'lq_time'=>time(),
            'end_time'=>time()+$coupon['expiry_day']*60*60*24,
            'source'=>1,
            'orderformid'=>$orderfomrid,
        );
      //  if($coupon['sign']==2){
            $qrcode_path=$this->setEwm('1-'.$orderfomrid);
            $data['qrcode_path']=$qrcode_path;
     //   }
        pdo_insert('yzcyk_sun_user_coupon', $data);
        pdo_update('yzcyk_sun_coupon',array('yl_num +='=>1),array('id'=>$gid));
        return $this->result(0, '领取成功' );
        exit;
    }
    //获取商家详情信息
    public function doPagegetStoreDetail(){
        global  $_W,$_GPC;
        $openid=$_GPC['openid'];
        $id=$_GPC['id'];
        $is_punch=$_GPC['is_punch']?1:0;
        $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $store['coupon_list']=pdo_getall('yzcyk_sun_coupon',array('uniacid'=>$_W['uniacid'],'store_id'=>$id,'is_punch'=>$is_punch));
        $store['banner_list']=pdo_getall('yzcyk_sun_customize',array('uniacid'=>$_W['uniacid'],'type'=>5,'store_id'=>$id));
        $store['tag_arr']=explode(',',$store['tag']);
        foreach($store['coupon_list'] as &$v) {
            $user_coupon = pdo_get('yzcyk_sun_user_coupon', array('uniacid' => $_W['uniacid'], 'uid' => $openid, 'store_id' => $v['store_id'], 'coupon_id' =>$v['id']));
            if (!empty($user_coupon)) {
                $v['status'] = 2;
            } else if ($v['num'] - $v['yl_num'] <= 0) {
                $v['status'] = 1;
            } else {
                $v['status'] = 0;
            }
            $v['start_time_d']=date('Y-m-d',$v['start_time']);
            $v['end_time_d']=date('Y-m-d',$v['end_time']);

        }
        echo json_encode($store);
    }
    //更新商家过期信息
    private function updatestore(){
        global  $_W;
        $store=pdo_getall('yzcyk_sun_store',array('uniacid'=>$_W['uniacid']));
        foreach($store as $val){
            if($val['state']==2&&$val['rz_end_time']<time()){
                pdo_update('yzcyk_sun_store',array('rz_status'=>2),array('id'=>$val['id']));
            }
        }
    }
    //获取商家列表信息
    public function doPagegetStore(){
        global  $_W,$_GPC;
        $this->updatestore();
        $openid=$_GPC['openid'];
        $order='id desc';
        $cond=array();
        $cond['uniacid']=$_W['uniacid'];
        $category_id=$_GPC['category_id'];
        if($category_id>0){
            $cond['category_id']=$category_id;
        }
        $district_id=$_GPC['district_id'];
        if($district_id>0){
            $cond['district_id']=$district_id;
        }
        $cond['state']=2;
        $cond['rz_status']=1;
        $cond['pay_status']=1;
        $distance=$_GPC['distance'];
        $title=$_GPC['title'];
        if($title){
            $cond['store_name like']='%'.$_GPC['title'].'%';
        }

        $is_punch=$_GPC['is_punch']?1:0;
        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
        $where=" uniacid={$_W['uniacid']} ";
        if($distance>0){
            if($category_id>0){
                $where.=" and category_id=$category_id ";
            }
            if($district_id>0){
                $where.=" and district_id=$district_id ";
            }
            if($title){
                $where.=" and store_name like '%$title%' ";
            }
            $where.=" and state=2 and rz_status=1 and pay_status=1 ";
            $lat=$_GPC['lat'];
            $lng=$_GPC['lng'];
            $sql = "select *,convert(acos(cos($lat*pi()/180 )*cos(latitude*pi()/180)*cos($lng*pi()/180 -longitude*pi()/180)+sin($lat*pi()/180 )*sin(latitude*pi()/180))*6370996.81,decimal)  as distance from ims_yzcyk_sun_store where  $where order by distance asc $limit";
            $store = pdo_fetchall($sql);
        }else{
            $store=pdo_getall('yzcyk_sun_store',$cond,array(),'',$order,$limit);
        }
        foreach($store as &$val){
            $val['tag_arr']=explode(',',$val['tag']);
            $val['coupon_list']=pdo_getall('yzcyk_sun_coupon',array('uniacid'=>$_W['uniacid'],'store_id'=>$val['id'],'is_punch'=>$is_punch,'state'=>1));
            foreach($val['coupon_list'] as &$v){
                $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('uniacid' => $_W['uniacid'],'uid'=>$openid,'store_id'=>$v['store_id'],'coupon_id'=>$v['id']));
                if(!empty($user_coupon)){
                    $v['status']=2;
                }else if($v['num']-$v['yl_num']<=0){
                    $v['status']=1;
                }else{
                    $v['status']=0;
                }
                $v['start_time_d']=date('Y-m-d',$v['start_time']);
                $v['end_time_d']=date('Y-m-d',$v['end_time']);
            }
        }
        echo json_encode($store);

    }
    //获取活动详情
    public function doPagegetActivityDetail(){
        global  $_W,$_GPC;
        $id=$_GPC['id'];
        $cond=array();
        $cond['uniacid']=$_W['uniacid'];
        $cond['id']=$id;
        $activity=pdo_get('yzcyk_sun_activity',$cond);
        $activity['bm_begin_time_d']=date('Y-m-d', $activity['bm_begin_time']);
        $activity['bm_end_time_d']=date('Y-m-d', $activity['bm_end_time']);;
        $activity['tag_arr']=explode(',',$activity['tag']);
        if($activity['bm_begin_time']>time()){
            $activity['hd_status']=1;
        }else if($activity['bm_end_time']<time()){
            $activity['hd_status']=3;
        }else{
            $activity['hd_status']=2;
        }
        $activity['lb_pics_arr']=explode(',',$activity['lb_pics']);
        $activity['store']=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$activity['store_id']));
        echo json_encode($activity);
    }
    //获取活动列表信息
    public function doPagegetActivity(){
        global  $_W,$_GPC;
        $tid=$_GPC['tid'];
        $cond=array();
        $cond['uniacid']=$_W['uniacid'];
        if($tid>0){
            $cond['category_id']=$tid;
        }
        $title=$_GPC['title'];
        if($title){
            $cond['title like']='%'.$_GPC['title'].'%';
        }
        $show_index=$_GPC['show_index'];
        if($show_index==1){
            $cond['show_index']=1;
            $cond['bm_begin_time <=']=time();
            $cond['bm_end_time >=']=time();
        }
        $cond['state']=2;
        $gkfl_status=$_GPC['gkfl_status']?1:0;
        $cond['gkfl_status']=$gkfl_status;
        //分页
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=$_GPC['pagesize']?$_GPC['pagesize']:10;
        $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
        $activity=pdo_getall('yzcyk_sun_activity',$cond,array(), '','id desc',$limit);
        foreach($activity as &$val){
            $val['bm_begin_time_d']=date('Y-m-d', $val['bm_begin_time']);
            $val['bm_end_time_d']=date('Y-m-d', $val['bm_end_time']);
            $val['tag_arr']=explode(',',$val['tag']);
            if($val['bm_begin_time']>time()){
                $val['hd_status']=1;
            }else if($val['bm_end_time']<time()){
                $val['hd_status']=3;
            }else{
                $val['hd_status']=2;
            }
        }
        echo json_encode($activity);

    }
    //获取活动分类信息
    public function doPagegetActivityCategory(){
        global  $_W,$_GPC;
        $activity_category=pdo_getall('yzcyk_sun_activity_category',array('uniacid'=>$_W['uniacid']));
        echo json_encode($activity_category);
    }



    //测试函数
    public function doPagetest(){
        $end_time=strtotime(date('Y-m-d 23:59:59',1563074445));
        echo $end_time."<br>";

    }
    //车友卡续费或者充值
    public function doPagesetParentShip(){
        global  $_W,$_GPC;
        $openid=$_GPC['openid'];
        $data=array(
            'names'=>$_GPC['names'],
            'phone'=>$_GPC['phone'],
            'address'=>$_GPC['address'],
            'address_detail'=>$_GPC['address_detail'],
            'baby_id'=>$_GPC['baby_id'],
        );
        //更新车友卡信息
        pdo_update('yzcyk_sun_user',$data,array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        $settings=pdo_get('yzcyk_sun_settings',array('uniacid'=>$_W['uniacid']));
        //增加订单信息
        $order=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$_GPC['openid'],
            'orderformid'=>date("YmdHis") .rand(11111, 99999),//订单号
            'order_amount'=>$settings['money'],
            'order_lid'=>1,
            'qzk_type'=>1,
            'pay_type'=>1,
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_order',$order);
        $order_id = pdo_insertid();

        //========计算分销佣金 S===========
        include_once IA_ROOT . '/addons/yzcyk_sun/inc/func/distribution.php';
        $distribution = new Distribution();
        $distribution->order_id = $order_id;
        $distribution->money = $settings['money'];
       // $distribution->money = 100;
        $distribution->userid = $_GPC['openid'];
        $distribution->ordertype =1;
        $distribution->computecommission();
        //========计算分销佣金 E===========

        echo $order_id;
    }
    //获取宝宝详情信息
    public function doPagegetBabyDetail(){
        global  $_W,$_GPC;
        $id=$_GPC['id'];
        $baby=pdo_get('yzcyk_sun_baby',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        echo json_encode($baby);
    }
    //获取宝宝信息
    public function doPagegetBaby(){
        global  $_W,$_GPC;
        $openid=$_GPC['openid'];
        $baby=pdo_getall('yzcyk_sun_baby',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        echo json_encode($baby);
    }
    //删除宝宝
    public function doPagedelBaby(){
        global  $_W,$_GPC;
        $id=$_GPC['id'];
        pdo_delete('yzcyk_sun_baby',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        echo 1;
    }
    //修改宝宝信息
    public function doPageeditBaby(){
        global  $_W,$_GPC;
        $id=$_GPC['id'];
        $car_producer=$_GPC['car_producer'];
        $car_level=$_GPC['car_level'];
        $car_number=$_GPC['car_number'];
        $car_insurance=$_GPC['car_insurance'];
        $data=array(
            'car_producer'=>$car_producer,
            'car_level'=>$car_level,
            'car_number'=>$car_number,
            'car_insurance'=>$car_insurance,
            'edit_time'=>time(),
        );
        pdo_update('yzcyk_sun_baby',$data,array('uniacid'=>$_W['uniacid'],'id'=>$id));
        echo 1;
    }
    //增加宝宝信息
    public function doPagesetBaby(){
        global  $_W,$_GPC;
        $openid=$_GPC['openid'];
        $car_producer=$_GPC['car_producer'];
        $car_level=$_GPC['car_level'];
        $car_number=$_GPC['car_number'];
        $car_insurance=$_GPC['car_insurance'];


        $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        $baby_count=pdo_get('yzcyk_sun_baby', array('uniacid'=>$_W['uniacid'],'openid'=>$openid), array('count(id) as count'));
        if($baby_count['count']>=5){
            return $this->result(1,'宝宝数已达上限');
            exit;
        }

        $data=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$openid,
            'user_id'=>$user['id'],
            'car_producer'=>$car_producer,
            'car_level'=>$car_level,
            'car_number'=>$car_number,
            'car_insurance'=>$car_insurance,
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_baby',$data);
        echo 1;
    }

    //判断用户是不是车友vip返回
    public function doPagecheckVipReturn(){
        global  $_W,$_GPC;
        $openid=$_GPC['openid'];
        $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        if($user['is_vip']==1){
            if($user['end_time']>time()){
                return 1;
            }else{
                pdo_update('yzcyk_sun_user',array('is_vip'=>0),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
                return 0;
            }
        }else{
            return 0;
        }
    }

    //判断用户是不是车友vip
    public function doPagecheckVip(){
        global  $_W,$_GPC;
        $openid=$_GPC['openid'];
        $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
        if($user['is_vip']==1){
            if($user['end_time']>time()){
                echo 1;
            }else{
                pdo_update('yzcyk_sun_user',array('is_vip'=>0),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
                echo 0;
            }
        }else{
            echo 0;
        }
    }

    //获取公告信息
    public function doPagegetAnnouncement(){
        global  $_W,$_GPC;
        $type=$_GPC['type']?$_GPC['type']:1;
        $cond=array();
        $cond['type']=$type;
        $cond['uniacid']=$_W['uniacid'];
        $cond['show_index']=1;
        $announcement=pdo_getall('yzcyk_sun_announcement',$cond);
        echo json_encode($announcement);
    }
    //获取特权标识
    public function doPagegetPrivilegeIdentifier(){
        global  $_W;
        $privilege_identifier=pdo_getall('yzcyk_sun_privilege_identifier',array('uniacid'=>$_W['uniacid']));
        echo json_encode($privilege_identifier);
    }


  //发货
  public function doPagesetOrderFahuo(){
 	 global  $_W,$_GPC;
     $id=$_GPC['id'];
     $express_delivery=$_GPC['express_delivery'];
     $express_orderformid=$_GPC['express_orderformid'];
     $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$id));
     if($order['order_status']==2){
     	  return $this->result(1,'该订单已发货');
         exit;
     }
     pdo_update('yzcyk_sun_order',array('order_status'=>2,'fahuo_time'=>time(),'express_delivery'=>$express_delivery,'express_orderformid'=>$express_orderformid),array('id'=>$_GPC['id']));
     $msg['errcode']=0;
     $msg['errmsg']='发货成功';
     echo json_encode($msg);
  }
  //获取自定义信息
  public function doPagegetCustomize(){
  	 global  $_W,$_GPC;
     $cond1=array(
     	'uniacid'=>$_W['uniacid'],
        'type'=>1,
     );
     $cond2=array(
     	'uniacid'=>$_W['uniacid'],
        'type'=>2,
     );
     $cond3=array(
     	'uniacid'=>$_W['uniacid'],
        'type'=>3,
     );
     $cond4=array(
         'uniacid'=>$_W['uniacid'],
         'type'=>4,
     );
     $banner=pdo_getall('yzcyk_sun_customize',$cond1, array(), '', 'sort DESC,id asc');
     foreach($banner as &$v1){
     	$v1['attachurl']=$_W['attachurl'];
        if(strpos($v1['url'],'?')){
        	 $v1['is_url']=substr($v1['url'],0,strpos($v1['url'],'?'));
        }else{
        	 $v1['is_url']=$v1['url'];
        }
     }
     $icons=pdo_getall('yzcyk_sun_customize',$cond2, array(), '', 'sort DESC,id asc');
     foreach($icons as &$v2){
     	$v2['attachurl']=$_W['attachurl'];
       if(strpos($v2['url'],'?')){
       	 $v2['is_url']=substr($v2['url'],0,strpos($v2['url'],'?'));
       }else{
       		 $v2['is_url']=$v2['url'];
       }       
     }
     $tab=pdo_getall('yzcyk_sun_customize',$cond3, array(), '', 'sort DESC,id asc');
     foreach($tab as &$v3){
     	$v3['attachurl']=$_W['attachurl'];
          if(strpos($v3['url'],'?')){
          	 $v3['is_url']=substr($v3['url'],0,strpos($v3['url'],'?')); 
          }else{
          	$v3['is_url']=$v3['url'];
          }
     }
      $hd=pdo_getall('yzcyk_sun_customize',$cond4, array(), '', 'sort DESC,id asc');
      foreach($hd as &$v4){
          $v4['attachurl']=$_W['attachurl'];
          if(strpos($v4['url'],'?')){
              $v4['is_url']=substr($v4['url'],0,strpos($v4['url'],'?'));
          }else{
              $v4['is_url']=$v4['url'];
          }
      }
     $data=array(
     	 'banner'=>$banner,
         'icons'=>$icons,
         'tab'=>$tab,
         'hd'=>$hd,
     );
    echo json_encode($data);
    
  }
  //购物车判断库存
  public function doPageis_stock(){
  	 global  $_W,$_GPC;
     $crid=$_GPC['crid'];
     $crid=rtrim($crid, ','); 
     $where = " where uniacid={$_W['uniacid']} and id in ($crid) ";
     $sql = "select gid,sum(num) as num from " . tablename('yzcyk_sun_shop_car') . $where . " group by gid order by id desc";
     $data = pdo_fetchall($sql);  
     $no_stock=0;
     $gname='';
     foreach($data as $val){
        $num=pdo_getcolumn('yzcyk_sun_goods', array('id' =>$val['gid'],'uniacid' => $_W['uniacid']), 'num',1);
        if($num<$val['num']){
            $gname=pdo_getcolumn('yzcyk_sun_goods', array('id' =>$val['gid'],'uniacid' => $_W['uniacid']), 'goods_name',1);  
        	$no_stock=1;
            break;
        }
     }
     if($no_stock==1){
        $msg=$gname."商品库存不足";
        return $this->result(1,$msg);
     }else{
     	echo $no_stock;
     } 
  }
  //异步回调地址处理
  public function payResult($data){
      global  $_W,$_GPC;
      $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'orderformid'=>$data['out_trade_no']));
      if(empty($order)||$order['pay_status']==1){
        echo 'FAIL';
        exit;
      } 
      $_GPC['transaction_id']=$data['transaction_id'];
      $_GPC['order_id']=$order['id'];
      $_GPC['form_id']=$order['prepay_id'];
      $this->doPagePayOrder(); 
  }
  //获取首页推荐排序信息
  public function doPagegetRecommendSort(){
  	   global $_W, $_GPC;
       $system=pdo_get('yzcyk_sun_system',array('uniacid'=>$_W['uniacid']));
       $sort=array(
       		array(
            	'name'=>'yuyue_sort',
                'sort'=>$system['yuyue_sort'],
            ),
            array(
            	'name'=>'haowu_sort',
                'sort'=>$system['haowu_sort'],
            ),
      	   array(
            	'name'=>'groups_sort',
                'sort'=>$system['groups_sort'],
            ),
      	   array(
            	'name'=>'bargain_sort',
                'sort'=>$system['bargain_sort'],
            ),
      	   array(
            	'name'=>'xianshigou_sort',
                'sort'=>$system['xianshigou_sort'],
            ),
       	   array(
            	'name'=>'share_sort',
                'sort'=>$system['share_sort'],
            ),
      	   array(
            	'name'=>'xinpin_sort',
                'sort'=>$system['xinpin_sort'],
            ),
       );
       array_multisort(array_column($sort,'sort'),SORT_DESC,$sort);
       echo json_encode($sort);
  
  
  }
  //获取商品列表
   public function doPagegetGoodsList()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_goods', array('uniacid' => $_W['uniacid'],'lid'=>array(1,2,4,5,6)), array(), '', 'id DESC');
        foreach($res as &$val){
            $val['lb_img']=explode(',',$val['lb_imgs'])[0]; 
        }
        echo json_encode($res);
    }
  //判断是否可以拼团
  public function doPageisGroups(){
  		global $_W, $_GPC;
        $order_id=$_GPC['order_id'];
        $groups=pdo_get('yzcyk_sun_user_groups',array('uniacid'=>$_W['uniacid'],'order_id'=>$order_id));
        if($groups['status']==1){
          return $this->result(1,'该拼团已拼团成功,请不要参与');
        }
        if($groups['status']==3){
          return $this->result(1,'该拼团已拼团失败,请不要参与'); 
        }
  
  }
  
  //formID
  public function doPagesetFormId(){
     global $_W, $_GPC;
     file_put_contents('abcdef.txt','formid:'.$_GPC['formId']);
   
  }
  //测试发送模板消息
    public function doPageteststm(){
        global $_W, $_GPC;
        //发送模板消息
        $param=array();
        $param['openid']='oKbcA5dgnhJwF4o7x9Q-93MVlx2E';
        $param['form_id']='wx021553112490116a607205522881569439';
        $param['template_id']=pdo_getcolumn('yzcyk_sun_sms',array( 'uniacid' =>$_W['uniacid']),'tid1',1);
        $param['page']='yzcyk_sun/pages/index/index';
        $gname="商家入驻";
        $num=1;
        $param['keyword1']='2018081';
        $param['keyword2']=$gname;
        $param['keyword3']=$num;
        $param['keyword4']=100;
        $param['keyword5']=date('Y-m-d H:i');
        $this->setSendTemplate($param);

    }

  //发送模板消息 支付后
  private function setSendTemplate($param){
     global $_W, $_GPC;
     $access_token = $this->getAccess_token1();
     $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token; 
     $data=array(
     	'keyword1'=>array('value'=>$param['keyword1'],'color'=>'173177'),
        'keyword2'=>array('value'=>$param['keyword2'],'color'=>'173177'),
        'keyword3'=>array('value'=>$param['keyword3'],'color'=>'173177'),
        'keyword4'=>array('value'=>$param['keyword4'],'color'=>'173177'),
        'keyword5'=>array('value'=>$param['keyword5'],'color'=>'173177'),
     );
     $request_data=array(
      'touser'=>$param['openid'],//接收者（用户）的 openid
      'template_id'=>$param['template_id'],//所需下发的模板消息的id
      'page'=>$param['page'],//点击模板卡片后的跳转页面
      'form_id'=>$param['form_id'],//表单提交场景下，为 submit 事件带上的 formId；支付场景下，为本次支付的 prepay_id
      'data'=>$data,//"keyword1": {"value": "339208499", "color": "#173177"}
     );
    $res=$this->postJsonCurl($url,$request_data);
    echo 1;
  }
  
  
  private function postJsonCurl($url,$formwork){
     // $header [] = "content-type: application/json; charset=UTF-8"; 
         $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
         $formwork=json_encode($formwork);
         $ch = curl_init();   
         curl_setopt($ch, CURLOPT_URL, $url); 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $formwork);
         curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
         $data = curl_exec($ch);
         curl_close($ch);
         return $data;  
  }
  
  //测试发送模板消息
  
  //判断是否管理员或者核销人员
  public function doPageisHxstaff(){
  	global $_W, $_GPC; 
    $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid' => $_W['uniacid'],'openid'=>$_GPC['uid'],'type'=>0));
    if($hxstaff){
      echo 1;
    }else{
      echo 2;
    }
  }
  
  //判断是否有后台管理或者商家权限
  public function doPageis_hx_openid(){
  	global $_W, $_GPC;
    $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid' => $_W['uniacid'],'openid'=>$_GPC['openid'],'store_id'=>0,'type'=>0));
    $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['openid'],'state'=>2));
    $hxstaff_person=pdo_get('yzcyk_sun_hxstaff',array('uniacid' => $_W['uniacid'],'openid'=>$_GPC['openid'],'type'=>1));
    if($hxstaff){
        $msg['errcode']=1;
    }else if($store){
        $msg['errcode']=2;
        $msg['errmsg']=$store;
    }else if($hxstaff_person){
        $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$hxstaff_person['store_id'],'state'=>2));
        $msg['errcode']=2;
        $msg['errmsg']=$store;
    }else{
        $msg['errcode']=0;
    }
    echo json_encode($msg);
  }
  //检测商品条件
  public function doPagecheckGoods(){
  	global $_W, $_GPC;  
    $gid=$_GPC['gid'];
    $num=$_GPC['num']?$_GPC['num']:1;
    $goods=pdo_get('yzcyk_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$gid));
    if(!$goods){
    	return $this->result(1,'商品错误');
    }
    if($goods['lid']==4||$goods['lid']==5||$goods['lid']==6||$goods['lid']==7){
    	if($goods['end_time']<time()){
        	return $this->result(1,'活动时间已结束,感谢参与');
        }
    }
    if($goods['num']-$num<0){
    	return $this->result(1,'库存不足,当前剩余库存为'.$goods['num']);
    }
   echo 1;

  }
  
  //获取用户 佣金
  public function doPagegetUser(){
 	 global $_W, $_GPC; 
     $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['openid']));
     if($user['end_time']>0){
         $user['end_time_d']=date('Y-m-d',$user['end_time']);
     }
     echo json_encode($user);
 	   
  }
  //检测拼团失败 退款
    public function doPagecheckGroups(){
    	global $_W; 
        $group= pdo_getall('yzcyk_sun_user_groups',array('uniacid'=>$_W['uniacid'],'status'=>2,'refund_num'=>0,'end_time <'=>time()),array(), '','id asc',10);
        foreach($group as $val){
            pdo_update('yzcyk_sun_user_groups',array('status'=>3,'refund_num +='=>1),array('id'=>$val['id']));
            $out_refund_no=date("YmdHis") .rand(11111, 99999);
            $xml=$this->refund(intval($val['order_id']),$out_refund_no);
            pdo_update('yzcyk_sun_user_groups',array('xml'=>$xml,'out_refund_no'=>$out_refund_no),array('id'=>$val['id']));
            pdo_update('yzcyk_sun_order',array('order_status'=>5,'refund_time'=>time(),'refund_status'=>2,'refund_application_status'=>1,'tuikuanformid'=>$out_refund_no),array('id'=>$val['order_id']));
        }    
    }
    public function doPageapplyrefund(){
    	$this->refund(118);
    }
   //退款接口
    private function refund($order_id,$out_refund_no){
        global $_W;     
       // $order_id=intval($_GPC['order_id']);
        $order = pdo_get('yzcyk_sun_order', array('uniacid' => $_W['uniacid'],'id'=>$order_id));
        if(empty($order)){
            exit;
        }
        if($order['order_status']!=1){
           // return $this->result(1, '该订单不能发起退款');
            exit;
        }
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['appid'] =$system['appid'];
        $data['mch_id'] =$system['mchid'];
        $data['nonce_str']=$this->createNoncestr();
        $data['out_trade_no']=$order['orderformid'];
        $data['out_refund_no']=$out_refund_no;
        $data['total_fee']=intval($order['order_amount']*100);
        $data['refund_fee']=$data['total_fee'];
        $data['sign']=$this->getSign($data,$system['wxkey']);
        $xml=$this->postXmlCurl($data);
        return $xml;
    }
    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    //提现测试
    public function doPagetesttx(){
        global $_W;
        exit;
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['mch_appid']=$system['appid'];
        $data['mchid'] =$system['mchid'];
        $data['nonce_str']=$this->createNoncestr();
        $data['partner_trade_no']=date("YmdHis") .rand(11111, 99999);
        $data['openid']='oKbcA5dgnhJwF4o7x9Q-93MVlx2E';
        $data['check_name']='NO_CHECK';
        $data['amount']=100;
        $data['desc']='提现';
        $data['spbill_create_ip']=$_SERVER['REMOTE_ADDR'];
        $data['sign']=$this->getSign($data,$system['wxkey']);
        $xml=$this->postXmlCurl($data,$url);
        $arr=xml2array($xml);
        var_dump($arr);
    }

    //作用：生成签名
    private function getSign($Obj,$key) {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }
    private  function postXmlCurl($xml, $url, $second = 30)
    {
        global $_W;
        if(!$url){
            $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";//微信退款地址，post请求
        }
        $xml = $this->arrayToXmls($xml);
        $refund_xml='';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, IA_ROOT . '/addons/yzcyk_sun/cert/apiclient_cert_'.$_W['uniacid'].'.pem');
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, IA_ROOT . '/addons/yzcyk_sun/cert/apiclient_key_'.$_W['uniacid'].'.pem');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);   
        $refund_xml = curl_exec($ch);
        // 返回结果0的时候能只能表明程序是正常返回不一定说明退款成功而已
        $errono = curl_errno($ch);
       /* if ($errono == 0) {
            $xml_data = xml2array($xml);
            $return_data['errNum'] = 0;
            $return_data['info'] = $xml_data;
        } else {
            $return_data['errNum'] = $errono;
            $return_data['info'] = '';
        }*/
        curl_close($ch);
        return $refund_xml;
       // die(json_encode($return_data)); 
    }

    ///作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

   //获取商户统计信息
   public function doPagegetstoretongji(){
       global $_W,$_GPC;
       $store_id=$_GPC['store_id'];
       $openid=$_GPC['openid'];
       $time=date("Y-m-d");
       $time_jr=strtotime($time);
       //今日订单
       $sql=" select a.* from (select  id,FROM_UNIXTIME(add_time) as time  from".tablename('yzcyk_sun_order')." where uniacid={$_W['uniacid']} and order_lid=3 and store_id={$_GPC['store_id']} ) a where time like '%{$time}%' ";
       $jir=count(pdo_fetchall($sql));
       //总订单
       $sql=" select  *  from ".tablename('yzcyk_sun_order')." where uniacid={$_W['uniacid']} and order_lid=3 and store_id={$_GPC['store_id']}";
       $total_order=count(pdo_fetchall($sql));

       //今日销售总额
       $sql="SELECT sum(order_amount) FROM ".tablename('yzcyk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and order_lid=3 and store_id={$_GPC['store_id']} and pay_time>=$time_jr";
       $jr_total_sale_money= pdo_fetchcolumn($sql);
       $jr_total_sale_money=$jr_total_sale_money?$jr_total_sale_money:0;

       //销售总额
       $sql="SELECT sum(order_amount) FROM ".tablename('yzcyk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and order_lid=3 and store_id={$_GPC['store_id']} ";
       $total_sale_money= pdo_fetchcolumn($sql);
       $total_sale_money=$total_sale_money?$total_sale_money:0;

       $tongji=array();
       $tongji[]=array('title'=>'今日订单','detail'=>$jir);
       $tongji[]=array('title'=>'总订单','detail'=>$total_order);
       $tongji[]=array('title'=>'今日销售总额','detail'=>$jr_total_sale_money);
       $tongji[]=array('title'=>'总销售额','detail'=>$total_sale_money);
       $data=array(
           'tongji'=>$tongji,
       );
       echo json_encode($data);
   }

  //获取统计信息
  public function doPagegettongji(){
  	global $_W;
    //会员信息
    $time=date("Y-m-d");
    $time2=date("Y-m-d",strtotime("-1 day"));
    $time3=date("Y-m");
    $time_jr=strtotime($time);
    $time_zr=strtotime(date("Y-m-d",strtotime("-1 day")));
    //会员总数
    $totalhy=pdo_get('yzcyk_sun_user', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
    //今日新增会员
    $sql=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzcyk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time}%' ";
    $jir=count(pdo_fetchall($sql));
    //昨日新增
    $sql2=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzcyk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time2}%' ";
    $zuor=count(pdo_fetchall($sql2));
    //本月新增
    $sql3=" select a.* from (select  id,FROM_UNIXTIME(time) as time  from".tablename('yzcyk_sun_user')." where uniacid={$_W['uniacid']}) a where time like '%{$time3}%' ";
    $beny=count(pdo_fetchall($sql3));
    //总共订单
	$totalorder=pdo_get('yzcyk_sun_order', array('uniacid'=>$_W['uniacid']), array('count(id) as count'));
	//待使用(发货)订单
	$dfhorder=pdo_get('yzcyk_sun_order', array('uniacid'=>$_W['uniacid'],'order_status'=>1), array('count(id) as count'));
    
    //今日销售总额
    $sql="SELECT sum(order_amount) FROM ".tablename('yzcyk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_jr";
    $jr_total_sale_money= pdo_fetchcolumn($sql);
    $jr_total_sale_money=$jr_total_sale_money?$jr_total_sale_money:0;
    
     //昨日销售总额
    $sql="SELECT sum(order_amount) FROM ".tablename('yzcyk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1 and pay_time>=$time_zr and pay_time<$time_jr";
    $zr_total_sale_money= pdo_fetchcolumn($sql);
    $zr_total_sale_money=$zr_total_sale_money?$zr_total_sale_money:0;
    
     //销售总额
    $sql="SELECT sum(order_amount) FROM ".tablename('yzcyk_sun_order')." where uniacid={$_W['uniacid']} and pay_status=1";
    $total_sale_money= pdo_fetchcolumn($sql);
    $total_sale_money=$total_sale_money?$total_sale_money:0;
    
    
    $tongji=array();
    $tongji[]=array('title'=>'今日新增用户','detail'=>$jir); 
    $tongji[]=array('title'=>'昨日新增用户','detail'=>$zuor);
    $tongji[]=array('title'=>'本月新增用户','detail'=>$beny);
    $tongji[]=array('title'=>'访客总数','detail'=>$totalhy['count']);
    $tongji[]=array('title'=>'待使用订单','detail'=>$dfhorder['count']);
    $tongji[]=array('title'=>'总订单','detail'=>$totalorder['count']);
    $sale_tongji=array();
    $sale_tongji[]=array('title'=>'今日销售总额','detail'=>$jr_total_sale_money);
    $sale_tongji[]=array('title'=>'昨日销售总额','detail'=>$zr_total_sale_money);
    $sale_tongji[]=array('title'=>'总销售总额','detail'=>$total_sale_money);
    
    $data=array(
    	'tongji'=>$tongji,
        'sale_tongji'=>$sale_tongji,
    );
    echo json_encode($data);
  }
  
  //获取评价
  public function doPagegetPingjia(){
  	global $_W, $_GPC;
    $gid=$_GPC['gid'];
    $pingjia=pdo_getall('yzcyk_sun_pingjia',array('uniacid'=>$_W['uniacid'],'gid'=>$gid),array(),'','id desc');
    foreach($pingjia as &$val){
        $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$val['uid']));
        $val['nickname']=$user['name'];
        $val['headimg']=$user['img'];
    	$val['add_time_d']=date('Y-m-d H:i',$val['add_time']);
    }
    echo json_encode($pingjia);
  
 
  }
  //发表评价
  public function doPagesetComment(){
  	 global $_W, $_GPC;
      $uid=$_GPC['uid'];
      $order_id=$_GPC['order_id'];
      $order_detail_id=$_GPC['order_detail_id'];
      $stars=$_GPC['stars'];
      $content=$_GPC['content'];
      $detail=pdo_get('yzcyk_sun_order_detail',array('uniacid'=>$_W['uniacid'],'id'=>$order_detail_id));
       
      $pingjia=pdo_get('yzcyk_sun_pingjia',array('uniacid'=>$_W['uniacid'],'order_id'=>$order_id,'order_detail_id'=>$order_detail_id));
      if($pingjia){
      	  return $this->result(1,'你已评价,不要重复评价');
          exit;
      }
      
      $data=array(
      	'uniacid'=>$_W['uniacid'],
        'uid'=>$uid,
        'order_id'=>$order_id,
        'order_detail_id'=>$order_detail_id,
        'gid'=>$detail['gid'],
        'stars'=>$stars,
        'content'=>$content,
        'add_time'=>time(),
      );
      pdo_insert('yzcyk_sun_pingjia',$data);
      //修改评价详情评价状态
      pdo_update('yzcyk_sun_order_detail',array('is_pingjia'=>1),array('id'=>$order_detail_id));
      //修改订单评价状态
      $order_detail=pdo_get('yzcyk_sun_order_detail',array('uniacid'=>$_W['uniacid'],'order_id'=>$order_id,'is_pingjia'=>0));
      if(!$order_detail){
           pdo_update('yzcyk_sun_order',array('is_pingjia'=>1),array('id'=>$order_id));
      }
      echo 1;
 
  }
  //获取评价商品信息
  public function doPagegetOrderDetailComment(){
  	 global $_W, $_GPC;
      $uid=$_GPC['uid'];
      $order_id=$_GPC['order_id'];
      $order_detail_id=$_GPC['order_detail_id'];
      $order_detail=pdo_get('yzcyk_sun_order_detail',array('uniacid'=>$_W['uniacid'],'uid'=>$uid,'id'=>$order_detail_id));
      echo json_encode($order_detail);
     
  }

  //确认收货
  public function doPagequerenOrder(){
  	  global $_W, $_GPC;
      $uid=$_GPC['uid'];
      $order_id=$_GPC['order_id'];
      $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$order_id,'uid'=>$uid));
      if($order['pay_status']==0){
          return $this->result(1,'订单未支付不能确认收货');
          exit;
      }
      if(empty($order)){
        return $this->result(1,'订单错误');
          exit;
      }
     pdo_update('yzcyk_sun_order',array('order_status'=>3,'queren_time'=>time()),array('id'=>$order_id));
     echo $order_id;
  
  }

  //检测拼团信息是否到期
  public function doPagecheckGrops(){
  
  }
    
    
    
  //获取拼团信息
  public function doPagegetUserGroups(){
     global $_W, $_GPC;
     $openid=$_GPC['openid'];
     $index=$_GPC['index']?$_GPC['index']:0;
     $cond=array(
      'uniacid'=>$_W['uniacid'],
      'openid'=>$openid,
    );
     if($index==0){
       $where['status']=2;
    }else if($index==1){
       $where['status']=1;
    }else if($index==2){
       $where['status']=3;
     }
     $cond=array_merge($cond,$where);
     $user_groups=pdo_getall('yzcyk_sun_user_groups',$cond,array(),'','id desc');
    if($user_groups){
     foreach($user_groups as &$val){
      $goods=pdo_get('yzcyk_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$val['gid']));
      $val['lb_img']=explode(',', $goods['lb_imgs'])[0];
      $val['goods_name']=$goods['goods_name'];
      $val['goods_price']=$goods['goods_price'];
      $val['pintuan_price']=$goods['kanjia_price'];
      $val['pintuan_price']=$goods['pintuan_price'];
      $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$val['order_id']));
      $val['orderformid']=$order['orderformid'];
      $val['hc_num']=$val['buynum']-$val['num'];
      $val['end_time']=$val['addtime']+$goods['pin_hours']*60*60;
      $val['endtime']= $val['end_time']*1000;
      if($val['mch_id']==0){
        $val['share_order_id']=$val['order_id'];
      }else{
      	$val['share_order_id']=pdo_getcolumn('yzcyk_sun_user_groups',array( 'uniacid' => $_W['uniacid'],'id'=>$val['mch_id']),'order_id',1);
      } 
     }
    }
     echo json_encode($user_groups);
  
  }

  //获取砍价信息
  public function doPagegetUserBargain(){
  	 global $_W, $_GPC;
     $openid=$_GPC['openid'];
    $index=$_GPC['index']?$_GPC['index']:0;
    $cond=array(
      'uniacid'=>$_W['uniacid'],
      'openid'=>$openid,
      'mch_id'=>0,
    );
    if($index==0){
       $where['status']=array(1,2);
    }else if($index==1){
       $where['status']=3;
    }
    $cond=array_merge($cond,$where);
    $user_bargain=pdo_getall('yzcyk_sun_user_bargain',$cond,array(),'','id desc');
    foreach($user_bargain as &$val){
      $goods=pdo_get('yzcyk_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$val['gid']));
      $val['lb_img']=explode(',', $goods['lb_imgs'])[0];
      $val['goods_name']=$goods['goods_name'];
      $val['goods_price']=$goods['goods_price'];
      $val['kanjia_price']=$goods['kanjia_price'];
      if($val['status']==2||$val['status']==3){
        	$order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$val['order_id']));
            $val['orderformid']=$order['orderformid'];
      }
    }
    echo json_encode($user_bargain);
  
  
  }
  //获取分享商品记录
  public function doPagegetShareGoodsRecord(){
  		 global $_W, $_GPC;
          $uid=$_GPC['uid'];
    	 $share_goods_record=pdo_getall('yzcyk_sun_user_share_goods_record',array('uniacid'=>$_W['uniacid'],'openid'=>$uid),array(),'','id desc');
    foreach($share_goods_record as &$val){
      $goods=pdo_get('yzcyk_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$val['gid']));
        $val['goods_name']=$goods['goods_name'];
        $val['goods_price']=$goods['goods_price'];
        $val['img']=explode(',',$goods['imgs'])[0];
    }
    echo json_encode($share_goods_record);
  
  }
  //获取分销记录
  public function doPagegetShareRecord(){
    global $_W, $_GPC;
    $uid=$_GPC['uid'];
    $sql = ' SELECT * FROM ' . tablename('yzcyk_sun_user_share_record')." where (uniacid=".$_W['uniacid']." and first_openid='".$uid."') or (uniacid=".$_W['uniacid']." and second_openid='".$uid."') order by id desc";  
    $sharerecord = pdo_fetchall($sql);
    foreach($sharerecord as &$val){
         $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$val['openid']));
        $val['uname']=$user['name'];
      $val['img']=$user['img'];
    	if($uid==$val['first_openid']){
            $val['money']=$val['first_money'];
        }
        if($uid==$val['second_openid']){
        	 $val['money']=$val['second_money'];
        }
      $val['add_time_d']=date('Y-m-d H:i:s',$val['add_time']);
    
    }
    echo json_encode($sharerecord);
  
  }
  
  
  //获取单个订单
  public function doPagegetSingleOrder(){
   global $_W, $_GPC;
    $uid=$_GPC['uid'];
    $id=$_GPC['id'];
    $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$id,'uid'=>$uid));
    if($order['pay_status']==1&&empty($order['qrcode_path'])){
    	 $qrcode_path=$this->setEwm('2-'.$order['orderformid']);
     	 $order['qrcode_path']=$qrcode_path;
         pdo_update('yzcyk_sun_order',array('qrcode_path'=>$qrcode_path),array('id'=>$id));
        
    } 
    return $this->result(0,'',$order);
  
  }
  //获取预约订单
  public function doPagegetBookOrder(){
   global $_W, $_GPC;
     $uid=$_GPC['uid'];
     $index=$_GPC['index']?$_GPC['index']:0;
     $cond['uid']=$uid;
     $cond['order_lid']=2;
     $cond['pay_status']=1;
    if($index==0){
       $cond['order_status']=1;
    }else if($index==1){
       $cond['order_status']=3;
    }
     $order=pdo_getall('yzcyk_sun_order',$cond,array(),'','id desc');
     if($order){
     	foreach($order as &$val){
          $val['detail']=pdo_getall('yzcyk_sun_order_detail',array('uniacid'=>$_W['uniacid'],'order_id'=>$val['id']));
          $val['goods_cost']=pdo_getcolumn('yzcyk_sun_goods', array('id' =>$val['crid'],'uniacid' => $_W['uniacid']), 'goods_cost',1);
        }
     }
     echo json_encode($order); 
  
  
  }
  
  //获取全部订单
  public function doPagegetOrder(){
  	global $_W, $_GPC;
    $index=$_GPC['index']?$_GPC['index']:0;
    if($index==1){
       $cond['pay_status']=1;
       $cond['order_status']=1;
    }
    $cond['order_lid']=array(1,3,4,5,6,7);
    $cond['del_status']=0; 
    $cond['uniacid']=$_W['uniacid'];
    $order=pdo_getall('yzcyk_sun_order',$cond,array(),'','id desc');
    if($order){
     foreach($order as $k=>&$val){
         $val['detail']=pdo_getall('yzcyk_sun_order_detail',array('uniacid'=>$_W['uniacid'],'order_id'=>$val['id']));
         foreach($val['detail'] as &$v){
          if($v['spec_value']=='undefined'){
             $v['spec_value']='';
          }
          if($v['spec_value1']=='undefined'){
            $v['spec_value1']='';
          }
        } 
     }
    }
    echo json_encode($order); 
  
  }

  
    //获取我的普通订单（包含 商店、好物、限时购、分享）
   public function doPagegetMyorder1(){
     global $_W, $_GPC;
     $uid=$_GPC['uid'];
     $index=$_GPC['index']?$_GPC['index']:0;
     $cond['uid']=$uid;
     $cond['order_lid']=array(1,3,4,5,6,7);
     $cond['del_status']=0; 
     $cond['uniacid']=$_W['uniacid'];
   
     if($index==0){  
       
     }else if($index==1){
       $cond['pay_status']=0;
       $cond['order_status']=0;
     }else if($index==2){
       $cond['pay_status']=1;
       $cond['order_status']=1;
     }else if($index==3){
       $cond['pay_status']=1;
       $cond['order_status']=2; 
     }else if($index==4){
       $cond['pay_status']=1;
       $cond['order_status']=3;
       $cond['is_pingjia']=0;
     }

      $order=pdo_getall('yzcyk_sun_order',$cond,array(),'','id desc');
     if($order){
     	foreach($order as $k=>&$val){
          $val['detail']=pdo_getall('yzcyk_sun_order_detail',array('uniacid'=>$_W['uniacid'],'order_id'=>$val['id']));
          foreach($val['detail'] as &$v){
          	if($v['spec_value']=='undefined'){
              $v['spec_value']='';
            }
            if($v['spec_value1']=='undefined'){
              $v['spec_value1']='';
            }
          }
            
            
          if($val['order_lid']==4&&$val['pay_status']==0&&$val['pin_buy_type']==1){
          	unset($order[$k]);   
          }
        }
     }
     echo json_encode($order);
   }
    //创建到店买单订单
    public function doPagesetShopOrder(){
    	global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $price=$_GPC['price'];
    	if(!preg_match('/^[0-9]+(.[0-9]{1,2})?$/',$price)){
             return $this->result(1,'支付金额有误');
          	 exit;
         }
         if($price>500000){
             return $this->result(1,'支付金额不能超过￥500000');
          	 exit;
         }
         $order=array(
         	'uniacid'=>$_W['uniacid'],
            'uid'=>$openid,
            'cid'=>0,
            'orderformid'=>date("YmdHis") .rand(11111, 99999),//订单号
            'order_lid'=>8,
            'order_amount'=>$price,
            'sincetype'=>2,
            'add_time'=>time(),
         );
         pdo_insert('yzcyk_sun_order',$order);
         $order_id = pdo_insertid();
         return $this->result(0,'',$order_id);

      

    }
  //用户分享金额记录
  public function doPagegetUserMoneyRecord(){
    global $_W, $_GPC;
    $type=$_GPC['type'];
    if($type==2){
      $cond['type']=2;
    }
    $cond['uniacid']=$_W['uniacid'];
    $cond['openid']=$_GPC['openid'];
    $record=pdo_getall('yzcyk_sun_user_money_record',$cond);
    foreach($record as &$val){
      $val['add_time_d']=date('Y-m-d H:i',$val['add_time']);
    }
    echo json_encode($record);
  
  }
    //创建分享相关信息
    public function doPagesetShareRecord(){
        global $_W, $_GPC;
        $gid=$_GPC['gid'];
        $openid=$_GPC['openid'];
        $share_openid=$_GPC['share_openid'];
        //判断进入自己分享页面
        if($openid==$share_openid){
            exit;
        }
       if(empty($openid)||empty($share_openid)){ 
       	  exit;
       }
       //添加分享商品记录
       $share_goods_record=pdo_get('yzcyk_sun_user_share_goods_record',array('uniacid' => $_W['uniacid'],'openid'=>$share_openid,'gid'=>$gid));
      if(!$share_goods_record){
           $share_goods_record=array(
           	 'uniacid' => $_W['uniacid'],
             'openid'=>$share_openid,
             'gid'=>$gid,
             'acc_openid'=>$openid,
             'add_time'=>time(),
           );
           pdo_insert('yzcyk_sun_user_share_goods_record',$share_goods_record);
      
      }
      
        //判断用户是否参加
        $join=pdo_get('yzcyk_sun_user_share_join',array('uniacid' => $_W['uniacid'],'openid'=>$openid,'gid'=>$gid));
        if($join){
            exit;
        }
        //获取商品详情
        $goods=pdo_get('yzcyk_sun_goods',array('uniacid' => $_W['uniacid'],'id'=>$gid));
        if($goods['lid']!=7){
            exit;
        }
        if($goods['share_price']<=0){
            exit;
        }
       //判断活动是否过期
       if(time()>$goods['end_time']){
       	  exit; 
       }
        //增加参加记录
        $join=array(
            'uniacid' => $_W['uniacid'],
            'openid'=>$openid,
            'gid'=>$gid,
            'add_time'=>time()
        );
        //判断分享用户是否参加  不存在增加
        $share_join=pdo_get('yzcyk_sun_user_share_join',array('uniacid' => $_W['uniacid'],'openid'=>$share_openid,'gid'=>$gid));
        if(!$share_join){
            $share_join=array(
                'uniacid' => $_W['uniacid'],
                'openid'=>$share_openid,
                'gid'=>$gid,
                'add_time'=>time()
            );
            pdo_insert('yzcyk_sun_user_share_join',$share_join);
        }
        pdo_insert('yzcyk_sun_user_share_join',$join);
        //创建子父级关系
        $share=array(
            'uniacid' => $_W['uniacid'],
            'gid'=>$gid,
            'openid'=>$openid,
            'p_openid'=>$share_openid,
            'add_time'=>time()
        );
        pdo_insert('yzcyk_sun_user_share',$share);

        //增加分享记录
        $share_record=array(
            'uniacid' => $_W['uniacid'],
            'gid'=>$gid,
            'openid'=>$openid,
            'first_openid'=>$share_openid,
            'first_money'=>$goods['share_price'],
            'add_time'=>time()
        );
        //判断分享用户有没有父级
        $share=pdo_get('yzcyk_sun_user_share',array('uniacid'=>$_W['uniacid'],'gid'=>$gid,'openid'=>$share_openid));
        if($share['p_openid']){
            $share_record['second_openid']=$share['p_openid'];
            $share_record['second_money']=$goods['second_price'];
        }
        pdo_insert('yzcyk_sun_user_share_record',$share_record);
        $user_share_record_id=pdo_insertid();
        //增加一级 二级 用户分享佣金记录
        pdo_update('yzcyk_sun_user',array('money +='=>$goods['share_price'],'total_money +='=>$goods['share_price']),array('uniacid'=>$_W['uniacid'],'openid'=>$share_openid));
        $record=array(
            'uniacid' => $_W['uniacid'],
            'openid'=>$share_openid,
            'sign'=>1,
            'type'=>1,
            'money'=>$goods['share_price'],
            'title'=>'分享'.$goods['goods_name'].'赚$'.$goods['share_price'],
            'add_time'=>time(),
            'user_share_record_id'=>$user_share_record_id,
            'level'=>1,
        );
        pdo_insert('yzcyk_sun_user_money_record',$record);  
        if($share['p_openid']){
            pdo_update('yzcyk_sun_user',array('money +='=>$goods['second_price'],'total_money +='=>$goods['second_price']),array('uniacid'=>$_W['uniacid'],'openid'=>$share['p_openid']));
            $record=array(
                'uniacid' => $_W['uniacid'],
                'openid'=>$share['p_openid'],
                'sign'=>1,
                'type'=>1,
                'money'=>$goods['second_price'],
                'title'=>'分享'.$goods['goods_name'].'赚$'.$goods['second_price'],
                'add_time'=>time(),
                'user_share_record_id'=>$user_share_record_id,
                'level'=>2,
            );
            pdo_insert('yzcyk_sun_user_money_record',$record);
        }



    }

    //获取分享商品访记录
    public function doPagegetShareAccessRecord(){
        global $_W, $_GPC;
        $gid=$_GPC['gid'];
        $access_record=pdo_getall('yzcyk_sun_user_share_access_record',array('uniacid' => $_W['uniacid'],'gid'=>$gid),array(), '','id desc');
        $access=array();
        foreach($access_record as $val){
			if(!empty($val['openid'])){
            	$access[]=$val;
            }
        }
        echo json_encode($access);
    }
    //增加分享商品访问记录
    public function doPagesetShareAccessRecord(){
        global $_W, $_GPC;
        $gid=$_GPC['gid'];
        $openid=$_GPC['openid'];
        $access_record=pdo_get('yzcyk_sun_user_share_access_record',array('uniacid' => $_W['uniacid'],'openid'=>$openid,'gid'=>$gid));
        if(empty($openid)){
          echo 1;
      	  exit;
        }
        if($gid<=0){
          echo 1; 
          exit;
        }
        if(!$access_record){
            $data=array(
                'uniacid' => $_W['uniacid'],
                'openid'=>$openid,
                'gid'=>$gid,
                'head_img'=>pdo_getcolumn('yzcyk_sun_user',array( 'uniacid' => $_W['uniacid'],'openid'=>$openid),'img'),
                'add_time'=>time(),
            );
            pdo_insert('yzcyk_sun_user_share_access_record',$data);
        }
    }
    //获取分享商品信息
    public function doPagegetShareGoods(){
        global $_W, $_GPC;
        $index=$_GPC['index'];
        if(empty($index)||$index==0){
            $order='sales_num desc,id desc';
        }else if($index==1){
            $order='time desc';
        }else if($index==2){
            $where=array('show_recommend'=>1);
            $order='id desc';
        }else if($index==8){
        	$where=array('show_index'=>1);
            $order='id desc';
        }
      
        $cond=array(
            'uniacid' => $_W['uniacid'],
            'status' =>1,
            'lid'=>7,
            'start_time <='=>time(),
        );
        if(!empty($where)){
            $cond=array_merge($cond,$where);
        }
        $res = pdo_getall('yzcyk_sun_goods',$cond, array(), '',$order);
        if($res){
            foreach($res as &$val){
                $val['lb_img']=explode(',',$val['lb_imgs'])[0];
                $val['endtime']=$val['end_time']*1000;
                $val['shareprice']=$val['share_price']+$val['second_price'];
            }
        }
        echo json_encode($res);
    }
  //获取评论信息
  public function doPagegetDynamicComment(){
     global $_W, $_GPC;
     $comment_id=$_GPC['comment_id']; 
     $collection=pdo_getall('yzcyk_sun_dynamic_comment',array('uniacid'=>$_W['uniacid'],'dynamic_id'=>$comment_id),array(),'','id desc');
     foreach($collection as &$v){
         if(empty($v['nickname'])){
            $v['nickname']=pdo_getcolumn('yzcyk_sun_user', array('openid' =>$v['openid'],'uniacid' => $_W['uniacid']), 'name',1);   
         }
        $v['nickname']=$this->sub_strs($v['nickname'],6);
    } 
     echo json_encode($collection);  
  }
  //截取字符串
 public function sub_strs($str, $length = 6, $append = true){
      $str = trim($str);
      $strlength = strlen($str);
      if ($length >= $strlength)
      {
        return $str; //截取长度等于或大于等于本字符串的长度，返回字符串本身 
      }
      elseif ($length < 0) //如果截取长度为负数
      {
        $length = $strlength + $length;//那么截取长度就等于字符串长度减去截取长度
        if ($length < 0)
        {
          $length = $strlength;//如果截取长度的绝对值大于字符串本身长度，则截取长度取字符串本身的长度
        }
      }
      if (function_exists('mb_substr'))
      {
        $newstr = mb_substr($str,0 , $length, 'utf-8'); 
      }
      elseif (function_exists('iconv_substr'))
      {
        $newstr = iconv_substr($str, 0, $length, 'utf-8');
      }
      else
      {
        $newstr = substr($str,0, $length);
      }
      if ($append && $str != $newstr)
      {
        $newstr .= '...';
      }
      return $newstr;
  }
  
  
  //前台发布动态
  public function doPagesetDynamic(){
  	 global $_W, $_GPC;
      $system=pdo_get('yzcyk_sun_system',array('uniacid'=>$_W['uniacid']));
      $dynamic=array(
      	'uniacid'=>$_W['uniacid'],
        'head_img'=>$system['shopmsg_img'],
        'title'=>$system['pt_name'],
        'content'=>$_GPC['content'],
        'imgs'=>$_GPC['imgs'],
        'gid'=>$_GPC['gid'],
        'is_status'=>1,
        'add_time'=>time(),
      );
      pdo_insert('yzcyk_sun_dynamic',$dynamic);
      echo 1; 
  }
   //发表评论
  public function doPagesetDynamicComment(){
  	 global $_W, $_GPC;
     $openid=$_GPC['openid'];
     $comment_id=$_GPC['comment_id']; 
     $comment=trim($_GPC['comment']);
     if(empty($comment)){
       return $this->result(1,'评论内容不能为空');
       exit;
     } 
    $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
    $data=array(
    	'uniacid'=>$_W['uniacid'],
      'dynamic_id'=>$comment_id,
      'openid'=>$openid,
      'nickname'=>$user['name'],
      'content'=>$comment,
      'add_time'=>time(),
    );
     pdo_insert('yzcyk_sun_dynamic_comment',$data);
  }
  
  //点赞、收藏、取消
   public function doPagesetDynamicCollection(){
    global $_W, $_GPC;
    $openid=$_GPC['openid'];
    $dynamic_id=$_GPC['dynamic_id'];
    $is_status=$_GPC['is_status'];
    $collection=pdo_get('yzcyk_sun_dynamic_collection',array('uniacid'=>$_W['uniacid'],'dynamic_id'=>$dynamic_id,'openid'=>$openid));
    if(!$collection){
       $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
      if(empty($user['name'])||empty($user['img'])){
      	return $this->result(1,'请先授权');
        exit; 
      }
    	$collection=array(
          'uniacid'=>$_W['uniacid'],
          'dynamic_id'=>$dynamic_id,
          'openid'=>$openid,
          'nickname'=>$user['name'],
          'headimg'=>$user['img'],
          'is_status'=>$is_status,
          'add_time'=>time(),  
        );
       pdo_insert('yzcyk_sun_dynamic_collection',$collection);
    }else{
    	pdo_update('yzcyk_sun_dynamic_collection',array('is_status'=>$is_status),array('uniacid'=>$_W['uniacid'],'dynamic_id'=>$dynamic_id,'openid'=>$openid));
    } 
   
   }
    //获取动态点赞收藏头像
  public function doPagegetDynamicCollectionHeadimg(){
     global $_W, $_GPC;
     $dynamic_id=$_GPC['dynamic_id'];
     $collection=pdo_getall('yzcyk_sun_dynamic_collection',array('uniacid'=>$_W['uniacid'],'dynamic_id'=>$dynamic_id,'is_status'=>1),array('headimg'),'','id desc');
     echo json_encode($collection);
  
  }
    //获取动态信息
    public function doPagegetDynamic(){
        global $_W, $_GPC;
        $cond=array(
            'uniacid' => $_W['uniacid'],
            'is_status'=>1,
        );
        $order='id desc';
        $res = pdo_getall('yzcyk_sun_dynamic',$cond, array(), '',$order);
        foreach($res as &$val) {
            $val['imgs'] = explode(',', $val['imgs']);
            if($val['gid']){
             $val['goods']=pdo_get('yzcyk_sun_activity',array('uniacid' => $_W['uniacid'],'id'=>$val['gid']));
             $val['goods']['lb_img']=explode(',',$val['goods']['lb_pics'])[0];
             $collection=pdo_get('yzcyk_sun_dynamic_collection',array('uniacid'=>$_W['uniacid'],'dynamic_id'=>$val['id'],'openid'=>$_GPC['openid'],'is_status'=>1));
              if($collection){
              	$val['is_collection']=1;
              }else{
              	$val['is_collection']=0;
              }
              $collection=pdo_getall('yzcyk_sun_dynamic_collection',array('uniacid'=>$_W['uniacid'],'dynamic_id'=>$val['id'],'is_status'=>1),array('headimg'),'','id desc');
              $val['headimg']=$collection;
              $val['times']=$this->time2string(intval(time()-$val['add_time']));
              $comment=pdo_getall('yzcyk_sun_dynamic_comment',array('uniacid'=>$_W['uniacid'],'dynamic_id'=>$val['id']),array(),'','id desc');
              foreach($comment as &$v){
              	if(empty($v['nickname'])){
                	$v['nickname']=pdo_getcolumn('yzcyk_sun_user', array('openid' =>$v['openid'],'uniacid' => $_W['uniacid']), 'name',1); 
                }
                $v['nickname']=$this->sub_strs($v['nickname'],6);
              }
              $val['comment']=$comment;
  
  
            }
        }
        echo json_encode($res);
    }
   private function time2string($second){
	$day = floor($second/(3600*24));
	$second = $second%(3600*24);//除去整天之后剩余的时间
	$hour = floor($second/3600);
	$second = $second%3600;//除去整小时之后剩余的时间 
	$minute = floor($second/60);
/*	$second = $second%60;//除去整分钟之后剩余的时间 */
	//返回字符串  .$second.'秒;
    if($day>0){
       return $day.'天'.$hour.'小时'.$minute.'分';
    }else{
       return  $hour.'小时'.$minute.'分';
    }	
}
  
    
    //获取其他人开团记录
    public function doPagegetOtherGroups(){
        global $_W, $_GPC;
        $cond=array(
            'gid'=>$_GPC['gid'],
            'mch_id'=>0,
            'status'=>2,
           'openid !='=>$_GPC['openid'],
        );
        $limit=$_GPC['limit'];
        if(empty($limit)){
            $start_limit=$_GPC['start_limit'];
            $length=$_GPC['length'];
            if($start_limit){
                $limit=array($start_limit,$length);
            }else{
                $limit=20;
            }
        }

        //'openid !='=>$_GPC['openid'],
        //商品信息
        $goods=pdo_get('yzcyk_sun_goods',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['gid']));
        $order='id desc';
        $res = pdo_getall('yzcyk_sun_user_groups',$cond, array(), '',$order,$limit);
        foreach($res as &$val){
            $user=pdo_get('yzcyk_sun_user',array('uniacid' => $_W['uniacid'],'openid'=>$val['openid']));
            $val['name']=$user['name'];
            $val['img']=$user['img'];
            $val['hc_num']=$val['buynum']-$val['num'];
            $val['endtime'] = ($val['addtime']+$goods['pin_hours']*60*60)* 1000;
            $val['clock'] = '';
        }
        echo json_encode($res);
    }
    //通过order_id 获取拼主 mchid
    public function doPagegetMch_idByOrder_id(){
        global $_W, $_GPC;
        $order_id=$_GPC['order_id'];
        $mch_id=pdo_getcolumn('yzcyk_sun_user_groups', array('order_id' =>$order_id,'mch_id'=>0,'uniacid' => $_W['uniacid']), 'id',1);
        echo $mch_id;
    }

    //获取拼团详情
    public function doPagegetGroupsDetail(){
        global $_W, $_GPC;
        $order_id=$_GPC['order_id'];
        //订单详情
        $order=pdo_get('yzcyk_sun_order',array('uniacid' => $_W['uniacid'],'id'=>$order_id));
        //商品详情
        $goodsdetail=pdo_get('yzcyk_sun_goods',array('uniacid' => $_W['uniacid'],'id'=>$order['crid']));
        $goodsdetail['lj']=$goodsdetail['goods_price']-$goodsdetail['pintuan_price'];
        $goodsdetail['lb_img']=explode(',', $goodsdetail['lb_imgs'])[0];
        $goodsdetail['imgs'] = explode(',', $goodsdetail['imgs']);
        $goodsdetail['lb_imgs'] = explode(',', $goodsdetail['lb_imgs']);
        $goodsdetail['spec_value'] = explode(',', $goodsdetail['spec_value']);
        $goodsdetail['spec_values'] = explode(',', $goodsdetail['spec_values']);
        $goodsdetail['endtime']=$goodsdetail['end_time']*1000;
        $goodsdetail['start_times']=date('Y-m-d H:i:s',$goodsdetail['start_time']);
        $goodsdetail['end_times']=date('Y-m-d H:i:s',$goodsdetail['end_time']);
        //为团主
        $user_group=pdo_get('yzcyk_sun_user_groups',array('uniacid' => $_W['uniacid'],'order_id'=>$order_id,'mch_id'=>0));
       if(!$user_group){
           $user_group_gt=pdo_get('yzcyk_sun_user_groups',array('uniacid' => $_W['uniacid'],'order_id'=>$order_id));
           $user_group=pdo_get('yzcyk_sun_user_groups',array('uniacid' => $_W['uniacid'],'id'=>$user_group_gt['mch_id'],'mch_id'=>0));
       }
       //自己参团信息
        if($user_group['openid']==$_GPC['openid']){
           $myself_group=$user_group;
        }else{
            $myself_group=pdo_get('yzcyk_sun_user_groups',array('uniacid' => $_W['uniacid'],'mch_id'=>$user_group['id'],'openid'=>$_GPC['openid']));
        }

        //参团头像
        $user_img[]= pdo_getcolumn('yzcyk_sun_user', array('openid' =>$user_group['openid'],'uniacid' => $_W['uniacid']), 'img',1);
        //跟团信息
        $user_groups=pdo_getall('yzcyk_sun_user_groups',array('uniacid' => $_W['uniacid'],'mch_id'=>$user_group['id']));
        if($user_group){
            foreach($user_groups as $val){
                $user_img[]=pdo_getcolumn('yzcyk_sun_user', array('openid' =>$val['openid'],'uniacid' => $_W['uniacid']), 'img',1);
            }
        }
        $num=$user_group['buynum']-$user_group['num'];

        for($i=0;$i<$num;$i++){
            $user_img[]='../../../../style/images/nouser.png';
        }
        $data=array(
            'order'=>$order,
            'goodsdetail'=>$goodsdetail,
            'user_group'=>$user_group,
            'user_img'=>$user_img,
            'myself_group'=>$myself_group,
        );
        return $this->result(0,'',$data);
    }
    //获取拼团商品
    public function doPagegetGroupGoods(){
        global $_W, $_GPC;
        $index=$_GPC['index'];
        $flag=$_GPC['flag'];
        if(empty($index)||$index==0){
            $order='sales_num desc,id desc';
        }else if($index==1){
            $order='time desc';
        }else if($index==2){
            $where=array('show_recommend'=>1);
            $order='id desc';
        }else if($index==3){
            if($flag=='false'){
                $order='pintuan_price asc';
            }else if($flag=='true'){
                $order='pintuan_price desc';
            }
        }else if($index==8){
        	$where=array('show_index'=>1);
            $order='id desc';
        }
        $cond=array(
            'uniacid' => $_W['uniacid'],
            'status' =>1,
            'lid'=>4,
            'start_time <='=>time(),
        );
        if(!empty($where)){
            $cond=array_merge($cond,$where);
        }

        $res = pdo_getall('yzcyk_sun_goods',$cond, array(), '',$order);
        if($res){
            foreach($res as &$val){
                $val['lb_img']=explode(',',$val['lb_imgs'])[0];
                $val['clock']='';
                $val['endtime']=$val['end_time']*1000;
                $val['lj']=$val['goods_price']-$val['pintuan_price'];
            }
        }
        echo json_encode($res);
    }
    //获取砍价商品
    public function doPagegetBargainGoods(){
        global $_W, $_GPC;
        $index=$_GPC['index'];
        $flag=$_GPC['flag'];
        if(empty($index)||$index==0){
            $order='sales_num desc,id desc';
        }else if($index==1){
            $order='time desc';
        }else if($index==2){
            $where=array('show_recommend'=>1);
            $order='id desc';
        }else if($index==3){
            if($flag=='false'){
                $order='kanjia_price asc';
            }else if($flag=='true'){
                $order='kanjia_price desc';
            }
        }else if($index==8){
        	$where=array('show_index'=>1);
            $order='id desc';
        }
        $cond=array(
            'uniacid' => $_W['uniacid'],
            'status' =>1,
            'lid'=>5,
            'start_time <='=>time(),
        );
        if(!empty($where)){
            $cond=array_merge($cond,$where);
        }

        $res = pdo_getall('yzcyk_sun_goods',$cond, array(), '',$order);
        foreach($res as &$val){
            $val['lb_img']=explode(',',$val['lb_imgs'])[0];
            $val['clock']='';
            $val['endtime']=$val['end_time']*1000;
           // $val['cj_num']=pdo_fetchcolumn("select count(id) as cj_num from ".tablename('yzcyk_sun_user_bargain')." where gid=".$val['id']." group by openid");     
            $sql="select openid from ".tablename('yzcyk_sun_user_bargain')." where gid=".$val['id']." group by openid";
			$bargain=pdo_fetchall($sql); 
            $openid=array();
            $headimg=array();
            foreach($bargain as $v){  
                if(!empty($v['openid'])){
            		$headimg[]=pdo_getcolumn('yzcyk_sun_user', array('openid' =>$v['openid'],'uniacid' => $_W['uniacid']), 'img',1);
                }
            } 
            $val['cj_num']=count($headimg);
            $val['headimg']=$headimg;
            
        }
        echo json_encode($res);
    }
    //获取限购商品
    public function doPagegetLimitGoods(){
        global $_W, $_GPC;
        $index=$_GPC['index'];
        $flag=$_GPC['flag'];
        if(empty($index)||$index==0){
            $order='sales_num desc,id desc';
        }else if($index==1){
            $order='time desc';
        }else if($index==2){
            $where=array('show_recommend'=>1);
            $order='id desc';
        }else if($index==3){
            if($flag=='false'){
                $order='qianggou_price asc';
            }else if($flag=='true'){
                $order='qianggou_price desc';
            }
        }else if($index==8){
        	$where=array('show_index'=>1);
            $order='id desc';
        }
        $cond=array(
            'uniacid' => $_W['uniacid'],
            'status' =>1,
            'lid'=>6,
            'start_time <='=>time(),
        );
        if(!empty($where)){
            $cond=array_merge($cond,$where);
        }

        $res = pdo_getall('yzcyk_sun_goods',$cond, array(), '',$order);
        foreach($res as &$val){
            $val['lb_img']=explode(',',$val['lb_imgs'])[0];
            $val['clock']='';
            $val['endtime']=$val['end_time']*1000;
        }
        echo json_encode($res);
    }
    //获取好物商品
    public function doPagegetHaowuGoods(){
        global $_W, $_GPC;
        $index=$_GPC['index'];
        if(empty($index)||$index==0){
            $order='sales_num desc,id desc';
        }else if($index==1){
            $order='time desc';
        }else if($index==2){
            $where=array('show_recommend'=>1);
            $order='id desc';
        }else if($index==3){
            $where=array('show_columns'=>1);
            $order='id desc';
        }else if($index==8){
        	$where=array('show_index'=>1);
            $order='id desc';
        }
        $cond=array(
            'uniacid' => $_W['uniacid'],
            'status' =>1,
            'lid'=>3
        );
        if(!empty($where)){
            $cond=array_merge($cond,$where);
        }
        $res = pdo_getall('yzcyk_sun_goods',$cond, array(), '',$order);
        foreach($res as &$val){
            $val['lb_img']=explode(',',$val['lb_imgs'])[0];
        }
        echo json_encode($res);
    }
    //获取预约商品
    public function doPagegetYuyueGoods(){
        global $_W, $_GPC;
        $index=$_GPC['index'];
        $flag=$_GPC['flag'];
        if(empty($index)||$index==0){
            $order='sales_num desc,id desc';
        }else if($index==1){
            $order='time desc';
        }else if($index==2){
            $where=array('show_recommend'=>1);
            $order='id desc';
        }else if($index==3){
            if($flag=='false'){
                $order='goods_price asc';
            }else if($flag=='true'){
                $order='goods_price desc';
            }
        }else if($index==8){
        	$where=array('show_index'=>1);
            $order='id desc';
        }
        $cond=array(
            'uniacid' => $_W['uniacid'],
            'status' =>1,
            'lid'=>2
        );
        if(!empty($where)){
            $cond=array_merge($cond,$where);
        }
        $res = pdo_getall('yzcyk_sun_goods',$cond, array(), '',$order);
        foreach($res as &$val){
            $val['lb_img']=explode(',',$val['lb_imgs'])[0];
        }
        echo json_encode($res);
    }
  
  //优惠券核销
  public function doPagecheckUserCoupon(){
  	   global $_W, $_GPC; 
       $uid=$_GPC['uid'];
       $id=$_GPC['id'];
     /*  $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid'=>$_W['uniacid'],'openid'=>$uid));
       if(!$hxstaff){
            return $this->result(1,'没有核销权限'); 
            exit;
       } */
       $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('uniacid' => $_W['uniacid'],'id'=>$id));   
       if(!$user_coupon){
            return $this->result(1,'请扫描正确核销二维码');
        	exit;
       }
      $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$user_coupon['store_id'],'openid'=>$uid));
      $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid'=>$_W['uniacid'],'store_id'=>$user_coupon['store_id'],'openid'=>$uid,'type'=>1));
      if(!$store&&!$hxstaff){
          return $this->result(1,'没有核销权限');
          exit;
      }

       //修改核销信息
       pdo_update('yzcyk_sun_user_coupon',array('hx_openid'=>$uid,'hx_time'=>time(),'use_time'=>time(),'is_use'=>1),array('id'=>$id));
       $msg['errcode']=0;
       $msg['errmsg']='核销成功';
       echo json_encode($msg); 
  
  }
  //订单号核销
   public function doPagecheckOrder(){
   		global $_W, $_GPC;   
        $uid=$_GPC['uid'];
      /*  $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid'=>$_W['uniacid'],'openid'=>$uid));
        if(!$hxstaff){
        	return $this->result(1,'没有核销权限');
            exit;
        } */
      	$order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$order['store_id'],'openid'=>$uid));
        $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid'=>$_W['uniacid'],'store_id'=>$order['store_id'],'openid'=>$uid,'type'=>1));
        if(!$store&&!$order){
           return $this->result(1,'没有核销权限');
           exit;
        } 
        if($order['order_status']==3){
         	return $this->result(1,'该订单号已核销');
            exit;
        }
      //修改核销信息
        pdo_update('yzcyk_sun_order',array('hx_openid'=>$uid,'hx_time'=>time(),'order_status'=>3,'queren_time'=>time()),array('id'=>$_GPC['id']));
        //活动报名 核销成功增加商户余额 兼容之前下订单完
        if($order['order_lid']==3){
            $yzcyk_sun_mercapdetails=pdo_get('yzcyk_sun_mercapdetails',array('uniacid'=>$_W['uniacid'],'order_id'=>$order['id']));
            if(!$yzcyk_sun_mercapdetails&&$order['order_amount']>0){
                //增加商户账号金额
                pdo_update('yzcyk_sun_store',array('money +='=>$order['order_amount']),array('uniacid'=>$_W['uniacid'],'id'=>$order['store_id']));
                //增加商家收入明细
                $store=pdo_get('yzcyk_sun_store',array('id'=>$order['store_id']));
                $detail='活动订单核销完成-订单id:'.$order['id'].'订单号:'.$order['orderformid'];
                $mercapdetails=array(
                    'uniacid'=>$_W['uniacid'],
                    'store_id'=>$order['store_id'],
                    'store_name'=>$store['store_name'],
                    'mcd_type'=>4,
                    'openid'=>$order['openid'],
                    'sign'=>1,
                    'mcd_memo'=>$detail,
                    'money'=>$order['order_amount'],
                    'order_id'=>$order['id'],
                    'status'=>1,
                    'add_time'=>time(),
                );
                pdo_insert('yzcyk_sun_mercapdetails',$mercapdetails);
            }
            //更新分销
            /*======分销使用====== */
            include_once IA_ROOT . '/addons/yzcyk_sun/inc/func/distribution.php';
            $distribution = new Distribution();
            $distribution->order_id = $_GPC['id'];
            //1车友卡充值，3活动，4入驻
            $distribution->ordertype = 3;
            $distribution->settlecommission();
            /*======分销使用======*/

        }
        $msg['errcode']=0;
        $msg['errmsg']='核销成功';
        echo json_encode($msg);  
   }
  
  //优惠券和订单核销
    public function doPagesetCheckCoupon(){
    	global $_W, $_GPC;   
        $uid=$_GPC['openid'];
       /* $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid'=>$_W['uniacid'],'openid'=>$uid));
        if(!$hxstaff){
        	return $this->result(1,'没有核销权限'); 
            exit;
        } */
        $result=$_GPC['result']?$_GPC['result']:0; 
        $data=explode('-',$result);
        if($data[0]==1){
            $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('uniacid' => $_W['uniacid'],'orderformid'=>$data[1]));
            $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$user_coupon['store_id'],'openid'=>$uid));
            $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid'=>$_W['uniacid'],'store_id'=>$user_coupon['store_id'],'openid'=>$uid,'type'=>1));
            if(!$store&&!$hxstaff){
                return $this->result(1,'没有核销权限');
                exit;
            }
            if(!$user_coupon){
            	return $this->result(1,'请扫描正确核销二维码');
        	    exit;
            }
            if($user_coupon['is_use']==1){
            	return $this->result(1,'该核销单号已核销');
        	    exit;
            }
            $msg['errcode']=1;
            $msg['user_coupon_id']=$user_coupon['id'];
			$msg['uid']=$user_coupon['uid'];
            echo json_encode($msg);
            /*
            pdo_update('yzcyk_sun_user_coupon',array('hx_openid'=>$uid,'hx_time'=>time(),'use_time'=>time(),'is_use'=>1),array('id'=>$user_coupon['id']));
            return $this->result(1,'核销成功');
            exit;*/
          
        }else if($data[0]==2){
         $order=pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'orderformid'=>$data[1]));
         $store=pdo_get('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$order['store_id'],'openid'=>$uid));
         $hxstaff=pdo_get('yzcyk_sun_hxstaff',array('uniacid'=>$_W['uniacid'],'store_id'=>$order['store_id'],'openid'=>$uid,'type'=>1));
         if(!$store&&!$hxstaff){
            return $this->result(1,'没有核销权限');
            exit;
         }
         if($order['order_status']==3){
         	 return $this->result(1,'该订单号已核销');
             exit;
         }
         /*       
         //修改核销信息
         pdo_update('yzcyk_sun_order',array('hx_openid'=>$uid,'hx_time'=>time(),'order_status'=>3,'queren_time'=>time()),array('id'=>$order['id']));
         return $this->result(1,'核销成功'); 
         exit;
          */
          $msg['errcode']=2;
          $msg['orderid']=$order['id'];
          $msg['uid']=$order['openid'];
          echo json_encode($msg);

        }else{
        	return $this->result(1,'核销单号错误');
            exit;
        }
      
        
    
    }
   


    private function setEwm($url){
      include IA_ROOT .'/addons/yzcyk_sun/phpqrcode.php';
      $date=date('Y/m/d/');
      $dir=IA_ROOT . '/attachment/qrcode/'.$date;
      if (!file_exists($dir)){
  		  mkdir ($dir,0777,true); 
	  }
      $qrcode=new \QRcode();
      $qrcode_name=date("YmdHis") .rand(11111, 99999).'.png';
      $qrcode_path='qrcode/'.$date.$qrcode_name;
      $path=$dir.$qrcode_name;
      $qrcode::png($url,$path,'M',4,2);
      //远程附近
        @require_once(IA_ROOT . '/framework/function/file.func.php');
        @$filename = $qrcode_path;
        @file_remote_upload($filename);
      return $qrcode_path;
    }
  	
    //获取优惠券
    public function doPagegetCoupon(){
        global $_W, $_GPC;
        $uid=$_GPC['uid'];
        $sign=$_GPC['signs']?$_GPC['signs']:1;
        $show_index=$_GPC['show_index']?$_GPC['show_index']:0;
        $cond=array(
         'uniacid' => $_W['uniacid'], 
          'state' => 1,
        );
       if($show_index==1){
           $where['show_index']=1;
       }else{
          $where['sign']=$sign;
       }
        $cond=array_merge($cond,$where);
        $coupon= pdo_getall('yzcyk_sun_coupon',$cond);
        foreach($coupon as &$val){
            $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('uniacid' => $_W['uniacid'],'uid'=>$uid,'coupon_id'=>$val['id']));
            if(!empty($user_coupon)){
                $val['status']=2;
            }else if($val['num']-$val['yl_num']<=0){
                $val['status']=1;
            }else{
                $val['status']=0;
            }

        }
        return $this->result(0, '',$coupon );

    }

  //生成二维码
    public function doPagesetEwm(){
        $url='https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token='.$this->getAccess_token1();
        $url='https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$this->getAccess_token1();
        /*$data=array(
            'path'=>'pages/index',
            'width'=>443
        );
        $res=$this->post_data($url,$data);
        var_dump($res);*/

        $path="yzcyk_sun/pages/index/shareDet/shareDet?gid=36"; 
        $width=430;
        $post_data='{"path":"'.$path.'","width":'.$width.'}';
        $post_data='{"scene":"ghabc123","page":"yzcyk_sun/pages/index/shareDet/shareDet","width":"430" }';
        $result=$this->api_notice_increment($url,$post_data);
        var_dump($result);
      //  file_put_contents('ewm1.jpg', $result);
       

    }


    function api_notice_increment($url, $data){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }else{
            return $tmpInfo;
        }
    }

  public  function send_post($url, $post_data,$method='POST') {
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => $method, //or GET
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    //获取access_token
  private function getAccess_token1()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $appid = $res['appid'];
        $secret = $res['appsecret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data, true);
        return $data['access_token'];
    }

    function JSON($array) {
        arrayRecursive ( $array, 'urlencode', true );
        $json = json_encode ( $array );
        return urldecode ( $json );
    }
    // 以POST方式提交数据
    public function post_data($url,$param) {
        $param = '{"path": "pages/index/index", "width": 430}';
        $header [] = "content-type: application/json; charset=UTF-8";
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $res = curl_exec ( $ch );
        var_dump($res);
        exit;
        $flat = curl_errno ( $ch );
        if ($flat) {
            $data = curl_error ( $ch );
        }
        curl_close ( $ch );
        $return_array && $res = json_decode ( $res, true );
        return $res;
    }


    //获取openid
    public function doPageOpenid()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $code = $_GPC['code'];
        $appid = $res['appid'];
        $secret = $res['appsecret'];
   //     $appid='wx991466701277b893';
    //    $secret='95d5c4eef92a8d1471eabbee22632c34';
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $secret . "&js_code=" . $code . "&grant_type=authorization_code";
        function httpRequest($url, $data = null)
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            if (!empty($data)) {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            //执行
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;
        }

        $res = httpRequest($url);
        print_r($res);
    }


    //登录用户信息
    public function doPageLogin()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $res = pdo_get('yzcyk_sun_user', array('openid' => $openid, 'uniacid' => $_W['uniacid']));
        if ($openid and $openid != 'undefined') {
            if ($res) {
                $user_id = $res['id'];
                $data['openid'] = $_GPC['openid'];
                $data['img'] = $_GPC['img'];
                $data['name'] = $_GPC['name'];
                $res = pdo_update('yzcyk_sun_user', $data, array('id' => $user_id));
                $user = pdo_get('yzcyk_sun_user', array('openid' => $openid, 'uniacid' => $_W['uniacid']));
                echo json_encode($user);
            } else {
                $data['openid'] = $_GPC['openid'];
                $data['img'] = $_GPC['img'];
                $data['name'] = $_GPC['name'];
                $data['uniacid'] = $_W['uniacid'];
                $data['time'] = time();
                $res2 = pdo_insert('yzcyk_sun_user', $data);
                $user = pdo_get('yzcyk_sun_user', array('openid' => $openid, 'uniacid' => $_W['uniacid']));
                echo json_encode($user);
            }
        }
    }

    //广告
    public function doPageAd()
    {
        global $_GPC, $_W;
        $where = " where uniacid=:uniacid and status=1";
        if ($_GPC['cityname']) {
            $where .= " and cityname LIKE  concat('%', :name,'%')";
            $data[':name'] = $_GPC['cityname'];
        }
        $data[':uniacid'] = $_W['uniacid'];
        $sql = "select * from " . tablename('yzcyk_sun_ad') . $where . " order by orderby asc";
        $res = pdo_fetchall($sql, $data);
        echo json_encode($res);
    }

    public function doPagegetAttachUrl()
    {
        global $_GPC, $_W;
        echo $_W['attachurl'];
    }
     public function doPageUrl1()
    {
        global $_GPC, $_W;
        echo $_W['attachurl'];
    }

//url
    public function doPageUrl2()
    {
        global $_W, $_GPC;
        echo $_W['siteroot'];
    }

    //商品分类
    public function doPageType()
    {
        global $_GPC, $_W;
        $res_first=array('id'=>0,'type_name'=>'全部');
        $res = pdo_getall('yzcyk_sun_type', array('uniacid' => $_W['uniacid'], 'state' => 1), array(), '', 'num asc');
        array_unshift($res,$res_first);
        echo json_encode($res);
    }

    //子分类
    public function doPageType2()
    {
        global $_GPC, $_W;
        $res = pdo_getall('yzcyk_sun_type2', array('type_id' => $_GPC['id']), array(), '', 'num asc');
        echo json_encode($res);
    }

    //发帖
    public function doPagePosting()
    {
        global $_GPC, $_W;
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['details'] = $_GPC['details'];//帖子内容
        $data['img'] = $_GPC['img'];//帖子图片
        $data['user_id'] = $_GPC['user_id'];//用户id
        $data['user_name'] = $_GPC['user_name'];//姓名
        $data['user_tel'] = $_GPC['user_tel'];//电话
        $data['type2_id'] = $_GPC['type2_id'];//子分类id
        $data['type_id'] = $_GPC['type_id'];//主分类id
        $data['money'] = $_GPC['money'];//价格
        $data['top_type'] = $_GPC['type'];//置顶类型
        $data['address'] = $_GPC['address'];//帖子地址
        $data['store_id'] = $_GPC['store_id'];
        $data['cityname'] = $_GPC['cityname'];
        if ($_GPC['type']) {
            $data['top'] = 1;
        } else {
            $data['top'] = 2;
        }
        $data['time'] = time();
        $data['uniacid'] = $_W['uniacid'];
        if ($system['tz_audit'] == 2) {
            $data['sh_time'] = time();
            $data['state'] = 2;
        } else {
            $data['state'] = 1;
        }
        $data['hb_money'] = $_GPC['hb_money'];//红包金额
        $data['hb_num'] = $_GPC['hb_num'];//红包个数
        $data['hb_type'] = $_GPC['hb_type'];//红包类型1.普通 2.口令
        $data['hb_keyword'] = $_GPC['hb_keyword'];//红包口令
        $data['hb_random'] = $_GPC['hb_random'];//随机1.是 2否
        if ($_GPC['hb_random'] == 1) {
            function sendRandBonus($total = 0, $count = 3)
            {

                $input = range(0.01, $total, 0.01);
                if ($count > 1) {
                    $rand_keys = (array)array_rand($input, $count - 1);
                    $last = 0;
                    foreach ($rand_keys as $i => $key) {
                        $current = $input[$key] - $last;
                        $items[] = $current;
                        $last = $input[$key];
                    }
                }
                $items[] = $total - array_sum($items);
                return $items;
            }

            $hong = json_encode(sendRandBonus($_GPC['hb_money'], $_GPC['hb_num']));
            $data['hong'] = $hong;
        }

        $res = pdo_insert('yzcyk_sun_information', $data);
        $tz_id = pdo_insertid();
        $post_id = pdo_insertid();
        $a = json_decode(html_entity_decode($_GPC['sz']));
        $sz = json_decode(json_encode($a), true);
        // print_r($sz);die;
        if ($res) {
            for ($i = 0; $i < count($sz); $i++) {
                $data2['label_id'] = $sz[$i]['label_id'];
                $data2['information_id'] = $post_id;
                $res2 = pdo_insert('yzcyk_sun_mylabel', $data2);
            }
            //echo '1';
            echo $tz_id;
        } else {
            echo '2';
        }
    }

    //修改帖子
    public function doPageUpdPost()
    {
        global $_GPC, $_W;
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['details'] = $_GPC['details'];//帖子内容
        $data['img'] = $_GPC['img'];//帖子图片
        $data['user_id'] = $_GPC['user_id'];//用户id
        $data['user_name'] = $_GPC['user_name'];//姓名
        $data['user_tel'] = $_GPC['user_tel'];//电话
        $data['type2_id'] = $_GPC['type2_id'];//子分类id
        $data['type_id'] = $_GPC['type_id'];//主分类id
        $data['money'] = $_GPC['money'];//价格
        $data['address'] = $_GPC['address'];//帖子地址
        $data['store_id'] = $_GPC['store_id'];
        $data['top_type'] = $_GPC['top_type'];
        if ($_GPC['top_type']) {
            $data['top'] = 1;
        }

        $data['cityname'] = $_GPC['cityname'];
        $data['time'] = time();
        $data['uniacid'] = $_W['uniacid'];
        if ($system['tz_audit'] == 2) {
            $data['sh_time'] = time();
            $data['state'] = 2;
        } else {
            $data['state'] = 1;
        }
        $res = pdo_update('yzcyk_sun_information', $data, array('id' => $_GPC['id']));
        pdo_delete('yzcyk_sun_mylabel', array('information_id' => $_GPC['id']));
        $a = json_decode(html_entity_decode($_GPC['sz']));
        $sz = json_decode(json_encode($a), true);
        // print_r($sz);die;
        if ($res) {
            for ($i = 0; $i < count($sz); $i++) {
                $data2['label_id'] = $sz[$i]['label_id'];
                $data2['information_id'] = $post_id;
                $res2 = pdo_insert('yzcyk_sun_mylabel', $data2);
            }
            echo '1';
        } else {
            echo '2';
        }
    }

//删除帖子
    public function doPageDelPost()
    {
        global $_GPC, $_W;
        $res = pdo_update('yzcyk_sun_information', array('del' => 1), array('id' => $_GPC['id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }


    //帖子点赞
    public function doPageLike()
    {
        global $_GPC, $_W;
        $data['information_id'] = $_GPC['information_id'];
        $data['user_id'] = $_GPC['user_id'];
        $res = pdo_get('yzcyk_sun_like', $data);
        if ($res) {
            echo '不能重复点赞!';
        } else {
            pdo_insert('yzcyk_sun_like', $data);
            pdo_update('yzcyk_sun_zx', array('td_num +=' => 1), array('id' => $_GPC['information_id']));
            echo '1';
        }

    }

//点赞数量
    public function doPageZxLikeNum()
    {
        $res = pdo_getall('yzcyk_sun_like');
        return $this->result(0, '', $res);
    }

    //资讯点赞
    public function doPageZxLike()
    {
        global $_GPC, $_W;
        $data['zx_id'] = $_GPC['zx_id'];
        $data['user_id'] = $_GPC['user_id'];
        $res = pdo_get('yzcyk_sun_like', $data);
        if ($res) {
            echo '不能重复点赞!';
        } else {
            $res2 = pdo_insert('yzcyk_sun_like', $data);
            if ($res2) {
                echo '1';
            } else {
                echo '2';
            }

        }

    }

//资讯点赞头像
    public function doPageZxLikeImg()
    {
        global $_GPC, $_W;
        $zxid = $_GPC['zxid'];
        $sql = 'SELECT * FROM ' . tablename('yzcyk_sun_like') . ' l ' . ' JOIN ' . tablename('yzcyk_sun_user') . ' u ' . ' ON ' . 'l.user_id=u.id' . ' WHERE ' . 'l.zx_id=' . $zxid . ' LIMIT 0, 5';
        $zxImg = pdo_fetchall($sql);
        echo json_encode($zxImg);
    }

//资讯点赞人数
    public function doPageZxLikeLength()
    {
        global $_GPC, $_W;
        $zxid = $_GPC['zxid'];
        $length = pdo_getall('yzcyk_sun_like', ['zx_id' => $zxid]);
        echo json_encode($length);
    }

//资讯点赞列表
    public function doPageZxLikeList()
    {
        global $_GPC, $_W;
        $sql = "select a.*,b.img as user_img ,b.name as user_name from " . tablename("yzcyk_sun_like") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.zx_id=:zx_id  ORDER BY a.id DESC";
        $res = pdo_fetchall($sql, array(':zx_id' => $_GPC['zx_id']));
        echo json_encode($res);

    }


    //查看我的帖子
    public function doPageMyPost()
    {
        global $_GPC, $_W;
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $sql = "select a.*,b.type_name,c.name as type2_name from " . tablename("yzcyk_sun_information") . " a" . " left join " . tablename("yzcyk_sun_type") . " b on b.id=a.type_id  " . " left join " . tablename("yzcyk_sun_type2") . " c on a.type2_id=c.id   WHERE a.user_id=:user_id and a.del=2 ORDER BY a.id DESC";
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, array(':user_id' => $_GPC['user_id']));

        echo json_encode($res);
    }

//查看商家的帖子
    public function doPageStorePost()
    {
        global $_GPC, $_W;
        $res = pdo_getall('yzcyk_sun_information', array('store_id' => $_GPC['store_id'], 'del' => 2));
        echo json_encode($res);
    }

    //查看商家帖子列表
    public function doPageStorePostList()
    {
        global $_GPC, $_W;
        $sql = "select a.*,b.logo from " . tablename("yzcyk_sun_information") . " a" . " left join " . tablename("yzcyk_sun_store") . " b on b.id=a.store_id  WHERE a.uniacid=:uniacid and a.store_id!='' and a.del=2 ORDER BY a.id DESC";
        $res = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
        //  $res=pdo_getall('yzcyk_sun_information',array('uniacid'=>$_W['uniacid'],'store_id !='=>''));
        echo json_encode($res);
    }

    //查看帖子详情
    public function doPagePostInfo()
    {
        global $_GPC, $_W;
        pdo_update('yzcyk_sun_information', array('views +=' => 1), array('id' => $_GPC['id']));
        $sql = "select a.*,b.type_name,c.name as type2_name,d.img as user_img,e.logo,e.coordinates from " . tablename("yzcyk_sun_information") . " a" . " left join " . tablename("yzcyk_sun_type") . " b on b.id=a.type_id  " . " left join " . tablename("yzcyk_sun_type2") . " c on a.type2_id=c.id " . " left join " . tablename("yzcyk_sun_user") . " d on a.user_id=d.id" . " left join " . tablename("yzcyk_sun_store") . " e on a.store_id=e.id  WHERE a.id=:id  ORDER BY a.id DESC";
        $res = pdo_fetch($sql, array(':id' => $_GPC['id']));

        $sql2 = "select a.*,b.img as user_img from " . tablename("yzcyk_sun_like") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.information_id=:id  ORDER BY a.id DESC";
        $res2 = pdo_fetchall($sql2, array(':id' => $_GPC['id']));
        $sql3 = "select a.*,b.img as user_img,b.name from " . tablename("yzcyk_sun_comments") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.information_id=:id  ORDER BY a.id DESC";
        $res3 = pdo_fetchall($sql3, array(':id' => $_GPC['id']));
        $sql4 = "select a.*,b.label_name from " . tablename("yzcyk_sun_mylabel") . " a" . " left join " . tablename("yzcyk_sun_label") . " b on b.id=a.label_id  WHERE a.information_id=:id  ORDER BY a.id DESC";
        $res4 = pdo_fetchall($sql4, array(':id' => $_GPC['id']));
        $data['tz'] = $res;
        $data['dz'] = $res2;
        $data['pl'] = $res3;
        $data['label'] = $res4;
        echo json_encode($data);
    }

    //查看二级分类下的帖子
    public function doPagePostList()
    {
        global $_GPC, $_W;

        $time = time() - 24 * 60 * 60;//一天
        $time2 = time() - 24 * 7 * 60 * 60;//一周
        $time3 = time() - 24 * 30 * 60 * 60;//一个月
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time, 'top_type' => 1, 'state' => 2));
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time2, 'top_type' => 2, 'state' => 2));
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time3, 'top_type' => 3, 'state' => 2));
        $list = pdo_getall('yzcyk_sun_information', array('uniacid' => $_W['uniacid'], 'state' => 2));
        for ($j = 0; $j < count($list); $j++) {
            if ($list[$j]['top_type'] == 1) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60), array('id' => $list[$j]['id']));
            } elseif ($list[$j]['top_type'] == 2) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60 * 7), array('id' => $list[$j]['id']));
            } elseif ($list[$j]['top_type'] == 3) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60 * 60), array('id' => $list[$j]['id']));
            }
        }
        $where = " WHERE a.type2_id=:type2_id and a.state=:state and a.del=2";
        $data[':type2_id'] = $_GPC['type2_id'];
        $data[':state'] = 2;

        if ($_GPC['cityname']) {
            $where .= " and a.cityname LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['cityname'];
        }
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $sql = "select a.*,b.img as user_img,c.logo from " . tablename("yzcyk_sun_information") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id" . " left join " . tablename("yzcyk_sun_store") . " c on c.id=a.store_id" . $where . " ORDER BY a.top asc,a.id DESC";
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, $data);

        $sql2 = "select a.*,b.label_name from " . tablename("yzcyk_sun_mylabel") . " a" . " left join " . tablename("yzcyk_sun_label") . " b on b.id=a.label_id";
        $res2 = pdo_fetchall($sql2);

        // $res2=pdo_getall('yzcyk_sun_label',array('uniacid'=>$_W['uniacid']));
        $data2 = array();

        for ($i = 0; $i < count($res); $i++) {
            $data = array();
            for ($k = 0; $k < count($res2); $k++) {
                if ($res[$i]['id'] == $res2[$k]['information_id']) {
                    $data[] = array(
                        'label_name' => $res2[$k]['label_name']
                    );
                }
            }
            $data2[] = array(
                'tz' => $res[$i],
                'label' => $data
            );
        }


        echo json_encode($data2);
    }

    //大分类帖子列表
    public function doPageList()
    {
        global $_GPC, $_W;
        $time = time() - 24 * 60 * 60;//一天
        $time2 = time() - 24 * 7 * 60 * 60;//一周
        $time3 = time() - 24 * 30 * 60 * 60;//一个月
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time, 'top_type' => 1, 'state' => 2));
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time2, 'top_type' => 2, 'state' => 2));
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time3, 'top_type' => 3, 'state' => 2));
        $where = " where a.type_id=:type_id and a.state=:state and a.del=2 ";
        $list = pdo_getall('yzcyk_sun_information', array('uniacid' => $_W['uniacid'], 'state' => 2));
        for ($j = 0; $j < count($list); $j++) {
            if ($list[$j]['top_type'] == 1) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60), array('id' => $list[$j]['id']));
            } elseif ($list[$j]['top_type'] == 2) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60 * 7), array('id' => $list[$j]['id']));
            } elseif ($list[$j]['top_type'] == 3) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60 * 60), array('id' => $list[$j]['id']));
            }
        }
        $data[':type_id'] = $_GPC['type_id'];
        $data[':state'] = 2;
        if ($_GPC['cityname']) {
            $where .= " and a.cityname LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['cityname'];
        }
        $sql = "select a.*,b.img as user_img,c.logo from " . tablename("yzcyk_sun_information") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id" . " left join " . tablename("yzcyk_sun_store") . " c on c.id=a.store_id" . $where . " ORDER BY a.top asc,a.id DESC";
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, $data);
        //  $res=pdo_fetchall($sql,array(':type_id'=>$_GPC['type_id'],':state'=>2));
        $sql2 = "select a.*,b.label_name from " . tablename("yzcyk_sun_mylabel") . " a" . " left join " . tablename("yzcyk_sun_label") . " b on b.id=a.label_id";
        $res2 = pdo_fetchall($sql2);

        // $res2=pdo_getall('yzcyk_sun_label',array('uniacid'=>$_W['uniacid']));
        $data2 = array();
        for ($i = 0; $i < count($res); $i++) {
            $data = array();
            for ($k = 0; $k < count($res2); $k++) {
                if ($res[$i]['id'] == $res2[$k]['information_id']) {
                    $data[] = array(
                        'label_name' => $res2[$k]['label_name']
                    );
                }
            }
            $data2[] = array(
                'tz' => $res[$i],
                'label' => $data
            );
        }

        echo json_encode($data2);
    }

//所有帖子列表
    public function doPageList2()
    {
        global $_GPC, $_W;
        $time = time() - 24 * 60 * 60;//一天
        $time2 = time() - 24 * 7 * 60 * 60;//一周
        $time3 = time() - 24 * 30 * 60 * 60;//一个月
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time, 'top_type' => 1, 'state' => 2));
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time2, 'top_type' => 2, 'state' => 2));
        pdo_update('yzcyk_sun_information', array('top' => 2), array('sh_time <=' => $time3, 'top_type' => 3, 'state' => 2));
        $list = pdo_getall('yzcyk_sun_information', array('uniacid' => $_W['uniacid'], 'state' => 2));
        for ($j = 0; $j < count($list); $j++) {
            if ($list[$j]['top_type'] == 1) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60), array('id' => $list[$j]['id']));
            } elseif ($list[$j]['top_type'] == 2) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60 * 7), array('id' => $list[$j]['id']));
            } elseif ($list[$j]['top_type'] == 3) {
                pdo_update('yzcyk_sun_information', array('dq_time' => $list[$j]['sh_time'] + 24 * 60 * 60 * 60), array('id' => $list[$j]['id']));
            }
        }
        $where = " WHERE a.state=:state and a.del=2  and a.user_id != 0 and a.uniacid=:uniacid";
        $data[':state'] = 2;
        $data[':uniacid'] = $_W['uniacid'];
        if ($_GPC['keywords']) {
            $where .= " and a.details LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['keywords'];
        }
        if ($_GPC['type_id']) {
            $where .= " and  a.type_id=:type_id ";
            $data[':type_id'] = $_GPC['type_id'];
        }
        if ($_GPC['cityname']) {
            $where .= " and a.cityname LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['cityname'];
        }
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $sql = "select a.*,b.img as user_img,c.type_name,d.name as type2_name  from" . tablename("yzcyk_sun_information") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id " . " left join " . tablename("yzcyk_sun_type") . " c on a.type_id=c.id " . " left join " . tablename("yzcyk_sun_type2") . " d on a.type2_id=d.id " . $where . " ORDER BY a.top asc,a.id DESC";
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, $data);
        $sql2 = "select a.*,b.label_name from " . tablename("yzcyk_sun_mylabel") . " a" . " left join " . tablename("yzcyk_sun_label") . " b on b.id=a.label_id";
        $res2 = pdo_fetchall($sql2);
// $res2=pdo_getall('yzcyk_sun_label',array('uniacid'=>$_W['uniacid']));
        $data2 = array();
        for ($i = 0; $i < count($res); $i++) {
            $data = array();
            for ($k = 0; $k < count($res2); $k++) {
                if ($res[$i]['id'] == $res2[$k]['information_id']) {
                    $data[] = array(
                        'label_name' => $res2[$k]['label_name']
                    );
                }
            }
            $data2[] = array(
                'tz' => $res[$i],
                'label' => $data
            );
        }
        echo json_encode($data2);
    }

    //查看二级分类下的标签
    public function doPageLabel()
    {
        global $_GPC, $_W;
        $res = pdo_getall('yzcyk_sun_label', array('type2_id' => $_GPC['type2_id']));
        echo json_encode($res);
    }

    //帖子评论
    public function doPageComments()
    {
        global $_GPC, $_W;
        $data['information_id'] = $_GPC['information_id'];
        $data['user_id'] = $_GPC['user_id'];
        $data['details'] = $_GPC['details'];
        $data['time'] = time();
        $res = pdo_insert('yzcyk_sun_comments', $data);
        $assess_id = pdo_insertid();
        if ($res) {
            echo $assess_id;
        } else {
            echo 'error';
        }
    }

    //商家评分
    public function doPageStoreComments()
    {
        global $_GPC, $_W;

        $data['store_id'] = $_GPC['store_id'];
        $data['user_id'] = $_GPC['user_id'];
        $data['details'] = $_GPC['details'];
        $data['score'] = $_GPC['score'];
        $data['time'] = time();
        $res = pdo_insert('yzcyk_sun_comments', $data);
        $assess_id = pdo_insertid();
        if ($res) {
            $total = pdo_get('yzcyk_sun_comments', array('store_id' => $_GPC['store_id']), array('sum(score) as total'));
            $count = pdo_get('yzcyk_sun_comments', array('store_id' => $_GPC['store_id']), array('count(id) as count'));
            if ($total['total'] > 0 and $count['count'] > 0) {
                $pf = ($total['total'] / $count['count']);
            } else {
                $pf = 0;
            }
            pdo_update('yzcyk_sun_store', array('score' => $pf), array('id' => $_GPC['store_id']));
            echo $assess_id;
        } else {
            echo '2';
        }
    }

    //回复
    public function doPageReply()
    {
        global $_GPC, $_W;
        $data['reply'] = $_GPC['reply'];
        $data['hf_time'] = time();
        $res = pdo_update('yzcyk_sun_comments', $data, array('id' => $_GPC['id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //总浏览量
    public function doPageViews()
    {
        global $_W, $_GPC;
        $sql = "select sum(views) as num from " . tablename("yzcyk_sun_information") . " WHERE uniacid=" . $_W['uniacid'];
        $total = pdo_fetch($sql);
        pdo_update('yzcyk_sun_system', array('total_num +=' => 1), array('uniacid' => $_W['uniacid']));
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));

        echo($total['num'] + $system['total_num']);
    }

    //帖子总量
    public function doPageNum()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_information', array('uniacid' => $_W['uniacid']));
        $total = count($res);
        $res2 = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        echo count($res) + $res2['tz_num'];

    }

    //置顶
    public function doPageTop()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_top', array('uniacid' => $_W['uniacid']), array(), '', 'num asc');
        echo json_encode($res);
    }

//    //支付
//    public function doPagePay(){
//      global $_W, $_GPC;
//      include IA_ROOT.'/addons/yzcyk_sun/wxpay.php';
//      $res=pdo_get('yzcyk_sun_system',array('uniacid'=>$_W['uniacid']));
//      $appid=$res['appid'];
//        $openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
//        $mch_id=$res['mchid'];
//        $key=$res['wxkey'];
//        $out_trade_no = $mch_id. time();
//        $total_fee =$_GPC['money'];
//            if(empty($total_fee)) //押金
//            {
//              $body = "订单付款";
//              $total_fee = floatval(99*100);
//            }else{
//             $body = "订单付款";
//             $total_fee = floatval($total_fee*100);
//           }
//           if($_GPC['order_id']){
//           		pdo_update('yzcyk_sun_order',array('out_trade_no'=>$out_trade_no),array('id'=>$_GPC['order_id']));
//           }
//           $weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee);
//           $return=$weixinpay->pay();
//           echo json_encode($return);
//         }
    //商家入驻
    public function doPageStore()
    {
        global $_W, $_GPC;
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['user_id'] = $_GPC['user_id'];//用户id
        $data['store_name'] = $_GPC['store_name'];//商家名称
        $data['address'] = $_GPC['address'];//地址
        $data['announcement'] = $_GPC['announcement'];//公告
        $data['storetype_id'] = $_GPC['storetype_id'];//行业分类id
        $data['storetype2_id'] = $_GPC['storetype2_id'];//之行业分类id
        $data['area_id'] = $_GPC['area_id'];//区域id
        $data['start_time'] = $_GPC['start_time'];//营业时间
        $data['end_time'] = $_GPC['end_time'];//营业时间
        $data['keyword'] = $_GPC['keyword'];//关键字
        $data['skzf'] = $_GPC['skzf'];//刷卡支付
        $data['wifi'] = $_GPC['wifi'];//wifi
        $data['mftc'] = $_GPC['mftc'];//免费停车
        $data['jzxy'] = $_GPC['jzxy'];//禁止吸烟
        $data['tgbj'] = $_GPC['tgbj'];//提供包间
        $data['sfxx'] = $_GPC['sfxx'];//沙发休闲
        $data['tel'] = $_GPC['tel'];//电话
        $data['logo'] = $_GPC['logo'];//商家logo
        $data['vr_link'] = $_GPC['vr_link'];//vr
        $data['weixin_logo'] = $_GPC['weixin_logo'];//老板微信
        $data['ad'] = $_GPC['ad'];//轮播图
        $data['img'] = $_GPC['img'];//商家图片
        $data['start_time'] = $_GPC['start_time'];
        $data['end_time'] = $_GPC['end_time'];
        $data['cityname'] = $_GPC['cityname'];
        if ($system['sj_audit'] == 2) {
            $data['sh_time'] = time();
            $data['state'] = 2;
        } else {
            $data['state'] = 1;
        }
        if ($_GPC['type']) {
            $data['type'] = $_GPC['type'];//入驻类型
            $data['time_over'] = 2;
        }
        $data['time'] = date('Y-m-d H:i:s', time());
        $data['money'] = $_GPC['money'];//付款价格
        $data['details'] = $_GPC['details'];//商家简介
        $data['coordinates'] = $_GPC['coordinates'];//坐标
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_store', $data);
        $store_id = pdo_insertid();
        if ($res) {
            //echo '1';
            echo $store_id;
        } else {
            echo '2';
        }

    }

    //修改入驻
    public function doPageUpdStore()
    {
        global $_W, $_GPC;
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        //$data['user_id']=$_GPC['user_id'];//用户id
        $data['store_name'] = $_GPC['store_name'];//商家名称
        $data['address'] = $_GPC['address'];//地址
        $data['announcement'] = $_GPC['announcement'];//公告
        $data['storetype_id'] = $_GPC['storetype_id'];//行业分类id
        $data['storetype2_id'] = $_GPC['storetype2_id'];//之行业分类id
        $data['area_id'] = $_GPC['area_id'];//区域id
        $data['start_time'] = $_GPC['start_time'];//营业时间
        $data['end_time'] = $_GPC['end_time'];//营业时间
        $data['keyword'] = $_GPC['keyword'];//关键字
        $data['skzf'] = $_GPC['skzf'];//刷卡支付
        $data['wifi'] = $_GPC['wifi'];//wifi
        $data['mftc'] = $_GPC['mftc'];//免费停车
        $data['jzxy'] = $_GPC['jzxy'];//禁止吸烟
        $data['tgbj'] = $_GPC['tgbj'];//提供包间
        $data['sfxx'] = $_GPC['sfxx'];//沙发休闲
        $data['tel'] = $_GPC['tel'];//电话
        $data['logo'] = $_GPC['logo'];//商家logo
        $data['vr_link'] = $_GPC['vr_link'];//vr
        $data['weixin_logo'] = $_GPC['weixin_logo'];//老板微信
        $data['ad'] = $_GPC['ad'];//轮播图
        $data['img'] = $_GPC['img'];//商家图片
        if ($system['sj_audit'] == 2) {
            //$data['sh_time']=time();
            $data['state'] = 2;
        } else {
            $data['state'] = 1;
        }
        if ($_GPC['type']) {
            $data['type'] = $_GPC['type'];//入驻类型
            $data['time_over'] = 2;

        }

        $data['money'] = $_GPC['money'];//付款价格
        $data['details'] = $_GPC['details'];//商家简介
        $data['coordinates'] = $_GPC['coordinates'];//坐标
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_update('yzcyk_sun_store', $data, array('id' => $_GPC['id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }

    }

    //商家列表
    public function doPageStoreList()
    {
        global $_W, $_GPC;
        $time = time() - 24 * 60 * 60 * 7;//一周
        $time2 = time() - 24 * 182 * 60 * 60;//半年
        $time3 = time() - 24 * 365 * 60 * 60;//一年
        pdo_update('yzcyk_sun_store', array('time_over' => 1), array('sh_time <=' => $time, 'type' => 1, 'state' => 2));
        pdo_update('yzcyk_sun_store', array('time_over' => 1), array('sh_time <=' => $time2, 'type' => 2, 'state' => 2));
        pdo_update('yzcyk_sun_store', array('time_over' => 1), array('sh_time <=' => $time3, 'type' => 3, 'state' => 2));
        $list = pdo_getall('yzcyk_sun_store', array('uniacid' => $_W['uniacid'], 'state' => 2));
        for ($i = 0; $i < count($list); $i++) {
            if ($list[$i]['type'] == 1) {
                pdo_update('yzcyk_sun_store', array('dq_time' => $list[$i]['sh_time'] + 24 * 60 * 60 * 7), array('id' => $list[$i]['id']));
            } elseif ($list[$i]['type'] == 2) {
                pdo_update('yzcyk_sun_store', array('dq_time' => $list[$i]['sh_time'] + 24 * 60 * 60 * 182), array('id' => $list[$i]['id']));
            } elseif ($list[$i]['type'] == 3) {
                pdo_update('yzcyk_sun_store', array('dq_time' => $list[$i]['sh_time'] + 24 * 60 * 60 * 365), array('id' => $list[$i]['id']));
            }
        }
        $where = " where uniacid=:uniacid and time_over !=1 and state=2";
        $data[':uniacid'] = $_W['uniacid'];
        if ($_GPC['keywords']) {
            $where .= " and (store_name LIKE  concat('%', :name,'%') or keyword LIKE  concat('%', :name,'%'))";
            $data[':name'] = $_GPC['keywords'];
        }
        if ($_GPC['cityname']) {
            $where .= " and cityname LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['cityname'];
        }
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $sql = "select * from" . tablename('yzcyk_sun_store') . $where . " order by is_top,sh_time DESC";
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, $data);

        // $res=pdo_getall('yzcyk_sun_store',array('uniacid'=>$_W['uniacid'],'time_over !='=>1),array(),'','num asc');
        echo json_encode($res);
    }

    //分类下商家列表
    public function doPageTypeStoreList()
    {
        global $_W, $_GPC;
        $time = time() - 24 * 60 * 60 * 7;//一周
        $time2 = time() - 24 * 182 * 60 * 60;//半年
        $time3 = time() - 24 * 365 * 60 * 60;//一年
        pdo_update('yzcyk_sun_store', array('time_over' => 1), array('sh_time <=' => $time, 'type' => 1, 'state' => 2));
        pdo_update('yzcyk_sun_store', array('time_over' => 1), array('sh_time <=' => $time2, 'type' => 2, 'state' => 2));
        pdo_update('yzcyk_sun_store', array('time_over' => 1), array('sh_time <=' => $time3, 'type' => 3, 'state' => 2));
        $list = pdo_getall('yzcyk_sun_store', array('uniacid' => $_W['uniacid'], 'state' => 2));
        for ($i = 0; $i < count($list); $i++) {
            if ($list[$i]['type'] == 1) {
                pdo_update('yzcyk_sun_store', array('dq_time' => $list[$i]['sh_time'] + 24 * 60 * 60 * 7), array('id' => $list[$i]['id']));
            } elseif ($list[$i]['type'] == 2) {
                pdo_update('yzcyk_sun_store', array('dq_time' => $list[$i]['sh_time'] + 24 * 60 * 60 * 182), array('id' => $list[$i]['id']));
            } elseif ($list[$i]['type'] == 3) {
                pdo_update('yzcyk_sun_store', array('dq_time' => $list[$i]['sh_time'] + 24 * 60 * 60 * 365), array('id' => $list[$i]['id']));
            }
        }
        $res = pdo_getall('yzcyk_sun_store', array('uniacid' => $_W['uniacid'], 'time_over !=' => 1, 'storetype_id' => $_GPC['storetype_id'], 'state' => 2), array(), '', 'num asc');
        echo json_encode($res);
    }

    //查看我的商家信息
    public function doPageMyStore()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.type_name,c.name as type2_name from " . tablename("yzcyk_sun_store") . " a" . " left join " . tablename("yzcyk_sun_storetype") . " b on b.id=a.storetype_id  " . " left join " . tablename("yzcyk_sun_storetype2") . " c on a.storetype2_id=c.id  WHERE a.id=:store_id  ORDER BY a.id DESC";
        $res = pdo_fetch($sql, array(':store_id' => $_GPC['user_id']));
        echo json_encode($res);
    }

    public function doPageSjdLogin()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.type_name,c.name as type2_name from " . tablename("yzcyk_sun_store") . " a" . " left join " . tablename("yzcyk_sun_storetype") . " b on b.id=a.storetype_id  " . " left join " . tablename("yzcyk_sun_storetype2") . " c on a.storetype2_id=c.id  WHERE a.user_id=:user_id  ORDER BY a.id DESC";
        $res = pdo_fetch($sql, array(':user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }

    //商家详情
    public function doPageStoreInfo()
    {
        global $_W, $_GPC;
        pdo_update('yzcyk_sun_store', array('views +=' => 1), array('id' => $_GPC['id']));
        $res = pdo_getall('yzcyk_sun_store', array('id' => $_GPC['id']));
        $sql2 = "select a.*,b.img as user_img,b.name from " . tablename("yzcyk_sun_comments") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.store_id=:id  ORDER BY a.id DESC";
        $res2 = pdo_fetchall($sql2, array(':id' => $_GPC['id']));
        $data['store'] = $res;
        $data['pl'] = $res2;
        echo json_encode($data);
    }

    //区域信息
    public function doPageArea()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_area', array('uniacid' => $_W['uniacid']));
        echo json_encode($res);
    }

    //行业分类
    public function doPageStoreType()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_storetype', array('uniacid' => $_W['uniacid'], 'state' => 1), array(), '', 'num asc');
        echo json_encode($res);
    }

    //二级行业分类
    public function doPageStoreType2()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_storetype2', array('type_id' => $_GPC['type_id']));
        echo json_encode($res);
    }

    //地图
    public function doPageMap()
    {
        global $_GPC, $_W;
        $op = $_GPC['op'];
        $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $url = "https://apis.map.qq.com/ws/geocoder/v1/?location=" . $op . "&key=" . $res['mapkey'] . "&get_poi=0&coord_type=1";
        $html = file_get_contents($url);
        echo $html;
    }

    //系统设置
    public function doPageSystem()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        if(!empty($res['provide'])){
            $res['provide']=explode(',',$res['provide']);
        }
    //    $index_layout=json_decode($res['index_layout'],true);
        $res['index_layout']=$this->getIndexLayout();
        $res['shopdes_img']=explode(',', $res['shopdes_img']);
        $res['shop_banner']=explode(',', $res['shop_banner']);
        echo json_encode($res);
    }

    //获取首页布局
    private function getIndexLayout()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $index_layout=json_decode($res['index_layout'],true);
        $index_layout=$this->second_array_unique_bykey($index_layout,'name');
        $index_layout_arr=array(
            array('order'=>7,'status'=>false,'name'=>'qzcard'),
            array('order'=>7,'status'=>false,'name'=>'banner'),
            array('order'=>7,'status'=>false,'name'=>'notice'),
            array('order'=>7,'status'=>false,'name'=>'icons'),
            array('order'=>7,'status'=>false,'name'=>'wyfee'),
            array('order'=>7,'status'=>false,'name'=>'storyst'),
            array('order'=>7,'status'=>false,'name'=>'recommend'),
        );
        foreach($index_layout as $key=>$val){
            foreach($index_layout_arr as &$v){
                if($val['name']==$v['name']){
                    $v['order']=$key;
                    $v['status']=true;
                }
            }
        }
        return $index_layout_arr;
    }
    //二维数组去除键值一样的一维数组
    public function second_array_unique_bykey($arr, $key){
        $tmp_arr = array();
        foreach($arr as $k => $v){
            if(in_array($v[$key], $tmp_arr)){
              unset($arr[$k]);
            }else{
                $tmp_arr[$k] = $v[$key];
            }
        }
        //ksort($arr); //ksort函数对数组进行排序(保留原键值key) sort为不保留key值
        return $arr;
    }

//公告列表
    public function doPageNews()
    {
        global $_GPC, $_W;
        $where = " where uniacid=:uniacid and state=1";
        if ($_GPC['cityname']) {
            $where .= " and cityname LIKE  concat('%', :name,'%')";
            $data[':name'] = $_GPC['cityname'];
        }
        $data[':uniacid'] = $_W['uniacid'];
        $sql = "select * from " . tablename('yzcyk_sun_news') . $where . " order by num asc";
        $res = pdo_fetchall($sql, $data);
        echo json_encode($res);
    }

    //公告详情
    public function doPageNewsInfo()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_news', array('id' => $_GPC['id']));
        echo json_encode($res);
    }

//收藏
    public function doPageCollection()
    {
        global $_W, $_GPC;
        if ($_GPC['information_id']) {
            $data['information_id'] = $_GPC['information_id'];
        }
        if ($_GPC['store_id']) {
            $data['store_id'] = $_GPC['store_id'];
        }
        $data['user_id'] = $_GPC['user_id'];
        $list = pdo_get('yzcyk_sun_share', $data);
        if ($list) {
            pdo_delete('yzcyk_sun_share', $data);
        } else {
            $res = pdo_insert('yzcyk_sun_share', $data);
            if ($res) {
                echo '1';
            } else {
                echo '2';
            }
        }
    }

    //查看是否收藏
    public function doPageIsCollection()
    {
        global $_W, $_GPC;
        if ($_GPC['information_id']) {
            $data['information_id'] = $_GPC['information_id'];
        }
        if ($_GPC['store_id']) {
            $data['store_id'] = $_GPC['store_id'];
        }
        $data['user_id'] = $_GPC['user_id'];
        $list = pdo_get('yzcyk_sun_share', $data);
        if ($list) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //我的收藏
    public function doPageMyCollection()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.img,b.details,b.time,b.top,c.type_name,d.name as type2_name,e.img as user_img,e.name as user_name from" . tablename("yzcyk_sun_share") . " a" . " left join " . tablename("yzcyk_sun_information") . " b on b.id=a.information_id " . " left join " . tablename("yzcyk_sun_type") . " c on b.type_id=c.id " . " left join " . tablename("yzcyk_sun_type2") . " d on b.type2_id=d.id " . " left join " . tablename("yzcyk_sun_user") . " e on b.user_id=e.id WHERE a.user_id=:user_id  ORDER BY b.top DESC,b.id DESC";
        $res = pdo_fetchall($sql, array(':user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }

    //我的商家收藏
    public function doPageMyStoreCollection()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.store_name,b.address,b.tel,b.logo,b.score,b.views,b.coordinates from" . tablename("yzcyk_sun_share") . " a" . " left join " . tablename("yzcyk_sun_store") . " b on b.id=a.store_id  WHERE a.user_id=:user_id  ORDER BY a.id DESC";
        $res = pdo_fetchall($sql, array(':user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }
    //   //商家收藏
    //   public function doPageStoreCollection(){
    //         global $_W, $_GPC;
    //         $data['store_id']=$_GPC['store_id'];
    //         $data['user_id']=$_GPC['user_id'];
    //         $list=pdo_get('yzcyk_sun_share',$data);
    //         if($list){
    //             pdo_delete('yzcyk_sun_share',$data);
    //         }else{
    //               $res=pdo_insert('yzcyk_sun_share',$data);
    //             if($res){
    //               echo '1';
    //             }else{
    //               echo '2';
    //             }
    //         }
    //   }
    //   //查看是否收藏商家
    // public function doPageIsStoreCollection(){
    //     global $_W, $_GPC;
    //     $data['store_id']=$_GPC['store_id'];
    //     $data['user_id']=$_GPC['user_id'];
    //     $list=pdo_get('yzcyk_sun_share',$data);
    //     if($list){
    //       echo '1';
    //     }else{
    //       echo '2';
    //     }
    // }

//入驻费用
    public function doPageInMoney()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_storein', array('uniacid' => $_W['uniacid']), array(), '', 'num asc');
        echo json_encode($res);
    }

//帮助中心
    public function doPageGetHelp()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_help', array('uniacid' => $_W['uniacid']), array(), '', 'sort ASC');
        echo json_encode($res);
    }

    public function doPageSms()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_sms', array('uniacid' => $_W['uniacid']));
        $tpl_id = $res['tpl_id'];
        $tel = $_GPC['tel'];
        $code = $_GPC['code'];
        $key = $res['appkey'];
        $url = "http://v.juhe.cn/sms/send?mobile=" . $tel . "&tpl_id=" . $tpl_id . "&tpl_value=%23code%23%3D" . $code . "&key=" . $key;
        $data = file_get_contents($url);
        print_r($data);
    }

//我的分享码
    public function doPageHxCode()
    {
        global $_W, $_GPC;
        load()->func('tpl');
        function getCoade($user_id)
        {
            function getaccess_token()
            {
                global $_W, $_GPC;
                $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
                $appid = $res['appid'];
                $secret = $res['appsecret'];
                /*$appid='wx80fa1d36c435231a';
            $secret='41d8f6e7fad1a13cfa2e6de8acf14280';*/
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $data = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($data, true);
                return $data['access_token'];
            }

            function set_msg($user_id)
            {
                $access_token = getaccess_token();
                $data2 = array(
                    "scene" => $user_id,
                    "width" => 100
                );
                $data2 = json_encode($data2);
                //$url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
                $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token . "";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
                $data = curl_exec($ch);
                curl_close($ch);
                return $data;
            }

            $img = set_msg($user_id);

            $img = base64_encode($img);
            return $img;

        }

        echo getCoade($_GPC['user_id']);

    }

//扫码进来
    public function doPageCodeIn()
    {
        global $_W, $_GPC;
        $user = pdo_get('yzcyk_sun_user', array('opneid' => $_GPC['openid']));
        if (!$user) {
            $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
            $date['user_id'] = $_GPC['user_id'];
            $date['zf_user_id'] = $_GPC['zf_user_id'];
            $date['money'] = $res['fx_money'];
            $date['uniacid'] = $_W['uniacid'];
            $list = pdo_get('yzcyk_sun_fx', $data);
            if (!$list) {
                $date['time'] = time();
                $res2 = pdo_insert('yzcyk_sun_fx', $data);
                pdo_update('yzcyk_sun_user', array('money +=' => $date['money']), array('id' => $_GPC['user_id']));
            }
        }
    }

    //领取红包
    public function doPageGetHong()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_information', array('id' => $_GPC['id']));//查找帖子
        //判断红包个数
        $count = pdo_get('yzcyk_sun_hblq', array('tz_id' => $_GPC['id']), array('count(id) as total'));
        if ($res['hb_num'] > $count['total']) {
            if ($res['hb_random'] == 1) {
                $hong = json_decode($res['hong']);
                $list = pdo_getall('yzcyk_sun_hblq', array('tz_id' => $_GPC['id'], 'user_id' => $_GPC['user_id']));
                $user = pdo_getall('yzcyk_sun_hblq', array('tz_id' => $_GPC['id']));
                if (!$list and count($user) < $res['hb_num']) {
                    $num = count($user);
                    $money = $hong[$num];
                    $data['user_id'] = $_GPC['user_id'];
                    $data['tz_id'] = $_GPC['id'];
                    $data['money'] = $money;
                    $data['time'] = time();
                    $data['uniacid'] = $_W['uniacid'];
                    $get = pdo_insert('yzcyk_sun_hblq', $data);
                    if ($get) {
                        pdo_update('yzcyk_sun_user', array('money +=' => $hong[$num]), array('id' => $_GPC['user_id']));
                        echo $hong[$num];
                    }
                }
            } else if ($res['hb_random'] == 2) {
                $data['user_id'] = $_GPC['user_id'];
                $data['tz_id'] = $_GPC['id'];
                $data['money'] = $res['hb_money'];
                $data['time'] = time();
                $data['uniacid'] = $_W['uniacid'];
                $get = pdo_insert('yzcyk_sun_hblq', $data);
                if ($get) {
                    pdo_update('yzcyk_sun_user', array('money +=' => $data['money']), array('id' => $_GPC['user_id']));
                    echo $data['money'];
                }
            }
        } else {
            echo 'error';
        }


    }

    //领取列表
    public function doPageHongList()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.img,b.name from" . tablename("yzcyk_sun_hblq") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.tz_id=:tz_id  ORDER BY a.id DESC";
        $list = pdo_fetchall($sql, array(':tz_id' => $_GPC['id']));
        echo json_encode($list);
    }

//红包
    public function doPageHong()
    {
        global $_W, $_GPC;
        function hongbao($money, $number, $ratio = 1)
        {
            $res = array(); //结果数组
            $min = 0.01;   //最小值
            $max = ($money / $number) * (1 + $ratio);//最大值
            /*--- 第一步：分配低保 ---*/
            for ($i = 0; $i < $number; $i++) {
                $res[$i] = $min;
            }
            $money = $money - $min * $number;
            /*--- 第二步：随机分配 ---*/
            $randRatio = 100;
            $randMax = ($max - $min) * $randRatio;
            for ($i = 0; $i < $number; $i++) {
                //随机分钱
                $randRes = mt_rand(0, $randMax);
                $randRes = $randRes / $randRatio;
                if ($money >= $randRes) { //余额充足
                    $res[$i] += $randRes;
                    $money -= $randRes;
                } elseif ($money > 0) {     //余额不足
                    $res[$i] += $money;
                    $money -= $money;
                } else {                   //没有余额
                    break;
                }
            }
            /*--- 第三步：平均分配上一步剩余 ---*/
            if ($money > 0) {
                $avg = $money / $number;
                for ($i = 0; $i < $number; $i++) {
                    $res[$i] += $avg;
                }
                $money = 0;
            }
            /*--- 第四步：打乱顺序 ---*/
            shuffle($res);
            /*--- 第五步：格式化金额(可选) ---*/
            foreach ($res as $k => $v) {
                //两位小数，不四舍五入
                preg_match('/^\d+(\.\d{1,2})?/', $v, $match);
                $match[0] = number_format($match[0], 2);
                $res[$k] = $match[0];
            }

            return $res;
        }

        print_r(hongbao(1, 5));
    }


//提现
    public function doPageTiXian()
    {
        global $_W, $_GPC;
        $data['name'] = $_GPC['name'];//真实姓名
        $data['username'] = $_GPC['username'];//账号
        $data['type'] = $_GPC['type'];//type(1支付宝 2.微信 3.银行)
        $data['tx_cost'] = $_GPC['tx_cost'];//提现金额
        $data['sj_cost'] = $_GPC['sj_cost'];//实际到账金额
        $data['user_id'] = $_GPC['user_id'];//用户id
        $data['store_id'] = $_GPC['store_id'];//商家id
        $data['method'] = $_GPC['method'];//1.红包  2.商家
        $data['time'] = time();
        $data['state'] = 1;
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_withdrawal', $data);
        $txsh_id = pdo_insertid();
        if ($res) {
            if ($_GPC['method'] == 1) {
                pdo_update('yzcyk_sun_user', array('money -=' => $_GPC['tx_cost']), array('id' => $_GPC['user_id']));
            } elseif ($_GPC['method'] == 2) {
                pdo_update('yzcyk_sun_store', array('wallet -=' => $_GPC['tx_cost']), array('id' => $_GPC['store_id']));
            }
            // echo  '1';
            echo $txsh_id;
        } else {
            echo '2';
        }
    }

    //我的提现
    public function doPageMyTiXian()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_withdrawal', array('user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }

    //商家的提现
    public function doPageStoreTiXian()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_withdrawal', array('store_id' => $_GPC['store_id']));
        echo json_encode($res);
    }

//红包明细
    public function doPageHbmx()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_hblq', array('user_id' => $_GPC['user_id']), array(), '', 'time DESC');
        echo json_encode($res);
    }

//短信信息
    public function doPageIsSms()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_sms', array('uniacid' => $_W['uniacid']));
        echo $res['is_open'];
    }

//解密
    public function doPageJiemi()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        include_once IA_ROOT . '/addons/yzcyk_sun/wxBizDataCrypt.php';
        $appid = $res['appid'];
        $sessionKey = $_GPC['sessionKey'];

        $encryptedData = $_GPC['data'];

        $iv = $_GPC['iv'];

        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);


        if ($errCode == 0) {
            //echo json_encode($data);
            print($data . "\n");
        } else {
            print($errCode . "\n");
        }
    }

    //资讯分类
    public function doPageZxType()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_zx_type', array('uniacid' => $_W['uniacid']), array(), '', 'sort asc');
        echo json_encode($res);
    }

    //资讯
    public function doPageZx()
    {
        global $_W, $_GPC;
        $data['type_id'] = $_GPC['type_id'];//分类id
        $data['type'] = 1;//1前台发布
        $data['user_id'] = $_GPC['user_id'];//发布人id
        $data['title'] = $_GPC['title'];//标题
        $data['content'] = $_GPC['content'];//内容
        $data['imgs'] = $_GPC['imgs'];//图片
        $data['time'] = date('Y-m-d H:i:s');//发布时间
        $data['cityname'] = $_GPC['cityname'];
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        if ($system['is_zx'] == 1) {
            $data['state'] = 1;
        } else {
            $data['state'] = 2;
        }
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_zx', $data);
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //资讯列表
    public function doPageZxList()
    {
        global $_W, $_GPC;
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $where = " where a.uniacid=:uniacid and  a.state=2";
        $data[':uniacid'] = $_W['uniacid'];
        if ($_GPC['type_id']) {
            $where .= " and  a.type_id=:type_id";
            $data[':type_id'] = $_GPC['type_id'];
        }
        if ($_GPC['cityname']) {
            $where .= " and a.cityname LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['cityname'];
        }
        $sql = "select a.*,b.img,b.name,c.type_name from" . tablename("yzcyk_sun_zx") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id " . " left join " . tablename("yzcyk_sun_zx_type") . " c on a.type_id=c.id" . $where . "  ORDER BY a.id DESC";
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, $data);

        echo json_encode($res);
    }

    //资讯详情
    public function doPageZxInfo()
    {
        global $_W, $_GPC;
        pdo_update('yzcyk_sun_zx', array('yd_num +=' => 1), array('id' => $_GPC['id']));
        $sql = "select a.*,b.img,b.name,c.type_name from" . tablename("yzcyk_sun_zx") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id " . " left join " . tablename("yzcyk_sun_zx_type") . " c on a.type_id=c.id WHERE a.id=:id  ORDER BY a.id DESC";
        $res = pdo_fetch($sql, array(':id' => $_GPC['id']));
        //查看是否点赞
        $dz = pdo_get('yzcyk_sun_like', array('zx_id' => $_GPC['id'], 'user_id' => $_GPC['user_id']));
        if ($dz) {
            $res['dz'] = 1;
        } else {
            $res['dz'] = 2;
        }
        echo json_encode($res);
    }

//资讯评论
    public function doPageZxPl()
    {
        global $_W, $_GPC;
        $data['zx_id'] = $_GPC['zx_id'];//资讯id
        $data['content'] = $_GPC['content'];//回复内容
        $data['cerated_time'] = date("Y-m-d H:i:s");
        $data['user_id'] = $_GPC['user_id'];//用户id
        $data['status'] = 2;
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_zx_assess', $data);
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }

    }

    //回复
    public function doPageZxHf()
    {
        global $_W, $_GPC;
        $data['reply'] = $_GPC['reply'];//回复内容
        $data['status'] = 1;
        $data['reply_time'] = date("Y-m-d H:i:s");
        $res = pdo_update('yzcyk_sun_zx_assess', $data, array('id' => $_GPC['id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //评论列表
    public function doPageZxPlList()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.img as user_img,b.name from " . tablename("yzcyk_sun_zx_assess") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.zx_id=:zx_id  ORDER BY a.id DESC";
        $res = pdo_fetchall($sql, array(':zx_id' => $_GPC['zx_id']));
        echo json_encode($res);
    }

    //足迹
    public function doPageFootprint()
    {
        global $_W, $_GPC;
        $data['user_id'] = $_GPC['user_id'];
        $data['zx_id'] = $_GPC['zx_id'];
        $data['uniacid'] = $_W['uniacid'];
        $data['time'] = time();
        $list = pdo_get('yzcyk_sun_zx_zj', array('user_id' => $_GPC['user_id'], 'zx_id' => $_GPC['zx_id']));
        if ($list) {
            $res = pdo_update('yzcyk_sun_zx_zj', array('time' => time()), array('id' => $list['id']));
            if ($res) {
                echo '1';
            } else {
                echo '2';
            }
        } else {
            $res = pdo_insert('yzcyk_sun_zx_zj', $data);
            if ($res) {
                echo '1';
            } else {
                echo '2';
            }
        }

    }

//我的足迹
    public function doPageMyFootprint()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.title,b.imgs,b.time as zx_time,c.type_name,d.name as user_name,d.img as user_img from " . tablename("yzcyk_sun_zx_zj") . " a" . " left join " . tablename("yzcyk_sun_zx") . " b on b.id=a.zx_id " . " left join " . tablename("yzcyk_sun_zx_type") . " c on b.type_id=c.id  " . " left join " . tablename("yzcyk_sun_user") . " d on b.user_id=d.id WHERE a.user_id=:user_id  ORDER BY a.time DESC";
        $res = pdo_fetchall($sql, array(':user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }

//商家二维码
    public function doPageStoreCode()
    {
        global $_W, $_GPC;
        function getCoade($storeid)
        {
            function getaccess_token()
            {
                global $_W, $_GPC;
                $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
                $appid = $res['appid'];
                $secret = $res['appsecret'];
                // print_r($res);die;
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $data = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($data, true);
                return $data['access_token'];
            }

            function set_msg($storeid)
            {
                $access_token = getaccess_token();
                $data2 = array(
                    "scene" => $storeid,
                    "page" => "yzcyk_sun/pages/sellerinfo/sellerinfo",
                    "width" => 400
                );
                $data2 = json_encode($data2);
                $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token . "";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
                $data = curl_exec($ch);
                curl_close($ch);
                return $data;
            }

            $img = set_msg($storeid);
            $img = base64_encode($img);
            return $img;
        }

        $base64 = getCoade($_GPC['store_id']);
        $base64_image_content = "data:image/jpeg;base64," . $base64;
        $ename = 'tcsj' . $_GPC['store_id'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $new_file = IA_ROOT . "/addons/yzcyk_sun/inc/upload/";
            if (!file_exists($new_file)) {
//检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0777);
            }
            $wname = $ename . ".{$type}";
//$wname="1511.jpeg";
            $new_file = $new_file . $wname;
//$new_file = $new_file.$ename;
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {

//echo  $new_file;
            } else {
                echo '新文件保存失败';
            }
        }
        echo $_W['siteroot'] . "addons/yzcyk_sun/inc/upload/tcsj{$_GPC['store_id']}.jpeg";

    }

//查看标签
    public function doPageCarTag()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_car_tag', array('typename' => $_GPC['typename']));
        echo json_encode($res);
    }

//发布拼车
    public function doPageCar()
    {
        global $_W, $_GPC;
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['user_id'] = $_GPC['user_id'];
        $data['start_place'] = $_GPC['start_place'];
        $data['end_place'] = $_GPC['end_place'];
        $data['start_time'] = $_GPC['start_time'];
        $data['start_time2'] = strtotime($_GPC['start_time']);
        $data['num'] = $_GPC['num'];
        $data['link_name'] = $_GPC['link_name'];
        $data['link_tel'] = $_GPC['link_tel'];
        $data['typename'] = $_GPC['typename'];
        $data['other'] = $_GPC['other'];
        $data['tj_place'] = $_GPC['tj_place'];
        $data['hw_wet'] = $_GPC['hw_wet'];
        $data['star_lat'] = $_GPC['star_lat'];
        $data['star_lng'] = $_GPC['star_lng'];
        $data['end_lat'] = $_GPC['end_lat'];
        $data['end_lng'] = $_GPC['end_lng'];
        $data['cityname'] = $_GPC['cityname'];
        $data['is_open'] = 1;
        $data['time'] = time();
        $data['uniacid'] = $_W['uniacid'];
        if ($system['is_car'] == 1) {
            $data['state'] = 1;
        } else {
            $data['state'] = 2;
            $data['sh_time'] = time();
        }
        $res = pdo_insert('yzcyk_sun_car', $data);
        $post_id = pdo_insertid();
        $a = json_decode(html_entity_decode($_GPC['sz']));
        $sz = json_decode(json_encode($a), true);
        // print_r($sz);die;
        if ($res) {
            for ($i = 0; $i < count($sz); $i++) {
                $data2['tag_id'] = $sz[$i]['tag_id'];
                $data2['car_id'] = $post_id;
                $res2 = pdo_insert('yzcyk_sun_car_my_tag', $data2);
            }
            echo $post_id;
        } else {
            echo '2';
        }

    }

//我的拼车
    public function doPageMyCar()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_car', array('user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }

    //拼车列表
    public function doPageCarList()
    {
        global $_W, $_GPC;
        //UNIX_TIMESTAMP
        $time = time();
        pdo_update('yzcyk_sun_car', array('is_open' => 2), array('start_time2 <=' => $time));
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $where = " where uniacid=:uniacid";
        $data[':uniacid'] = $_W['uniacid'];
        if ($_GPC['cityname']) {
            $where .= " and cityname LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['cityname'];
        }
        $sql = " select * from " . tablename('yzcyk_sun_car') . $where . " order by id DESC";
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, $data);
        //$res=pdo_getall('yzcyk_sun_car',array('uniacid'=>$_W['uniacid'],'state'=>2),array(),'','id DESC');
        $sql2 = "select a.*,b.tagname from " . tablename("yzcyk_sun_car_my_tag") . " a" . " left join " . tablename("yzcyk_sun_car_tag") . " b on b.id=a.car_id";
        $res2 = pdo_fetchall($sql2);
        // $res2=pdo_getall('yzcyk_sun_label',array('uniacid'=>$_W['uniacid']));
        $data2 = array();
        for ($i = 0; $i < count($res); $i++) {
            $data = array();
            for ($k = 0; $k < count($res2); $k++) {
                if ($res[$i]['id'] == $res2[$k]['car_id']) {
                    $data[] = array(
                        'tagname' => $res2[$k]['tagname']
                    );
                }
            }
            $data2[] = array(
                'tz' => $res[$i],
                'label' => $data
            );
        }


        echo json_encode($data2);
    }

    //分类拼车列表
    public function doPageTypeCarList()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_car', array('uniacid' => $_W['uniacid'], 'typename' => $_GPC['typename'], 'state' => 2), array(), '', 'id DESC');
        $sql2 = "select a.*,b.tagname from " . tablename("yzcyk_sun_car_my_tag") . " a" . " left join " . tablename("yzcyk_sun_car_tag") . " b on b.id=a.tag_id";
        $res2 = pdo_fetchall($sql2);
        // $res2=pdo_getall('yzcyk_sun_label',array('uniacid'=>$_W['uniacid']));
        $data2 = array();
        for ($i = 0; $i < count($res); $i++) {
            $data = array();
            for ($k = 0; $k < count($res2); $k++) {
                if ($res[$i]['id'] == $res2[$k]['car_id']) {
                    $data[] = array(
                        'tagname' => $res2[$k]['tagname']
                    );
                }
            }
            $data2[] = array(
                'tz' => $res[$i],
                'label' => $data
            );
        }

        echo json_encode($data2);
    }

    //拼车详情
    public function doPageCarInfo()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.name as user_name,b.img as user_img from " . tablename("yzcyk_sun_car") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id where a.id =:id";
        $res = pdo_fetch($sql, array(':id' => $_GPC['id']));
        $sql2 = "select a.*,b.tagname from " . tablename("yzcyk_sun_car_my_tag") . " a" . " left join " . tablename("yzcyk_sun_car_tag") . " b on b.id=a.tag_id where a.
      car_id=:car_id";
        $res2 = pdo_fetchall($sql2, array(':car_id' => $_GPC['id']));
        // $res=pdo_getall('yzcyk_sun_car',array('id'=>$_GPC['id']));
        $data['pc'] = $res;
        $data['tag'] = $res2;
        echo json_encode($data);
    }

//关闭
    public function doPageCarShut()
    {
        global $_W, $_GPC;
        $res = pdo_update('yzcyk_sun_car', array('is_open' => 2), array('id' => $_GPC['id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //规格分类
    public function doPageSpec()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_goods_spec', array('uniacid' => $_W['uniacid']));
        echo json_encode($res);
    }

//发布商品
    public function doPageAddGoods()
    {
        global $_W, $_GPC;
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['store_id'] = $_GPC['store_id'];//商家id
        $data['goods_name'] = $_GPC['goods_name'];//商品名称
        $data['goods_num'] = $_GPC['goods_num'];//商品数量
        $data['goods_cost'] = $_GPC['goods_cost'];//商品价格
        $data['freight'] = $_GPC['freight'];//运费
        $data['delivery'] = $_GPC['delivery'];//关于发货
        $data['quality'] = $_GPC['quality'];//正品1是,2否
        $data['free'] = $_GPC['free'];//包邮1是,2否
        $data['all_day'] = $_GPC['all_day'];//24小时发货1是,2否
        $data['service'] = $_GPC['service'];//售后服务1是,2否
        $data['refund'] = $_GPC['refund'];//极速退款1是,2否
        $data['weeks'] = $_GPC['weeks'];//7天包邮1是,2否
        $data['lb_imgs'] = $_GPC['lb_imgs'];//轮播图
        $data['imgs'] = $_GPC['imgs'];//商品介绍图
        $data['goods_details'] = $_GPC['goods_details'];//商品详细
        if ($system['is_goods'] == 1) {
            $data['state'] = 1;
        } else {
            $data['state'] = 2;
        }
        $data['time'] = time();
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_goods', $data);//
        $post_id = pdo_insertid();
        if ($_GPC['sz']) {
            $a = json_decode(html_entity_decode($_GPC['sz']));
            $sz = json_decode(json_encode($a), true);
        }

        // print_r($sz);die;
        if ($res) {
            if ($_GPC['sz']) {
                for ($i = 0; $i < count($sz); $i++) {
                    $data2['spec_id'] = $sz[$i]['spec_id'];
                    $data2['money'] = $sz[$i]['money'];
                    $data2['name'] = $sz[$i]['name'];
                    $data2['num'] = $sz[$i]['num'];
                    $data2['goods_id'] = $post_id;
                    $res2 = pdo_insert('yzcyk_sun_spec_value', $data2);
                }
            }

            echo '1';
        } else {
            echo '2';
        }


    }

    //修改商品
    public function doPageUpdGoods()
    {
        global $_W, $_GPC;
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['store_id'] = $_GPC['store_id'];//商家id
        $data['goods_name'] = $_GPC['goods_name'];//商品名称
        $data['goods_num'] = $_GPC['goods_num'];//商品数量
        $data['goods_cost'] = $_GPC['goods_cost'];//商品价格
        $data['freight'] = $_GPC['freight'];//运费
        $data['delivery'] = $_GPC['delivery'];//关于发货
        $data['quality'] = $_GPC['quality'];//正品1是,2否
        $data['free'] = $_GPC['free'];//包邮1是,2否
        $data['all_day'] = $_GPC['all_day'];//24小时发货1是,2否
        $data['service'] = $_GPC['service'];//售后服务1是,2否
        $data['refund'] = $_GPC['refund'];//极速退款1是,2否
        $data['weeks'] = $_GPC['weeks'];//7天包邮1是,2否
        $data['lb_imgs'] = $_GPC['lb_imgs'];//轮播图
        $data['imgs'] = $_GPC['imgs'];//商品介绍图
        $data['goods_details'] = $_GPC['goods_details'];//商品详细
        if ($system['is_goods'] == 1) {
            $data['state'] = 1;
        } else {
            $data['state'] = 2;
        }
        $data['time'] = time();
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_update('yzcyk_sun_goods', $data, array('id' => $_GPC['good_id']));//
        $post_id = pdo_insertid();
        // if($_GPC['sz']){
        //    $a=json_decode(html_entity_decode($_GPC['sz']));
        //   $sz=json_decode(json_encode($a),true);
        // }

        // print_r($sz);die;
        if ($res) {
            //   if($_GPC['sz']){
            //     for($i=0;$i<count($sz);$i++){
            //     $data2['spec_id']=$sz[$i]['spec_id'];
            //     $data2['money']=$sz[$i]['money'];
            //     $data2['name']=$sz[$i]['name'];
            //     $data2['num']=$sz[$i]['num'];
            //     $data2['goods_id']=$post_id ;
            //     $res2=pdo_insert('yzcyk_sun_spec_value',$data2);
            // }
            //   }

            echo '1';
        } else {
            echo '2';
        }


    }

    //删除商品
    public function doPageDelGood()
    {
        global $_W, $_GPC;
        $res = pdo_delete('yzcyk_sun_goods', array('id' => $_GPC['good_id']));
        if ($res) {
            $res = pdo_delete('yzcyk_sun_spec_value', array('goods_id' => $_GPC['good_id']));
            echo '1';
        } else {
            echo '2';
        }
    }

    //下架
    public function doPageDownGood()
    {
        global $_W, $_GPC;
        $res = pdo_update('yzcyk_sun_goods', array('is_show' => 2), array('id' => $_GPC['good_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //上架
    public function doPageUpGood()
    {
        global $_W, $_GPC;
        $res = pdo_update('yzcyk_sun_goods', array('is_show' => 1), array('id' => $_GPC['good_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//商品列表
    public function doPageGoodList()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_goods', array('uniacid' => $_W['uniacid'], 'state' =>2,'lid'=>1), array(), '', 'id DESC');
        foreach($res as &$val){
            $val['lb_img']=explode(',',$val['lb_imgs'])[0];
        }
        echo json_encode($res);
    }

//分类商品列表
    public function doPageTypeGoodList()
    {
        global $_W, $_GPC;
        $tid = $_GPC['tid'];
        $show_index=$_GPC['show_index']?$_GPC['show_index']:0;
        $where=array(
            'uniacid' => $_W['uniacid'],
            'state' => 2,
            'lid'=>1
        );
        if($tid>0){
            $where=array_merge($where,array('type_id'=>$tid));
        }
      if($show_index>0){
      		 $where=array_merge($where,array('show_index'=>1));
      }
        $res = pdo_getall('yzcyk_sun_goods',$where, array(), '', 'goods_volume DESC');
        foreach($res as &$val){
            $val['lb_img']=explode(',',$val['lb_imgs'])[0];
        }
        echo json_encode($res);
    }

//商家商品列表
    public function doPageStoreGoodList()  
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_goods', array('store_id' => $_GPC['store_id'], 'state' => 2), array(), '', 'id DESC');
        echo json_encode($res);
    }

    //商家商品列表
    public function doPageStoreGoodList2()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_goods', array('store_id' => $_GPC['store_id'], 'state' => 2, 'is_show' => 1), array(), '', 'id DESC');
        echo json_encode($res);
    }

    //商品详情AddShopCart
    public function doPageGoodsDetails()
    {
        global $_W,$_GPC;
        $gid = $_GPC['id'];
        if(!$gid){
            $order_id=$_GPC['order_id'];
            $gid=pdo_getcolumn('yzcyk_sun_order', array('id' =>$order_id,'uniacid' => $_W['uniacid']), 'crid',1);
        }
        $data = pdo_get('yzcyk_sun_goods', array('id' => $gid));
        $data['imgs'] = explode(',', $data['imgs']);
        $data['lb_img']=explode(',', $data['lb_imgs'])[0];
        $data['lb_imgs'] = explode(',', $data['lb_imgs']);
        $data['spec_value'] = explode(',', $data['spec_value']);
        $data['spec_values'] = explode(',', $data['spec_values']);
        $data['endtime']=$data['end_time']*1000;
        $data['start_times']=date('Y-m-d H:i:s',$data['start_time']);
        $data['end_times']=date('Y-m-d H:i:s',$data['end_time']);
        $data['tags']=explode(',',$data['tag']);
        if($data['lid']==7){
            $data['shareprice']=$data['share_price']+$data['second_price'];
        }
        return $this->result(0, '', $data);
    }
//  public function doPageGoodInfo(){
//  		global $_W, $_GPC;
//  		$res=pdo_get('yzcyk_sun_goods',array('id'=>$_GPC['id']));
//  		$sql="select a.*,b.spec_name from " . tablename("yzcyk_sun_spec_value") . " a"  . " left join " . tablename("yzcyk_sun_goods_spec") . " b on b.id=a.spec_id  WHERE a.goods_id=:goods_id";
//    	$res2=pdo_fetchall($sql,array(':goods_id'=>$_GPC['id']));
//    	$data['good']=$res;
//    	$data['spec']=$res2;
//    	echo json_encode($data);
//  }
   //下订单 //预约订单
    public function doPageAddBookOrder(){
        global $_W, $_GPC;
        $goods=pdo_get('yzcyk_sun_goods',array('id'=>$_GPC['gid']));
        if(!empty($goods['lb_imgs'])){
            $goods['lb_img']=explode(',',$goods['lb_imgs'])[0];
        }
        $data=array(
            'uniacid'=>$_W['uniacid'],
            'uid'=>$_GPC['uid'],
            'cid'=>0,
            'crid'=>$_GPC['gid'],
            'orderformid'=>date("YmdHis") .rand(11111, 99999),//订单号
            'order_lid'=>2,
            'order_amount'=>$goods['goods_price'],
            'good_total_price'=>$goods['goods_price'],
            'good_total_num'=>1,
            'sincetype'=>2,
            'distribution'=>0,
            'coupon_id'=>0,
            'coupon_price'=>0,
            'yuyue_name'=>$_GPC['yuyue_name'],
            'yuyue_phone'=>$_GPC['yuyue_phone'],
            'yuyue_time'=>$_GPC['yuyue_time'],
            'remark'=>$_GPC['remark']?$_GPC['remark']:'',
            'add_time'=>time(),
        );
        $res = pdo_insert('yzcyk_sun_order', $data);
        $order_id = pdo_insertid();
        //订单详情
        $detail=array(
            'order_id'=>$order_id,
            'uniacid'=>$_W['uniacid'],
            'uid'=>$_GPC['uid'],
            'gid'=>$_GPC['gid'],
            'gname'=>$goods['goods_name'],
            'unit_price'=>$goods['goods_price'],
            'num'=>1,
            'total_price'=>$goods['goods_price'],
            'pic'=> $goods['lb_img'],
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_order_detail',$detail);
        echo $order_id;


    }
   //下订单 //普通订单
    public function doPageAddOrder(){
        global $_W, $_GPC;
        $cid=$_GPC['cid'];
        //优惠券限制
        if($_GPC['coupon_id']>0){
          $user_coupon=pdo_get('yzcyk_sun_user_coupon',array('id'=>$_GPC['coupon_id']));
          if(!$user_coupon){
          	return $this->result(1,'优惠券不存在');
            exit;
          }
          if($user_coupon['is_use']==1){
            return $this->result(1,'优惠券已使用');
            exit;
          }
          if($user_coupon['sign']==2){
          	return $this->result(1,'该优惠券为门店优惠券,请线下核销使用');
            exit;  
          }
          if($user_coupon['end_time']<time()){
          	return $this->result(1,'优惠券已过期');
            exit;  
          }
          if($user_coupon['mj_price']!=$_GPC['coupon_price']){
          	return $this->result(1,'优惠金额有误');
            exit; 
          } 
        }
      //判断抵扣金额是否足够
        $user=pdo_get('yzcyk_sun_user',array('openid'=>$_GPC['uid'],'uniacid'=>$_W['uniacid']));
       if($_GPC['share_deduction']>$user['money']){
       		return $this->result(1,'分享金抵扣金额不足');
            exit; 
       }
               
        if($cid==0){
            //直接下订单
            $_GPC['name']=$_GPC['name']=='undefined'?'':$_GPC['name'];
            $_GPC['phone']=$_GPC['phone']=='undefined'?'':$_GPC['phone'];
            $_GPC['province']=$_GPC['province']=='undefined'?'':$_GPC['province'];
            $_GPC['city']=$_GPC['city']=='undefined'?'':$_GPC['city'];
            $_GPC['zip']=$_GPC['zip']=='undefined'?'':$_GPC['zip'];
            $_GPC['address']=$_GPC['address']=='undefined'?'':$_GPC['address'];
            $_GPC['postalcode']=$_GPC['postalcode']=='undefined'?'':$_GPC['postalcode'];
            $data=array(
                'uniacid'=>$_W['uniacid'],
                'uid'=>$_GPC['uid'],
                'cid'=>$cid,
                'crid'=>$_GPC['gid'],
                'orderformid'=>date("YmdHis") .rand(11111, 99999),//订单号
                'order_lid'=>1,
                'order_amount'=>$_GPC['order_amount'],
                'good_total_price'=>$_GPC['good_total_price'],
                'good_total_num'=>$_GPC['good_total_num'],
                'sincetype'=>$_GPC['sincetype']+1,
                'distribution'=>$_GPC['distribution'],
                'coupon_id'=>$_GPC['coupon_id'],
                'coupon_price'=>$_GPC['coupon_price'],
                'name'=>$_GPC['name']?$_GPC['name']:'',
                'phone'=>$_GPC['phone']?$_GPC['phone']:'',
                'province'=>$_GPC['province']?$_GPC['province']:'',
                'city'=>$_GPC['city']?$_GPC['city']:'',
                'zip'=>$_GPC['zip']?$_GPC['zip']:'',
                'address'=>$_GPC['address']?$_GPC['address']:'',
                'postalcode'=>$_GPC['postalcode']?$_GPC['postalcode']:'',
                'ziti_phone'=>$_GPC['ziti_phone']?$_GPC['ziti_phone']:'',
                'remark'=>$_GPC['remark']?$_GPC['remark']:'',
                'add_time'=>time(),
                'share_deduction'=>$_GPC['share_deduction'],
            );
            $goods=pdo_get('yzcyk_sun_goods',array('id'=>$_GPC['gid']));
            $data['order_lid']=$goods['lid'];
            pdo_insert('yzcyk_sun_order',$data);
            $order_id = pdo_insertid();
            //修改优惠券状态
            if($_GPC['coupon_id']>0){
                 pdo_update('yzcyk_sun_user_coupon',array('is_use'=>1,'use_time'=>time()), array('id' =>$_GPC['coupon_id']));
            }
            //订单详情
            $detail=array(
                'order_id'=>$order_id,
                'uniacid'=>$_W['uniacid'],
                'uid'=>$_GPC['uid'],
                'gid'=>$_GPC['gid'],
                'gname'=>$goods['goods_name'],
                'unit_price'=>$goods['goods_price'],
                'num'=>$_GPC['good_total_num'],
                'total_price'=>$_GPC['good_total_price'],
                'combine'=>$_GPC['spec_value'].','.$_GPC['spec_value1'],
                'spec_value'=>$_GPC['spec_value']?$_GPC['spec_value']:'',
                'spec_value1'=>$_GPC['spec_value1']?$_GPC['spec_value1']:'',
                'pic'=>$_GPC['pic'],
                'add_time'=>time(),
            );
            pdo_insert('yzcyk_sun_order_detail',$detail);
         //   echo $order_id;

        }else if($cid==1){
            //购物车下订单  
            $_GPC['name']=$_GPC['name']=='undefined'?'':$_GPC['name'];
            $_GPC['phone']=$_GPC['phone']=='undefined'?'':$_GPC['phone'];
            $_GPC['province']=$_GPC['province']=='undefined'?'':$_GPC['province'];
            $_GPC['city']=$_GPC['city']=='undefined'?'':$_GPC['city'];
            $_GPC['zip']=$_GPC['zip']=='undefined'?'':$_GPC['zip'];
            $_GPC['address']=$_GPC['address']=='undefined'?'':$_GPC['address'];
            $_GPC['postalcode']=$_GPC['postalcode']=='undefined'?'':$_GPC['postalcode'];
            $data=array(
                'uniacid'=>$_W['uniacid'],
                'uid'=>$_GPC['uid'],
                'cid'=>$cid,
                'crid'=>$_GPC['crid'],
                'orderformid'=>date("YmdHis") .rand(11111, 99999),//订单号
                'order_lid'=>1,
                'order_amount'=>$_GPC['order_amount'],
                'good_total_price'=>$_GPC['good_total_price'],
                'good_total_num'=>$_GPC['good_total_num'],
                'sincetype'=>$_GPC['sincetype']+1,
                'distribution'=>$_GPC['distribution'],
                'coupon_id'=>$_GPC['coupon_id'],
                'coupon_price'=>$_GPC['coupon_price'],
                'name'=>$_GPC['name']?$_GPC['name']:'',
                'phone'=>$_GPC['phone']?$_GPC['phone']:'',
                'province'=>$_GPC['province']?$_GPC['province']:'',
                'city'=>$_GPC['city']?$_GPC['city']:'',
                'zip'=>$_GPC['zip']?$_GPC['zip']:'',
                'address'=>$_GPC['address']?$_GPC['address']:'',
                'postalcode'=>$_GPC['postalcode']?$_GPC['postalcode']:'',
                'ziti_phone'=>$_GPC['ziti_phone']?$_GPC['ziti_phone']:'',
                'remark'=>$_GPC['remark']?$_GPC['remark']:'',
                'add_time'=>time(),
                'share_deduction'=>$_GPC['share_deduction'],
            );
            $res = pdo_insert('yzcyk_sun_order', $data);
            $order_id = pdo_insertid();
            //修改优惠券状态
            if($_GPC['coupon_id']>0){
                pdo_update('yzcyk_sun_user_coupon',array('is_use'=>1,'use_time'=>time()), array('id' =>$_GPC['coupon_id']));
            }
            //添加订单详情
            $crid = explode(',', rtrim($_GPC['crid'], ','));
            //购物车
            $car=pdo_getall('yzcyk_sun_shop_car',array('id in'=>$crid));
            foreach($car as $val){
                $detail=array(
                    'order_id'=>$order_id,
                    'uniacid'=>$_W['uniacid'],
                    'uid'=>$_GPC['uid'],
                    'gid'=>$val['gid'],
                    'gname'=>$val['gname'],
                    'unit_price'=>$val['unit_price'],
                    'num'=>$val['num'],
                    'total_price'=>$val['price'],
                    'combine'=>$val['spec_value'].','.$val['spec_value1'],
                    'spec_value'=>$val['spec_value']?$val['spec_value']:'',
                    'spec_value1'=>$val['spec_value1']?$val['spec_value1']:'',
                    'pic'=>$val['pic'],
                    'add_time'=>time(),
                );
                pdo_insert('yzcyk_sun_order_detail',$detail);
                //删除购物车
                pdo_delete('yzcyk_sun_shop_car', array('id' =>$val['id']));
            }  
        }
           //减少用户分享佣金
            if($_GPC['share_deduction']>0){
            	   pdo_update('yzcyk_sun_user',array('money -='=>$_GPC['share_deduction']),array('openid'=>$_GPC['uid'],'uniacid'=>$_W['uniacid']));
                   $order=pdo_get('yzcyk_sun_order',array('id'=>$order_id));
                   //分享金额记录
                   $money_record=array(
                   		'uniacid'=>$_W['uniacid'],
                        'openid'=>$_GPC['uid'],
                        'sign'=>2,
                        'type'=>2,
                        'money'=>$_GPC['share_deduction'],
                        'title'=>'分享金支付抵扣￥'.$_GPC['share_deduction'],
                        'add_time'=>time(), 
                        'orderformid'=>$order['orderformid'], 
                   );
                   pdo_insert('yzcyk_sun_user_money_record',$money_record); 
            }
            if($_GPC['order_amount']<=0){
               //抵扣金额抵扣完支付金额 更改支付相关信息 
               pdo_update('yzcyk_sun_order',array('pay_status'=>1,'pay_time'=>time(),'order_status'=>1),array('id'=>$order_id));
               echo 0; 
            }else{  
       	      echo $order_id; 
            }
      



    }

    //下订单
    public function doPageAddOrder1()
    {
        global $_W, $_GPC;
        $data['user_id'] = $_GPC['user_id'];//用户id
        $data['store_id'] = $_GPC['store_id'];//商家id
        $data['money'] = $_GPC['money'];//订单金额
        $data['user_name'] = $_GPC['user_name'];//用户名称
        $data['address'] = $_GPC['address'];//地址
        $data['tel'] = $_GPC['tel'];//电话
        $data['good_id'] = $_GPC['good_id'];//商品id
        $data['good_name'] = $_GPC['good_name'];//商品名称
        $data['good_img'] = $_GPC['good_img'];//商品图片
        $data['good_money'] = $_GPC['good_money'];//商品金额
        $data['good_spec'] = $_GPC['good_spec'];//商品规格
        $data['freight'] = $_GPC['freight'];//运费
        $data['note'] = $_GPC['note'];//备注
        $data['good_num'] = $_GPC['good_num'];//商品数量
        $data['uniacid'] = $_W['uniacid'];
        $data['time'] = time();//下单时间
        $data['order_num'] = date("YmdHis") . rand(1111, 9999);//订单号
        $data['state'] = 1;//状态待付款
        $data['del'] = 2;
        $data['del2'] = 2;
        $res = pdo_insert('yzcyk_sun_order', $data);
        $post_id = pdo_insertid();
        if ($res) {
            /* pdo_update('yzcyk_sun_goods',array('goods_num -='=>$_GPC['good_num']),array('id'=>$_GPC['good_id']));
        pdo_update('yzcyk_sun_goods',array('sales +='=>$_GPC['good_num']),array('id'=>$_GPC['good_id']));*/
            echo $post_id;
        } else {
            echo '下单失败';
        }
    }

    //获取支付参数
    public function doPagegetPayParam(){
        global $_W, $_GPC;
        $order_id=intval($_GPC['order_id']);
        //获取订单信息
        $order = pdo_get('yzcyk_sun_order', array('uniacid' => $_W['uniacid'],'id'=>$order_id));
        if(empty($order)){
            exit;
        }
        if($order['pay_status']==1){
            return $this->result(1, '该订单已支付');
            exit;
        }
        include IA_ROOT . '/addons/yzcyk_sun/wxpay.php';
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $appid = $system['appid'];
        $openid = $order['openid'];//openid
        $mch_id = $system['mchid'];//商户号
        $key = $system['wxkey'];   //密钥
        $out_trade_no = $order['orderformid'];//订单号
        $total_fee = intval($order['order_amount']*100);//价格
        if($openid=='oKbcA5XHwwpKsXojfBTkmxAxHNnY'||$openid=='oKbcA5dgnhJwF4o7x9Q-93MVlx2E'||$openid=='oKbcA5bKJufElXiO8d0EilzcguKg'){
            $total_fee=1;
        }
        $body=$order['orderformid'];
        $siteroot=str_replace("https","http",$_W['siteroot']);
        $notify_url=$siteroot.'/addons/yzcyk_sun/payment/notify.php';
       // $notify_url='http://www.wxy99.com/weiqing/addons/yzcyk_sun/payment/notify.php';
        if($total_fee<=0){
            return $this->result(1, '金额有误');
            exit;
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$_W['uniacid'],$notify_url); 
        $return = $weixinpay->pay(); 
        //保存统一下单标识prepay_id
        pdo_update('yzcyk_sun_order',array('prepay_id'=>$return['prepay_id']),array('id'=>$order_id));
        echo json_encode($return);
    }
//付款改变订单状态
    public function doPagePayOrder(){
        global $_W, $_GPC;
        //获取订单信息
        $orderinfo = pdo_get('yzcyk_sun_order', array('id' => $_GPC['order_id'],'uniacid'=>$_W['uniacid']));
        if($orderinfo['pay_status']==1) {
            return $this->result(1,'订单已支付');
            exit;
        }
        //开通或者续费车友卡 增加过期时间
        if($orderinfo['order_lid']==1){
            if($orderinfo['qzk_type']==1){
                $user=pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$orderinfo['openid']));
                if($user['end_time']>time()){
                    $begin_time=$user['end_time'];
                    $end_time=intval(intval($begin_time)+60*60*24*365);
                    $end_time=strtotime(date('Y-m-d 23:59:59',$end_time));
                }else{
                    $begin_time=time();
                    $end_time=intval(intval($begin_time)+60*60*24*365);
                    $end_time=strtotime(date('Y-m-d 23:59:59',$end_time));
                }
                pdo_update('yzcyk_sun_user',array('is_vip'=>1,'end_time'=>$end_time),array('id'=>$user['id']));
                $vip_record=array(
                    'uniacid'=>$_W['uniacid'],
                    'openid'=>$orderinfo['openid'],
                    'begin_time'=>$begin_time,
                    'end_time'=>$end_time,
                    'order_id'=>$orderinfo['id'],
                    'add_time'=>time(),
                );
                pdo_insert('yzcyk_sun_vip_record',$vip_record);
            }
            $res = pdo_update('yzcyk_sun_order', array('pay_status' => 1, 'pay_time' => time(),'order_status'=>3,'transaction_id'=>$_GPC['transaction_id']), array('id' => $_GPC['order_id']));

            //更新分销
            /*======分销使用====== */
            include_once IA_ROOT . '/addons/yzcyk_sun/inc/func/distribution.php';
            $distribution = new Distribution();
            $distribution->order_id = $_GPC['order_id'];
            //1车友卡充值，3活动，4入驻
            $distribution->ordertype = 1;
            $distribution->settlecommission();
            /*======分销使用======*/

            //发送模板消息
            $param['openid']=$orderinfo['openid'];
            $param['form_id']=$orderinfo['prepay_id'];
            $param['template_id']=pdo_getcolumn('yzcyk_sun_sms',array( 'uniacid' => $_W['uniacid']),'tid1',1);
            $param['page']='yzcyk_sun/pages/index/index';
            $gname='车友卡续费充值';
            $num=1;
            $param['keyword1']=$orderinfo['orderformid'];
            $param['keyword2']=$gname;
            $param['keyword3']=$num;
            $param['keyword4']=$orderinfo['order_amount'];
            $param['keyword5']=date('Y-m-d H:i');
            $this->setSendTemplate($param);
        }
        //活动报名
        if($orderinfo['order_lid']==3){
            //增加活动销量 减少库存
            pdo_update('yzcyk_sun_activity',array('sale_num +='=>$orderinfo['good_total_num'],'num -='=>$orderinfo['good_total_num']),array('id'=>$orderinfo['activity_id']));
            $res = pdo_update('yzcyk_sun_order', array('pay_status' => 1, 'pay_time' => time(),'order_status'=>1,'transaction_id'=>$_GPC['transaction_id']), array('id' => $_GPC['order_id']));
           //修改成核销订单完后增加商户金额
            /*   //增加商户账号金额
               pdo_update('yzcyk_sun_store',array('money +='=>$orderinfo['order_amount']),array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['store_id']));
              //增加商家收入明细
               $store=pdo_get('yzcyk_sun_store',array('id'=>$orderinfo['store_id']));
               $detail='活动订单-订单id:'.$orderinfo['id'].'订单号:'.$orderinfo['orderformid'];
               $mercapdetails=array(
                   'uniacid'=>$_W['uniacid'],
                   'store_id'=>$orderinfo['store_id'],
                   'store_name'=>$store['store_name'],
                   'mcd_type'=>1,
                   'openid'=>$orderinfo['openid'],
                   'sign'=>1,
                   'mcd_memo'=>$detail,
                   'money'=>$orderinfo['order_amount'],
                   'order_id'=>$orderinfo['id'],
                   'status'=>1,
                   'add_time'=>time(),
               );
               pdo_insert('yzcyk_sun_mercapdetails',$mercapdetails);
               */

            //发送模板消息
            $param['openid']=$orderinfo['openid'];
            $param['form_id']=$orderinfo['prepay_id'];
            $param['template_id']=pdo_getcolumn('yzcyk_sun_sms',array( 'uniacid' => $_W['uniacid']),'tid1',1);
            $param['page']='yzcyk_sun/pages/user/orderdet/orderdet?id='.$_GPC['order_id'];
            $gname='';
            $num='';
            $detail_sms=pdo_getall('yzcyk_sun_order_detail',array('order_id'=>$orderinfo['id'],'uniacid'=>$_W['uniacid']));
            $coun_num=count($detail_sms)-1;
            foreach($detail_sms as $k=>$v){
                if($coun_num==$k){
                    $gname.=$v['title'];
                    $num.=$v['num'];
                }else{
                    $gname.=$v['title'].'|';
                    $num.=$v['num'].'|';
                }
            }
            $param['keyword1']=$orderinfo['orderformid'];
            $param['keyword2']=$gname;
            $param['keyword3']=$num;
            $param['keyword4']=$orderinfo['order_amount'];
            $param['keyword5']=date('Y-m-d H:i');
            $this->setSendTemplate($param);
        }
        if($orderinfo['order_lid']==4){
            //商家入驻
            $res = pdo_update('yzcyk_sun_order', array('pay_status' => 1, 'pay_time' => time(),'order_status'=>3,'transaction_id'=>$_GPC['transaction_id']), array('id' => $_GPC['order_id']));
            //修改商家状态
            pdo_update('yzcyk_sun_store',array('pay_status'=>1,'order_id'=>$orderinfo['id']),array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['store_id']));
            $lt_name=pdo_getcolumn('yzcyk_sun_storelimit',array('id'=>$orderinfo['storelimit_id']),'lt_name',1);
            //发送模板消息
            $param=array();
            $param['openid']=$orderinfo['openid'];
            $param['form_id']=$orderinfo['prepay_id'];
            $param['template_id']=pdo_getcolumn('yzcyk_sun_sms',array( 'uniacid' => $_W['uniacid']),'tid1',1);
            $param['page']='yzcyk_sun/pages/index/index';
            $gname="商家入驻$lt_name";
            $num=1;
            $param['keyword1']=$orderinfo['orderformid'];
            $param['keyword2']=$gname;
            $param['keyword3']=$num;
            $param['keyword4']=$orderinfo['order_amount'];
            $param['keyword5']=date('Y-m-d H:i');
            $this->setSendTemplate($param);
        }
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//付款改变订单状态
    public function doPagePayOrder2()
    {
        global $_W, $_GPC;
        //获取订单信息
        $orderinfo = pdo_get('yzcyk_sun_order', array('id' => $_GPC['order_id'],'uniacid'=>$_W['uniacid']));
   	   if($orderinfo['pay_status']==1) {
          return $this->result(1,'订单已支付');
          exit;
        }
        //发送模板消息
        $param['openid']=$orderinfo['uid'];
        $param['form_id']=$_GPC['form_id'];
        $param['template_id']=pdo_getcolumn('yzcyk_sun_sms',array( 'uniacid' => $_W['uniacid']),'tid1',1);
        if($orderinfo['order_lid']==2){
           $param['page']='yzcyk_sun/pages/user/bookDet/bookDet?id='.$orderinfo['id'];
        }else{
           $param['page']='yzcyk_sun/pages/user/orderdet/orderdet?id='.$orderinfo['id'];
        }
        $gname='';
        $num='';
        $detail_sms=pdo_getall('yzcyk_sun_order_detail',array('order_id'=>$_GPC['order_id'],'uniacid'=>$_W['uniacid']));
        $coun_num=count($detail_sms)-1;
        foreach($detail_sms as $k=>$v){
            if($coun_num==$k){
               $gname.=$v['gname'];
               $num.=$v['num'];
            }else{
               $gname.=$v['gname'].'|';
               $num.=$v['num'].'|';
            }
        }
        if($order['order_lid']==8){
        	$goods_name='到店买单';
            $num=1;      
        }  
        $param['keyword1']=$orderinfo['orderformid'];
        $param['keyword2']=$gname;
        $param['keyword3']=$num;
        $param['keyword4']=$orderinfo['order_amount'];
        $param['keyword5']=date('Y-m-d H:i');
        $this->setSendTemplate($param); 
      
      //到店支付
    	if($orderinfo['order_lid']==8) {
          $res = pdo_update('yzcyk_sun_order', array('pay_status' => 1, 'pay_time' => time(),'order_status'=>3,'transaction_id'=>$_GPC['transaction_id']), array('id' => $_GPC['order_id']));
          echo 1;
          exit;
        }
        if($orderinfo['order_lid']==5) {

        }
        if($orderinfo['order_lid']==4&&$orderinfo['pin_buy_type']==1){
            //商品详情
            $goods=pdo_get('yzcyk_sun_goods',array('id'=>$orderinfo['crid'],'uniacid'=>$_W['uniacid']));
            //拼团支付完成发起拼团
            $user_groups=array(
                'mch_id'=>$orderinfo['pin_mch_id'],
                'gid'=>$orderinfo['crid'],
                'openid'=>$orderinfo['uid'],
                'order_id'=>$_GPC['order_id'],
                'uniacid'=>$_W['uniacid'],
                'status'=>2,
                'price'=>$orderinfo['order_amount'],
                'buynum'=>$goods['pintuan_num'],
                'addtime'=>time(),
            );
            if($orderinfo['pin_mch_id']==0){
                $user_groups['num']=1;
                $user_groups['end_time']=intval(time())+intval($goods['pin_hours'])*60*60;
            }else if($orderinfo['pin_mch_id']>0){
               //获取拼主详情
                $user_group=pdo_get('yzcyk_sun_user_groups',array('id'=>$orderinfo['pin_mch_id'],'uniacid'=>$_W['uniacid']));
                $user_groups['num']=$user_group['num']+1;
                $user_groups['end_time']=$user_group['end_time'];
                if($user_groups['num']>=$user_group['buynum']){
                    $user_groups['status']=1;
                }
            }
            $groups=pdo_get('yzcyk_sun_user_groups',array('order_id'=>$_GPC['order_id'],'openid'=>$orderinfo['uid'],'uniacid'=>$_W['uniacid']));
            if(empty($groups)){
                pdo_insert('yzcyk_sun_user_groups',$user_groups);
                $groups_id=pdo_insertid();

                if($orderinfo['pin_mch_id']>0){
                    //修改拼主数量 拼客数量
                    pdo_update('yzcyk_sun_user_groups',array('num +='=>1),array('id'=>$orderinfo['pin_mch_id']));
                    pdo_update('yzcyk_sun_user_groups',array('num'=>$user_groups['num']),array('mch_id'=>$orderinfo['pin_mch_id']));
                    //修改拼团状态
                    if($groups_id>0&&$user_groups['status']==1){
                        pdo_update('yzcyk_sun_user_groups',array('status'=>1),array('id'=>$orderinfo['pin_mch_id']));
                        pdo_update('yzcyk_sun_user_groups',array('status'=>1),array('mch_id'=>$orderinfo['pin_mch_id']));
                    }
                }
            }

        }
        //获取订单详情
        $detail=pdo_getall('yzcyk_sun_order_detail',array('order_id'=>$_GPC['order_id'],'uniacid'=>$_W['uniacid']));
        foreach($detail as $val){
            pdo_update('yzcyk_sun_goods', array('num -=' => $val['num'], 'sales_num +=' => $val['num']), array('id' => $val['gid']));
        }
        $res = pdo_update('yzcyk_sun_order', array('pay_status' => 1, 'pay_time' => time(),'order_status'=>1,'transaction_id'=>$_GPC['transaction_id']), array('id' => $_GPC['order_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//付款改变订单状态
    public function doPagePayOrder1()
    {
        global $_W, $_GPC;
        //获取订单信息
        $orderinfo = pdo_get('yzcyk_sun_order', array('id' => $_GPC['order_id']));
        pdo_update('yzcyk_sun_goods', array('goods_num -=' => $orderinfo['good_num'], 'sales +=' => $orderinfo['good_num']), array('id' => $orderinfo['good_id']));
        $res = pdo_update('yzcyk_sun_order', array('state' => 2, 'pay_time' => time()), array('id' => $_GPC['order_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //发货
    public function doPageDeliveryOrder()
    {
        global $_W, $_GPC;
        $res = pdo_update('yzcyk_sun_order', array('state' => 3, 'fh_time' => time()), array('id' => $_GPC['order_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//确认收货
    public function doPageCompleteOrder()
    {
        global $_W, $_GPC;
        $order = pdo_get('yzcyk_sun_order', array('id' => $_GPC['order_id']));
        $res = pdo_update('yzcyk_sun_order', array('state' => 4, 'complete_time' => time()), array('id' => $_GPC['order_id']));
        if ($res) {
            pdo_update('yzcyk_sun_store', array('wallet +=' => $order['money']));
            $data['store_id'] = $order['store_id'];
            $data['money'] = $order['money'];
            $data['note'] = '商品订单';
            $data['type'] = 1;
            $data['time'] = date("Y-m-d H:i:s");
            pdo_insert('yzcyk_sun_store_wallet', $data);

/////////////////分销/////////////////

            $set = pdo_get('yzcyk_sun_fxset', array('uniacid' => $_W['uniacid']));
            $order = pdo_get('yzcyk_sun_order', array('id' => $_GPC['order_id']));
            if ($set['is_open'] == 1) {
                if ($set['is_ej'] == 2) {//不开启二级分销
                    $user = pdo_get('yzcyk_sun_fxuser', array('fx_user' => $order['user_id']));
                    if ($user) {
                        $userid = $user['user_id'];//上线id
                        $money = $order['money'] * ($set['commission'] / 100);//一级佣金
                        pdo_update('yzcyk_sun_user', array('commission +=' => $money), array('id' => $userid));
                        $data6['user_id'] = $userid;//上线id
                        $data6['son_id'] = $order['user_id'];//下线id
                        $data6['money'] = $money;//金额
                        $data6['time'] = time();//时间
                        $data6['uniacid'] = $_W['uniacid'];
                        pdo_insert('yzcyk_sun_earnings', $data6);
                    }
                } else {//开启二级
                    $user = pdo_get('yzcyk_sun_fxuser', array('fx_user' => $order['user_id']));
                    $user2 = pdo_get('yzcyk_sun_fxuser', array('fx_user' => $user['user_id']));//上线的上线
                    if ($user) {
                        $userid = $user['user_id'];//上线id
                        $money = $order['money'] * ($set['commission'] / 100);//一级佣金
                        pdo_update('yzcyk_sun_user', array('commission +=' => $money), array('id' => $userid));
                        $data6['user_id'] = $userid;//上线id
                        $data6['son_id'] = $order['user_id'];//下线id
                        $data6['money'] = $money;//金额
                        $data6['time'] = time();//时间
                        $data6['uniacid'] = $_W['uniacid'];
                        pdo_insert('yzcyk_sun_earnings', $data6);
                    }
                    if ($user2) {
                        $userid2 = $user2['user_id'];//上线的上线id
                        $money = $order['money'] * ($set['commission2'] / 100);//二级佣金
                        pdo_update('yzcyk_sun_user', array('commission +=' => $money), array('id' => $userid2));
                        $data7['user_id'] = $userid2;//上线id
                        $data7['son_id'] = $order['user_id'];//下线id
                        $data7['money'] = $money;//金额
                        $data7['time'] = time();//时间
                        $data7['uniacid'] = $_W['uniacid'];
                        pdo_insert('yzcyk_sun_earnings', $data7);
                    }
                }
            }

/////////////////分销/////////////////


            echo '1';
        } else {
            echo '2';
        }
    }

    //取消订单
    public function doPageCancel()
    {
        global $_GPC;
        $oid = $_GPC['oid'];
        $res = pdo_delete('yzcyk_sun_order', array('id' => $oid));
        echo $res;
    }

    //查看商家余额明细
    public function doPageStoreWallet()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_store_wallet', array('store_id' => $_GPC['store_id']));
        echo json_encode($res);
    }

//查看我的订单
    public function doPageMyOrder()
    {
        global $_W, $_GPC;
        $uid = $_GPC['uid'];
        $res = pdo_getall('yzcyk_sun_order', array('user_id', $uid));

        echo json_encode($res);
    }

//  public function doPageOrderInfo(){
//      global $_W, $_GPC;
//     $sql="select a.*,b.store_name from " . tablename("yzcyk_sun_order") . " a"  . " left join " . tablename("yzcyk_sun_store") . " b on b.id=a.store_id  WHERE a.id=:id ";
//    	$res=pdo_fetch($sql,array(':id'=>$_GPC['order_id']));
//      echo json_encode($res);
//  }
//更新用户地址信息
    public function doPageUpdAdd()
    {
        global $_W, $_GPC;
        $data['user_name'] = $_GPC['user_name'];
        $data['user_tel'] = $_GPC['user_tel'];
        $data['user_address'] = $_GPC['user_address'];
        $res = pdo_update('yzcyk_sun_user', $data, array('id' => $_GPC['user_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//用户删除订单
    public function doPageDelOrder123()
    {
        global $_W, $_GPC;
        $res = pdo_update('yzcyk_sun_order', array('del' => 1), array('id' => $_GPC['order_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//商家删除订单
    public function doPageDelOrder2()
    {
        global $_W, $_GPC;
        $res = pdo_update('yzcyk_sun_order', array('del2' => 1), array('id' => $_GPC['order_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //商家订单列表
    public function doPageStoreOrder()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.name,b.img from " . tablename("yzcyk_sun_order") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.store_id=:store_id and a.del2=2";
        $res = pdo_fetchall($sql, array(':store_id' => $_GPC['store_id']));
        echo json_encode($res);
    }

    //商家订单详情
    public function doPageStoreOrderInfo()
    {
        global $_W, $_GPC;
        $sql = "select a.*,b.name,b.img from " . tablename("yzcyk_sun_order") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.id=:order_id and a.del2=2";
        $res = pdo_fetch($sql, array(':order_id' => $_GPC['order_id']));
        echo json_encode($res);
    }

//申请退款
    public function doPageTuOrder()
    {
        global $_W, $_GPC;
        $res = pdo_update('yzcyk_sun_order', array('state' => 5), array('id' => $_GPC['order_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //申请分销商
    public function doPageDistribution()
    {
        global $_W, $_GPC;
        pdo_delete('yzcyk_sun_distribution', array('user_id' => $_GPC['user_id']));
        $data['user_id'] = $_GPC['user_id'];
        $data['user_name'] = $_GPC['user_name'];
        $data['user_tel'] = $_GPC['user_tel'];
        $data['time'] = time();
        $data['state'] = 1;
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_distribution', $data);
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//查看我的申请
    public function doPageMyDistribution()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_distribution', array('user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }

//分销设置
    public function doPageFxSet()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_fxset', array('uniacid' => $_W['uniacid']));
        echo json_encode($res);
    }

    //查看我的上线
    public function doPageMySx()
    {
        global $_W, $_GPC;
        $sql = "select a.* ,b.name from " . tablename("yzcyk_sun_fxuser") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id   WHERE a.fx_user=:fx_user ";
        $res = pdo_fetch($sql, array(':fx_user' => $_GPC['user_id']));
        echo json_encode($res);
    }

    //查看我的佣金收益
    public function doPageEarnings()
    {
        global $_W, $_GPC;
        $sql = "select a.* ,b.name,b.img from " . tablename("yzcyk_sun_earnings") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.son_id   WHERE a.user_id=:user_id order by id DESC";
        $res = pdo_fetchall($sql, array(':user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }

//我的二维码
    public function doPageMyCode()
    {
        global $_W, $_GPC;
        function getCoade($storeid)
        {
            function getaccess_token()
            {
                global $_W, $_GPC;
                $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
                $appid = $res['appid'];
                $secret = $res['appsecret'];
                // print_r($res);die;
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $data = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($data, true);
                return $data['access_token'];
            }

            function set_msg($storeid)
            {
                $access_token = getaccess_token();
                $data2 = array(
                    "scene" => $storeid,
                    // /"page"=>"zh_dianc/pages/info/info",
                    "width" => 400
                );
                $data2 = json_encode($data2);
                $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token . "";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
                $data = curl_exec($ch);
                curl_close($ch);
                return $data;
            }

            $img = set_msg($storeid);
            $img = base64_encode($img);
            return $img;
        }

        echo getCoade($_GPC['user_id']);

    }

//佣金提现
    public function doPageYjtx()
    {
        global $_W, $_GPC;
        $data['user_id'] = $_GPC['user_id'];
        $data['type'] = $_GPC['type'];//类型
        $data['user_name'] = $_GPC['user_name'];//姓名
        $data['account'] = $_GPC['account'];//账号
        $data['tx_cost'] = $_GPC['tx_cost'];//提现金额
        $data['sj_cost'] = $_GPC['sj_cost'];//实际到账金额
        $data['state'] = 1;
        $data['time'] = time();
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_commission_withdrawal', $data);
        if ($res) {
            pdo_update('yzcyk_sun_user', array('commission -=' => $_GPC['tx_cost']), array('id' => $_GPC['user_id']));
            echo '1';
        } else {
            echo '2';
        }
    }

//提现明细
    public function doPageYjtxList()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_commission_withdrawal', array('user_id' => $_GPC['user_id']), array(), '', 'id DESC');
        echo json_encode($res);
    }

//绑定分销商
    public function doPageBinding()
    {
        global $_W, $_GPC;
        $set = pdo_get('yzcyk_sun_fxset', array('uniacid' => $_W['uniacid']));
        $res = pdo_get('yzcyk_sun_fxuser', array('fx_user' => $_GPC['fx_user']));
        $res2 = pdo_get('yzcyk_sun_fxuser', array('user_id' => $_GPC['fx_user'], 'fx_user' => $_GPC['user_id']));
        if ($set['is_open'] == 1) {
            if ($_GPC['user_id'] == $_GPC['fx_user']) {
                echo '自己不能绑定自己';
            } elseif ($res || $res2) {
                echo '不能重复绑定';
            } else {
                $res3 = pdo_insert('yzcyk_sun_fxuser', array('user_id' => $_GPC['user_id'], 'fx_user' => $_GPC['fx_user'], 'time' => time()));
                if ($res3) {
                    echo '1';
                } else {
                    echo '2';
                }
            }
        }


    }

//查看我的团队
    public function doPageMyTeam()
    {
        global $_W, $_GPC;
        $sql = "select a.* ,b.name,b.img from " . tablename("yzcyk_sun_fxuser") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.fx_user   WHERE a.user_id=:user_id order by id DESC";
        $res = pdo_fetchall($sql, array(':user_id' => $_GPC['user_id']));
        $res2 = array();
        for ($i = 0; $i < count($res); $i++) {
            $sql2 = "select a.* ,b.name,b.img from " . tablename("yzcyk_sun_fxuser") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.fx_user   WHERE a.user_id=:user_id order by id DESC";
            $res3 = pdo_fetchall($sql2, array(':user_id' => $res[$i]['fx_user']));
            $res2[] = $res3;

        }

        $res4 = array();
        for ($k = 0; $k < count($res2); $k++) {
            for ($j = 0; $j < count($res2[$k]); $j++) {
                $res4[] = $res2[$k][$j];
            }

        }
        $data['one'] = $res;
        $data['two'] = $res4;
        // print_r($data);die;
        echo json_encode($data);
    }

//查看佣金
    public function doPageMyCommission()
    {
        global $_W, $_GPC;
        $system = pdo_get('yzcyk_sun_fxset', array('uniacid' => $_W['uniacid']));//tx_money
        $user = pdo_get('yzcyk_sun_user', array('id' => $_GPC['user_id']));
        if ($user['commission'] < $system['tx_money']) {
            $ke = 0.00;
        } else {
            $ke = $user['commission'];
        }
        $sq = "select sum(tx_cost) as tx_cost from " . tablename("yzcyk_sun_commission_withdrawal") . " WHERE  user_id=" . $_GPC['user_id'];
        $sq = pdo_fetch($sq);
        $sq = $sq['tx_cost'];

        $cg = "select sum(tx_cost) as tx_cost from " . tablename("yzcyk_sun_commission_withdrawal") . " WHERE  state=2 and user_id=" . $_GPC['user_id'];
        $cg = pdo_fetch($cg);
        $cg = $cg['tx_cost'];

        $lei = "select sum(money) as tx_cost from " . tablename("yzcyk_sun_earnings") . " WHERE  user_id=" . $_GPC['user_id'];
        $lei = pdo_fetch($lei);
        $lei = $lei['tx_cost'];

        $data['ke'] = $ke;
        $data['sq'] = $sq;
        $data['cg'] = $cg;
        $data['lei'] = $lei;
        echo json_encode($data);
    }


//添加佣金
    public function doPageFx()
    {
        global $_W, $_GPC;
        $set = pdo_get('yzcyk_sun_fxset', array('uniacid' => $_W['uniacid']));
        if ($set['is_open'] == 1) {
            if ($set['is_ej'] == 2) {//不开启二级分销
                $user = pdo_get('yzcyk_sun_fxuser', array('fx_user' => $_GPC['user_id']));
                if ($user) {
                    $userid = $user['user_id'];//上线id
                    $money = $_GPC['money'] * ($set['commission'] / 100);//一级佣金
                    pdo_update('yzcyk_sun_user', array('commission +=' => $money), array('id' => $userid));
                    $data6['user_id'] = $userid;//上线id
                    $data6['son_id'] = $_GPC['user_id'];//下线id
                    $data6['money'] = $money;//金额
                    $data6['time'] = time();//时间
                    $data6['uniacid'] = $_W['uniacid'];
                    pdo_insert('yzcyk_sun_earnings', $data6);
                }
            } else {//开启二级
                $user = pdo_get('yzcyk_sun_fxuser', array('fx_user' => $_GPC['user_id']));
                $user2 = pdo_get('yzcyk_sun_fxuser', array('fx_user' => $user['user_id']));//上线的上线
                if ($user) {
                    $userid = $user['user_id'];//上线id
                    $money = $_GPC['money'] * ($set['commission'] / 100);//一级佣金
                    pdo_update('yzcyk_sun_user', array('commission +=' => $money), array('id' => $userid));
                    $data6['user_id'] = $userid;//上线id
                    $data6['son_id'] = $_GPC['user_id'];//下线id
                    $data6['money'] = $money;//金额
                    $data6['time'] = time();//时间
                    $data6['uniacid'] = $_W['uniacid'];
                    pdo_insert('yzcyk_sun_earnings', $data6);
                }
                if ($user2) {
                    $userid2 = $user2['user_id'];//上线的上线id
                    $money = $_GPC['money'] * ($set['commission2'] / 100);//二级佣金
                    pdo_update('yzcyk_sun_user', array('commission +=' => $money), array('id' => $userid2));
                    $data7['user_id'] = $userid2;//上线id
                    $data7['son_id'] = $_GPC['user_id'];//下线id
                    $data7['money'] = $money;//金额
                    $data7['time'] = time();//时间
                    $data7['uniacid'] = $_W['uniacid'];
                    pdo_insert('yzcyk_sun_earnings', $data7);
                }
            }
        }
    }

//入驻黄页
    public function doPageYellowPage()
    {
        global $_W, $_GPC;
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $data['user_id'] = $_GPC['user_id'];
        $data['logo'] = $_GPC['logo'];
        $data['company_name'] = $_GPC['company_name'];
        $data['company_address'] = $_GPC['company_address'];
        $data['type_id'] = $_GPC['type_id'];
        $data['link_tel'] = $_GPC['link_tel'];
        $data['rz_type'] = $_GPC['rz_type'];
        $data['coordinates'] = $_GPC['coordinates'];
        $data['content'] = $_GPC['content'];
        $data['imgs'] = $_GPC['imgs'];
        $data['tel2'] = $_GPC['tel2'];
        $data['cityname'] = $_GPC['cityname'];
        $data['uniacid'] = $_W['uniacid'];
        $data['time_over'] = 2;
        if ($system['is_hyset'] == 1) {
            $data['state'] = 1;
        } else {
            $data['state'] = 2;
            $data['sh_time'] = time();
        }

        $res = pdo_insert('yzcyk_sun_yellowstore', $data);
        $hy_id = pdo_insertid();
        if ($res) {
            echo $hy_id;
        } else {
            echo '2';
        }
    }

    //查看我入驻的黄页
    public function doPageMyYellowPage()
    {
        global $_W, $_GPC;
        $sql = "select a.* ,b.type_name from " . tablename("yzcyk_sun_yellowstore") . " a" . " left join " . tablename("yzcyk_sun_storetype") . " b on b.id=a.type_id   WHERE a.user_id=:user_id order by a.id desc ";
        $res = pdo_fetchall($sql, array(':user_id' => $_GPC['user_id']));

        echo json_encode($res);
    }

    //查看黄页列表
    public function doPageYellowPageList()
    {
        global $_W, $_GPC;
        //修改以前的数据

        $list = pdo_getall('yzcyk_sun_yellowstore', array('uniacid' => $_W['uniacid'], 'state' => 2));
        foreach ($list as $v) {
            $set = pdo_get('yzcyk_sun_yellowset', array('id' => $v['rz_type']));
            pdo_update('yzcyk_sun_yellowstore', array('dq_time' => $v['sh_time'] + $set['days'] * 24 * 60 * 60), array('id' => $v['id']));
        }
        $rst = pdo_update('yzcyk_sun_yellowstore', array('time_over' => 1), array('dq_time <=' => time(), 'state' => 2));
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $where = " WHERE a.uniacid=:uniacid and a.state=2 and a.time_over=2 ";
        if ($_GPC['cityname']) {
            $where .= " and a.cityname LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['cityname'];
        }
        if ($_GPC['keywords']) {
            $where .= " and a.company_name LIKE  concat('%', :name,'%') ";
            $data[':name'] = $_GPC['keywords'];
        }
        $data[':uniacid'] = $_W['uniacid'];
        $sql = "select a.* ,b.type_name from " . tablename("yzcyk_sun_yellowstore") . " a" . " left join " . tablename("yzcyk_sun_storetype") . " b on b.id=a.type_id " . $where . " order by id DESC";
        // $res=pdo_fetch($sql,array(':uniacid'=>$_W['uniacid']));
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, $data);
        echo json_encode($res);
    }

    //查看黄页详情
    public function doPageYellowPageInfo()
    {
        global $_W, $_GPC;
        pdo_update('yzcyk_sun_yellowstore', array('views +=' => 1), array('id' => $_GPC['id']));
        $sql = "select a.* ,b.type_name from " . tablename("yzcyk_sun_yellowstore") . " a" . " left join " . tablename("yzcyk_sun_storetype") . " b on b.id=a.type_id   WHERE a.id=:id";
        $res = pdo_fetch($sql, array(':id' => $_GPC['id']));

        echo json_encode($res);
    }

//查看黄页入驻设置
    public function doPageYellowSet()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_yellowset', array('uniacid' => $_W['uniacid']), array(), '', 'num asc');
        echo json_encode($res);
    }

//登录
    public function doPageStoreLogin()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_store', array('user_name' => $_GPC['user_name']));
        $res2 = pdo_get('yzcyk_sun_store', array('user_name' => $_GPC['user_name'], 'pwd' => md5($_GPC['pwd'])));
        if (!$res) {
            echo '账号不存在!';
        } elseif (!$res2) {
            echo '密码不正确!';
        } elseif ($res2) {
            echo json_encode($res2);
        }

    }
    //上传图片
   public function doPageUpload1()
    {
        $uptypes = array(
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/pjpeg',
            'image/gif',
            'image/bmp',
            'image/x-png'
        );
        $max_file_size = 2000000;     //上传文件大小限制, 单位BYTE
        $destination_folder = "../attachment/"; //上传文件路径
        $watermark = 2;      //是否附加水印(1为加水印,其他为不加水印);
        $watertype = 1;      //水印类型(1为文字,2为图片)
        $waterposition = 1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
        $waterstring = "666666";  //水印字符串
        // $waterimg="xplore.gif";    //水印图片
        $imgpreview = 1;      //是否生成预览图(1为生成,其他为不生成);
        $imgpreviewsize = 1 / 2;    //缩略图比例
        if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])) //是否存在文件
        {
            echo "图片不存在!";
            exit;
        }
        $file = $_FILES["upfile"];
        if ($max_file_size < $file["size"]) //检查文件大小
        {
            echo "文件太大!";
            exit;
        }
        if (!in_array($file["type"], $uptypes)) //检查文件类型
        {
            echo "文件类型不符!" . $file["type"];
            exit;
        }
        if (!file_exists($destination_folder)) {
            mkdir($destination_folder);
        }
        $filename = $file["tmp_name"];
        $image_size = getimagesize($filename);
        $pinfo = pathinfo($file["name"]);
        $ftype = $pinfo['extension'];
        $destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . "." . $ftype;
        if (file_exists($destination) && $overwrite != true) {
            echo "同名文件已经存在了";
            exit;
        }
        if (!move_uploaded_file($filename, $destination)) {
            echo "移动文件出错";
            exit;
        }
        $pinfo = pathinfo($destination);
        $fname = $pinfo['basename'];
        // echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";
        // echo " 宽度:".$image_size[0];
        // echo " 长度:".$image_size[1];
        // echo "<br> 大小:".$file["size"]." bytes";
        if ($watermark == 1) {
            $iinfo = getimagesize($destination, $iinfo);
            $nimage = imagecreatetruecolor($image_size[0], $image_size[1]);
            $white = imagecolorallocate($nimage, 255, 255, 255);
            $black = imagecolorallocate($nimage, 0, 0, 0);
            $red = imagecolorallocate($nimage, 255, 0, 0);
            imagefill($nimage, 0, 0, $white);
            switch ($iinfo[2]) {
                case 1:
                    $simage = imagecreatefromgif($destination);
                    break;
                case 2:
                    $simage = imagecreatefromjpeg($destination);
                    break;
                case 3:
                    $simage = imagecreatefrompng($destination);
                    break;
                case 6:
                    $simage = imagecreatefromwbmp($destination);
                    break;
                default:
                    die("不支持的文件类型");
                    exit;
            }
            imagecopy($nimage, $simage, 0, 0, 0, 0, $image_size[0], $image_size[1]);
            imagefilledrectangle($nimage, 1, $image_size[1] - 15, 80, $image_size[1], $white);
            switch ($watertype) {
                case 1:   //加水印字符串
                    imagestring($nimage, 2, 3, $image_size[1] - 15, $waterstring, $black);
                    break;
                case 2:   //加水印图片
                    $simage1 = imagecreatefromgif("xplore.gif");
                    imagecopy($nimage, $simage1, 0, 0, 0, 0, 85, 15);
                    imagedestroy($simage1);
                    break;
            }
            switch ($iinfo[2]) {
                case 1:
                    //imagegif($nimage, $destination);
                    imagejpeg($nimage, $destination);
                    break;
                case 2:
                    imagejpeg($nimage, $destination);
                    break;
                case 3:
                    imagepng($nimage, $destination);
                    break;
                case 6:
                    imagewbmp($nimage, $destination);
                    //imagejpeg($nimage, $destination);
                    break;
            }
            //覆盖原上传文件
            imagedestroy($nimage);
            imagedestroy($simage);
        }
        // if($imgpreview==1)
        // {
        // echo "<br>图片预览:<br>";
        // echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
        // echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";
        // }
        echo $fname;
        @require_once(IA_ROOT . '/framework/function/file.func.php');
        @$filename = $fname;
        @file_remote_upload($filename);
    }

    //上传图片
    public function doPageUpload()
    {
        $uptypes = array(
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/pjpeg',
            'image/gif',
            'image/bmp',
            'image/x-png'
        );
        $max_file_size = 2000000;     //上传文件大小限制, 单位BYTE
        $destination_folder = "../attachment/"; //上传文件路径
        $watermark = 2;      //是否附加水印(1为加水印,其他为不加水印);
        $watertype = 1;      //水印类型(1为文字,2为图片)
        $waterposition = 1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
        $waterstring = "666666";  //水印字符串
        // $waterimg="xplore.gif";    //水印图片
        $imgpreview = 1;      //是否生成预览图(1为生成,其他为不生成);
        $imgpreviewsize = 1 / 2;    //缩略图比例
        if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])) //是否存在文件
        {
            echo "图片不存在!";
            exit;
        }
        $file = $_FILES["upfile"];
        if ($max_file_size < $file["size"]) //检查文件大小
        {
            echo "文件太大!";
            exit;
        }
        if (!in_array($file["type"], $uptypes)) //检查文件类型
        {
            echo "文件类型不符!" . $file["type"];
            exit;
        }
        if (!file_exists($destination_folder)) {
            mkdir($destination_folder);
        }
        $filename = $file["tmp_name"];
        $image_size = getimagesize($filename);
        $pinfo = pathinfo($file["name"]);
        $ftype = $pinfo['extension'];
        $destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . "." . $ftype;
        if (file_exists($destination) && $overwrite != true) {
            echo "同名文件已经存在了";
            exit;
        }
        if (!move_uploaded_file($filename, $destination)) {
            echo "移动文件出错";
            exit;
        }
        $pinfo = pathinfo($destination);
        $fname = $pinfo['basename'];
        // echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";
        // echo " 宽度:".$image_size[0];
        // echo " 长度:".$image_size[1];
        // echo "<br> 大小:".$file["size"]." bytes";
        if ($watermark == 1) {
            $iinfo = getimagesize($destination, $iinfo);
            $nimage = imagecreatetruecolor($image_size[0], $image_size[1]);
            $white = imagecolorallocate($nimage, 255, 255, 255);
            $black = imagecolorallocate($nimage, 0, 0, 0);
            $red = imagecolorallocate($nimage, 255, 0, 0);
            imagefill($nimage, 0, 0, $white);
            switch ($iinfo[2]) {
                case 1:
                    $simage = imagecreatefromgif($destination);
                    break;
                case 2:
                    $simage = imagecreatefromjpeg($destination);
                    break;
                case 3:
                    $simage = imagecreatefrompng($destination);
                    break;
                case 6:
                    $simage = imagecreatefromwbmp($destination);
                    break;
                default:
                    die("不支持的文件类型");
                    exit;
            }
            imagecopy($nimage, $simage, 0, 0, 0, 0, $image_size[0], $image_size[1]);
            imagefilledrectangle($nimage, 1, $image_size[1] - 15, 80, $image_size[1], $white);
            switch ($watertype) {
                case 1:   //加水印字符串
                    imagestring($nimage, 2, 3, $image_size[1] - 15, $waterstring, $black);
                    break;
                case 2:   //加水印图片
                    $simage1 = imagecreatefromgif("xplore.gif");
                    imagecopy($nimage, $simage1, 0, 0, 0, 0, 85, 15);
                    imagedestroy($simage1);
                    break;
            }
            switch ($iinfo[2]) {
                case 1:
                    //imagegif($nimage, $destination);
                    imagejpeg($nimage, $destination);
                    break;
                case 2:
                    imagejpeg($nimage, $destination);
                    break;
                case 3:
                    imagepng($nimage, $destination);
                    break;
                case 6:
                    imagewbmp($nimage, $destination);
                    //imagejpeg($nimage, $destination);
                    break;
            }
            //覆盖原上传文件
            imagedestroy($nimage);
            imagedestroy($simage);
        }
        // if($imgpreview==1)
        // {
        // echo "<br>图片预览:<br>";
        // echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
        // echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";
        // }
        echo $fname;
        @require_once(IA_ROOT . '/framework/function/file.func.php');
        @$filename = $fname;
        @file_remote_upload($filename);
    }
/////////////////////////////////////////


    //提现金额模板消息
    public function doPageTxMessage()
    {
        global $_W, $_GPC;
        function getaccess_token($_W)
        {
            $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
            $appid = $res['appid'];
            $secret = $res['appsecret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data, true);
            return $data['access_token'];
        }

        //设置与发送模板信息

        function set_msg($_W, $_GPC)
        {
            $access_token = getaccess_token($_W);
            $res = pdo_get('yzcyk_sun_sms', array('uniacid' => $_W['uniacid']));
            $tx = pdo_get('yzcyk_sun_withdrawal', array('id' => $_GPC['txsh_id']));
            if ($tx['type'] == 1) {
                $typename = "支付宝";
            }
            if ($tx['type'] == 2) {
                $typename = "微信";
            }
            if ($tx['type'] == 3) {
                $typename = "银行卡";
            }
            $time = date('Y-m-d H:i:s', $tx['time']);
            $formwork = '{
     "touser": "' . $_GET["openid"] . '",
     "template_id": "' . $res["tid2"] . '",
     "page":"yzcyk_sun/pages/index/index",
     "form_id":"' . $_GET['form_id'] . '",
     "data": {
       "keyword1": {
         "value": "' . $tx['name'] . '",
         "color": "#173177"
       },
       "keyword2": {
         "value":"' . $tx['username'] . '",
         "color": "#173177"
       },
       "keyword3": {
         "value": "' . $tx['tx_cost'] . '",
         "color": "#173177"
       },
       "keyword4": {
         "value": "' . $tx['sj_cost'] . '",
         "color": "#173177"
       },
       "keyword5": {
         "value":  "' . $typename . '",
         "color": "#173177"
       },
        "keyword6": {
         "value":  "' . $time . '",
         "color": "#173177"
       }
     }   
   }';
            // $formwork=$data;
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formwork);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        echo set_msg($_W, $_GPC);
    }


    //商家入驻模板消息
    public function doPageRzMessage()
    {
        global $_W, $_GPC;
        function getaccess_token($_W)
        {
            $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
            $appid = $res['appid'];
            $secret = $res['appsecret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data, true);
            return $data['access_token'];
        }

        //设置与发送模板信息

        function set_msg($_W, $_GPC)
        {
            $access_token = getaccess_token($_W);
            $res2 = pdo_get('yzcyk_sun_sms', array('uniacid' => $_W['uniacid']));
            $sql = "select a.store_name,a.time,a.state,b.name as user_name from " . tablename("yzcyk_sun_store") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.id=:store_id";
            $res = pdo_fetch($sql, array(':store_id' => $_GPC['store_id']));
            $type = "待审核";
            $note = "1-3日完成审核";
            $formwork = '{
     "touser": "' . $_GET["openid"] . '",
     "template_id": "' . $res2["tid1"] . '",
     "page":"yzcyk_sun/pages/index/index",
     "form_id":"' . $_GET['form_id'] . '",
     "data": {
       "keyword1": {
         "value": "' . $res['store_name'] . '",
         "color": "#173177"
       },
       "keyword2": {
         "value":"' . $res['user_name'] . '",
         "color": "#173177"
       },
       "keyword3": {
         "value": "' . $res['time'] . '",
         "color": "#173177"
       },
       "keyword4": {
         "value": "' . $type . '",
         "color": "#173177"
       },
       "keyword5": {
         "value":  "' . $note . '",
         "color": "#173177"
       }
     }   
   }';
            // $formwork=$data;
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formwork);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        echo set_msg($_W, $_GPC);
    }


//保存商家支付记录
    public function doPageSaveStorePayLog()
    {
        global $_W, $_GPC;
        $data['store_id'] = $_GPC['store_id'];
        $data['money'] = $_GPC['money'];
        $data['time'] = date('Y-m-d H:i:s');
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_storepaylog', $data);
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //保存帖子支付记录
    public function doPageSaveTzPayLog()
    {
        global $_W, $_GPC;
        $data['tz_id'] = $_GPC['tz_id'];
        $data['money'] = $_GPC['money'];
        $data['time'] = date('Y-m-d H:i:s');
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_tzpaylog', $data);
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //保存拼车支付记录
    public function doPageSaveCarPayLog()
    {
        global $_W, $_GPC;
        $data['car_id'] = $_GPC['car_id'];
        $data['money'] = $_GPC['money'];
        $data['time'] = date('Y-m-d H:i:s');
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_carpaylog', $data);
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//保存黄页支付记录
    public function doPageSaveHyPayLog()
    {
        global $_W, $_GPC;
        $data['hy_id'] = $_GPC['hy_id'];
        $data['money'] = $_GPC['money'];
        $data['time'] = date('Y-m-d H:i:s');
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_yellowpaylog', $data);
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//保存定位城市

    public function doPageSaveHotCity()
    {
        global $_W, $_GPC;
        $rst = pdo_get('yzcyk_sun_hotcity', array('cityname' => $_GPC['cityname'], 'uniacid' => $_W['uniacid'], 'user_id' => $_GPC['user_id']));
        if (empty($rst)) {
            $data['user_id'] = $_GPC['user_id'];
            $data['cityname'] = $_GPC['cityname'];
            $data['time'] = time();
            $data['uniacid'] = $_W['uniacid'];
            $res = pdo_insert('yzcyk_sun_hotcity', $data);
            if ($res) {
                echo '1';
            } else {
                echo '2';
            }
        }

    }

//查看是否拉黑

    public function doPageGetUserInfo()
    {
        global $_W, $_GPC;
        $res = pdo_get('yzcyk_sun_user', array('id' => $_GPC['user_id']));
        echo json_encode($res);
    }

//商家分享数量加一

    public function doPageStoreFxNum()
    {
        global $_W, $_GPC;
        $res = pdo_update('yzcyk_sun_store', array('fx_num +=' => 1), array('id' => $_GPC['store_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//红包
    public function doPageRedPaperList()
    {
        global $_GPC, $_W;
        $sql = "select a.*,b.logo,c.img as user_img from " . tablename("yzcyk_sun_information") . " a" . " left join " . tablename("yzcyk_sun_store") . " b on b.id=a.store_id" . " left join " . tablename("yzcyk_sun_user") . " c on c.id=a.user_id  WHERE a.uniacid=:uniacid and a.hb_num>0 and a.del=2 and a.state=2 ORDER BY a.id DESC";
        $res = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
        echo json_encode($res);
    }

//获取城市

    public function doPageGetCity()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_hotcity', array('uniacid' => $_W['uniacid'], 'user_id' => $_GPC['user_id']));
        echo json_encode($res);
    }


//保存formid
    public function doPageSaveFormid()
    {
        global $_W, $_GPC;
        $data['user_id'] = $_GPC['user_id'];
        $data['form_id'] = $_GPC['form_id'];
        $data['openid'] = $_GPC['openid'];
        $data['time'] = date('Y-m-d H:i:s');
        $data['uniacid'] = $_W['uniacid'];
        $res = pdo_insert('yzcyk_sun_userformid', $data);
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

//删除formid
    public function doPageDelFormid()
    {
        global $_W, $_GPC;
        $res = pdo_delete('yzcyk_sun_userformid', array('user_id' => $_GPC['user_id'], 'form_id' => $_GPC['form_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //获取用户的formid
    public function doPageGetFormid()
    {
        global $_W, $_GPC;
        $res = pdo_getall('yzcyk_sun_userformid', array('user_id' => $_GPC['user_id'], 'uniacid' => $_W['uniacid']));
        echo json_encode($res);
    }


    //帖子评论成功模板消息
    public function doPageTzhfMessage()
    {
        global $_W, $_GPC;
        function getaccess_token($_W)
        {
            $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
            $appid = $res['appid'];
            $secret = $res['appsecret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data, true);
            return $data['access_token'];
        }

        //设置与发送模板信息

        function set_msg($_W, $_GPC)
        {
            $access_token = getaccess_token($_W);
            $res2 = pdo_get('yzcyk_sun_sms', array('uniacid' => $_W['uniacid']));
            $sql = "select a.details,a.information_id,a.time,b.name as user_name from " . tablename("yzcyk_sun_comments") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.id=:id ";
            $res = pdo_fetch($sql, array(':id' => $_GPC['pl_id']));
            $time = date("Y-m-d H:i:s", $res['time']);
            $formwork = '{
     "touser": "' . $_GET["openid"] . '",
     "template_id": "' . $res2["tid3"] . '",
     "page":"yzcyk_sun/pages/infodetial/infodetial?id=' . $res['information_id'] . '",
     "form_id":"' . $_GET['form_id'] . '",
     "data": {
       "keyword1": {
         "value": "' . $res['details'] . '",
         "color": "#173177"
       },
       "keyword2": {
         "value":"' . $res['user_name'] . '",
         "color": "#173177"
       },
       "keyword3": {
         "value": "' . $time . '",
         "color": "#173177"
       }
      
     }   
   }';
            // $formwork=$data;
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formwork);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        echo set_msg($_W, $_GPC);
    }


//帖子评论成功模板消息
    public function doPageStorehfMessage()
    {
        global $_W, $_GPC;
        function getaccess_token($_W)
        {
            $res = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
            $appid = $res['appid'];
            $secret = $res['appsecret'];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data, true);
            return $data['access_token'];
        }

        //设置与发送模板信息

        function set_msg($_W, $_GPC)
        {
            $access_token = getaccess_token($_W);
            $res2 = pdo_get('yzcyk_sun_sms', array('uniacid' => $_W['uniacid']));
            $sql = "select a.details,a.store_id,a.time,b.name as user_name from " . tablename("yzcyk_sun_comments") . " a" . " left join " . tablename("yzcyk_sun_user") . " b on b.id=a.user_id  WHERE a.id=:id ";
            $res = pdo_fetch($sql, array(':id' => $_GPC['pl_id']));
            $time = date("Y-m-d H:i:s", $res['time']);
            $formwork = '{
     "touser": "' . $_GET["openid"] . '",
     "template_id": "' . $res2["tid3"] . '",
     "page":"yzcyk_sun/pages/sellerinfo/sellerinfo?id=' . $res['store_id'] . '",
     "form_id":"' . $_GET['form_id'] . '",
     "data": {
       "keyword1": {
         "value": "' . $res['details'] . '",
         "color": "#173177"
       },
       "keyword2": {
         "value":"' . $res['user_name'] . '",
         "color": "#173177"
       },
       "keyword3": {
         "value": "' . $time . '",
         "color": "#173177"
       }
      
     }   
   }';
            // $formwork=$data;
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token . "";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formwork);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        echo set_msg($_W, $_GPC);
    }


    //商家福利
    public function doPageMyPost2()
    {
        global $_GPC, $_W;
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $sql = "select a.*,b.type_name,c.name as type2_name from " . tablename("yzcyk_sun_information") . " a" . " left join " . tablename("yzcyk_sun_type") . " b on b.id=a.type_id  " . " left join " . tablename("yzcyk_sun_type2") . " c on a.type2_id=c.id   WHERE a.store_id=:store_id and a.del=2   ORDER BY a.id DESC";
        $select_sql = $sql . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize;
        $res = pdo_fetchall($select_sql, array(':store_id' => $_GPC['user_id']));

        echo json_encode($res);
    }

//红包分享

    public function doPageHbFx()
    {
        global $_GPC, $_W;
        $res = pdo_update('yzcyk_sun_information', array('hbfx_num +=' => 1), array('id' => $_GPC['information_id']));
        if ($res) {
            echo 1;
        } else {
            echo 2;
        }
    }


//获取广告详情

    public function doPageGetAdInfo()
    {
        global $_GPC, $_W;
        $res = pdo_get('yzcyk_sun_ad', array('id' => $_GPC['ad_id']));
        echo json_encode($res);
    }

//获取首页轮播图
    public function doPageBanner()
    {
        global $_GPC, $_W;
        $banner = pdo_get('yzcyk_sun_banner', array('uniacid' => $_W['uniacid']));
        $banner['lb_imgs'] = explode(',', $banner['lb_imgs']);
        echo json_encode($banner);
    }
    //获取基础信息
    public function doPageSettings(){
        global $_GPC, $_W;
        $setting = pdo_get('yzcyk_sun_settings', array('uniacid' => $_W['uniacid']));
        $privilege_identifier=pdo_getall('yzcyk_sun_privilege_identifier',array('uniacid'=>$_W['uniacid']));
        $setting['privilege_identifier']=$privilege_identifier;
        echo json_encode($setting);
    }


//获取首页图标
    public function doPageIcons()
    {
        global $_GPC, $_W;
        $icons = pdo_get('yzcyk_sun_yingxiao', array('uniacid' => $_W['uniacid']));
        $system=pdo_get('yzcyk_sun_system',array('uniacid' => $_W['uniacid']));
        return $this->result(0, '', $icons,$system);
    }

//获取会员卡信息icons
    public function doPageGetVipcard()
    {
        global $_GPC, $_W;
        $data = pdo_get('yzcyk_sun_vipcard', array('uniacid' => $_W['uniacid']));
        return $this->result(0, '', $data);
    }

//购买会员卡成功
    public function doPageBuyOK()
    {
        global $_GPC, $_W;
        $uid = $_GPC['openid'];
        $data = array(
            'uid' => $uid,
            'vipcard_id' => $_GPC['id'],
            'card_number' => time(),
            'uniacid' => $_W['uniacid'],
        );
        $res = pdo_insert('yzcyk_sun_user_vipcard', $data);
        if ($res) {
            return $this->result(0, '', $data);
        }
    }

//会员卡号
    public function doPageVipcardNum()
    {
        global $_GPC, $_W;
        $uid = $_GPC['openid'];
        $data = pdo_get('yzcyk_sun_user_vipcard', array('uid' => $uid, 'uniacid' => $_W['uniacid']));
        return $this->result(0, '', $data);
    }

//获取个人会员卡
    public function doPagePersonVip()
    {
        global $_GPC, $_W;
        $uid = $_GPC['uid'];
        $data = pdo_get('yzcyk_sun_user_vipcard', array('uid' => $uid, 'uniacid' => $_W['uniacid']));
        $res = pdo_get('yzcyk_sun_vipcard', array('id' => $data['vipcard_id']));
        return $this->result(0, '', $res);
    }

//是否开启各个营销插件
    public function doPageSystemVip()
    {
        $data = pdo_get('yzcyk_sun_system');
        return $this->result(0, '', $data);
    }

//添加地址
    public function doPageSetAddress()
    {
        global $_GPC, $_W;
        pdo_update('yzcyk_sun_address', array('isdefault' => 0));
        $data = array(
            'consignee' => $_GPC['consignee'],
            'phone' => $_GPC['phone'],
            'address' => htmlspecialchars_decode($_GPC['address']),
            'stree' => $_GPC['stree'],
            'uid' => $_GPC['uid'],
            'isdefault' => 1,
            'uniacid' => $_W['uniacid'],
        );
        $data['address'] = ltrim($data['address'], '[');
        $data['address'] = rtrim($data['address'], ']');
        $data['address'] = str_replace('"', '', $data['address']);
        $res = pdo_insert('yzcyk_sun_address', $data);
        echo json_encode($res);
    }

//获取地址列表
    public function doPageAddressList()
    {
        global $_GPC, $_W;
        $uid = $_GPC['uid'];
        $data = pdo_getall('yzcyk_sun_address', array('uid' => $uid, 'uniacid' => $_W['uniacid']));
        return $this->result(0, '', $data);

    }

//删除地址
    public function doPageDelAddress()
    {
        global $_GPC;
        $id = $_GPC['id'];
        $res = pdo_delete('yzcyk_sun_address', ['id' => $id]);
        return $this->result(0, '', $res);
    }

//修改默认地址
    public function doPageSelectDefalut()
    {
        global $_GPC;
        $id = $_GPC['id'];
        pdo_update('yzcyk_sun_address', array('isdefault' => 0));
        $res = pdo_update('yzcyk_sun_address', array('isdefault' => 1), array('id' => $id));

        return $this->result(0, '', $res);
    }

//获取默认选中的地址
    public function doPageDefaultAddress()
    {
        global $_GPC;
        $uid = $_GPC['uid'];
        $data = pdo_get('yzcyk_sun_address', array('uid' => $uid, 'isdefault' => 1));
        return $this->result(0, '', $data);
    }

//添加购物车
    public function doPageAddShopCart()
    {
        global $_GPC, $_W;
        $sql="select * from".tablename("yzcyk_sun_shop_car")."where uniacid= :uniacid and uid= :uid and gid= :gid and combine= :combine";
        $_GPC['spec_value']=$_GPC['spec_value']=='undefined'?'':$_GPC['spec_value'];
        $_GPC['spec_value1']=$_GPC['spec_value1']=='undefined'?'':$_GPC['spec_value1'];  
        $map=array(
            ':gid'=>$_GPC['gid'],
            ':combine'=> $_GPC['spec_value'].','.$_GPC['spec_value1'],
            ':uid'=>$_GPC['uid'],
            ':uniacid'=>$_W['uniacid'],
        );
        $shop_car=pdo_fetch($sql,$map);
        if(!empty($shop_car)){
            $data['num']=$shop_car['num']+$_GPC['num'];
            $data['unit_price']=$_GPC['price'];
            $data['price']=$_GPC['price']*$data['num'];
            pdo_update('yzcyk_sun_shop_car', $data, array('id' => $shop_car['id']));
        }else{
            $data = array(
                'gid' => $_GPC['gid'],
                'num' => $_GPC['num'],
                'spec_value' => $_GPC['spec_value'],
                'spec_value1'=>$_GPC['spec_value1'],
                'combine'=> $_GPC['spec_value'].','.$_GPC['spec_value1'],
                'gname' => $_GPC['gname'],
                'unit_price'=>$_GPC['price'],
                'price' => $_GPC['price'] * $_GPC['num'],
                'pic' => $_GPC['pic'],
                'uid' => $_GPC['uid'],
                'uniacid' => $_W['uniacid'],
            );
            $res = pdo_insert('yzcyk_sun_shop_car', $data);
        }
        return $this->result(0, '', $res);
    }

//获取购物车数据
    public function doPageGetShopCar()
    {
        global $_GPC, $_W;
        $uid = $_GPC['uid'];
        $data = pdo_getall('yzcyk_sun_shop_car', array('uid' => $uid, 'uniacid' => $_W['uniacid']));
        foreach($data as &$val){
        	$num=pdo_getcolumn('yzcyk_sun_goods',array( 'uniacid' => $_W['uniacid'],'id'=>$val['gid']),'num',1);
            if($num<$val['num']){
            	$val['no_stock']=1;
            }
        }
        return $this->result(0, '', $data);
    }

//增加或减少个购物车数量AddShopCart
    public function doPagebuyNum()
    {
        global $_GPC;
        $data = array(
            'num' => $_GPC['num'],
            'price' => $_GPC['price'],
        );
        $res = pdo_update('yzcyk_sun_shop_car', $data, array('id' => $_GPC['id']));
        return $this->result(0, '', $res);
    }

//删除购物车
    public function doPageDelSopCar()
    {
        global $_GPC;
        $id = rtrim($_GPC['id'], ',');
        $id = explode(',', $id);
        foreach ($id as $k => $v) {
            $res = pdo_delete('yzcyk_sun_shop_car', array('id' => $v));
        }
        return $this->result(0, '', $res);
    }
    //删除单条记录购物车
    public function doPageDelSopSingleCar(){
        global $_GPC, $_W;
        $id=$_GPC['id'];
        $shop_car=pdo_get('yzcyk_sun_shop_car',array('id'=>$id));
        $res = pdo_delete('yzcyk_sun_shop_car', array('id' => $id));
        $message=pdo_getall('yzcyk_sun_shop_car', array('uid' => $shop_car['uid'], 'uniacid' => $_W['uniacid']));
        return $this->result(0, $message, $res);

    }
    //清空购物车
    public function doPageEmptySopCar(){
        global $_GPC, $_W;
        $uid=$_GPC['uid'];
        $res = pdo_delete('yzcyk_sun_shop_car', array('uid' => $uid, 'uniacid' => $_W['uniacid']));
        return $this->result(0, '', $res);
    }

//获取我的订单列表
    public function doPageOrderList()
    {
        global $_GPC, $_W;
        $uid = $_GPC['uid'];
        $data = pdo_getall('yzcyk_sun_order', array('user_id' => $uid, 'uniacid' => $_W['uniacid']), '', '', 'id DESC');
        foreach ($data as $k => $v) {
            $data[$k]['good_money'] = rtrim($v['good_money'], ',');
            $data[$k]['good_name'] = rtrim($v['good_name'], ',');
            $data[$k]['good_img'] = rtrim($v['good_img'], ',');
            $data[$k]['good_spec'] = rtrim($v['good_spec'], ',');
            $data[$k]['good_num'] = rtrim($v['good_num'], ',');
        }
        foreach ($data as $k => $v) {
            $data[$k]['good_money'] = explode(',', $v['good_money']);
            $data[$k]['good_name'] = explode(',', $v['good_name']);
            $data[$k]['good_img'] = explode(',', $v['good_img']);
            $data[$k]['good_spec'] = explode(',', $v['good_spec']);
            $data[$k]['good_num'] = explode(',', $v['good_num']);
        }
        return $this->result(0, '', $data);
    }

//获取订单状态
    public function doPageOrderStatus()
    {
        global $_GPC, $_W;
        $uid = $_GPC['uid'];
        $curType = $_GPC['curType'];
        if ($curType == 1) {
            $data = pdo_getall('yzcyk_sun_order', array('user_id' => $uid, 'state' => 1, 'uniacid' => $_W['uniacid']));
        }
        if ($curType == 2) {
            $data = pdo_getall('yzcyk_sun_order', array('user_id' => $uid, 'uniacid' => $_W['uniacid']));
        }
        if ($curType == 3) {
            $data = pdo_getall('yzcyk_sun_order', array('user_id' => $uid, 'state' => 4, 'uniacid' => $_W['uniacid']));
        }
        foreach ($data as $k => $v) {
            $data[$k]['good_money'] = rtrim($v['good_money'], ',');
            $data[$k]['good_name'] = rtrim($v['good_name'], ',');
            $data[$k]['good_img'] = rtrim($v['good_img'], ',');
            $data[$k]['good_spec'] = rtrim($v['good_spec'], ',');
            $data[$k]['good_num'] = rtrim($v['good_num'], ',');
        }

        foreach ($data as $k => $v) {
            $data[$k]['good_money'] = explode(',', $v['good_money']);
            $data[$k]['good_name'] = explode(',', $v['good_name']);
            $data[$k]['good_img'] = explode(',', $v['good_img']);
            $data[$k]['good_spec'] = explode(',', $v['good_spec']);
            $data[$k]['good_num'] = explode(',', $v['good_num']);
        }
        return $this->result(0, '', $data);
    }

//  //查看订单详情
    public function doPageOrderDetails()
    {
        global $_GPC, $_W;
        $uid = $_GPC['openid'];
        $id = $_GPC['id'];
        $data = pdo_getall('yzcyk_sun_order', array('id' => $id, 'user_id' => $uid, 'uniacid' => $_W['uniacid']));
        foreach ($data as $k => $v) {
            $data[$k]['good_money'] = rtrim($v['good_money'], ',');
            $data[$k]['good_name'] = rtrim($v['good_name'], ',');
            $data[$k]['good_img'] = rtrim($v['good_img'], ',');
            $data[$k]['good_spec'] = rtrim($v['good_spec'], ',');
            $data[$k]['good_num'] = rtrim($v['good_num'], ',');
        }
        foreach ($data as $k => $v) {
            $data[$k]['good_money'] = explode(',', $v['good_money']);
            $data[$k]['good_name'] = explode(',', $v['good_name']);
            $data[$k]['good_img'] = explode(',', $v['good_img']);
            $data[$k]['good_spec'] = explode(',', $v['good_spec']);
            $data[$k]['good_num'] = explode(',', $v['good_num']);
            $data[$k]['time'] = date('Y-m-d H:i:s', $v['time']);
        }
        return $this->result(0, '', $data);
    }

    //获取集卡活动信息
    public function doPageGetActive()
    {
        global $_GPC, $_W;
        $id = $_GPC['id'];
        $jkopen = pdo_get('yzcyk_sun_system', ['uniacid' => $_W['uniacid']]);
        $data = pdo_getall('yzcyk_sun_active', array('uniacid' => $_W['uniacid'], 'status' => 1, 'id' => $id));
        foreach ($data as $k => $v) {
            $data[$k]['antime'] = strtotime($v['antime']) * 1000;
        }
        return $this->result(0, '', $data);
    }

    //显示在首页的集卡活动
    Public function doPageGetActiveIndex()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_active', array('uniacid' => $_W['uniacid'], 'status' => 1, 'showindex' => 1));
        foreach ($data as $k => $v) {
            $data[$k]['antime'] = strtotime($v['antime']) * 1000;
            $data[$k]['clock'] = '';
        }
        return $this->result(0, '', $data);
    }


    //获取最新集卡列表
    public function doPageactiveList()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_active', array('uniacid' => $_W['uniacid']), '', '', 'createtime DESC');
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        foreach ($data as $k => $v) {
            $store_name = pdo_get('yzcyk_sun_store_active', array('user_id' => $v['user_id']));
            if ($data[$k]['user_id'] != '') {
                $data[$k]['store_name'] = $store_name['store_name'];
                $data[$k]['tel'] = $store_name['tel'];
                $data[$k]['address'] = $store_name['address'];
            } else {
                $data[$k]['store_name'] = $system['pt_name'];
                $data[$k]['tel'] = $system['tel'];
                $data[$k]['address'] = $system['address'];
            }
        }
        return $this->result(0, '', $data);
    }

    //获取最热集卡列表
    public function doPageactiveListHot()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_active', array('uniacid' => $_W['uniacid']), '', '', 'part_num DESC');
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        foreach ($data as $k => $v) {
            $store_name = pdo_get('yzcyk_sun_store_active', array('user_id' => $v['user_id']));
            if ($data[$k]['user_id'] != '') {
                $data[$k]['store_name'] = $store_name['store_name'];
                $data[$k]['tel'] = $store_name['tel'];
                $data[$k]['address'] = $store_name['address'];
            } else {
                $data[$k]['store_name'] = $system['pt_name'];
                $data[$k]['tel'] = $system['tel'];
                $data[$k]['address'] = $system['address'];
            }
        }
        return $this->result(0, '', $data);
    }

    //分享得次数
    public function doPageShareGetNum()
    {
        global $_GPC, $_W;
        $uid = $_GPC['uid'];
        $pid = $_GPC['id'];
        $data = pdo_getall('yzcyk_sun_user_active', array('uid' => $uid, 'active_id' => $pid));
        $numData = pdo_get('yzcyk_sun_active', array('uniacid' => $_W['uniacid'], 'id' => $pid));
        $num = $numData['share_plus'];
        foreach ($data as $k => $v) {
            $n = array(
                'jikanum' => $data[$k]['jikanum'] + $num,
            );
            $res = pdo_update('yzcyk_sun_user_active', $n, array('uid' => $uid, 'active_id' => $pid));
        }
//      $res = pdo_update('yzcyk_sun_user_active',array('uid'=>$uid));
        return $this->result(0, '', $res);
    }

    //获取可抽奖的图片
    public function doPageGiftData()
    {
        global $_GPC, $_W;
        $pid = $_GPC['id'];
        $uid = $_GPC['uid'];
        $gift = pdo_getall('yzcyk_sun_gift', array('pid' => $pid));
        $userActive = pdo_getall('yzcyk_sun_user_active', array('uid' => $uid, 'active_id' => $pid));
        foreach ($gift as $k => $v) {
            foreach ($userActive as $kk => $vv) {
                if ($vv['kapian_id'] == $v['id']) {
                    $gift[$k]['num'] = $vv['num'];
                    $gift[$k]['uid'] = $vv['uid'];
                }
            }
        }
        return $this->result(0, '', $gift);
    }

    //抽满卡片之后
    public function doPageLuck()
    {
        global $_GPC;
        $userData = pdo_getall('yzcyk_sun_user_active', array('uid' => $_GPC['uid'], 'active_id' => $_GPC['id']));
        return $this->result(0, '', $userData);
    }

    //每日访问小程序增加抽奖次数
    public function doPageautoNum()
    {
        global $_GPC;
        $data = pdo_getall('yzcyk_sun_user_active', array('uid' => $_GPC['openid']));
        foreach ($data as $k => $v) {
            $n = array(
                'jikanum' => $v['jikanum'] + 5,
            );
            pdo_update('yzcyk_sun_user_active', $n, array('uid' => $_GPC['openid']));
        }
    }

    //获取剩余抽奖次数
    public function doPagejikaNum()
    {
        global $_GPC, $_W;
        //用户的剩余抽奖次数
        $data = pdo_get('yzcyk_sun_user_active', array('uid' => $_GPC['uid'], 'active_id' => $_GPC['id']));
        if ($data) {
            return $this->result(0, '', $data['jikanum']);
        } else {
            $num = pdo_get('yzcyk_sun_active', array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
            $data = $num;
            return $this->result(0, '', $data['num']);
        }

    }

    //执行抽奖
    public function doPageGetGift()
    {
        global $_GPC, $_W;
        $uid = $_GPC['uid'];
        $pid = $_GPC['pid'];
        $req_timestamp  = $_GPC['timestamp'];
        $current_timestamp = time();
        $t = $_GPC['t'];
        $key = 'alsjdlqkwjlke123654!@#!@81903890';
        $my_t = base64_encode($req_timestamp . '???' . $key);
        if ($current_timestamp - 10 > ($req_timestamp/1000)){
            return $this->result(1, '请勿重复请求！', null);
        }
        if ($my_t !== $t)  return $this->result(1, '非法请求！', null);
        $num = pdo_get('yzcyk_sun_active', array('id' => $pid, 'uniacid' => $_W['uniacid']));
        //begin
        $user_actvie_info = pdo_get('yzcyk_sun_user_active', array('uniacid' => $_W['uniacid'], 'uid' => $uid));
        if (! empty($user_actvie_info)) {
            if ($user_actvie_info['jikanum'] <= 0 || $num['num'] <= 0) return $this->result(1, '没有次数了！', null);
        }
        //end


        $gift = pdo_getall('yzcyk_sun_gift', array('pid' => $pid));//获取对应活动的集卡图片；
        foreach ($gift as $k => $v) {
            $arr[$v['id']] = $v['rate'];
        }
        $cid = $this->get_rand($arr); //根据概率获取奖项id
        $ckapian = pdo_get('yzcyk_sun_gift', array('id' => $cid, 'uniacid' => $_W['uniacid']));
        //根据获得的卡片存入数据表
        $userGife = array(
            'uniacid' => $_W['uniacid'],
            'uid' => $uid,
            'num' => 1,
            'img' => $ckapian['thumb'],
            'jikanum' => $num['num'],
            'active_id' => $pid,
            'kapian_id' => $cid,
        );

        $userActive = pdo_get('yzcyk_sun_user_active', array('uniacid' => $_W['uniacid'], 'kapian_id' => $cid, 'uid' => $uid));
        if (!$userActive) {
            $res = pdo_insert('yzcyk_sun_user_active', $userGife);
            $userActive = pdo_get('yzcyk_sun_user_active', $userGife);
        } else {
            $data = array(
                'num' => $userActive['num'] + 1,
            );
            $res = pdo_update('yzcyk_sun_user_active', $data, array('kapian_id' => $cid));
        }
        $jakanum = pdo_get('yzcyk_sun_user_active', array('uid' => $uid, 'active_id' => $pid));
        $n = array(
            'jikanum' => $jakanum['jikanum'] - 1,
        );
        pdo_update('yzcyk_sun_user_active', $n, array('uid' => $uid, 'active_id' => $pid));
        $numdata = pdo_getall('yzcyk_sun_user_active', array('uniacid' => $_W['uniacid'], 'active_id' => $pid));
        if (!$numdata) {
            $numdata = [];
        }
        $a = [];
        foreach ($numdata as $k => $v) {
            $a[$v['uid']] = $v;
        }
        $partnum = count($a);
        $part = array(
            'part_num' => $num['new_partnum'] + $partnum,
        );
        pdo_update('yzcyk_sun_active', $part, array('id' => $pid));
        return $this->result(0, '', $ckapian);
    }

    //概率计算
    public function get_rand($proArr)
    {
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //  echo $proSum;
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            //	echo $randNum.'---'.$proCur."----".$key."<br>";
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);

        return $result;
    }

    //提交集卡订单
    public function doPagejikaOrder()
    {
        global $_GPC, $_W;
        $data = array(
            'uniacid' => $_W['uniacid'],
            'pid' => $_GPC['id'],
            'uid' => $_GPC['uid'],
            'createtime' => time(),
            'status' => 1,
            'consignee' => $_GPC['consignee'],
            'tel' => $_GPC['tel'],
            'note' => $_GPC['msg']
        );
        $res = pdo_insert('yzcyk_sun_gift_order', $data);
        return $this->result(0, '', $res);
    }

    //集卡订单
    public function doPagegiftOrder()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_gift_order', array('pid' => $_GPC['id'], 'uid' => $_GPC['uid']));
        return $this->result(0, '', $data);
    }

    //我的集卡奖品
    public function doPagePrizegood()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_gift_order', array('uid' => $_GPC['uid']));
        foreach ($data as $k => $v) {
            $actives = pdo_fetch("SELECT * FROM " . tablename('yzcyk_sun_active') . " WHERE id = :id", array(':id' => $v['pid']));
            $data[$k]['title'] = $actives['title'];
            $data[$k]['thumb'] = $actives['thumb'];
        }
        return $this->result(0, '', $data);
    }

    /*
     * 提交订单
     *
     */
    public function doPagePayCart()
    {
        global $_GPC;
        $crid = explode(',', rtrim($_GPC['id'], ','));
      /*  $payData = [];
        foreach ($crid as $k => $v) {
            $payData[] = pdo_get('yzcyk_sun_shop_car', ['id' => $v]);
        }*/
        $payData=pdo_getall('yzcyk_sun_shop_car',array('id in'=>$crid));
        return $this->result(0, '', $payData);
    }

    //获取商家入驻的入驻期限
    public function doPageStoreIn()
    {
        global $_W, $_GPC;
        $data = pdo_getall('yzcyk_sun_storein', array('uniacid' => $_W['uniacid']));

        foreach ($data as $k => $v) {
            static $typetime = [];
            if ($data[$k]['type'] == 1) {
                $typetime[] = '一周' . '/' . '￥' . $v['money'];
            }
            if ($data[$k]['type'] == 2) {
                $typetime[] = '一个月' . '/' . '￥' . $v['money'];
            }
            if ($data[$k]['type'] == 3) {
                $typetime[] = '三个月' . '/' . '￥' . $v['money'];
            }
            if ($data[$k]['type'] == 4) {
                $typetime[] = '半年' . '/' . '￥' . $v['money'];
            }
            if ($data[$k]['type'] == 5) {
                $typetime[] = '一年' . '/' . '￥' . $v['money'];
            }
        }
        return $this->result(0, '', $typetime);
    }

    //添加商家入驻
    public function doPageAddStore()
    {
        global $_W, $_GPC;
        $time = 24 * 60 * 60 * 7;//一周
        $time1 = 24 * 30 * 60 * 60;//一个月
        $time2 = 24 * 91 * 60 * 60;//三个月
        $time3 = 24 * 182 * 60 * 60;//半年
        $time4 = 24 * 365 * 60 * 60;//一年

        $data = array(
            'user_id' => $_GPC['user_id'],
            'store_name' => $_GPC['store_name'],
            'tel' => $_GPC['tel'],
            'address' => $_GPC['address'],
            'uniacid' => $_W['uniacid'],
            'time_over' => 2,
            'rz_time' => time(),
            'state' => 2,
        );
        $time_type = explode('￥', $_GPC['time_type']);
        if ($time_type[0] == '一周/') {
            $data['time_type'] = 1;
            $data['dq_time'] = time() + $time;
        };
        if ($time_type[0] == '一个月/') {
            $data['time_type'] = 2;
            $data['dq_time'] = time() + $time1;
        };
        if ($time_type[0] == '三个月/') {
            $data['time_type'] = 3;
            $data['dq_time'] = time() + $time2;
        };
        if ($time_type[0] == '半年/') {
            $data['time_type'] = 4;
            $data['dq_time'] = time() + $time3;
        };
        if ($time_type[0] == '一年/') {
            $data['time_type'] = 5;
            $data['dq_time'] = time() + $time4;
        };
        if ($_GPC['active_type'] == '集卡') {
            $data['active_type'] = 1;
        }
        $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));

        $res = pdo_insert('yzcyk_sun_store_active', $data);
        return $this->result(0, '', $res);
    }

    //查询该商家是否已经入驻
    public function doPageIsStore()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $data = pdo_getall('yzcyk_sun_store_active', array('user_id' => $openid, 'time_over' => 2, 'state' => 2));
        return $this->result(0, '', $data);
    }

    //添加商家入驻活动
    public function doPageAddActive()
    {
        global $_GPC, $_W;
        $data = array(
            'uniacid' => $_W['uniacid'],
            'title' => $_GPC['title'],
            'subtitle' => $_GPC['subtitle'],
            'content' => $_GPC['content'],
            'status' => 0,
            'thumb' => $_GPC['thumb'],
            'num' => $_GPC['num'],
            'sharenum' => $_GPC['sharenum'],
            'part_num' => 0,
            'share_plus' => $_GPC['share_plus'],
            'new_partnum' => 0,
            'storeinfo' => $_GPC['storeinfo'],
            'user_id' => $_GPC['user_id'],
            'createtime' => time(),
        );

        $year = date('Y');
        $astime = $year . '-' . $_GPC['astime'] . ':00';
        $antime = $year . '-' . $_GPC['antime'] . ':00';
        $data['astime'] = $astime;
        $data['antime'] = $antime;
        //strtotime
        $astime = strtotime($astime);
        $antime = strtotime($antime);
        $time = 24 * 60 * 60 * 7;//一周
        $time1 = 24 * 30 * 60 * 60;//一个月
        $time2 = 24 * 91 * 60 * 60;//三个月
        $time3 = 24 * 182 * 60 * 60;//半年
        $time4 = 24 * 365 * 60 * 60;//一年
//         $aaaa = $antime -  $astime;
        $datetime = pdo_get('yzcyk_sun_store_active', array('user_id' => $_GPC['user_id'], 'active_type' => 1));
        if ($datetime['time_type'] == 1) {
            if ($antime - $astime > $time) {
                $res = 222;
            } else {
                if ($antime < time()) {
                    $res = 22221;
                } else {
                    $res = pdo_insert('yzcyk_sun_active', $data);
                }

            }
        } elseif ($datetime['time_type'] == 2) {
            if ($antime - $astime > $time1) {
                $res = 222;
            } else {
                if ($antime < time()) {
                    $res = 222;
                } else {
                    $res = pdo_insert('yzcyk_sun_active', $data);
                }
            }
        } elseif ($datetime['time_type'] == 3) {
            if ($antime - $astime > $time2) {
                $res = 222;
            } else {
                if ($antime < time()) {
                    $res = 222;
                } else {
                    $res = pdo_insert('yzcyk_sun_active', $data);
                }
            }
        } elseif ($datetime['time_type'] == 4) {
            if ($antime - $astime > $time3) {
                $res = 222;
            } else {
                if ($antime < time()) {
                    $res = 222;
                } else {
                    $res = pdo_insert('yzcyk_sun_active', $data);
                }
            }
        } elseif ($datetime['time_type'] == 5) {
            if ($antime - $astime > $time4) {
                $res = 222;
            } else {
                if ($antime < time()) {
                    $res = 222;
                } else {
                    $res = pdo_insert('yzcyk_sun_active', $data);
                }
            }
        } else {
            $res = '系统错误，请联系管理员！';
        }
        return $this->result(0, '', $res);
    }

    //获取用户最新添加的活动
    public function doPageGetAddNowActive()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_active', array('uniacid' => $_W['uniacid'], 'user_id' => $_GPC['user_id']), '', '', 'createtime DESC');
        return $this->result(0, '', $data[0]['id']);
    }

    //用户添加卡片
    public function doPageAddGift()
    {
        global $_GPC, $_W;
        if ($_GPC['rate'] != '') {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb'],
                'thumb2' => $_GPC['thumb'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data);
        }
        if ($_GPC['rate1'] != '') {
            $data1 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb1'],
                'thumb2' => $_GPC['thumb1'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate1'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data1);
        }

        if ($_GPC['rate2'] != '') {
            $data2 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb2'],
                'thumb2' => $_GPC['thumb2'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate2'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data2);
        }

        if ($_GPC['rate3'] != '') {
            $data3 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb3'],
                'thumb2' => $_GPC['thumb3'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate3'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data3);
        }

        if ($_GPC['rate4'] != '') {
            $data4 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb4'],
                'thumb2' => $_GPC['thumb4'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate4'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data4);
        }

        if ($_GPC['rate5'] != '') {
            $data5 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb5'],
                'thumb2' => $_GPC['thumb5'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate5'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data5);
        }

        if ($_GPC['rate6'] != '') {
            $data6 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb6'],
                'thumb2' => $_GPC['thumb6'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate6'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data6);
        }

        if ($_GPC['rate7'] != '') {
            $data7 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb7'],
                'thumb2' => $_GPC['thumb7'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate7'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data7);
        }

        if ($_GPC['rate8'] != '') {
            $data8 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb8'],
                'thumb2' => $_GPC['thumb8'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate8'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data8);
        }

        if ($_GPC['rate9'] != '') {
            $data9 = array(
                'uniacid' => $_W['uniacid'],
                'createtime' => time(),
                'thumb' => $_GPC['thumb9'],
                'thumb2' => $_GPC['thumb9'],
                'pid' => $_GPC['pid'],
                'rate' => $_GPC['rate9'],
                'title' => '（前台用户添加）',
            );
            pdo_insert('yzcyk_sun_gift', $data9);
        }
    }

    //获取前台用户的集卡活动信息(审核中。。。)
    public function doPageGetUserActive()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_active', array('user_id' => $_GPC['user_id'], 'uniacid' => $_W['uniacid'], 'status' => 0));
        return $this->result(0, '', $data);
    }

    //获取前台用户的集卡活动信息(进行中。。。)
    public function doPageGetUserActived()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_active', array('user_id' => $_GPC['user_id'], 'uniacid' => $_W['uniacid'], 'status' => 1));
        return $this->result(0, '', $data);
    }

    //获取前台用户的集卡活动信息(已结束。。。)
    public function doPageGetUserActivend()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_active', array('user_id' => $_GPC['user_id'], 'uniacid' => $_W['uniacid']));
        foreach ($data as $k => $v) {
            if (time() < strtotime($v['antime'])) {
                unset($data[$k]);
            }
        }
        return $this->result(0, '', $data);
    }

    //检查商家入驻是否到期
    public function doPageStoreActivedq()
    {
        global $_W, $_GPC;
        $data = pdo_get('yzcyk_sun_store_active', array('user_id' => $_GPC['user_id']));
        if (time() > $data['dq_time']) {
            $res = $data['id'];
        } else {
            $res = 1;
        }
        return $this->result(0, '', $res);

    }

    //修改已过期商家
    public function doPagedelStoreActive()
    {
        global $_GPC, $_W;
        $data = array(
            'time_over' => 1,
        );
        $res = pdo_update('yzcyk_sun_store_active', $data, array('id' => $_GPC['id']));
        return $this->result(0, '', $res);
    }

    //查询用户是否添加活动后返回重新添加
    public function doPageSelectAddActive()
    {
        global $_GPC, $_W;
        $active = pdo_getall('yzcyk_sun_active', array('uniacid' => $_W['uniacid'], 'user_id' => $_GPC['user_id']), '', '', 'createtime DESC');
        $pid = $active[0]['id'];
        $res = pdo_get('yzcyk_sun_gift', array('uniacid' => $_W['uniacid'], 'pid' => $pid));
        if ($active) {
            if ($res == 'false') {
                $data = 0;
            } else {
                $data = 1;
            }
        } else {
            $data = 1;
        }
        return $this->result(0, '', $data);
    }

    //商家集卡活动集齐订单
    public function doPagejiqiOrder()
    {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        $sql = ' SELECT * FROM ' . tablename('yzcyk_sun_active') . ' a ' . ' JOIN ' . tablename('yzcyk_sun_gift_order') . ' o ' . ' ON ' . ' a.id=o.pid' . ' WHERE ' . ' a.user_id=' . "'$openid'";
        $giftorder = pdo_fetchall($sql);

        return $this->result(0, '', $giftorder);

    }

    //获取砍价商品列表
    public function doPageBargainList()
    {
        global $_GPC, $_W;
        $bargain = pdo_getall('yzcyk_sun_bargain', array('uniacid' => $_W['uniacid'], 'status' => 1));
        foreach ($bargain as $k => $v) {
            //判断该活动是否已经结束
            $date = time();
            $bargain[$k]['endtimes'] = strtotime($v['endtime']);
            if ($date - $bargain[$k]['endtimes'] <= 0) {
                $bargain[$k]['state'] = 1;//已结束
            } else {
                $bargain[$k]['state'] = 2;//未结束
            }
        }
        return $this->result(0, '', $bargain);
    }

    //获取砍价商品首页
    public function doPageGetBargainIndex()
    {
        global $_GPC, $_W;
        $bargain = pdo_getall('yzcyk_sun_bargain', array('uniacid' => $_W['uniacid'], 'status' => 1,'showindex'=>1));
        foreach ($bargain as $k => $v) {
            $bargain[$k]['endtime'] = strtotime($v['endtime']) * 1000;
            $bargain[$k]['clock'] = '';
            $bargain[$k]['partnum'] = count(pdo_getall('yzcyk_sun_user_bargain', array('uniacid' => $_W['uniacid'], 'gid' => $v['id'], 'mch_id' => 0)));
        }

        return $this->result(0, '', $bargain);
    }

    //获取砍价商品详情
    public function doPageBargainDetails()
    {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $bargain = pdo_get('yzcyk_sun_bargain', array('uniacid' => $_W['uniacid'], 'id' => $id));
        return $this->result(0, '', $bargain);
    }

    //用户砍价
    public function doPageNowBargain()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $id = $_GPC['id'];
        if(!$id||$id=='undefined')exit;
        $bargainDetails = pdo_get('yzcyk_sun_goods', array('uniacid' => $_W['uniacid'], 'id' => $id));
        //获取有没有砍主
        $bargain = pdo_get('yzcyk_sun_user_bargain', array('uniacid' => $_W['uniacid'], 'mch_id' => 0, 'gid' => $id, 'openid' => $openid));
        if($bargain){
            return $this->result(1, '您已经砍过了');
            exit;
        }

        //砍价百分比
        $kanjia_percent=$bargainDetails['$bargainDetails']?$bargainDetails['$bargainDetails']:20;
        //砍价金额
        $kanjias=($bargainDetails['goods_price']-$bargainDetails['kanjia_price'])*$kanjia_percent*0.01;
        $kanjias=sprintf("%.2f",$kanjias);
        //成为砍主
        $data['price_ago'] = $bargainDetails['goods_price'];
        $data['kanjias']=$kanjias;
        $data['prices']=$bargainDetails['goods_price']- $data['kanjias'];
        $data['prices_current']=$data['prices'];
        $data['kanjias_current']=$kanjias;
        $data['lowest_price']=$bargainDetails['kanjia_price'];
        $data['gid'] = $id;
        $data['openid'] = $openid;
        $data['mch_id'] = 0;//为砍主
        $data['status'] = 1;
        $data['uniacid'] = $_W['uniacid'];
        $data['add_time'] = time();
        $data['uniacid'] = $_W['uniacid'];
        pdo_insert('yzcyk_sun_user_bargain', $data);
        echo json_encode($kanjias);
    }

    //获取自己的砍价信息
    public function doPageMyBargain()
    {
        global $_W, $_GPC;
        $data = pdo_get('yzcyk_sun_user_bargain', array('openid' => $_GPC['openid'], 'mch_id' => 0, 'gid' => $_GPC['id'], 'uniacid' => $_W['uniacid']));
        //砍价后比例
        $data['weight']=sprintf("%.2f",floatval($data['prices_current'])/floatval($data['price_ago']));
        if($data['weight']>0.9){
            $data['weight']=0.9;
        }
        return $this->result(0, '', $data);
    }

    //获取已有多少人参与砍价活动
    public function doPagePartNum()
    {
        global $_W, $_GPC;
//        $sql = ' SELECT * FROM ' . tablename('yzcyk_sun_user_bargain') . ' ub' . ' JOIN ' . tablename('yzcyk_sun_user') . ' u' . ' ON ' . ' ub.openid=u.openid ' . ' WHERE' . ' ub.gid=' . $_GPC['id'] . ' AND ' . ' ub.mch_id=0 ' . ' AND' . ' u.uniacid=' . $_W['uniacid'] . ' AND '  .  ' ub.uniacid=' . $_W['uniacid'];
//        $user = pdo_fetchall($sql);
        $num = pdo_getall('yzcyk_sun_user_bargain', array('uniacid' => $_W['uniacid'], 'gid' => $_GPC['id'], 'mch_id' => 0));
        return $this->result(0, '', $num);
    }

    //帮助好友五位头像信息
    public function doPageFriendsImg()
    {
        global $_W, $_GPC;
        //先获取砍主
        $master = pdo_get('yzcyk_sun_user_bargain', array('openid' => $_GPC['openid'], 'mch_id' => 0, 'gid' => $_GPC['id'], 'uniacid' => $_W['uniacid']));
        //好友的头像
        if($master){
            $sql = ' SELECT * FROM ' . tablename('yzcyk_sun_user_bargain') . ' ub' . ' JOIN ' . tablename('yzcyk_sun_user') . ' u' . ' ON' . ' ub.openid=u.openid' . ' WHERE' . ' ub.mch_id=' . $master['id'] . ' AND' . ' ub.gid=' . $_GPC['id'] . ' AND ' . 'ub.uniacid=' . $_W['uniacid'];
            $friends = pdo_fetchall($sql);
        }else{
            $friends=array();
        }
        $friends[] = pdo_get('yzcyk_sun_user', array('uniacid' => $_W['uniacid'], 'openid' => $_GPC['openid']));
        return $this->result(0, '', $friends);
    }

    //好友点击帮助进入页面获取对应商品
    public function doPagehelpBargain()
    {
        global $_GPC, $_W;
        $bargain = pdo_get('yzcyk_sun_goods', array('id' => $_GPC['id'], 'uniacid' => $_W['uniacid']));
        $bargain['lb_img']=explode(',', $bargain['lb_imgs'])[0];
        //查询砍主 当前价格
        $master = pdo_get('yzcyk_sun_user_bargain', array('mch_id' => '0', 'uniacid' => $_W['uniacid'], 'gid' => $_GPC['id'], 'openid' => $_GPC['openid']));
        $bargain['prices_current']=$master['prices_current'];
        return $this->result(0, '', $bargain);
    }

    //查询自己是否砍过价
    public function doPageiskanjia()
    {
        global $_W, $_GPC;
        $myInfo = pdo_get('yzcyk_sun_user_bargain', array('gid' => $_GPC['id'], 'mch_id' => 0, 'openid' => $_GPC['openid'], 'uniacid' => $_W['uniacid']));
        return $this->result(0, '', $myInfo);
    }

    //查询砍主
    public function doPageKanZhu()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $userInfo = pdo_get('yzcyk_sun_user', array('openid' => $openid, 'uniacid' => $_W['uniacid']));
        return $this->result(0, '', $userInfo);
    }

    //查询帮忙砍价的人
    public function doPageFriends()
    {
        global $_W, $_GPC;
        $openid = $_GPC['openid'];
        //查询砍主
        $master = pdo_get('yzcyk_sun_user_bargain', array('mch_id' => '0', 'gid' => $_GPC['id'], 'openid' => $_GPC['openid']));
        $sql = ' SELECT * FROM ' . tablename('yzcyk_sun_user_bargain') . ' a ' . ' JOIN ' . tablename('yzcyk_sun_user') . ' b ' . ' ON ' . ' a.openid=b.openid' . ' WHERE ' . ' a.gid=' . $_GPC['id'] . ' AND ' . ' a.uniacid=' . $_W['uniacid'] . ' AND ' . ' b.uniacid= ' . $_W['uniacid'] . ' AND ' . ' a.mch_id=' . $master['id'];
        $user = pdo_fetchall($sql);
        foreach ($user as $k => $v) {
            if ($user[$k]['openid'] == $openid) unset($user[$k]);
        }
        return $this->result(0, '', $user);
    }

    //好友帮忙砍价
    public function doPageDoHelpBargain()
    {
        global $_GPC, $_W;
        //获取商品
        $bargainDetails = pdo_get('yzcyk_sun_goods', array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
        //先查询砍主
        $master = pdo_get('yzcyk_sun_user_bargain', array('mch_id' => '0', 'gid' => $_GPC['id'], 'openid' => $_GPC['userid']));
        //查看是否帮看砍过
         $bargain=pdo_get('yzcyk_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['openid'],'mch_id'=>$master['id']));
         if($bargain){
         	 return $this->result(1, '已经砍过了');
             exit;
         }
        if(empty($_GPC['openid'])||strlen($_GPC['openid'])!=28){
        	return $this->result(1,'用户错误');
            exit;
        }
        //获取砍价的百分比 砍价金额
        $person = $bargainDetails['kanjia_percent'] * 0.01;
        $price = ($master['prices_current'] - $bargainDetails['kanjia_price']) * $person;
        $price= sprintf("%.2f",$price); 
        $data['price_ago'] = $master['prices_current'];  
        $data['kanjias']=$price;
        $data['prices']=$master['prices_current']- $data['kanjias'];
        $data['gid'] = $_GPC['id'];
        $data['openid'] = $_GPC['openid'];
        $data['mch_id'] = $master['id'];//为砍主
        $data['status'] = 1;
        $data['uniacid'] = $_W['uniacid'];
        $data['add_time'] = time();
        $data['uniacid'] = $_W['uniacid'];
        pdo_insert('yzcyk_sun_user_bargain', $data);
        //修改砍主的信息
        $datas['prices_current'] = $master['prices_current']- $data['kanjias'];;
        $datas['kanjias_current'] = $master['kanjias_current'] + $price;
        pdo_update('yzcyk_sun_user_bargain', $datas, array('id' => $master['id']));
        return $this->result(0, '', $price);
    }

    //查询是否已经帮忙砍价过
    public function doPageIsHelp()
    {
        global $_GPC, $_W;
        $openid = $_GPC['userid'];
        $kanzhu = pdo_get('yzcyk_sun_user_bargain', array('openid' => $_GPC['userid'], 'gid' => $_GPC['id'], 'mch_id' => 0));
        $helpInfo = pdo_getall('yzcyk_sun_user_bargain', array('openid' => $_GPC['openid'], 'mch_id' => $kanzhu['id']));

        return $this->result(0, '', $helpInfo);
    }

    //获取是否已经是最低价
    public function doPagezuidijia()
    {
        global $_GPC, $_W;
        //获取商品的最低价
        $goods = pdo_get('yzcyk_sun_goods', array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
        //获取当前的最低价
        $price = pdo_get('yzcyk_sun_user_bargain', array('uniacid' => $_W['uniacid'], 'gid' => $_GPC['id'], 'openid' => $_GPC['openid'], 'mch_id' => 0));
        if ($goods['kanjia_price'] >= $price['prices_current']) {
            $data = array(
                'prices_current' => $goods['kanjia_price']
            );
            $res = pdo_update('yzcyk_sun_user_bargain', $data, array('id' => $price['id']));
        } else {
            $res = '222';
        }
        echo json_encode($res);

    }

    //查询砍价活动是否已经到期
    public function doPageExpire()
    {
        global $_GPC, $_W;
        $goodsInfo = pdo_get('yzcyk_sun_goods', array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
        //将当前商品转化为时间戳
        $times = $goodsInfo['end_time'];
        $nowtime = time();
        if ($nowtime > $times) {
            $data = 0;
        } else {
            $data = 1;
        }
        return $this->result(0, '', $data);
    }
    //查询砍价商品信息
    public function doPagegetBargainGoodsInfo(){
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $sql = ' SELECT b.*,ub.prices_current FROM ' . tablename('yzcyk_sun_goods') . ' b ' . ' JOIN ' . tablename('yzcyk_sun_user_bargain') . ' ub' . ' ON ' . ' b.id=ub.gid' . ' WHERE ' . ' b.id=' . $_GPC['id'] . ' AND ' . ' ub.openid=' . "'$openid'" . ' AND' . ' ub.uniacid=' . $_W['uniacid'] . ' AND' . ' ub.mch_id=0';
        $info = pdo_fetch($sql);
        $info['lb_img']=explode(',', $info['lb_imgs'])[0];
        return $this->result(0, '', $info);
    }

    //查询对应的购买商品
    public function doPageBuyGoodsInfo()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $sql = ' SELECT * FROM ' . tablename('yzcyk_sun_bargain') . ' b ' . ' JOIN ' . tablename('yzcyk_sun_user_bargain') . ' ub' . ' ON ' . ' b.id=ub.gid' . ' WHERE ' . ' b.id=' . $_GPC['id'] . ' AND ' . ' ub.openid=' . "'$openid'" . ' AND' . ' ub.uniacid=' . $_W['uniacid'] . ' AND' . ' ub.mch_id=0';
        $info = pdo_fetch($sql);
        return $this->result(0, '', $info);
    }

    //拼主 拼客 生成拼团商品订单
    public function doPagesetGroupOrder(){
        global $_W, $_GPC;
        $cid=$_GPC['cid'];
        $_GPC['name']=$_GPC['name']=='undefined'?'':$_GPC['name'];
        $_GPC['phone']=$_GPC['phone']=='undefined'?'':$_GPC['phone'];
        $_GPC['province']=$_GPC['province']=='undefined'?'':$_GPC['province'];
        $_GPC['city']=$_GPC['city']=='undefined'?'':$_GPC['city'];
        $_GPC['zip']=$_GPC['zip']=='undefined'?'':$_GPC['zip'];
        $_GPC['address']=$_GPC['address']=='undefined'?'':$_GPC['address'];
        $_GPC['postalcode']=$_GPC['postalcode']=='undefined'?'':$_GPC['postalcode'];
        $data=array(
            'uniacid'=>$_W['uniacid'],
            'uid'=>$_GPC['uid'],
            'cid'=>$cid,
            'crid'=>$_GPC['gid'],
            'orderformid'=>date("YmdHis") .rand(11111, 99999),//订单号
            'order_lid'=>4,
            'pin_buy_type'=>1,
            'pin_mch_id'=>0,
            'order_amount'=>$_GPC['order_amount'],
            'good_total_price'=>$_GPC['good_total_price'],
            'good_total_num'=>$_GPC['good_total_num'],
            'sincetype'=>$_GPC['sincetype']+1,
            'distribution'=>$_GPC['distribution'],
            'coupon_id'=>$_GPC['coupon_id'],
            'coupon_price'=>$_GPC['coupon_price'],
            'name'=>$_GPC['name']?$_GPC['name']:'',
            'phone'=>$_GPC['phone']?$_GPC['phone']:'',
            'province'=>$_GPC['province']?$_GPC['province']:'',
            'city'=>$_GPC['city']?$_GPC['city']:'',
            'zip'=>$_GPC['zip']?$_GPC['zip']:'',
            'address'=>$_GPC['address']?$_GPC['address']:'',
            'postalcode'=>$_GPC['postalcode']?$_GPC['postalcode']:'',
            'ziti_phone'=>$_GPC['ziti_phone']?$_GPC['ziti_phone']:'',
            'remark'=>$_GPC['remark']?$_GPC['remark']:'',
            'add_time'=>time(),
        );
        //拼客
        if($_GPC['pin_mch_id']&&$_GPC['order_id']){
            $data['pin_mch_id']=$_GPC['pin_mch_id'];
            $data['pin_order_id']=$_GPC['order_id'];
        }
        $goods=pdo_get('yzcyk_sun_goods',array('id'=>$_GPC['gid']));
        pdo_insert('yzcyk_sun_order',$data);
        $order_id = pdo_insertid();
        //订单详情
        $detail=array(
            'order_id'=>$order_id,
            'uniacid'=>$_W['uniacid'],
            'uid'=>$_GPC['uid'],
            'gid'=>$_GPC['gid'],
            'gname'=>$goods['goods_name'],
            'unit_price'=>$goods['pintuan_price'],
            'num'=>$_GPC['good_total_num'],
            'total_price'=>$_GPC['good_total_price'],
            'combine'=>$_GPC['spec_value'].','.$_GPC['spec_value1'],
            'spec_value'=>$_GPC['spec_value']?$_GPC['spec_value']:'',
            'spec_value1'=>$_GPC['spec_value1']?$_GPC['spec_value1']:'',
            'pic'=>$_GPC['pic'],
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_order_detail',$detail);
        echo $order_id;
    }
   //生成砍价商品订单
    public function doPagesetBargainOrder(){
        global $_W, $_GPC;
        $cid=$_GPC['cid'];
        $_GPC['name']=$_GPC['name']=='undefined'?'':$_GPC['name'];
        $_GPC['phone']=$_GPC['phone']=='undefined'?'':$_GPC['phone'];
        $_GPC['province']=$_GPC['province']=='undefined'?'':$_GPC['province'];
        $_GPC['city']=$_GPC['city']=='undefined'?'':$_GPC['city'];
        $_GPC['zip']=$_GPC['zip']=='undefined'?'':$_GPC['zip'];
        $_GPC['address']=$_GPC['address']=='undefined'?'':$_GPC['address'];
        $_GPC['postalcode']=$_GPC['postalcode']=='undefined'?'':$_GPC['postalcode'];
        $data=array(
            'uniacid'=>$_W['uniacid'],
            'uid'=>$_GPC['uid'],
            'cid'=>$cid,
            'crid'=>$_GPC['gid'],
            'orderformid'=>date("YmdHis") .rand(11111, 99999),//订单号
            'order_lid'=>5,
            'order_amount'=>$_GPC['order_amount'],
            'good_total_price'=>$_GPC['good_total_price'],
            'good_total_num'=>$_GPC['good_total_num'],
            'sincetype'=>$_GPC['sincetype']+1,
            'distribution'=>$_GPC['distribution'],
            'coupon_id'=>$_GPC['coupon_id'],
            'coupon_price'=>$_GPC['coupon_price'],
            'name'=>$_GPC['name']?$_GPC['name']:'',
            'phone'=>$_GPC['phone']?$_GPC['phone']:'',
            'province'=>$_GPC['province']?$_GPC['province']:'',
            'city'=>$_GPC['city']?$_GPC['city']:'',
            'zip'=>$_GPC['zip']?$_GPC['zip']:'',
            'address'=>$_GPC['address']?$_GPC['address']:'',
            'postalcode'=>$_GPC['postalcode']?$_GPC['postalcode']:'',
            'ziti_phone'=>$_GPC['ziti_phone']?$_GPC['ziti_phone']:'',
            'remark'=>$_GPC['remark']?$_GPC['remark']:'',
            'add_time'=>time(),
        );
        $goods=pdo_get('yzcyk_sun_goods',array('id'=>$_GPC['gid']));
        pdo_insert('yzcyk_sun_order',$data);
        $order_id = pdo_insertid();
        //订单详情
        $detail=array(
            'order_id'=>$order_id,
            'uniacid'=>$_W['uniacid'],
            'uid'=>$_GPC['uid'],
            'gid'=>$_GPC['gid'],
            'gname'=>$goods['goods_name'],
            'unit_price'=>$goods['goods_price'],
            'num'=>$_GPC['good_total_num'],
            'total_price'=>$_GPC['good_total_price'],
            'combine'=>$_GPC['spec_value'].','.$_GPC['spec_value1'],
            'spec_value'=>$_GPC['spec_value']?$_GPC['spec_value']:'',
            'spec_value1'=>$_GPC['spec_value1']?$_GPC['spec_value1']:'',
            'pic'=>$_GPC['pic'],
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_order_detail',$detail);
        //获取砍主信息更新order_id
        $bargain=pdo_get('yzcyk_sun_user_bargain',array('uniacid'=>$_W['uniacid'],'gid'=>$_GPC['gid'],'openid'=>$_GPC['uid'],'mch_id'=>0));
        pdo_update('yzcyk_sun_user_bargain',array('status'=>2,'order_id'=>$order_id),array('id'=>$bargain['id']));
        echo $order_id;
    }

    //购买砍价商品生成订单
    public function doPagebargainorder()
    {
        global $_GPC, $_W;
        $address = $_GPC['address'];
        $consignee = $_GPC['consignee'];
        $phone = $_GPC['phone'];
        $gid = $_GPC['gid'];
        $openid = $_GPC['openid'];
        $price = $_GPC['price'];
        $goods = pdo_get('yzcyk_sun_bargain', array('id' => $gid, 'uniacid' => $_W['uniacid']));
        $data = array(
            'user_id' => $openid,
            'money' => $price,
            'user_name' => $consignee,
            'address' => $address,
            'tel' => $phone,
            'time' => time(),
            'state' => 1,
            'order_num' => date("YmdHis") . rand(1111, 9999),
            'good_id' => $goods['id'],
            'good_name' => $goods['gname'],
            'good_img' => $goods['pic'],
            'good_money' => $goods['marketprice'],
            'out_trade_no' => 1,
            'uniacid' => $_W['uniacid'],
            'note' => $_GPC['note'],
        );
        $res = pdo_insert('yzcyk_sun_order', $data);
        $id = pdo_get('yzcyk_sun_order', array('user_id' => $openid, 'good_id' => $gid, 'out_trade_no' => 1, 'uniacid' => $_W['uniacid']));
        echo json_encode($id['id']);
    }

    //付款修改砍价订单状态
    public function doPageUpdateOrder()
    {
        global $_W, $_GPC;
        //获取订单信息
        $orderinfo = pdo_get('yzcyk_sun_order', array('id' => $_GPC['order_id']));
        pdo_update('yzcyk_sun_bargain', array('num -=' => 1), array('id' => $orderinfo['good_id']));
        $res = pdo_update('yzcyk_sun_order', array('state' => 2, 'pay_time' => time()), array('id' => $_GPC['order_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //查询是否已经购买过
    public function doPagebuyed()
    {
        global $_W, $_GPC;
        $data = pdo_get('yzcyk_sun_order', array('uniacid' => $_W['uniacid'], 'uid' => $_GPC['openid'], 'crid' => $_GPC['id']));
        if ($data) {
            echo '1';
        } else {
            echo '2';
        }

    }

    //获取底部自定义图标
    public function doPageTab()
    {
        global $_GPC, $_W;
        $data = pdo_get('yzcyk_sun_tab', array('uniacid' => $_W['uniacid']));
        $data=array_merge($data,array('url'=>$_W['attachurl'],'current'=>0));
        return $this->result(0, '', $data);
    }

//-------------------------拼团start--------------------------------
    public function doPageGroupsList()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_groups', array('uniacid' => $_W['uniacid']));
        foreach ($data as $k => $v) {
            $data[$k]['part_num'] = count(pdo_getall('yzcyk_sun_user_groups', array('uniacid' => $_W['uniacid'], 'gid' => $v['id'])));
        }
        return $this->result(0, '', $data);
    }

    //显示在首页的拼团
    public function doPageGetGroupsIndex(){
        global $_GPC,$_W;
        $data = pdo_getall('yzcyk_sun_groups',array('uniacid'=>$_W['uniacid'],'showindex'=>1,'status'=>1));
        foreach ($data as $k => $v) {
            $data[$k]['endtime'] = strtotime($v['endtime']) * 1000;
            $data[$k]['clock'] = '';
            $data[$k]['partnum'] = count(pdo_getall('yzcyk_sun_user_groups', array('uniacid' => $_W['uniacid'], 'gid' => $v['id'])));
        }
        return $this->result(0, '', $data);
    }
    //获取拼团详细信息
    public function doPageGroupsDetails()
    {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $data = pdo_get('yzcyk_sun_groups', array('uniacid' => $_W['uniacid'], 'id' => $id));
        $data['endtime'] = strtotime($data['endtime']) * 1000;
        $data['clock'] = '';
        return $this->result(0, '', $data);
    }

    //付款生成订单
    public function doPageGroupsOrder()
    {
        global $_GPC, $_W;
        $id = $_GPC['gid'];
        $groups = pdo_get('yzcyk_sun_groups', array('uniacid' => $_W['uniacid'], 'id' => $id));
        $data = array(
            'user_id' => $_GPC['openid'],
            'money' => $groups['shopprice'],
            'user_name' => $_GPC['consignee'],
            'address' => $_GPC['address'],
            'tel' => $_GPC['phone'],
            'time' => time(),
            'state' => 1,
            'order_num' => date("YmdHis") . rand(1111, 9999),
            'good_id' => $id,
            'good_name' => $groups['gname'],
            'good_img' => $groups['pic'],
            'good_money' => $groups['marketprice'],
            'out_trade_no' => 2,
            'uniacid' => $_W['uniacid'],
            'note' => $_GPC['note'],
            'good_num' => 1,
        );
        $res = pdo_insert('yzcyk_sun_order', $data);
        $id = pdo_get('yzcyk_sun_order', array('user_id' => $_GPC['openid'],'time'=>time(), 'good_id' => $id, 'out_trade_no' => 2, 'uniacid' => $_W['uniacid']));
        return $this->result(0, '', $id);

    }

    //付款修改拼团订单状态
    public function doPageUpdateGroupsOrder()
    {
        global $_W, $_GPC;
        //获取订单信息
        $orderinfo = pdo_get('yzcyk_sun_order', array('id' => $_GPC['order_id']));
        pdo_update('yzcyk_sun_groups', array('num -=' => 1), array('id' => $orderinfo['good_id']));
        $res = pdo_update('yzcyk_sun_order', array('state' => 2, 'pay_time' => time()), array('id' => $_GPC['order_id']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //付款成功存进数据表
    public function doPageUserGroups()
    {
        global $_GPC, $_W;
        $data = array(
            'gid' => $_GPC['gid'],
            'openid' => $_GPC['openid'],
            'order_id' => $_GPC['order_id'],
            'addtime' => time(),
            'uniacid' => $_W['uniacid'],
            'status' => 2,
            'num' => 1,
            'price' => $_GPC['price'],
            'buynum' => 1
        );
        if(!$_GPC['userid']){
            $data['mch_id'] = 0;

        }else{
            //查询团长
            $head_groups = pdo_get('yzcyk_sun_user_groups',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['userid'],'mch_id'=>0,'gid'=>$_GPC['gid']));
            $data['mch_id'] = $head_groups['id'];
        }
        $res = pdo_insert('yzcyk_sun_user_groups', $data);
        pdo_update('yzcyk_sun_user_groups', array('buynum +=' => 1), array('gid' => $_GPC['gid'],'openid'=>$_GPC['openid'],'mch_id'=>0,'uniacid'=>$_W['uniacid']));
        if ($res) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //判断该团在付款结束后是否已经满团
    public function doPageOverGroups(){
        global $_W,$_GPC;
        //查询该商品需要几人团
        $data = pdo_get('yzcyk_sun_groups',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['gid']));
        $num = $data['groups_num'];
        //查询该团已有多少人
        $groups_num = pdo_get('yzcyk_sun_user_groups',array('uniacid'=>$_W['uniacid'],'gid'=>$_GPC['gid'],'openid'=>$_GPC['openid'],'mch_id'=>0));
        if($data['groups_num']==$groups_num['buynum']){
            echo '1';
        }else{
            echo '2';
        }
    }

    //判断是否已经存在该订单
    public function doPageOrderPass(){
        global $_GPC,$_W;
        $data = pdo_get('yzcyk_sun_order',array('uniacid'=>$_W['uniacid'],'good_id'=>$_GPC['gid'],'user_id'=>$_GPC['openid'],'out_trade_no'=>2));
        if($data){
            echo '1';
        }else{
            echo '2';
        }
    }

    //判断是否购买过该商品
    public function doPageIsBuyGroups()
    {
        global $_GPC, $_W;
        $data = pdo_get('yzcyk_sun_user_groups', array('uniacid' => $_W['uniacid'], 'gid' => $_GPC['id'], 'openid' => $_GPC['openid']));
        if ($data) {
            echo '1';
        } else {
            echo '2';
        }
    }

    //获取该商品的拼团列表
    public function doPageUserGroupsList()
    {
        global $_GPC, $_W;
        $sql = ' SELECT * FROM ' . tablename('yzcyk_sun_user') . ' u' . ' JOIN ' . tablename('yzcyk_sun_user_groups') . ' ug' . ' ON ' . ' ug.openid=u.openid' . ' WHERE ' . ' ug.uniacid=' . $_W['uniacid'] . ' AND' . ' ug.gid= ' . $_GPC['id'] . ' AND ' . ' ug.mch_id=0 ' . ' AND' . ' u.uniacid=' . $_W['uniacid'];
        $data = pdo_fetchall($sql);
//查询该活动需要几人成团
        $num = pdo_fetch(' SELECT * FROM ' . tablename('yzcyk_sun_groups') . ' a' . ' WHERE ' . ' a.id=' . $_GPC['id'] . ' AND ' . ' a.uniacid=' . $_W['uniacid']);
        //获取退款方式以及退款时间
        $refund_type = pdo_get('yzcyk_sun_system',array('uniacid'=>$_W['uniacid']));//refund = 2为自动退款
        $time = 60 * 60 * 24 ; //24小时
        $time1 = 60 * 60 * 48 ;
        $time2 = 60 * 60 * 72;
        $time3 = strtotime($num['endtime']);//活动结束时间

        foreach ($data as $k => $v) {
            if ($v['mch_id'] == 0) {
                $data[$k]['jiren'] = intval($num['groups_num']) - count($this->getSon(pdo_getall('yzcyk_sun_user_groups', array('uniacid' => $_W['uniacid'])), $v['id'])) - 1;
            }
            if ($data[$k]['jiren'] == '0') unset($data[$k]);
            if($refund_type['refund_time']==1){
                $data[$k]['endtime'] = ($v['addtime'] + $time) * 1000;
                $data[$k]['clock'] = '';
            }elseif ($refund_type['refund_time']==2){
                $data[$k]['endtime'] = ($v['addtime'] + $time1) * 1000;
                $data[$k]['clock'] = '';
            }elseif ($refund_type['refund_time']==3){
                $data[$k]['endtime'] = ($v['addtime'] + $time2) * 1000;
                $data[$k]['clock'] = '';
            }elseif ($refund_type['refund_time']==4){
                $data[$k]['endtime'] = $time3 * 1000;
                $data[$k]['clock'] = '';
            }else{
                $data[$k]['endtime'] = $time3 * 1000;
                $data[$k]['clock'] = '';
            }

        }

        return $this->result(0, '', $data);
    }

    public function getSon($data, $id)
    {
        global $_W;
        $temp = [];
        foreach ($data as $k => $v) {
            if ($v['mch_id'] == $id) {
                $temp[] = $v['id'];
            }
        }
        return $temp;
    }

    //获取该团长
    public function doPageTuanZhang()
    {
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $userid = $_GPC['userid'];
        $data = pdo_get('yzcyk_sun_user', array('uniacid' => $_W['uniacid'], 'openid' => $userid));
        return $this->result(0, '', $data);
    }

    //获取已经有多少人参与拼团
    public function doPagePartNumGroups()
    {
        global $_GPC, $_W;
        $data = pdo_getall('yzcyk_sun_user_groups', array('uniacid' => $_W['uniacid'], 'gid' => $_GPC['id']));
        return $this->result(0, '', $data);
    }

//    //好友点击去参团
    public function doPageFriendsGroups()
    {
        global $_W, $_GPC;
        $id = $_GPC['gid'];//商品ID
        $userid = $_GPC['userid'];//团长id
        //先查找团长的信息
        $tuanz = pdo_get('yzcyk_sun_user_groups', array('uniacid' => $_W['uniacid'], 'mch_id' => 0, 'gid' => $id, 'openid' => $userid));
        $sql = ' SELECT * FROM ' . tablename('yzcyk_sun_user_groups') . ' ug' . ' JOIN ' . tablename('yzcyk_sun_user') . ' u ' . ' ON ' . ' ug.openid=u.openid' . ' WHERE ' . ' ug.mch_id=' . $tuanz['id'] . ' AND ' . ' ug.gid=' . $id . ' AND ' . ' ug.uniacid=' . $_W['uniacid'] . ' AND ' . ' u.uniacid=' . $_W['uniacid'] . ' LIMIT 0,4';
//        $sql = ' SELECT * FROM ' .tablename('yzcyk_sun_groups') . ' g ' . ' JOIN ' . tablename('yzcyk_sun_user_groups') . ' ug ' . ' JOIN ' . tablename('yzcyk_sun_user') . ' u ' . ' ON ' . ' g.id=ug.gid' . ' AND ' . ' ug.openid=u.openid ' . ' WHERE ' . ' g.id=' . $id . ' AND ' . ' ug.gid= ' . $id . ' AND ' . ' ug.openid= ' . "'$userid'" . ' AND ' . ' ug.mch_id= ' . $tuanz['id'] . ' AND ' . ' g.uniacid=' . $_W['uniacid'] . ' AND ' . ' ug.uniacid=' . $_W['uniacid'] . ' AND ' . ' u.uniacid=' . $_W['uniacid'];
        $data = pdo_fetchall($sql);
//        $data[] = pdo_get('yzcyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$userid));
        return $this->result(0, '', $data);
    }

//-------------------------拼团end--------------------------------
    //获取微信支付参数
    public function doPagegetWxPaymentParam(){
        global $_GPC, $_W;
        $order=pdo_get('yzcyk_sun_order',array('id'=>$_GPC['order_id']));
        $openid = $order['uid'];
        $appData = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $appid = $appData['appid'];
        $mch_id = $appData['mchid'];
        $keys = $appData['wxkey'];
        $price = $order['order_amount'];
        $order_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $data = array(
            'appid' => $appid,
            'mch_id' => $mch_id,
            'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',//
            'body' => time(),
            'out_trade_no' => date('Ymd') . substr('' . time(), -4, 4),
            'total_fee' => $price * 100,
            'spbill_create_ip' => '120.79.152.105',
            'notify_url' => '120.79.152.105',
            'trade_type' => 'JSAPI',
            'openid' => $openid
        );
        ksort($data, SORT_ASC);
        $stringA = http_build_query($data);
        $signTempStr = $stringA . '&key=' . $keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['sign'] = $signValue;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $order_url);//如果不传这样进行设置
        curl_setopt($ch, CURLOPT_HEADER, 0);//header就是返回header头相关信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置数据是直接输出还是返回
        curl_setopt($ch, CURLOPT_POST, 1);//设置为post模式提交 跟 form表单的提交是一样
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->arrayToXml($data));//设置提交数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//设置ssl不验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//设置ssl不验证
        $result = curl_exec($ch);//执行请求 就等于html表单的 input:submit 如果没有设置 returntransfer 那么 是不会有返回值的 会直接输出
        curl_close($ch);//关闭
        $result = xml2array($result);
        echo json_encode($this->createPaySign($result));
    }
    /*
         * 获取微信支付的数据
         *
         */
    public function doPageOrderarr()
    {
        global $_GPC, $_W;
        $openid = $_GPC['openid'];
        $appData = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
        $appid = $appData['appid'];
        $mch_id = $appData['mchid'];
        $keys = $appData['wxkey'];
        $price = $_GPC['price'];
        $order_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $data = array(
            'appid' => $appid,
            'mch_id' => $mch_id,
            'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',//
            //'sign' => '',
            'body' => time(),
            'out_trade_no' => date('Ymd') . substr('' . time(), -4, 4),
            'total_fee' => $price * 100,
//            'total_fee' => 1,
            'spbill_create_ip' => '120.79.152.105',
            'notify_url' => '120.79.152.105',
            'trade_type' => 'JSAPI',
            'openid' => $openid
        );
        ksort($data, SORT_ASC);
        $stringA = http_build_query($data);
        $signTempStr = $stringA . '&key=' . $keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['sign'] = $signValue;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $order_url);//如果不传这样进行设置
        curl_setopt($ch, CURLOPT_HEADER, 0);//header就是返回header头相关信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置数据是直接输出还是返回
        curl_setopt($ch, CURLOPT_POST, 1);//设置为post模式提交 跟 form表单的提交是一样
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->arrayToXml($data));//设置提交数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//设置ssl不验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//设置ssl不验证
        $result = curl_exec($ch);//执行请求 就等于html表单的 input:submit 如果没有设置 returntransfer 那么 是不会有返回值的 会直接输出
        curl_close($ch);//关闭
        $result = xml2array($result);
//        return $this->result(0,'',$result);
        echo json_encode($this->createPaySign($result));

    }

    function createPaySign($result)
    {
        $appData = pdo_get('yzcyk_sun_system');
        $keys = $appData['wxkey'];
        $data = array(
            'appId' => $result['appid'],
            'timeStamp' => (string)time(),
            'nonceStr' => $result['nonce_str'],
            'package' => 'prepay_id=' . $result['prepay_id'],
            'signType' => 'MD5'
        );
        ksort($data, SORT_ASC);
        $stringA = '';
        foreach ($data as $key => $val) {
            $stringA .= "{$key}={$val}&";
        }
        $signTempStr = $stringA . 'key=' . $keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['paySign'] = $signValue;
        return $data;
    }

    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }


    /**
     * @return mixed|string
     *  自动退款
     */
    public function doPageHomeindex()
    {
        $transaction_id = intval($_POST['transaction_id']);
        $op_user_id = trim($_POST['uid']);

        date_default_timezone_set("Asia/Shanghai");
        $data['appid'] = "wx0ebf16dc245d637c";
        $data['mch_id'] = "1326789001";
        $data['transaction_id'] = "4200000098201804245081657613";
        $data['op_user_id'] = "ojKX54teKGVjnu0IBoFb-KvdZO9g";
        $data['nonce_str'] = '5K8264ILTKCH16CQ2502SI8ZNMTM67VS';
        $data['total_fee'] = 1;
        $data['refund_fee'] = 1;
        $data['out_refund_no'] = date("YmdHis");
        ksort($data, SORT_ASC);
        $stringA = http_build_query($data);
        $signTempStr = $stringA . '&key=8xrNr9LfKTYtM39vr2EvBfeLcdveHPxE';
        $signValue = strtoupper(md5($signTempStr));
        //$sign = getSign($data, '8xrNr9LfKTYtM39vr2EvBfeLcdveHPxE');
        $data['sign'] = $signValue;
//        $appid = "wx0ebf16dc245d637c";
//        $mch_id = "1326789001";
//        $out_trade_no = "14487658021497944120";
//        $op_user_id = "ojKX54teKGVjnu0IBoFb-KvdZO9g";
//        $out_refund_no = $date;
//        $total_fee = "1";
//        $refund_fee = "1";
////  $transaction_id = "4009542001201706206596667604";
//        $key = "8xrNr9LfKTYtM39vr2EvBfeLcdveHPxE";
//        $nonce_str = '5K8264ILTKCH16CQ2502SI8ZNMTM67VS';
//        $ref = strtoupper(md5("appid=$appid&mch_id=$mch_id&nonce_str=$nonce_str&op_user_id=$op_user_id"
//            . "&out_refund_no=$out_refund_no&out_trade_no=$out_trade_no&refund_fee=$refund_fee&total_fee=$total_fee"
//            . "&key=$key")); //sign加密MD5
//        $refund = array(
//            'appid' =>$appid, //应用ID，固定
//            'mch_id' => $mch_id, //商户号，固定
//            'nonce_str' => $nonce_str, //随机字符串
//            'op_user_id' => $op_user_id, //操作员
//            'out_refund_no' => $out_refund_no, //商户内部唯一退款单号
//            'out_trade_no' => $out_trade_no, //商户订单号,pay_sn码 1.1二选一,微信生成的订单号，在支付通知中有返回
//            // 'transaction_id'=>'1',//微信订单号 1.2二选一,商户侧传给微信的订单号
//            'refund_fee' => $refund_fee, //退款金额
//            'total_fee' => $total_fee, //总金额
//            'sign' => $ref//签名
//        );
        $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";; //微信退款地址，post请求
        $xml = $this->arrayToXmls($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

//        if ($useCert == true) {
        // 设置证书
//            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'p12');
//            curl_setopt($ch, CURLOPT_SSLCERT, dirname(__FILE__) . '/WxPay/cert/apiclient_cert.p12');
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, IA_ROOT . '/addons/yzcyk_sun/WxPay/cert/apiclient_cert.pem');
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, IA_ROOT . '/addons/yzcyk_sun/WxPay/cert/apiclient_key.pem');

//        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $xml = curl_exec($ch);
//        var_dump(curl_error($ch));exit;
//        print_r($xml);exit;
        // 返回结果0的时候能只能表明程序是正常返回不一定说明退款成功而已
        $errono = curl_errno($ch);
        if ($errono == 0) {
            $xml_data = xml2array($xml);
            $return_data['errNum'] = 0;
            $return_data['info'] = $xml_data;
        } else {
            $return_data['errNum'] = $errono;
            $return_data['info'] = '';
        }
        curl_close($ch);
        die(json_encode($return_data));
    }

    function getSign1($data, $key)
    {
        ksort($data, SORT_ASC);
        $stringA = http_build_query($data);
        $signTempStr = $stringA . '&key=' . $key;
        $signValue = strtoupper(md5($signTempStr));
        return $signValue;
    }

    function arrayToXmls($arr)
    {
        $xml = "<root>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</root>";
        return $xml;
    }

    function object_to_array($obj)
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }
        return $obj;
    }

    function nonceStr()
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        $length = 32;
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        // 随机字符串
        return $str;
    }
    //分销
    //判断是否开启相关插件
    public function doPagePlugin(){
        global $_W, $_GPC;
        $type = intval($_GPC["type"]);//1分销插件
        $uniacid = $_W["uniacid"];
        if($type==1){
            //判断分销表是否存在
            if(pdo_tableexists("yzcyk_sun_distribution_set")){
                $set = pdo_get('yzcyk_sun_distribution_set',array('uniacid'=>$uniacid));
                if($set){
                    if($set["status"]>0){
                        echo json_encode($set);
                    }else{
                        echo 2;
                    }
                }else{
                    echo 2;
                }
            }else{
                echo 2;
            }
        }else{
            echo 2;
        }
    }
}