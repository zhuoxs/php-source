<?php
namespace app\api\controller;

use app\model\Config;
use app\model\Distribution;
use app\model\Infobrowselike;
use app\model\Memberconf;
use app\model\Shop;
use app\model\Storeuser;
use app\model\User;
use app\model\Order;
use app\model\Userbalancerecord;
use app\model\Userprivilege;

class ApiUser extends Api
{
    //授权登录
    public function login(){
        $openid = input('request.openid');
        $info = User::get(['openid'=>$openid])?:new User();
        $data = input('request.');
        $data['login_time'] = time();
        $share_user_id = $data['share_user_id'];
//        邀请人如果不是分销商，则不记录
    /*    if(!User::isDistribution($share_user_id)){
            $share_user_id = 0;
        }
        $data['last_share_user_id'] = $share_user_id;
//        第一次进入
        if(!isset($info->id) || !$info->id){
            $data['first_share_user_id'] = $share_user_id;
        }
        unset($data['share_user_id']);
        //还没确定上线
        if (!isset($info->share_user_id) || ! $info->share_user_id){
            if (!Config::get_value('distribution_relation')){
                $data['share_user_id'] = $share_user_id;
            }
        }*/
        $ret = $info->allowField(true)->save($data);
        $info=User::get($info['id']);
        if ($ret){
           success_json($info);
        }else{
           error_json('登录失败');
        }
    }

    //TODO:: 我的个人信息
    public function myInfo(){
        $user_id=input('request.user_id');
        if($user_id>0){
            $user=new User();
            $info['userinfo']=$user->mfind(['id'=>$user_id]);
            $info['mylikenum']=(new Infobrowselike())->getMyLikeNum($user_id);
            $info['is_vip']=(new User())->isVip($user_id);
            success_withimg_json($info);
        }else{
          return_json('user_id不能为空',-1);
        }
    }
    //TODO::余额记录
    public  function balanceRecord(){
        global $_W;
        $model=new Userbalancerecord();
        $page=input('post.page');
        $length=input('post.length');
        $user_id=input('post.user_id');
        $sign=input('post.sign',1); //1充值 2.支付
        $where['sign']=$sign;
        $where['user_id']=$user_id;
        $where['uniacid']=$_W['uniacid'];
        $list=$model->mlist($where,['create_time'=>'desc'],$page,$length);
        success_json($list);
    }
    //获取会员权益列表信息
    public function getUserPrivilege(){
        $data=(new Userprivilege())->where(['state'=>1])->select();
        success_withimg_json($data);
    }

}
