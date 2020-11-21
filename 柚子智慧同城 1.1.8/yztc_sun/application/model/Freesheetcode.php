<?php
/**
 * User: YangXinlan
 * DateTime: 2019/2/26 10:54
 */
namespace app\model;


class Freesheetcode extends Base
{
    //生成抽奖码
    public function addCode($oid,$user_id,$goods_id,$help_uid=0){
        global $_W;
        $strs="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $code=substr(str_shuffle($strs),mt_rand(0,strlen($strs)-11),6).rand(10000,99999);
        $newcode=substr($oid.$code,0,10);
        $data['order_id']=$oid;
        $data['user_id']=$user_id;
        $data['goods_id']=$goods_id;
        $data['lottery_code']=$newcode;
        $data['uniacid']=$_W['uniacid'];
        $data['help_uid']=$help_uid;
        $this->allowField(true)->save($data);
        return $newcode ;
    }
    //获取所有次数
    public function allnum($user_id,$goods_id){
        $num=$this->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->count();
        return $num;
    }
}