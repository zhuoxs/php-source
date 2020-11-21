<?php
/**
 * @author 坤典科技
 * @url www.cqkundian.com
 */
defined('IN_IA') or exit('Access Denied');

class Kundian_farm_plugin_ptModuleHook extends WeModuleHook {
    // app端的嵌入点
    public function hookWebPlugin() {
        global $_GPC;
        $plugin_module = WeUtility::createModuleHook('kundian_farm_plugin_pt');
        $module=$plugin_module->module;
        if(!empty($module)){
            include $this->template('web/common/module');
        }

    }
}