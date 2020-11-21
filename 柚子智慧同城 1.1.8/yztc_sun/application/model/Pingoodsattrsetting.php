<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 14:22
 */
namespace app\model;


class Pingoodsattrsetting extends Base
{
    //获取选完规格后商品信息
    public function getGoodsAttrInfo($goods_id,$attr_ids){
        global $_W;
        $cond=array(
            'uniacid'=>$_W['uniacid'],
            'goods_id'=>$goods_id,
            'attr_ids'=>$attr_ids
        );
        $data=$this->where($cond)->find();
        return $data;
    }
}