<?php
namespace app\model;

use app\base\model\Base;

class Pinclassify extends Base
{

    public function get_info($id){
        $info = self::get(['id'=>$id]);
        return $info;
    }

}