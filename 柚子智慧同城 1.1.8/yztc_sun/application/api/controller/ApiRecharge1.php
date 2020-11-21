<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 10:21
 */
namespace app\api\controller;

use app\model\Recharge;
use app\model\Userbalancerecord;
use think\Db;

class ApiRecharge extends Api
{
    //TODO::充值设置
    public function rechargeSet(){
        $data=Recharge::get_curr();
        success_json($data);
    }
    //TODO::充值
    public function recharge(){
        global $_W;
        $user_id = input('post.user_id', 0);
        if ($user_id > 0){
            $user=new \app\model\User();
            $userinfo=$user->mfind(['id'=>$user_id],'openid');
            $rec=new Recharge();
            $recinfo=$rec->get_curr();
            $money=input('post.recmoney');
            $send_money=input('post.send_money');
            if($recinfo['recharge_lowest']<=$money){
                $allmoney= sprintf("%.2f",$money+$send_money);
                $wx=new ApiWx();
                $attach=json_encode(array('type'=>'recharge','uniacid'=>$_W['uniacid'],'recmoney'=>$allmoney,'send_money'=>$send_money));
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
    public function rechargeNotify($data){
        $attach=json_decode($data['attach'],true);
        $user=new \app\model\User();
        $userinfo=$user->mfind(['openid'=>$data['openid']]);
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

        $order_id= Db::name('rechargerecord')->getLastInsID();
        //添加余额记录
        $record->addBalanceRecord($userinfo['id'],$attach['uniacid'],1,$attach['send_money'],$attach['recmoney'],$order_id, $log['out_trade_no'],$remark='充值');
        echo 'SUCCESS';

    }
}