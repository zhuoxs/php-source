<?php

namespace app\model;


class System extends Base
{
    static public function get_curr(){
        $info = self::get([]);
        return $info;
    }
}
