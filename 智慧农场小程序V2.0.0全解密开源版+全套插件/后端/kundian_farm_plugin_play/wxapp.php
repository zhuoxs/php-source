<?php
/**
 * Created by PhpStorm.
 * User: 资源邦源码网
 * Date: 2018/9/14
 * Time: 14:04
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH_PLAY') && define('ROOT_PATH_PLAY', IA_ROOT . '/addons/kundian_farm_plugin_play/');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
class Kundian_farm_plugin_playModuleWxapp extends WeModuleWxapp {

    public function doPageGame(){
        global $_GPC, $_W;
        $action=$_GPC['action'];
        require_once ROOT_PATH_PLAY.'inc/wxapp/'.$action.'.inc.php';
        $class=ucfirst($action.'Controller');
        $actionModel=new $class();
        $op=$_GPC['op'];
        $actionModel->$op($_GPC);
    }

    public function doPagePay(){
        global $_GPC, $_W;
        require_once ROOT_PATH_PLAY.'inc/wxapp/'.$_GPC['control'].'.inc.php';
        $class=ucfirst($_GPC['control'].'Controller');
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

    public function payResult($log){
        load()->func('logging');
        logging_run($log);
        if ($log['result']=='success') {
            $action=cache_load('kundian_farm_pay_notify_'.$log['user']);
            require_once ROOT_PATH_PLAY.'inc/wxapp/land.inc.php';
            $land=new LandController();
            $res=$land->$action($log);
            //查询统计记录
            $statistics=pdo_get('cqkundian_farm_statistics',['uniacid'=>$log['uniacid'],'date'=>date("Ymd",time())]);
            if(empty($statistics)){
                $insert=[
                    'date'=>date("Ymd",time()),
                    'uniacid'=>$log['uniacid'],
                    'order_count'=>1,
                    'total_price'=>$log['fee'],

                ];
                pdo_insert('cqkundian_farm_statistics',$insert);
            }else{
                pdo_update('cqkundian_farm_statistics',['order_count +='=>1,'total_price +='=>$log['fee']],['uniacid'=>$log['uniacid'],'date'=>date("Ymd",time())]);
            }

            if($res){
                cache_delete('kundian_farm_pay_notify_'.$log['user']);
            }
        }
    }
}