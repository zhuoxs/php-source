<?php

namespace app\model;

use Think\Db;
use app\base\model\Base;

class Bookorder extends Base
{
     public function getOrderRecordNum($user_id){
           global $_W;
           $data=Db::name('order')->field('user_id,order_status,count(id) as record_num')->where(array('uniacid'=>$_W['uniacid'],'user_id'=>$user_id))->group('order_status')->select();
           foreach($data as $val){
               if($val['order_status']==0){
                   $dfk=$val['record_num'];
               }else  if($val['order_status']==1){
                   $dfh=$val['record_num'];
               }else  if($val['order_status']==3){
                   $ywc=$val['record_num'];
               }else  if($val['order_status']==5){
                   $tk=$val['record_num'];
               }
           }
           $dfk=$dfk?$dfk:0;
           $dfh=$dfh?$dfh:0;
           $ywc=$ywc?$ywc:0;
           $tk=$tk?$tk:0;
           return array(
                 'dfk'=>$dfk,
                 'dfh'=>$dfh,
                 'ywc'=>$ywc,
                 'tk'=>$tk
            );
     }

    public function orderdetails()
    {
        return $this->hasMany('Orderdetail');
    }
}
