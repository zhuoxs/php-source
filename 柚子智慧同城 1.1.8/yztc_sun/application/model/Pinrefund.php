<?php
/**
 * User: YangXinlan
 * DateTime: 2019/1/19 17:49
 */
namespace app\model;

use think\cache\driver\Redis;
use think\Db;

class Pinrefund extends Base
{

    public function refundBalanceRecord($order){
        $refund=array(
            'uniacid'=>$order['uniacid'],
            'store_id'=>$order['store_id'],
            'order_id'=>$order['id'],
            'order_type'=>3,
            'refund_type'=>2,
            'order_refund_no'=>date("YmdHis") .rand(11111, 99999),
            'type'=>1,
            'refund_price'=>$order['order_amount'],
            'create_time'=>time(),
            'refund_status'=>1,
            'refund_time'=>time()
        );
        Db::name('orderrefund')->insert($refund);
        $remark="订单退款增加￥".$order['order_amount'];
        $Userbalancerecord=new Userbalancerecord();
        $Userbalancerecord->editBalance($order['user_id'],$order['order_amount']);
        $Userbalancerecord->addBalanceRecord($order['user_id'],$order['uniacid'],3,0,$order['order_amount'],$order['id'],$order['order_no'],$remark);
    }

    //余额退款
    public function refundBalance($orderinfo){
        $oid=$orderinfo['id'];
        //修改拼团订单
        Pinorder::update(['refund_status'=>2,'refund_time'=>time(),'after_sale'=>2],['id' => $oid]);
        //修改退款记录
        Pinrefund::update(['refund_status'=>2,'refund_time'=>time()],['order_id'=>$oid]);
        //修改公共订单
        (new Commonorder())->editCommonOrderStatus(4,$oid,51);
        //返回库存减销量
        $orderinfo=Pinorder::get($oid);
        //加库存
        $model=new Pingoods();
        $model->updateNum($orderinfo['goods_id'],$orderinfo['num'],$orderinfo['attr_ids']);
        $this->refundBalanceRecord($orderinfo);

    }
    //TODO::退款成功
    public function refundSuccess($oid,$xml=''){
        //修改拼团订单
        Pinorder::update(['refund_status'=>2,'refund_time'=>time(),'after_sale'=>2],['id' => $oid]);
        //修改退款记录
        Pinrefund::update(['refund_status'=>2,'refund_time'=>time(),'xml'=>$xml],['order_id'=>$oid]);
        //修改公共订单
        (new Commonorder())->editCommonOrderStatus(4,$oid,51);
        //返回库存减销量
        $orderinfo=Pinorder::get($oid);
        //加库存
        $model=new Pingoods();
        $model->updateNum($orderinfo['goods_id'],$orderinfo['num'],$orderinfo['attr_ids']);
    }
    //TODO::微信退款
    public function refundWechat($orderinfo){
        $xml=$this->getRefundXml($orderinfo);
        $data=xml2array($xml);
//        var_dump($data);exit;
        if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
            $this->refundSuccess($orderinfo['id'],$xml);
            return array('code'=>0, 'msg'=>'退款成功',);
        }else{
            //修改订单
            Pinorder::update(['refund_status'=>3,'refund_time'=>time(),'after_sale'=>0,'err_code_dec'=>$data['err_code_des']],['id' => $orderinfo['id']]);
            //修改退款记录
            Pinrefund::update(['refund_status'=>3,'refund_time'=>time(),'err_code'=>$data['err_code'],'err_code_dec'=>$data['err_code_des'],'xml'=>$xml],['order_id'=>$orderinfo['id']]);
            //修改公共订单
            (new Commonorder())->editCommonOrderStatus(2,$orderinfo['id'],52);
            return array('code'=>1, 'msg'=>'退款失败',);
        }
    }
    public function failRefundWechat($orderinfo){
        $xml=$this->getRefundXml($orderinfo);
        $data=xml2array($xml);
        if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
            $this->refundSuccess($orderinfo['id'],$xml);
            return array('code'=>0, 'msg'=>'退款成功',);
        }else{
            //修改订单
            Pinorder::update(['refund_status'=>3,'refund_time'=>time(),'after_sale'=>0,'err_code_dec'=>$data['err_code_des']],['id' => $orderinfo['id']]);
            //修改退款记录
            Pinrefund::update(['refund_status'=>3,'refund_time'=>time(),'err_code'=>$data['err_code'],'err_code_dec'=>$data['err_code_des'],'xml'=>$xml],['order_id'=>$orderinfo['id']]);
            //修改公共订单
            (new Commonorder())->editCommonOrderStatus(2,$orderinfo['id'],52);
//            return array('code'=>1, 'msg'=>'退款失败',);
        }
    }
    //TODO::获取微信退款报文信息
    private function getRefundXml($orderinfo){
        $system=Db::name('system')->where(array('uniacid'=>$orderinfo['uniacid']))->find();
        $data['appid'] =$system['appid'];
        $data['mch_id'] =$system['mchid'];
        $data['nonce_str']=createNoncestr();
        $data['out_trade_no']=$orderinfo['out_trade_no'];
        $data['out_refund_no']=$orderinfo['refund_no'];
        $data['total_fee']=intval($orderinfo['order_amount']*100);
        $data['refund_fee']=intval($orderinfo['order_amount']*100);
        $data['sign']=getSign($data,$system['wxkey']);
        $xml=postXmlCurl($data,$orderinfo['uniacid']);
        return $xml;
    }
    //TODO::拼团失败退款
    public function pinFailRefund($orderinfo){
        //增加退款记录
        $refund=array(
            'uniacid'=>$orderinfo['uniacid'],
            'store_id'=>$orderinfo['store_id'],
            'heads_id' => $orderinfo['heads_id'],
            'order_id'=>$orderinfo['id'],
            'refund_type'=>1,
            'order_refund_no'=>date("YmdHis") .rand(11111, 99999),
            'type'=>1,
            'refund_price'=>$orderinfo['order_amount'],
            'create_time'=>time(),
            'refund_status'=>0,
            'test'=>1,
        );
        $orderinfo['refund_no']=$refund['order_refund_no'];
        //增加退款记录
        $this->allowField(true)->save($refund);
        if($orderinfo['order_amount']>0){
            if($orderinfo['pay_type']==2){
                $this->refundBalance($orderinfo);
            }else{
                $this->failRefundWechat($orderinfo);
            }
        }else{
            $this->refundSuccess($orderinfo['id']);
        }
    }
}