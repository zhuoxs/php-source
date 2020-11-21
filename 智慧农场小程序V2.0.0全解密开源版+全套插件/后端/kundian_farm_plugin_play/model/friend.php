<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/11/8
 * Time: 9:45
 */
defined("IN_IA") or exit("Access Denied");
class Friend_Model{
    protected $tableName='cqkundian_farm_plugin_play_friend';
    protected $userTable='cqkundian_farm_user';
    protected $visitTable='cqkundian_farm_plugin_play_visit';
    protected $uniacid='';
    public function __construct($uniacid){
        $this->uniacid=$uniacid;
    }

    /**
     * 插入好友信息
     * @param $data
     * @return bool
     */
    public function insertFriend($data){
        if(empty($data)){
            return false;
        }
        return pdo_insert($this->tableName,$data);
    }

    /**
     * 获取好友信息
     * @param $uid
     * @param $filed
     * @return array
     */
    public function selectFriendInfo($uid,$filed){
        $friendData=pdo_getall($this->tableName,['uid'=>$uid,'uniacid'=>$this->uniacid],['uid','friend_uid']);
        $list=array();
        foreach ($friendData as $key => $val ){
            $list[$key]=pdo_get($this->userTable,['uid'=>$val['friend_uid'],'uniacid'=>$this->uniacid],$filed);
        }
        return $list;
    }

    /**
     * 判断当前用户与分享用户是否是好友
     * @param $uid
     * @param $share_uid
     * @return bool
     */
    public function getFriend($uid,$share_uid){
        return pdo_get($this->tableName,['uid'=>$uid,'friend_uid'=>$share_uid,'uniacid'=>$this->uniacid]);
    }

    /**
     * 插入拜访信息
     * @param $data
     * @return bool
     */
    public function insertVisitRecord($data){
        return pdo_insert($this->visitTable,$data);
    }

    /**
     * 获取拜访信息
     * @param $cond
     * @return bool
     */
    public function getVisitRecord($cond){
        return pdo_getall($this->visitTable,$cond);
    }

    /**
     * 获取好友偷取列表
     * @param $cond
     * @param string $order_by
     * @return array
     */
    public function getStealList($cond,$order_by='create_time desc'){
        return pdo_getall($this->visitTable,$cond,'','',$order_by);
    }
}