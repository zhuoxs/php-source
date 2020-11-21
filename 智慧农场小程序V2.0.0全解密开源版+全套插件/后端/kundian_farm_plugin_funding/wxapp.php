<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/14
 * Time: 14:04
 */
defined('IN_IA') or exit('Access Denied');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
!defined('ROOT_PATH_FARM_FUND') && define('ROOT_PATH_FARM_FUND', IA_ROOT . '/addons/kundian_farm_plugin_funding/');
class Kundian_farm_plugin_fundingModuleWxapp extends WeModuleWxapp {
    public function doPageProject(){
        require_once ROOT_PATH_FARM_FUND.'inc/wxapp/project.inc.php';
    }
    public function doPageOrder(){
        require_once ROOT_PATH_FARM_FUND.'inc/wxapp/order.inc.php';
    }
}