<?php
namespace app\model;

use app\base\model\Base;
use app\model\Pinorder;
use think\Db;

class Pinheads extends Base
{
    //判断拼团是否成功
    public function checkNum($heads_id,$oid){
        //团员---》 达到拼团人数
        $ord=new Pinorder();
        $nowmun=$ord->allpayNum($heads_id);
//        $headsinfo=self::get($heads_id);
        $headsinfo=  Db::name('pinheads')->where(['id'=>$heads_id])->find();
//        var_dump($nowmun,$headsinfo['groupnum']);exit;
        if($nowmun==$headsinfo['groupnum']){
            //删除成团倒计时任务
            $task=new Task();
            $task->where(['type'=>'pinopen','value'=>$oid])->delete();
            //拼团成功
            Db::name('pinheads')->where(['id'=>$heads_id])->update(['status'=>2]);
//            $this->save(['status'=>2],['id'=>$heads_id]);
            //修改订单成团状态
//            $ord->save(['order_status'=>2],['heads_id'=>$heads_id]);
//            Db::name('pinorder')->where(['heads_id'=>$heads_id,'is_del'=>0])->update(['order_status'=>2,'group_time'=>time()]);
            $pinorders = Pinorder::where(['heads_id'=>$heads_id,'is_del'=>0])->select();
            foreach($pinorders as $pinorder){
                $pinorder->order_status=2;
                $pinorder->group_time=time();
                $pinorder->save();
            }
        }
    }
    function user(){
        return $this->hasOne('User','id','user_id')->bind([
            'user_name'=>'name',
            'user_img'=>'img',
        ]);
    }
    function pinorder(){
        return $this->hasOne('Pinorder','id','oid')->bind(['leader_id'=>'leader_id','goods_id'=>'goods_id']);
    }
}
