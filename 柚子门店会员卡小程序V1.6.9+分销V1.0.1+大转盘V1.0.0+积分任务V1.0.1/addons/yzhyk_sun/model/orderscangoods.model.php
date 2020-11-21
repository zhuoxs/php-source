<?php
class orderscangoods extends base{
	public $required_fields = array('orderscan_id','goods_id','goods_name','goods_price','goods_img','num');

	public function insert($data){
	    $orderscna_data = $data['orderscan'];
	    unset($data['orderscan']);

        //修改库存
        $storegoods = new storegoods();
        $storegoods->out($orderscna_data['store_id'], $data['goods_id'], $data['num']);

        return parent::insert($data);
    }
}