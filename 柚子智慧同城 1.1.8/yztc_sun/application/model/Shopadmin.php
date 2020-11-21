<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 16:25
 */
namespace app\model;


class Shopadmin extends Base
{
    public function user(){
        return $this->hasOne('User','id','user_id');
    }
    //判断是管理员
    public function isAdmin($user_id){
        //判断是否核销员
        $shopadmin=new Shopadmin();
        $isshopadmin=$shopadmin->mfind(['user_id'=>$user_id]);
        if($isshopadmin){
            $shops=Shop::get($isshopadmin['sid']);
            return array('admininfo'=>$isshopadmin,'auth'=>$isshopadmin['auth'],'shopinfo'=>$shops);
        }else{
            return -1;
        }

    }
}
