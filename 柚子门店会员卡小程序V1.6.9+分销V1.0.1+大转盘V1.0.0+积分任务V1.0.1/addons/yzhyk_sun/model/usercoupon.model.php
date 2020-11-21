<?php
class usercoupon extends base{
	public $required_fields = array('user_id');
	public $unique = array();

	public function usecoupon($id){
		$this->update_by_id(array('is_used'=>1),$id);
	}

	public function insert($data){
		// 补充数据
		$storecoupon = new storecoupon();
		$storecoupon_data = $storecoupon->get_data_by_id($data['storecoupon_id']);

        if($storecoupon_data['left_num']<=0){
            throw new ZhyException('优惠券已领完');
        }

        $storecoupon->update_by_id(array('left_num -='=>1),$data['storecoupon_id']);

		$data['name'] = $storecoupon_data['name'];
		$data['begin_time'] = date('Y-m-d',time());
		$data['end_time'] = date('Y-m-d',strtotime("+{$storecoupon_data['days']} day"));
		$data['use_amount'] = $storecoupon_data['use_amount'];
		$data['amount'] = $storecoupon_data['amount'];
		$data['is_used'] = 0;
        $data['coupon_id'] = $storecoupon_data['coupon_id'];
        $data['store_id'] = $storecoupon_data['store_id'];

		return parent::insert($data);
	}
}