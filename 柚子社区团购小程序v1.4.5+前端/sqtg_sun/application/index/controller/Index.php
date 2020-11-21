<?php
namespace app\index\controller;
use think\Db;
use app\index\model\Task;
use app\model\Userbalancerecord;
class Index
{
    public function index()
    {   
        // $a = new Userbalancerecord();
        // $res = $a->field("*,if(sign=1,"男","女") as haha")->select();
        // return json_encode($res);
        $ret = Db::query("select *,if(sign=1,'男','女') from ims_sqtg_sun_userbalancerecord");
        dump($ret);
    }

    public function index2()
    {
        $a = new \app\index\model\User();
        $a->aa();
    }
}
