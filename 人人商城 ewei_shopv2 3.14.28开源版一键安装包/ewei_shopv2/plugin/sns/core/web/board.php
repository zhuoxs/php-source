<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Board_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and title  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_sns_board') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_sns_board') . (' WHERE 1 ' . $condition), $params);

		foreach ($list as &$r) {
			$url = mobileUrl('sns/board', array('id' => $r['id']), true);
			$r['qrcode'] = m('qrcode')->createQrcode($url);
			$r['postcount'] = $this->model->getPostCount($r['id']);
			$r['followcount'] = $this->model->getFollowCount($r['id']);
			$r['content'] = $this->model->replaceContent($r['content']);
			$r['images'] = iunserializer($r['images']);

			if (!is_array($r['images'])) {
				$r['images'] = array();
			}
		}

		unset($r);
		$pager = pagination2($total, $pindex, $psize);
		$category = $this->model->getCategory();
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
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_sns_board') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$item['showlevels'] = explode(',', $item['showlevels']);
			$item['postlevels'] = explode(',', $item['postlevels']);
			$item['showagentlevels'] = explode(',', $item['showagentlevels']);
			$item['postagentlevels'] = explode(',', $item['postagentlevels']);
			$item['showgroups'] = explode(',', $item['showgroups']);
			$item['postgroups'] = explode(',', $item['postgroups']);
			$item['showsnslevels'] = explode(',', $item['showsnslevels']);
			$item['postsnslevels'] = explode(',', $item['postsnslevels']);
			$item['showpartnerlevels'] = explode(',', $item['showpartnerlevels']);
			$item['postpartnerlevels'] = explode(',', $item['postpartnerlevels']);
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'cid' => intval($_GPC['cid']), 'title' => trim($_GPC['title']), 'logo' => save_media($_GPC['logo']), 'banner' => save_media($_GPC['banner']), 'desc' => trim($_GPC['desc']), 'displayorder' => intval($_GPC['displayorder']), 'status' => intval($_GPC['status']), 'noimage' => intval($_GPC['noimage']), 'showlevels' => is_array($_GPC['showlevels']) ? implode(',', $_GPC['showlevels']) : '', 'postlevels' => is_array($_GPC['postlevels']) ? implode(',', $_GPC['postlevels']) : '', 'showgroups' => is_array($_GPC['showgroups']) ? implode(',', $_GPC['showgroups']) : '', 'postgroups' => is_array($_GPC['postgroups']) ? implode(',', $_GPC['postgroups']) : '', 'postcredit' => intval($_GPC['postcredit']), 'replycredit' => intval($_GPC['replycredit']), 'topcredit' => intval($_GPC['topcredit']), 'topboardcredit' => intval($_GPC['topboardcredit']), 'bestcredit' => intval($_GPC['bestcredit']), 'bestboardcredit' => intval($_GPC['bestboardcredit']), 'needfollow' => intval($_GPC['needfollow']), 'needpostfollow' => intval($_GPC['needpostfollow']), 'share_title' => trim($_GPC['share_title']), 'share_icon' => trim($_GPC['share_icon']), 'share_desc' => trim($_GPC['share_desc']), 'keyword' => trim($_GPC['keyword']), 'isrecommand' => intval($_GPC['isrecommand']), 'needcheck' => intval($_GPC['needcheck']), 'needcheckmanager' => intval($_GPC['needcheckmanager']), 'needcheckreply' => intval($_GPC['needcheckreply']), 'needcheckreplymanager' => intval($_GPC['needcheckreplymanager']), 'showsnslevels' => is_array($_GPC['showsnslevels']) ? implode(',', $_GPC['showsnslevels']) : '', 'postsnslevels' => is_array($_GPC['postsnslevels']) ? implode(',', $_GPC['postsnslevels']) : '');

			if (p('commission')) {
				$data['notagent'] = intval($_GPC['notagent']);
				$data['showagentlevels'] = is_array($_GPC['showagentlevels']) ? implode(',', $_GPC['showagentlevels']) : '';
				$data['notagentpost'] = intval($_GPC['notagentpost']);
				$data['postagentlevels'] = is_array($_GPC['postagentlevels']) ? implode(',', $_GPC['postagentlevels']) : '';
			}

			if (p('globonus')) {
				$data['notpartner'] = intval($_GPC['notpartner']);
				$data['showpartnerlevels'] = is_array($_GPC['showpartnerlevels']) ? implode(',', $_GPC['showpartnerlevels']) : '';
				$data['notpartnerpost'] = intval($_GPC['notpartnerpost']);
				$data['postpartnerlevels'] = is_array($_GPC['postpartnerlevels']) ? implode(',', $_GPC['postpartnerlevels']) : '';
			}

			if (!empty($id)) {
				if (!empty($data['keyword'])) {
					$keyword = pdo_fetchcolumn('SELECT keyword FROM ' . tablename('ewei_shop_sns_board') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid']));

					if ($data['keyword'] != $item['keyword']) {
						$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid limit 1 ', array(':content' => $data['keyword'], ':uniacid' => $_W['uniacid']));

						if (!empty($keyword)) {
							show_json(0, '关键词 ' . $data['keyword'] . ' 已经使用!');
						}
					}
				}
				else {
					if (!empty($item['keyword'])) {
						$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and module=:module and uniacid=:uniacid limit 1 ', array(':content' => $item['keyword'], ':module' => 'ewei_shopv2', ':uniacid' => $_W['uniacid']));

						if (!empty($keyword)) {
							m('common')->delrule($keyword['rid']);
						}
					}
				}

				pdo_update('ewei_shop_sns_board', $data, array('id' => $id));
				plog('sns.board.edit', '修改版块 ID: ' . $id);
			}
			else {
				if (!empty($data['keyword'])) {
					$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid limit 1 ', array(':content' => $data['keyword'], ':uniacid' => $_W['uniacid']));

					if (!empty($keyword)) {
						show_json(0, '关键词 ' . $data['keyword'] . ' 已经使用!');
					}
				}

				pdo_insert('ewei_shop_sns_board', $data);
				$id = pdo_insertid();
				plog('sns.board.add', '添加版块 ID: ' . $id);
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:sns:board:' . $id));

			if (empty($rule)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:sns:board:' . $id, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				pdo_update('rule_keyword', array('content' => trim($data['keyword'])), array('rid' => $rule['id']));
			}

			pdo_delete('ewei_shop_sns_manage', array('uniacid' => $_W['uniacid'], 'bid' => $id));

			if (is_array($_GPC['openid'])) {
				foreach ($_GPC['openid'] as $openid) {
					$m = array('uniacid' => $_W['uniacid'], 'bid' => $id, 'openid' => $openid);
					pdo_insert('ewei_shop_sns_manage', $m);
				}
			}

			show_json(1, array('url' => webUrl('sns/board/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$levels = m('member')->getLevels();
		$set_member = m('common')->getSysset();
		$set_commission = m('common')->getPluginset('commission');
		$default_name = empty($set_member['shop']['levelname']) ? '普通等级' : $set_member['shop']['levelname'];
		$default_name_commission = empty($set_commission['levelname']) ? '普通等级' : $set_commission['levelname'];
		$groups = m('member')->getGroups();

		if (p('commission')) {
			$agentlevels = p('commission')->getLevels();
		}

		if (p('globonus')) {
			$partnerlevels = p('globonus')->getLevels();
		}

		$category = $this->model->getCategory();
		$snslevels = $this->model->getLevels();

		if (!empty($item)) {
			$managers = pdo_fetchall('select m.id,m.openid,m.avatar,m.nickname from ' . tablename('ewei_shop_sns_manage') . ' sm ' . ' left join ' . tablename('ewei_shop_member') . ' m on sm.openid = m.openid and sm.uniacid = m.uniacid' . ' where sm.uniacid=:uniacid and sm.bid=:bid ', array(':uniacid' => $_W['uniacid'], ':bid' => $item['id']));
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

		$items = pdo_fetchall('SELECT id,title,keyword FROM ' . tablename('ewei_shop_sns_board') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_sns_board', array('id' => $item['id']));
			pdo_delete('ewei_shop_sns_board_follow', array('bid' => $item['id']));
			pdo_delete('ewei_shop_sns_post', array('bid' => $item['id']));

			if (!empty($item['keyword'])) {
				$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and module=:module and uniacid=:uniacid limit 1 ', array(':content' => $item['keyword'], ':module' => 'ewei_shopv2', ':uniacid' => $_W['uniacid']));

				if (!empty($keyword)) {
					m('common')->delrule($keyword['rid']);
				}
			}

			plog('sns.board.delete', '删除版块 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_sns_board') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($item)) {
			pdo_update('ewei_shop_sns_board', array('displayorder' => $displayorder), array('id' => $id));
			plog('sns.board.edit', '修改版块排序 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_sns_board') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_sns_board', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('sns.board.edit', '修改版块状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
