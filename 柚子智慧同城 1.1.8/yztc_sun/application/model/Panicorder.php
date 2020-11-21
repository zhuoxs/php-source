<?php
/**
 * User: YangXinlan
 * DateTime: 2019/1/7 14:00
 */
namespace app\model;

use think\cache\driver\Redis;
use think\Db;

class Panicorder extends Base
{
    public function store(){
        return $this->hasOne('Store','id','store_id');
    }
    public function panic(){
        return $this->hasOne('Panic','id','pid');
    }
    //TODO::支付成功改订单状态
    public function editStatus($oid,$pid,$prepay_id='',$transaction_id='',$out_trade_no='',$pay_type=1){
        $data['is_pay']=1;
        $data['pay_type']=$pay_type;
        $data['pay_time']=time();
        if($prepay_id){
            $data['prepay_id']=$prepay_id;
        }
        $data['transaction_id']=$transaction_id;
        $data['out_trade_no']=$out_trade_no;
        $data['order_status']=20;
        Panicorder::update($data,['id'=>$oid]);
        //下分销订单
        $order=self::get($oid);
        (new Distributionorder())->setDistributionOrder($order['user_id'],2,$order['store_id'],$order['id'],$order['order_amount'],$order['pid'],$order['share_user_id'],1);

        $orderinfo=Panicorder::get($oid);
        //添加已购买人数
        $panic=new Panic();
        $redis=new Redis();
        $panic->addSalesnum($pid,$orderinfo['num']);
        //修改公共订单状态
        $common=new Commonorder();
        $common->editCommonOrderStatus(2,$oid,20);
        //发送模板消息
        $tem=new Template();

        $orderinfo['name']=Panic::get($orderinfo['pid'])['name'];
        $page='plugin/panic/mypanicorder/mypanicorder';
        $tem->tid1($orderinfo,$page);
        //发短信
        (new Sms())->SendSms($orderinfo['store_id'],0);
        //发钉钉
        (new Dingtalk())->sendtalk($orderinfo['store_id'],0);
        //打印机

    }
    //TODO::未支付未取消订单
    public function noPay($user_id,$pid){
        $ord=$this->where(['is_del'=>0,'is_pay'=>0,'user_id'=>$user_id,'pid'=>$pid,'order_status'=>10])->find();
        if($ord){
            return $ord['id'];
        }else{
            return 0;
        }
    }
    //TODO::取消订单
    public function cancelOrder($oid){
        $orderinfo=$this->mfind(['id'=>$oid]);
        $panic=new Panic();
        if($orderinfo['is_pay']==0&&$orderinfo['is_del']==0){
            $redis=new Redis();
            //加库存
            if($orderinfo['use_attr']==1){
                $attr=new Panicattrsetting();
                $attr->where(['attr_ids'=>$orderinfo['attr_ids']])->setInc('stock',$orderinfo['num']);
            }else{
                $panic->where(['id'=>$orderinfo['pid']])->setInc('stock',$orderinfo['num']);
            }
            //减少购买次数
            $redis->dec('panicbuytimes'.$orderinfo['pid'].'uid'.$orderinfo['user_id'],$orderinfo['num']);
            //减少免单次数
            if($orderinfo['is_free']==1){
                $redis->dec('panicfreetimes'.$orderinfo['pid'].'uid'.$orderinfo['user_id'],$orderinfo['num']);
            }
            //改订单状态
            Panicorder::update(['is_del'=>1,'order_status'=>5],['id'=>$oid]);
            //修改公共订单状态
            $common=new Commonorder();
            $common->editCommonOrderStatus(2,$oid,5);
            return true;
        }else{
            return_json('当前订单无法取消',-1);
        }
    }
    //TODO::支付回调
    public function panicNotify($data){
        global $_W;
        $attach=json_decode($data['attach'],true);
        $_W['uniacid']=$attach['uniacid'];
        $this->editStatus($attach['oid'],$attach['pid'],'',$data['transaction_id'],$data['out_trade_no']);
        echo 'SUCCESS';
    }
    //TODO::倒计时
    public function timingTask($oid){
        $orderinfo=$this->mfind(['id'=>$oid]);
        $task=array(
            'uniacid'=>$orderinfo['uniacid'],
            'type'=>'panicpay',
            'state'=>0,
            'level'=>1,
            'value'=>$oid,
            'create_time'=>time(),
            'execute_time'=>$orderinfo['expire_time']-5,
            'execute_times'=>1
        );
        $mtask=new Task();
        $mtask->allowField(true)->save($task);
//        Db::name('task')->insert($task);
    }
    //TODO::核销订单
    public function checkOrd($order_no,$num,$user_id){
        //管理员
        $orderinfo=Panicorder::get(['order_no'=>$order_no]);
        Storeuser::checkConfirmPermission($orderinfo['store_id'],$user_id);
        $panicinfo=Panic::get($orderinfo['pid']);
        //判断过期
        if($panicinfo['expire_time']<time()){
            return_json('该商品 已过期，无法核销',-1);
        }
        //判断订单状态
        if($orderinfo['order_status']==20){
            //判断已用份数
            if($orderinfo['write_off_num']<$orderinfo['num']){
                if($num>intval($orderinfo['num']-$orderinfo['write_off_num'])){
                    return_json('核销数量有误',-1);
                }
                //是否全部核销完毕
                if(($orderinfo['write_off_num']+$num)==$orderinfo['num']){
                    //修改订单状态
                    Panicorder::update(['write_off_status'=>2,'write_off_num'=>intval($orderinfo['write_off_num']+$num),'write_off_time'=>time(),'order_status'=>40],['order_no'=>$order_no]);
                    //修改公共订单
                    $common=new Commonorder();
                    $common->editCommonOrderStatus(2,$orderinfo['id'],40);

                    //完成订单进行佣金结算
                    (new Distributionorder())->setSettlecommission(2,$orderinfo['id'],$order_no,$orderinfo['store_id']);

                    //增加积分
                    $Integralrecord=new Integralrecord();
                    $score=$Integralrecord->getScore($orderinfo['order_amount']);
                    if($score>0) {
                        $Integralrecord->scoreAct($orderinfo['user_id'], 1, $score, $orderinfo['id']);
                    }

                }else{
                    //修改订单状态
                    Panicorder::update(['write_off_status'=>1,'write_off_num'=>intval($orderinfo['write_off_num']+$num),'write_off_time'=>time(),'order_status'=>20],['order_no'=>$order_no]);
                }

                //添加商户收入
                (new Store())->setConfirmAfter($orderinfo['store_id'],sprintf("%.2f", ($orderinfo['order_amount']/$orderinfo['num']*$num)),2,$orderinfo['id'],$order_no,$orderinfo['user_id'],$num);
                return_json();
            }else{
                return_json('当前订单已全部核销完',-1);
            }
        }else{
            return_json('当前订单无法核销',-1);
        }

    }
}