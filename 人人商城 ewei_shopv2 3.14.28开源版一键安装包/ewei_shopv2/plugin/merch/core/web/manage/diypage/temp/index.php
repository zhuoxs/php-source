<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Index_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$condition = '';

		if ($_GPC['cate'] != '') {
			$condition .= ' and cate=' . intval($_GPC['cate']) . ' ';
		}

		if (!empty($_GPC['type'])) {
			$condition .= ' and type=' . intval($_GPC['type']) . ' ';
		}
		else {
			$condition .= ' and type<=2 ';
		}

		if (!empty($_GPC['keyword'])) {
			$keyword = '%' . trim($_GPC['keyword']) . '%';
			$condition .= ' and name like \'' . $keyword . '\' ';
		}

		$condition .= ' and (merch=' . intval($_W['merchid']) . ' or uniacid=0)';
		$list = pdo_fetchall('select id, name, type, preview, uniacid from ' . tablename('ewei_shop_diypage_template') . ' where (uniacid=:uniacid or uniacid=0) and deleted=0 ' . $condition . ' order by uniacid asc, type desc, id desc limit ' . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage_template') . ' where deleted=0 and (uniacid=:uniacid or uniacid=0) ' . $condition, array(':uniacid' => $_W['uniacid']));
		$pager = pagination($total, $pindex, $psize);
		$diypage_plugin = p('diypage');
		$allpagetype = $diypage_plugin->getPageType();
		$category = pdo_fetchall('SELECT id, name FROM ' . tablename('ewei_shop_diypage_template_category') . ' WHERE uniacid=:uniacid and merch=:merch order by id desc ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		include $this->template();
	}

	public function import()
	{
		global $_W;
		global $_GPC;
	}

	public function delete()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$tid = intval($_GPC['id']);

			if (empty($tid)) {
				show_json(1, '参数错误，请刷新重试！');
			}

			$item = pdo_fetch('SELECT id, name, uniacid FROM ' . tablename('ewei_shop_diypage_template') . ' WHERE id=:id and (uniacid=:uniacid or uniacid=0) and (merch=:merch or uniacid=0) ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid'], ':id' => $tid));

			if (!empty($item)) {
				if (empty($item['uniacid'])) {
					if (!$_W['isfounder']) {
						show_json(1, '您无权删除系统模板！');
					}

					pdo_update('ewei_shop_diypage_template', array('deleted' => 1), array('id' => $tid, 'merch' => intval($_W['merchid'])));
				}
				else {
					pdo_delete('ewei_shop_diypage_template', array('id' => $tid));
				}

				plog('diypage.temp.delete', '删除模板 名称:' . $item['name']);
			}

			show_json(0);
		}
	}
}

?>
