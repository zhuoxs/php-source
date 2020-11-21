<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 15:28
 */
namespace app\api\controller;


use app\model\Couponget;
use app\model\Ordercar;
use app\model\Orderchartered;
use app\model\Panicorder;
use app\model\Pinorder;
use app\model\Recharge;
use app\model\Infotoprecord;
use app\model\Integralorder;
use think\Db;

class Notify extends Api
{
    //回调方法
    public function wxpay(){
        $xml = file_get_contents('php://input');
        $obj = isimplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $data = json_decode(json_encode($obj), true);
        //增加报文记录
        $baowen=array();
        $baowen['xml']=$xml;
        $baowen['out_trade_no']=$data['out_trade_no'];
        $baowen['transaction_id']=$data['transaction_id'];
        $baowen['add_time']=time();
        Db::name('baowen')->insert($baowen);
        if($this->checksign($data)){
            $this->setPayResult($data);
        }else{
            echo 'FAIL';
        }
    }
    //签名验证
    private function checksign($data){

        $get=$data;
        $string1 = '';
        ksort($get);
        foreach($get as $k => $v) {
            if($v != '' && $k != 'sign') {
                $string1 .= "{$k}={$v}&";
            }
        }
        $attach=json_decode($data['attach'],true);
        $system=Db::name('system')->where(array('uniacid'=>$attach['uniacid']))->find();
        $wxkey=$system['wxkey'];
        $sign = strtoupper(md5($string1 . "key=$wxkey"));
        if($sign==$get['sign']){
            return true;
        }else{
            return false;
        }
    }
    //回调处理订单
    private function setPayResult($data){
        $attach=json_decode($data['attach'],true);
        if($attach['type']=='openvip'){
            //开通会员卡
            $vip=new ApiVip();
            $vip->payNotify($data);
        }else if($attach['type']=='coupon'){
            $coupon=new Couponget();
            $coupon->payNotify($data);
        }else if($attach['type']=='storerecharge'){
            $store=new ApiStore();
            $store->payNotify($data);
        }else if($attach['type']=='CommonOrder'){
            $order=new ApiOrder();
            $order->payNotify($data);
        }else if($attach['type']=='panic'){
            $panic=new Panicorder();
            $panic->panicNotify($data);
        }else if($attach['type']=='pinbuy'){
            //拼团 团长、单独购
            $pin=new Pinorder();
            $pin->notify($data);
        }else if($attach['type']=='pinjoinbuy'){
            //拼团 参团
            $pin=new Pinorder();
            $pin->joinNotify($data);
        }else if($attach['type']=='TopOrder'){
            $infotoprecordModel=new Infotoprecord();
            $infotoprecordModel->payNotify($data);
        }else if($attach['type']=='recharge'){
            $rec=new ApiRecharge();
            $rec->payNotify($data);
        }else if($attach['type']=='integral'){
            $int=new Integralorder();
            $int->notify($data);
        }

    }
}