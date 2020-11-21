<?php
class orderonline extends base{
	public $required_fields = array('user_id','amount','store_id','pay_amount','pay_type');

	public function insert($data){
		$data['time'] = time();

        //保存订单
        $res = parent::insert($data);
        if ($res['code']) {
            return $res;
        }

        //判断是否使用优惠券
        if ($data['coupon_id'] && $data['coupon_id'] != 'undefined'){
            $usercoupon = new usercoupon();
            $usercoupon->usecoupon($data['coupon_id']);
        }

//        保存待支付记录
        $payrecord = new payrecord();
        $payrecord_data = [];
        $payrecord_data['source_type'] = 'orderonline';
        $payrecord_data['source_id'] = $res['data'];
        $payrecord_data['pay_type'] = $data['pay_type'];
        $payrecord_data['pay_money'] = $data['pay_amount'];
        $payrecord_data['user_id'] = $data['user_id'];
        $ret = $payrecord->insert($payrecord_data);
        $res['paydata'] = $ret;

        return $res;
	}
//	订单完成
	public function finish($id){
        global $_W;
	    $data = [];
	    $data['pay_time'] = time();
	    $data['pay_state'] = 1;
	    $res = $this->update_by_id($data,$id);

//	    添加积分记录
	    $data = parent::get_data_by_id($id);
        $uniacid = $data['uniacid'];

	    $integral_data = [];
        $integral_data['user_id'] = $data['user_id'];
        $integral_data['pay_amount'] = $data['pay_amount'];
        $integral_data['type'] = 1;
        $user = new user();
        $user->add_integral($integral_data);

        $store = new store();
        $store_data = $store->get_data_by_id($data['store_id']);

        $phone=$this->SendSms($store_data['tel'],$uniacid);

        $task_model = new task();
//        添加钉钉推送任务
        $task_model->insert([
            'type' => 'sendDingtalk4OrderOnline',
            'value' => $id,
        ]);
//        添加模板消息任务
        $task_model->insert([
            'type' => 'sendTemplate4OrderOnline',
            'value' => $id,
        ]);

//        增加门店账单
        $bill_model = new storebill();
        $bill_model->insert([
            'content'=>'线上支付-收款',
            'time'=>time(),
            'type'=>1,
            'store_id'=>$data['store_id'],
            'balance'=>$data['pay_amount'],
        ]);



        return $res;
    }
    public function send_dingtalk($id){
        global $_W;
        $order_data = $this->get_data_by_id($id);

        $store = new store();
        $store_data = $store->get_data_by_id($order_data['store_id']);

        $user_model = new user();
        $user_data = $user_model->get_data_by_id($order_data['user_id']);

        $ding_msg = [
            'title'=>'线上买单:'.$order_data['amount'],
        ];
        $msg = "## 线上买单 [".$order_data['amount']."]\n\n";
        $msg .= "> 门店[**".$store_data['name']."**] \n\n";
        $msg .= "> 会员[**".$user_data['name']."**] \n\n";
        $msg .= "> 订单总额[".$order_data['amount']."] \n\n";
        $msg .= "> 下单时间[".date('Y-m-d H:i:s',($order_data['pay_time']?:time()))."] \n\n";
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

        $opt = array('线上支付', $order_data['amount'], $store_data['name'], date('Y-m-d H:i:s', time()));
        $ret = sendTemplate($system_data['appid'], $system_data['appsecret'], $user_data['openid'], $system_data['template_id_buy'], 'yzhyk_sun/pages/index/index',$formid_data['form_id'],$opt);
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