<?php
/**
 * User: YangXinlan
 * DateTime: 2019/1/8 15:16
 */
namespace app\model;
class Commonorder extends Base
{
    //TODO::添加订单记录
    public function addCommonOrder($type,$goods_id,$user_id,$order_no,$order_id,$num,$store_id,$order_amount,$order_status=10){
        $data['type']=$type;
        $data['goods_id']=$goods_id;
        $data['user_id']=$user_id;
        $data['order_no']=$order_no;
        $data['order_id']=$order_id;
        $data['num']=$num;
        $data['store_id']=$store_id;
        $data['order_amount']=$order_amount;
        $data['order_status']=$order_status;
        $this->allowField(true)->save($data);
    }
    //TODO::修改订单状态
    public function editCommonOrderStatus($type,$order_id,$order_status){
        Commonorder::update(['order_status'=>$order_status],['type'=>$type,'order_id'=>$order_id]);
    }

}