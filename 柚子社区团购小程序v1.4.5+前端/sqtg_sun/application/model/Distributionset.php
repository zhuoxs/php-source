<?php
namespace app\model;
use think\Loader;
use think\Db;
use app\base\model\Base;
class Distributionset extends Base
{
    static public function get_curr(){
        global $_W;
        $uniacid = $_W['uniacid'];
        $info = self::get(['uniacid'=>$uniacid]);
        $info['join_module_z']=explode(',',$info['join_module']);
        $info['withdraw_type_z']=explode(',',$info['withdraw_type']);
        return $info;
    }

}
