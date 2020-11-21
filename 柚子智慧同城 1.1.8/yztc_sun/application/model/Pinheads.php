<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 14:31
 */
namespace app\model;


use think\Db;

class Pinheads extends Base
{
    //判断拼团是否成功
    public function checkNum($heads_id,$oid){
        //团员---》 达到拼团人数
        $ord=new Pinorder();
        $nowmun=$ord->allpayNum($heads_id);
        $headsinfo=  Db::name('pinheads')->where(['id'=>$heads_id])->find();
        if($nowmun==$headsinfo['groupnum']){
            //删除成团倒计时任务
            $task=new Task();
            $task->where(['type'=>'pinopen','value'=>$oid])->delete();
            //拼团成功
            Db::name('pinheads')->where(['id'=>$heads_id])->update(['status'=>2]);
            //修改订单成团状态
            Db::name('pinorder')->where(['heads_id'=>$heads_id])->update(['order_status'=>25,'group_time'=>time()]);
        }
    }
}
