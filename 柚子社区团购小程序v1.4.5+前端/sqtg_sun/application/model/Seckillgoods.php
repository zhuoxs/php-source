<?php

namespace app\model;

use app\base\model\Base;

class Seckillgoods extends Base
{
    public function seckillmeeting(){
        return $this->hasOne('Seckillmeeting','id','seckillmeeting_id')->bind(array(
            'seckillmeeting_name'=>'name',
        ));
    }
    public function store(){
        return $this->hasOne('Store','id','store_id')->bind(array(
            'store_name'=>'name',
            'store_pic'=>'pic',
            'goods_count',
            'sale_count',
        ));
    }
    public function attrGroupList()
    {
        return $this->hasMany('Goodsattrgroup','goods_id','goods_id')->with('attrs');
    }
    public function attrgroups()
    {
        return $this->hasMany('Goodsattrgroup','goods_id','goods_id')->with('attrs');
    }
    public function attrsetting()
    {
        return $this->hasMany('Seckillgoodsattrsetting','seckillgoods_id','id');
    }
}
