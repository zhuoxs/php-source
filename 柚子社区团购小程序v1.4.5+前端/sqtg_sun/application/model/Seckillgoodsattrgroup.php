<?php

namespace app\model;

use app\base\model\Base;

class Seckillgoodsattrgroup extends Base
{
    public function attrs()
    {
        return $this->hasMany('Seckillgoodsattr');
    }
    public function attrList()
    {
        return $this->hasMany('Seckillgoodsattr');
    }
}
