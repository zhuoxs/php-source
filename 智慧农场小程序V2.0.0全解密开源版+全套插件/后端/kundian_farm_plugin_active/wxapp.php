<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/14
 * Time: 14:04
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH_ACTIVE') && define('ROOT_PATH_ACTIVE', IA_ROOT . '/addons/kundian_farm_plugin_active/');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
class Kundian_farm_plugin_activeModuleWxapp extends WeModuleWxapp {
    public function doPageActive(){
        global $_GPC, $_W;
        $action = $_GPC['do'];
        require_once ROOT_PATH_ACTIVE . 'inc/wxapp/' . $action . '.inc.php';
        $class = ucfirst($action . 'Controller');
        $actionModel = new $class();
        $op = $_GPC['op'];
        $actionModel->$op($_GPC);
    }

    public function doPageOrder(){
        global $_GPC, $_W;
        $action = $_GPC['do'];
        require_once ROOT_PATH_ACTIVE . 'inc/wxapp/' . $action . '.inc.php';
        $class = ucfirst($action . 'Controller');
        $actionModel = new $class();
        $op = $_GPC['op'];
        $actionModel->$op($_GPC);
    }

    public function doPageClass(){
        global $_GPC, $_W;
        $action = $_GPC['action'];
        require_once ROOT_PATH_ACTIVE . 'inc/wxapp/' . $action . '.inc.php';
        $class = ucfirst($action . 'Controller');
        $actionModel = new $class();
        $op = $_GPC['op'];
        $actionModel->$op($_GPC);
    }

}