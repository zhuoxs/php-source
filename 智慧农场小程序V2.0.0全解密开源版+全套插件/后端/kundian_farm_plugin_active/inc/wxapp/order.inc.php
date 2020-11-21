<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/9/30
 * Time: 10:05
 * line 101
 */

defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH_ACTIVE') && define('ROOT_PATH_ACTIVE', IA_ROOT . '/addons/kundian_farm_plugin_active/');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
require_once ROOT_PATH.'model/goods.php';
require_once ROOT_PATH_ACTIVE.'model/active.php';
class OrderController{
    protected $uniacid = '';
    protected $uid = '';
    static $active='';
    public function __construct(){
        global $_GPC;
        $this->uniacid = $_GPC['uniacid'];
        $this->uid = $_GPC['uid'];
        self::$active=new Active_KundianFarmPluginActive($this->uniacid);
    }

    /** 活动订单列表 */
    public function getOrderList($get){
        $page=empty($get['page']) ? 1 : $get['page'];
        $condition=['uid'=>$this->uid, 'uniacid'=>$this->uniacid,'is_recycle'=>0];
        if ($get['current']==2){
            $condition['is_pay']=1;
            $condition['is_check']=1;
            $condition['apply_delete']=0;
        }elseif ($get['current']==3){
            $condition['is_pay']=1;
            $condition['is_check']=0;
            $condition['apply_delete']=0;
        }elseif ($get['current']==4){
            $condition['is_pay']=0;
            $condition['apply_delete']=0;
        }
        $orderData=pdo_getall('cqkundian_farm_plugin_active_order',$condition,'','','create_time desc',array($page,10));
        for ($i=0; $i <count($orderData) ; $i++) {
            $active=pdo_get('cqkundian_farm_plugin_active',['id'=>$orderData[$i]['active_id'],'uniacid'=>$this->uniacid]);
            $active['start_time']=date('m/d',$active['start_time']);
            $active['week']=self::$active->getWeek(date('w'));
            $orderData[$i]['active']=$active;
        }
        $request['orderList']=$orderData;
        echo json_encode($request);die;
    }

    /** 取消活动订单 */
    public function cancelOrder($get){
        $res=pdo_update('cqkundian_farm_plugin_active_order',['apply_delete'=>2],['uniacid'=>$this->uniacid,'uid'=>$this->uid,'id'=>$get['order_id']]);
        echo $res ? json_encode(['code'=>1,'msg'=>'订单已取消']) : json_encode(['code'=>2,'msg'=>'订单取消失败']);die;
    }

    /** 获取二维码信息 */
    public function getQrcode($get){
        $orderData=pdo_get('cqkundian_farm_plugin_active_order',['id'=>$get['order_id'],'uid'=>$this->uid]);
        $orderData['sign_up']=json_decode($orderData['sign_up']);
        $active=pdo_get('cqkundian_farm_plugin_active',['uniacid'=>$this->uniacid,'id'=>$orderData['active_id']]);
        $active['start_time']=date("Y-m-d H:i",$active['start_time']);
        if($orderData['qrcode']==''){
            $goods=new Goods_KundianFarmModel('','');
            $qrcode=$goods->getGoodsQrcode('/kundian_active/pages/check/index?order_id='.$orderData['order_number'],$this->uniacid);
            $orderData['qrcode']=$qrcode;
            pdo_update('cqkundian_farm_plugin_active_order',['qrcode'=>$qrcode],['uniacid'=>$this->uniacid,'id'=>$orderData['id']]);
        }
        $request['active']=$active;
        $request['orderData']=$orderData;
        echo json_encode($request);die;
    }

    /** 获取门票信息 */
    public function getTicketData($get){
        $is_check_user=pdo_get('cqkundian_farm_vet',['uniacid'=>$this->uniacid,'uid'=>$this->uid,'status'=>1]);
        $orderData=pdo_get('cqkundian_farm_plugin_active_order',['order_number'=>$get['order_number'],'uniacid'=>$this->uniacid]);
        $orderData=self::$active->neatenOrder($orderData);
        $orderData['create_time']=date("Y-m-d H:i:s",$orderData['create_time']);
        $orderData['sign_up']=json_decode($orderData['sign_up']);
        echo json_encode(['code'=>1,'orderData'=>$orderData,'is_check_user'=>$is_check_user]);die;
    }

    /** 核销活动订单 */
    public function checkActive($get){
        $orderData=pdo_get('cqkundian_farm_plugin_active_order',['uniacid'=>$this->uniacid,'id'=>$get['order_id']]);
        $is_check_user=pdo_get('cqkundian_farm_vet',['uniacid'=>$this->uniacid,'uid'=>$this->uid,'status'=>1]);
        if(!empty($is_check_user)){
            $active=pdo_get('cqkundian_farm_plugin_active',['uniacid'=>$this->uniacid,'id'=>$orderData['active_id']]);
            if($active['start_time']<time()){
                $res=pdo_update('cqkundian_farm_plugin_active_order',['is_check'=>3],['uniacid'=>$this->uniacid,'id'=>$get['order_id']]);
                echo $res ? json_encode(['code'=>1,'msg'=>'核销成功']) : json_encode(['code'=>2,'msg'=>'核销失败']);die;
            }
            echo json_encode(['code'=>'1','msg'=>'活动未开始']);die;
        }
        echo json_encode(['code'=>1,'msg'=>'您没有权限核销']);die;
    }
}