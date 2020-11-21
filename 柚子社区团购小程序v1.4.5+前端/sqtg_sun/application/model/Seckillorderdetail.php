<?php

namespace app\model;
use think\Db;
use think\Exception;
use app\base\model\Base;

class Seckillorderdetail extends Base
{
    //    新增订单：新增、生成分佣记录
    public static function insertDb($data){
        Db::name('seckillorderdetail')->insert($data);
        $id = Db::name('seckillorderdetail')->getLastInsID();
        return $id;
    }
}
