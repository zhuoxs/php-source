<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Member_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		return app_json(array(
			'perm' => array('member' => cv('member'))
		));
	}

	/**
     * 获取会员列表
     */
	public function get_list()
	{
		global $_W;
		global $_GPC;

		if (!cv('member')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

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
		$listArr = array();

		foreach ($list as $row) {
			$row1 = array();
			$row1['id'] = $row['id'];
			$row1['levelname'] = isset($res_level[$row['level']]) ? $res_level[$row['level']]['levelname'] : '';
			$row1['nickname'] = $row['nickname'];
			$row1['avatar'] = $row['avatar'];
			$row1['followed'] = isset($res_fans[$row['openid']]) ? $res_fans[$row['openid']]['followed'] : '';
			$row1['levelname'] = empty($row1['levelname']) ? (empty($shop['levelname']) ? '普通会员' : $shop['levelname']) : $row1['levelname'];
			$row1['credit1'] = m('member')->getCredit($row['openid'], 'credit1');
			$row1['credit2'] = m('member')->getCredit($row['openid'], 'credit2');
			$row1['groupname'] = isset($res_group[$row['groupid']]) ? $res_group[$row['groupid']]['groupname'] : '';
			$row1['groupname'] = empty($row1['groupname']) ? '未分组' : $row1['groupname'];
			$listArr[] = $row1;
		}

		unset($row);
		$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . ' '), $params);
		return app_json(array(
			'total'    => $total,
			'list'     => $listArr,
			'pagesize' => $psize,
			'page'     => $pindex,
			'perm'     => array('member_view' => cv('member.list.view'), 'member_edit' => cv('member.list.edit'))
		));
	}

	/**
     * 获取会员详情
     */
	public function get_detail()
	{
		global $_W;
		global $_GPC;
		if (!cv('member.list.view') && cv('member.list.edit')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$plugin_commission = p('commission');

		if ($plugin_commission) {
			$member = $plugin_commission->getInfo($id, array('total', 'pay'));
		}
		else {
			$member = m('member')->getMember($id);
		}

		if (empty($member)) {
			return app_error(AppError::$ParamsError, '会员不存在');
		}

		$member['followed'] = m('user')->followed($member['openid']);

		if ($member['followed']) {
			$member['followedtext'] = '已关注';
		}
		else {
			$member['followedtext'] = empty($member['uid']) ? '未关注' : '取消关注';
		}

		$openbind = 0;
		if (empty($_W['shopset']['app']['isclose']) && !empty($_W['shopset']['app']['openbind']) || !empty($_W['shopset']['wap']['open'])) {
			$openbind = 1;
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
			$agentlevels = $plugin_commission->getLevels(true, true);
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
		$groups = array_merge(array(
			array('id' => 0, 'groupname' => '未分组')
		), $groups);
		$levels = m('member')->getLevels();
		$levels = array_merge(array(
			array('id' => 0, 'levelname' => empty($_W['shopset']['shop']['levelname']) ? '普通会员' : $_W['shopset']['shop']['levelname'])
		), $levels);
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

		$result = array(
			'member'          => array('id' => $member['id'], 'avatar' => tomedia($member['avatar']), 'nickname' => $member['nickname'], 'realname' => $member['realname'], 'followed' => $member['followed'], 'followedtext' => $member['followedtext'], 'credit2' => $member['credit2'], 'credit1' => $member['credit1'], 'mobile' => $member['mobile'], 'mobileverify' => $member['mobileverify'], 'weixin' => $member['weixin'], 'isblack' => $member['isblack'], 'content' => $member['content'], 'createtime' => date('Y-m-d H:i:s', $member['createtime']), 'self_ordercount' => $member['self_ordercount'], 'self_ordermoney' => $member['self_ordermoney'], 'last_ordertime' => $member['last_ordertime'], 'level' => $member['level'], 'levelname' => $level_title, 'groupid' => $member['groupid'], 'groupname' => $group_title, 'agentlevel' => $member['agentlevel'], 'agentlevelname' => $comlevel_title, 'fixagentid' => $member['fixagentid'], 'isagent' => $member['isagent'], 'status' => $member['status'], 'agentnotupgrade' => $member['agentnotupgrade'], 'commission_total' => $member['commission_total'], 'commission_pay' => $member['commission_pay'], 'agenttime' => 0 < $member['agenttime'] ? $member['agenttime'] : '非分销商', 'agentselectgoods' => $goods_title),
			'openbind'        => $openbind,
			'hascommission'   => $hascommission,
			'parentagent'     => false,
			'agentlevel_list' => false,
			'level_list'      => $levels,
			'group_list'      => $groups,
			'perm'            => array('member_edit' => cv('member.list.edit'), 'recharge_credit2' => cv('finance.recharge.credit2'), 'recharge_credit1' => cv('finance.recharge.credit1'), 'commission_changeagent' => cv('commission.agent.changeagent'), 'commission_check' => cv('commission.agent.check'), 'order' => cv('order'))
		);

		if ($hascommission) {
			if ($parentagent) {
				$result['parentagent'] = array('id' => $parentagent['id'], 'avatar' => $parentagent['avatar'], 'nickname' => $parentagent['nickname'], 'realname' => $parentagent['realname'], 'mobile' => $parentagent['mobile'], 'weixin' => $parentagent['weixin']);
			}

			$result['agentlevel_list'] = $agentlevels;
		}

		return app_json($result);
	}

	public function submit()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			return app_error(AppError::$RequestError);
		}

		if (!cv('member.list.edit') && !cv('member.list.add')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$id = intval($_GPC['id']);
		$plugin_commission = p('commission');

		if ($plugin_commission) {
			$member = $plugin_commission->getInfo($id, array('total', 'pay'));
		}
		else {
			$member = m('member')->getMember($id);
		}

		$openbind = 0;
		if (empty($_W['shopset']['app']['isclose']) && !empty($_W['shopset']['app']['openbind']) || !empty($_W['shopset']['wap']['open'])) {
			$openbind = 1;
		}

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
		return app_json();
	}
}

?>
