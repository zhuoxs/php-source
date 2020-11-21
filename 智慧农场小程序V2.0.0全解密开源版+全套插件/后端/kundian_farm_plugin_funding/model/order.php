<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/15
 * Time: 10:24
 */
defined("IN_IA") or exit('Access Denied');
class Order_KundianFarmPluginFundingModel{
    protected $tableName='';
    public function __construct($tableName){
        $this->tableName=$tableName;
    }

    /**
     * 根据id获取订单信息
     * @param $id
     * @param $uniacid
     * @return bool
     */
    public function getOrderById($id,$uniacid){
        $list=pdo_get($this->tableName,array('id'=>$id,'uniacid'=>$uniacid));
        return $list;
    }

    /**
     * 获取订单列表
     * @param $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return array
     */
    public function getFundOrder($cond,$pageIndex='',$pageSize='',$order_by="create_time desc"){
        if(!empty($pageIndex) && !empty($pageSize)){
            $list=pdo_getall($this->tableName,$cond,'','',$order_by,array($pageIndex,$pageSize));
        }else{
            $list=pdo_getall($this->tableName,$cond);
        }
        return $list;
    }

    /**
     * 更新订单信息
     * @param $updateData
     * @param $cond
     * @return bool
     */
    public function updateFundOrder($updateData,$cond){
        $res=pdo_update($this->tableName,$updateData,$cond);
        return $res;
    }

    public function neatenOrder($orderData){
        if($orderData['apply_delete']==0) {
            if($orderData['is_return']==0) {
                if ($orderData['is_pay'] == 0) {
                    $orderData['status_txt'] = '未支付';
                    $orderData['status_code'] = 0;
                } elseif ($orderData['is_pay'] == 1 && $orderData['is_send'] == 0) {
                    $orderData['status_txt'] = '已支付';
                    $orderData['status_code'] = 1;
                } elseif ($orderData['is_pay'] == 1 && $orderData['is_send'] == 1 && $orderData['is_confirm'] == 0) {
                    $orderData['status_txt'] = '已发货';
                    $orderData['status_code'] = 2;
                } elseif ($orderData['is_pay'] == 1 && $orderData['is_send'] == 1 && $orderData['is_confirm'] == 1) {
                    $orderData['status_txt'] = '已收货';
                    $orderData['status_code'] = 3;
                }
            }else{
                $orderData['status_txt']='已分红';
                $orderData['status_code']=6;
            }
        }elseif($orderData['apply_delete']==1){
            $orderData['status_txt'] = '申请退款';
            $orderData['status_code']=4;
        }elseif ($orderData['apply_delete']==2){
            $orderData['status_txt'] = '已取消';
            $orderData['status_code']=5;
        }
        return $orderData;
    }

}