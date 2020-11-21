<?php

namespace app\model;


class Menugroup extends Base
{
    protected $autoWriteTimestamp = true;
    public $required_fields = array('name');//必填字段
    public $unique = array('name');//唯一分组
    public $order = 'index';
    public $has_uniacid = false;

    public function menus()
    {
        if ($_SESSION['admin']['store_id']){
            return $this->hasMany('Menu')->with('menus')->where('store_show',1)->where('menu_id','0');
        }
        return $this->hasMany('Menu')->with('menus')->where('menu_id','0')->order('index','asc');
    }
}
