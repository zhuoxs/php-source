<?php
/**
 *
 * @author 坤典团队
 * @url http://9hym.cn/
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH_FARM_FUND') && define('ROOT_PATH_FARM_FUND', IA_ROOT . '/addons/kundian_farm_plugin_funding/');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
class Kundian_farm_plugin_fundingModuleSite extends WeModuleSite {
	public function doWebSystem() {
	    require_once ROOT_PATH_FARM_FUND.'inc/web/system.inc.php';
	}
	public function doWebProject(){
	    require_once ROOT_PATH_FARM_FUND.'inc/web/project.inc.php';
    }
    public function doWebOrder(){
	    require ROOT_PATH_FARM_FUND.'inc/web/order.inc.php';
    }
}