<?php
namespace app\admin\controller;
use Think\Db;
use app\base\controller\Admin;


class Cwithdraw extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    //    获取列表页数据
    public function get_list(){
        $model = $this->model;
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            $type= input('get.type');
            if ($key){
                $query->where('store_name','like',"%$key%");
            }
            if($type==1){
                $query->where('is_state','=',1);
                $query->where('state','=',0);
            }else if($type==2){
                $query->where('status','=',1);
            }else if($type==3){
                $query->where('is_state','=',1);
                $query->where('state','=',2);
            }else if($type==4){
                $query->where('status','=',2);
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->order('id desc')->select();
        foreach ($list as &$item) {
            $item['wd_type']='微信';
            if($item['is_state']==1&&$item['state']==0){
                $item['tx_status_z']='待审核';
            }else if($item['is_state']==1&&$item['state']==2){
                $item['tx_status_z']='已拒绝';
            }else if($item['status']==1){
                $item['tx_status_z']='提现成功';
            }else if($item['status']==2){
                $item['tx_status_z']='提现失败';
            }
            if($item['status']==2){
                if($item['return_status']==1){
                    $item['refund_status_z']='已退款';
                }else{
                    $item['refund_status_z']='未退款';
                }
            }
            $item['add_time'] = date('Y-m-d H:i:d',$item['add_time']);
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

//   审核通过
    public function pass(){
        global $_W;
        $ids = input('post.ids');
        $id = intval($ids);
        $uniacid = $_W['uniacid'];
        $withdraw =Db::name('withdraw')->where(array('uniacid'=>$uniacid,'id'=>$id))->find();
        if($withdraw['is_state']==1&&$withdraw['state']==0){
            $res=Db::name('withdraw')->where(array('id'=>$id,'uniacid'=>$uniacid))->update(array('state'=>1,'review_time'=>time()));
            $withdraw =Db::name('withdraw')->where(array('uniacid'=>$uniacid,'id'=>$id))->find();
            $arr=$this->tixian($withdraw);
            if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
                return array(
                    'code'=>0,
                    'data'=>'提现成功请在微信钱包查看。',
                );
            }else{
                //提现失败返还
                //增加商户金额
                Db::name('store')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['store_id']))->setInc('money',$withdraw['money']);
                //更新提现状态
                Db::name('withdraw')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']))->update(array('return_status'=>1,'return_time'=>time()));
                //增加商户金额明细
                $mcd_memo="商家提现失败返还-提现总金额:￥{$withdraw['money']};支付佣金:￥{$withdraw['paycommission']};支付手续费:￥{$withdraw['ratesmoney']};实际提现金额:￥{$withdraw['realmoney']}";
                $mercapdetails=array(
                    'uniacid'=>$_W['uniacid'],
                    'store_id'=>$withdraw['store_id'],
                    'store_name'=>$withdraw['store_name'],
                    'mcd_type'=>5,
                    'openid'=>$withdraw['openid'],
                    'sign'=>1,
                    'mcd_memo'=>$mcd_memo,
                    'money'=>$withdraw['money'],
                    'realmoney'=>$withdraw['realmoney'],
                    'paycommission'=>$withdraw['paycommission'],
                    'ratesmoney'=>$withdraw['ratesmoney'],
                    'wd_id'=>$withdraw['id'],
                    'add_time'=>time(),
                );
                Db::name('mercapdetails')->insert($mercapdetails);
                return array(
                    'code'=>1,
                    'msg'=>'提现失败，原因'.$arr['err_code_des'].'请联系平台管理人员',
                );
            }
        }else{
            return array(
                'code'=>1,
                'msg'=>'系统错误',
            );
        }

    }

    private function tixian($withdraw){
        global $_W;
        if($withdraw['is_state']!=1||$withdraw['state']!=1||$withdraw['status']!=0){
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


    //审核拒绝
    public function nopass(){
        global $_W;
        $ids = input('post.ids');
        $id = intval($ids);
        $uniacid = $_W['uniacid'];
        $withdraw =Db::name('withdraw')->where(array('uniacid'=>$uniacid,'id'=>$id))->find();
        if($withdraw['is_state']==1&&$withdraw['state']==0){
            $res=Db::name('withdraw')->where(array('id'=>$id,'uniacid'=>$uniacid))->update(array('state'=>2,'review_time'=>time()));
            //拒绝增加商户金额
            Db::name('store')->where(array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['store_id']))->setInc('money',$withdraw['money']);
            //增加商家资金明细记录
            $mcd_memo="商家提现-审核拒绝总金额:￥".$withdraw['money'];
            $mercapdetails=array(
                'uniacid'=>$_W['uniacid'],
                'store_id'=>$withdraw['store_id'],
                'store_name'=>$withdraw['store_name'],
                'mcd_type'=>3,
                'sign'=>1,
                'mcd_memo'=>$mcd_memo,
                'money'=>$withdraw['money'],
                'realmoney'=>$withdraw['realmoney'],
                'paycommission'=>$withdraw['paycommission'],
                'ratesmoney'=>$withdraw['ratesmoney'],
                'wd_id'=>$withdraw['id'],
                'add_time'=>time(),
            );
            Db::name('mercapdetails')->insert($mercapdetails);
            if($res){
                return array(
                    'code'=>0,
                    'data'=>'拒绝成功',
                );
            }else{
                return array(
                    'code'=>1,
                    'msg'=>'系统错误',
                );
            }
        }else{
            return array(
                'code'=>1,
                'msg'=>'系统错误',
            );
        }
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
   public function arrayToXmls($arr)
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
