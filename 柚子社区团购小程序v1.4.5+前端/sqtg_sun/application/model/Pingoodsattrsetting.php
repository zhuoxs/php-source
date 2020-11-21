<?php
namespace app\model;

use app\base\model\Base;

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