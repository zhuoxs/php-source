<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/9/30
 * Time: 11:03
 */
defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH_ACTIVE') && define('ROOT_PATH_ACTIVE', IA_ROOT . '/addons/kundian_farm_plugin_active/');
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH_ACTIVE.'model/active.php';
require_once ROOT_PATH.'model/notice.php';
class Active_Order{
    protected $that='';
    protected $uniacid='';
    static $active='';
    static $common='';
    public function __construct($that){
        global $_W;
        checklogin();
        $this->that=$that;
        $this->uniacid=$_W['uniacid'];
        self::$active=new Active_KundianFarmPluginActive($this->uniacid);
        self::$common=new Common_KundianFarmModel($this->uniacid);
    }

    public function active_order_list($get){
        $data['old_time'] = [
            'start' => date("Y-m-d", strtotime('-30 days')),
            'end' => date('Y-m-d', strtotime('+1 days'))
        ];
        if($get['active_id']){
            $condition['active_id']=$get['active_id'];
        }

        if($get['is_recycle']){
            $condition['is_recycle']=$get['is_recycle'];
        }
        if($get['is_pay']){
            if($get['is_pay']==2){
                $condition['is_pay']=0;
            }else{
                $condition['is_pay']=1;
                $condition['is_check']=0;
            }
        }

        if($get['is_check']){
            $condition['is_check']=$get['is_check'];
        }

        if($get['apply_delete']){
            $condition['apply_delete']=$get['apply_delete'];
        }
        if ($get['start'] && $get['end']) {
            $condition['create_time >'] = strtotime($get['start']);
            $condition['create_time <'] = strtotime($get['end']);
        }
        if (!empty($get['order_number'])) {
            $condition['order_number LIKE'] = '%' . trim($get['order_number']) . '%';
        }
        if ($get['order_number'] || $get['start'] || $get['end']) {
            $data['list']=self::$active->getActiveOrder($condition);
        }else{
            $order_total = pdo_getall('cqkundian_farm_plugin_active_order',$condition,'','','create_time desc');
            $pageIndex=$get['page'] ? $get['page'] : 1;
            $data['pager']=pagination(count($order_total),$pageIndex,10);
            $data['list']=self::$active->getActiveOrder($condition,$pageIndex,10);
        }

        $data['active']=pdo_getall('cqkundian_farm_plugin_active',['uniacid'=>$this->uniacid]);
        $this->that->doWebCommon("web/order/order_list",$data);
    }

    /** 通过审核 */
    public function checkOrder($get){
        $update=['is_check'=>2];
        if($type='agree'){
            $update=['is_check'=>1];
        }

        $res=pdo_update(self::$active->active_order,$update,['uniacid'=>$this->uniacid,'id'=>$get['order_id']]);
        if($res){
            $notice=new Notice_KundianFarmModel($this->uniacid);
            $activeOrder=pdo_get(self::$active->active_order,['id'=>$get['order_id'],'uniacid'=>$this->uniacid]);
            $active=pdo_get(self::$active->active,['id'=>$activeOrder['active_id'],'uniacid'=>$this->uniacid]);
            $data=[
                'title'=>$active['title'],
                'count'=>$activeOrder['count'],
                'status'=>$update['is_check']==1 ? '已通过审核，待参加':'已拒绝',
                'address'=>$active['address'],
                'time'=>date("Y-m-d H:i",$active['start_time']) . " ".self::$active->getWeek(date("w",$active['start_time'])),
            ];
            $notice->activeCheckMsg($data,$activeOrder['uid'],'/kundian_active/pages/orderList/index');
        }
        echo $res ? json_encode(['code'=>0,'msg'=>'操作成功']) : json_encode(['code'=>-1,'msg'=>'操作失败']);die;
    }

    /** 移入回收站 */
    public function move_into_recycle($get){
        $update=array('is_recycle'=>0);
        if($get['type']==1){
            $update=array('is_recycle'=>1);
        }
        $res=pdo_update('cqkundian_farm_plugin_active_order',$update,['uniacid'=>$this->uniacid,'id'=>$get['order_id']]);
        echo $res ? json_encode(['code'=>0,'msg'=>'操作成功']) : json_encode(['code'=>-1,'msg'=>'操作失败']);die;
    }

    /** 删除订单*/
    public function order_del($get){
        $orderData=pdo_get('cqkundian_farm_plugin_active_order',['uniacid'=>$this->uniacid,'id'=>$get['order_id']]);
        $res1=pdo_update('cqkundian_farm_plugin_active',['person_count -='=>$orderData['count']],['uniacid'=>$this->uniacid,'id'=>$orderData['active_id']]);
        $res=pdo_delete('cqkundian_farm_plugin_active_order',['uniacid'=>$this->uniacid,'id'=>$get['order_id']]);
        if($res && $res1){
            echo json_encode(['code'=>0,'msg'=>'操作成功']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'操作失败']);die;
    }

    /** 订单详情 */
    public function order_detail($get){
        $orderData=pdo_get(self::$active->active_order,['id'=>$get['id'],'uniacid'=>$this->uniacid]);
        $orderData['sign_up']=json_decode($orderData['sign_up']);
        $signInfo=self::$common->objectToArray($orderData['sign_up']);
        $data=[
            'orderData'=>$orderData,
            'signInfo'=>$signInfo,
        ];
        $this->that->doWebCommon("web/order/order_detail",$data);
    }
}
