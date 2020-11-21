<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 14:24
 */
namespace app\model;


class Recharge extends Base
{
    static public function get_curr(){
        global $_W;
        $uniacid = $_W['uniacid'];
        $info = self::get(['uniacid'=>$uniacid]);
        return $info;
    }
}