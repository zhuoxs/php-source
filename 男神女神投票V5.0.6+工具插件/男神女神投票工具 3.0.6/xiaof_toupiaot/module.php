<?php
/**
 * 男神女神投票工具模块定义
 *
 * @author 忘道 QQ：1020332177
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Xiaof_toupiaotModule extends WeModule {
	
	public function settingsDisplay($settings) {
		global $_W, $_GPC;


		if(checksubmit()) {

			$dat['makelog'] = $_GPC['makelog'];

            $this->saveSettings($dat);
            message('配置参数更新成功！', referer(), 'success');
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}