<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends SystemPage
{
	protected $type = 'set';

	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = array();
			$data['type'] = $this->type;
			$_GPC['data']['logo'] = save_media($_GPC['data']['logo']);
			$_GPC['data']['qrcode'] = save_media($_GPC['data']['qrcode']);
			$data['content'] = iserializer($_GPC['data']);
			$res = pdo_fetch('select id from ' . tablename('ewei_shop_system_site') . ' where `type`=:type', array(':type' => $this->type));

			if (empty($res)) {
				$ok = pdo_insert('ewei_shop_system_site', $data);
				$ok ? show_json(1) : show_json(0);
			}
			else {
				$ok = pdo_update('ewei_shop_system_site', $data, array('id' => $res['id']));
				show_json(1);
			}
		}

		$styles = array();
		$dir = IA_ROOT . '/pcsite/template';

		if ($handle = @opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . '/' . $file)) {
						$styles[] = $file;
					}
				}
			}

			closedir($handle);
		}

		$res = pdo_fetch('select * from ' . tablename('ewei_shop_system_site') . ' where `type`=:type', array(':type' => $this->type));
		if (!empty($res['content']) && !is_array($res['content'])) {
			if (strexists($res['content'], '{"')) {
				$data = json_decode($res['content'], true);
			}
			else {
				$data = unserialize($res['content']);
			}
		}

		include $this->template();
	}
}

?>
