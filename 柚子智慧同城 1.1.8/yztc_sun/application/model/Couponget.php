<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/2
 * Time: 10:12
 */
namespace app\model;


use think\Db;

class Couponget extends Base
{
    public function couponinfo(){
        return $this->hasOne('Coupon','id','cid');
    }
    public function storeinfo(){
        return $this->hasOne('Store','id','store_id');
    }
    //TODO::添加领取记录
    public function getCoupon($couponinfo,$user_id,$cid,$help_uid=0,$gettype,$money=0){
        $data['user_id']=$user_id;
        $data['cid']=$cid;
        $data['order_no']=date('YmdHis').rand(100000,999999);
        $data['help_uid']=$help_uid;
        $data['gettype']=$gettype;
        $data['money']=$money;
        $data['end_time']=$couponinfo['end_time'];
        $data['store_id']=$couponinfo['store_id'];
        $data['uniacid']=$couponinfo['uniacid'];
        $data['create_time']=time();
        $oid=Db::name('couponget')->insertGetId($data);

        //减库存、加领取量
        $cou=new Coupon();
        $cou->where('id',$cid)->setInc('sales_num',1);
        $cou->where('id',$cid)->setInc('sales_num_virtua',1);
        if($couponinfo['num']>0){
            $cou->where('id',$cid)->setDec('num',1);
        }
        //添加公共订单
        $common=new Commonorder();
        $common-> addCommonOrder(3,$cid,$user_id,$data['order_no'],$oid,1,$couponinfo['store_id'],$money,1);
        return $data['order_no'];
    }
    //TODO::支付回调
    public function payNotify($data){
        $attach=json_decode($data['attach'],true);
        $couponinfo=Coupon::get($attach['cid']);
        $res=$this->getCoupon($couponinfo,$attach['user_id'],$attach['cid'],$help_uid=0,1,$couponinfo['getmoney']);
        $edit['transaction_id']=$data['transaction_id'];
        $edit['out_trade_no']=$data['out_trade_no'];
        $edit['prepay_id']=$data['prepay_id'];
        Couponget::update($edit,['order_no'=>$res]);
        echo 'SUCCESS';
    }
    //TODO::优惠券核销
    public function checkOrd($order_no,$user_id){
        //管理员
        $orderinfo=Couponget::get(['order_no'=>$order_no]);
        Storeuser::checkConfirmPermission($orderinfo['store_id'],$user_id);
        $couponinfo=Coupon::get($orderinfo['cid']);
        //判断过期
        if($couponinfo['use_starttime']>time()){
            return_json('优惠券还未开始使用',-1);
        }
        if($orderinfo['end_time']<time()){
            return_json('该优惠券已过期，无法核销',-1);
        }
        //判断订单状态
        if($orderinfo['write_off_status']==0){
            //修改订单状态
            Couponget::update(['write_off_status'=>2,'write_off_time'=>time()],['order_no'=>$order_no]);
            //修改公共订单
            $common=new Commonorder();
            $common->editCommonOrderStatus(3,$orderinfo['id'],60);
            //添加商户收入
            (new Store())->setConfirmAfter($orderinfo['store_id'],$orderinfo['money'],3,$orderinfo['id'],$order_no,$orderinfo['user_id'],1);

            //增加积分
            $Integralrecord=new Integralrecord();
            $score=$Integralrecord->getScore($orderinfo['money']);
            if($score>0) {
                $Integralrecord->scoreAct($orderinfo['user_id'], 1, $score, $orderinfo['id']);
            }

            return_json();
        }else{
            return_json('该优惠券已使用',-1);
        }

    }
}