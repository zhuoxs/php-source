<?php
namespace enum;

class Enum{
    public static $data = [];
//    获取列表数据
    public static function getList(){
        return static::$data;
    }
//    获取列表,用于 select 显示
    public static function getList4Select(){
        $data = [];
        foreach (static::$data as $key=>$value) {
            $data[] = [
                'id' => $key,
                'text' => $value,
            ];
        }
        return json_encode($data);
    }
//    根据 key 获取 value
    public static function getValue($key, $default= false){
        return isset(static::$data[$key]) && static::$data[$key]?:$default;
    }
//    根据 value 获取对应 key
    public static function getKey($value, $default= false){
        $key = array_search($value, static::$data);
        return $key !== false ? $key : $default;
    }
}