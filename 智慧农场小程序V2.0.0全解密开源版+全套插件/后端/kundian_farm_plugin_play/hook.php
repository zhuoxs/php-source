<?php
/**
 * 智慧农场活动插件
 * @author 资源邦源码网
 */
defined('IN_IA') or exit('Access Denied');

class Kundian_farm_plugin_playModuleHook extends WeModuleHook {
    public function hookWebPlugin() {
        global $_GPC;
        $plugin_module = WeUtility::createModuleHook('kundian_farm_plugin_play');
        $module=$plugin_module->module;
        if(!empty($module)){
            include $this->template('web/common/module');
        }

    }
}