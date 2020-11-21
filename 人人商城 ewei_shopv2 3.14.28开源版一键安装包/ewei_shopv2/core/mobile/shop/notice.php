<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Notice_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and `uniacid` = :uniacid and status=1 and iswxapp=0';
		$params = array(':uniacid' => $_W['uniacid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_notice') . (' where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_notice') . ' where 1 ' . $condition . ' ORDER BY displayorder desc,id desc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		foreach ($list as $key => &$row) {
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
		}

		unset($row);
		$list = set_medias($list, 'thumb');
		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$merchid = intval($_GPC['merchid']);
		$merch_plugin = p('merch');
		if ($merch_plugin && !empty($merchid)) {
			$notice = pdo_fetch('select * from ' . tablename('ewei_shop_merch_notice') . ' where id=:id and uniacid=:uniacid and merchid=:merchid and status=1', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
		}
		else {
			$notice = pdo_fetch('select * from ' . tablename('ewei_shop_notice') . ' where id=:id and iswxapp=0 and uniacid=:uniacid and status=1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		}

		$notice['detail'] = m('ui')->lazy($notice['detail']);
		include $this->template();
	}
}

?>
