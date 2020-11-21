<?php

namespace app\model;
use think\Db;


class Goods extends Base
{
    public function category(){
        return $this->hasOne('Category','id','cat_id')->bind(array(
            'cat_name'=>'name',
        ));
    }
    public function platformCategory(){
        return $this->hasOne('Category','id','platform_cat_id')->bind(array(
            'platform_cat_name'=>'name',
        ));
    }

    public function store(){
        return $this->hasOne('Store','id','store_id')->bind(array(
            'store_name'=>'name',
            'store_pic'=>'pic',
            'goods_count',
            'sale_count',
        ));
    }
    public function store1(){
        return $this->hasOne('Store','id','store_id')->bind(array(
            'store_end_time'=>'end_time',
        ));
    }

    public function attrgroups()
    {
        return $this->hasMany('Goodsattrgroup','goods_id','id')->with('attrs');
    }
    public function getEndTimeAttr($value)
    {
        return date('Y-m-d H:i:d',$value);
    }
    public function getExpireTimeAttr($value)
    {
        return date('Y-m-d H:i:d',$value);
    }
    //获取商品列表信息
    public function getGoodsListByStoreId($store_id){
        $data=$this->where(['store_id'=>$store_id,'state'=>1,'check_status'=>2])->order('id desc')->select();
        return $data;
    }
    //获取商品详情信息
    public function getGoodsDetailByGid($gid,$attr_ids,$user_id,$num){
        $data=$this::get($gid);
        if($attr_ids){
            $goodsattrsetting=(new Goodsattrsetting())->where(['goods_id'=>$gid,'attr_ids'=>$attr_ids])->find();
            $data['goodsattrsetting']=$goodsattrsetting;
        }
        $store=new Store();
        $data['store']=$store::get($data['store_id']);
        $user=new User();
        $data['user']=$user::get($user_id);
        $is_vip=(new User())->isVip($user_id);
        $free_num=0;//免费单数
        //仅vip和免费领取存在
        $is_free=0;//vip免单标识
        if($data['only_num']>0&&$is_vip==1){
            //获取该用户已经免费该商品订单数量
            $total_free_num=(new Order())->getOrderFreeNumByGid($user_id,$gid);
            //计算还可以免费多少单
            $yu_free_num=$data['only_num']-$total_free_num;
            if($yu_free_num>0){
                if($yu_free_num-$num>=0){
                    $free_num=$num;
                }else{
                    $free_num=$yu_free_num;
                }
                $is_free=1;
            }
        }
        //计算付款单数
        $pay_num=$num-$free_num;
        $unit_price=0;//商品单价
        $price=0;//商品总价
        $order_amount=0;//订单总价
        if($is_vip){
            if($goodsattrsetting){
                $unit_price=$goodsattrsetting['vip_price'];
                $pic=$goodsattrsetting['pic'];
            }else{
                $unit_price=$data['vip_price'];
                $pic=$data['pic'];
            }
        }else{
            if($goodsattrsetting){
                $unit_price=$goodsattrsetting['price'];
                $pic=$goodsattrsetting['pic'];
            }else{
                $unit_price=$data['price'];
                $pic=$data['pic'];
            }
        }
        $price=sprintf("%.2f",$unit_price*$pay_num);
        $order_amount=$price;
        $data['order']=array(
            'unit_price'=>$unit_price,
            'price'=>$price,
            'order_amount'=>$order_amount,
            'is_free'=>$is_free,
            'num'=>$num,
            'free_num'=>$free_num,
            'pic'=>$pic,
        );
        return $data;
    }
    //获取商品库存总数和所有加起来
    public function getGoodsSaleNumByGid($gid){
        $goods=self::get($gid);
        $stock_num=0;
        if($goods['use_attr']==1){
            $stock=(new Goodsattrsetting())->where(['goods_id'=>$gid])->sum('stock');
            $stock_num=intval($stock+$goods['sales_num_virtual']+$goods['sales_num']);
        }else{
            $stock_num=intval($goods['stock']+$goods['sales_num_virtual']+$goods['sales_num']);
        }
        return $stock_num;
    }
    public function check_version($store_id){
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
        $total_store_num=Db::name('goods')->count();
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
