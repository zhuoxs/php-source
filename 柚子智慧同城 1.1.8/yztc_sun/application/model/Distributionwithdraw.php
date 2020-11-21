<?php
namespace app\model;
use think\Loader;
use think\Db;

class Distributionwithdraw extends Base
{
    //获取已提现佣金
    public function getWithdrawMoney($user_id){
        $data=$this->where(['user_id'=>$user_id,'status'=>1])->sum('money');
        return $data;
    }
    //获取待打款佣金
    public function getWaitMoney($user_id){
        $data=$this->where(['user_id'=>$user_id,'status'=>0,'is_state'=>1,'state'=>0])->sum('money');
        return $data;
    }

}
