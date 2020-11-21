<?php

namespace app\model;


class Withdrawset extends Base
{
    static public function get_curr(){
        $info = self::get([]);
        return $info;
    }
}
