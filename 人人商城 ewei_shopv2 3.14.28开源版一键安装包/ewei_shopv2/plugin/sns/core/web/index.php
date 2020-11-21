<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		include $this->template();
	}

	public function data()
	{
		global $_W;
		$boardcount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_board') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		$postcount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and pid=0 limit 1', array(':uniacid' => $_W['uniacid']));
		$replycount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and pid>0 limit 1', array(':uniacid' => $_W['uniacid']));
		$createtime1 = strtotime(date('Y-m-d', time() - 3600 * 24));
		$createtime2 = strtotime(date('Y-m-d', time()));
		$postcount1 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . (' where uniacid=:uniacid and pid=0 and createtime between ' . $createtime1 . ' and ' . $createtime2 . ' limit 1'), array(':uniacid' => $_W['uniacid']));
		$replycount1 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . (' where uniacid=:uniacid and pid>0 and createtime between ' . $createtime1 . ' and ' . $createtime2 . ' limit 1'), array(':uniacid' => $_W['uniacid']));
		$createtime1 = strtotime(date('Y-m-d', time() - 7 * 3600 * 24));
		$createtime2 = strtotime(date('Y-m-d', time()));
		$postcount2 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . (' where uniacid=:uniacid and pid=0 and createtime between ' . $createtime1 . ' and ' . $createtime2 . ' limit 1'), array(':uniacid' => $_W['uniacid']));
		$replycount2 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . (' where uniacid=:uniacid and pid>0 and createtime between ' . $createtime1 . ' and ' . $createtime2 . ' limit 1'), array(':uniacid' => $_W['uniacid']));
		show_json(1, array('boardcount' => $boardcount, 'postcount' => $postcount, 'replycount' => $replycount, 'postcount1' => $postcount1, 'replycount1' => $replycount1, 'postcount2' => $postcount2, 'replycount2' => $replycount2));
	}

	public function set()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('sns.set.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['share_icon'] = save_media($data['share_icon']);
			$data['avatar'] = save_media($data['avatar']);
			$data['banner'] = save_media($data['banner']);
			$data['imagesnum'] = intval($data['imagesnum']);

			if (is_array($_GPC['managers'])) {
				$data['managers'] = implode(',', $_GPC['managers']);
			}
			else {
				$data['managers'] = '';
			}

			$this->updateSet($data);
			m('cache')->set('template_' . $this->pluginname, $data['style']);
			plog('sns.set.edit', '修改基本设置');
			show_json(1);
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

		$data = $this->set;
		$managers = array();

		if (isset($data['managers'])) {
			if (!empty($data['managers'])) {
				$openids = array();
				$strsopenids = explode(',', $data['managers']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$managers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		include $this->template();
	}

	public function notice()
	{
		global $_W;
		global $_GPC;
		$set = m('common')->getPluginset('sns');

		if ($_W['ispost']) {
			ca('sns.notice.edit');
			$data = is_array($_GPC['tm']) ? $_GPC['tm'] : array();
			m('common')->updatePluginset(array(
	'sns' => array('tm' => $data)
	));
			plog('sns.notice.edit', '修改通知设置');
			show_json(1);
		}

		$salers = array();

		if (isset($set['tm']['openids'])) {
			if (!empty($set['tm']['openids'])) {
				$openids = array();
				$strsopenids = explode(',', $set['tm']['openids']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

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
