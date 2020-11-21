<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4
 * Time: 13:38
 */
defined("IN_IA") or exit("Access Denied");
class Animal_Model{
    public $shedTable='cqkundian_farm_plugin_play_shed_upgrade';
    public function __construct($uniacid){
        $this->uniacid=$uniacid;
    }

    /**
     * 新增棚订单
     * @param $data
     * @return bool
     */
    public function insertShedOrder($data){
        if(empty($data)){
            return $data;
        }
        pdo_insert($this->shedTable,$data);
        $order_id=pdo_insertid();
        return $order_id;
    }

    /**
     *  根据订单id获取订单信息
     * @param $order_id
     * @return bool
     */
    public function getShedOrderById($order_id){
        return pdo_get($this->shedTable,['id'=>$order_id,'uniacid'=>$this->uniacid]);
    }

    /**
     * 查询棚升级订单信息
     * @param $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return array
     */
    public function getShedOrder($cond,$pageIndex='',$pageSize='',$order_by='create_time desc'){
        if(!empty($pageIndex) &&!empty($pageSize)){
            return pdo_getall($this->shedTable,$cond,'','',$order_by,[$pageIndex,$pageSize]);
        }else{
            return pdo_getall($this->shedTable,$cond,'','',$order_by);
        }
    }

    /**
     * 获取棚升级订单总数
     * @param $cond
     * @return mixed
     */
    public function getShedOrderCount($cond){
        $query = load()->object('query');
        $row = $query->from($this->shedTable)->where($cond)->count();
        return $row;
    }

}