<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 16:36
 */
namespace app\model;


class Integralgoods extends Base{
    public function get_info($id){
        $info = self::get(['id'=>$id]);
        return $info;
    }
    /**
     * 减库存 、加销量
    */
    public function actNum($goods_id,$total_num){
        $this->where('id',$goods_id)->setDec('num',$total_num);
        $this->where('id',$goods_id)->setInc('sales_numxn',$total_num);
        $this->where('id',$goods_id)->setInc('sales_num',$total_num);
    }
}