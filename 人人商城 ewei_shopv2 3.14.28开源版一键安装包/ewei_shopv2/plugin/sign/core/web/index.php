<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		if (cv('sign.rule')) {
			header('Location: ' . webUrl('sign/rule'));
		}
		else if (cv('sign.records')) {
			header('Location: ' . webUrl('sign/records'));
		}
		else if (cv('sign.set')) {
			header('Location: ' . webUrl('sign/set'));
		}
		else {
			header('Location: ' . webUrl());
		}

		exit();
	}

	public function rule()
	{
		global $_W;
		global $_GPC;
		$set = $this->model->getSet();

		if (!empty($set['sign_rule'])) {
			$set['sign_rule'] = iunserializer($set['sign_rule']);
		}

		if ($_W['ispost']) {
			cv('sign.rule');
			$data = array('isopen' => intval($_GPC['isopen']), 'signold' => intval($_GPC['signold']), 'signold_price' => intval($_GPC['signold_price']), 'signold_type' => intval($_GPC['signold_type']), 'textsign' => trim($_GPC['textsign']), 'textsignold' => trim($_GPC['textsignold']), 'textsigned' => trim($_GPC['textsigned']), 'textsignforget' => trim($_GPC['textsignforget']), 'maincolor' => trim($_GPC['maincolor']), 'cycle' => intval($_GPC['cycle']), 'reward_default_first' => intval($_GPC['reward_default_first']), 'reward_default_day' => intval($_GPC['reward_default_day']), 'reword_order' => $_GPC['reword_order'], 'reword_sum' => $_GPC['reword_sum'], 'reword_special' => $_GPC['reword_special'], 'sign_rule' => iserializer($_GPC['sign_rule']));

			if (!empty($data['reword_order'])) {
				$reword_order = array();

				foreach ($data['reword_order'] as $k1 => $v1) {
					foreach ($v1 as $k2 => $v2) {
						if (!empty($k1) && !empty($v2)) {
							$reword_order[$k2][$k1] = $v2;
						}
					}
				}

				$data['reword_order'] = iserializer($reword_order);
			}

			if (!empty($data['reword_sum'])) {
				$reword_sum = array();

				foreach ($data['reword_sum'] as $k1 => $v1) {
					foreach ($v1 as $k2 => $v2) {
						if (!empty($k1) && !empty($v2)) {
							$reword_sum[$k2][$k1] = $v2;
						}
					}
				}

				$data['reword_sum'] = iserializer($reword_sum);
			}

			if (!empty($data['reword_special'])) {
				$reword_special = array();

				foreach ($data['reword_special'] as $k1 => $v1) {
					foreach ($v1 as $k2 => $v2) {
						if ($k1 == 'date') {
							$v2 = strtotime($v2);
						}

						$reword_special[$k2][$k1] = $v2;
					}
				}

				$data['reword_special'] = iserializer($reword_special);
			}

			if (empty($set)) {
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_sign_set', $data);
			}
			else {
				pdo_update('ewei_shop_sign_set', $data, array('id' => $set['id'], 'uniacid' => $_W['uniacid']));
			}

			plog('sign.rule.edit', '修改签到规则');
			$textcredit = trim($_GPC['textcredit']);

			if (!empty($textcredit)) {
				$tradedata = m('common')->getSysset('trade');
				$tradedata['credittext'] = $textcredit;
				m('common')->updateSysset(array('trade' => $tradedata));
			}

			show_json(1);
		}

		if (!empty($set['reword_order'])) {
			$set['reword_order'] = iunserializer($set['reword_order']);

			foreach ($set['reword_order'] as $key => $row) {
				$volume[$key] = $row['day'];
			}

			if (1 < count($set['reword_order'])) {
				array_multisort($volume, SORT_ASC, $set['reword_order']);
			}

			unset($volume);
		}

		if (!empty($set['reword_sum'])) {
			$set['reword_sum'] = iunserializer($set['reword_sum']);

			foreach ($set['reword_sum'] as $key => $row) {
				$volume[$key] = $row['day'];
			}

			if (1 < count($set['reword_sum'])) {
				array_multisort($volume, SORT_ASC, $set['reword_sum']);
			}

			unset($volume);
		}

		if (!empty($set['reword_special'])) {
			$set['reword_special'] = iunserializer($set['reword_special']);
		}

		include $this->template();
	}

	public function records()
	{
		global $_W;
		global $_GPC;
		$time_start = mktime(0, 0, 0, date('m'), 1, date('Y'));
		$time_end = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
		$starttime = !empty($_GPC['time']['start']) ? strtotime($_GPC['time']['start']) : $time_start;
		$endtime = !empty($_GPC['time']['end']) ? strtotime($_GPC['time']['end']) : $time_end;
		$condition = ' where r.uniacid=' . $_W['uniacid'] . ' and m.uniacid=' . $_W['uniacid'];
		$time = $_GPC['time'];
		$keyword = trim($_GPC['keyword']);
		$type = trim($_GPC['type']);
		$searchtime = intval($_GPC['searchtime']);

		if (!empty($keyword)) {
			$condition .= ' and (m.nickname like \'%' . $keyword . '%\' or r.log like \'%' . $keyword . '%\') ';
		}

		if ($type != '' && -1 < $type) {
			$condition .= ' and `type`=' . $type;
		}

		if (!empty($searchtime) && is_array($_GPC['time'])) {
			$_GPC['time']['start'] = strtotime($_GPC['time']['start']);
			$_GPC['time']['end'] = strtotime($_GPC['time']['end']) + 3600 * 24 - 1;
			$condition .= ' and r.time BETWEEN ' . $_GPC['time']['start'] . ' AND ' . $_GPC['time']['end'];
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall('select r.*, m.nickname, m.id as mid, m.avatar from ' . tablename('ewei_shop_sign_records') . 'r left join ' . tablename('ewei_shop_member') . 'm on r.openid=m.openid ' . $condition . ' order by r.time desc, r.id desc limit ' . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_sign_records') . 'r left join ' . tablename('ewei_shop_member') . 'm on r.openid=m.openid ' . $condition);
		$pager = pagination2($total, $pindex, $psize);
		$count = 0;

		foreach ($list as $item) {
			if (0 < $item['credit']) {
				$count = $count + $item['credit'];
			}
		}

		include $this->template();
	}

	public function set()
	{
		global $_W;
		global $_GPC;
		$set = $this->model->getSet();
		$url = mobileUrl('sign', NULL, true);
		$qrcode = m('qrcode')->createQrcode($url);

		if ($_W['ispost']) {
			cv('sign.set');
			$data = array('iscenter' => intval($_GPC['iscenter']), 'iscreditshop' => intval($_GPC['iscreditshop']), 'keyword' => trim($_GPC['keyword']), 'title' => trim($_GPC['title']), 'title' => trim($_GPC['title']), 'thumb' => trim($_GPC['thumb']), 'desc' => trim($_GPC['desc']), 'share' => intval($_GPC['share']));

			if (empty($data['keyword'])) {
				show_json(0, '请填写关键词!');
			}

			$keyword = m('common')->keyExist($data['keyword']);

			if (!empty($keyword)) {
				if ($keyword['name'] != 'ewei_shopv2:sign') {
					show_json(0, '关键字已存在!');
				}
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2:sign'));

			if (!empty($rule)) {
				$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
				$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
			}

			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:sign', 'module' => 'cover', 'displayorder' => 0, 'status' => 1);

			if (empty($rule)) {
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
			}
			else {
				pdo_update('rule', $rule_data, array('id' => $rule['id']));
				$rid = $rule['id'];
			}

			$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => 1);

			if (empty($keyword)) {
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				pdo_update('rule_keyword', $keyword_data, array('id' => $keyword['id']));
			}

			$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'title' => $data['title'], 'description' => $data['desc'], 'thumb' => $data['thumb'], 'url' => mobileUrl('sign'));

			if (empty($cover)) {
				pdo_insert('cover_reply', $cover_data);
			}
			else {
				pdo_update('cover_reply', $cover_data, array('id' => $cover['id']));
			}

			if (empty($set)) {
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_sign_set', $data);
			}
			else {
				pdo_update('ewei_shop_sign_set', $data, array('id' => $set['id'], 'uniacid' => $_W['uniacid']));
			}

			plog('sign.set.edit', '修改入口设置');
			show_json(1);
		}

		include $this->template();
	}

	public function tpl()
	{
		global $_GPC;
		$tpltype = trim($_GPC['tpltype']);
		include $this->template();
	}
}

?>
