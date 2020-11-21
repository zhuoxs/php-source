<?php

namespace app\model;

use app\base\model\Base;
use think\Exception;
use think\Hook;

class Leader extends Base
{
    public $order = 'create_time desc,check_state';//默认排序
    protected static function init()
    {
        parent::init();

        self::beforeInsert(function ($model){
            Hook::listen('on_leader_add',$model);
        });
        self::beforeUpdate(function ($model){
            $old_info = self::get($model->id);
//            审核
            if ($old_info['check_state'] == 1 && $model['check_state'] == 2){
                Hook::listen('on_leader_checked',$model);
            }

        });
        self::beforeDelete(function ($model){
            Hook::listen('on_leader_deleted',$model);
        });
    }
    public function user(){
        return $this->hasOne('User','id','user_id')->bind(array(
            'openid'=>'openid',
            'pic'=>'img',
        ));
    }
    public function onLeaderbillAdd($bill){
        $leader = Leader::get($bill->leader_id);
        $leader->money += $bill->money;
        $leader->save();
    }
    public function onLeaderbillDelete($bill){
        $leader = Leader::get($bill->leader_id);
        $leader->money -= $bill->money;
        $leader->save();
    }
    public function onLeaderwithdrawAdd($info){
        $leader = Leader::get($info->leader_id);
        $leader->money -= $info->amount;
        $leader->save();
    }
    public function onLeaderwithdrawFail(&$info){
        $leader = Leader::get($info->leader_id);
        $leader->money += $info->amount;
        $leader->save();
    }

    public static function checkWork($id){
        //        验证团长工作日
        $leader = Leader::get($id);
        $weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
        $week = $weekarray[date("w")];
        if (!$leader['workday']){
            throw new Exception("当前团长属于休息状态");
        }
        if (!in_array($week,explode(',',$leader['workday']))){
            throw new Exception("当前团长属于休息状态，您可以在星期（{$leader['workday']}）下单");
        }
    }
}
