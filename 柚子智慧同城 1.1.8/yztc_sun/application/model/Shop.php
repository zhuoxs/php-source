<?php

namespace app\model;


class Shop extends Base
{
   /**
    * 添加商家收入
    */
    public function addShopIncome($sid,$type,$typeid,$money){
        //1.提现 2.包车 3.租车
        if($type==1){
            //提现减少总收入、余额
            $this->where('id',$sid)->setDec('total_money',$money);
            $this->where('id',$sid)->setDec('money',$money);
        }elseif ($type==2 || $type==3){
            //添加总收入、余额
            $this->where('id',$sid)->setInc('total_money',$money);
            $this->where('id',$sid)->setInc('money',$money);
        }
        //添加记录
        $log['sid']=$sid;
        $log['type']=$type;
        $log['typeid']=$typeid;
        $log['money']=$money;
        $log['uniacid']=Shop::get($sid)['uniacid'];
        $model=new Shopbalance();
        $model->allowField(true)->save($log);
    }
    //添加商家评分
    public function addScore($sid,$score){
        $this->where('id',$sid)->setInc('all_score',$score);
        $this->where('id',$sid)->setInc('all_scorenum');
    }

}
