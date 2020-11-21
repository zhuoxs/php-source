<?php

namespace app\model;

use app\base\model\Base;
use think\Hook;

class Leaderbill extends Base
{
    protected static function init()
    {
        parent::init();

//        账单变动
        self::beforeInsert(function ($model) {
            Hook::listen('on_leaderbill_add',$model);
        });

        self::beforeDelete(function ($model){
            Hook::listen('on_leaderbill_delete',$model);
        });
    }
    public function onOrderFinish(&$order){
        $rate = Config::get_value('leader_draw_rate',0);
        $money = $order->pay_amount * $rate / 100;
        if ($money >= 0.01){
            $data = [
                'content'=>'商城订单',
                'leader_id'=>$order->leader_id,
                'money'=>$money,
                'order_id'=>$order->id,
            ];
            $leaderbill = new Leaderbill($data);
            $leaderbill->isUpdate(false)->allowField(true)->save();
            $order->share_amount += $money;
        }
    }
    public function onOrdergoodsFinish(&$ordergoods){
        $rate = 0;
        $money = 0;

        $goods = Goods::get($ordergoods->goods_id);
        if ($goods->leader_draw_type == 1){
            $rate = $goods->leader_draw_rate;
        }elseif ($goods->leader_draw_type == 2){
            $money = $goods->leader_draw_money;
        }else{
            $store = Store::get($goods->store_id);
            if ($store && $store->leader_draw_type == 1){
                $rate = $store->leader_draw_rate;
            }elseif ($store && $store->leader_draw_type == 2){
                $money = $store->leader_draw_money;
            }else{
                $type = Config::get_value('leader_draw_type',1);
                if ($type == 1) {
                    $rate = Config::get_value('leader_draw_rate',0);
                }else{
                    $money = Config::get_value('leader_draw_money',0);
                }
            }
        }

        $money = $ordergoods->pay_amount * $rate / 100 + $money * $ordergoods->num;
        if ($money >= 0.01){
            $data = [
                'content'=>'商城订单',
                'leader_id'=>$ordergoods->leader_id,
                'money'=>$money,
                'order_id'=>$ordergoods->id,
            ];
            $leaderbill = new Leaderbill($data);
            $leaderbill->isUpdate(false)->allowField(true)->save();
            $ordergoods->share_amount += $money;
        }
    }
    public function onPingorderReceive(&$ordergoods){
        $rate = 0;
        $money = 0;

        $goods = Pingoods::get($ordergoods->goods_id);
        if ($goods->leader_draw_type == 1){
            $rate = $goods->leader_draw_rate;
        }elseif ($goods->leader_draw_type == 2){
            $money = $goods->leader_draw_money;
        }else{
            $store = Store::get($goods->store_id);
            if ($store && $store->leader_draw_type == 1){
                $rate = $store->leader_draw_rate;
            }elseif ($store && $store->leader_draw_type == 2){
                $money = $store->leader_draw_money;
            }else{
                $type = Config::get_value('leader_draw_type',1);
                if ($type == 1) {
                    $rate = Config::get_value('leader_draw_rate',0);
                }else{
                    $money = Config::get_value('leader_draw_money',0);
                }
            }
        }

        $money = ($ordergoods->order_amount - $ordergoods->distribution)* $rate / 100 + $money * $ordergoods->num;
        if ($money >= 0.01){
            $data = [
                'content'=>'拼团订单',
                'leader_id'=>$ordergoods->leader_id,
                'money'=>$money,
                'order_id'=>$ordergoods->id,
            ];
            $leaderbill = new Leaderbill($data);
            $leaderbill->isUpdate(false)->allowField(true)->save();
            $ordergoods->share_amount += $money;
        }
    }
}
