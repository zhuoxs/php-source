<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'mmanage/core/inc/page_mmanage.php';
class Notice_EweiShopV2Page extends MmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$notice = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_copyright_notice') . ' WHERE status=1 ORDER BY displayorder ASC,createtime DESC LIMIT 10');
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$this->message('参数错误');
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_copyright_notice') . ' WHERE id=:id AND status=1 LIMIT 1', array('id' => $id));

		if (empty($item)) {
			$this->message('公告不存在');
		}

		include $this->template();
	}
}

?>
