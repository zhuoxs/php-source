<?php
/**
 * 智慧农场插件
 * @author 资源邦源码网
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH_PLAY') && define('ROOT_PATH_PLAY', IA_ROOT . '/addons/kundian_farm_plugin_play/');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
class Kundian_farm_plugin_playModuleSite extends WeModuleSite {
	public function sdoWebSystem(){
        include ROOT_PATH_PLAY."inc/web/system.inc.php";
    }

    public function doWebWithdraw(){
	    require_once ROOT_PATH_PLAY.'inc/web/withdraw.inc.php';
    }

    public function doWebLand(){
	    require_once ROOT_PATH_PLAY.'inc/web/land.inc.php';
    }
    public function doWebAnimal(){
	    require_once ROOT_PATH_PLAY.'inc/web/animal.inc.php';
    }

    public function doWebAdmin() {
        global $_GPC;
        $op=$_GPC['op'] ? $_GPC['op'] :'system_set';
        $action=$_GPC['action'] ? $_GPC['action'] :'system';
        try{
            require ROOT_PATH_PLAY.'inc/web/'.$action.'.inc.php';
            $class='Play_'.ucfirst($action);
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