<?php
/**
 * User: YangXinlan
 * DateTime: 2019/1/8 14:48
 */
namespace app\model;
class Comment extends Base
{
    public function userinfo(){
        return $this->hasOne('User','id','user_id')->bind(array(
            'username'=>'nickname',
            'headurl'=>'avatar',
        ));
    }

}