<?php
class task extends base{
    public $has_uniacid = false;//是否有 uniacid 字段
    public $auto_create_time = true;
    public function insert($data){
        startTask();
        if (!isset($data['execute_time']) || !$data['execute_time']){
            $data['execute_time'] = time();
        }
        return parent::insert($data);
    }
}