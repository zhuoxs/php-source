<?php
namespace Api\Controller;

use Common\Model\PayModel;
use Think\Controller;

/**
 *  彩虹易支付
 */
class YipayController extends Controller{

    const UID = "126729";//"此处填写Yipay的uid";
    const TOKEN = "E5D6B9048E09AE1D6206753EC071AF4D";//"此处填写Yipay的Token";
    const POST_URL = "http://pay.hackwl.cn/";

    public function pay(){
        $order_no = I('get.order_no');
        $type = I('get.payment_type')=='alipay' ? 'alipay' : 'wxpay';
        $recharge = M('recharge')->where(array('order_no'=>$order_no))->find();

        $goodsname = "充值VIP";
        $notify_url = U('Yipay_notify','','',true);
        $return_url = U('Yipay_return','','',true);
 
		$orderid = $order_no;
        $orderuid = $recharge['member_id'];
        $price = $recharge['price'];

      
      	$alipay_config = array();
		$alipay_config['partner']		= self::UID;
		$alipay_config['key']			= self::TOKEN;
		$alipay_config['sign_type']    = strtoupper('MD5');
		$alipay_config['input_charset']= strtolower('utf-8');
		$alipay_config['transport']    = 'http';
		$alipay_config['apiurl']    =  self::POST_URL;
      
		require_once(dirname(__FILE__)."/ep/epay_submit.class.php");
		
		$parameter = array
		(
				"pid" => self::UID ,
				"type" => $type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"out_trade_no"	=> $order_no,
				"name"	=> $orderid,
				"money"	=> $price,
				"sign_type"	=> "MD5",
				#"sitename"	=> $orderid
		);
		//建立请求
		$alipaySubmit = new \AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter);
		echo $html_text;
		
		exit;
		

        
    }


    /**
     * return_url接收页面
     */
    public function Yipay_return()
    {
        $this->display();
    }

    /**
     * notify_url接收页面
     */
    public function Yipay_notify()
    {

      	error_reporting( 0 );
      	$alipay_config = array();
		$alipay_config['partner']		= self::UID;
		$alipay_config['key']			= self::TOKEN;
		$alipay_config['sign_type']    = strtoupper('MD5');
		$alipay_config['input_charset']= strtolower('utf-8');
		$alipay_config['transport']    = 'http';
		$alipay_config['apiurl']    =  self::POST_URL;
      	require_once(dirname(__FILE__)."/ep/epay_notify.class.php");
        //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) 
        {
            $out_trade_no = $_GET['out_trade_no'];
            $trade_no = $_GET['trade_no'];
            $trade_status = $_GET['trade_status'];
            $type = $_GET['type'];
            if ($_GET['trade_status'] == 'TRADE_SUCCESS') 
            {
              	  $d = M('recharge')->where(array('order_no'=>$out_trade_no))->find();
                 
                  $pay_model = new PayModel();
                  $pay_model->pay_vip_success( $d['id'], $d['payment_type'], $trade_no );
            }
        }
      	echo 'success';
        exit;
      
       
    }


}