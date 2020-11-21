<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 17:33
 */
namespace app\model;


class Activity extends Base
{
    //普通商品加入总活动表
    public function addActivityByGoods($data){
        if($data['is_activity']==1){
            $activity=$this->where(['type'=>$data['type'],'goods_id'=>$data['goods_id']])->find();
            if(!$activity){
                $this->allowField(true)->save($data);
            }else{
                $this->allowField(true)->save($data,['id'=>$activity['id']]);
            }
        }else if($data['is_activity']==0){
            $this->where(['type'=>$data['type'],'goods_id'=>$data['goods_id']])->delete();
        }
    }
}