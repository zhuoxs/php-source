<?php
namespace App\Model;

class Order extends Model {
    public  function checkStock($item,$user_id){ //$item['store_goods_id'],$item['num'],$item['goods_type']
        if($item['goods_type']==0) {
            $storeGoods = StoreGoods::instance()->find($item['store_goods_id']);
            if ($storeGoods->stock != -1 && $storeGoods->stock < $item['num']) {
                return true;
            } else {
                return false;
            }
        }else {
            $activityGodos = ActivityGoods::instance()->find($item['activity_goods_id']);

            //是否超过总购买量   是否超过个人购买量
            if ($activityGodos->buy_num + $item['num'] >$activityGodos->limited) {

                return  true;
            }else if($item['goods_type'] == 1){
                //获得个人购买限制
                $user_limit = \App\Model\LimitTimeActivity::instance()->find($activityGodos->activity_id)->toArray();

                //用户购买的多少本商品

                $query = \App\Model\OrderGoods::instance()->query;
                $count = $query->from('yzbld_sun_orders', 'o')->innerjoin('yzbld_sun_order_goods','d')->on('o.sn','d.order_sn')
                    ->where('o.user_id', $user_id)
                    ->where('o.status >',10)
                    ->where('o.status <',50)
                    ->where('d.activity_goods_id', $item['activity_goods_id'])
                    ->getall();

                $buynum = 0;
                foreach($count as $value){
                    $buynum+=$value['num'];
                }
//                return $user_limit['user_limit'].'-'.$buynum.'<'.$item['num'];
                if($user_limit['user_limit']-$buynum<$item['num']){
                    return '个人购买数量超过';
                }

            }
            return false;
        }
        return false;
    }
    public function decStock($order_sn){
        $orderGoods = OrderGoods::instance()->where('order_sn',$order_sn)->all();
        foreach($orderGoods as $item){
            if($item->buy_type==0){
                $storeGoods = StoreGoods::instance()->find($item->store_goods_id);
                if($storeGoods->stock != -1){
                    $storeGoods->stock -= $item->num;
                    $storeGoods->save();
                }

            }else{
                $activityGodos = ActivityGoods::instance()->find($item->activity_goods_id);
                $activityGodos->buy_num += $item->num;
                $activityGodos->save();
            }
        }
    }
}
