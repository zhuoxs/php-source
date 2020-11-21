<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 14:07
 */
namespace app\model;


class Integralcategory extends Base
{
    public function get_info($id){
        $info = self::get(['id'=>$id]);
        return $info;
    }

}