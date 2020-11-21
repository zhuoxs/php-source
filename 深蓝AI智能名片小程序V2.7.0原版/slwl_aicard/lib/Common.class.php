<?php

class Common{
    public static function get_app_info($uniacid) {
        $account = uni_fetch($uniacid);
        // $account = $_W['uniaccount'];

        $account_setting = pdo_get('uni_settings', array ('uniacid' => $uniacid));
        $payment = iunserializer($account_setting['payment']);

        $res = array();
        $res['appid'] = @$account['key'];
        $res['secret'] = @$account['secret'];
        $res['mchid'] = @$payment['wechat']['mchid']; // 商户ID
        $res['signkey'] = @$payment['wechat']['signkey']; // 商户KEY

        return $res;
    }

    // 开始支付
    public static function run_pay($openid, $good_name, $money) {
        require_once MODULE_ROOT . "/lib/wxpay/WxPay.Api.php";
        require_once MODULE_ROOT . "/lib/wxpay/WxPay.JsApiPay.php";

        // 统一下单
        $tools = new JsApiPay();
        $input = new WxPayUnifiedOrder();

        $input->SetBody("$good_name"); //设置商品或支付单简要描述
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis")); // 调用成功后的微信支付订单ID
        $input->SetTotal_fee("$money"); // money
        // $input->SetGoods_tag($act['post_title']); // 商品标记
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openid);
        $order = WxPayApi::unifiedOrder($input);

        if (!(empty($order)) && $order['return_code'] == 'SUCCESS') {
            $rs = array(
                'return_code' =>'SUCCESS',
                'return_msg'=>@$tools->GetJsApiParameters($order),
            );
            return $rs;
        } else {
            // return var_dump($order);
            $rs = array(
                'return_code' =>'ERROR',
                'return_msg'=>$order['return_msg'],
            );
            return $rs;
        }

        // return @$tools->GetJsApiParameters($order);
    }
}

?>