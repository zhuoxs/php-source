<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Short_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid AND deleted = :deleted and merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':deleted' => '0', ':merchid' => $merchid);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND ( title LIKE :title or shorttitle like :title ) ';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if (!empty($_GPC['shorttitle'])) {
			$_GPC['shorttitle'] = intval($_GPC['shorttitle']);

			if ($_GPC['shorttitle'] < 2) {
				$condition .= ' AND shorttitle <> "" ';
			}
			else {
				$condition .= ' AND shorttitle = "" ';
			}
		}

		if ($_GPC['status'] != '') {
			$_GPC['status'] = intval($_GPC['status']);
			$condition .= ' AND status=:status ';
			$params[':status'] = $_GPC['status'];
		}

		$sql = 'SELECT id,title,shorttitle,status FROM ' . tablename('ewei_shop_goods') . (' where 1 and ' . $condition . ' ORDER BY  shorttitle desc, status desc, id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_goods') . (' where 1 and ' . $condition), $params);
		$pager = pagination($total, $pindex, $psize);
		include $this->template();
	}

	public function edit()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$id = intval($_GPC['id']);
		$shorttitle = trim($_GPC['value']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
			$shorttitle = '';
		}

		$goods = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid'] . ' AND merchid=' . $merchid);

		foreach ($goods as $good) {
			pdo_update('ewei_shop_goods', array('shorttitle' => $shorttitle), array('id' => $good['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $merchid));

			if (empty($shorttitle)) {
				plog('merch.exhelper.short.edit', '清空商品简称 ID: ' . $good['id'] . ' 商品名称: ' . $good['title']);
			}
			else {
				plog('merch.exhelper.short.edit', '修改商品简称 ID: ' . $good['id'] . ' 商品名称: ' . $good['title'] . ' 商品简称: ' . $shorttitle);
			}
		}

		show_json(1, array('url' => referer()));
	}
}

?>
