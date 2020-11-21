<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Agent_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$aagentlevels = $this->model->getLevels(true, true);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$params = array();
		$condition = '';
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' and ( dm.realname like :keyword or dm.nickname like :keyword or dm.mobile like :keyword)';
			$params[':keyword'] = '%' . $keyword . '%';
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
			$condition .= ' AND dm.aagenttime >= :starttime AND dm.aagenttime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if ($_GPC['aagentlevel'] != '') {
			$condition .= ' and dm.aagentlevel=' . intval($_GPC['aagentlevel']);
		}

		if ($_GPC['aagenttype'] != '') {
			$condition .= ' and dm.aagenttype=' . intval($_GPC['aagenttype']);
		}

		if ($_GPC['aagentblack'] != '') {
			$condition .= ' and dm.aagentblack=' . intval($_GPC['aagentblack']);
		}

		if ($_GPC['aagentstatus'] != '') {
			$condition .= ' and dm.aagentstatus=' . intval($_GPC['aagentstatus']);
		}

		$sql = 'select dm.*,dm.nickname,dm.avatar,l.levelname,p.nickname as parentname,p.avatar as parentavatar from ' . tablename('ewei_shop_member') . ' dm ' . ' left join ' . tablename('ewei_shop_member') . ' p on p.id = dm.agentid ' . ' left join ' . tablename('ewei_shop_abonus_level') . ' l on l.id = dm.aagentlevel' . ' where dm.uniacid = ' . $_W['uniacid'] . (' and dm.isaagent =1  ' . $condition . ' ORDER BY dm.aagenttime desc');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(dm.id) from' . tablename('ewei_shop_member') . ' dm  ' . ' left join ' . tablename('ewei_shop_member') . ' p on p.id = dm.agentid ' . ' left join ' . tablename('ewei_shop_abonus_level') . ' l on l.id = dm.aagentlevel' . ' where dm.uniacid =' . $_W['uniacid'] . (' and dm.isaagent =1  ' . $condition), $params);
		$geo_key = pdo_fetchcolumn('SELECT geo_key FROM ' . tablename('ewei_shop_city_express') . ' WHERE uniacid=:uniacid and merchid=0 limit 1', array(':uniacid' => $_W['uniacid']));

		if (empty($geo_key)) {
			$geo_key = 0;
		}

		foreach ($list as &$row) {
			$bonus = $this->model->getBonus($row['openid'], array('ok'));
			$row['bonus'] = $bonus['ok'];
			$row['followed'] = m('user')->followed($row['openid']);
			$agent_district = '';

			if ($row['aagenttype'] == 1) {
				$agent_info = iunserializer($row['aagentprovinces']);
				$agent_district = $agent_info[0];
			}
			else if ($row['aagenttype'] == 2) {
				$agent_info = iunserializer($row['aagentcitys']);
				$data = m('util')->geocode($agent_info[0], $geo_key);
				if ($data['status'] == 1 && 0 < $data['count']) {
					$agent_district = $data['geocodes'][0]['city'];
				}
				else {
					$agent_district = $row['city'];
				}
			}
			else {
				if ($row['aagenttype'] == 3) {
					$agent_info = iunserializer($row['aagentareas']);
					$data = m('util')->geocode($agent_info[0], $geo_key);
					if ($data['status'] == 1 && 0 < $data['count']) {
						$agent_district = $data['geocodes'][0]['district'];
					}
					else {
						$agent_district = $row['area'];
					}
				}
			}

			$row['agent_district'] = $agent_district;
		}

		unset($row);

		if ($_GPC['export'] == '1') {
			ca('abonus.agent.export');
			plog('abonus.agent.export', '导出区域代理商数据');

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['aagentime'] = empty($row['aagenttime']) ? '' : date('Y-m-d H:i', $row['aagentime']);
				$row['groupname'] = empty($row['groupname']) ? '无分组' : $row['groupname'];
				$row['levelname'] = empty($row['levelname']) ? '普通等级' : $row['levelname'];
				$row['parentname'] = empty($row['parentname']) ? '总店' : '[' . $row['agentid'] . ']' . $row['parentname'];
				$row['statusstr'] = empty($row['status']) ? '' : '通过';
				$row['followstr'] = empty($row['followed']) ? '' : '已关注';
			}

			unset($row);
			m('excel')->export($list, array(
	'title'   => '区域代理数据-' . date('Y-m-d-H-i', time()),
	'columns' => array(
		array('title' => 'ID', 'field' => 'id', 'width' => 12),
		array('title' => '昵称', 'field' => 'nickname', 'width' => 12),
		array('title' => '姓名', 'field' => 'realname', 'width' => 12),
		array('title' => '手机号', 'field' => 'mobile', 'width' => 12),
		array('title' => '微信号', 'field' => 'weixin', 'width' => 12),
		array('title' => 'openid', 'field' => 'openid', 'width' => 24),
		array('title' => '推荐人', 'field' => 'parentname', 'width' => 12),
		array('title' => '代理商等级', 'field' => 'levelname', 'width' => 12),
		array('title' => '累计分红', 'field' => 'bonus', 'width' => 12),
		array('title' => '注册时间', 'field' => 'createtime', 'width' => 12),
		array('title' => '成为代理商时间', 'field' => 'aagenttime', 'width' => 12),
		array('title' => '审核状态', 'field' => 'statusstr', 'width' => 12),
		array('title' => '是否关注', 'field' => 'followstr', 'width' => 12)
		)
	));
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
			pdo_update('ewei_shop_member', array('isaagent' => 0, 'aagentstatus' => 0), array('id' => $member['id']));
			plog('abonus.agent.delete', '取消区域代理资格 <br/>区域代理信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
		}

		show_json(1, array('url' => referer()));
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
		$condition = ' and uniacid=:uniacid and isaagent=1';

		if (!empty($kwd)) {
			$condition .= ' AND ( `nickname` LIKE :keyword or `realname` LIKE :keyword or `mobile` LIKE :keyword )';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		if (!empty($_GPC['selfid'])) {
			$condition .= ' and id<>' . intval($_GPC['selfid']);
		}

		$ds = pdo_fetchall('SELECT id,avatar,nickname,openid,realname,mobile FROM ' . tablename('ewei_shop_member') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		include $this->template('abonus/query');
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
		$members = pdo_fetchall('SELECT id,openid,nickname,realname,mobile,aagentstatus,aagenttype,aagentareas,aagentprovinces,aagentcitys FROM ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
		$time = time();

		foreach ($members as $member) {
			if ($member['aagentstatus'] === $status) {
				continue;
			}

			if ($status == 1) {
				switch ($member['aagenttype']) {
				case '1':
					$aagentprovinces = (array) iunserializer($member['aagentprovinces']);
				case '2':
					$aagentcitys = (array) iunserializer($member['aagentcitys']);
				case '3':
					$aagentareas = (array) iunserializer($member['aagentareas']);
				}

				$area = array_merge((array) $aagentprovinces, (array) $aagentcitys, (array) $aagentareas);
				pdo_update('ewei_shop_member', array('aagentstatus' => 1, 'aagenttime' => $time), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
				plog('abonus.aagent.check', '审核代理 <br/>代理信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
				$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'aagenttime' => $time, 'aagenttype' => $member['aagenttype'], 'aagentareas' => implode(';', $area)), TM_ABONUS_BECOME);
			}
			else {
				pdo_update('ewei_shop_member', array('aagentstatus' => 0, 'aagenttime' => 0), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
				plog('abonus.agent.check', '取消审核 <br/>代理信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function aagentblack()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$aagentblack = intval($_GPC['aagentblack']);
		$members = pdo_fetchall('SELECT id,openid,nickname,realname,mobile FROM ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($members as $member) {
			if ($member['aagentblack'] === $aagentblack) {
				continue;
			}

			if ($aagentblack == 1) {
				pdo_update('ewei_shop_member', array('isaagent' => 1, 'aagentstatus' => 0, 'aagentblack' => 1), array('id' => $member['id']));
				plog('abonus.agent.aagentblack', '设置黑名单 <br/>区域代理信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
			else {
				pdo_update('ewei_shop_member', array('isaagent' => 1, 'aagentstatus' => 1, 'aagentblack' => 0), array('id' => $member['id']));
				plog('abonus.agent.aagentblack', '取消黑名单 <br/>区域代理信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
		}

		show_json(1, array('url' => referer()));
	}
}

?>
