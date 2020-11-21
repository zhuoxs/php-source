<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Member_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and dm.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['realname'])) {
			$_GPC['realname'] = trim($_GPC['realname']);
			$condition .= ' and ( dm.realname like :realname or dm.nickname like :realname or dm.mobile like :realname or dm.id like :realname)';
			$params[':realname'] = '%' . $_GPC['realname'] . '%';
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND sm.createtime >= :starttime AND sm.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if ($_GPC['level'] != '') {
			$condition .= ' and sm.level=' . intval($_GPC['level']);
		}

		if ($_GPC['followed'] != '') {
			if ($_GPC['followed'] == 2) {
				$condition .= ' and f.follow=0 and dm.uid<>0';
			}
			else {
				$condition .= ' and f.follow=' . intval($_GPC['followed']);
			}
		}

		if ($_GPC['isblack'] != '') {
			$condition .= ' and sm.isblack=' . intval($_GPC['isblack']);
		}

		$sql = 'select sm.id as sns_id,sm.credit as sns_credit, sm.level as sns_level,sm.createtime,sm.isblack,sm.openid, ' . ' dm.id,dm.nickname,dm.avatar,dm.agentid, dm.isagent,dm.status,dm.realname,dm.mobile,' . ' a.nickname as agentnickname,a.avatar as agentavatar,' . ' f.follow as followed from ' . tablename('ewei_shop_sns_member') . ' sm ' . ' left join ' . tablename('ewei_shop_member') . ' dm on dm.openid = sm.openid and dm.uniacid = sm.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' a on a.id=dm.agentid' . ' left join ' . tablename('ewei_shop_sns_level') . ' l on sm.level =l.id' . ' left join ' . tablename('mc_mapping_fans') . ('f on f.openid=dm.openid  and f.uniacid=' . $_W['uniacid']) . (' where 1 ' . $condition . '  ORDER BY sm.id DESC');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$set = $this->set;
		$level = array('levelname' => empty($set['levelname']) ? '社区粉丝' : $set['levelname'], 'color' => empty($set['levelcolor']) ? '#333' : $set['levelcolor'], 'bg' => empty($set['levelbg']) ? '#eee' : $set['levelbg']);

		foreach ($list as &$row) {
			$row['level'] = $level;

			if (!empty($row['sns_level'])) {
				$row['level'] = pdo_fetch('select * from ' . tablename('ewei_shop_sns_level') . ' where id=:id  limit 1', array(':id' => $row['sns_level']));
			}

			$row['sns_postcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid=0 and deleted = 0 and checked=1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
			$row['sns_replycount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid>0 and deleted = 0 and checked=1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
		}

		unset($row);
		$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_sns_member') . ' sm ' . ' left join ' . tablename('ewei_shop_member') . ' dm on dm.openid = sm.openid and dm.uniacid = sm.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' a on a.id=dm.agentid' . ' left join ' . tablename('ewei_shop_sns_level') . ' l on sm.level =l.id' . ' left join ' . tablename('mc_mapping_fans') . ('f on f.openid=dm.openid  and f.uniacid=' . $_W['uniacid']) . (' where 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);
		$levels = $this->model->getLevels();
		$opencommission = false;
		$plug_commission = p('commission');

		if ($plug_commission) {
			$comset = $plug_commission->getSet();

			if (!empty($comset)) {
				$opencommission = true;
			}
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

		$items = pdo_fetchall('SELECT id,openid FROM ' . tablename('ewei_shop_sns_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_sns_member', array('id' => $item['id']));
			pdo_delete('ewei_shop_sns_post', array('openid' => $item['openid'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_sns_board_follow', array('openid' => $item['openid'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_sns_like', array('openid' => $item['openid'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_sns_manage', array('openid' => $item['openid'], 'uniacid' => $_W['uniacid']));
			$member = m('member')->getMember($item['openid']);
			plog('sns.member.delete', '删除会员 ID: ' . $item['id'] . ' 昵称: ' . $member['nickname'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function setblack()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,openid FROM ' . tablename('ewei_shop_sns_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_sns_member', array('isblack' => intval($_GPC['isblack'])), array('id' => $item['id']));
			$member = m('member')->getMember($item['openid']);
			plog('sns.member.edit', '设置黑名单<br/>ID: ' . $item['id'] . '<br/>昵称: ' . $member['nickname'] . '<br/>状态: ' . $_GPC['isblack'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
