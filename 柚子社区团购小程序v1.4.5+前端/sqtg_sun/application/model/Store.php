<?php

namespace app\model;

use app\base\model\Base;
use think\Hook;

class Store extends Base
{
    public $unique = array('name');//唯一分组
    protected static function init()
    {
        parent::init();
        self::beforeInsert(function ($model){
            Hook::listen('on_store_add',$model);
        });
        self::beforeUpdate(function ($model){
            $old_info = self::get($model->id);
//            审核
            if ($old_info['check_state'] == 1 && $model['check_state'] == 2){
                Hook::listen('on_store_checked',$model);
            }

        });

        self::beforeDelete(function ($model){
            Hook::listen('on_store_deleted',$model);
        });
    }
    public function onMercapdetailsAdd($info){
        if ($info->sign == 1){
            $store = Store::get($info->store_id);
            if ($store){
                $store->money += $info->money;
                $store->save();
            }
        }
    }
}
