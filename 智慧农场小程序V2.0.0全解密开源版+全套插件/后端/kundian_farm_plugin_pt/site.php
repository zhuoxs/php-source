<?php
/**
 * @author 坤典团队
 * @url www.cqkundian.com
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH_FARM_PT') && define('ROOT_PATH_FARM_PT', IA_ROOT . '/addons/kundian_farm_plugin_pt/');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
class Kundian_farm_plugin_ptModuleSite extends WeModuleSite {
    public function doWebAdmin() {
        global $_GPC;
        $op=$_GPC['op'] ? $_GPC['op'] :'typeList';
        $action=$_GPC['action'] ? $_GPC['action'] :'goods';
        try{
            require ROOT_PATH_FARM_PT.'inc/web/'.$action.'.inc.php';
            $class='Pt_'.ucfirst($action);
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