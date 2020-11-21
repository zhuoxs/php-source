<?php
//QQ63779278
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

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_postera') . (' WHERE 1 ' . $condition . ' ORDER BY isdefault desc,createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($list as &$row) {
			$row['follows'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_postera_log') . ' where posterid=:posterid and uniacid=:uniacid', array(':posterid' => $row['id'], ':uniacid' => $_W['uniacid']));
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_postera') . (' where 1 ' . $condition . ' '), $params);
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
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_postera') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$data = json_decode(str_replace('&quot;', '\'', $item['data']), true);
		}

		if ($_W['ispost']) {
			load()->model('account');
			$acid = pdo_fetchcolumn('select acid from ' . tablename('account_wechats') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			$data = array('uniacid' => $_W['uniacid'], 'title' => trim($_GPC['title']), 'type' => intval($_GPC['type']), 'keyword2' => trim($_GPC['keyword2']), 'bg' => save_media($_GPC['bg']), 'data' => htmlspecialchars_decode($_GPC['data']), 'resptype' => trim($_GPC['resptype']), 'resptext' => trim($_GPC['resptext']), 'resptitle' => trim($_GPC['resptitle']), 'respthumb' => trim($_GPC['respthumb']), 'respdesc' => trim($_GPC['respdesc']), 'respurl' => trim($_GPC['respurl']), 'createtime' => time(), 'oktext' => trim($_GPC['oktext']), 'waittext' => trim($_GPC['waittext']), 'subcredit' => intval($_GPC['subcredit']), 'submoney' => $_GPC['submoney'], 'reccredit' => intval($_GPC['reccredit']), 'recmoney' => $_GPC['recmoney'], 'subtext' => trim($_GPC['subtext']), 'bedown' => intval($_GPC['bedown']), 'beagent' => intval($_GPC['beagent']), 'isopen' => intval($_GPC['isopen']), 'opentext' => trim($_GPC['opentext']), 'openurl' => trim($_GPC['openurl']), 'paytype' => intval($_GPC['paytype']), 'subpaycontent' => trim($_GPC['subpaycontent']), 'recpaycontent' => trim($_GPC['recpaycontent']), 'templateid' => trim($_GPC['templateid']), 'entrytext' => trim($_GPC['entrytext']), 'timestart' => strtotime($_GPC['time']['start']), 'timeend' => strtotime($_GPC['time']['end']), 'status' => intval($_GPC['status']), 'goodsid' => intval($_GPC['goodsid']), 'starttext' => trim($_GPC['starttext']), 'endtext' => trim($_GPC['endtext']));
			$reward_totle = array('reccredit_totle' => intval($_GPC['reccredit_totle']), 'recmoney_totle' => floatval($_GPC['recmoney_totle']));
			$keyword = m('common')->keyExist($data['keyword2']);
			if ($item['keyword2'] != $data['keyword2'] && !empty($keyword)) {
				if ($keyword['name'] != 'ewei_shopv2:postera:' . $id) {
					show_json(0, '关键字已存在!');
				}
			}

			if ($plugin_coupon) {
				$data['reccouponid'] = intval($_GPC['reccouponid']);
				$data['reccouponnum'] = intval($_GPC['reccouponnum']);
				$data['subcouponid'] = intval($_GPC['subcouponid']);
				$data['subcouponnum'] = intval($_GPC['subcouponnum']);
				$reward_totle['reccouponnum_totle'] = intval($_GPC['reccouponnum_totle']);
			}

			$data['reward_totle'] = json_encode($reward_totle);

			if ($data['isdefault'] == 1) {
				pdo_update('ewei_shop_postera', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1, 'type' => $data['type']));
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_postera', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('postera.edit', '修改活动海报 ID: ' . $id . '<br>' . ($data['isopen'] ? '允许非分销商生成自己的海报 -- 是<br>' : '允许非分销商生成自己的海报 -- 否<br>') . ($data['bedown'] ? '扫码关注成为下线 -- 是<br>' : '扫码关注成为下线 -- 否<br>') . ($data['beagent'] ? '扫码关注成为分销商 -- 是' : '扫码关注成为分销商 -- 否'));
			}
			else {
				pdo_insert('ewei_shop_postera', $data);
				$id = pdo_insertid();
				plog('postera.add', '修改活动海报 ID: ' . $id . '<br>' . ($data['isopen'] ? '允许非分销商生成自己的海报<br>' : '不允许非分销商生成自己的海报<br>') . ($data['bedown'] ? '扫码关注成为下线 -- 是<br>' : '扫码关注成为下线 -- 否<br>') . ($data['beagent'] ? '扫码关注成为分销商 -- 是' : '扫码关注成为分销商 -- 否'));
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:postera:' . $id));
			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:postera:' . $id, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => $data['status']);
			$keyword_data = array('uniacid' => $_W['uniacid'], 'module' => 'ewei_shopv2', 'content' => trim($data['keyword2']), 'type' => 1, 'displayorder' => 0, 'status' => $data['status']);

			if (empty($rule)) {
				pdo_insert('rule', $rule_data);
				$keyword_data['rid'] = pdo_insertid();
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				pdo_update('rule_keyword', $keyword_data, array('rid' => $rule['id']));
			}

			$ruleauto = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:postera:auto'));

			if (empty($ruleauto)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:postera:auto', 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => 'EWEI_SHOPV2_POSTERA', 'type' => 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}

			show_json(1, array('url' => webUrl('postera')));
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

		if ($plugin_coupon) {
			if (!empty($item['subcouponid'])) {
				$subcoupon = $plugin_coupon->getCoupon($item['subcouponid']);
			}

			if (!empty($item['reccouponid'])) {
				$reccoupon = $plugin_coupon->getCoupon($item['reccouponid']);
			}

			$item['reccouponnum_totle'] = intval($reward_totle['reccouponnum_totle']);
		}

		if (!empty($item['goodsid'])) {
			$goods = set_medias(pdo_fetch('select id,title,thumb,commission_thumb,marketprice,productprice from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['goodsid'], ':uniacid' => $_W['uniacid'])), 'thumb');
		}

		if (empty($item)) {
			$starttime = time();
			$endtime = strtotime(date('Y-m-d H:i', $starttime) . '+30 days');
		}
		else {
			$type = $item['coupontype'];
			$starttime = $item['timestart'];
			$endtime = $item['timeend'];
		}

		include $this->template();
	}

	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$poster = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_postera') . (' WHERE id = \'' . $id . '\''));

		if (empty($poster)) {
			show_json(0, '抱歉，海报不存在或是已经被删除！');
		}

		pdo_update('ewei_shop_postera', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1, 'type' => $poster['type']));
		pdo_update('ewei_shop_postera', array('isdefault' => 1), array('uniacid' => $_W['uniacid'], 'id' => $poster['id']));
		plog('postera.setdefault', '设置默认超级海报 ID: ' . $id . ' 海报名称: ' . $poster['title']);
		show_json(1);
	}

	public function delete()
	{
		global $_GPC;
		global $_W;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$posters = pdo_fetchall('SELECT id,title,keyword,keyword2 FROM ' . tablename('ewei_shop_postera') . (' WHERE id in ( ' . $id . ' ) and uniacid=') . $_W['uniacid']);

		foreach ($posters as $poster) {
			if (empty($poster['keyword'])) {
				$poster['keyword'] = $poster['keyword2'];
			}

			$rule = pdo_fetchall('SELECT id,rid FROM ' . tablename('rule_keyword') . (' WHERE uniacid=:uniacid AND content IN (\'' . $poster['keyword'] . '\',\'' . $poster['keyword2'] . '\')'), array(':uniacid' => $_W['uniacid']), 'rid');
			$rule = array_keys($rule);
			m('common')->delrule($rule);
			pdo_delete('ewei_shop_postera', array('id' => $poster['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_postera_log', array('posterid' => $poster['id'], 'uniacid' => $_W['uniacid']));
			plog('postera.delete', '删除活动海报 ID: ' . $id . ' 海报名称: ' . $poster['title']);
		}

		show_json(1, array('url' => webUrl('postera')));
	}

	public function clear()
	{
		global $_W;
		global $_GPC;
		load()->func('file');
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/postera/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/qrcode/' . $_W['uniacid']);
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		pdo_update('ewei_shop_postera_qr', array('mediaid' => ''), array('acid' => $acid));
		plog('postera.clear', '清除海报缓存');
		show_json(1, array('url' => webUrl('postera', array('op' => 'display'))));
	}
}

?>
