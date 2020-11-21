<?php

namespace app\model;

use app\base\model\Base;

class Admin extends Base
{
    public $unique = array('code');//唯一分组

    public function store(){
        return $this->hasOne('Store','id','store_id')->bind(array(
            'store_name'=>'name',
        ));
    }
}
