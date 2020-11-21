<?php

namespace app\model;

use app\base\model\Base;
use think\Exception;

class Goods extends Base
{
    public $order = 'create_time desc';//默认排序
    protected static function init()
    {
        parent::init();

        self::beforeInsert(function ($model){
            $model->batch_no = date("YmdHis") .rand(11111, 99999);
        });
    }
    //转换开始时间显示
    public function getBeginTimeAttr($value)
    {
        return $value?date('Y-m-d H:i:s',$value):'';
    }
    public function getEndTimeAttr($value)
    {
        return $value?date('Y-m-d H:i:s',$value):'';
    }
    public function setBeginTimeAttr($value)
    {
        return strtotime($value);
    }
    public function setEndTimeAttr($value)
    {
        return strtotime($value);
    }
    public function getSendTimeAttr($value)
    {
        return $value?date('Y-m-d H:i:s',$value):'';
    }
    public function setSendTimeAttr($value)
    {
        return strtotime($value);
    }
    public function getReceiveTimeAttr($value)
    {
        return $value?date('Y-m-d H:i:s',$value):'';
    }
    public function setReceiveTimeAttr($value)
    {
        return strtotime($value);
    }

    public function category(){
        return $this->hasOne('Category','id','cat_id')->bind(array(
            'cat_name'=>'name',
        ));
    }

    public function store(){
        return $this->hasOne('Store','id','store_id')->bind(array(
            'store_name'=>'name',
            'store_leader_draw_type'=>'leader_draw_type',
            'store_leader_draw_rate'=>'leader_draw_rate',
            'store_leader_draw_money'=>'leader_draw_money',
        ));
    }
    public function attrgroups()
    {
        return $this->hasMany('Goodsattrgroup','goods_id','id')->with('attrs');
    }

    public function ordergoodses(){
        return $this->hasMany('Ordergoods','goods_id','id');
    }

    public function onOrderPay($order){
        $ordergoodses = Ordergoods::where('order_id',$order->id)->select();

        foreach ($ordergoodses as $ordergoods) {
            $goods = Goods::get($ordergoods->goods_id);

//            $this->checkStock($ordergoods->goods_id,$ordergoods->attr_ids,$ordergoods->num);

            if ($ordergoods->attr_ids){
                $setting = Goodsattrsetting::get([
                    'goods_id'=>$ordergoods->goods_id,
                    'attr_ids'=>$ordergoods->attr_ids,
                ]);
                $setting->stock -= $ordergoods->num;
                $setting->save();
            }

            $goods->stock -= $ordergoods->num;
            $goods->sales_num += $ordergoods->num;
            $goods->save();
        }
    }
    public function onOrdergoodsRefund($ordergoods){
        $goods = Goods::get($ordergoods->goods_id);

        if ($goods){
            if ($ordergoods->attr_ids){
                $setting = Goodsattrsetting::get([
                    'goods_id'=>$ordergoods->goods_id,
                    'attr_ids'=>$ordergoods->attr_ids,
                ]);

                if ($setting){
                    $setting->stock += $ordergoods->num;
                    $setting->save();
                }
            }

            $goods->stock += $ordergoods->num;
            $goods->sales_num -= $ordergoods->num;
            $goods->save();
        }

    }

    public function onDeliveryordergoodsAdd($deliveryordergoods){
        $goods = Goods::get($deliveryordergoods->goods_id);
        $goods->batch_no = date("YmdHis") .rand(11111, 99999);
        $goods->save();
    }

    public function checkLimit($goods_id,$user_id,$num){
        $goods = Goods::get($goods_id);
        if ($goods['limit']){
            $count = Ordergoods::where('user_id',$user_id)
                ->where('goods_id',$goods_id)
                ->where('state',['in',[2,3,4,5]])
                ->sum('num');

            if ($count + $num > $goods['limit']){
                error_json('您购买的数量超过商家设置限购数量，请调整购买数量');
            }
        }
    }
    public function checkStock($goods_id,$attr_ids,$num){
        $goods = Goods::get($goods_id);

        $stock = $goods->stock;
        if ($attr_ids){
            $setting = Goodsattrsetting::get([
                'goods_id'=>$goods_id,
                'attr_ids'=>$attr_ids,
            ]);
            $stock = $setting->stock;
        }
        if ($stock < $num){
            error_json('库存不足');
        }
    }

    public function checkState($goods_id,$leader_id){
        $goods = Goods::get($goods_id);

        $storeleader_count = Storeleader::where('store_id',$goods->store_id)
            ->where('leader_id',$leader_id)
            ->count();

        if(!$storeleader_count && !$goods->mandatory){
            error_json('所选团长没有该商品');
        }

        if (Config::get_value('leader_choosegoods_switch',0)){
            $leadergoods_count = Leadergoods::where('leader_id',$leader_id)
                ->where('goods_id',$goods_id)
                ->count();
            if(!$leadergoods_count && !$goods->mandatory ){
                error_json('所选团长没有该商品');
            }
        }
        if (!$goods->state || $goods->getData('end_time') < time()){
            error_json('商品已结束');
        }
    }
}
