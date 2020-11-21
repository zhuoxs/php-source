<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Setting_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
	}

	public function download()
	{
		global $_GPC;
		global $_W;
		$dir = IA_ROOT . ('/addons/ewei_shopv2/data/qrcode/' . $_W['uniacid'] . '/exchange');
		if (!file_exists($dir) || !is_writable($dir)) {
			load()->func('file');
			mkdirs($dir);
		}
		else {
			$file = array();
			$allFile = scandir($dir);
			array_splice($allFile, 0, 2);

			foreach ($allFile as $k => $v) {
				$file_dir = $dir . '/' . $v;
				$file[$k]['name'] = $v;
				$file[$k]['dir'] = $file_dir;
				$file[$k]['time'] = filemtime($file_dir);
				$file[$k]['size'] = filesize($file_dir);
				$expanded = substr($v, -4, 4);

				switch ($expanded) {
				case '.zip':
					$type = 1;
					break;

				case '.txt':
					$type = 2;
					break;

				case '.xls':
					$type = 3;
					break;

				default:
					$type = 0;
				}

				$file[$k]['type'] = $type;
			}

			uasort($file, function($x, $y) {
				return $y['time'] - $x['time'];
			});
		}

		include $this->template();
	}

	public function filedel()
	{
		global $_GPC;
		global $_W;
		$filename = trim($_GPC['fname']);
		$filetype = intval($_GPC['ftype']);
		$dir = IA_ROOT . ('/addons/ewei_shopv2/data/qrcode/' . $_W['uniacid'] . '/exchange');
		$fileDir = $dir . '/' . $filename;

		if (0 < $filetype) {
			if (unlink($fileDir)) {
				show_json(1, '删除成功');
			}
			else {
				show_json(0, '删除失败');
			}
		}
		else {
			$delres = $this->delDirAndFile($fileDir);

			if (!empty($delres)) {
				show_json(1, '删除成功');
			}
			else {
				show_json(0, '删除失败');
			}
		}
	}

	public function delDirAndFile($path, $delDir = true)
	{
		$handle = opendir($path);

		if ($handle) {
			while (false !== ($item = readdir($handle))) {
				if ($item != '.' && $item != '..') {
					is_dir($path . '/' . $item) ? $this->delDirAndFile($path . '/' . $item, $delDir) : unlink($path . '/' . $item);
				}
			}

			closedir($handle);

			if ($delDir) {
				return rmdir($path);
			}
		}
		else {
			if (file_exists($path)) {
				return unlink($path);
			}

			return false;
		}
	}

	public function delall()
	{
		global $_GPC;
		global $_W;
		$dir = IA_ROOT . ('/addons/ewei_shopv2/data/qrcode/' . $_W['uniacid'] . '/exchange');
		$this->delDirAndFile($dir, 0);
	}

	public function other()
	{
		global $_GPC;
		global $_W;
		$data = m('common')->getSysset('notice', false);
		$salers = array();

		if (isset($data['openid'])) {
			if (!empty($data['openid'])) {
				$openids = array();
				$strsopenids = explode(',', $data['openid']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		if ($_W['ispost']) {
			ca('sysset.notice.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (is_array($_GPC['openids'])) {
				$data['openid'] = implode(',', $_GPC['openids']);
			}
			else {
				$data['openid'] = '';
			}

			if (empty($data['willcancel_close_advanced'])) {
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
						$datas = array();

						foreach ($uniacids as $uniacid) {
							if ($uniacid != $_W['uniacid']) {
								$datas[] = $uniacid;
							}
						}

						m('cache')->set('willcloseuniacid', $datas, 'global');
					}
				}
			}

			m('common')->updateSysset(array('notice' => $data));
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

		if ($_W['ispost']) {
			$mistake = intval($_GPC['mistake']);
			$freeze = intval($_GPC['freeze']);
			$grouplimit = intval($_GPC['grouplimit']);
			$alllimit = intval($_GPC['alllimit']);
			$coupon_templateid = $_GPC['data']['coupon_templateid'];

			if (pdo_get('ewei_shop_exchange_setting', array('uniacid' => $_W['uniacid'])) == false) {
				pdo_insert('ewei_shop_exchange_setting', array('uniacid' => $_W['uniacid'], 'mistake' => $mistake, 'freeze' => $freeze, 'grouplimit' => $grouplimit, 'alllimit' => $alllimit, 'no_qrimg' => (int) $_GPC['no_qrimg'], 'rule' => $_GPC['rule']));
			}
			else {
				pdo_update('ewei_shop_exchange_setting', array('mistake' => $mistake, 'freeze' => $freeze, 'grouplimit' => $grouplimit, 'alllimit' => $alllimit, 'no_qrimg' => (int) $_GPC['no_qrimg'], 'rule' => $_GPC['rule'], 'coupon_templateid' => $coupon_templateid), array('uniacid' => $_W['uniacid']));
			}

			show_json(1, '保存成功');
		}
		else {
			$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exchange_setting') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $_W['uniacid']));
		}

		include $this->template();
	}
}

?>
