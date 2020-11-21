<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Agent_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$agentlevels = $this->model->getLevels(true, true);
		$level = $this->set['level'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$params = array();
		$condition = '';
		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'member') {
				$condition .= ' and ( dm.realname like :keyword or dm.nickname like :keyword or dm.mobile like :keyword)';
				$params[':keyword'] = '%' . $keyword . '%';
			}
			else {
				if ($searchfield == 'parent') {
					if ($keyword == '总店') {
						$condition .= ' and dm.agentid=0';
					}
					else {
						$condition .= ' and ( p.mobile like :keyword or p.nickname like :keyword or p.realname like :keyword)';
						$params[':keyword'] = '%' . $keyword . '%';
					}
				}
			}
		}

		if ($_GPC['followed'] != '') {
			if ($_GPC['followed'] == 2) {
				$condition .= ' and f.follow=0 and dm.uid<>0';
			}
			else {
				$condition .= ' and f.follow=' . intval($_GPC['followed']);
			}
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND dm.agenttime >= :starttime AND dm.agenttime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if ($_GPC['agentlevel'] != '') {
			$condition .= ' and dm.agentlevel=' . intval($_GPC['agentlevel']);
		}

		if ($_GPC['status'] != '') {
			$condition .= ' and dm.status=' . intval($_GPC['status']);
		}

		if ($_GPC['agentblack'] != '') {
			$condition .= ' and dm.agentblack=' . intval($_GPC['agentblack']);
		}

		$sql = 'select dm.*,dm.nickname,dm.avatar,l.levelname,p.nickname as parentname,p.avatar as parentavatar from ' . tablename('ewei_shop_member') . ' dm ' . ' left join ' . tablename('ewei_shop_member') . ' p on p.id = dm.agentid ' . ' left join ' . tablename('ewei_shop_commission_level') . ' l on l.id = dm.agentlevel' . ' left join ' . tablename('mc_mapping_fans') . ('f on f.openid=dm.openid and f.uniacid=' . $_W['uniacid']) . ' where dm.uniacid = ' . $_W['uniacid'] . (' and dm.isagent =1  ' . $condition . ' ORDER BY dm.agenttime desc');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(dm.id) from' . tablename('ewei_shop_member') . ' dm  ' . ' left join ' . tablename('ewei_shop_member') . ' p on p.id = dm.agentid ' . ' left join ' . tablename('mc_mapping_fans') . 'f on f.openid=dm.openid' . ' where dm.uniacid =' . $_W['uniacid'] . (' and dm.isagent =1 ' . $condition), $params);
		$array = array('total', 'pay', 'ordercount0', 'ordermoney0', 'ordercount', 'ordermoney', 'ordercount3', 'ordermoney3');
		if (!empty($_GPC['ordertime']['start']) && !empty($_GPC['ordertime']['end'])) {
			$starttime = strtotime($_GPC['ordertime']['start']);
			$endtime = strtotime($_GPC['ordertime']['end']);
			$array['starttime'] = $starttime;
			$array['endtime'] = $endtime;
		}

		foreach ($list as &$row) {
			$info = $this->model->getInfo($row['openid'], $array);
			$row['level1_ordercount'] = $info['order1'];
			$row['level2_ordercount'] = $info['order2'];
			$row['level3_ordercount'] = $info['order3'];
			$row['level_ordercount'] = $row['level1_ordercount'] + $row['level2_ordercount'] + $row['level3_ordercount'];
			$row['ordermoney'] = $info['ordermoney'];
			$sdata = $this->model->getStatistics($info);
			$row['level_commission_total'] = $sdata['level_commission_total'];
			$row['levelcount'] = $info['agentcount'];

			if (1 <= $level) {
				$row['level1'] = $info['level1'];
			}

			if (2 <= $level) {
				$row['level2'] = $info['level2'];
			}

			if (3 <= $level) {
				$row['level3'] = $info['level3'];
			}

			$row['credit1'] = m('member')->getCredit($row['openid'], 'credit1');
			$row['credit2'] = m('member')->getCredit($row['openid'], 'credit2');
			$row['commission_total'] = $info['commission_total'];
			$row['commission_pay'] = $info['commission_pay'];
			$row['followed'] = m('user')->followed($row['openid']);
			if (p('diyform') && !empty($row['diymemberfields']) && !empty($row['diymemberdata'])) {
				$diyformdata_array = p('diyform')->getDatas(iunserializer($row['diymemberfields']), iunserializer($row['diymemberdata']));
				$diyformdata = '';

				foreach ($diyformdata_array as $da) {
					$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
				}

				$row['member_diyformdata'] = $diyformdata;
			}

			if (p('diyform') && !empty($row['diycommissionfields']) && !empty($row['diycommissiondata'])) {
				$diyformdata_array = p('diyform')->getDatas(iunserializer($row['diycommissionfields']), iunserializer($row['diycommissiondata']));
				$diyformdata = '';

				foreach ($diyformdata_array as $da) {
					$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
				}

				$row['agent_diyformdata'] = $diyformdata;
			}
		}

		unset($row);

		if ($_GPC['export'] == '1') {
			ca('commission.agent.export');
			plog('commission.agent.export', '导出分销商统计数据');

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['agentime'] = empty($row['agenttime']) ? '' : date('Y-m-d H:i', $row['agentime']);
				$row['groupname'] = empty($row['groupname']) ? '无分组' : $row['groupname'];
				$row['levelname'] = empty($row['levelname']) ? '普通等级' : $row['levelname'];
				$row['parentname'] = empty($row['parentname']) ? '总店' : '[' . $row['agentid'] . ']' . $row['parentname'];
				$row['statusstr'] = empty($row['status']) ? '' : '通过';
				$row['followstr'] = empty($row['followed']) ? '' : '已关注';
			}

			unset($row);
			$columns = array(
				array('title' => 'ID', 'field' => 'id', 'width' => 12),
				array('title' => '昵称', 'field' => 'nickname', 'width' => 12),
				array('title' => '姓名', 'field' => 'realname', 'width' => 12),
				array('title' => '手机号', 'field' => 'mobile', 'width' => 12),
				array('title' => '微信号', 'field' => 'weixin', 'width' => 12),
				array('title' => 'openid', 'field' => 'openid', 'width' => 24),
				array('title' => '推荐人', 'field' => 'parentname', 'width' => 12),
				array('title' => '分销商等级', 'field' => 'levelname', 'width' => 12),
				array('title' => '点击数', 'field' => 'clickcount', 'width' => 12),
				array('title' => '下线分销商总数', 'field' => 'levelcount', 'width' => 12),
				array('title' => '一级下线分销商数', 'field' => 'level1', 'width' => 12),
				array('title' => '二级下线分销商数', 'field' => 'level2', 'width' => 12),
				array('title' => '三级下线分销商数', 'field' => 'level3', 'width' => 12),
				array('title' => '累计佣金', 'field' => 'commission_total', 'width' => 12),
				array('title' => '打款佣金', 'field' => 'commission_pay', 'width' => 12),
				array('title' => '分销金额', 'field' => 'ordermoney', 'width' => 12),
				array('title' => '分销订单数量', 'field' => 'level_ordercount', 'width' => 12),
				array('title' => '一级分销订单数量', 'field' => 'level1_ordercount', 'width' => 12),
				array('title' => '二级分销订单数量', 'field' => 'level2_ordercount', 'width' => 12),
				array('title' => '三级分销订单数量', 'field' => 'level3_ordercount', 'width' => 12),
				array('title' => '下级累计佣金', 'field' => 'level_commission_total', 'width' => 12),
				array('title' => '注册时间', 'field' => 'createtime', 'width' => 12),
				array('title' => '成为分销商时间', 'field' => 'createtime', 'width' => 12),
				array('title' => '审核状态', 'field' => 'createtime', 'width' => 12),
				array('title' => '是否关注', 'field' => 'followstr', 'width' => 12)
			);

			if (p('diyform')) {
				$columns[] = array('title' => '分销商会员自定义信息', 'field' => 'member_diyformdata', 'width' => 36);
				$columns[] = array('title' => '分销商申请自定义信息', 'field' => 'agent_diyformdata', 'width' => 36);
			}

			m('excel')->export($list, array('title' => '分销商统计数据-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		$pager = pagination2($total, $pindex, $psize);
		load()->func('tpl');
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
			pdo_update('ewei_shop_member', array('isagent' => 0, 'status' => 0), array('id' => $member['id']));
			plog('commission.agent.delete', '取消分销商资格 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
		}

		show_json(1, array('url' => referer()));
	}

	public function user()
	{
		global $_W;
		global $_GPC;
		$level = intval($_GPC['level']);
		$agentid = intval($_GPC['id']);
		$member = $this->model->getInfo($agentid);
		$total = $member['agentcount'];
		$level1 = $member['level1'];
		$level2 = $member['level2'];
		$level3 = $member['level3'];
		$level11 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where isagent=0 and agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $agentid, ':uniacid' => $_W['uniacid']));
		$condition = '';
		$params = array();

		if (empty($level)) {
			$condition = ' and ( dm.agentid=' . $member['id'];

			if (0 < $level1) {
				$condition .= ' or  dm.agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ')';
			}

			if (0 < $level2) {
				$condition .= ' or  dm.agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ')';
			}

			$condition .= ' )';
			$hasagent = true;
		}
		else if ($level == 1) {
			if (0 < $level1) {
				$condition = ' and dm.agentid=' . $member['id'];
				$hasagent = true;
			}
		}
		else if ($level == 2) {
			if (0 < $level2) {
				$condition = ' and dm.agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ')';
				$hasagent = true;
			}
		}
		else {
			if ($level == 3) {
				if (0 < $level3) {
					$condition = ' and dm.agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ')';
					$hasagent = true;
				}
			}
		}

		if (!empty($_GPC['mid'])) {
			$condition .= ' and dm.id=:mid';
			$params[':mid'] = intval($_GPC['mid']);
		}

		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'member') {
				$condition .= ' and ( dm.realname like :keyword or dm.nickname like :keyword or dm.mobile like :keyword)';
				$params[':keyword'] = '%' . $keyword . '%';
			}
			else {
				if ($searchfield == 'parent') {
					if ($keyword == '总店') {
						$condition .= ' and dm.agentid=0';
					}
					else {
						$condition .= ' and ( p.mobile like :keyword or p.nickname like :keyword or p.realname like :keyword)';
						$params[':keyword'] = '%' . $keyword . '%';
					}
				}
			}
		}

		if ($_GPC['isagent'] != '') {
			$condition .= ' and dm.isagent=' . intval($_GPC['isagent']);
		}

		if ($_GPC['status'] != '') {
			$condition .= ' and dm.status=' . intval($_GPC['status']);
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND dm.agenttime >= :starttime AND dm.agenttime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if ($_GPC['followed'] != '') {
			if ($_GPC['followed'] == 2) {
				$condition .= ' and f.follow=0 and dm.uid<>0';
			}
			else {
				$condition .= ' and f.follow=' . intval($_GPC['followed']);
			}
		}

		if ($_GPC['isagentblack'] != '') {
			$condition .= ' and dm.agentblack=' . intval($_GPC['isagentblack']);
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = array();

		if ($hasagent) {
			$total = pdo_fetchcolumn('select count(dm.id) from' . tablename('ewei_shop_member') . ' dm ' . ' left join ' . tablename('ewei_shop_member') . ' p on p.id = dm.agentid ' . ' left join ' . tablename('mc_mapping_fans') . 'f on f.openid=dm.openid' . ' where dm.uniacid =' . $_W['uniacid'] . ('  ' . $condition), $params);
			$list = pdo_fetchall('select dm.*,p.nickname as parentname,p.avatar as parentavatar  from ' . tablename('ewei_shop_member') . ' dm ' . ' left join ' . tablename('ewei_shop_member') . ' p on p.id = dm.agentid ' . ' left join ' . tablename('mc_mapping_fans') . ('f on f.openid=dm.openid  and f.uniacid=' . $_W['uniacid']) . ' where dm.uniacid = ' . $_W['uniacid'] . ('  ' . $condition . '   ORDER BY dm.agenttime desc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
			$pager = pagination($total, $pindex, $psize);

			foreach ($list as &$row) {
				$info = $this->model->getInfo($row['openid'], array('total', 'pay'));
				$row['levelcount'] = $info['agentcount'];

				if (1 <= $this->set['level']) {
					$row['level1'] = $info['level1'];
				}

				if (2 <= $this->set['level']) {
					$row['level2'] = $info['level2'];
				}

				if (3 <= $this->set['level']) {
					$row['level3'] = $info['level3'];
				}

				$row['credit1'] = m('member')->getCredit($row['openid'], 'credit1');
				$row['credit2'] = m('member')->getCredit($row['openid'], 'credit2');
				$row['commission_total'] = $info['commission_total'];
				$row['commission_pay'] = $info['commission_pay'];
				$row['followed'] = m('user')->followed($row['openid']);

				if ($row['agentid'] == $member['id']) {
					$row['level'] = 1;
				}
				else if (in_array($row['agentid'], array_keys($member['level1_agentids']))) {
					$row['level'] = 2;
				}
				else {
					if (in_array($row['agentid'], array_keys($member['level2_agentids']))) {
						$row['level'] = 3;
					}
				}
			}
		}

		unset($row);

		if ($_GPC['export'] == 1) {
			foreach ($list as &$row) {
				$row['realname'] = str_replace('=', '', $row['realname']);
				$row['nickname'] = str_replace('=', '', $row['nickname']);
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['agentime'] = empty($row['agenttime']) ? '' : date('Y-m-d H:i', $row['agentime']);
				$row['groupname'] = empty($row['groupname']) ? '无分组' : $row['groupname'];
				$row['levelname'] = empty($row['levelname']) ? '普通等级' : $row['levelname'];
				$row['parentname'] = empty($row['parentname']) ? '总店' : '[' . $row['agentid'] . ']' . $row['parentname'];
				$row['statusstr'] = empty($row['status']) ? '' : '通过';
				$row['followstr'] = empty($row['followed']) ? '' : '已关注';
				if (p('diyform') && !empty($row['diycommissionfields']) && !empty($row['diycommissiondata'])) {
					$diyformdata_array = p('diyform')->getDatas(iunserializer($row['diycommissionfields']), iunserializer($row['diycommissiondata']));
					$diyformdata = '';

					foreach ($diyformdata_array as $da) {
						$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
					}

					$row['agent_diyformdata'] = $diyformdata;
				}
			}

			unset($row);
			$columns = array(
				array('title' => 'ID', 'field' => 'id', 'width' => 12),
				array('title' => '昵称', 'field' => 'nickname', 'width' => 12),
				array('title' => '姓名', 'field' => 'realname', 'width' => 12),
				array('title' => '手机号', 'field' => 'mobile', 'width' => 12),
				array('title' => '微信号', 'field' => 'weixin', 'width' => 12),
				array('title' => 'openid', 'field' => 'openid', 'width' => 24),
				array('title' => '推荐人', 'field' => 'parentname', 'width' => 12),
				array('title' => '分销商等级', 'field' => 'levelname', 'width' => 12),
				array('title' => '点击数', 'field' => 'clickcount', 'width' => 12),
				array('title' => '下线分销商总数', 'field' => 'levelcount', 'width' => 12),
				array('title' => '一级下线分销商数', 'field' => 'level1', 'width' => 12),
				array('title' => '二级下线分销商数', 'field' => 'level2', 'width' => 12),
				array('title' => '三级下线分销商数', 'field' => 'level3', 'width' => 12),
				array('title' => '累计佣金', 'field' => 'commission_total', 'width' => 12),
				array('title' => '打款佣金', 'field' => 'commission_pay', 'width' => 12),
				array('title' => '注册时间', 'field' => 'createtime', 'width' => 12),
				array('title' => '成为分销商时间', 'field' => 'createtime', 'width' => 12),
				array('title' => '审核状态', 'field' => 'createtime', 'width' => 12),
				array('title' => '是否关注', 'field' => 'followstr', 'width' => 12)
			);

			if (p('diyform')) {
				$columns[] = array('title' => '分销商自定义信息', 'field' => 'agent_diyformdata', 'width' => 36);
			}

			m('excel')->export($list, array('title' => '推广下线-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		load()->func('tpl');
		include $this->template('commission/agent_user');
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$wechatid = intval($_GPC['wechatid']);

		if (empty($wechatid)) {
			$wechatid = $_W['uniacid'];
		}

		$params = array();
		$params[':uniacid'] = $wechatid;
		$condition = ' and uniacid=:uniacid and isagent=1 and status=1';

		if (!empty($kwd)) {
			$condition .= ' AND ( `nickname` LIKE :keyword or `realname` LIKE :keyword or `mobile` LIKE :keyword )';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		if (!empty($_GPC['selfid'])) {
			$condition .= ' and id<>' . intval($_GPC['selfid']);
		}

		$ds = pdo_fetchall('SELECT id,avatar,nickname,openid,realname,mobile FROM ' . tablename('ewei_shop_member') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		include $this->template('commission/query');
	}

	public function check()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$status = intval($_GPC['status']);
		$members = pdo_fetchall('SELECT id,openid,nickname,realname,mobile,status FROM ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
		$time = time();

		foreach ($members as $member) {
			if ($member['status'] === $status) {
				continue;
			}

			if ($status == 1) {
				pdo_update('ewei_shop_member', array('status' => 1, 'agenttime' => $time), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
				plog('commission.agent.check', '审核分销商 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
				$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);

				if (!empty($member['agentid'])) {
					$this->model->upgradeLevelByAgent($member['agentid']);

					if (p('globonus')) {
						p('globonus')->upgradeLevelByAgent($member['agentid']);
					}

					if (p('author')) {
						p('author')->upgradeLevelByAgent($member['agentid']);
					}
				}
			}
			else {
				pdo_update('ewei_shop_member', array('status' => 0, 'agenttime' => 0), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
				plog('commission.agent.check', '取消审核 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function agentblack()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$agentblack = intval($_GPC['agentblack']);
		$members = pdo_fetchall('SELECT id,openid,nickname,realname,mobile,agentblack FROM ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($members as $member) {
			if ($member['agentblack'] === $agentblack) {
				continue;
			}

			if ($agentblack == 1) {
				pdo_update('ewei_shop_member', array('isagent' => 1, 'status' => 0, 'agentblack' => 1), array('id' => $member['id']));
				plog('commission.agent.agentblack', '设置黑名单 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
			else {
				pdo_update('ewei_shop_member', array('isagent' => 1, 'status' => 1, 'agentblack' => 0), array('id' => $member['id']));
				plog('commission.agent.agentblack', '取消黑名单 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
		}

		show_json(1, array('url' => referer()));
	}
}

?>
