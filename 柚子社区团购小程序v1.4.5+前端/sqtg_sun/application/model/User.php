<?php

namespace app\model;

use app\base\model\Base;

class User extends Base
{
//    判断是不是分销商
//      如果是分销商，则返回对应id
//      否则，返回 false
    public static function isDistribution($id){
        if (!$id){
            return false;
        }
        if (!pdo_tableexists('sqtg_sun_distribution')) {
            return false;
        }
        $distribution = Distribution::get(['user_id'=>$id,'check_state'=>2]);
        return !!$distribution ? $distribution['id'] : false;
    }

    public function onOrderAdd($order){
        $user = User::get($order->user_id);
        if ($user && !$user->share_user_id && Config::get_value('distribution_relation',0) == 1){
            $user->share_user_id = $user->last_share_user_id;
            $user->save();
        }
    }
    public function onOrderPay($order){
        $user = User::get($order->user_id);
        if ($user && !$user->share_user_id && Config::get_value('distribution_relation',0) == 2){
            $user->share_user_id = $user->last_share_user_id;
            $user->save();
        }
    }
}
