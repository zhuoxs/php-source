<?php
/**
 * User: YangXinlan
 * DateTime: 2019/2/26 10:54
 */
namespace app\model;


class Freesheetorder extends Base
{
    //TODO::核销订单
    public function checkOrd($order_no,$user_id){
        //管理员
        $orderinfo=Freesheetorder::get(['order_no'=>$order_no,'is_del'=>0,'after_sale'=>0]);
        Storeuser::checkConfirmPermission($orderinfo['store_id'],$user_id);
        $goodsinfo=Freesheet::get($orderinfo['goods_id']);
        //判断过期
        if($goodsinfo['lottery_time']<time()){
            return_json('当前活动未开奖',-1);
        }
        if($goodsinfo['expire_time']<time()){
            return_json('该商品已过期，无法核销',-1);
        }
        //判断订单状态
        if($orderinfo['lottery_status']==2){
            if($orderinfo['user_id']==$user_id){
                $ord=new Freesheetorder();
                $res=$ord->save(['write_off_status'=>1,'write_off_time'=>time()],['order_no'=>$order_no]);
                if($res){
                    return_json('使用成功');
                }else{
                    return_json('请稍后重试',-1);
                }
            }else{
                return_json('当前账号与下单账号不一致',-1);
            }
        }else{
            return_json('未中奖，当前订单无法核销',-1);
        }
    }
    //TODO::获取预中奖人数
    public function preprizeNum($goods_id){
        $model=new Freesheetorder();
        $num=$model->where(['pre_prize'=>1,'goods_id'=>$goods_id])->count();
        return $num?$num:0;
    }
    //TODO::抽奖
    public function lottery(){

    }
}