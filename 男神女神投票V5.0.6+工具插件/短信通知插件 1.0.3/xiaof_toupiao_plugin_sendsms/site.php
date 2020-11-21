<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT.'/addons/xiaof_toupiao_plugin_sendsms/global.php';
require MODULE_ROOT.'/class/sms.class.php';
class Xiaof_toupiao_plugin_sendsmsModuleSite extends WeModuleSite {
    public $module;
    public function __construct() {
        //初始化modules
        global $_W, $_GPC, $do;
        if (defined('IN_SYS')) {
            $this->init_web();
        }
    }
    private function init_web() {
        if (defined('SUPERMAN_DEVELOPMENT')) {

        }
    }
}