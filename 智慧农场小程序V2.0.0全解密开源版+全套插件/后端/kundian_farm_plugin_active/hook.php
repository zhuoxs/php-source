<?php
/**
 * 智慧农场活动插件
 * @author 坤典科技
 */
defined('IN_IA') or exit('Access Denied');

class Kundian_farm_plugin_activeModuleHook extends WeModuleHook {
    public function hookWebPlugin() {
        global $_GPC;
        $plugin_module = WeUtility::createModuleHook('kundian_farm_plugin_active');
        $module=$plugin_module->module;
        if(!empty($module)){
            include $this->template('web/common/module');
        }

    }
}