<?php

namespace app\model;


class Task extends Base
{
    protected static function init()
    {
        self::beforeInsert(function ($model){
            startTask();
            if (!isset($model->execute_time) || !$model->execute_time){
                $model->execute_time = time();
            }
        });
        parent::init();
    }
//    获取器
    public function getExecuteTimeAttr($value)
    {
        if ($value){
            return date('Y-m-d H:i:s',$value);
        }
        return "";
    }
}
