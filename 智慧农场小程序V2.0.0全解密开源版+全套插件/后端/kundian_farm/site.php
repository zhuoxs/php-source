<?php
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
!defined('TABLE_PRE') && define('TABLE_PRE', 'cqkundian_farm_');
class Kundian_farmModuleSite extends WeModuleSite {
    public function doWebCommon($template,$data=[]){
        global $_W,$_GPC;
        include $this->template($template);
    }

    public function doWebAdmin() {
        global $_GPC;
        $op=$_GPC['op'] ? $_GPC['op'] :'index';
        $action=$_GPC['action'] ? $_GPC['action'] :'index';
        try{
            require ROOT_PATH.'inc/web/'.$action.'.inc.php';
            $class='Farm_'.ucfirst($action);

            $Index=new $class($this);
            $Index->$op($_GPC);

        } catch (Exception $e){
            var_dump($e);
        }
    }
    public function doWebWebapp(){
        require_once ROOT_PATH.'inc/web/webapp.inc.php';
    }
}