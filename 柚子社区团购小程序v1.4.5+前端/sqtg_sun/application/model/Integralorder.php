<?php
namespace app\model;

use app\base\model\Base;
use think\Db;

class Integralorder extends Base{
    public function get_orderinfo($id){
        $info = self::get(['id'=>$id]);
        return $info;
    }
    /**
     * 免运费下单/支付成功
    */
    public function orderPay($oid){
        $orderinfo=$this->get_orderinfo($oid);
        $record=new Integralrecord();
        //扣除积分 、添加积分记录
        $record->scoreAct($orderinfo['user_id'],2,-$orderinfo['total_integral'],$orderinfo['goods_id']);
        //加销量、减库存
        $good=new Integralgoods();
        $goodinfo=$good->mfind(['id'=>$orderinfo['goods_id']],'num_type');
        if($goodinfo['num_type']==2){
            $good->actNum($orderinfo['goods_id'],$orderinfo['total_num']);
        }
        //修改订单状态
        $data['order_status']=1;
        $data['pay_status']=1;
        $data['pay_time']=time();
        $data['out_trade_no']=date('YmdHis') . substr('' . time(), -4, 4);
        $res=$this->allowField(true)->save($data,['id'=>$oid]);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    /**
     * 计算我已购买的数量
    */
    public function buyNum($user_id,$goods_id){
        $count=$this->where(['user_id'=>$user_id,'goods_id'=>$goods_id])->sum('total_num');
        return $count;
    }
    /**
     * 支付成功回调
    */
    public function notify($data){
        $attach=json_decode($data['attach'],true);
        $oid=$attach['oid'];
        $log['out_trade_no']=$data['out_trade_no'];
        $log['transaction_id']=$data['transaction_id'];
        $log['order_status']=1;
        $log['pay_status']=1;
        $log['pay_type']=1;
        $log['pay_time']=time();
        Db::name('integralorder')->where(['id'=>$oid])->update($log);
//        $order=new Integralorder();
//        $orderinfo=$order->mfind(['id'=>$oid]);
        $orderinfo=$this->get_orderinfo($oid);
        $goods=new Integralgoods();
        $goodsinfo=$goods->get_info($orderinfo['goods_id']);
        //减库存
        if($goodsinfo['num_type']==2){
            $goods->actNum($goodsinfo['id'],$orderinfo['total_num']);
        }
        //扣积分
        $record=new Integralrecord();
        //扣除积分 、添加积分记录
        $record->scoreAct($orderinfo['user_id'],2,-$orderinfo['total_integral'],$orderinfo['goods_id']);
        echo 'SUCCESS';
    }
    /**
     * 余额支付
    */
    public function moneyPay($oid){
//        $log['out_trade_no']=$data['out_trade_no'];
//        $log['transaction_id']=$data['transaction_id'];
        $log['order_status']=1;
        $log['pay_status']=1;
        $log['pay_type']=2;
        $log['pay_time']=time();
        $res=Db::name('integralorder')->where(['id'=>$oid])->update($log);
        if($res){
            $orderinfo=$this->get_orderinfo($oid);
            $goods=new Integralgoods();
            $goodsinfo=$goods->get_info($orderinfo['goods_id']);
            //减库存
            if($goodsinfo['num_type']==2){
                $goods->actNum($goodsinfo['id'],$orderinfo['total_num']);
            }
            //扣积分
            $record=new Integralrecord();
            //扣除积分 、添加积分记录
            $record->scoreAct($orderinfo['user_id'],2,-$orderinfo['total_integral'],$orderinfo['goods_id']);
            //扣余额
            $balance=new Userbalancerecord();
            $balance->editBalance($orderinfo['user_id'],-$orderinfo['order_amount']);
            //加余额记录
            $balance->addBalanceRecord($orderinfo['user_id'],$orderinfo['uniacid'],2,$send_money='0.00',-$orderinfo['order_amount'],$orderinfo['id'],$orderinfo['out_trade_no'],'积分商城消费');
            return 1 ;
        }else{
            return 0 ;
        }

    }
}