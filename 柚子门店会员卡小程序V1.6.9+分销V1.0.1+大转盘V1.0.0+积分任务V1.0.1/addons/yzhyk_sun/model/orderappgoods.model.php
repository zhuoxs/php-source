<?php
class orderappgoods extends base{
	public $required_fields = array('order_id','goods_id','goods_name','goods_price','goods_img','num');

	public function insert($data){
	    $order_data = $data['order'];
	    unset($data['order']);


		//判断门店商品库存、并修改库存
        $storegoods = new storegoods();
        $storegoods->out($order_data['store_id'],$data['goods_id'],$data['num']);

		return parent::insert($data);
	}
}