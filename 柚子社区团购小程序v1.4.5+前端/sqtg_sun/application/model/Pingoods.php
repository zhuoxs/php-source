<?php
namespace app\model;

use app\base\model\Base;

class Pingoods extends Base
{
    public function category(){
        return $this->hasOne('Pinclassify','id','cid')->bind(array(
            'cname'=>'name',
        ));
    }
    /**
     * 减库存 、加销量
     */
    public function actNum($goods_id,$total_num,$attr_ids=''){
        $this->where('id',$goods_id)->setDec('stock',$total_num); //单规格
        $this->where('id',$goods_id)->setInc('sales_xnnum',$total_num);
        $this->where('id',$goods_id)->setInc('sales_num',$total_num);
        if($attr_ids){
            $setting=new Pingoodsattrsetting();
            $setting->where(['goods_id'=>$goods_id,'attr_ids'=>$attr_ids])->setDec('stock',$total_num); //多规格
        }
    }
    /**
     * 加库存 、减销量
     */
    public function updateNum($goods_id,$total_num,$attr_ids=''){
        $this->where('id',$goods_id)->setInc('stock',$total_num); //单规格
        $this->where('id',$goods_id)->setDec('sales_xnnum',$total_num);
        $this->where('id',$goods_id)->setDec('sales_num',$total_num);
        if($attr_ids){
            $setting=new Pingoodsattrsetting();
            $setting->where(['goods_id'=>$goods_id,'attr_ids'=>$attr_ids])->setInc('stock',$total_num); //多规格
        }
    }
    /**
     * 修改开团数
    */
    public function actHeadsnum($goods_id,$type,$num){
        if($type=='add'){
            $this->where('id',$goods_id)->setInc('group_num',$num);
            $this->where('id',$goods_id)->setInc('group_xnnum',$num);
        }else{
            $this->where('id',$goods_id)->setDec('group_num',$num);
            $this->where('id',$goods_id)->setDec('group_xnnum',$num);
        }
    }

    public function store(){
        return $this->hasOne('Store','id','store_id')->bind(array(
            'store_name'=>'name',
            'store_leader_draw_type'=>'leader_draw_type',
            'store_leader_draw_rate'=>'leader_draw_rate',
            'store_leader_draw_money'=>'leader_draw_money',
        ));
    }
}