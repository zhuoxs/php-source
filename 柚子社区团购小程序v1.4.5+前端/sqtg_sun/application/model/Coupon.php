<?php

namespace app\model;

use app\base\model\Base;
use think\Exception;

class Coupon extends Base
{
    public $order = 'id desc';//默认排序
    //转换开始时间显示
    public function getBeginTimeAttr($value)
    {
        return $value?date('Y-m-d H:i:d',$value):'';
    }
    public function getEndTimeAttr($value)
    {
        return $value?date('Y-m-d H:i:d',$value):'';
    }
    public function setBeginTimeAttr($value)
    {
        return strtotime($value);
    }
    public function setEndTimeAttr($value)
    {
        return strtotime($value);
    }

//    观察用户领取优惠券
    public function onUsercouponAdd(Usercoupon $usercoupon){
        $coupon = Coupon::get($usercoupon->coupon_id);

        if ($coupon->left_num <= 0 || $coupon->state != 1){
            throw new Exception('该优惠券已领完');
        }

        $coupon->setDec('left_num');
    }
}
