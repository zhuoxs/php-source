<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;

		if (cv('abonus.agent')) {
			header('location: ' . webUrl('abonus/agent'));
			exit();
		}
		else if (cv('abonus.level')) {
			header('location: ' . webUrl('abonus/level'));
			exit();
		}
		else if (cv('abonus.bonus')) {
			header('location: ' . webUrl('abonus/bonus'));
			exit();
		}
		else if (cv('abonus.bonus.send')) {
			header('location: ' . webUrl('abonus/bonus/send'));
			exit();
		}
		else if (cv('abonus.notice')) {
			header('location: ' . webUrl('abonus/notice'));
			exit();
		}
		else {
			if (cv('abonus.set')) {
				header('location: ' . webUrl('abonus/set'));
				exit();
			}
		}
	}

	public function notice()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			m('common')->updatePluginset(array(
				'abonus' => array('tm' => $data)
			));
			plog('abonus.notice.edit', '修改通知设置');
			show_json(1);
		}

		$data = m('common')->getPluginset('abonus');
		$template_lists = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_lists as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		$template_list = $template_group;
		include $this->template();
	}

	public function set()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (!empty($data['withdrawcharge'])) {
				$data['withdrawcharge'] = trim($data['withdrawcharge']);
				$data['withdrawcharge'] = floatval(trim($data['withdrawcharge'], '%'));
			}

			$data['withdrawbegin'] = floatval(trim($data['withdrawbegin']));
			$data['withdrawend'] = floatval(trim($data['withdrawend']));
			$data['register_bottom_content'] = m('common')->html_images($data['register_bottom_content']);
			$data['applycontent'] = m('common')->html_images($data['applycontent']);
			$data['regbg'] = save_media($data['regbg']);
			$data['become_goodsid'] = intval($_GPC['become_goodsid']);
			$data['texts'] = is_array($_GPC['texts']) ? $_GPC['texts'] : array();
			m('common')->updatePluginset(array('abonus' => $data));
			m('cache')->set('template_' . $this->pluginname, $data['style']);
			$selfbuy = $data['selfbuy'] ? '开启' : '关闭';

			switch ($data['become']) {
			case '0':
			case '1':
				$become = '申请';
				break;

			case '2':
				$become = '消费次数';
				break;

			case '3':
				$become = '消费金额';
				break;

			case '4':
				$become = '购买商品';
				break;
			}

			plog('abonus.set.edit', '修改基本设置<br>' . '内购分红 -- ' . $selfbuy . ' <br>成为分销商条件 -- ' . $become);
			show_json(1, array('url' => webUrl('abonus/set', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$styles = array();
		$dir = IA_ROOT . '/addons/ewei_shopv2/plugin/' . $this->pluginname . '/template/mobile/';

		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . '/' . $file)) {
						$styles[] = $file;
					}
				}
			}

			closedir($handle);
		}

		$data = m('common')->getPluginset('abonus');
		include $this->template();
	}
}

?>
