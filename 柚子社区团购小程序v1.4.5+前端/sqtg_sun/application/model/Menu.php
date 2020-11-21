<?php

namespace app\model;

use app\base\model\Base;

class Menu extends Base
{
    protected $autoWriteTimestamp = true;
    public $required_fields = array('name');//必填字段
    public $unique = array(['menu_id','name']);//唯一分组
    public $order = 'index';
    public $has_uniacid = false;

    public function menugroup(){
        return $this->hasOne('Menugroup','id','menugroup_id')->bind(array(
            'menugroup_name'=>'name',
        ));
    }

    public function menu(){
        return $this->hasOne('Menu','id','menu_id')->bind(array(
            'menu_name'=>'name',
        ));
    }
    public function menus()
    {
        if ($_SESSION['admin']['store_id']){
            return $this->hasMany('Menu')->where('store_show',1)->order('index,id');
        }
        return $this->hasMany('Menu')->order('index,id');
    }
}
