<?php

namespace app\model;

use app\base\model\Base;

class Topic extends Base
{
    public $order = 'is_hot desc,update_time desc';//默认排序
    public static function get($data,$with= ['goods'],$cache= false)
    {
        return parent::get($data, $with, $cache);
    }
    public function goods(){
        return $this->hasOne('Goods','id','goods_id')->bind(array(
            'goods_name'=>'name',
            'goods_price'=>'price',
            'goods_pic'=>'pic',
        ));
    }
}
