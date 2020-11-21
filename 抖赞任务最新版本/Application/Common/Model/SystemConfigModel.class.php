<?php
namespace Common\Model;
use Common\Model\BaseModel;

class SystemConfigModel extends BaseModel{

    /**
     * 快速缓存
     * @param $data
     */
    public static function set($data)
    {
        F("systemConfig", $data, UPLOAD_PATH);
    }

    /**
     * 获取文件缓存
     * @param $key
     * @return mixed
     */
    public static function get($key=null)
    {
        $config = F("systemConfig", '', UPLOAD_PATH);
        if( !empty($key) ) {
            return $config[$key];
        } else {
            return $config;
        }
    }
}