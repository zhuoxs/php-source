<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 14:24
 */
namespace app\model;


class Config extends Base{
    public static function full_id($key,$value){
        $data = [
            'key'=>$key,
            'value'=>$value,
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
        return $data?$data['value']:$default;
    }
}