<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Repeat_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$init = pdo_tableexists('ewei_shop_member_tmp');

		if ($init) {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$condition = ' and dm.uniacid=:uniacid';
			$params = array(':uniacid' => $_W['uniacid']);

			if (!empty($_GPC['mid'])) {
				$condition .= ' and dm.id=:mid';
				$params[':mid'] = intval($_GPC['mid']);
			}

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
				$condition .= ' AND dm.createtime >= :starttime AND dm.createtime <= :endtime ';
				$params[':starttime'] = $starttime;
				$params[':endtime'] = $endtime;
			}

			if ($_GPC['level'] != '') {
				$condition .= ' and dm.level=' . intval($_GPC['level']);
			}

			if ($_GPC['groupid'] != '') {
				$condition .= ' and dm.groupid=' . intval($_GPC['groupid']);
			}

			$join = ' join ' . tablename('ewei_shop_member_tmp') . ' tmp on tmp.openid=dm.openid ';

			if ($_GPC['followed'] != '') {
				if ($_GPC['followed'] == 2) {
					$condition .= ' and f.follow=0 and f.unfollowtime<>0';
				}
				else {
					$condition .= ' and f.follow=' . intval($_GPC['followed']) . ' and f.unfollowtime=0 ';
				}

				$join .= ' join ' . tablename('mc_mapping_fans') . ' f on f.openid=dm.openid';
			}

			if ($_GPC['isblack'] != '') {
				$condition .= ' and dm.isblack=' . intval($_GPC['isblack']);
			}

			$sql = 'select * from ' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . '  ORDER BY dm.openid DESC,dm.createtime DESC ');

			if (empty($_GPC['export'])) {
				$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
			}

			$list = pdo_fetchall($sql, $params);
			$list_group = array();
			$list_level = array();
			$list_agent = array();
			$list_fans = array();

			foreach ($list as $val) {
				$list_group[] = trim($val['groupid'], ',');
				$list_level[] = trim($val['level'], ',');
				$list_agent[] = trim($val['agentid'], ',');
				$list_fans[] = trim($val['openid'], ',');
			}

			$memberids = array_keys($list);
			isset($list_group) && ($list_group = array_values(array_filter($list_group)));

			if (!empty($list_group)) {
				$res_group = pdo_fetchall('select id,groupname from ' . tablename('ewei_shop_member_group') . ' where id in (' . implode(',', $list_group) . ')', array(), 'id');
			}

			isset($list_level) && ($list_level = array_values(array_filter($list_level)));

			if (!empty($list_level)) {
				$res_level = pdo_fetchall('select id,levelname from ' . tablename('ewei_shop_member_level') . ' where id in (' . implode(',', $list_level) . ')', array(), 'id');
			}

			isset($list_agent) && ($list_agent = array_values(array_filter($list_agent)));

			if (!empty($list_agent)) {
				$res_agent = pdo_fetchall('select id,nickname as agentnickname,avatar as agentavatar from ' . tablename('ewei_shop_member') . ' where id in (' . implode(',', $list_agent) . ')', array(), 'id');
			}

			isset($list_fans) && ($list_fans = array_values(array_filter($list_fans)));

			if (!empty($list_fans)) {
				$res_fans = pdo_fetchall('select fanid,openid,follow as followed, unfollowtime from ' . tablename('mc_mapping_fans') . ' where openid in (\'' . implode('\',\'', $list_fans) . '\')', array(), 'openid');
			}

			$shop = m('common')->getSysset('shop');

			foreach ($list as &$row) {
				$row['groupname'] = isset($res_group[$row['groupid']]) ? $res_group[$row['groupid']]['groupname'] : '';
				$row['levelname'] = isset($res_level[$row['level']]) ? $res_level[$row['level']]['levelname'] : '';
				$row['agentnickname'] = isset($res_agent[$row['agentid']]) ? $res_agent[$row['agentid']]['agentnickname'] : '';
				$row['agentavatar'] = isset($res_agent[$row['agentid']]) ? $res_agent[$row['agentid']]['agentavatar'] : '';
				$row['followed'] = isset($res_fans[$row['openid']]) ? $res_fans[$row['openid']]['followed'] : '';
				$row['unfollowtime'] = isset($res_fans[$row['openid']]) ? $res_fans[$row['openid']]['unfollowtime'] : '';
				$row['fanid'] = isset($res_fans[$row['openid']]) ? $res_fans[$row['openid']]['fanid'] : '';
				$row['levelname'] = empty($row['levelname']) ? (empty($shop['levelname']) ? '普通会员' : $shop['levelname']) : $row['levelname'];
				$row['ordercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
				$row['ordermoney'] = pdo_fetchcolumn('select sum(price) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
				$row['credit1'] = m('member')->getCredit($row['openid'], 'credit1');
				$row['credit2'] = m('member')->getCredit($row['openid'], 'credit2');
			}

			unset($row);
			$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . ' '), $params);
			$pager = pagination2($total, $pindex, $psize);
			$opencommission = false;
			$plug_commission = p('commission');

			if ($plug_commission) {
				$comset = $plug_commission->getSet();

				if (!empty($comset)) {
					$opencommission = true;
				}
			}

			$groups = m('member')->getGroups();
			$levels = m('member')->getLevels();
			$set = m('common')->getSysset();
			$default_levelname = empty($set['shop']['levelname']) ? '普通等级' : $set['shop']['levelname'];
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

		$members = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($members as $member) {
			if (empty($member['agentid'])) {
				$m = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member') . ' WHERE openid=\'' . $member['openid'] . '\' AND id <> ' . $member['id'] . ' AND uniacid=' . $_W['uniacid'] . ' limit 1');

				if (!empty($m)) {
					if (!empty($member['credit1'])) {
						if (empty($m['credit1'])) {
							$credit1 = $member['credit1'];
						}
						else {
							$credit1 = $m['credit1'] < $member['credit1'] ? $member['credit1'] : $m['credit1'];
						}

						pdo_update('ewei_shop_member', array('credit1' => $credit1), array('id' => $m['id'], 'uniacid' => $_W['uniacid']));
					}

					if (!empty($member['credit2'])) {
						if (empty($m['credit2'])) {
							$credit2 = $member['credit2'];
						}
						else {
							$credit2 = $m['credit2'] < $member['credit2'] ? $member['credit2'] : $m['credit2'];
						}

						pdo_update('ewei_shop_member', array('credit2' => $credit2), array('id' => $m['id'], 'uniacid' => $_W['uniacid']));
					}

					pdo_update('ewei_shop_member', array('agentid' => $m['id']), array('agentid' => $member['id'], 'uniacid' => $_W['uniacid']));
					pdo_delete('ewei_shop_member', array('id' => $member['id']));

					if (method_exists(m('member'), 'memberRadisCountDelete')) {
						m('member')->memberRadisCountDelete();
					}

					pdo_delete('ewei_shop_member_tmp', array('openid' => $member['openid'], 'uniacid' => $member['uniacid']));
					plog('member.list.delete', '删除会员  ID: ' . $member['id'] . ' <br/>会员信息: ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
				}
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function init()
	{
		global $_W;
		global $_GPC;
		$init = pdo_tableexists('ewei_shop_member_tmp');

		if ($init) {
			pdo_query('DROP TABLE ' . tablename('ewei_shop_member_tmp'));
		}

		pdo_run('CREATE TABLE ' . tablename('ewei_shop_member_tmp') . ' (`uniacid` int(11) DEFAULT \'0\',`openid` varchar(50) DEFAULT \'\') ENGINE=MyISAM DEFAULT CHARSET=utf8;');
		pdo_query('INSERT INTO  ' . tablename('ewei_shop_member_tmp') . ' SELECT uniacid,openid FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid=:uniacid  GROUP BY openid HAVING COUNT(openid)>1', array(':uniacid' => $_W['uniacid']));
		show_json(1);
	}

	public function upmember()
	{
		global $_W;
		global $_GPC;
		$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		$members = pdo_fetchall('select id,openid,nickname,realname,avatar from ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($members as $member) {
			pdo_update('ewei_shop_member', array('nickname' => '', 'realname' => '', 'avatar' => ''), array('id' => $member['id']));
		}

		show_json(1);
	}
}

?>
