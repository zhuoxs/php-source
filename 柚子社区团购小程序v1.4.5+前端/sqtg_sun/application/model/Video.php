<?php
namespace app\model;

use app\base\model\Base;

class Video extends Base{
    public function getVideo($id){
        $info=self::get($id);
        return $info;
    }
}