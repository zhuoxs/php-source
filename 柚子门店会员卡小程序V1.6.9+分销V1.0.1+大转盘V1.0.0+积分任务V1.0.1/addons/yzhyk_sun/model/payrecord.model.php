<?php
class payrecord extends base{
	public $auto_create_time = true;
//	新增支付记录，并返回支付信息包
    public function insert($data){
        global $_W;
        $data['create_time'] = time();
        $data['no'] = date('YmdHis') . substr('' . time(), -4, 4);

        $ret = parent::insert($data);
        if ($ret['code']){
            throw new ZhyException('支付记录保存失败');
        }
            

//        余额支付
        if ($data['pay_type'] == '余额'){
            // var_dump($payrecord_data);

            //用户支付
//            $pay_data['amount'] = $data['amount'];
            $pay_data['pay_amount'] = $data['pay_money'];
            $pay_data['pay_type'] = $data['pay_type'];
            $pay_data['type'] = 1;
            $pay_data['user_id'] = $data['user_id'];
            // var_dump($pay_data);
            $user = new user();
            $res = $user->pay_balance($pay_data);
            
            if ($res['code']) {
                throw new ZhyException("支付失败");
            }
            // var_dump($ret['data']);die;
            $this->finish($ret['data']);

            $ret['paytype']=1;
        }else if ($data['pay_type'] == '微信'){
            $retdata=$ret['data'];
            // $this->finish($ret['data']);
//            微信支付
            include_once __DIR__.'/../wxpay.php';
//          用户id
            $user_model = new user();
            $user_data = $user_model->get_data_by_id($data['user_id']);
            $openid = $user_data['openid'];

//          商户信息
            $system_model = new system();
            $system_data = $system_model->get_current();
            $appid = $system_data['appid'];
            $mch_id = $system_data['mchid'];
            $key = $system_data['wxkey'];
            // var_dump($data['pay_money']);
//          支付信息
            $total_fee = $data['pay_money']*100;
            // $total_fee =0.01*100;
            $body = '支付';
            $out_trade_no = $data['no'];

            // var_dump($ret['data']);die;

            if($data['source_type']=='order'){
                pdo_update('yzhyk_sun_order',array('out_trade_no'=>$out_trade_no),array('uniacid'=>$_W['uniacid'],'id'=>$data['source_id']));

            }
//          回调信息
            $attach = json_encode([//回调参数
                'payrecord_id'=>$ret['data'],
            ]);
            $notify_url = $_W['siteroot'].'addons/yzhyk_sun/notify.php';//回调地址

            $wxpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);
            $ret = $wxpay->pay();
            $ret['url'] = $notify_url;
            $ret['integralid']=$retdata;
            $ret['out_trade_no']=$out_trade_no;

            // var_dump($wxpay);
            // $this->finish($retdata);
            $ret['paytype']=2;
            

            // // 余额账单
            // $bill_data['type']  = 1;
            // $bill_data['user_id'] = $data['user_id'];
            // $bill_data['balance'] = $data['pay_money'];
            // $bill_data['content'] = '线下订单、线上支付';
            // $bill = new bill();
            // $bill->insert($bill_data);

        }
        // $this->finish($ret['data']);
        return $ret;
    }
//    支付完成
    public function finish($id){
        $data = $this->get_data_by_id($id);
        // var_dump($data);die;
        switch ($data['source_type']){
            case 'orderonline':
                $order = new orderonline();
                $order->finish($data['source_id']);
                break;
            case 'order':
                $order = new order();
                $order->finish($data['source_id']);
                break;
            case 'orderapp':
                $order = new orderapp();
                $order->finish($data['source_id']);
                break;
        }

        

        $update_data = array();
        $update_data['pay_time'] = time();
        return $this->update_by_id($update_data,$id);
    }
}