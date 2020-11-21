<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 17:33
 */
namespace app\model;


class Browserecord extends Base
{
    //获取浏览查看人数
    public function getBrowserecordGoodsByGid($gid){
        $num=$this->where(['gid'=>$gid])->group('user_id')->count();
        return $num;
    }
}