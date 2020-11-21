<?php
class ordergoods extends base{
	public $required_fields = array('order_id','goods_id','goods_name','goods_price','goods_img','num');

	public function insert($data){
	    $order_data = $data['order'];
	    unset($data['order']);
		$activity_id = $data['activity_id'];
		unset($data['activity_id']);

        //判断门店活动商品的数量、并扣减
        if($activity_id){
            $storeactivitygoods = new storeactivitygoods();
            $storeactivitygoods->out($order_data['store_id'],$data['goods_id'],$activity_id,$data['num']);
        }

		//判断门店商品库存、并修改库存
        $storegoods = new storegoods();
        $storegoods->out($order_data['store_id'],$data['goods_id'],$data['num']);

		return parent::insert($data);
	}
}