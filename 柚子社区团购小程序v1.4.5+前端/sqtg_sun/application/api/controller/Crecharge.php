<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 16:26
 */
namespace app\api\controller;
use app\base\controller\Api;
use app\model\Recharge;
use app\model\Rechargerecord;
use app\model\System;
use app\model\User;
use app\model\Userbalancerecord;
use think\Db;
use think\Loader;

class Crecharge extends Api{
    /**
     * 充值页面
    */
    public function recharge(){
        $rec=new Recharge();
        $recinfo=$rec->get_curr();
        $recinfo['details']=json_decode($recinfo['details'],true);
        $user_id=input('post.user_id');
        if($user_id>0){
            $user=new User();
            $info['userinfo']=$user->mfind(['id'=>$user_id],'balance');
            $info['recharge']=$recinfo;
            return_json('success',0,$info);
        }else{
            return_json('user_id不能为空',1);
        }
    }
    public function wx($openid,$total_fee,$attach){
        global $_W;
        Loader::import('wxpay.wxpay');
        $system = System::get_curr();
        $appid = $system['appid'];
//        $openid = $openid;//openid
        $mch_id = $system['mchid'];//商户号
        $key = $system['wxkey'];   //密钥
        $out_trade_no = date('Ymd') . substr('' . time(), -4, 4);//订单号
        $total_fee = intval($total_fee*100);//价格
        $body='充值';
//        $attach=$attach;
        $siteroot=str_replace("https","http",$_W['siteroot']);
        $notify_url=$siteroot.'/addons/sqtg_sun/public/notify.php';
        if($total_fee<=0){
            error_json('金额有误');
        }
//        var_dump($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);exit;
        $weixinpay = new \WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);
        $return = $weixinpay->pay();
//        var_dump($return);exit;
        return $return;
    }
    /**
     * 调支付
    */
    public function pay(){
        global $_W;
        $user_id = input('post.user_id', 0);
        if ($user_id > 0){
            $user=new User();
            $userinfo=$user->mfind(['id'=>$user_id],'openid');
            $rec=new Recharge();
            $recinfo=$rec->get_curr();
            $money=input('post.recmoney');
            $send_money=input('post.send_money');
            if($recinfo['recharge_lowest']<=$money){
                $allmoney= sprintf("%.2f",$money+$send_money);
                $wx=new Cwx();
                $attach=json_encode(array('type'=>'recharge','uniacid'=>$_W['uniacid'],'recmoney'=>$allmoney,'send_money'=>$send_money));
//                $wxinfo=$this->wx($userinfo['openid'],$allmoney,$attach);
                $wxinfo=$wx->pay($userinfo['openid'],$money,$attach);
                return_json('调支付',0,$wxinfo);
            }else{
                return_json('最低需充值'.$recinfo['recharge_lowest'].'元',1);
            }
        }else{
            return_json('user_id不能为空',1);
        }
    }
    /**
     * 支付回调
    */
    public function payNotify($data){

        $attach=json_decode($data['attach'],true);
//        $user=new User();
//        $userinfo=$user->mfind(['openid'=>$data['openid']]);
        $userinfo=Db::name('user')->where('openid',$data['openid'])->find();

        $record=new Userbalancerecord();
        //修改账户余额
        $record->editBalance($userinfo['id'],$attach['recmoney']);
        //添加充值记录
        $log['user_id']=$userinfo['id'];
        $log['money']=$attach['recmoney'];
        $log['send_money']=$attach['send_money']?$attach['send_money']:0;
        $log['out_trade_no']=$data['out_trade_no'];
        $log['transaction_id']=$data['transaction_id'];
        $log['prepay_id']=$data['prepay_id'];
        $log['uniacid']=$attach['uniacid'];
        $log['create_time']=time();
        Db::name('rechargerecord')->insert($log);
//        $rech=new Rechargerecord();
//        $rech->allowField(true)->save($log);
        $order_id= Db::name('rechargerecord')->getLastInsID();
        //添加余额记录
        $record->addBalanceRecord($userinfo['id'],$attach['uniacid'],1,$attach['send_money'],$attach['recmoney'],$order_id, $log['out_trade_no'],$remark='充值');
        echo 'SUCCESS';

    }
    /**
     * 余额明细
    */
    public function balanceList(){
        $user_id = input('post.user_id', 0);
        if ($user_id > 0){
            $bal=new Userbalancerecord();
            $where['user_id']=$user_id;
            $order['create_time']='desc';
            $page = input('post.page', 1);
            $length = input('post.length', 10);
            $list=$bal->mlist($where,$order,$page,$length);
            return_json('success',0,$list);
        }else{
            return_json('user_id不能为空',1);
        }
    }
}