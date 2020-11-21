<?php
defined('IN_IA') or exit('Access Denied');
class kundian_farmModule extends WeModule {
    public function index(){
        global $_GPC;
        $url=url('site/entry/admin',array('m'=>'kundian_farm','op'=>'index','action'=>'index'));
        message('',$url);
    }

    public function welcomeDisplay($menus = array()) {
        global $_GPC;
        $url=url('site/entry/admin',array('m'=>'kundian_farm','op'=>'index','action'=>'index'));
        cache_write('current_version',$_GPC['version_id']);

        message('',$url);
    }

}