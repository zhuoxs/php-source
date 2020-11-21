<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Notice_EweiShopV2Page extends AppMobilePage
{
	public function get_list()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and `uniacid` =:uniacid and status=1';
		$params = array(':uniacid' => $_W['uniacid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_notice') . (' where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_notice') . ' where 1 ' . $condition . ' ORDER BY displayorder desc,id desc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		foreach ($list as $key => &$row) {
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			$row['thumb'] = empty($row['thumb']) ? tomedia($_W['shopset']['shop']['logo']) : tomedia($row['thumb']);
		}

		unset($row);
		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total));
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
			$notice = pdo_fetch('select * from ' . tablename('ewei_shop_notice') . ' where id=:id and uniacid=:uniacid and status=1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		}

		return app_json(array(
			'notice' => array('title' => $notice['title'], 'createtime' => date('Y-m-d H:i', $notice['createtime']), 'detail' => M('common')->html_to_images($notice['detail']))
		));
	}
}

?>
