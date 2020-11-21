<?php
namespace app\model;

use think\Model;

class Member extends Model {


    public function orders(){
        return $this->hasMany('order','user_id','id');
    }


    public function videoWatchLog(){
        return $this->hasMany('VideoWatchLog','user_id','id');
    }
}