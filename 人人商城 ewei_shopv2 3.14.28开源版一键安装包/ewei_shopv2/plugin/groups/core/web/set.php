<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Set_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$set = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_set') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $uniacid));

		if ($_W['ispost']) {
			$goodsid = htmlspecialchars_decode($_GPC['goodsid']);
			$goodsid = json_decode($goodsid, true);
			$goodsid = array_keys($goodsid);
			$data2 = is_array($_GPC['data2']) ? $_GPC['data2'] : array();
			$exchangekeyword = $data2['exchangekeyword'];
			$keyword = m('common')->keyExist($exchangekeyword);

			if (!empty($keyword)) {
				if ($keyword['name'] != 'ewei_shopv2:groups') {
					show_json(0, '关键字已存在!');
				}
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:groups'));

			if (empty($rule)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:groups', 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => trim($exchangekeyword), 'type' => 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				pdo_update('rule_keyword', array('content' => trim($exchangekeyword)), array('rid' => $rule['id']));
			}

			$this->updateSet($data2);
			$data = array('uniacid' => $uniacid, 'groups' => intval($_GPC['data']['groups']), 'followurl' => trim($_GPC['data']['followurl']), 'followqrcode' => trim($_GPC['data']['followqrcode']), 'groupsurl' => trim($_GPC['data']['groupsurl']), 'share_title' => trim($_GPC['data']['share_title']), 'share_icon' => trim($_GPC['data']['share_icon']), 'share_desc' => trim($_GPC['data']['share_desc']), 'share_url' => trim($_GPC['data']['share_url']), 'groups_description' => m('common')->html_images($_GPC['groups_description']), 'rules' => m('common')->html_images($_GPC['rules']), 'description' => intval($_GPC['data']['description']), 'creditdeduct' => intval($_GPC['data']['creditdeduct']), 'credit' => intval($_GPC['data']['credit']), 'groupsdeduct' => intval($_GPC['data']['groupsdeduct']), 'groupsmoney' => $_GPC['data']['groupsmoney'], 'refund' => intval($_GPC['data']['refund']), 'refundday' => intval($_GPC['data']['refundday']), 'receive' => intval($_GPC['data']['receive']), 'discount' => intval($_GPC['data']['discount']), 'headstype' => intval($_GPC['headstype']), 'headsmoney' => floatval($_GPC['headsmoney']), 'headsdiscount' => intval($_GPC['headsdiscount']), 'goodsid' => !empty($goodsid) ? implode(',', $goodsid) : 0, 'followbar' => intval($_GPC['data']['followbar']));

			if (!empty($set)) {
				$set_update = pdo_update('ewei_shop_groups_set', $data, array('id' => $set['id'], 'uniacid' => $uniacid));
			}
			else {
				$set_insert = pdo_insert('ewei_shop_groups_set', $data);
			}

			pdo_update('ewei_shop_groups_goods', array('rights' => 1), array('uniacid' => $uniacid));
			$goodsid = explode(',', $data['goodsid']);

			foreach ($goodsid as $value) {
				$goods_update = pdo_update('ewei_shop_groups_goods', array('rights' => 0), array('id' => intval($value), 'uniacid' => $uniacid));
			}

			show_json(1, array('url' => webUrl('groups/set', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$sys_data = m('common')->getPluginset('sale');
		$data2 = $this->set;
		$data = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_set') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $uniacid));

		if ($data['goodsid']) {
			$goods = pdo_fetchall('SELECT *,groupsprice as marketprice  FROM ' . tablename('ewei_shop_groups_goods') . ('
                    WHERE uniacid = :uniacid and id in (' . $data['goodsid'] . ') '), array(':uniacid' => $uniacid), 'id');
			$goods = set_medias($goods, 'thumb');
		}

		include $this->template();
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$params[':deleted'] = 0;
		$condition = ' and uniacid=:uniacid and deleted = :deleted ';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,rights,thumb FROM ' . tablename('ewei_shop_groups_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		$ds = set_medias($ds, array('thumb', 'share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}
}

?>
