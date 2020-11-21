<?php

namespace app\model;

use app\base\model\Base;
use think\Hook;

class Usercoupon extends Base
{
    protected static function init()
    {
        parent::init();

//        用户领取优惠券
        self::beforeInsert(function ($model) {
            Hook::listen('on_usercoupon_add',$model);
        });
    }
    public function onOrderAdd($order){
        if($order->usercoupon_id){
            $usercoupon = Usercoupon::get($order->usercoupon_id);

            if ($order->amount < $usercoupon->use_money){
                error_json('该优惠券不符合使用场景');
            }

            $coupon = Coupon::get([
                'id'=>$usercoupon->coupon_id,
                'state'=>1,
            ]);
            if (!$coupon){
                error_json('该优惠券已过期，请选择其他优惠券');
            }

            $usercoupon->state = 2;
            $usercoupon->use_time = time();
            $usercoupon->save();
        }
    }

    public function user() {
        return $this->hasOne('User', 'id', 'user_id')->bind([
            'user_name' => 'name'
        ]);
    }
}
