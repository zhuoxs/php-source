<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Notice_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		$notice = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_copyright_notice') . ' WHERE status=1 ORDER BY displayorder ASC,createtime DESC LIMIT 10');

		if (!empty($notice)) {
			foreach ($notice as &$item) {
				$item['createtime'] = date('Y-m-d H:i:s', $item['createtime']);
			}
		}

		return app_json(array('list' => $notice));
	}

	public function detail()
	{
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError, '参数错误');
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_copyright_notice') . ' WHERE id=:id AND status=1 LIMIT 1', array('id' => $id));

		if (empty($item)) {
			return app_error(AppError::$ParamsError, '公告不存在');
		}

		$item['createtime'] = !empty($item['createtime']) ? date('Y-m-d H:i:s', $item['createtime']) : 0;

		if (!empty($item['content'])) {
			$item['content'] = htmlspecialchars_decode($item['content']);
		}

		return app_json(array('detail' => $item));
	}
}

?>
