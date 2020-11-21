<?php
/**
 * 【超人】超级商城模块定义
 *
 * @author 超人
 * @url http://bbs.we7.cc/thread-13060-1-1.html
 */
defined('IN_IA') or exit('Access Denied');

class Superman_hand2_plugin_adModuleHook extends WeModuleHook {
    //web端
    public function hookWebNav($hook){
        global $_W, $_GPC;
        // 将调用 template/web/test.html
        include $this->template('nav');
    }
    public function hookWebSetting($hook){
        global $_W, $_GPC;
        include $this->template('setting');
    }
    //mobile端
    public function hookMobileTest($hook) {
        global $_W,$_GPC;
        // 将调用 template/mobile/test.html
        include $this->template('test');
    }
}

