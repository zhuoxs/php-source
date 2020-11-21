<?php
class orderapp extends base{
	public $required_fields = array('user_id','amount','store_id');
    public $relations = array(
        array(
            'as'=>'t2',
            'table'=>'user',
            'on'=>array(
                'id'=>'user_id',
            ),
            'columns'=>array(
                'name'=>'user_name',
            ),
        ),
        array(
            'as'=>'t3',
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
        global $_W;
        
	    //补充订单信息
        $new_goods['goods_id'] = $data['goods_id'];
        $new_goods['goods_price'] = $data['goods_price'];
        $new_goods['num'] = $data['num'];
        $new_goods['goods_name'] = $data['goods_name'];
        $new_goods['goods_img'] = $data['goods_img'];
        
        unset($data['goods_id']);
        unset($data['goods_price']);
        unset($data['num']);
        unset($data['goods_name']);
        unset($data['goods_img']);


		$data['time'] = $data['time']?:time();
		$data['order_number'] = date('Ymd').time().rand(1000,9999);
		$res = parent::insert($data);
		$data['id'] = $res['data'];
        // var_dump($data);
		//判断是否使用优惠券、并修改优惠券使用状态
		if ($data['coupon_id'] && $data['coupon_id'] != 'undefined'){
            $usercoupon = new usercoupon();
            $usercoupon->usecoupon($data['coupon_id']);
        }

        //保存订单商品
        $ordergoods = new orderappgoods();
        $new_goods['order_id'] = $res['data'];
        $new_goods['order'] = $data;
        $ordergoods->insert($new_goods);


        //        保存待支付记录
        $payrecord = new payrecord();
        $payrecord_data = [];
        $payrecord_data['source_type'] = 'orderapp';
        $payrecord_data['source_id'] = $res['data'];
        $payrecord_data['pay_type'] = $data['pay_type'];
        $payrecord_data['pay_money'] = $data['pay_amount'];
        $payrecord_data['user_id'] = $data['user_id'];
        $ret = $payrecord->insert($payrecord_data);

        $res['paydata'] = $ret;

        $order=pdo_get('yzhyk_sun_orderapp',array('uniacid'=>$_W['uniacid'],'id'=>$res['data']));
        if($order['pay_type']=='余额'){
            $distributionset = pdo_get('yzhyk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array("is_offline"));
            if($distributionset['is_offline']==1){
                $is_offline=1;
            }
        }else{
            $is_offline=1;
        }
        // var_dump($is_offline);
        if($is_offline==1){
            //========计算分销佣金 S===========
            include_once IA_ROOT . '/addons/yzhyk_sun/inc/func/distribution.php';
            $distribution = new Distribution();
            $distribution->order_id = $order['id'];
            $distribution->money = $order['pay_amount'];
            $distribution->userid = pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$order['user_id']))['openid'];
            $distribution->ordertype = 4;
            $distribution->computecommission();
            
        }
        
		return $res;
	}

	public function pay($data,$id){
	    $order_data = $this->get_data_by_id($id);
        //        保存待支付记录
        $payrecord = new payrecord();
        $payrecord_data = [];
        $payrecord_data['source_type'] = 'orderapp';
        $payrecord_data['source_id'] = $id;
        $payrecord_data['pay_type'] = $data['pay_type'];
        $payrecord_data['pay_money'] = $data['pay_amount'];
        $payrecord_data['user_id'] = $order_data['user_id'];
        $ret = $payrecord->insert($payrecord_data);

        $res = [];
        $res['paydata'] = $ret;
        // var_dump($ret);
        // $res['paydata']['code']=0;

        return $res;
    }
    //删除
	public function delete($id){
		$data['state'] = -10;
		return $this->update_by_id($data,$id);
	}


	// 通过 id 获取数据
	public function get_data_by_id($id = 0){
		$info = parent::get_data_by_id($id);
		$info['time'] = date('Y-m-d H:i:s',$info['time']);

		$store = new store();
		$store_data = $store->get_data_by_id($info['store_id']);
		$info['store_name'] = $store_data['name'];
		$info['tel'] = $store_data['tel'];
		$info['store_address'] = $store_data['address'];

		$ordergoods = new orderappgoods();
		$goodses = $ordergoods->query(array('order_id = '.$id));
		if (!$goodses['data']){
		    return null;
        }
		$info['goodses'] = $goodses['data'];
		return $info;
	}

