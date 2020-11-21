<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and uniacid=:uniacid ';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND `title` LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if (!empty($_GPC['type'])) {
			$condition .= ' AND `type` = :type';
			$params[':type'] = intval($_GPC['type']);
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_poster') . (' WHERE 1 ' . $condition . ' ORDER BY isdefault desc,createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($list as &$row) {
			$row['times'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_poster_scan') . ' where posterid=:posterid and uniacid=:uniacid', array(':posterid' => $row['id'], ':uniacid' => $_W['uniacid']));
			$row['follows'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_poster_log') . ' where posterid=:posterid and uniacid=:uniacid', array(':posterid' => $row['id'], ':uniacid' => $_W['uniacid']));
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_poster') . (' where 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);
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
		$plugin_coupon = com('coupon');
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_poster') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$data = json_decode(str_replace('&quot;', '\'', $item['data']), true);
			foreach ($data as &$v) {
                if ($v["type"] == "productprice" || $v["type"] == "marketprice") {
                    $v["top"] = intval(substr($v["top"], 0, -2)) - 50 . "px";
                }
            }
		}

		if ($_W['ispost']) {
			load()->model('account');
			$acid = pdo_fetchcolumn('select acid from ' . tablename('account_wechats') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			$data = array('uniacid' => $_W['uniacid'], 'title' => trim($_GPC['title']), 'type' => intval($_GPC['type']), 'keyword2' => trim($_GPC['keyword2']), 'bg' => save_media($_GPC['bg']), 'data' => htmlspecialchars_decode($_GPC['data']), 'resptype' => trim($_GPC['resptype']), 'resptext' => trim($_GPC['resptext']), 'resptitle' => trim($_GPC['resptitle']), 'respthumb' => trim($_GPC['respthumb']), 'respdesc' => trim($_GPC['respdesc']), 'respurl' => trim($_GPC['respurl']), 'isdefault' => intval($_GPC['isdefault']), 'createtime' => time(), 'oktext' => trim($_GPC['oktext']), 'waittext' => trim($_GPC['waittext']), 'subcredit' => intval($_GPC['subcredit']), 'submoney' => $_GPC['submoney'], 'reccredit' => intval($_GPC['reccredit']), 'recmoney' => $_GPC['recmoney'], 'subtext' => trim($_GPC['subtext']), 'bedown' => intval($_GPC['bedown']), 'beagent' => intval($_GPC['beagent']), 'isopen' => intval($_GPC['isopen']), 'opentext' => trim($_GPC['opentext']), 'openurl' => trim($_GPC['openurl']), 'paytype' => intval($_GPC['paytype']), 'subpaycontent' => trim($_GPC['subpaycontent']), 'recpaycontent' => trim($_GPC['recpaycontent']), 'templateid' => trim($_GPC['templateid']), 'entrytext' => trim($_GPC['entrytext']), 'ismembergroup' => intval($_GPC['ismembergroup']));
			if (empty($data["type"])) {
                show_json(0, "请选择海报类型!");
            }
			if ($data['type'] == 4) {
				$data['membergroupid'] = intval($_GPC['membergroupid']);
			}
			else {
				$data['membergroupid'] = 0;
			}

			$reward_totle = array('reccredit_totle' => intval($_GPC['reccredit_totle']), 'recmoney_totle' => floatval($_GPC['recmoney_totle']));
			$keyword = m('common')->keyExist($data['keyword2']);
			if ($item['keyword2'] != $data['keyword2'] && !empty($keyword)) {
				if ($keyword['name'] != 'ewei_shopv2:poster:' . $data['type']) {
					show_json(0, '关键字已存在!');
				}
			}

			if (com('coupon')) {
				$data['reccouponid'] = intval($_GPC['reccouponid']);
				$data['reccouponnum'] = intval($_GPC['reccouponnum']);
				$data['subcouponid'] = intval($_GPC['subcouponid']);
				$data['subcouponnum'] = intval($_GPC['subcouponnum']);
				$reward_totle['reccouponnum_totle'] = intval($_GPC['reccouponnum_totle']);
			}

			$data['reward_totle'] = json_encode($reward_totle);

			if ($data['isdefault'] == 1) {
				pdo_update('ewei_shop_poster', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1, 'type' => $data['type']));
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_poster', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('poster.edit', '修改超级海报 ID: ' . $id . '<br>' . ($data['isopen'] ? '允许非分销商生成自己的海报 -- 是<br>' : '允许非分销商生成自己的海报 -- 否<br>') . ($data['bedown'] ? '扫码关注成为下线 -- 是<br>' : '扫码关注成为下线 -- 否<br>') . ($data['beagent'] ? '扫码关注成为分销商 -- 是' : '扫码关注成为分销商 -- 否'));
			}
			else {
				pdo_insert('ewei_shop_poster', $data);
				$id = pdo_insertid();
				plog('poster.add', '添加超级海报 ID: ' . $id . '<br>' . ($data['isopen'] ? '允许非分销商生成自己的海报<br>' : '不允许非分销商生成自己的海报<br>') . ($data['bedown'] ? '扫码关注成为下线 -- 是<br>' : '扫码关注成为下线 -- 否<br>') . ($data['beagent'] ? '扫码关注成为分销商 -- 是' : '扫码关注成为分销商 -- 否'));
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:poster:' . $data['type']));

			if (empty($rule)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:poster:' . $data['type'], 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => $data['type'] == 3 ? '^' . trim($data['keyword2']) . '\\+*[0-9]{1,}$' : trim($data['keyword2']), 'type' => $data['type'] == 3 ? 3 : 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				$isDefault = pdo_fetchcolumn("select `isdefault` from " . tablename("ewei_shop_poster") . " where uniacid = :uniacid and id=:id", array(":uniacid" => $_W["uniacid"], ":id" => $id));
                if ($isDefault) {
				$content = $data['type'] == 3 ? '^' . trim($data['keyword2']) . '\\+*[0-9]{1,}$' : trim($data['keyword2']);
				pdo_update('rule_keyword', array('content' => $content), array('rid' => $rule['id']));
			}
			}

			$ruleauto = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:poster:auto'));

			if (empty($ruleauto)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:poster:auto', 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => 'EWEI_SHOPV2_POSTER', 'type' => 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}

			show_json(1, array('url' => webUrl('poster/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$imgroot = $_W['attachurl'];

		if (empty($_W['setting']['remote'])) {
			setting_load('remote');
		}

		if (!empty($_W['setting']['remote']['type'])) {
			$imgroot = $_W['attachurl_remote'];
		}

		$reward_totle = !empty($item['reward_totle']) ? json_decode($item['reward_totle'], true) : array();
		$item['reccredit_totle'] = intval($reward_totle['reccredit_totle']);
		$item['recmoney_totle'] = floatval($reward_totle['recmoney_totle']);
		$groups = m('member')->getGroups();

		if (com('coupon')) {
			if (!empty($item['subcouponid'])) {
				$subcoupon = com('coupon')->getCoupon($item['subcouponid']);
			}

			if (!empty($item['reccouponid'])) {
				$reccoupon = com('coupon')->getCoupon($item['reccouponid']);
			}

			$item['reccouponnum_totle'] = intval($reward_totle['reccouponnum_totle']);
		}

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

		$posters = pdo_fetchall('SELECT id,title,keyword,keyword2 FROM ' . tablename('ewei_shop_poster') . (' WHERE id in ( ' . $id . ' ) and uniacid=') . $_W['uniacid']);

		foreach ($posters as $poster) {
			if (empty($poster['keyword'])) {
				$poster['keyword'] = $poster['keyword2'];
			}

			$rule = pdo_fetchall('SELECT id,rid FROM ' . tablename('rule_keyword') . (' WHERE uniacid=:uniacid AND content IN (\'' . $poster['keyword'] . '\',\'' . $poster['keyword2'] . '\')'), array(':uniacid' => $_W['uniacid']), 'rid');
			$rule = array_keys($rule);
			m('common')->delrule($rule);
			pdo_delete('ewei_shop_poster', array('id' => $poster['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_poster_log', array('posterid' => $poster['id'], 'uniacid' => $_W['uniacid']));
			plog('poster.delete', '删除超级海报 ID: ' . $id . ' 海报名称: ' . $poster['title']);
		}

		show_json(1, array('url' => webUrl('poster')));
	}

	public function clear()
	{
		global $_W;
		global $_GPC;
		load()->func('file');
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/poster/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/qrcode/' . $_W['uniacid']);
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		pdo_update('ewei_shop_poster_qr', array('mediaid' => ''), array('acid' => $acid));
		plog('poster.clear', '清除海报缓存');
		show_json(1, array('url' => webUrl('poster')));
	}

	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$poster = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_poster') . (' WHERE id = \'' . $id . '\''));

		if (empty($poster)) {
			show_json(0, '抱歉，海报不存在或是已经被删除！');
		}
		$rule = pdo_fetch("select * from " . tablename("rule") . " where uniacid=:uniacid and module=:module and name=:name  limit 1", array(":uniacid" => $_W["uniacid"], ":module" => "ewei_shopv2", ":name" => "ewei_shopv2:poster:" . $poster["type"]));
		pdo_update('ewei_shop_poster', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1, 'type' => $poster['type']));
		pdo_update('ewei_shop_poster', array('isdefault' => 1), array('uniacid' => $_W['uniacid'], 'id' => $poster['id']));
		pdo_update("rule_keyword", array("content" => $poster["keyword2"]), array("rid" => $rule["id"]));
		plog('poster.setdefault', '设置默认超级海报 ID: ' . $id . ' 海报名称: ' . $poster['title']);
		show_json(1);
	}
}

?>
