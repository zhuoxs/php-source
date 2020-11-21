<?php

namespace app\admin\controller;

use app\base\controller\Admin;

class Cusercoupon extends Admin
{
    //显示用户的优惠券
    public function get_list(){
        $used = [
            1=>'未使用',
            2=>'已经使用'
        ];
        $query = function($query){
            $user_id = input("post.user_id",0);
            $coupon_id = input("request.coupon_id",0);
            if($user_id){
                $query->where('user_id',$user_id);
            }
            if($coupon_id){
                $query->where('coupon_id',$coupon_id);
            }
        };
        $this->model->fill_order_limit();
        $list = $this->model->with('user')->where($query)->select();

        foreach($list as $key=>$val){
            $list[$key]['state']=$used[$val['state']];
            $list[$key]['end_time']=date('Y-m-d H:i:s',$val['end_time']);
            if($list[$key]['use_time']){
                $list[$key]['use_time'] = date('Y-m-d H:i:s',$val['use_time']);
            }
        }
        return [
            'code'=>0,
            'count'=>$this->model->where($query)->count(),
            'data'=>$list
        ];
    }
}
