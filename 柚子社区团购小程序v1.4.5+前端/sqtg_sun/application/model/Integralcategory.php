<?php
namespace app\model;

use app\base\model\Base;

class Integralcategory extends Base
{
    public function get_info($id){
        $info = self::get(['id'=>$id]);
        return $info;
    }

}