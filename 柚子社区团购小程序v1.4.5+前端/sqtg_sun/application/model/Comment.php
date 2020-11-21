<?php
namespace app\model;

use app\base\model\Base;

class Comment extends Base{
    public function userinfo(){
        return $this->hasOne('User','id','user_id')->bind(array(
            'username'=>'name',
            'headurl'=>'img',
        ));
    }

}