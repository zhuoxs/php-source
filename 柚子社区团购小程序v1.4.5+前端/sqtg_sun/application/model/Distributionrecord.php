<?php

namespace app\model;

use app\base\model\Base;
use think\Db;
use think\Hook;

class Distributionrecord extends Base
{
    protected static function init()
    {
        parent::init();

        self::beforeUpdate(function ($model){
            $old_model = Distributionrecord::get($model->id);
//        分佣订单完成
            if($old_model->state == 1 && $model->state == 2){
                Hook::listen('on_distributionrecord_finish',$model);
            }
        });
    }
    public function user(){
        return $this->hasOne('User','id','user_id')->bind(array(
            'img'=>'img',
        ));
    }

    public function onOrdergoodsAdded($ordergoods){
//            计算佣金
        $distribution_amount = 0;
        $distribution_level = Config::get_value('distribution_level',0);//佣金层级
        if ($distribution_level){
//              一级id
            $user_id1 = $ordergoods['user_id'];
//            判断 自己不是分销商 或者 没有开启内购 则取上级为分销商
            if (!User::isDistribution($user_id1) || !Config::get_value('distribution_self',0)){
                $user_id1 = User::get($user_id1)['share_user_id'];
            }
            if ($user_id1 && User::isDistribution($user_id1)){
//                    计算一级分佣
                $distribution_draw_type = Config::get_value('distribution_draw_type',1);

                $distribution_rate_level1 = 0;
                $distribution_money_level1 = 0;
                if ($distribution_draw_type == 1){
                    $distribution_rate_level1 = Config::get_value('distribution_rate_level1',0);
                }else{
                    $distribution_money_level1 = Config::get_value('distribution_money_level1',0);
                }
                $distribution_amount1 = round($ordergoods['pay_amount'] * $distribution_rate_level1/100 + $distribution_money_level1 * $ordergoods->num,2);
                $distribution_amount += $distribution_amount1;
                if ($distribution_amount1){
                    $record = [
                        'order_id'=>$ordergoods['order_id'],
                        'goods_id'=>$ordergoods['id'],
                        'user_id'=>$user_id1,
                        'rate'=>$distribution_rate_level1,
                        'amount'=>$ordergoods['pay_amount'],
                        'money'=>$distribution_amount1,
                        'level'=>1,
                        'state'=>1,
                    ];
                    Distributionrecord::create($record);
                }
                if ($distribution_level >= 2){
//                        二级
                    $user_id2 = User::get($user_id1)['share_user_id'];
                    if ($user_id2 && User::isDistribution($user_id2)){
                        $distribution_rate_level2 = 0;
                        $distribution_money_level2 = 0;
                        if ($distribution_draw_type == 1){
                            $distribution_rate_level2 = Config::get_value('distribution_rate_level2',0);
                        }else{
                            $distribution_money_level2 = Config::get_value('distribution_money_level2',0);
                        }
                        $distribution_amount2 = round($ordergoods['pay_amount'] * $distribution_rate_level2/100 + $distribution_money_level2 * $ordergoods->num,2);
                        $distribution_amount += $distribution_amount2;
                        if ($distribution_amount2) {
                            $record = [
                                'order_id'=>$ordergoods['order_id'],
                                'goods_id'=>$ordergoods['id'],
                                'user_id'=>$user_id2,
                                'rate'=>$distribution_rate_level2,
                                'amount'=>$ordergoods['pay_amount'],
                                'money'=>$distribution_amount2,
                                'level'=>2,
                                'state'=>1,
                            ];
                            Distributionrecord::create($record);
                        }
                        if ($distribution_level >= 3) {
                            //三级
                            $user_id3 = User::get($user_id2)['share_user_id'];
                            if ($user_id3 && User::isDistribution($user_id3)) {
                                $distribution_rate_level3 = 0;
                                $distribution_money_level3 = 0;
                                if ($distribution_draw_type == 1){
                                    $distribution_rate_level3 = Config::get_value('distribution_rate_level3',0);
                                }else{
                                    $distribution_money_level3 = Config::get_value('distribution_money_level3',0);
                                }
                                $distribution_amount3 = round($ordergoods['pay_amount'] * $distribution_rate_level3/100 + $distribution_money_level3 * $ordergoods->num,2);
                                $distribution_amount += $distribution_amount3;
                                if ($distribution_amount3) {
                                    $record = [
                                        'order_id'=>$ordergoods['order_id'],
                                        'goods_id'=>$ordergoods['id'],
                                        'user_id'=>$user_id3,
                                        'rate'=>$distribution_rate_level3,
                                        'amount'=>$ordergoods['pay_amount'],
                                        'money'=>$distribution_amount3,
                                        'level'=>3,
                                        'state'=>1,
                                    ];
                                    Distributionrecord::create($record);
                                }
                            }
                        }
                    }
                }
            }
        }
        $ordergoods->distribution_money = $distribution_amount;
        $ordergoods->save();
    }

    public function onOrdergoodsFinish($ordergoods){
        $records = Distributionrecord::where([
            'state'=>1,
            'order_id'=>$ordergoods->order_id,
            'goods_id'=>$ordergoods->id,
        ])->select();

        foreach ($records as $record) {
            $record->state = 2;
            $record->save();
        }
    }

    //    未结算分佣转可提现
    public static function convert($id){
        $record = self::get($id);

        $distribution = Distribution::get(['user_id'=>$record->user_id]);

        if ($distribution){
            $distribution->setInc('money',$record['money']);
            $distribution->setDec('money_future',$record['money']);
        }

        return true;
    }
}
