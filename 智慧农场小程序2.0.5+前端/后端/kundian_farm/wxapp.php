<?php
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
!defined('TABLE_PRE') && define('TABLE_PRE', 'cqkundian_farm_');
error_reporting(0);
class Kundian_farmModuleWxapp extends WeModuleWxapp {

    public function doPageWebThing(){
        require_once ROOT_PATH.'inc/wxapp/webThing.inc.php';
    }

    public function doPageClass(){
        global $_GPC, $_W;
        $action=$_GPC['action'];
        if(!empty($_GPC['control']) && !empty($_GPC['action'])){
            require_once ROOT_PATH.'inc/wxapp/'.$_GPC['control'].'/'.$action.'.inc.php';
            $class=ucfirst($action.'Controller');
        }elseif($_GPC['action']){
            require_once ROOT_PATH.'inc/wxapp/'.$action.'/'.$action.'.inc.php';
            $class=ucfirst($action.'Controller');
        }elseif($_GPC['control']){
            require_once ROOT_PATH.'inc/wxapp/'.$_GPC['control'].'.inc.php';
            $class=ucfirst($_GPC['control'].'Controller');
        }

        $actionModel=new $class();
        $op=$_GPC['op'];
        $actionModel->$op($_GPC);
    }


    public function doPagePay(){
        global $_GPC, $_W;
        $action=$_GPC['action'];
        if(!empty($_GPC['control']) && !empty($action)){
            require_once ROOT_PATH.'inc/wxapp/'.$_GPC['control'].'/'.$action.'.inc.php';
            $class=ucfirst($action.'Controller');
        }elseif($_GPC['control']){
            require_once ROOT_PATH.'inc/wxapp/'.$_GPC['control'].'.inc.php';
            $class=ucfirst($_GPC['control'].'Controller');
        }elseif($action){
            require_once ROOT_PATH.'inc/wxapp/'.$action.'/'.$action.'.inc.php';
            $class=ucfirst($action.'Controller');
        }else{
            require_once ROOT_PATH.'inc/wxapp/'.$_GPC['file'].'.inc.php';
            $class=ucfirst($_GPC['file'].'Controller');
        }

        $actionModel=new $class();
        $op=$_GPC['op'];
        $order=$actionModel->$op();
        //生成支付参数，返回给小程序端
        $pay_params = $this->pay($order);

        if (is_error($pay_params)) {
            return $this->result(1, $pay_params['message']);
        }
        return $this->result(0, '', $pay_params);
    }

    public function doPageFundingPay(){
        global $_GPC, $_W;
        //获取订单号，保证在业务模块中唯一即可
        $order_id = intval($_GPC['orderid']);
        $uniacid=$_GPC['uniacid'];
        $orderData=pdo_get('cqkundian_farm_plugin_funding_order',array('id'=>$order_id,'uniacid'=>$uniacid));
        //构造支付参数
        $order = array(
            'tid' => $orderData['order_number'],
            'user' => $_W['openid'], //用户OPENID
            'fee' => $orderData['total_price'], //金额
            'title' => '购物消费',
        );
        //生成支付参数，返回给小程序端
        $pay_params = $this->pay($order);
        if (is_error($pay_params)) {
            return $this->result(1, $pay_params['message']);
        }
        cache_write("kundian_farm_pay_notify_".$_W['openid'],9);
        return $this->result(0, '', $pay_params);
    }

    public function doPageActivePay(){
        global $_GPC, $_W;
        $order_id = intval($_GPC['orderid']);
        $uniacid=$_GPC['uniacid'];
        $orderData=pdo_get('cqkundian_farm_plugin_active_order',array('id'=>$order_id,'uniacid'=>$uniacid));
        $active=pdo_get('cqkundian_farm_plugin_active',array('uniacid'=>$uniacid,'id'=>$orderData['active_id']));
        if($active['count'] > 0){
            if($active['count']-$active['person_count'] < $orderData['count']){
                return $this->result(0, '当前余票不足');
            }
        }
        $order = array(
            'tid' => $orderData['order_number'],
            'user' => $_W['openid'], //用户OPENID
            'fee' => $orderData['total_price'], //金额
            'title' => '购物消费',
        );
        //生成支付参数，返回给小程序端
        $pay_params = $this->pay($order);
        if (is_error($pay_params)) {
            return $this->result(1, $pay_params['message']);
        }
        cache_write("kundian_farm_pay_notify_".$_W['openid'],10);
        return $this->result(0, '', $pay_params);
    }

    /**
     * 支付回调
     * @param $log
     */
    public function payResult($log){
        load()->func('logging');
        logging_run($log);
        if ($log['result']=='success') {
            $order_id = $log['tid'];
            $uniontid = $log['uniontid'];
            $fee = $log['fee'];
            $user=$log['user'];
            $remark=cache_load('kundian_farm_pay_notify_'.$user);
            if ($remark==9){
                $update_save=array(
                    'is_pay'=>1,
                    'pra_price'=>$fee,
                    'pay_time'=>time(),
                    'pay_method'=>'微信支付',
                    'uniontid'=>$uniontid,
                );
                pdo_update('cqkundian_farm_plugin_funding_order',$update_save,array('order_number'=>$order_id,'uniacid'=>$log['uniacid']));
            }elseif ($remark==10){
                $update_save=array(
                    'is_pay'=>1,
                    'pra_price'=>$fee,
                    'pay_time'=>time(),
                    'pay_method'=>'微信支付',
                    'uniontid'=>$uniontid,
                );
                pdo_update('cqkundian_farm_plugin_active_order',$update_save,array('order_number'=>$order_id,'uniacid'=>$log['uniacid']));
            }else{
                require_once ROOT_PATH.'model/notify.php';
                $notify=new Notify_KundianFarmModel();
                $res=$notify->$remark($log);
            }

            //查询统计记录
            $statistics=pdo_get('cqkundian_farm_statistics',array('uniacid'=>$log['uniacid'],'date'=>date("Ymd",time())));
            if(empty($statistics)){
                $insert=array(
                    'date'=>date("Ymd",time()),
                    'uniacid'=>$log['uniacid'],
                    'order_count'=>1,
                    'total_price'=>$fee,

                );
                pdo_insert('cqkundian_farm_statistics',$insert);
            }else{
                pdo_update('cqkundian_farm_statistics',array('order_count +='=>1,'total_price +='=>$fee),array('uniacid'=>$log['uniacid'],'date'=>date("Ymd",time())));
            }

            if($res){
                cache_delete('kundian_farm_pay_notify_'.$user);
            }
        }
    }
}