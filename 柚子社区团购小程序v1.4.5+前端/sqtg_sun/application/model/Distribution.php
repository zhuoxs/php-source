<?php

namespace app\model;

use app\base\model\Base;

class Distribution extends Base
{
    public $order = 'create_time desc';//默认排序
    public function user(){
        return $this->hasOne('User','id','user_id')->bind(array(
            'img'=>'img',
        ));
    }
    public function getCheckTimeAttr($value)
    {
        if (!$value){
            return '';
        }
        return date('Y-m-d H:i:s',$value);
    }
    public function onDistributionrecordFinish($record){
        $distribution = Distribution::get([
            'user_id'=>$record->user_id,
        ]);

        if ($distribution){
            $distribution->setInc('amount',$record['money']);
            $distribution->setInc('money_future',$record['money']);
            $distribution->setInc('amount_order',$record['amount']);
        }
    }
    public function onDistributionwithdrawAdd($withdraw){
        $distribution = Distribution::get($withdraw['distribution_id']);

        if ($distribution){
            $distribution->setDec('money',$withdraw['amount']);
            $distribution->setInc('money_ing',$withdraw['amount']);
        }
    }
    public function onDistributionwithdrawFail(&$withdraw){
        $distribution = Distribution::get($withdraw['distribution_id']);

        if ($distribution) {
            $distribution->setInc('money', $withdraw['amount']);
            $distribution->setDec('money_ing', $withdraw['amount']);
        }
    }
    public function onDistributionwithdrawSuccess(&$withdraw){
        $distribution = Distribution::get($withdraw['distribution_id']);

        if ($distribution) {
            $distribution->setInc('money_old', $withdraw['amount']);
            $distribution->setDec('money_ing', $withdraw['amount']);
        }
    }
}
