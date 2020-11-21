<?php
/**
 * 智慧农场活动插件
 * @author 坤典科技
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
!defined('ROOT_PATH_ACTIVE') && define('ROOT_PATH_ACTIVE', IA_ROOT . '/addons/kundian_farm_plugin_active/');
class Kundian_farm_plugin_activeModuleSite extends WeModuleSite {
	public function system(){
        include ROOT_PATH_ACTIVE."inc/web/system.inc.php";
    }
    public function active(){
	    include ROOT_PATH_ACTIVE.'inc/web/system.inc.php';
    }

    public function doWebAdmin() {
        global $_GPC;
        $op=$_GPC['op'] ? $_GPC['op'] :'system_set';
        $action=$_GPC['action'] ? $_GPC['action'] :'system';
        try{
            require ROOT_PATH_ACTIVE.'inc/web/'.$action.'.inc.php';
            $class='Active_'.ucfirst($action);
            $Index=new $class($this);
            $Index->$op($_GPC);

        } catch (Exception $e){
            var_dump($e);
        }
    }

    public function doWebCommon($template,$data=[]){
        global $_W,$_GPC;
        include $this->template($template);
    }

}