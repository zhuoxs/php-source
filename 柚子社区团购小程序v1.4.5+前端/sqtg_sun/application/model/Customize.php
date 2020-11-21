<?php

namespace app\model;

use app\base\model\Base;

class Customize extends Base
{
    //获取单个菜单图标
    public function getMenu($id){
        $info=self::get($id);
        return $info;
    }

}
