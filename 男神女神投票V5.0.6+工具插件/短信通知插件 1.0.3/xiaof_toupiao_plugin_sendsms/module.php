<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT.'/addons/xiaof_toupiao_plugin_sendsms/global.php';
class Xiaof_toupiao_plugin_sendsmsModule extends WeModule {
    public $module;
    private $_data = array();
    public function settingsDisplay($settings) {
        global $_W, $_GPC;
        if (!empty($_GPC['load_slide'])) {
            $tmp = "web/slide-tmpl";
            if (!empty($_GPC['page'])) {
                $tmp .= "-{$_GPC['page']}";
            }
            include $this->template($tmp);
            exit;
        }
        $app_secret = $this->module['config']['base']['alidayu']['app_secret'];
        $app_secret = $app_secret ? mb_substr($app_secret, 0, 4) . '********' . mb_substr($app_secret, -4, abs(-4)) : '';
        if (checksubmit('submit')) {
            $this->_setting_base();
            $this->_setting_slide();
            $this->saveSettings($this->_data);
            itoast('更新成功！', referer(), 'success');
        }
        include $this->template('web/setting');
    }
    public function welcomeDisplay() {
        $url = $this->createWebUrl('lists');
        ob_end_clean();
        @header('Location: '.$url);
        exit;
    }
    private function _setting_base() {
        global $_GPC;
        $this->_data['base'] = $_GPC['base'];
        if (strpos($_GPC['base']['alidayu']['app_secret'], '*') !== false) {
            $this->_data['base']['alidayu']['app_secret'] = $this->module['config']['base']['alidayu']['app_secret'];
        }
    }
    private function _setting_slide() {
        global $_GPC;
        $fields = array();
        if (!empty($_GPC['tmpl'])) {
            foreach ($_GPC['tmpl']['id'] as $key => $id) {
                $fields[$id] = array(
                    'name' => $_GPC['tmpl']['name'][$key],
                    'id' => $id,
                    'variable' => $_GPC['tmpl']['variable'][$key],
                );
            }
        }
        $this->_data['tmpl'] = $fields;
    }
}