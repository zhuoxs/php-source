<?php

namespace app\model;

use think\Db;
use think\Exception;
use app\base\model\Base;

class Deliveryordergoods extends Base
{
    protected static function init()
    {
        parent::init();
        //新增前-验证必填
        self::beforeInsert(function ($model){
            $ordergoods = new Ordergoods();
            $ordergoods->onDeliveryordergoodsAdd($model);

            $goods = new Goods();
            $goods->onDeliveryordergoodsAdd($model);
        });
        self::beforeUpdate(function ($model){
            if ($model->num == $model->receive_num){
                $deliveryorder = new Deliveryorder();
                $deliveryorder->onDeliveryordergoodsReceive($model);
            }
        });
    }
    public function leader(){
        return $this->hasOne('Leader','id','leader_id')->bind([
            'leader_name'=>'name',
            'address',
            'tel'
        ]);
    }
    public function goods(){
        return $this->hasOne('Goods','id','goods_id')->bind([
            'goods_name'=>'name',
        ]);
    }
}