    //	订单完成
    public function finish($id){
        global $_W,$_GPC;
        // $uniacid = $_W['uniacid'];
        //修改订单状态
        $data = [];
        $data['state'] = 20;
        $data['pay_time']=time();
        $res = $this->update_by_id($data,$id);

//	    添加积分记录
        $data = parent::get_data_by_id($id);
        $uniacid = $data['uniacid'];

        // var_dump($data);die;
        $integral_data = [];
        $integral_data['user_id'] = $data['user_id'];
        $integral_data['pay_amount'] = $data['pay_amount'];
        $integral_data['type'] = 7;
        $user = new user();
        $user->add_integral($integral_data);

        $store = new store();
        $store_data = $store->get_data_by_id($data['store_id']);

        $phone=$this->SendSms($store_data['tel'],$uniacid);

        $task_model = new task();
//        添加飞鹅打印任务
        $task_model->insert([
            'type' => 'fePrint4Orderapp',
            'value' => $id,
        ]);
//        添加钉钉推送任务
        $task_model->insert([
            'type' => 'sendDingtalk4Orderapp',
            'value' => $id,
        ]);
//        添加模板消息任务
        $task_model->insert([
            'type' => 'sendTemplate4Orderapp',
            'value' => $id,
        ]);

        //        增加门店账单
        $bill_model = new storebill();
        $bill_model->insert([
            'content'=>'预约订单-收款',
            'time'=>time(),
            'type'=>7,
            'store_id'=>$data['store_id'],
            'balance'=>$data['pay_amount'],
        ]);

        $condition = pdo_get('yzhyk_sun_distribution_set',array('uniacid'=>$uniacid),array("lower_condition"));
        if($condition['lower_condition']==1){
            // $openid = pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$data['user_id']))['openid'];
            $sql = "select sum(count) as count from (select count(id) as count from ".tablename('yzhyk_sun_order')." where uniacid= ".$uniacid." and state>10 and state != 50 and user_id='".$data['user_id']."' union all select count(id) as count from ".tablename('yzhyk_sun_orderapp')." where uniacid= ".$uniacid." and state>10 and state != 40 and user_id='".$data['user_id']."' union all select count(id) as count from ".tablename('yzhyk_sun_membercardrecord')." where uniacid= ".$uniacid." and user_id='".$data['user_id']."') as a";
        
            $num = pdo_fetch($sql);//购买商品数

            if($num['count']==1){
                //获取用户信息
                $user1 = pdo_get('yzhyk_sun_user',array('uniacid'=>$uniacid,'user_id'=>$data['user_id']));
                $data1["parents_id"] = $user1["spare_parents_id"];
                $data1["parents_name"] = $user1["spare_parents_name"];
                $res1 = pdo_update('yzhyk_sun_user', $data1, array('uniacid' => $uniacid,'user_id' => $data['user_id']));
            }
        }

        return $res;
    }

	public function cancel($id){
		$data['state'] = 40;
		return $this->update_by_id($data,$id);
	}

	public function confirm($id){
		$data['state'] = 30;
		return $this->update_by_id($data,$id);
	}

	public function fe_print($id){
        include_once __DIR__.'/../class/Feie.php';
        $store = new store();
        $user = new user();

        // function getMoney($money,$len = 7,$num = 2){
        //     $money = sprintf("%.{$num}f",$money);
        //     for ($i = 1;$i<= $len;$i++){
        //         $money = ' '.$money;
        //     }
        //     return substr($money,-1*$len);
        // }
        // function getName($name,$len = 6){
        //     if(strlen($name)>= $len*3){
        //         return $name;
        //     }

        //     for ($i = 1;$i<= $len;$i++){
        //         $name .= '　';
        //     }
        //     return substr($name,0,$len*3);
        // }
        if (!function_exists('getMoney')) {
            function getMoney($money,$len = 7,$num = 2){
                $money = sprintf("%.{$num}f",$money);
                for ($i = 1;$i<= $len;$i++){
                    $money = ' '.$money;
                }
                return substr($money,-1*$len);
            }
        }
        
        if (!function_exists('getName')) {
            function getName($name,$len = 6){
                if(strlen($name)>= $len*3){
                    return $name;
                }

                for ($i = 1;$i<= $len;$i++){
                    $name .= '　';
                }
                return substr($name,0,$len*3);
            }
        }

        $order_data = $this->get_data_by_id($id);
        if (!$order_data){
            return ['code'=>1];
        }
        $store_data = $store->get_data_by_id($order_data['store_id']);
        $user_data = $user->get_data_by_id($order_data['user_id']);

        if (!$store_data['feie_user']){
            return ['code'=>1,'msg'=>'商家没有设置飞鹅打印信息'];
        }

        $feie = new Feie($store_data['feie_user'],$store_data['feie_ukey'],$store_data['feie_sn']);
//            $feie = new Feie('1020526528@qq.com','jJWJu6rSIv2dsBun','918513936');

        $print_info = "";
        // $print_info .= '<CB>打印测试</CB><BR>';
//            自提
        // if ($order_data['distribution_type'] == 1){
            $print_info .= '<CB>门店自提单</CB><BR>';
            $print_info .= '提货人：'.$user_data['name'].'<BR>';
            $print_info .= '联系电话：'.$order_data['take_tel'].'<BR>';
            $print_info .= '提货时间：'.$order_data['take_time'].'<BR>';
        // }else{
        //     //门店配送
        //     $print_info .= '<CB>门店配送单</CB><BR>';
        //     $print_info .= '收货人：'.$user_data['name'].'<BR>';
        //     $print_info .= '联系电话：'.$user_data['tel'].'<BR>';
        //     $print_info .= '地址：'.$order_data['province'].$order_data['city'].$order_data['county'].'<BR>';
        //     $print_info .= $order_data['address'].'<BR>';
        // }
        $print_info .= '<BR>名称　　　　　 <RIGHT>单价 数量  金额</RIGHT>';
        $print_info .= '--------------------------------<BR>';
        foreach ($order_data['goodses'] as $goods) {
            $print_info .= $goods['goods_name'].'<BR>'
                .'<RIGHT>'
                .getMoney($goods['goods_price'])
                .getMoney($goods['num'],4,0)
                .getMoney($goods['goods_price']*$goods['num'])
                .'</RIGHT><BR>';
        }
        $print_info .= '--------------------------------<BR>';
        $print_info .= '合计：'.$order_data['amount'].'<BR>';
        $print_info .= '单号：'.$order_data['order_number'].'<BR>';
        $print_info .= '日期：'.date("Y-m-d H:i:s",strtotime($order_data['time'])).'<BR>';
        $ret = $feie->print_fe($print_info);
        return $ret;
    }

