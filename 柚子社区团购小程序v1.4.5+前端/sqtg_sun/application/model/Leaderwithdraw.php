<?php

namespace app\model;

use app\base\model\Base;
use think\Db;
use think\Loader;

class Leaderwithdraw extends Base
{
    protected static function init()
    {
        parent::init();

//        新增后-判断是否免审核
        self::afterInsert(function ($model){
            $withdraw_noapplymoney = Config::get_value('leader_withdraw_noapplymoney',0);
            if ($model['amount']<=$withdraw_noapplymoney){
                $model->checked($model['id']);
            }
        });

//        提现申请
        self::beforeInsert(function ($model){
            $model->no = date("YmdHis") .rand(11111, 99999);

            $leader = new Leader();
            $leader->onLeaderwithdrawAdd($model);
        });

        self::beforeUpdate(function ($model){
            $old_info = self::get($model->id);
//            审核通过、提现到微信
            if ($old_info['check_state'] == 1 && $model['check_state'] == 2 && $model['wd_type'] == 1){
                self::take($model->id);
            }
//        提现打回、提现失败
            if (($old_info['check_state'] == 1 && $model['check_state'] == 3)||($old_info['state'] == 0 && $model['state'] == 2)){
                $leader = new Leader();
                $leader->onLeaderwithdrawFail($model);
            }
        });
    }

    public function leader(){
        return $this->hasOne('Leader','id','leader_id')->bind(array(
            'leader_name'=>'name',
        ));
    }
//    打款
    public static function take($id){
        $info = Leaderwithdraw::get($id);

        //        提现到微信
        if ($info['wd_type'] == 1){
            $system = System::get_curr();
            $user = User::get($info['user_id']);

            Loader::import('wxtake.wxtake');
            $wxtake = new \WeixinTake($system['appid'],$user['openid'],$system['mchid'],$system['wxkey'],$info['no'],100*$info['money']);
            $ret = $wxtake->take();

            if (!$ret['code']){
                $info->state = 1;
                $info->tx_time = time();
                $ret = $info->save();
            }else{
                $info->state = 2;
                $info->err_code = $ret['msg'];
                $ret = $info->save();
            }
        }else{
            $info->state = 1;
            $info->tx_time = time();
            $ret = $info->save();
        }

        return $ret;
    }
//    审核通过
    public static function checked($id){
        $info = Leaderwithdraw::get($id);
        $info->check_state = 2;
        $info->check_time = time();
        return $info->save();
    }
//    审核失败
    public static function checkedfail($id,$reason){
        $info = Leaderwithdraw::get($id);
        $info->check_state = 3;
        $info->fail_reason = $reason;
        $info->check_time = time();
        return $info->save();
    }
}
