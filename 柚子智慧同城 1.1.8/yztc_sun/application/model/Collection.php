<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 17:33
 */
namespace app\model;


class Collection extends Base
{
    //收藏
    public function setCollection($user_id,$store_id){
       $data=$this->where(['user_id'=>$user_id,'type'=>1,'store_id'=>$store_id])->find();
       if($data){
           $id=$data['id'];
           $data=[
               'is_collection'=>1,
               'collect_time'=>time(),
           ];
           $this->allowField(true)->save($data,['id'=>$id]);
       }else{
           $data=array(
               'user_id'=>$user_id,
               'type'=>1,
               'store_id'=>$store_id,
               'is_collection'=>1,
               'collect_time'=>time(),
           );
           $this->allowField(true)->save($data);
       }

    }
    //取消收藏
    public function cancelCollection($user_id,$store_id){
        $data=$this->where(['user_id'=>$user_id,'type'=>1,'store_id'=>$store_id,'is_collection'=>1])->find();
        $id=$data['id'];
        $data=[
            'is_collection'=>0,
            'cancel_time'=>time(),
        ];
        $this->allowField(true)->save($data,['id'=>$id]);
    }
    //获取用户收藏状态
    public function getUserCollection($user_id,$store_id){
        $data=$this->where(['user_id'=>$user_id,'type'=>1,'store_id'=>$store_id,'is_collection'=>1])->find();
        if($data){
            return 1;
        }else{
            return 0;
        }
    }
}