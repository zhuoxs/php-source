<?php
namespace app\model;

use app\base\model\Base;
use think\Db;
use wx\Refund;

class Pinrefund extends Base
{
    /**
     * 退款
     */
    public function refund($oid){
        $orderinfo = Pinorder::get($oid);
        if($orderinfo['is_pay']==1){
            if($orderinfo['pay_type']==1){
                //微信支付退款
                $this->wxRefund($orderinfo);
            }elseif ($orderinfo['pay_type']==2){
                //余额支付退回
                $this->balanceRefund($orderinfo);
            }
        }

    }
    //余额退款
    private function balanceRefund($order)
    {
        $refund = array(
            'uniacid' => $order['uniacid'],
            'store_id' => $order['store_id'],
            'heads_id' => $order['heads_id'],
            'oid' => $order['id'],
            'refund_type' => 2,
            'order_refund_no' => date("YmdHis") . rand(11111, 99999),
            'type' => 1,
            'refund_price' => $order['order_amount'],
            'create_time' => time(),
            'refund_status' => 1,
            'refund_time' => time()
        );
        //增加退款记录
        $this->allowField(true)->save($refund);
        //修改用户金额和增加用户余额变动记录
        $remark = "拼团订单退款增加￥" . $order['order_amount'];
        $Userbalancerecord = new Userbalancerecord();
        $Userbalancerecord->addBalanceRecord($order['user_id'], $order['uniacid'], 7, 0, $order['order_amount'], $order['id'], $order['order_num'], $remark);
        $pinorder = Pinorder::get($order['id']);
        $pinorder->save(['order_status' => 6, 'is_refund' => 1, 'refund_time' => time(), 'refund_num' => $refund['order_refund_no']]);
    }
    //微信退款
    private function wxRefund($order){
        global $_W;
        //增加退款记录
        $refund=array(
            'uniacid'=>$order['uniacid'],
            'store_id'=>$order['store_id'],
            'heads_id' => $order['heads_id'],
            'oid'=>$order['id'],
            'refund_type'=>1,
            'order_refund_no'=>date("YmdHis") .rand(11111, 99999),
            'type'=>1,
            'refund_price'=>$order['order_amount'],
            'create_time'=>time(),
            'refund_status'=>0,
        );
        //增加退款记录
        $this->allowField(true)->save($refund);
        $refund_id=$this->id;


        $xml=$this->getRefundXml($order,$refund['order_refund_no']); 
        // $system=Db::name('system')->where(array('uniacid'=>$order['uniacid']))->find();
        // $certpath = IA_ROOT . '/addons/sqtg_sun/cert/apiclient_cert_'.$_W['uniacid'].'.pem';
        // $keypath = IA_ROOT . '/addons/sqtg_sun/cert/apiclient_key_'.$_W['uniacid'].'.pem';
        // $refund_model = new Refund(
        //             $system['appid'],$system['mchid'],$system['wxkey']
        //             ,$order['out_trade_no'],$refund['order_refund_no']
        //             ,sprintf("%.0f",$order['order_amount']*100),sprintf("%.0f",$order['order_amount']*100)
        //             ,$certpath,$keypath);

        // $ret = $refund_model->run();
        

        Db::name("baowen")->insert(["xml"=> $xml, 'out_trade_no'=>$refund['order_refund_no']]); 
        $data=xml2array($xml); 
        Db::name("baowen")->insert(["xml"=>'我是测试', 'out_trade_no'=>87]);
        if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
            $this->save(['refund_status'=>1,'refund_time'=>time(),'xml'=>$xml],['id'=>$refund_id]);
//            Pinorder::update(['order_status' => 6, 'is_refund' => 1, 'refund_time' => time(), 'refund_num' => $refund['order_refund_no']], ['id' => $order['id']]);
            $pinorder = Pinorder::get($order['id']);
            $pinorder->save(['order_status' => 6, 'is_refund' => 1, 'refund_time' => time(), 'refund_num' => $refund['order_refund_no']]);
        }else{
            $this->save(['refund_status'=>2,'err_code'=>$data['err_code'],'err_code_dec'=>$data['err_code_des'],'xml'=>$xml],['id'=>$refund_id]);
//            Pinorder::update(['order_status' => 7, 'is_refund' => 0, 'refund_time' => time(), 'refund_num' => $refund['order_refund_no']], ['id' => $order['id']]);
            $pinorder = Pinorder::get($order['id']);
            $pinorder->save(['order_status' => 7, 'is_refund' => 0, 'refund_time' => time(), 'refund_num' => $refund['order_refund_no']]);

        }

    }
    //获取微信退款报文信息
    private function getRefundXml($order,$out_refund_no){
        $system=Db::name('system')->where(array('uniacid'=>$order['uniacid']))->find();
        $data['appid'] =$system['appid'];
        $data['mch_id'] =$system['mchid'];
        $data['nonce_str']=createNoncestr();
        $data['out_trade_no']=$order['out_trade_no'];
        $data['out_refund_no']=$out_refund_no;
        $data['total_fee']=sprintf("%.0f",$order['order_amount']*100);
        $data['refund_fee']=sprintf("%.0f",$order['order_amount']*100);
        $data['sign']=getSign($data,$system['wxkey']);
        $xml=postXmlCurl($data,$order['uniacid']);
        return $xml;
    }
}