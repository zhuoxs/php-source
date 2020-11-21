<?php
//QQ63779278
class Favorite_EweiShopV2Page extends PluginMobileLoginPage
{
	public function get_list()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and f.uniacid = :uniacid and f.openid=:openid and f.deleted=0 and f.type=1';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_favorite') . (' f where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT f.id,f.merchid,g.merchname,g.logo,g.desc FROM ' . tablename('ewei_shop_member_favorite') . ' f ' . ' left join ' . tablename('ewei_shop_merch_user') . ' g on f.merchid = g.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'logo');
			$merch_plugin = p('merch');
			$merch_data = m('common')->getPluginset('merch');
			if (!empty($list) && $merch_plugin && $merch_data['is_openmerch']) {
				$merch_user = pdo_fetchall('select id,merchname from ' . tablename('ewei_shop_merch_user') . ' where id in(' . implode(',', array_unique(array_column($list, 'merchid'))) . ')', array(), 'id');

				foreach ($list as &$row) {
					$row['merchname'] = $merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name'];
				}

				unset($row);
			}
		}

		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}

	public function toggle()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$isfavorite = intval($_GPC['isfavorite']);
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			show_json(0, '商品未找到');
		}

		$data = pdo_fetch('select id,deleted from ' . tablename('ewei_shop_member_favorite') . ' where uniacid=:uniacid and merchid=:id and openid=:openid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':id' => $id));

		if (empty($data)) {
			if (!empty($isfavorite)) {
				$data = array('uniacid' => $_W['uniacid'], 'merchid' => $id, 'openid' => $_W['openid'], 'createtime' => time());
				pdo_insert('ewei_shop_member_favorite', $data);
			}
		}
		else {
			pdo_update('ewei_shop_member_favorite', array('deleted' => $isfavorite ? 0 : 1), array('id' => $data['id'], 'uniacid' => $_W['uniacid']));
		}

		show_json(1, array('isfavorite' => $isfavorite == 1));
	}
}

?>
