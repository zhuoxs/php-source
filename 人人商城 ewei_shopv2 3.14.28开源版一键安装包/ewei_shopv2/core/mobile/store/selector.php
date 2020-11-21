<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Selector_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$ids = trim($_GPC['ids']);
		$type = intval($_GPC['type']);
		$merchid = intval($_GPC['merchid']);
		$condition = '';

		if (!empty($ids)) {
			$condition = ' and id in(' . $ids . ')';
		}

		if ($type == 1) {
			$condition .= ' and type in(1,3) ';
		}
		else {
			if ($type == 2) {
				$condition .= ' and type in(2,3) ';
			}
		}

		if (0 < $merchid) {
			$list = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 ' . $condition . ' order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
		}
		else {
			$list = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 ' . $condition . ' order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
		}

		include $this->template();
	}
}

?>
