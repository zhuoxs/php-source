<?php
/**
 * User: YangXinlan
 * DateTime: 2019/2/25 13:57
 */
namespace app\model;


class Freesheet extends Base
{
    public function category(){
        return $this->hasOne('Category','id','cat_id');
    }
    public function store(){
        return $this->hasOne('Store','id','store_id');
    }
    public function checkJoin($goods_id,$user_id,$info,$help_uid=0){
        if($info['start_time']>time()){
            return_json('活动未开始',-1);
        }
        if($info['end_time']<time()){
            return_json('活动已结束',-1);
        }
        if($help_uid==0){
            $isvip=\app\model\User::isVip($user_id);
            if( ($info['only_vip']==1) && ($isvip==0)){
                return_json('请先开通会员',-1);
            }
            $isjoin=Freesheetorder::get(['goods_id'=>$goods_id,'user_id'=>$user_id]);
            if($isjoin){
                return_json('只能参与一次哦',-1);
            }
        }else{
            $ishelp=Freesheetcode::get(['user_id'=>$user_id,'help_uid'=>$help_uid,'goods_id'=>$goods_id]);
            if($ishelp){
                return_json('只能帮忙一次',-1);
            }else{
                $code=new Freesheetcode();
                $num=($code->allnum($user_id,$goods_id))-1;
                if(($info['share_num']>0 )&& ($num>=$info['share_num'])){
                    return_json('好友帮助次数已达上限啦,试试自己参加抽奖',-1);
                }
            }
        }

        return true;
    }
    public function openPrize($good_id){

    }
}