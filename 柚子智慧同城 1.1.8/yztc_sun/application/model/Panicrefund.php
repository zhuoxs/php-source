<?php
/**
 * User: YangXinlan
 * DateTime: 2019/1/19 17:49
 */
namespace app\model;

use think\cache\driver\Redis;
use think\Db;

class Panicrefund extends Base
{
    //TODO::退款成功
    public function refundSuccess($oid,$xml='',$pay_type=1){
        //修改抢购订单
        Panicorder::update(['refund_status'=>2,'refund_time'=>time(),'after_sale'=>2],['id' => $oid]);
        //修改退款记录
        Panicrefund::update(['refund_status'=>2,'refund_time'=>time(),'xml'=>$xml],['order_id'=>$oid]);
        //修改公共订单
        (new Commonorder())->editCommonOrderStatus(2,$oid,51);
        //返回库存减销量
        $orderinfo=Panicorder::get($oid);
        //余额退款
        if($pay_type==2){
            $this->refundBalance($orderinfo);
        }
        //加库存
        $pan=new Panic();
        if($orderinfo['use_attr']==0){
            $pan->where(['id'=>$orderinfo['pid']])->setInc('stock',$orderinfo['num']);
        }else{
            $attr=new Panicattrsetting();
            $attr->where(['attr_ids'=>$orderinfo['attr_ids']])->setInc('stock',$orderinfo['num']);
        }
        //减销量
        $pan->decSalesnum($orderinfo['pid'],$orderinfo['num']);
        //减少购买次数
        $redis=new Redis();
        $redis->dec('panicbuytimes'.$orderinfo['pid'].'uid'.$orderinfo['user_id'],$orderinfo['num']);
        //减少免单次数
        if($orderinfo['is_free']==1){
            $redis->dec('panicfreetimes'.$orderinfo['pid'].'uid'.$orderinfo['user_id'],$orderinfo['num']);
        }
    }
    public function refundBalance($order){
        $refund=array(
            'uniacid'=>$order['uniacid'],
            'store_id'=>$order['store_id'],
            'order_id'=>$order['id'],
            'order_type'=>2,
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
    //TODO::微信退款
    public function refundWechat($orderinfo){
        $xml=$this->getRefundXml($orderinfo);
        $data=xml2array($xml);
//        var_dump($data);exit;
        if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
            $this->refundSuccess($orderinfo['id'],$xml);
            return array('code'=>0, 'msg'=>'退款成功',);
        }else{
            //修改抢购订单
            Panicorder::update(['refund_status'=>3,'refund_time'=>time(),'after_sale'=>0],['id' => $orderinfo['id']]);
            //修改退款记录
            Panicrefund::update(['refund_status'=>3,'refund_time'=>time(),'err_code'=>$data['err_code'],'err_code_dec'=>$data['err_code_des'],'xml'=>$xml],['order_id'=>$orderinfo['id']]);
            //修改公共订单
            (new Commonorder())->editCommonOrderStatus(2,$orderinfo['id'],52);
            return array('code'=>1, 'msg'=>'退款失败',);
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
        $data['total_fee']=sprintf("%.0f",$orderinfo['order_amount']*100);
        $data['refund_fee']=sprintf("%.0f",$orderinfo['order_amount']*100);
        $data['sign']=getSign($data,$system['wxkey']);
        $xml=postXmlCurl($data,$orderinfo['uniacid']);
        return $xml;
    }
}