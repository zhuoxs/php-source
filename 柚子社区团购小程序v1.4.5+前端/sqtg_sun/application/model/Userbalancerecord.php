<?php
namespace app\model;

use app\base\model\Base;
use think\Db;
use think\Log;

class Userbalancerecord extends Base{
    /**
     * 修改用户余额
    */
    public function editBalance($user_id,$money){
//        $user=new User();
        Db::name('user')->where('id',$user_id)->setInc('balance',$money);
    }
    /**
     * 新增余额记录
     * $sign 1.充值 2.支付 3.退款 4.后台操作 5.商户入驻费用 6 拼团支付 7拼团退款
     * $send_moeny 充值赠送金额
     * $money 总金额 支付用负数（如 ：-100）
     * $order_id 订单id
     * $order_num 订单号
     * $remark 备注内容 （如支付 可填写商品名称）
    */
    public function addBalanceRecord($user_id,$uniacid,$sign=1,$send_money='0.00',$money,$order_id,$order_num,$remark=''){
        //修改用户余额
//        Db::name('user')->where('id',$user_id)->setInc('balance',$money);
        $user = User::get($user_id);
        $user->balance = bcadd($user->balance,$money,2);
        $user->save();
        //新增记录
        $data['user_id']=$user_id;
        $data['sign']=$sign;        //1充值2支付
        $data['send_money']=$send_money?$send_money:0;
        $data['money']=$money;
        $user=new User();
        $userinfo=$user->mfind(['id'=>$user_id],'balance,uniacid');
        $data['now_balance']=$userinfo['balance'];
        $data['order_id']=$order_id;
        $data['order_num']=$order_num;
        $data['remark']=$remark;
        $data['uniacid']=$uniacid;
        $data['create_time']=time();
        Db::name('userbalancerecord')->insert($data);
//        $this->allowField(true)->save($data);
    }
    public function onRechargeFinish($model){
        $real_recmoney = round($model->money - $model->send_money,2);
        $this->addBalanceRecord($model->user_id,$model->uniacid,1,$model->send_money,$model->money,$model->id,1,"充值".$real_recmoney.'赠送'.$model->send_money);
    }
}