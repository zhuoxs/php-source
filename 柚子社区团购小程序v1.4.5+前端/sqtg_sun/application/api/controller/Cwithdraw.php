<?php
namespace app\api\controller;
use think\Db;

use app\base\controller\Api;

class Cwithdraw extends Api
{
    //获取提现设置信息
    public function getWithDrawSet(){
        global $_W;
        $store_id=input('request.store_id');
        $withdrawset=Db::name('withdrawset')->where(array('uniacid'=>$_W['uniacid']))->find();
        $store=Db::name('store')->find($store_id);
        if($store['draw_rate']>0){
            $withdrawset['cms_rates']=$store['draw_rate'];
        }
        $this->ajaxSuccess($withdrawset);
    }
    //申请提现
    public function setWithDraw(){
        global $_W;
        $user_id=input('request.user_id');
        $money=input('request.money');
        $store_id=input('request.store_id');
        $wd_name=input('request.wd_name');
        $wd_phone=input('request.wd_phone');
        $user=Db::name('user')->find($user_id);
        if(!$user){
            $this->ajaxError('用户不存在');
        }
        //判断商家
        $store=Db::name('store')->where(array('id'=>$store_id,'user_id'=>$user_id))->find();
        if(!$store){
            $this->ajaxError('商家不存在');
        }
        $withdrawset=Db::name('withdrawset')->where(array('uniacid'=>$_W['uniacid']))->find();
        if(!$withdrawset){
            $this->ajaxError('请先配置提现设置');
        }
        if($withdrawset['is_open']!=1){
            $this->ajaxError('提现申请已关闭不能提现');;
        }
        if($money<1){
            $this->ajaxError('提现金额最少￥1');
        }
        if($money<$withdrawset['min_money']){
            $this->ajaxError('最低提现金额为￥'.$withdrawset['min_money']);
        }
        if($store['money']<$money){
            $this->ajaxError('余额不足');
        }
        //手续费
        $ratesmoney=0;
        if($withdrawset['wd_wxrates']>0){
            $ratesmoney=sprintf("%.2f",$withdrawset['wd_wxrates']/100*$money);
        }
        //平台抽取
        $paycommission=0;
        $rate=0;
        if($store['draw_rate']>0){
            $rate=$store['draw_rate'];
        }else if($withdrawset['cms_rates']){
            $rate=$withdrawset['cms_rates'];
        }
        $paycommission=sprintf("%.2f",$rate/100*$money);
        //实际提现金额
        $realmoney=sprintf("%.2f",$money-$ratesmoney-$paycommission);
        if($realmoney<1){
            $this->ajaxError('实际提现金额最少￥1');
        }
        //增加提现记录
        $withdraw=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$user['openid'],
            'wd_type'=>1,
            'wd_name'=>$wd_name,
            'wd_phone'=>$wd_phone,
            'money'=>$money,
            'realmoney'=>$realmoney,
            'paycommission'=>$paycommission,
            'ratesmoney'=>$ratesmoney,
            'store_id'=>$store_id,
            'store_name'=>$store['name'],
            'add_time'=>time(),
        );
        if($money>$withdrawset['avoidmoney']){
            $withdraw['is_state']=1;
        }else{
            $withdraw['is_state']=0;
        }
        Db::name('withdraw')->insert($withdraw);
        $withdraw_id=Db::name('withdraw')->getLastInsID();
        //减少商户金额
        Db::name('store')->where(array('uniacid'=>$_W['uniacid'],'id'=>$store_id))->setDec('money',$money);
        //增加商户金额明细
        $mcd_memo="商家提现-提现总金额:￥$money;支付佣金:￥$paycommission;支付手续费:￥$ratesmoney;实际提现金额:￥$realmoney";
        $mercapdetails=array(
            'uniacid'=>$_W['uniacid'],
            'store_id'=>$store_id,
            'store_name'=>$store['name'],
            'mcd_type'=>2,
            'openid'=>$user['openid'],
            'sign'=>2,
            'mcd_memo'=>$mcd_memo,
            'money'=>$money,
            'realmoney'=>$realmoney,
            'paycommission'=>$paycommission,
            'ratesmoney'=>$ratesmoney,
            'wd_id'=>$withdraw_id,
            'add_time'=>time(),
        );
        Db::name('mercapdetails')->insert($mercapdetails);
        $withdraw=Db::name('withdraw')->find($withdraw_id);
        $arr=$this->tixian($withdraw);
        if($withdraw['is_state']==1){
            $this->ajaxSuccess('提现申请已提交,请等待审核');
        }else if($withdraw['is_state']==0){
            if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
                $this->ajaxSuccess('提现成功请在微信钱包查看。');
            }else{
                //提现失败返还
                //增加商户金额
                Db::name('store')->where(array('uniacid'=>$_W['uniacid'],'id'=>$store_id))->setInc('money',$money);
                //更新提现状态
                Db::name('withdraw')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw_id))->update(array('return_status'=>1,'return_time'=>time()));
                //增加商户金额明细
                $mcd_memo="商家提现失败返还-提现总金额:￥$money;支付佣金:￥$paycommission;支付手续费:￥$ratesmoney;实际提现金额:￥$realmoney";
                $mercapdetails=array(
                    'uniacid'=>$_W['uniacid'],
                    'store_id'=>$store_id,
                    'store_name'=>$store['name'],
                    'mcd_type'=>5,
                    'openid'=>$user['openid'],
                    'sign'=>1,
                    'mcd_memo'=>$mcd_memo,
                    'money'=>$money,
                    'realmoney'=>$realmoney,
                    'paycommission'=>$paycommission,
                    'ratesmoney'=>$ratesmoney,
                    'wd_id'=>$withdraw_id,
                    'add_time'=>time(),
                );
                Db::name('mercapdetails')->insert($mercapdetails);
                $this->ajaxError('提现失败，原因'.$arr['err_code_des'].'请联系平台管理人员');
            }
        }
    }
    private function tixian($withdraw){
        global $_W;
        if($withdraw['is_state']==1){
            return false;
            exit;
        }
        if($withdraw['status']==1){
            return false;
            exit;
        }
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $system=Db::name('system')->where(array('uniacid'=>$_W['uniacid']))->find();
        $data['mch_appid']=$system['appid'];
        $data['mchid'] =$system['mchid'];
        $data['nonce_str']=$this->createNoncestr();
        $data['partner_trade_no']=date("YmdHis") .rand(11111, 99999);
        $data['openid']=$withdraw['openid'];
        $data['check_name']='NO_CHECK';
        $data['amount']=$withdraw['realmoney']*100;
        $data['desc']='提现';
        $data['spbill_create_ip']=$_SERVER['REMOTE_ADDR'];
        $data['sign']=$this->getSign($data,$system['wxkey']);
        $xml=$this->postXmlCurl($data,$url);
        //保存报文信息
        Db::name('withdraw')->where(array('id'=>$withdraw['id']))->update(array('baowen'=>$xml));
        //添加报文记录
        $baowen=array(
            'uniacid'=>$_W['uniacid'],
            'openid'=>$withdraw['openid'],
            'store_id'=>$withdraw['store_id'],
            'money'=>$withdraw['realmoney'],
            'baowen'=>$xml,
            'wd_id'=>$withdraw['id'],
            'add_time'=>time(),
            'request_data'=>json_encode($data),
        );
        Db::name('withdrawbaowen')->insert($baowen);
        //更改提现状态 商家明细提现状态
        $arr=xml2array($xml);
        if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
            Db::name('withdraw')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']))->update(array('status'=>1,'tx_time'=>time(),'request_time'=>time()));
            Db::name('mercapdetails')->where(array('uniacid'=>$_W['uniacid'],'wd_id'=>$withdraw['id']))->update(array('status'=>1));
        }else{
            Db::name('withdraw')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']))->update(array('status'=>2,'request_time'=>time(),'err_code'=>$arr['err_code'],'err_code_des'=>$arr['err_code_des']));
            Db::name('mercapdetails')->where(array('uniacid'=>$_W['uniacid'],'wd_id'=>$withdraw['id']))->update(array('status'=>2));
        }
        return $arr;
    }

    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    //作用：生成签名
    private function getSign($Obj,$key) {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    //作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    private  function postXmlCurl($xml, $url, $second = 30)
    {
        global $_W;
        if(!$url){
            $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";//微信退款地址，post请求
        }
        $xml = $this->arrayToXmls($xml);
        $refund_xml='';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, IA_ROOT . '/addons/sqtg_sun/cert/apiclient_cert_'.$_W['uniacid'].'.pem');
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, IA_ROOT . '/addons/sqtg_sun/cert/apiclient_key_'.$_W['uniacid'].'.pem');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $refund_xml = curl_exec($ch);
        // 返回结果0的时候能只能表明程序是正常返回不一定说明退款成功而已
        $errono = curl_errno($ch);
        /* if ($errono == 0) {
             $xml_data = xml2array($xml);
             $return_data['errNum'] = 0;
             $return_data['info'] = $xml_data;
         } else {
             $return_data['errNum'] = $errono;
             $return_data['info'] = '';
         }*/
        curl_close($ch);
        return $refund_xml;
        // die(json_encode($return_data));
    }
    function arrayToXmls($arr)
    {
        $xml = "<root>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</root>";
        return $xml;
    }

}