    public function send_dingtalk($id){
        global $_W;
        $order_data = $this->get_data_by_id($id);

        $store = new store();
        $store_data = $store->get_data_by_id($order_data['store_id']);

        $ding_msg = [
            'title'=>'您的商城收到一条新订单',
        ];
        $msg = "## 商城订单 \n\n";
        $msg .= "> 门店[**".$store_data['name']."**] \n\n";
        $msg .= "> 订单号[**".$order_data['order_number']."**] \n\n";
        $msg .= "> 订单总额[".$order_data['amount']."] \n\n";
        $msg .= "> 下单时间[".date('Y-m-d H:i:s',($order_data['pay_time']?:time()))."] \n\n";
        $msg .= "###### 请[登录后台]({$_W['siteroot']}/addons/yzhyk_sun/admin/index.php?c=site&a=entry&op=display&do=orderapp&m=yzhyk_sun)处理订单";
        $ding_msg['text'] = $msg;

        $ret = sendDingTalk($store_data['dingtalk_token'],$ding_msg);
        $ret = json_decode($ret);
        if ($ret->errcode){
            return false;
        }
        return true;
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

        $opt = array('商城预约订单', $order_data['amount'], $store_data['name'], date('Y-m-d H:i:s', time()));
        $ret = sendTemplate($system_data['appid'], $system_data['appsecret'], $user_data['openid'], $system_data['template_id_buy'], 'yzhyk_sun/pages/user/apporder/apporder',$formid_data['form_id'],$opt);
        if (is_string($ret)){
            $ret = json_decode($ret,true);
        }
        if ($ret['errcode']){
            return false;
        }
        return true;
    }
    //本页面调用发送短信
    public function SendSms($phone,$uniacid){
        global $_W, $_GPC;

        $sms=pdo_get('yzhyk_sun_sms',array('uniacid'=>$uniacid));


        if($sms){
            if($sms["is_open"]==1){
                if($sms["smstype"]==1){//253
                    $msg = $sms['ytx_order'];
                    if($num!=''){
                        $this->SendYtxSms($msg,$sms,$phone);
                    }
                }elseif($sms["smstype"]==3){//阿里大鱼
                    include_once IA_ROOT . '/addons/yzhyk_sun/api/aliyun-dysms/sendSms.php';
                    set_time_limit(0);
                    header('Content-Type: text/plain; charset=utf-8');
                    $sendid = $sms['aly_order'];
                    // logging_run(json_encode($phone), 'trace','test333' );

                    if($sendid!=""){
                        $return = sendSms($sms["aly_accesskeyid"], $sms["aly_accesskeysecret"],$phone, $sms["aly_sign"],$sendid);
                        // echo json_encode($return);
                    }
                }
            }
        }
    }
    //253云通信
    public function SendYtxSms($sendid='',$sms=array(),$mobile=''){
        global $_W, $_GPC;
        $postArr = array (
            'account'  => $sms["ytx_apiaccount"],
            'password' => $sms["ytx_apipass"],
            'msg' => $sendid,
            'phone' => $mobile,
            'report' => 'true'
        );
        //echo json_encode($sms["ytx_apiurl"]);exit;
        $url = "http://smssh1.253.com/msg/send/json";
        $result = $this->curlPost($url, $postArr);
        echo $result;
    }
    private function curlPost($url,$postFields){
        $postFields = json_encode($postFields);
        
        $ch = curl_init ();
        curl_setopt( $ch, CURLOPT_URL, $url ); 
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
            )
        );
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); 
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt( $ch, CURLOPT_TIMEOUT,60); 
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec ( $ch );
        if (false == $ret) {
            $result = curl_error(  $ch);
        } else {
            $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "请求状态 ". $rsp . " " . curl_error($ch);
            } else {
                $result = $ret;
            }
        }
        curl_close ( $ch );
        return $result;
    }

}