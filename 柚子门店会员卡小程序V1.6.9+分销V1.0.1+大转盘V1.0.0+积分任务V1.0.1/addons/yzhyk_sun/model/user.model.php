<?php
class user extends base{
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'admin',
            'on'=>array(
                'id'=>'admin_id',
            ),
            'columns'=>array(
                'name'=>'admin_name',
            ),
        ),
    );

    public function pay_balance($data){
        global $_W;
        switch ($data['type']) {
            case '1':
                $data['content'] = '线下订单、线上支付';
                break;
            case '2':
                $data['content'] = '扫码购订单';
                break;
            case '3':
                $data['content'] = '线上商城订单';
                break;
            case '4':
                $data['content'] = '积分兑换余额';
                break;
            case '5':
                $data['content'] = '充值';
                break;
            case '6':
                $data['content'] = '线上生成团购订单';
                break;
            case '7':
                $data['content'] = '预约订单支付';
                break;
        }

        $user_data = $this->get_data_by_id($data['user_id']);

        // 判断余额是否充足
        if ($user_data['balance'] < $data['pay_amount']) {
            throw new ZhyException('余额不足');
        }

        // 余额支付
        $res = $this->update_by_id(array('balance -='=>$data['pay_amount']),$data['user_id']);
        if (!$res) {
            throw new ZhyException('余额支付失败');
        }
        
        // 余额账单
        $bill_data['type']  = $data['type'];
        $bill_data['user_id'] = $data['user_id'];
        $bill_data['balance'] = $data['pay_amount'];
        $bill_data['content'] = $data['content'];
        $bill = new bill();
        $bill->insert($bill_data);
        // var_dump($bill_data);
        // var_dump($user_data);

        // $user=pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$data['user_id']));
        if($user_data['isbuy']==1){
            $member_upgrade=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']),array('member_upgrade'));
            if($member_upgrade['member_upgrade']==1){
                // 增加用户消费额
                $this->update_by_id(array('amount'=>($user_data['amount']?:0) + $data['pay_amount']),$data['user_id']);
                $this->update_member_level($data['user_id']);
            }
        }
        else{
            $this->update_by_id(array('amount'=>($user_data['amount']?:0) + $data['pay_amount']),$data['user_id']);
            $this->update_member_level($data['user_id']);
        }
        // die;
        

        
    }
    public function add_integral($data){
        // var_dump($data['type']);
        $data['content'] = $this->get_content_by_type($data['type']);
        // var_dump($data['content']);
        
        // var_dump($data);die;

        // 积分账单
        $system = new system();
        $system_data = $system->get_current();
        $i = $system_data['integral1'];
        
        // $i=1;
        if ($i && $i<= $data['pay_amount']){
            $integral_data['user_id'] = $data['user_id'];
            $integral_data['content'] = $data['content'];
            $integral_data['integral'] = floor($data['pay_amount']/$i);
            $integral_data['type'] = $data['type'];
            $integral = new integral();
            $integral->insert($integral_data);
        }
    }

    public function get_content_by_type($type){
        $content = "";
        switch ($type) {
            case '1':
                $content = '线下订单、线上支付';
                break;
            case '2':
                $content = '扫码购订单';
                break;
            case '3':
                $content = '线上商城订单';
                break;
            case '4':
                $content = '积分兑换余额';
                break;
            case '5':
                $content = '充值';
                break;
            case '6':
                $content = '线上生成团购订单';
                break;
            case '7':
                $content = '预约订单支付';
                break;
        }
        return $content;
    }

	public function pay($data){
        global $_W;
		switch ($data['type']) {
			case '1':
				$data['content'] = '线下订单、线上支付';
				break;
			case '2':
				$data['content'] = '扫码购订单';
				break;
			case '3':
				$data['content'] = '线上商城订单';
				break;
            case '4':
                $data['content'] = '积分兑换余额';
                break;
            case '5':
                $data['content'] = '充值';
                break;
            case '6':
                $data['content'] = '线上生成团购订单';
                break;
            case '7':
                $data['content'] = '预约订单支付';
                break;
		}

        $user_data = $this->get_data_by_id($data['user_id']);
        // 余额支付、余额账单
        if ($data['pay_type'] == '余额') {
			// 判断余额是否充足
			if ($user_data['balance'] < $data['pay_amount']) {
			    throw new ZhyException('余额不足');
			}
			// 余额支付
			$res = $this->update_by_id(array('balance -='=>$data['pay_amount']),$data['user_id']);
			if (!$res) {
			    throw new ZhyException('余额支付失败');
			}

			// 余额账单
			$bill_data['type']  = $data['type'];
            $bill_data['user_id'] = $data['user_id'];
            $bill_data['balance'] = $data['pay_amount'];
            $bill_data['content'] = $data['content'];
			$bill = new bill();
			$bill->insert($bill_data);
		}

		// 积分账单
		$system = new system();
		$system_list = $system->query();
		$system_data = $system_list['data'][0];
		$i = $system_data['integral1'];
		if ($i && $i<= $data['pay_amount']){
            $integral_data['user_id'] = $data['user_id'];
            $integral_data['content'] = $data['content'];
            $integral_data['integral'] = floor($data['pay_amount']/$i);
            $integral_data['type'] = $data['type'];
            $integral = new integral();
            $integral->insert($integral_data);
        }

        // $user=pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$data['user_id']));
        if($user_data['isbuy']==1){
            $member_upgrade=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']),array('member_upgrade'));
            if($member_upgrade['member_upgrade']==1){
                // 增加用户消费额
                $this->update_by_id(array('amount'=>($user_data['amount']?:0) + $data['pay_amount']),$data['user_id']);
                $this->update_member_level($data['user_id']);
            }
        }else{
            $this->update_by_id(array('amount'=>($user_data['amount']?:0) + $data['pay_amount']),$data['user_id']);
            $this->update_member_level($data['user_id']);
        }
        
    }

    public function back($data){
        global $_W;
        switch ($data['type']) {
            case '1':
                $data['content'] = '线下订单、线上支付';
                break;
            case '2':
                $data['content'] = '扫码购订单';
                break;
            case '3':
                $data['content'] = '线上商城订单';
                break;
            case '4':
                $data['content'] = '积分兑换余额';
                break;
            case '5':
                $data['content'] = '充值';
                break;
            case '-6':
                $data['content'] = '线上生成团购订单-退款';
                break;
            case '7':
                $data['content'] = '预约订单退款';
                break;
        }

        //暂时退款至余额
        //todo 以后加上微信退款
        $user_data = $this->get_data_by_id($data['user_id']);
        //增加余额
        $res = $this->update_by_id(array('balance'=>($user_data['balance']?:0) + $data['pay_amount']),$data['user_id']);

        // 余额账单
        $bill_data['type']  = $data['type'];
        $bill_data['user_id'] = $data['user_id'];
        $bill_data['balance'] = $data['pay_amount'];
        $bill_data['content'] = $data['content'];
        $bill = new bill();
        $bill->insert($bill_data);

        // 积分账单
        $system = new system();
        $system_list = $system->query();
        $system_data = $system_list['data'][0];
        $i = $system_data['integral1'];
        if ($i && $i<= $data['pay_amount']){
            $integral_data['user_id'] = $data['user_id'];
            $integral_data['content'] = $data['content'];
            $integral_data['integral'] = floor($data['pay_amount']/$i);
            $integral_data['type'] = $data['type'];
            $integral = new integral();
            $integral->insert($integral_data);
            $this->update_by_id(array('integral'=>($user_data['integral']?:0)-$integral_data['integral']),$data['user_id']);
        }

        
        // $user=pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$data['user_id']));
        if($user_data['isbuy']==1){
            $member_upgrade=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']),array('member_upgrade'));
            if($member_upgrade['member_upgrade']==1){
                // 减少用户消费额
                $this->update_by_id(array('amount'=>($user_data['amount']?:0) - $data['pay_amount']),$data['user_id']);

                $this->update_member_level($data['user_id']);
            }
        }else{
            // 减少用户消费额
            $this->update_by_id(array('amount'=>($user_data['amount']?:0) - $data['pay_amount']),$data['user_id']);

            $this->update_member_level($data['user_id']);
        }
    }

	public function update_member_level($id){
		$user_data = $this->get_data_by_id($id);

		$cardlevel = new cardlevel();
		$cardlevel_list = $cardlevel->query(array('amount <= '.$user_data['amount']),array(),array('amount desc'));

		$next_level = $cardlevel_list['data'][0];

		$curr_level = $cardlevel->get_data_by_id($user_data['level_id']);

		if ($next_level['amount'] > $curr_level['amount']) {
			$this->update_by_id(array('level_id'=>$next_level['id']),$id);
		}
	}
}