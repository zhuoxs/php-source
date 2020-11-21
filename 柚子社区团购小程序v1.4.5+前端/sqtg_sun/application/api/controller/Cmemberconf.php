<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 17:36
 */
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Memberconf;

class Cmemberconf extends Api{
    public function mylevel(){
        $money=5.01;
        $mem=new Memberconf();
        $info=$mem->mylevel($money);
        var_dump($info);exit;
    }
    public function levelList(){
        global $_W;
        $mem=new Memberconf();
        $list = $mem->where(['uniacid'=>$_W['uniacid']])->order(['money'=>'asc'])->select();
        return_json('success',0,$list);
    }
}