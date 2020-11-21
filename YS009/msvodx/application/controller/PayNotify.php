<?php
/**
 * MsvodX支付通知处理逻辑
 * @Author: $dreamer
 * @Date:   2017/12/28
 */

namespace app\controller;

use systemPay\aliPay;
use systemPay\wxPay;
use systemPay\paypal;
use think\Request;
use app\model\Order as Order;

class PayNotify
{

    /**
     * 码支付通知处理
     * @param Request $request
     */
    function codepayNotify(Request $request)
    {
        #header('Content-type:text/html;charset=utf8'); 加上这句后codepay监测软件会出错  by $dreamer
        @file_put_contents('../logs/codepay_notify.log', "\r\n" . date('Y-m-d H:i:s') . str_repeat('===', 30) . "\r\n" . var_export($request->param(), 1), FILE_APPEND);

        $notifyData = $request->post();

        /*
        $notifyData=array (//模拟数据
          'app_time' => '1515127780',
          'chart' => 'utf-8',
          'id' => '18709',
          'money' => '0.01',
          'order_id' => '18709',
          'pay_id' => '2018010509574458116',
          'pay_no' => '20180105200040011100540086842664',
          'pay_time' => '1515117471',
          'price' => '0.01',
          'status' => '1',
          'tag' => '0',
          'trueID' => '18709',
          'type' => '1',
          'version' => '4.350',
          'sign' => '1d7215bd32aa207c507510be7acdcea0',
        );
        */

        $codepayer = new \systemPay\codePay();
        if ($codepayer->verifyNotifyData($notifyData)) {
            $updateRs = Order::updateOrder($notifyData['pay_id'], $notifyData['money'],isset($notifyData['param'])?$notifyData['param']:0);

            if (is_array($updateRs) && isset($updateRs['result']) && $updateRs['result'] == 0) {
                ob_clean();
                exit('success');
            } else {
                exit($updateRs['msg']);
            }
        } else {
            exit('密钥验证失败');
        }
    }


    /** 支付宝支付通知 */
    function alipayNotify(Request $request)
    {
        $alipayer = new aliPay();
        if ($alipayer->verify($request->param())) {
            $updateRs = Order::updateOrder($request->param('out_trade_no'), $request->param('total_amount'));
            if (is_array($updateRs) && isset($updateRs['result']) && $updateRs['result'] == 0) {
                ob_clean();
                exit('success');
            } else {
                exit($updateRs['msg']);
            }
        } else {
            exit('数据验证失败');
        }
    }

    /** 微信支付通知 */
    function wxpayNotify(){
        $wxpayer=new wxPay();
        if(is_array($notifyData=$wxpayer->verify())){
            $updateRs = Order::updateOrder($notifyData['out_trade_no'], $notifyData['total_fee']);
            if (is_array($updateRs) && isset($updateRs['result']) && $updateRs['result'] == 0) {
                ob_clean();
                exit('success');
            } else {
                exit($updateRs['msg']);
            }
        }else{
            exit('数据验证失败');
        }
    }

    /** paypal支付通知 */
    function paypalNotify(Request $request){
        $data = $request->param();
        //$str = 'mc_gross=0.02&invoice=2018051016144332193&protection_eligibility=Eligible&address_status=confirmed&payer_id=H3R6DF4QP7P5L&address_street=NO+1+Nan+Jin+Road&payment_date=02%3A35%3A56+May+10%2C+2018+PDT&payment_status=Completed&charset=gb2312&address_zip=200000&first_name=feng&mc_fee=0.02&address_country_code=CN&address_name=rusheng+feng&notify_version=3.9&custom=&payer_status=unverified&business=280360721-facilitator%40qq.com&address_country=China&address_city=Shanghai&quantity=1&verify_sign=A6gZzLobrdwg9V2Rjfr3KKJ0eG5qANP88sI8VWcnY6-xHCcBvbAFMOnA&payer_email=280360721%40qq.com&txn_id=06M03442UH9653718&payment_type=instant&last_name=rusheng&address_state=Shanghai&receiver_email=280360721-facilitator%40qq.com&payment_fee=0.02&receiver_id=TAKGP8TVWJLJE&txn_type=web_accept&item_name=%B9%BA%C2%F2VIP%2F%B3%E4%D6%B5%BD%F0%B1%D2&mc_currency=USD&item_number=1&residence_country=CN&test_ipn=1&transaction_subject=&payment_gross=0.02&ipn_track_id=a891b67dad2c';
        //parse_str($str,$data);
        $paypals=new paypal();
        if ($paypals->verify($data)) {
            $updateRs = Order::updateOrder($data['invoice'], $data['mc_gross']);
            if (is_array($updateRs) && isset($updateRs['result']) && $updateRs['result'] == 0) {
                ob_clean();
                exit('success');
            } else {
                exit($updateRs['msg']);
            }
        }else{
            exit('数据验证失败');
        }
    }

}