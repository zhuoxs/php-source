<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 16:16
 */
namespace app\model;
use think\Db;

class Pingoods extends Base
{
    //获取商品列表信息
    public function getGoodsListByStoreId($store_id){
        $data=$this->where(['store_id'=>$store_id,'state'=>1,'check_status'=>2,'is_del'=>0,'end_time'=>['egt',time()]])->order('id desc')->select();
        return $data;
    }
    public function category(){
        return $this->hasOne('Category','id','cat_id')->bind(array(
            'cat_name'=>'name',
        ));
    }
    public function store(){
        return $this->hasOne('Store','id','store_id');
    }
    /**
     * 减库存 、加销量
     */
    public function actNum($goods_id,$total_num,$attr_ids=''){
        $this->where('id',$goods_id)->setDec('stock',$total_num); //单规格
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
        }else{
            $this->where('id',$goods_id)->setDec('group_num',$num);
        }
    }
    public function check_version(){
        $config=getSystemConfig()['system'];
        if(StrCode($config['version'],'DECODE')!='advanced'){
            if(StrCode($config['version'],'DECODE')=='free'){
                $this->check_store_num(intval(StrCode($config['goods_num'],'DECODE')),$store_id);
            }else{
                throw new \ZhyException(getErrorConfig('genuine'));
            }
        }
    }
    //获取数量
    private function check_store_num($num){
        $total_store_num=Db::name('pingoods')->count();
        if($num>0&&$num<=100){
            if($total_store_num>=$num){
                throw new \ZhyException(getErrorConfig('goods_num'));
            }
        }else if($num>100){

        }else{
            throw new \ZhyException(getErrorConfig('genuine'));
        }
    }
}