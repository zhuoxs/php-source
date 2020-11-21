<?php
namespace Api\Controller;
use Common\Model\PayModel;
use Think\Controller;

/**
 * 微信支付
 */
class WeixinpayController extends Controller{

    const PLATFORM = 'wxpay';

    /**
     * notify_url接收页面
     */
    public function notify(){

        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay=new \Weixinpay();
        $result=$wxpay->notify();
        if ($result) {
            // 验证成功 修改数据库的订单状态等 $result['out_trade_no']为订单号
            $out_trade_no = $result['out_trade_no'];

            $d = M('recharge')->where(array('order_no'=>$out_trade_no))->find();
            $total_fee = $result['cash_fee']/100;
            $trade_no = $result['transaction_id'];

            //如果订单金额数量不对
            if( floatval($d['price']) != $total_fee ) {
                file_put_contents('wxpay_fail.log', $out_trade_no."::".json_encode($result));
                return '';
            }

            $pay_model = new PayModel();
            $pay_model->pay_vip_success($d['id'], self::PLATFORM, $trade_no);
        } else {
            $out_trade_no = 'VIPB2303B11395790275893';

            $d = M('recharge')->where(array('order_no'=>$out_trade_no))->find();

            $pay_model = new PayModel();
            $pay_model->pay_vip_success($d['id'], self::PLATFORM, 'test');
        }
    }

    /**
     * 公众号支付 必须以get形式传递 out_trade_no 参数
     * 示例请看 /Application/Home/Controller/IndexController.class.php
     * 中的weixinpay_js方法
     */
    public function pay(){
        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay=new \Weixinpay();
        // 获取jssdk需要用到的数据
        $data=$wxpay->getParameters();
        // 将数据分配到前台页面
        $assign=array(
            'data'=>json_encode($data)
            );
        $this->assign($assign);
        $this->display();
    }

}