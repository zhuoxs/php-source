<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Manage_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and s.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['bid'] != '') {
			$condition .= ' and s.bid=' . intval($_GPC['bid']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( b.title like :keyword or m.nickname like :keyword or m.realname like :keyword or m.mobile like :keyword )';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT s.*,b.title,m.avatar,m.nickname,m.realname,m.mobile  FROM ' . tablename('ewei_shop_sns_manage') . ' s ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on s.bid= b.id and s.uniacid = b.uniacid ' . ' left join ' . tablename('ewei_shop_member') . ' m on s.openid = m.openid and s.uniacid = m.uniacid ' . (' WHERE 1 ' . $condition . '  ORDER BY s.id  DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_sns_manage') . ' s ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on s.bid= b.id and s.uniacid = b.uniacid ' . ' left join ' . tablename('ewei_shop_member') . ' m on s.openid = m.openid and s.uniacid = m.uniacid ' . (' WHERE 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$boards = pdo_fetchall('select id, title from ' . tablename('ewei_shop_sns_board') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
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

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'bid' => intval($_GPC['bid']), 'openid' => trim($_GPC['openid']));
			$board = $this->model->getBoard($data['bid']);
			$member = m('member')->getMember($data['openid']);

			if (!empty($id)) {
				pdo_update('ewei_shop_sns_manage', $data, array('id' => $id));
				plog('sns.manage.edit', '修改版主 版块: ' . $board['title'] . ' <br/>会员  ID: ' . $member['id'] . ' <br/>会员信息: ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
			else {
				pdo_insert('ewei_shop_sns_manage', $data);
				$id = pdo_insertid();
				plog('sns.manage.add', '添加版主 版块: ' . $board['title'] . '  <br/>会员  ID: ' . $member['id'] . ' <br/>会员信息: ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}

			show_json(1, array('url' => webUrl('sns/manage')));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_sns_manage') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$member = m('member')->getMember($item['openid']);
		}

		$boards = pdo_fetchall('select id, title from ' . tablename('ewei_shop_sns_board') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
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

		$items = pdo_fetchall('SELECT* FROM ' . tablename('ewei_shop_sns_manage') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_sns_manage', array('id' => $item['id']));
			$member = m('member')->getMember($item['openid']);
			$board = $this->model->getBoard($item['bid']);
			plog('sns.manage.delete', '删除版主 版块: ' . $board['title'] . ' <br/>会员  ID: ' . $member['id'] . ' <br/>会员信息: ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
