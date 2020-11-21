<?php
namespace app\model;
use think\Loader;

class Infosettings extends Base
{
    static public function get_curr(){
        global $_W;
        $uniacid = $_W['uniacid'];
        $info = self::get(['uniacid'=>$uniacid]);
        return $info;
    }
}
