<?php
namespace app\api\controller;

use app\model\Recharge;
use app\model\Userbalancerecord;
use app\base\controller\Api;
use think\Db;
use app\model\Rechargerecord;
use app\model\User;

class ApiRecharge extends Api
{
    //TODO::充值设置
    public function rechargeSet(){
        $data=Recharge::get_curr();
        $data['details']=json_decode($data['details'],true);
        success_json($data);
    }

    //TODO::充值

    /**
     * param $user_id 用户id
     * param recmoney 充值金额
     * param $send_money 赠送金额
     */
    public function recharge(){
        $rec=new Recharge();
        $recinfo=$rec->get_curr();
        $recinfo['details']=json_decode($recinfo['details'],true);
        $user_id=input('post.user_id');
        if($user_id>0){
            $user=new User();
            $info['userinfo']=$user->mfind(['id'=>$user_id],'balance');
            $info['recharge']=$recinfo;
            return_json('success',0,$info);
        }else{
            return_json('user_id不能为空',1);
        }
    }

    /**
     * 余额明细
     */
    public function balanceList(){
        $user_id = input('post.user_id', 0);
        if ($user_id > 0){
            $bal=new Userbalancerecord();
            $where['user_id']=$user_id;
            $order['create_time']='desc';
            $page = input('post.page', 1);
            $length = input('post.length', 10);
            $list=$bal->mlist($where,$order,$page,$length);
            return_json('success',0,$list);
        }else{
            return_json('user_id不能为空',1);
        }
    }
    /**public function recharge(Rechargerecord $rechargerecord){
        global $_W;
        $user_id = input('post.user_id', 0);
        if ($user_id > 0){
            $user=new \app\model\User();
            $userinfo = $user->get($user_id);
            $rec=new Recharge();
            $recinfo=$rec->get_curr();
            $money=input('post.recmoney');
            $send_money=input('post.send_money',0);
            if($recinfo['recharge_lowest']<=$money){
                $allmoney= sprintf("%.2f",$money+$send_money);

                //乐慧云原版调支付 20190718
/*                $wx=new ApiWx();
                $attach=json_encode(array('type'=>'recharge','uniacid'=>$userinfo['uniacid'],'recmoney'=>$allmoney,'send_money'=>$send_money,'user_id'=>$user_id));
                $wxinfo=$wx->pay($userinfo['openid'],$money,$attach);
                return_json('调支付',0,$wxinfo);

                //开心版支付

                $log['user_id']=$userinfo['id'];
                $log['money']=$allmoney;
                $log['send_money']=$send_money;
                $rechargerecord->allowField(true)->save($log);
                $wx = new Cwx();
                $wxinfo = $wx->pay($userinfo->openid,$money,$rechargerecord->id,'recharge');
                return_json('调支付',0,$wxinfo);
            }else{
                return_json('最低需充值'.$recinfo['recharge_lowest'].'元',1);
            }
        }else{
            return_json('user_id不能为空',1);
        }
    }*/

    /**
     * 调支付
    */
    public function pay(Rechargerecord $rechargerecord){
        global $_W;
        $user_id = input('post.user_id', 0);
        if ($user_id > 0){
            $user=new User();
            $userinfo=$user->get($user_id);
            $rec=new Recharge();
            $recinfo=$rec->get_curr();
            $money=input('post.recmoney');
            $send_money=input('post.send_money');
            if($recinfo['recharge_lowest']<=$money){
                $allmoney= sprintf("%.2f",$money+$send_money);
                $log['user_id']=$userinfo['id'];
                $log['money']=$allmoney;
                $log['send_money']=$send_money;
                $rechargerecord->allowField(true)->save($log);
                $wx = new Cwx();
                $wxinfo = $wx->pay($userinfo->openid,$money,$rechargerecord->id,'recharge');
                return_json('调支付',0,$wxinfo);
            }else{
                return_json('最低需充值'.$recinfo['recharge_lowest'].'元',1);
            }
        }else{
            return_json('user_id不能为空',1);
        }
    }
}