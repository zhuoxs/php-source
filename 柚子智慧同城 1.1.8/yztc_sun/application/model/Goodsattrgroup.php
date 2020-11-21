<?php

namespace app\model;
use app\model\Goodsattr;
class Goodsattrgroup extends Base
{
    public function attrs()
    {
        return $this->hasMany('Goodsattr');
    }
    //获取商品可选的规格列表
    public function getAttrGroupList($goods_id){
        global  $_W;
        $data=$this->where(array('goods_id'=>$goods_id))->select();
        $data=objecttoarray($data);
        $goodsattr=new Goodsattr();
        foreach ($data as &$val) {
            $val['attr_list']=$goodsattr->where('goodsattrgroup_id',$val['id'])->select();
        }
        return $data;
    }
}
