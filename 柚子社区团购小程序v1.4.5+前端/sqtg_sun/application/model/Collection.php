<?php

namespace app\model;

use app\base\model\Base;

class Collection extends Base
{
    public $order = 'update_time desc';//默认排序
//    取消收藏
//    传入：
//        id：收藏id
    public static function cancel($id){
        return self::get($id)->save(array('collect_state'=>2,'cancel_time'=>time()));
    }

    public function goods(){
        return $this->hasOne('Goods','id','goods_id')->bind(array(
            'goods_name'=>'name',
            'goods_price'=>'price',
            'goods_pic'=>'pic',
            'goods_store_id'=>'store_id',
        ));
    }
    public function topic(){
        return $this->hasOne('Topic','id','topic_id')->bind(array(
            'topic_title'=>'title',
            'see_count'=>'see_count',
            'topic_pic'=>'pic',
        ));
    }
//    public function store(){
//        return $this->hasOne('Store','id','store_id')->bind(array(
//            'store_name'=>'name',
////            'store_address'=>'address',
//        ));
//    }
}
