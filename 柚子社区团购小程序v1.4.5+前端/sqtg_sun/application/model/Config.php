<?php
namespace app\model;

use app\base\model\Base;

class Config extends Base{
    public static function full_id($key,$value,$default=''){
        $data = [
            'key'=>$key,
            'value'=>is_null($value) ? $default : $value,
        ];
        $config = self::get(['key'=>$key]);
        $id = $config['id']?:0;
        if ($id){
            $data['id'] = $id;
        }
        return $data;
    }
    public static function get_value($key,$default=''){
        $data = self::get(['key'=>$key]);
        return $data&&$data['value']?$data['value']:$default;
    }
}