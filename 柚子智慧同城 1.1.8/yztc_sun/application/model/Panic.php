<?php

namespace app\model;

use think\Db;
use think\cache\driver\Redis;

class Panic extends Base
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
        return $this->hasOne('Store','id','store_id');
    }
    public function attrgroups()
    {
        return $this->hasMany('Goodsattrgroup','goods_id','id')->with('attrs');
    }
    public function ladderinfo()
    {
        return $this->hasMany('Panicladder','id','goods_id');
    }
    //TODO::抢购详情
    public function getInfo($pid){
        $pid = intval($pid);
        $data = $this->where(array('id' => $pid))->find();
        $data = json_decode($data, true);
        return $data;
    }
    function delRedisBuy($redis,$pid){
        $redis->rm('hpanicinfo' . $pid);
    }
    //TODO::新增浏览量
    public function addReadnum($pid){
        $this->where(['id'=>$pid])->setInc('read_num');
    }
    //TODO::新增销量
    public function addSalesnum($pid,$num){
        $this->where(['id'=>$pid])->setInc('sales_num',$num);
    }
    //TODO::减少销量
    public function decSalesnum($pid,$num){
        $this->where(['id'=>$pid])->setDec('sales_num',$num);
    }
    //TODO::添加订单
    public function addOrder($panicinfo,$user_id,$pid,$redis,$num,$remark,$phone,$use_attr,$attr_ids,$attr_list,$order_amount,$money,$is_vip,$is_free,$share_user_id=0,$pay_type=1){
        //减库存
        if($use_attr==0){
            $this->where(['id'=>$pid])->setDec('stock',$num);
        }else{
            $attr=new Panicattrsetting();
            $attr->where(['attr_ids'=>$attr_ids])->setDec('stock',$num);
        }
        $data['user_id']=$user_id;
        $data['pid']=$pid;
        $data['num']=$num;
        $data['use_attr']=$use_attr;
        $data['attr_ids']=$attr_ids;
        $data['order_no']=date('Ymd',time()).rand(100000,999999);
        $data['store_id']=$panicinfo['store_id'];
        $data['attr_list']=$attr_list;
        $data['order_amount']=$order_amount;
        $data['money']=$money;
        $data['is_vip']=$is_vip;
        $data['is_free']=$is_free;
        $data['remark']=$remark;
        $data['phone']=$phone;
        $data['expire_time']=$panicinfo['cancel_order']*60+time()-5;
        $data['share_user_id']=$share_user_id;
        $data['pay_type']=$pay_type;
        //加记录
        $log=new Panicorder();
        $log->allowField(true)->save($data);
        $oid=$log->id;

        //下分销订单
        $order=Panicorder::get($oid);
        (new Distributionorder())->setDistributionOrder($order['user_id'],2,$order['store_id'],$oid,$order['order_amount'],$order['pid'],$share_user_id);

        //添加购买次数
        $mybuytimes=$redis->get('panicbuytimes'.$pid.'uid'.$user_id);
        if($mybuytimes){
            $redis->inc('panicbuytimes'.$pid.'uid'.$user_id,$num);
        }else{
            $redis->set('panicbuytimes'.$pid.'uid'.$user_id,$num);
        }
        //添加免单次数
        if($is_free==1){
            $mybuytimes=$redis->get('panicfreetimes'.$pid.'uid'.$user_id);
            if($mybuytimes){
                $redis->inc('panicfreetimes'.$pid.'uid'.$user_id,$num);
            }else{
                $redis->set('panicfreetimes'.$pid.'uid'.$user_id,$num);
            }
        }
        //添加公共订单
        $common=new Commonorder();
        $common->addCommonOrder(2,$pid,$user_id,$data['order_no'],$oid,$num,$panicinfo['store_id'],$order_amount,0);
        return $oid;
    }

    //获取商品列表信息
    public function getGoodsListByStoreId($store_id){
        $data=$this->where(['store_id'=>$store_id,'state'=>1,'is_del'=>0,'end_time'=>['gt',time()]])->order('id desc')->select();
        return $data;
    }

    public function check_version(){
        $config=getSystemConfig()['system'];
        if(StrCode($config['version'],'DECODE')!='advanced'){
            if(StrCode($config['version'],'DECODE')=='free'){
                $this->check_store_num(intval(StrCode($config['goods_num'],'DECODE')));
            }else{
                throw new \ZhyException(getErrorConfig('genuine'));
            }
        }
    }
    //获取数量
    private function check_store_num($num){
        $total_store_num=Db::name('panic')->count();
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
