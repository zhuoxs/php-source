<?php

namespace app\model;

use app\base\model\Base;

class Leadergoods extends Base
{
    public function goods(){
        return $this->hasOne('Goods','id','goods_id')->bind(array(
            'name',
            'price',
            'pic',
            'sales_num'=>'sales_num'
        ));
    }
    public function store(){
        return $this->hasOne('Store','id','store_id')->bind(array(
            'store_name'=>'name',
        ));
    }
}
