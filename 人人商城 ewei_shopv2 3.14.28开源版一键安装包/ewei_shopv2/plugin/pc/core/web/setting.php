<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class SettingController extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			if (!empty($_GPC['qq_nick']) && !empty($_GPC['qq_num'])) {
				$qq = array();

				foreach ($_GPC['qq_nick'] as $key => $val) {
					$qq[$key]['nickname'] = $val;
					$qq[$key]['qqnum'] = $_GPC['qq_num'][$key];
				}
			}

			if (!empty($_GPC['wx_nick']) && !empty($_GPC['wx_img'])) {
				$wx = array();

				foreach ($_GPC['wx_nick'] as $key => $val) {
					$wx[$key]['wxnickname'] = $val;
					$wx[$key]['wximg'] = $_GPC['wx_img'][$key];
				}

				$wx_nick = $_GPC['wx_nick'];
				$wx_img = $_GPC['wx_img'];
			}

			$data = array();
			$data['search'] = $_GPC['search'];
			$data['copyright'] = $_GPC['copyright'];
			$data['qq'] = $qq;
			$data['wx'] = $wx;
			$data['wx_nick'] = $wx_nick;
			$data['wx_img'] = $wx_img;
			m('common')->updatePluginset(array('pc' => $data));
			show_json(1);
		}

		$data = m('common')->getPluginset('pc');
		$data['url'] = mobileUrl('pc', NULL, true);
		include $this->template();
	}
}

?>
