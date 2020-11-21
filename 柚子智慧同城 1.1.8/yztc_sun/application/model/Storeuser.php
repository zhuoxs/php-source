<?php

namespace app\model;


class Storeuser extends Base
{
    public function user(){
        return $this->hasOne('User','id','user_id')->bind(array(
            'user_name'=>'nickname',
            'img'=>'avatar',
        ));
    }
    //检测核销权限
    public static function checkConfirmPermission($store_id,$user_id){
        $store=(new Store())->where(['id'=>$store_id,'user_id'=>$user_id])->find();
        if(!$store){
            $storeuser=(new Storeuser())->where(['store_id'=>$store_id,'user_id'=>$user_id,'state'=>1])->find();
            if(!$storeuser){
               return_json('没有权限',-1);
            }
        }
        return true;
    }
}
