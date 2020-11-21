<?php
class storecoupon extends base{
	public $required_fields = array();
	public $unique = array(array('store_id','coupon_id'));
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'store',
            'on'=>array(
                'id'=>'store_id',
            ),
            'columns'=>array(
                'name'=>'store_name',
            ),
        ),
    );
	public function insert($data){
		// 补充数据
		$coupon = new coupon();
		$coupon_data = $coupon->get_data_by_id($data['coupon_id']);

		$data['name'] = $coupon_data['name'];
		$data['num'] = $coupon_data['num'];
		$data['left_num'] = $coupon_data['num'];
		$data['begin_time'] = $coupon_data['begin_time'];
		$data['end_time'] = $coupon_data['end_time'];
		$data['use_amount'] = $coupon_data['use_amount'];
		$data['amount'] = $coupon_data['amount'];
		$data['days'] = $coupon_data['days'];

		return parent::insert($data);
	}
}