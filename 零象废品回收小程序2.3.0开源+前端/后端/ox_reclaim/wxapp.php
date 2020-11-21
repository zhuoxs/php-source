<?php
defined('IN_IA') or exit('Access Denied');
define('MODEL_NAME','ox_reclaim');
require_once IA_ROOT . '/addons/'.MODEL_NAME.'/application/bootstrap.php';

class Ox_reclaimModuleWxapp extends WeModuleWxapp
{
    public function doPageApi()
    {
        Application::api();
    }
    /**
     * 应用套餐开通支付
     */
    public function doPagePayNewEnter()
    {
        global $_GPC, $_W;
        //创建订单并插入对应monai_sharing_order表
        $fans=@pdo_get('mc_mapping_fans',array('uid'=>$_GPC['uid']));
        //会员入驻价目表
        $enter=@pdo_get('monai_newsharing_store_enter',array('uniacid'=>$_W['uniacid'],'status'=>1,'id'=>$_GPC['classid'],'type' => $_GPC['type']));
        $order_sn = 'I'.self::makeOrderNo();
        $inlogdb=[
            'uniacid'=>$_W['uniacid'],
            'order_sn'=>$order_sn,//in会员入驻I开头
            'uid'=>$_GPC['uid'],
            'create_time'=>$_SERVER['REQUEST_TIME'],
            'price'=>$enter['price'],
            'enter_id'=>$enter['id'],
            'enter_name'=>$enter['name'],
            'cycle'=>$enter['cycle'],
            'type' => 1,
        ];
        if(floatval($enter['price']) <= 0){
            $inlogdb['pay_time'] = $_SERVER['REQUEST_TIME'];
            $inlogdb['order_state'] = 2;
            $instore=pdo_insert('monai_newsharing_store_log',$inlogdb);
            $plugin = pdo_get('monai_newsharing_member_plugin',['uniacid' =>$_W['uniacid'],'uid' => $_GPC['uid'],'type' => $_GPC['type']]);
            if($plugin){
                if($plugin['end_time'] >= $_SERVER['REQUEST_TIME']){
                    $re = pdo_update('monai_newsharing_member_plugin',['end_time' => ($plugin['end_time'] + $enter['cycle']*86400)  ],['id'=>$plugin['id']]);
                }else{
                    $re = pdo_update('monai_newsharing_member_plugin',['end_time' => ($plugin['end_time'] + $enter['cycle']*86400) ,'begin_time'=> $_SERVER['REQUEST_TIME']],['id'=>$plugin['id']]);
                }
            }else{
                $data = [
                    'uniacid'=>$_W['uniacid'],
                    'uid'=>$_GPC['uid'],
                    'type' => 1,
                    'begin_time' => $_SERVER['REQUEST_TIME'],
                    'create_time' => $_SERVER['REQUEST_TIME'],
                    'end_time' => $_SERVER['REQUEST_TIME'] + $enter['cycle'] * 86400,
                    ];
                $re = pdo_insert('monai_newsharing_member_plugin', $data);
            }
            if($re){
                return $this->result(0, '',['paytype' => 2]);
            }else{
                return $this->result(2, '支付失败','');
            }

        }else{
            $instore=pdo_insert('monai_newsharing_store_log',$inlogdb);
            $orderid = pdo_insertid();
            if (empty($instore) || !$orderid) {
                return $this->result(2, '创建订单失败','');
            }
            //构造支付参数
            $order = array(
                'tid' => $order_sn,
                'user' => $fans['openid'], //用户OPENID
                'fee' => floatval($enter['price']), //金额
                'title' => '商户入驻',
            );
            //生成支付参数，返回给小程序端
            $pay_params = $this->pay($order);
            if (is_error($pay_params)) {
                return $this->result(1, '支付失败，检查支付配置');
            }
            $logs = [
                'type' => 1,
                'pay_sn' => $order_sn,
                'order_id' => $orderid,
                'pay_type' => 1,
                'title' => '开通应用',
                'account' => floatval($enter['price']),
                'create_time' => $_SERVER['REQUEST_TIME'],
                'uniacid'=>$_W['uniacid'],
                'uid'=>$_GPC['uid'],
            ];
            pdo_insert('monai_newsharing_finance',$logs);
            $pay_params['orderid'] = $orderid;
            $pay_params['paytype'] = 1;
            return $this->result(0, '',$pay_params );
        }





    }
    //支付回调
    public function payResult($log) {
        $result = pdo_get('monai_newsharing_finance',[ 'uniacid'=>$log['uniacid'], 'pay_sn'=>$log['tid']]);
        // 根据回调订单号，处理具体业务
        if($result){
            switch ($result['type']){
                case 1:
                    $this->applyNotify($result);
                    break;
                default:
                    break;
            }
        }


    }
    // 开通应用回调处理
    public  function applyNotify($params){

    }
    //随机生成 订单号
    public static function makeOrderNo()
    {
        $yCode = array('S', 'C', 'U', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper('A') . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

}