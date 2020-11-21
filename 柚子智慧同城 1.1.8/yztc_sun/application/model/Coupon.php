<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 17:33
 */
namespace app\model;


class Coupon extends Base
{
    public function storeinfo(){
        return $this->hasOne('Store','id','store_id');
    }
    //获取最新免费领取优惠券名称
    public function getGetType3CouponTitle($store_id){
        $data=$this->where(['store_id'=>$store_id,'state'=>1,'gettype'=>3])->order('id desc')->find();
        return $data['name'];
    }
    //获取优惠券列表通过门店
    public function getCouponListByStoreId($store_id){
        $data=$this->where(['store_id'=>$store_id,'state'=>1])->order('id desc')->select();
        return $data;
    }
}