<?php

namespace app\model;

use app\base\model\Base;

class Cart extends Base
{
    public function goods(){
        return $this->hasOne('Goods','id','goods_id')->bind(array(
            'name',
            'pic',
            'price'
        ));
    }
}
