<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 16:04
 */
namespace app\model;

use app\model\Distributionorder;
use think\Db;

class Pinorder extends Base
{
    /**
     * 获取购买次数
    */
    public function buyNum($goods_id,$user_id){
        $num=$this->where(['goods_id'=>$goods_id,'user_id'=>$user_id,'is_del'=>0,'after_sale'=>['lt',2]])->count();
        return $num;
    }
    /**
     * 单购/团长免费购买成功
     * join  0.团长  1.参团 2.单购
    */
    public function freePay($oid,$join){
        //修改订单信息
        $orderinfo=$this->mfind(['id'=>$oid]);
        if($orderinfo['heads_id']>0){
            $log['order_status']=20;
        }else{
            $log['order_status']=25;
        }
        $log['is_pay']=1;
        $log['pay_type']=1;
        $log['pay_time']=time();
        $this->where(['id'=>$oid])->update($log);
        //团长添加成团倒计时
        $head=new Pinheads();
        if($join==0){
            $goodsinfo=Pingoods::get(['id'=>$orderinfo['goods_id']]);
            $exper=$goodsinfo['group_time']*60*60+time();
            if($orderinfo['heads_id']>0){

                $head->save(['status'=>1,'expire_time'=>$exper],['id'=>$orderinfo['heads_id']]);
                //添加成团倒计时任务
                $task=array(
                    'uniacid'=>$orderinfo['uniacid'],
                    'type'=>'pinopen',
                    'state'=>0,
                    'level'=>1,
                    'value'=>$oid,
                    'create_time'=>time(),
                    'execute_time'=>$exper-5,
                    'execute_times'=>1
                );
                Db::name('task')->insert($task);
            }
        }
        //参团判断是否成团
        if($join==1){
            $orderinfo=Db::name('pinorder')->where(['id'=>$oid])->find();
            $head->checkNum($orderinfo['heads_id'],$oid);
        }

    }
    /**
     * 单购/团长支付成功回调
     */
    public function notify($data){
        global $_W;
        $attach=json_decode($data['attach'],true);
        $_W['uniacid']=$attach['uniacid'];
        $oid=$attach['oid'];
        //修改订单信息
        $orderinfo=$this->mfind(['id'=>$oid]);
        if($orderinfo['heads_id']>0){
            $log['order_status']=20;
        }else{
            $log['order_status']=25;
        }
        $log['out_trade_no']=$data['out_trade_no'];
        $log['transaction_id']=$data['transaction_id'];
        $log['is_pay']=1;
        $log['pay_type']=1;
        $log['pay_time']=time();
        $this->where(['id'=>$oid])->update($log);

        //下分销订单
        $order=self::get($oid);
        (new Distributionorder())->setDistributionOrder($order['user_id'],3,$order['store_id'],$order['id'],$order['order_amount'],$order['goods_id'],$order['share_user_id'],1);

        //修改团长信息
        //删除支付任务
        $task=new Task();
        $task->where(['type'=>'pinpay','value'=>$oid])->delete();
        if($orderinfo['is_head']>0){
            $goodsinfo=Pingoods::get(['id'=>$orderinfo['goods_id']]);
            $exper=$goodsinfo['group_time']*60*60+time();
            if($orderinfo['heads_id']>0){
                $head=new Pinheads();
                $head->save(['status'=>1,'expire_time'=>$exper],['id'=>$orderinfo['heads_id']]);
                //添加成团倒计时任务
                $task=array(
                    'uniacid'=>$orderinfo['uniacid'],
                    'type'=>'pinopen',
                    'state'=>0,
                    'level'=>1,
                    'value'=>$oid,
                    'create_time'=>time(),
                    'execute_time'=>$exper-5,
                    'execute_times'=>1
                );
                Db::name('task')->insert($task);
//                $this->timingTask(2,$oid);
            }
        }

        echo 'SUCCESS';
    }
    /**
     * 团员支付成功回调
    */
    public function joinNotify($data){
        global $_W;
        $attach=json_decode($data['attach'],true);
        $_W['uniacid']=$attach['uniacid'];
        $oid=$attach['oid'];
        //修改订单信息
        $log['out_trade_no']=$data['out_trade_no'];
        $log['transaction_id']=$data['transaction_id'];
        $log['order_status']=20;
        $log['is_pay']=1;
        $log['pay_type']=1;
        $log['pay_time']=time();
        $this->where(['id'=>$oid])->update($log);

        //下分销订单
        $order=self::get($oid);
        (new Distributionorder())->setDistributionOrder($order['user_id'],3,$order['store_id'],$order['id'],$order['order_amount'],$order['goods_id'],$order['share_user_id'],1);

        //判断人数 ，是否拼团成功
        $heads=new Pinheads();

        $orderinfo=Db::name('pinorder')->where(['id'=>$oid])->find();
        $heads->checkNum($orderinfo['heads_id'],$oid);
        //删除任务
        $task=new Task();
        $task->where(['type'=>'pinpay','value'=>$oid])->delete();
        echo 'SUCCESS';
    }
    /**
     * 团员列表
    */
    public function grouplist($heads_id){
        global $_W;
        $list=$this->where(['uniacid'=>$_W['uniacid'],'heads_id'=>$heads_id,'is_del'=>0])->order(['is_head'=>'desc','create_time'=>'asc'])->select();
        foreach ($list as $key =>$value){
            $list[$key]['userinfo']=User::get(['id'=>$value['user_id']]);
        }
        return $list;
    }
    /**
     * 获取团员总人数
    */
    public function allNum($heads_id){
        global $_W;
        $num=$this->where(['uniacid'=>$_W['uniacid'],'heads_id'=>$heads_id,'is_del'=>0])->field('id')->count();
        return $num;
    }
    /**
     * 获取已支付团员总人数
     */
    public function allpayNum($heads_id){
        global $_W;
        $num=$this->where(['heads_id'=>$heads_id,'is_del'=>0,'is_pay'=>1])->field('id')->count();
        return $num;
    }
    /**
     * 添加计时任务
    */
    public function timingTask($type,$oid){
        $orderinfo=$this->mfind(['id'=>$oid]);
        //1.支付倒计时
        if($type==1){
            $task=array(
                'uniacid'=>$orderinfo['uniacid'],
                'type'=>'pinpay',
                'state'=>0,
                'level'=>1,
                'value'=>$oid,
                'create_time'=>time(),
                'execute_time'=>$orderinfo['expire_time']-5,
                'execute_times'=>1
            );
        }elseif ($type==2){
            //2.开团倒计时
            $head=new Pinheads();
            $headinfo=$head->mfind(['id'=>$orderinfo['heads_id']]);
            $task=array(
                'uniacid'=>$orderinfo['uniacid'],
                'type'=>'pinopen',
                'state'=>0,
                'level'=>1,
                'value'=>$oid,
                'create_time'=>time(),
                'execute_time'=>$headinfo['expire_time']-5,
                'execute_times'=>1
            );
        }

//        Db::name('task')->insert($task);
        $mod=new Task();
//        var_dump($task);exit;
        $mod->allowField(true)->save($task);
    }
    /**
     * 支付过期
    */
    public  function payOverdue($value){
        $oid=intval($value);
        $orderinfo=$this->mfind(['id'=>$oid,'is_del'=>0]);
        if($orderinfo['is_pay']==0){
            //返回库存，销量
            $goods=new Pingoods();
            $goods->updateNum($orderinfo['goods_id'],$orderinfo['num'],$orderinfo['attr_ids']);
            //删除订单
            $this->save(['is_del'=>1],['id'=>$oid]);
            return true ;
        }else{
            return true ;
        }
    }
    /**
     * 拼团过期
    */
    public function openOverdue($value){
        $oid=intval($value);
        $heads=new Pinheads();
        $headsinfo=$heads->mfind(['oid'=>$oid]);
        if($headsinfo['status']==1){
            $heads->allowField(true)->save(['status'=>3],['id'=>$headsinfo['id']]);
            //退款、返库存、减销量
            $orderinfo=$this->mfind(['id'=>$oid]);
            $pin=new Pingoods();
            $pin->updateNum($orderinfo['goods_id'],$orderinfo['num'],$orderinfo['attr_ids']);
            //获取所有已支付订单列表
            $paylist=$this->where(['uniacid'=>$orderinfo['uniacid'],'heads_id'=>$orderinfo['heads_id'],'is_del'=>0,'is_pay'=>1])->select();
            foreach ($paylist as $key =>$value){
                $refund=new Pinrefund();
                $group_orderinfo=Pinorder::get($value['id']);
                $refund->pinFailRefund($group_orderinfo);
            }
            return true;
        }else{
            return true;
        }
    }
    //TODO::核销订单
    public function checkOrd($order_no,$num,$user_id){
        //管理员
        $orderinfo=Pinorder::get(['order_no'=>$order_no,'is_del'=>0,'after_sale'=>0]);
        Storeuser::checkConfirmPermission($orderinfo['store_id'],$user_id);
        $goodsinfo=Pingoods::get($orderinfo['goods_id']);
        //判断过期
        if($goodsinfo['expire_time']<time()){
            return_json('该商品 已过期，无法核销',-1);
        }
        //判断订单状态
        if($orderinfo['order_status']==25){
            //判断已用份数
            if($orderinfo['write_off_num']<$orderinfo['num']){
                if($num>intval($orderinfo['num']-$orderinfo['write_off_num'])){
                    return_json('核销数量有误',-1);
                }
                //是否全部核销完毕
                if(($orderinfo['write_off_num']+$num)==$orderinfo['num']){
                    //修改订单状态
                    Pinorder::update(['write_off_status'=>2,'write_off_num'=>intval($orderinfo['write_off_num']+$num),'write_off_time'=>time(),'order_status'=>40],['order_no'=>$order_no]);
                    //修改公共订单
                    $common=new Commonorder();
                    $common->editCommonOrderStatus(4,$orderinfo['id'],40);

                    //完成订单进行佣金结算
                    (new Distributionorder())->setSettlecommission(3,$orderinfo['id'],$order_no,$orderinfo['store_id']);

                    //增加积分
                    $Integralrecord=new Integralrecord();
                    $score=$Integralrecord->getScore($orderinfo['order_amount']);
                    if($score>0) {
                        $Integralrecord->scoreAct($orderinfo['user_id'], 1, $score, $orderinfo['id']);
                    }

                }else{
                    //修改订单状态
                    Pinorder::update(['write_off_status'=>1,'write_off_num'=>intval($orderinfo['write_off_num']+$num),'write_off_time'=>time(),'order_status'=>25],['order_no'=>$order_no]);
                }
                //添加商户收入
                (new Store())->setConfirmAfter($orderinfo['store_id'],sprintf("%.2f", ($orderinfo['order_amount']/$orderinfo['num']*$num)),4,$orderinfo['id'],$order_no,$orderinfo['user_id'],$num);
                return_json();
            }else{
                return_json('当前订单已全部核销完',-1);
            }
        }else{
            return_json('当前订单无法核销',-1);
        }

    }
}