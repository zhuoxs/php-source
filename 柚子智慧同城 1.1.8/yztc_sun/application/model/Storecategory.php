<?php

namespace app\model;


class Storecategory extends Base
{
    public $unique = array('name');//唯一分组
    public function hotgoodses()
    {
        return $this->hasMany('Goods','store_id','id')
            ->where('state',1)
            ->where('stock',['>',0])
            ->where('is_recommend',1)
            ->where('check_status',2)

            ->field('id,name,pic,price,store_id')
            ->order('update_time','desc')
            ->limit(6);
    }
    public function getEndTimeAttr($value)
    {
        if (!$value){
            return '';
        }
        return date('Y-m-d H:i:s',$value);
    }
    public function setEndTimeAttr($value)
    {
        if (is_int($value)){
            return $value;
        }
        return strtotime($value);
    }
}
