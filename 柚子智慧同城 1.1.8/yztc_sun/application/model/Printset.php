<?php

namespace app\model;


class Printset extends Base
{
    static public function get_curr(){
        $info = self::get([]);
        return $info;
    }
}
