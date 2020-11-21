<?php
namespace Api\Controller;

use Common\Model\PayModel;
use Think\Controller;

/**
 * Paysapi个人免签
 */
class PaysapiController extends Controller{

    const UID = "898f93eba4aa9bfedd798c60";//"此处填写PaysApi的uid";
    const TOKEN = "1f29849e5a9c877e6dab0bb2f2766f91";//"此处填写PaysApi的Token";
    const POST_URL = "https://pay.bbbapi.com/";

    public function pay(){
        $order_no = I('get.order_no');
        $istype = I('get.payment_type')=='alipay' ? 1 :2;
        $recharge = M('recharge')->where(array('order_no'=>$order_no))->find();

        $goodsname = "充值VIP";
        $notify_url = U('paysapi_notify','','',true);
        $return_url = U('paysapi_return','','',true);
        $orderid = $order_no;
        $orderuid = $recharge['member_id'];
        $price = $recharge['price'];

        $key = md5($goodsname. $istype . $notify_url . $orderid . $orderuid . $price . $return_url . self::TOKEN . self::UID);

        $data = array(
            'goodsname'=>$goodsname,
            'istype'=>$istype,
            'key'=>$key,
            'notify_url'=>$notify_url,
            'orderid'=>$orderid,
            'orderuid'=>$orderuid,
            'price'=>$price,
            'return_url'=>$return_url,
            'uid'=>self::UID
        );
        $this->assign('data',$data);
        $this->assign('post_url',self::POST_URL);
        $this->display();
    }


    /**
     * return_url接收页面
     */
    public function paysapi_return(){
        $this->display();
    }

    /**
     * notify_url接收页面
     */
    public function paysapi_notify(){

        $paysapi_id = $_POST["paysapi_id"];
        $orderid = $_POST["orderid"];
        $price = $_POST["price"];
        $realprice = $_POST["realprice"];
        $orderuid = $_POST["orderuid"];
        $key = $_POST["key"];

        //校验传入的参数是否格式正确，略

        $token = self::TOKEN;

        $temps = md5($orderid . $orderuid . $paysapi_id . $price . $realprice . $token);

        if ($temps != $key){
            return jsonError("key值不匹配");
        }else{
            //校验key成功
            $out_trade_no = $orderid;
            $d = M('recharge')->where(array('order_no'=>$out_trade_no))->find();
            $trade_no = $paysapi_id;
            $pay_model = new PayModel();
            $pay_model->pay_vip_success($d['id'], $d['payment_type'], $trade_no);
        }
    }


}