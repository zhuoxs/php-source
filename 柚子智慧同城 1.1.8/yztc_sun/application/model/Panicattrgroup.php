<?php

namespace app\model;
use app\model\Goodsattr;
class Panicattrgroup extends Base
{
    public function attrs()
    {
        return $this->hasMany('Panicattr','goodsattrgroup_id','id');
    }
    //获取商品可选的规格列表
    public function getAttrGroupList($goods_id){
        global  $_W;
        $data=$this->where(array('uniacid'=>$_W['uniacid'],'goods_id'=>$goods_id))->select();
        $goodsattr=new Panicattr();
        foreach ($data as &$val) {
            $val['attr_list']=$goodsattr->where('goodsattrgroup_id',$val['id'])->select();
        }
        return $data;
    }
}
