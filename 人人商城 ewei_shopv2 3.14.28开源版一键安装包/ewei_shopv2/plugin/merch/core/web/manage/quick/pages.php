<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Pages_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' WHERE uniacid=:uniacid AND merchid=:merchid ';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' AND title LIKE \'%' . $keyword . '%\' ';
		}

		$status = trim($_GPC['status']);

		if ($status != '') {
			$condition .= ' AND status=:status ';
			$params['status'] = intval($status);
		}

		$limit = ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall('SELECT * FROM' . tablename('ewei_shop_quick') . $condition . ' ORDER BY createtime DESC' . $limit, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename('ewei_shop_quick') . $condition, $params);
		$pager = pagination($total, $pindex, $psize);

		if (!empty($list)) {
			foreach ($list as $key => &$value) {
				$url = mobileUrl('quick', array('id' => $value['id']), true);
				$value['qrcode'] = m('qrcode')->createQrcode($url);
			}
		}

		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = intval($_GPC['type']);

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM' . tablename('ewei_shop_quick') . ' WHERE id=:id AND uniacid=:uniacid AND merchid=:merchid', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

			if (!empty($item['datas'])) {
				$datas = htmlspecialchars_decode(base64_decode($item['datas']));
				$datas = p('quick')->update($datas);
			}
			else {
				$datas = 'null';
			}

			if (!empty($item['adv_data'])) {
				$item['adv_data'] = iunserializer($item['adv_data']);
			}

			if ($type == 1) {
				$status = $item['status'];
			}
			else {
				$status = intval($_GPC['status']);
			}
		}
		else {
			$datas = 'null';
		}

		if ($_W['ispost']) {
			$tab = trim($_GPC['tab']);
			$arr = array('title' => trim($_GPC['title']), 'keyword' => trim($_GPC['keyword']), 'share_title' => trim($_GPC['share_title']), 'share_desc' => trim($_GPC['share_desc']), 'share_icon' => trim($_GPC['share_icon']), 'enter_title' => trim($_GPC['enter_title']), 'enter_desc' => trim($_GPC['enter_desc']), 'enter_icon' => trim($_GPC['enter_icon']), 'status' => intval($_GPC['status']), 'lasttime' => time());
			$arr['datas'] = base64_encode($_GPC['datas']);

			if ($type != '1') {
				if (empty($arr['title'])) {
					show_json(0, '请填写页面标题');
				}
			}

			if (!empty($arr['keyword'])) {
				$keyword = m('common')->keyExist($arr['keyword']);

				if (!empty($keyword)) {
					if ($keyword['name'] != 'ewei_shopv2:quick:' . $id) {
						show_json(0, '关键字"' . $arr['keyword'] . '"已存在!');
					}
				}
			}

			if (empty($item)) {
				$arr['uniacid'] = $_W['uniacid'];
				$arr['merchid'] = $_W['merchid'];
				$arr['createtime'] = time();
				pdo_insert('ewei_shop_quick', $arr);
				$id = pdo_insertid();
				plog('quick.pages.add', '添加购买页面 ID: ' . $id . ' 标题: ' . $arr['title']);
			}
			else {
				pdo_update('ewei_shop_quick', $arr, array('uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid'], 'id' => $id));
				plog('quick.pages.add', '添加购买页面 ID: ' . $id . ' 标题: ' . $arr['title']);
			}

			if (!empty($arr['keyword'])) {
				$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:quick:' . $id));

				if (!empty($rule)) {
					pdo_update('rule_keyword', array('content' => $arr['keyword']), array('rid' => $rule['id']));
				}
				else {
					$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:quick:' . $id, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
					pdo_insert('rule', $rule_data);
					$rid = pdo_insertid();
					$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => $arr['keyword'], 'type' => 1, 'displayorder' => 0, 'status' => 1);
					pdo_insert('rule_keyword', $keyword_data);
				}
			}
			else {
				$this->delKey($item['keyword']);
			}

			show_json(1, array('url' => webUrl('quick/pages/edit', array('id' => $id, 'tab' => $tab, 'type' => $type))));
		}

		if (!empty($item)) {
			$url = mobileUrl('quick', array('id' => $item['id'], 'merchid' => $_W['merchid']), true);
			$qrcode = m('qrcode')->createQrcode($url);
		}

		$merchid = $_W['merchid'];
		$merchset = p('merch')->getListUserOne($merchid);
		$shopset = array('name' => $merchset['merchname'], 'logo' => tomedia($merchset['logo']));
		$diymenu = pdo_fetchall('select id, `name` from ' . tablename('ewei_shop_diypage_menu') . ' where merch=:merch and uniacid=:uniacid  order by id desc', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title,cart,keyword FROM ' . tablename('ewei_shop_quick') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_delete('ewei_shop_quick', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('quick.pages.delete', '删除购买页面 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');

				if (!empty($item['cart'])) {
					pdo_delete('ewei_shop_quick_cart', array('quickid' => $item['id'], 'uniacid' => $_W['uniacid']));
				}

				if (!empty($item['keyword'])) {
					$this->delKey($item['keyword']);
				}
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_quick') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_update('ewei_shop_quick', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
				plog('quick.pages.status', '修改页面状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '显示' : '隐藏');
			}
		}

		show_json(1, array('url' => referer()));
	}

	protected function delKey($keyword)
	{
		global $_W;

		if (empty($keyword)) {
			return NULL;
		}

		$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and module=:module and uniacid=:uniacid limit 1 ', array(':content' => $keyword, ':module' => 'ewei_shopv2', ':uniacid' => $_W['uniacid']));

		if (!empty($keyword)) {
			pdo_delete('rule_keyword', array('id' => $keyword['id']));
			pdo_delete('rule', array('id' => $keyword['rid']));
		}
	}
}

?>
