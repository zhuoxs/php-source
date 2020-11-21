<?php
/**
 * 村民信息录入模块定义
 *
 * @author peng
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Nxb_informationModule extends WeModule {
	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			load()->func('file');
			$input =array(); 
			$input=$_GPC['settings'];
			//字段验证, 并获得正确的数据$dat
			if($this->saveSettings($input)) {
                message('保存参数成功', 'refresh');
            }
			$this->saveSettings($dat);
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}


}