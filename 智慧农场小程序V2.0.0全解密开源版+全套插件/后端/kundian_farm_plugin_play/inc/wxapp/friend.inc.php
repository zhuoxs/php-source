<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/11/8
 * Time: 9:38
 */
defined("IN_IA") or exit("Access Denied");
require_once ROOT_PATH_PLAY.'model/friend.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/user.php';

class FriendController{
    protected $uniacid='';
    protected $uid='';
    static $common='';
    static $friend='';
    public function __construct(){
        global $_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$common=new Common_KundianFarmModel('cqkundian_farm_plugin_play_set');
        self::$friend=new Friend_Model($this->uniacid);
    }

    //通过分享链接成为好友
    public function becomeFriend($get){
        $share_uid=$get['share_uid'];
        if(empty($share_uid) || empty($this->uid)){
            echo json_encode(['code'=>-1,'msg'=>'用户uid为空或者分享uid为空']);die;
        }
        if($share_uid==$this->uid){
            echo json_encode(['code'=>-1,'msg'=>'自己不能成为自己的好友']);die;
        }
        //判断ta是不是我的好友
        $is_friend=self::$friend->getFriend($this->uid,$share_uid);
        if(empty($is_friend)){
            $data=array(
                'uid'=>$this->uid,
                'friend_uid'=>$share_uid,
                'create_time'=>time(),
                'uniacid'=>$this->uniacid,
            );
            $res=self::$friend->insertFriend($data);
        }

        //判断我是不是ta的好友
        $is_her_friend=self::$friend->getFriend($share_uid,$this->uid);
        if(empty($is_her_friend)){
            $friendData=array(
                'uid'=>$share_uid,
                'friend_uid'=>$this->uid,
                'create_time'=>time(),
                'uniacid'=>$this->uniacid,
            );
            $res1=self::$friend->insertFriend($friendData);
        }
        if($res || $res1){
            echo json_encode(['code'=>0,'msg'=>'成功成为好友']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'成为好友失败或者已是好友']);die;
    }

    //获取好友信息
    public function getFriendInfo(){
        $friendData=self::$friend->selectFriendInfo($this->uid,['uid','nickname','avatarurl']);
        echo json_encode(['friendList'=>$friendData]);die;
    }

    //拜访好友
    public function visitFriend($get){
        $friend_uid=$get['friend_uid'];  //好友的uid
        $visitType=$get['visitType'];    //1 农场 2牧场
        $userModel=new User_KundianFarmModel();
        if($get['form_id']){
            $commonForm=new Common_KundianFarmModel();
            $user=$userModel->getUserByUid($this->uid,$this->uniacid);
            $commonForm->insertFormIdData($get['form_id'],$this->uid,$user['openid'],1,$this->uniacid);
        }
        $visit_where=array('uid'=>$friend_uid,'visit_uid'=>$this->uid,'uniacid'=>$this->uniacid);
        $today_is_visit=self::$friend->getVisitRecord($visit_where);

        $friendData=$userModel->getUserByUid($friend_uid,$this->uniacid);
        $friendList=self::$friend->selectFriendInfo($this->uid,['uid','nickname','avatarurl']);
        if(!empty($today_is_visit)){
            echo json_encode(['code'=>0,'msg'=>'已拜访过好友','user'=>$friendData,'friendList'=>$friendList]);die;
        }

        $farmSet=self::$common->getSetData(['visit_friend_gold_count'],$this->uniacid);

        $user=$userModel->getUserByUid($this->uid,$this->uniacid);
        $updateUser=$userModel->updateUser(['money +='=>$farmSet['visit_friend_gold_count']],['uid'=>$this->uid,'uniacid'=>$this->uniacid]);
        if(!$updateUser){
            echo json_encode(['code'=>-1,'msg'=>'金币数量更新失败','user'=>$friendData,'friendList'=>$friendList]);die;
        }

        if($visitType==1){
            $body=$user['nickname'].'拜访了您的农场，获得'.$farmSet['visit_friend_gold_count'].'元';
        }else{
            $body=$user['nickname'].'拜访了您的牧场，获得'.$farmSet['visit_friend_gold_count'].'元';
        }
        $insertVisit=[
            'uid'=>$friend_uid,
            'visit_uid'=>$this->uid,
            'create_time'=>time(),
            'uniacid'=>$this->uniacid,
            'operation'=>1,
            'body'=>$body,
            'gold'=>$farmSet['visit_friend_gold_count'],
        ];

        $res1=$userModel->insertRecordMoney($this->uid,$farmSet['visit_friend_gold_count'],1,'首次拜访好友获得',$this->uniacid);
        $res=self::$friend->insertVisitRecord($insertVisit);
        if($res && $res1){
            echo json_encode(['code'=>0,'msg'=>'首次拜访好友获得'.$farmSet['visit_friend_gold_count'].'元','user'=>$friendData,'friendList'=>$friendList]);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'记录失败','user'=>$friendData,'friendList'=>$friendList]);die;
    }


    //偷取好友金币
    public function matureFriendLand($get){
        $userModel=new User_KundianFarmModel();
        $uid=$get['uid'];  //好友的uid
        $friend_uid=$get['friend_uid'];  //当前操作用户的uid
        $plant_id=$get['plant_id'];
        $user=$userModel->getUserByUid($friend_uid,$this->uniacid);
        $playSet=self::$common->getSetData(['steal_friend_get_gold'],$this->uniacid);
        $steal_gold=explode(',',$playSet['steal_friend_get_gold']);

        $money=round($steal_gold[0] + mt_rand()/mt_getrandmax() * ($steal_gold[1]-$steal_gold[0]),2);
        //判断是否已经偷取了
        $is_steal=self::$friend->getVisitRecord(['visit_uid'=>$friend_uid,'uid'=>$uid,'plant_id'=>$plant_id,'visit_type'=>1]);
        if(!empty($is_steal)){
            echo json_encode(['code'=>-1,'msg'=>'今日已偷取']);die;
        }

        $updateUser=$userModel->updateUser(['money +='=>$money],['uid'=>$friend_uid,'uniacid'=>$this->uniacid]);
        if(!$updateUser){
            echo json_encode(['code'=>-1,'msg'=>'偷取失败']);die;
        }

        $insertVisit=[
            'visit_uid'=>$friend_uid,
            'uid'=>$uid,
            'uniacid'=>$this->uniacid,
            'create_time'=>time(),
            'operation'=>1,
            'body'=>$user['nickname'].'偷取了你的金币',
            'gold'=>$money,
            'visit_type'=>1,
            'plant_id'=>$plant_id,
        ];
        $res=self::$friend->insertVisitRecord($insertVisit);
        $res1=$userModel->insertRecordMoney($friend_uid,$money,1,'偷取好友种植获得',$this->uniacid);
        if($res && $res1){
            echo json_encode(['code'=>0,'msg'=>'偷取成功','gold'=>$money]);die;
        }
        echo json_encode(['code'=>0,'msg'=>'偷取成功，记录生成失败','gold'=>$money]);die;
    }
}
