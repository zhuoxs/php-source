<?php
namespace app\model;
use think\Loader;

class Infotop extends Base
{
    //判断是否存在收费id
    public function isExistInfotop($id){
        $data=self::get(['id'=>$id,'state'=>1]);
        return $data;
    }
}
