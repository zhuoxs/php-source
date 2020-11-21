<?php
namespace app\model;
use think\Loader;
use think\Db;

class Distributionpromoter extends Base
{

    //判断是不是分销商
    public static  function is_promoter($user_id){
        $data=self::get(['user_id'=>$user_id,'check_status'=>2]);
        if(!$data){
            return false;
        }else{
            return true;
        }
    }
    /**
     * @param $user_id 用户id
     * @param $parents_id 经销商用户id
     */
    //申请成为经销商下线(购买付款后使用)
    public function setDistributionParents($user_id,$parents_id){
        //判断父级是不是分销商
        if(!Distributionpromoter::is_promoter($parents_id)){
            return '不是分销商不能成为下级';
        }
        //判断用户是不是经销商
        if(Distributionpromoter::is_promoter($user_id)){
            return('该用户为经销商不能申请成为上级');
        }
        $user=User::get($user_id);
        if(!$user){
            return('用户不存在');
        }
        if($user['parents_id']){
            return('已有上级不能申请上级');
        }
        if($user['id']==$parents_id){
            return('上级不能为自己');
        }
        $distributionset=Distributionset::get_curr();
        //首次购买条件
        if($distributionset['lower_condition']==1){
            $parents=User::get(['id'=>$parents_id]);
            (new User())->allowField(true)->save(['parents_id'=>$parents_id,'parents_name'=>$parents['nickname']],['id'=>$user_id]);
            return('申请成功');
        }else{
            return('暂未开放成为下线条件');
        }

    }
    //申请分销商

    /**
     * @param $type 3消费金额 5成为会员
     * @param $user_id
     * @return bool
     * @throws \think\exception\DbException
     */
    public function setDistributionpromoter($type,$user_id){
        $distributionpromoter=self::get(['user_id'=>$user_id]);
        if($distributionpromoter['check_status']==1){
            return false;
        }
        if($distributionpromoter['check_status']==2){
            return false;
        }
        $distributionset=Distributionset::get_curr();
        $user=User::get($user_id);
        $data=[
            'condition_type'=>$distributionset['distribution_condition'],
            'user_id'=>$user_id,
            'referrer_name'=>$user['parents_name'],
            'referrer_uid'=>$user['parents_id'],
        ];
        if($distributionset['is_check']==1){
            $data['check_status']=1;
        }else{
            $data['check_status']=2;
            $data['check_time']=time();
        }
        if($type==3&&$distributionset['distribution_condition']==3){
            if($user['total_consume']<$distributionset['consumption_money']){
                return false;
            }
        }else if($type==5&&$distributionset['distribution_condition']==5){
            if(User::isVip($user_id)==0){
                return false;
            }
        }else{
            return false;
        }
        if($distributionpromoter['id']){
            $this->allowField(true)->save($data,['id'=>$distributionpromoter['id']]);
        }else{
            $this->allowField(true)->save($data);
        }

    }

}
