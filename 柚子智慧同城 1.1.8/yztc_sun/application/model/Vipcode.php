<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/25
 * Time: 15:23
 */
namespace app\model;


class Vipcode extends Base
{
    //TODO::激活
    public function Activation($code,$user_id,$tel){
        $info=Vipcode::get(['code'=>$code]);
        if($info){
            if($info['isuse']==0){
                //修改激活码状态
                Vipcode::update(['isuse'=>1,'usetime'=>time(),'user_id'=>$user_id],['code'=>$code]);
                //添加开卡记录
                $log=new Openvip();
                $log->addLog(2,0,$info['day'].'天会员',$info['code'],$user_id,$info['day'],$info['uniacid']);
                //修改会员时间
                $user=new User();
                $user->editVip($user_id,$tel,$info['day']);
            }else{
                return_json('该激活码已使用或不存在',-1);
            }
        }else{
            return_json('该激活码不存在',-1);
        }

    }
}