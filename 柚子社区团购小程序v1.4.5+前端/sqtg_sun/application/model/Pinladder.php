<?php
namespace app\model;

use app\base\model\Base;

class Pinladder extends Base
{
    /**
     * 获取阶梯团列表
    */
    public function getLadderList($goods_id){
        $list=$this->where(['goods_id'=>$goods_id])->select();
        return $list;
    }
}