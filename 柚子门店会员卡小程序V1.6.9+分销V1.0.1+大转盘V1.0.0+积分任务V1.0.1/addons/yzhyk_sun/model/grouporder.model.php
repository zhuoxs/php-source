<?php
class grouporder extends base{
	public $required_fields = array();
	public $unique = array();

    public function insert($data){
        $goodses = $data['goodses'];
        unset($data['goodses']);
        $data['time'] = time();
        $data['order_number'] = date('Ymd').time().rand(1000,9999);

        foreach ($goodses as $goods) {
            $data['goods_id'] = $goods->id;
            $data['goods_name'] = $goods->title;
            $data['goods_price'] = $goods->price;
            $data['goods_img'] = $goods->src;
            $data['num'] = $goods->num;
            break;
        }

        $res = parent::insert($data);
        if ($res['code']) {
            return $res;
        }

        //判断是否使用优惠券、并切换优惠券状态
        if ($data['coupon_id'] && $data['coupon_id'] != 'undefined'){
            $usercoupon = new usercoupon();
            $usercoupon->usecoupon($data['coupon_id']);
        }
        return $res;
    }
    // 支付
    public function pay($data,$id){
        global $_W,$_GPC;
        $uniacid = $_W['uniacid'];
        $grouporder_data = parent::get_data_by_id($id);

//        用户支付
        $pay_data['pay_amount'] = $data['pay_amount'];
        $pay_data['pay_type'] = $data['pay_type'];
        $pay_data['amount'] = $grouporder_data['amount'];
        $pay_data['type'] = 6;
        $pay_data['user_id'] = $grouporder_data['user_id'];
        $user = new user();
        $res = $user->pay($pay_data);
        if ($res['code']) {
            return $res;
        }

//        判断是否团长，团长需要开团
        $group_id = $grouporder_data['group_id'];
        if(!$group_id){
//            门店团购商品 id
            $storegroupgoods = new storegroupgoods();
            $storegroupgoods_list = $storegroupgoods->query(array("store_id = {$grouporder_data['store_id']}","groupgoods_id = {$grouporder_data['goods_id']}"));
            $storegroupgoods_data = $storegroupgoods_list['data'][0];
            $group_data['storegroupgoods_id'] = $storegroupgoods_data['id'];
            $group_data['groupgoods_id'] = $storegroupgoods_data['groupgoods_id'];

            // 设置开团有效期
            $groupgoods = new groupgoods();
            $groupgoods_data = $groupgoods->get_data_by_id($storegroupgoods_data['groupgoods_id']);
            $group_data['end_time'] = strtotime($groupgoods_data['end_time']);
            $time = time() + $groupgoods_data['useful_hour']*3600;
            if ($groupgoods_data['useful_hour'] && $group_data['end_time']>$time) {
                $group_data['end_time']=$time;
            }
            $group_data['user_id']=$grouporder_data['user_id'];

//            保存团购
            $group = new group();
            $ret = $group->insert($group_data);
            $group_id = $ret['data'];
            $data['group_id'] = $group_id;
        }

//        修改订单状态
        $data['state'] = 20;
        $data['pay_time']=time();
        $res = $this->update_by_id($data,$id);

//        加入团购
        $groupuser = new groupuser();
        $groupuser_data = array();
        $groupuser_data['group_id'] = $group_id;
        $groupuser_data['user_id'] = $grouporder_data['user_id'];
        $ret = $groupuser->insert($groupuser_data);


        // 发送模板消息
        $system = new system();
        $system_data = $system->get_current();

        $user_data = $user->get_data_by_id($grouporder_data['user_id']);

        $store = new store();
        $store_data = $store->get_data_by_id($grouporder_data['store_id']);

        $formid = new formid();
        $formid_data = $formid->get_data_by_user_id($grouporder_data['user_id']);

        $opt = array('线上商城团购', $grouporder_data['amount'], $store_data['name'], date('Y-m-d H:i', time()));
        sendTemplate($system_data['appid'], $system_data['appsecret'], $user_data['openid'], $system_data['template_id_buy'], 'yzhyk_sun/pages/user/myorder/myorder',$formid_data['form_id'],$opt);

        $res['group_id']= $group_id;

        $condition = pdo_get('yzhyk_sun_distribution_set',array('uniacid'=>$uniacid),array("lower_condition"));
        if($condition['lower_condition']==1){
            // $openid = pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$data['user_id']))['openid'];
            $sql = "select sum(count) as count from (select count(id) as count from ".tablename('yzhyk_sun_order')." where uniacid= ".$uniacid." and state>10 and state != 50 and user_id='".$grouporder_data['user_id']."' union all select count(id) as count from ".tablename('yzhyk_sun_orderapp')." where uniacid= ".$uniacid." and state>10 and state != 40 and user_id='".$grouporder_data['user_id']."' union all select count(id) as count from ".tablename('yzhyk_sun_membercardrecord')." where uniacid= ".$uniacid." and user_id='".$grouporder_data['user_id']."') as a";
        
            $num = pdo_fetch($sql);//购买商品数

            if($num['count']==1){
                //获取用户信息
                $user1 = pdo_get('yzhyk_sun_user',array('uniacid'=>$uniacid,'user_id'=>$grouporder_data['user_id']));
                $data1["parents_id"] = $user1["spare_parents_id"];
                $data1["parents_name"] = $user1["spare_parents_name"];
                $res1 = pdo_update('yzhyk_sun_user', $data1, array('uniacid' => $_W['uniacid'],'user_id' => $grouporder_data['user_id']));
            }
        }
        return $res;
    }

    public function cancel($id){
        $grouporder_data = $this->get_data_by_id($id);
        $group_id = $grouporder_data['group_id'];

        $group = new group();
        $group_data = $group->get_data_by_id($group_id);

        // 判断是否团长
        if ($group_data['user_id'] != $grouporder_data['user_id']) {
            $groupuser = new groupuser();
            $groupuser->cancel(array('group_id'=>$group_id, 'user_id'=>$grouporder_data['user_id']));
            $ret = $this->update_by_id(array('state'=>50),$id);
            return array(
                'code'=>0,
                'group_id'=>$group_id
            );
        }else{
            $group->cancel($group_id);

//            $groupuser = new groupuser();
//            $groupuser->cancel(array('group_id'=>$group_id));

            $ret = $this->update(array('state'=> 50),array('group_id'=>$group_id));
            return array(
                'code'=>0,
                'group_id'=>$group_id
            );
        }
    }
    public function delete_app($id){
        $data['state'] = -10;
        $res = $this->update_by_id($data,$id);
        return $res;
    }
}