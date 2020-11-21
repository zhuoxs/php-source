<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Setting_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_GPC;
		global $_W;
		$uniacid = intval($_W['uniacid']);
		$data = pdo_fetch('select * from ' . tablename('ewei_shop_live_setting') . ' where uniacid = ' . $uniacid . ' ');

		if ($_W['ispost']) {
			ca('sysset.notice.edit');
			$tdata = is_array($_GPC['tdata']) ? $_GPC['tdata'] : array();
			$set_data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (empty($tdata['willcancel_close_advanced'])) {
				$uniacids = m('cache')->get('willcloseuniacid', 'global');

				if (!is_array($uniacids)) {
					$uniacids = array();
				}

				if (!in_array($_W['uniacid'], $uniacids)) {
					$uniacids[] = $_W['uniacid'];
					m('cache')->set('willcloseuniacid', $uniacids, 'global');
				}
			}
			else {
				$uniacids = m('cache')->get('willcloseuniacid', 'global');

				if (is_array($uniacids)) {
					if (in_array($_W['uniacid'], $uniacids)) {
						$tdatas = array();

						foreach ($uniacids as $uniacid) {
							if ($uniacid != $_W['uniacid']) {
								$tdatas[] = $uniacid;
							}
						}

						m('cache')->set('willcloseuniacid', $tdatas, 'global');
					}
				}
			}

			if (!empty($data)) {
				pdo_update('ewei_shop_live_setting', $set_data, array('uniacid' => $uniacid));
			}
			else {
				$set_data['uniacid'] = $uniacid;
				pdo_insert('ewei_shop_live_setting', $set_data);
			}

			m('common')->updateSysset(array('notice' => $tdata));
			show_json(1);
		}

		$tdata = m('common')->getSysset('notice', false);
		$template_list = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_list as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		include $this->template();
	}
}

?>
