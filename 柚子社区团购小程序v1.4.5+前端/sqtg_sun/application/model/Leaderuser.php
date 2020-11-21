<?php

namespace app\model;

use app\base\model\Base;

class Leaderuser extends Base
{
    public function user(){
        return $this->hasOne('User','id','user_id')->bind([
            'name',
            'img',
            'tel',
        ]);
    }
    public function leader(){
        return $this->hasOne('Leader','id','leader_id')->bind([
            'leader_name'=>'name',
        ]);
    }
}
