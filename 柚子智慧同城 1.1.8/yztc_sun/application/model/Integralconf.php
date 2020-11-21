<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 10:53
 */
namespace app\model;


class Integralconf extends Base
{
    static public function get_curr(){
        global $_W;
        $uniacid = $_W['uniacid'];
        $info = self::get(['uniacid'=>$uniacid]);
        return $info;
    }

}