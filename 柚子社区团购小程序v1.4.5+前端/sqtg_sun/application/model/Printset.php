<?php

namespace app\model;

use app\base\model\Base;

class Printset extends Base
{
    static public function get_curr(){
        $info = self::get([]);
        return $info;
    }
}
