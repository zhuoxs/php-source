<?php
namespace Api\Controller;

use Common\Model\PayModel;
use Think\Controller;

/**
 * 支付宝
 */
class AlipayController extends Controller{

    const PLATFORM = 'alipay';

    /**
     * return_url接收页面
     */
    public function alipay_return(){

        // 引入支付宝
        vendor('Alipay.AlipayNotify','','.class.php');
        $config=$config=C('ALIPAY_CONFIG');
        $notify=new \AlipayNotify($config);
        // 验证支付数据
        $status=$notify->verifyReturn();
        if($status){//临时测试
            // 下面写验证通过的逻辑 比如说更改订单状态等等 $_GET['out_trade_no'] 为订单号；
            if( $_GET['is_success'] ) {
                //结算提成
                $out_trade_no = $_GET['out_trade_no'];

                $d = M('recharge')->where(array('order_no'=>$out_trade_no))->find();
                $total_fee = floatval($_GET['total_fee']);
                $trade_no = $_GET['trade_no'];

                //如果订单金额数量不对
                if( floatval($d['price']) != $total_fee ) {
                    file_put_contents('/Runtime/alipay_fail.log', json_encode($_GET));
                    return '';
                }

                $pay_model = new PayModel();
                $pay_model->pay_vip_success($d['id'], self::PLATFORM, $trade_no);

                $this->success('支付成功',U('Home/Member/index',array('id'=>$d['post_id'])));
            } else {
                file_put_contents('/Runtime/alipay.log', json_encode($_GET) . "/r/n", FILE_APPEND);
            }

        }else{
            echo "支付失败";
            exit;
        }
    }

    /**
     * notify_url接收页面
     */
    public function alipay_notify(){
        // 引入支付宝
        vendor('Alipay.AlipayNotify','','.class.php');
        $config=$config=C('ALIPAY_CONFIG');
        $alipayNotify = new \AlipayNotify($config);
        // 验证支付数据
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {
            echo "success";
            $out_trade_no = $_POST['out_trade_no'];
            $d = M('recharge')->where(array('order_no'=>$out_trade_no))->find();
            $total_fee = floatval($_POST['total_fee']);
            $trade_no = $_POST['trade_no'];

            //如果订单金额数量不对
            if( floatval($d['price']) != $total_fee ) {
                file_put_contents('/Runtime/alipay_fail.log', json_encode($_GET));
                return '';
            }

            $pay_model = new PayModel();
            $pay_model->pay_vip_success($d['id'], self::PLATFORM, $trade_no);

        }else {
            echo "fail";
        }
    }


}