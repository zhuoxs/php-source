<?php
namespace app\model;

use app\base\model\Base;

class Integralrecord extends Base{

    /**
     * 可获得积分
     */
    public function getScore($money=0){
//        return 0 ;
        $conf=new Integralconf();
        $set=$conf->get_curr();
        if($set['is_open']==1){
            $fanscore=floor($money*$set['score']/$set['cost']);
            return $fanscore ;
        }else{
            return 0 ;
        }
    }
    /**
     * 积分操作
     * type 1.购买返积分 2.积分商城消费
     */
    public function scoreAct($user_id,$type=1,$score=0,$goods_id=0){
        global $_W;
        $data['uniacid']=$_W['uniacid'];
        $data['user_id']=$user_id;
        $data['goods_id']=$goods_id;
        $data['type']=$type;
        $data['score']=$score;
        $data['create_time']=time();
        /*新增记录*/
        $this->allowField(true)->save($data);
//        Integralrecord::create($data);
        //修改总积分
        $user=new User();
        if($score>0){
            $user->where('id',$user_id)->setInc('integral',$score);
        }
        //修改现有积分
        $user->where('id',$user_id)->setInc('now_integral',$score);
    }

}