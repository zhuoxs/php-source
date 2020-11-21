<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 17:33
 */
namespace app\model;


class Order extends Base
{
    //获取商品总订单数量
    public function getOrderNumByGid($user_id,$gid){
        $num=$this->where(['user_id'=>$user_id,'gid'=>$gid,'order_status'=>['egt',10],'after_sale'=>0])->sum('num');
        $num1=$this->where(['user_id'=>$user_id,'gid'=>$gid,'order_status'=>['egt',10],'after_sale'=>1,'review_status'=>['neq',1]])->sum('num');
        return $num+intval($num1);
    }
    //获取免费商品订单数量
    public function getOrderFreeNumByGid($user_id,$gid){
        $num=$this->where(['user_id'=>$user_id,'gid'=>$gid,'is_free'=>1,'order_status'=>['egt',10],'after_sale'=>0])->sum('free_num');
        return $num;
    }
    //获取商品总参与人数
    public function getOrderCyNumByGid($gid){
        $num=$this->where(['gid'=>$gid])->group('user_id')->count();
        return $num;
    }
    //修改订单状态、减少库存、增加商品销量、人气 (商家销量改成确认收货或者核销）
    public function updateOrderStatusAndStock($order_id,$gid,$num,$store_id,$transaction_id,$out_trade_no,$order_amount,$is_free=0,$attr_ids){
        //修改订单状态
        $this->allowField(true)->save(['pay_status'=>1,'order_status'=>20,'pay_time'=>time(),'transaction_id'=>$transaction_id,'out_trade_no'=>$out_trade_no,'is_free'=>$is_free],['id'=>$order_id]);
        $goods=Goods::get($gid);
        if($goods['use_attr']==1){
            (new Goods())->where(['id'=>$gid])->setDec('stock',$num);
            (new Goods())->where(['id'=>$gid])->setInc('sales_num',$num);
            (new Goodsattrsetting())->where(['goods_id'=>$gid,'attr_ids'=>$attr_ids])->setDec('stock',$num);
        }else{
            (new Goods())->where(['id'=>$gid])->setDec('stock',$num);
            (new Goods())->where(['id'=>$gid])->setInc('sales_num',$num);
        }
      //  (new Store())->where(['id'=>$store_id])->setInc('sale_count',$num);
        if($order_amount>0){
            (new Store())->where(['id'=>$store_id])->setInc('popularity',intval($order_amount));
        }

    }
    //核销订单 多次核销
    public function confirmCommonOrder($order_no,$num,$user_id){
        $data=self::get(['order_no'=>$order_no]);
        if($data['order_status']!=20&&$data['order_status']!=30){
            error_json('只有待使用和待收货状态才可以核销');
        }
        if($data['after_sale']==1){
            error_json('售后处理,不能核销');
        }
        $goods=Goods::get($data['gid']);
        if(intval(strtotime($goods['expire_time']))<time()){
            error_json('活动核销已过期');
        }

        //判断核销权限
        (new Storeuser())->checkConfirmPermission($data['store_id'],$user_id);
        $current_num=intval($data['write_off_num']+$num);
        //判断核销数量是否全部
        if($current_num>intval($data['num'])){
            error_json('超过未核销数量,不能核销');
        }
        //修改订单核销状态和核销数量
        $this->allowField(true)->save(['write_off_status'=>1,'write_off_num'=>$current_num,'confirm_time'=>time(),'write_off_time'=>time()],['id'=>$data['id']]);
        if($current_num==intval($data['num'])){
            //修改订单状态和核销数量
            $this->allowField(true)->save(['order_status'=>40,'confirm_time'=>time(),'write_off_time'=>time(),'write_off_status'=>2,'write_off_num'=>$current_num],['id'=>$data['id']]);
            //修改总订单状态
            (new Commonorder())->editCommonOrderStatus(1,$data['id'],40);
        }
        //核销完成对商家操作
        $money=sprintf("%.2f",$data['order_amount']/$data['num']*$num);
        (new Store())->setConfirmAfter($data['store_id'],$money,1,$data['id'],$order_no,$user_id,$num);
        if($current_num==intval($data['num'])){
            //完成订单进行佣金结算
            (new Distributionorder())->setSettlecommission(1,$data['id'],$order_no,$data['store_id']);
            //增加积分
            $Integralrecord=new Integralrecord();
            $score=$Integralrecord->getScore($data['order_amount']);
            if($score>0) {
                $Integralrecord->scoreAct($data['user_id'], 1, $score, $data['id']);
            }
        }
        success_json('核销成功');
    }
    //确认收货
    public function confirmOrder($order_id){
        $data=self::get($order_id);
        if($data['order_status']!=20&&$data['order_status']!=30){
            error_json('只有待发货和待收货状态才可以确认收货。');
        }
        //增加用户消费金额
        if($data['order_amount']>0){
            (new User())->where(['id'=>$data['user_id']])->setInc('total_consume',$data['order_amount']);
        }
        //修改订单状态
        $this->allowField(true)->save(['order_status'=>40,'confirm_time'=>time()],['id'=>$order_id]);
        //修改总订单状态
        (new Commonorder())->editCommonOrderStatus(1,$order_id,40);
        if($data['store_id']>0){
            if(['order_amount']>0){
            //增加商户余额
                (new Store())->where(['id'=>$data['store_id']])->setInc('balance',$data['order_amount']);
            }
            $store=Store::get($data['store_id']);
            if(!$store){
                error_json('商家不存在');
            }
            //增加商家记录
            $detail='订单完成-订单id:'.$order_id.' 订单号:'.$data['order_no'];
            $mercapdetails=[
                'store_id'=>$data['store_id'],
                'store_name'=>$store['name'],
                'mcd_type'=>1,
                'openid'=>$data['openid'],
                'user_id'=>$data['user_id'],
                'sign'=>1,
                'mcd_memo'=>$detail,
                'money'=>$data['order_amount'],
                'order_id'=>$data['id'],
                'add_time'=>time(),
                'now_money'=>$store['balance'],
            ];
            (new Mercapdetails())->allowField(true)->save($mercapdetails);
            //增加商家总销量
            (new Store())->where(['id'=>$data['store_id']])->setInc('sale_count',$data['num']);
        }
    }
    //退款成功增加商品和商品规格库存减少商品和商家销量
    public function afterRefund($order_id){
        $order=self::get($order_id);
        if($order['after_sale']==1&&$order['refund_status']==1){
            $goodModel=new Goods();
            //增加商品和商品规格库存、减少商品销量、商家销量
            $goodModel->where(['id'=>$order['gid']])->setInc('stock',$order['num']);
            $goodModel->where(['id'=>$order['gid']])->setDec('sales_num',$order['num']);
            $storeModel=new Store();
            $storeModel->where(['id'=>$order['store_id']])->setDec('sale_count',$order['num']);
            //增加规格商品库存
            $goodsModel=new Goods();
            $goods=$goodsModel::get($order['gid']);
            //订单详情
            $orderdetail=Orderdetail::get(['order_id'=>$order['id']]);
            if($orderdetail['attr_ids']&&$goods['use_attr']==1){
                $goodsattrsettingModel=new Goodsattrsetting();
                $goodsattrsetting=$goodsattrsettingModel->where(['goods_id'=>$orderdetail['gid'],['attr_ids'=>$orderdetail['attr_ids']]])->find();
                if($goodsattrsetting){
                    $goodsattrsetting->where(['id'=>$goodsattrsetting['id']])->setInc('stock',$orderdetail['num']);
                }
            }
        }
    }

}