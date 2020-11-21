<?php

namespace app\model;
class District extends Base
{
    public $has_uniacid = false;//是否有 uniacid 字段
    //获取省市区
    public function getProvinceCityZip($type){
        $address=array('country','province','city','district');
        $type=$address[$type];
        $data=$this->getAllList(array('level'=>$type));
        return $data;
    }
}
