<?php
namespace app\model;

use app\base\model\Base;

class Suggest extends Base
{
    public function user(){
        return $this->hasOne('User','id','user_id')->bind(array(
            'user_name'=>'name',
            'img'=>'img',
        ));
    }
}