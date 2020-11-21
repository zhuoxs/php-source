<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 11:34
 */
namespace app\model;


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