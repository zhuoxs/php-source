<?php

namespace app\model;

use app\base\model\Base;
use think\Db;
use think\Hook;
use think\Loader;

class Distributionwithdraw extends Base
{
    protected static function init()
    {
        parent::init();

        self::beforeInsert(function ($model){
//            补充信息
            $model['no'] = date("YmdHis") .rand(10000, 99999);
            $distribution = Distribution::get(['user_id'=>$model['user_id']]);
            $model['distribution_id'] = $distribution['id'];
//            申请提现事件
            Hook::listen('on_distributionwithdraw_add',$model);
        });
//        新增后-判断是否免审核
        self::afterInsert(function ($model){
            $withdraw_noapplymoney = Config::get_value('distribution_withdraw_noapplymoney',0);
            if ($model['amount']<=$withdraw_noapplymoney){
                $model->checked($model['id']);
            }
        });

        self::beforeUpdate(function ($model){
            $old_info = self::get($model->id);
//            审核通过、提现到微信
            if ($old_info['check_state'] == 1 && $model['check_state'] == 2 && $model['wd_type'] == 1){
                self::take($model->id);
            }
//        提现打回、提现失败
            if (($old_info['check_state'] == 1 && $model['check_state'] == 3)||($old_info['state'] == 0 && $model['state'] == 2)){
                Hook::listen('on_distributionwithdraw_fail',$model);
            }
//        提现成功
            if ($old_info['state'] == 0 && $model['state'] == 1){
                Hook::listen('on_distributionwithdraw_success',$model);
            }
        });
    }

    public function distribution(){
        return $this->hasOne('Distribution','id','distribution_id')->bind(array(
            'distribution_name'=>'name',
        ));
    }
//    打款
    public static function take($id){
        $info = Distributionwithdraw::get($id);

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
        $info = self::get($id);
        $info->check_state = 2;
        $info->check_time = time();
        return $info->save();
    }
//    审核失败
    public static function checkedfail($id,$reason){
        $info = self::get($id);
        $info->check_state = 3;
        $info->fail_reason = $reason;
        $info->check_time = time();
        return $info->save();
    }
}
