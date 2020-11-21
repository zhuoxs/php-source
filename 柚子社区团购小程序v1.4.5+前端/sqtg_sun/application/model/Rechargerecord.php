<?php
namespace app\model;

use app\base\model\Base;
use think\Hook;

class Rechargerecord extends Base{
    protected static function init(){
        parent::init();
        self::beforeUpdate(function ($model){
            $old = self::get($model->id);

            //充值成功
            if($old->state==0 && $model->state == 1){
                Hook::listen('on_recharge_finish',$model);
            }
        });
    }
}