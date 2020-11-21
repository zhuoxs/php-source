<?php
/**
 * @author 坤典科技
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Kundian_farm_plugin_fundingModuleHook extends WeModuleHook {
    // web端的嵌入点
    public function hookMobileTest() {
        // 将调用 teamplate/mobile/testhook.html
        include $this->template('web/common/module');
    }
    // app端的嵌入点
    public function hookWebPlugin() {
        global $_GPC;
        $plugin_module = WeUtility::createModuleHook('kundian_farm_plugin_funding');
        $module=$plugin_module->module;
        if(!empty($module)){
            include $this->template('web/common/module');
        }

    }
}