<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 10:47
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
class Route_KundianFarmModel{
    public function run(){
        global $_W,$_GPC;
        $do=$_GPC['r'];
        $method=$_GPC['op'];
        require_once ROOT_PATH.'inc/web/'.$do.'.inc.php';
        $class=ucfirst($do).'_KundianFarm';
        $action=new $class();
        $action->$method();
        exit();
    }
}