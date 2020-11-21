<?php
namespace app\model;

use app\base\model\Base;
use app\model\Delivery;

class Mercapdetails extends Base
{
    public $order = 'create_time desc';//默认排序
    protected static function init()
    {
        parent::init();

//        账单变动
        self::beforeInsert(function ($model) {
            $store = new Store();
            $store->onMercapdetailsAdd($model);
        });
    }

    public function onOrderFinish(&$order){
        $stores = Ordergoods::where('order_id',$order->id)
            ->distinct('store_id')
            ->field('store_id')
            ->select();
        foreach ($stores as $store) {
            $store2 = Store::get($store->store_id);
            $data = [
                'type'=>1,
                'store_id'=>$store->store_id,
                'store_name'=>$store2->name,
                'money'=>Ordergoods::where('order_id',$order->id)
                    ->where('store_id',$store->store_id)
                    ->sum('amount'),
                'sign'=>1,
                'order_id'=>$order->id,
            ];
            $info = new Mercapdetails($data);
            $info->isUpdate(false)->allowField(true)->save();
        }
    }
    public function onOrdergoodsFinish(&$ordergoods){
        $store = Store::get($ordergoods->store_id);

        //合并配送费问题
        $order = Order::get($ordergoods->order_id);
        if($order->merge){
//            db('baowen')->insert(['xml'=>'给运费 订单'.$order->id.'分订单'.$ordergoods->id]);
            $delivery = Delivery::where(['store_id'=>$ordergoods->store_id,'order_id'=>$ordergoods->order_id])->find();
//            db('baowen')->insert(['xml'=>'state'.json_encode($delivery)]);
            if(!$delivery->state){
                $money = $ordergoods->pay_amount - $ordergoods->share_amount - $ordergoods->distribution_money + $delivery->delivery_fee;
//                db('baowen')->insert(['xml'=>'给运费'.$delivery->delivery_fee]);
                $delivery->state=1;
                $delivery->save();
            }else{
                $money = $ordergoods->pay_amount - $ordergoods->share_amount - $ordergoods->distribution_money;
//                db('baowen')->insert(['xml'=>'不给运费']);
            }

        }else{
            //没有运费合并，每个商品都给运费
            $money = $ordergoods->pay_amount - $ordergoods->share_amount - $ordergoods->distribution_money + $ordergoods->delivery_fee;
        }

        $data = [
            'type'=>1,
            'store_id'=>$ordergoods->store_id,
            'store_name'=>$store['name'],
            'money'=>$money,
            'sign'=>1,
            'order_id'=>$ordergoods->id,
        ];
        $info = new Mercapdetails($data);
        $info->isUpdate(false)->allowField(true)->save();
    }
    public function onPingoodsFinish(&$ordergoods){
        $store = Store::get($ordergoods->store_id);
        $data = [
            'type'=>2,
            'store_id'=>$ordergoods->store_id,
            'store_name'=>$store['name'],
//            'money'=>$ordergoods->pay_amount - $ordergoods->share_amount - $ordergoods->distribution_money + $ordergoods->delivery_fee,
            'money'=>$ordergoods->order_amount-$ordergoods->share_amount,
            'sign'=>1,
            'order_id'=>$ordergoods->id,
        ];
        $info = new Mercapdetails($data);
        $info->isUpdate(false)->allowField(true)->save();
    }
    public function ordergoods(){
        return $this->hasOne('Ordergoods','id','order_id')->bind([
            'orderid'=>'order_id',
            'goods_name'=>'goods_name',
            'amount'=>'amount'
        ]);
    }
    public function order(){
        return $this->hasOne('Order','id','orderid')->bind([
            'order_no'=>'order_no'
        ]);
    }
    public function pinorder(){
        return $this->hasOne("Pinorder",'id','order_id')->withField('order_num,id,goods_id,order_amount')->bind([
            'order_no'=>'order_num',
            'goods_id'=>'goods_id',
            'amount'=>'order_amount'
        ]);
    }
    public function goods(){
        return $this->hasOne('Pingoods','id','goods_id')->bind([
            'goods_name'=>'name'
        ]);
    }
}
