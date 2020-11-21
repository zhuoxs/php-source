<?php

namespace app\model;

use think\Db;
use think\Exception;
use app\base\model\Base;

class Deliveryorder extends Base
{
    protected static function init()
    {
        parent::init();
        //新增前-验证必填
        self::beforeInsert(function ($model){
            $model->order_no = date("YmdHis") .rand(11111, 99999);
            $model->store_id = $_SESSION['admin']['store_id'];
        });
    }
    public function orderdetails()
    {
        return $this->hasMany('Orderdetail');
    }
    public function goodses()
    {
        return $this->hasMany('Deliveryordergoods','order_id','id')->with('goods');
    }
    public function leader(){
        return $this->hasOne('Leader','id','leader_id')->bind([
            'leader_name'=>'name',
            'address',
            'tel'
        ]);
    }
    public function onDeliveryordergoodsReceive($goods){
        Deliveryorder::update(['state'=>4],['id'=>$goods->order_id]);
    }
}
