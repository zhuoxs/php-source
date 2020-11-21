<?php

namespace app\model;


class Postagerules extends Base
{
    public function store(){
        return $this->hasOne('Store','id','store_id')->bind(array(
            'store_name'=>'name',
        ));
    }
}
