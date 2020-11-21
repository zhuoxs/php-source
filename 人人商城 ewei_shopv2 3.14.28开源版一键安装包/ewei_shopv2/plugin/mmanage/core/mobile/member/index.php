<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'mmanage/core/inc/page_mmanage.php';
class Index_EweiShopV2Page extends MmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (!cv('member')) {
			$this->message('您无操作权限');
		}

		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$offset = intval($_GPC['offset']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and dm.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['id'])) {
			$condition .= ' and dm.id=:mid';
			$params[':mid'] = intval($_GPC['id']);
		}

		if (!empty($_GPC['keywords'])) {
			$keywords = trim($_GPC['keywords']);
			$condition .= ' and ( dm.realname like :keywords or dm.nickname like :keywords or dm.mobile like :keywords or dm.id like :keywords)';
			$params[':keywords'] = '%' . $keywords . '%';
		}

		$join = '';
		$sql = 'select * from ' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . '  ORDER BY id DESC');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$list = set_medias($list, 'avatar');
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

		$shop = $_W['shopset']['shop'];

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
			$row['ordermoney'] = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
			$row['credit1'] = m('member')->getCredit($row['openid'], 'credit1');
			$row['credit2'] = m('member')->getCredit($row['openid'], 'credit2');
			$row['groupname'] = empty($row['groupname']) ? '未分组' : $row['groupname'];
		}

		unset($row);
		$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . ' '), $params);
		show_json(1, array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		if (!cv('member.list.view') && cv('member.list.edit')) {
			$this->message('您无操作权限');
		}

		$id = intval($_GPC['id']);
		$plugin_commission = p('commission');

		if ($plugin_commission) {
			$member = $plugin_commission->getInfo($id, array('total', 'pay'));
		}
		else {
			$member = m('member')->getMember($id);
		}

		if (empty($member)) {
			if ($_W['isajax']) {
				show_json(0, '会员不存在');
			}
			else {
				$this->message('会员不存在');
			}
		}

		$followed = m('user')->followed($member['openid']);
		$openbind = 0;
		if (empty($_W['shopset']['app']['isclose']) && !empty($_W['shopset']['app']['openbind']) || !empty($_W['shopset']['wap']['open'])) {
			$openbind = 1;
		}

		if ($_W['ispost']) {
			ca('member.list.edit');
			$data = array('level' => intval($_GPC['level']), 'groupid' => intval($_GPC['groupid']), 'realname' => trim($_GPC['realname']), 'weixin' => trim($_GPC['weixin']), 'isblack' => intval($_GPC['isblack']), 'content' => trim($_GPC['content']));

			if (empty($openbind)) {
				$data['mobile'] = trim($_GPC['mobile']);
			}
			else {
				if (empty($member['mobileverify']) || empty($member['mobile'])) {
					$password = trim($_GPC['password']);
					$data['mobile'] = trim($_GPC['mobile']);
					$data['mobileverify'] = intval($_GPC['mobileverify']);
					if (!empty($data['mobileverify']) && empty($data['mobile'])) {
						show_json(0, '开启绑定前请填写手机号');
					}

					$m = pdo_fetch('select id from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and mobileverify=1 and uniacid=:uniaicd limit 1 ', array(':mobile' => $data['mobile'], ':uniaicd' => $_W['uniacid']));
					if (!empty($m) && $m['id'] != $id) {
						show_json(0, '此手机号已绑定其他用户!(uid:' . $m['id'] . ')');
					}

					if (!empty($data['mobileverify']) && empty($password)) {
						show_json(0, '开启绑定前请为用户设置密码');
					}

					if (!empty($password)) {
						$salt = $member['salt'];

						if (empty($salt)) {
							$salt = m('account')->getSalt();
						}

						$data['pwd'] = md5($password . $salt);
						$data['salt'] = $salt;
					}
				}

				if (!empty($member['mobileverify']) && !empty($member['mobile'])) {
					$password = trim($_GPC['password']);

					if (!empty($password)) {
						$salt = $member['salt'];

						if (empty($salt)) {
							$salt = m('account')->getSalt();
						}

						$data['pwd'] = md5($password . $salt);
						$data['salt'] = $salt;
					}
				}
			}

			if ($plugin_commission && cv('commission.agent.edit')) {
				$data['fixagentid'] = intval($_GPC['fixagentid']);
				$data['isagent'] = intval($_GPC['isagent']);
				$data['status'] = intval($_GPC['status']);
				$data['agentnotupgrade'] = intval($_GPC['agentnotupgrade']);
				$data['agentlevel'] = intval($_GPC['agentlevel']);
				$data['agentselectgoods'] = intval($_GPC['agentselectgoods']);

				if (cv('commission.agent.check')) {
					if (empty($member['status']) && !empty($data['status'])) {
						$time = time();
						$adata['agenttime'] = time();
						$plugin_commission->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);
						plog('commission.agent.check', '审核分销商 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);

						if (!empty($member['agentid'])) {
							$plugin_commission->upgradeLevelByAgent($member['agentid']);

							if (p('globonus')) {
								p('globonus')->upgradeLevelByAgent($member['agentid']);
							}

							if (p('author')) {
								p('author')->upgradeLevelByAgent($member['agentid']);
							}
						}
					}
				}
				else {
					$data['status'] = $member['status'];
				}

				plog('commission.agent.edit', '修改分销商 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}

			pdo_update('ewei_shop_member', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			plog('member.list.edit', '修改会员资料  ID: ' . $member['id'] . ' <br/> 会员信息:  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			show_json(1);
		}

		$member['self_ordercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
		$member['self_ordermoney'] = pdo_fetchcolumn('select sum(price) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
		$order = pdo_fetch('select finishtime from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status>=1 and finishtime>0 limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
		$member['last_ordertime'] = $order['finishtime'];
		$member['last_ordertime'] = empty($member['last_ordertime']) ? '无任何交易' : date('Y-m-d H:i:s', $member['last_ordertime']);

		if (!empty($member['agentid'])) {
			$parentagent = m('member')->getMember($member['agentid']);
		}

		$hascommission = 0;

		if ($plugin_commission) {
			$hascommission = 1;
			$plugin_com_set = $plugin_commission->getSet();
			$agentlevels = $plugin_commission->getLevels();
			$comlevel_title = empty($plugin_com_set['levelname']) ? '普通等级' : $plugin_com_set['levelname'];
			if (!empty($member['agentlevel']) && !empty($agentlevels)) {
				foreach ($agentlevels as $agentlevel) {
					if ($member['agentlevel'] == $agentlevel['id']) {
						$comlevel_title = $agentlevel['levelname'];
						break;
					}
				}
			}
		}

		$groups = m('member')->getGroups();
		$levels = m('member')->getLevels();
		$shop = $_W['shopset']['shop'];
		$level_title = empty($shop['levelname']) ? '普通会员' : $shop['levelname'];
		if (!empty($member['level']) && $levels) {
			foreach ($levels as $level) {
				if ($level['id'] == $member['level']) {
					$level_title = $level['levelname'];
					break;
				}
			}
		}

		$group_title = '未分组';
		if (!empty($member['groupid']) && $groups) {
			foreach ($groups as $group) {
				if ($member['groupid'] == $group['id']) {
					$group_title = $group['groupname'];
					break;
				}
			}
		}

		$goods_title = '系统设置';

		if ($member['agentselectgoods'] == 1) {
			$goods_title = '强制禁止';
		}
		else {
			if ($member['agentselectgoods'] == 2) {
				$goods_title = '强制开启';
			}
		}

		$json = json_encode(array('hascom' => intval($hascommission), 'bind' => intval($openbind), 'binded' => intval($member['mobileverify']), 'mobile' => trim($member['mobile'])));
		include $this->template();
	}

	public function setblack()
	{
		global $_W;
		global $_GPC;
		ca('member.list.edit.');
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$members = pdo_fetchall('select id,openid,nickname,realname,mobile from ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
		$black = intval($_GPC['isblack']);

		foreach ($members as $member) {
			if (!empty($black)) {
				pdo_update('ewei_shop_member', array('isblack' => 1), array('id' => $member['id']));
				plog('member.list.edit', '设置黑名单 <br/>用户信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
			else {
				pdo_update('ewei_shop_member', array('isblack' => 0), array('id' => $member['id']));
				plog('member.list.edit', '取消黑名单 <br/>用户信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
		}

		show_json(1);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		ca('member.list.delete');
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$members = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($members as $member) {
			pdo_delete('ewei_shop_member', array('id' => $member['id']));

			if (method_exists(m('member'), 'memberRadisCountDelete')) {
				m('member')->memberRadisCountDelete();
			}

			plog('member.list.delete', '删除会员  ID: ' . $member['id'] . ' <br/>会员信息: ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
		}

		show_json(1, array('url' => referer()));
	}
}

?>
