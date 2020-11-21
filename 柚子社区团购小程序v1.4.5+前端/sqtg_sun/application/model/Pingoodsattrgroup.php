<?php
namespace app\model;

use app\base\model\Base;

class Pingoodsattrgroup extends Base
{
    public function attrs()
    {
        return $this->hasMany('Pingoodsattr','goodsattrgroup_id');
    }
    //获取商品可选的规格列表
    public function getAttrGroupList($goods_id){
        global  $_W;
        $data=$this->where(array('uniacid'=>$_W['uniacid'],'goods_id'=>$goods_id))->select();
        $goodsattr=new Pingoodsattr();
        foreach ($data as &$val) {
            $val['attr_list']=$goodsattr->where('goodsattrgroup_id',$val['id'])->select();
        }
        return $data;
    }
}