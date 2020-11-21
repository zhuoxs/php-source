<?php
class orderscan extends base{
	public $required_fields = array('user_id','amount','store_id','pay_amount','pay_type');

	public function insert($data){
		$goodses = $data['goodses'];
		unset($data['goodses']);
		$data['time'] = time();
		$data['order_number'] = date('Ymd').time().rand(1000,9999);

		//用户支付
		$pay_data['amount'] = $data['amount'];
		$pay_data['pay_amount'] = $data['pay_amount'];
		$pay_data['pay_type'] = $data['pay_type'];
		$pay_data['type'] = 2;
		$pay_data['user_id'] = $data['user_id'];
		$user = new user();
		$user->pay($pay_data);

		//保存扫码订单
		$res = parent::insert($data);
		if ($res['code']) {
			return $res;
		}
		$data['id'] = $res['data'];

		//保存商品
		$orderscangoods = new orderscangoods();
		foreach ($goodses as $goods) {
			$new_goods = array();
            $new_goods['orderscan_id'] = $res['data'];
            $new_goods['goods_id'] = $goods->id;
            $new_goods['goods_name'] = $goods->title;
            $new_goods['goods_price'] = $goods->price;
            $new_goods['goods_img'] = $goods->src;
            $new_goods['num'] = $goods->num;
            $new_goods['orderscan'] = $data;
            $orderscangoods->insert($new_goods);
		}

		//判断是否使用优惠券、并切换优惠券状态
        if ($data['coupon_id'] && $data['coupon_id'] != 'undefined'){
            $usercoupon = new usercoupon();
            $usercoupon->usecoupon($data['coupon_id']);
        }

        $task_model = new task();
//        添加模板消息任务
        $task_model->insert([
            'type' => 'sendTemplate4OrderScan',
            'value' => $res['data'],
        ]);

        //        增加门店账单
        $bill_model = new storebill();
        $bill_model->insert([
            'content'=>'扫码购订单-收款',
            'time'=>time(),
            'type'=>2,
            'store_id'=>$data['store_id'],
            'balance'=>$data['pay_amount'],
        ]);

        return $res;
	}

	public function delete_app($id){
        $data['isdel'] = 1;
        $res = $this->update_by_id($data,$id);
        return $res;
    }

	// 通过 id 获取数据
	public function get_data_by_id($id = 0){
		$info = parent::get_data_by_id($id);
		$info['time'] = date('Y-m-d H:i:s',$info['time']);

		$store = new store();
		$store_data = $store->get_data_by_id($info['store_id']);
		$info['store_name'] = $store_data['name'];

		$orderscangoods = new orderscangoods();
		$goodses = $orderscangoods->query(array('orderscan_id = '.$id));
		$info['goodses'] = $goodses['data'];
		return $info;
	}

    public function send_template($id){
        $order_data = $this->get_data_by_id($id);

        $system = new system();
        $system_data = $system->get_current();

        $user_model = new user();
        $user_data = $user_model->get_data_by_id($order_data['user_id']);

        $store = new store();
        $store_data = $store->get_data_by_id($order_data['store_id']);

        $formid = new formid();
        $formid_data = $formid->get_data_by_user_id($order_data['user_id']);

        $opt = array('扫码购', $order_data['amount'], $store_data['name'], date('Y-m-d H:i:s', time()));
        $ret = sendTemplate($system_data['appid'], $system_data['appsecret'], $user_data['openid'], $system_data['template_id_buy'], 'yzhyk_sun/pages/user/scanorder/scanorder',$formid_data['form_id'],$opt);
        if (is_string($ret)){
            $ret = json_decode($ret,true);
        }
        if ($ret['errcode']){
            return false;
        }
        return true;
    }
}