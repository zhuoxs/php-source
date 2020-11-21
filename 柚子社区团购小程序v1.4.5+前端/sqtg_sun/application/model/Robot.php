<?php

namespace app\model;

use app\base\model\Base;

class Robot extends Base
{
    public static function getList($limit = 10){
        global $_W;
        $robots = self::where('1=1')->limit($limit)->field('img')->select();
        foreach ($robots as &$robot) {
            $robot['img'] = $_W['attachurl'].$robot['img'];
        }
        return $robots;
    }
}
