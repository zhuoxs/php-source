<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class List_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and dm.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['mid'])) {
			$condition .= ' and dm.id=:mid';
			$params[':mid'] = intval($_GPC['mid']);
		}

		if (!empty($_GPC['realname'])) {
			$realname = trim($_GPC['realname']);
			$condition .= ' and ( dm.realname like :realname or dm.nickname like :realname or dm.mobile like :realname or dm.id like :realname)';
			$params[':realname'] = '%' . $realname . '%';
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
			$condition .= ' and level=' . intval($_GPC['level']);
		}

		$join = '';

		if ($_GPC['groupid'] != '') {
			$condition .= ' and find_in_set(' . intval($_GPC['groupid']) . ',groupid) ';
			$join .= ' left join (select * from ' . tablename('ewei_shop_member_group_log') . ' order by log_id desc limit 1 ) glog on (glog.openid = dm.openid) and glog.group_id = ' . (int) $_GPC['groupid'];
		}

		if ($_GPC['followed'] != '') {
			if ($_GPC['followed'] == 2) {
				$condition .= ' and f.follow=0 and f.unfollowtime<>0';
			}
			else {
				if ($_GPC["followed"] == 1) {
                    $condition .= " and f.follow=" . intval($_GPC["followed"]);
                } else {
                    $condition .= " and f.follow=" . intval($_GPC["followed"]) . " and f.unfollowtime=0 ";
                }
			}

			$join .= ' join ' . tablename('mc_mapping_fans') . ' f on f.openid=dm.openid';
		}

		if ($_GPC['isblack'] != '') {
			$condition .= ' and dm.isblack=' . intval($_GPC['isblack']);
		}

		$sql = 'select * ,dm.openid from ' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . '  ORDER BY dm.id DESC,dm.createtime DESC ');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}
		else {
			ini_set('memory_limit', '-1');
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
			$res_fans = pdo_fetchall('select fanid,openid,follow as followed, unfollowtime from ' . tablename('mc_mapping_fans') . ' where openid in (\'' . implode('\',\'', $list_fans) . '\') and uniacid = :uniacid', array('uniacid' => $_W['uniacid']), 'openid');
		}

		$shop = m('common')->getSysset('shop');

		foreach ($list as &$row) {
			if (isset($row['groupid'])) {
				$groupid = explode(',', $row['groupid']);
			}

			$row['groupname'] = '';

			if (is_array($groupid)) {
				foreach ($groupid as $key => $value) {
					$row['groupname'] .= $res_group[$value]['groupname'] . ',';
				}

				$row['groupname'] = substr($row['groupname'], 0, -1);
			}

			$row['levelname'] = isset($res_level[$row['level']]) ? $res_level[$row['level']]['levelname'] : '';
			$row['agentnickname'] = isset($res_agent[$row['agentid']]) ? $res_agent[$row['agentid']]['agentnickname'] : '';
			$row['agentnickname'] = str_replace('"', '', $row['agentnickname']);
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

		if ($_GPC['export'] == '1') {
			plog('member.list', '导出会员数据');

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['groupname'] = empty($row['groupname']) ? '无分组' : $row['groupname'];
				$row['levelname'] = empty($row['levelname']) ? '普通会员' : $row['levelname'];
				$row['realname'] = str_replace('=', '', $row['realname']);
				$row['nickname'] = str_replace('=', '', $row['nickname']);
				$row['remark'] = trim($row['content']);
			}

			unset($row);
			m('excel')->export($list, array(
				'title'   => '会员数据-' . date('Y-m-d-H-i', time()),
				'columns' => array(
					array('title' => '昵称', 'field' => 'nickname', 'width' => 12),
					array('title' => '姓名', 'field' => 'realname', 'width' => 12),
					array('title' => '手机号', 'field' => 'mobile', 'width' => 12),
					array('title' => 'openid', 'field' => 'openid', 'width' => 24),
					array('title' => '会员等级', 'field' => 'levelname', 'width' => 12),
					array('title' => '会员分组', 'field' => 'groupname', 'width' => 12),
					array('title' => '注册时间', 'field' => 'createtime', 'width' => 12),
					array('title' => '积分', 'field' => 'credit1', 'width' => 12),
					array('title' => '余额', 'field' => 'credit2', 'width' => 12),
					array('title' => '成交订单数', 'field' => 'ordercount', 'width' => 12),
					array('title' => '成交总金额', 'field' => 'ordermoney', 'width' => 12),
					array('title' => '备注', 'field' => 'remark', 'width' => 24)
				)
			));
		}

		$open_redis = function_exists('redis') && !is_error(redis());
		if ($join == '' && $condition == ' and dm.uniacid=:uniacid') {
			if ($open_redis) {
				$redis_key = 'ewei_' . $_W['uniacid'] . '_member_list';
				$total = m('member')->memberRadisCount($redis_key);

				if (!$total) {
					$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . ' '), $params);
					m('member')->memberRadisCount($redis_key, $total);
				}
			}
			else {
				$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . ' '), $params);
			}
		}
		else {
			$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_member') . (' dm ' . $join . ' where 1 ' . $condition . ' '), $params);
		}

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
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$shop = $_W['shopset']['shop'];
		$hascommission = false;
		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();
			$hascommission = !empty($plugin_com_set['level']);
		}

		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !empty($plugin_globonus_set['open']);
		}

		$plugin_author = p('author');

		if ($plugin_author) {
			$plugin_author_set = $plugin_author->getSet();
			$hasauthor = !empty($plugin_author_set['open']);
		}

		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !empty($plugin_abonus_set['open']);
		}

		$id = intval($_GPC['id']);

		if ($hascommission) {
			$agentlevels = $plugin_com->getLevels();
		}

		if ($hasglobonus) {
			$partnerlevels = $plugin_globonus->getLevels();
		}

		if ($hasabonus) {
			$aagentlevels = $plugin_abonus->getLevels();
		}

		$member = m('member')->getMember($id);

		if (false == $member) {
			include $this->template('member/list/notFound');
			exit();
		}

		if ($hascommission) {
			$member = $plugin_com->getInfo($id, array('total', 'pay'));
		}

		$member['self_ordercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
		$member['self_ordermoney'] = pdo_fetchcolumn('select sum(price) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));

		if (!empty($member['agentid'])) {
			$parentagent = m('member')->getMember($member['agentid']);
		}

		$order = pdo_fetch('select finishtime from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status>=1 Limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
		$member['last_ordertime'] = $order['finishtime'];

		if ($hasglobonus) {
			$bonus = $plugin_globonus->getBonus($member['openid'], array('ok'));
			$member['bonusmoney'] = $bonus['ok'];
		}

		if ($hasabonus) {
			$bonus = $plugin_abonus->getBonus($member['openid'], array('ok', 'ok1', 'ok2', 'ok3'));
			$member['abonus_ok'] = $bonus['ok'];
			$member['abonus_ok1'] = $bonus['ok1'];
			$member['abonus_ok2'] = $bonus['ok2'];
			$member['abonus_ok3'] = $bonus['ok3'];
			$member['aagentprovinces'] = iunserializer($member['aagentprovinces']);
			$member['aagentcitys'] = iunserializer($member['aagentcitys']);
			$member['aagentareas'] = iunserializer($member['aagentareas']);
		}

		$followed = m('user')->followed($member['openid']);
		$plugin_sns = p('sns');

		if ($plugin_sns) {
			$plugin_sns_set = $plugin_sns->getSet();
			$sns_member = pdo_fetch('select * from ' . tablename('ewei_shop_sns_member') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $member['openid'], ':uniacid' => $_W['uniacid']));
			$sns_member['postcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid=0 and deleted = 0 and checked=1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
			$sns_member['replycount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid>0 and deleted = 0 and checked=1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
			$hassns = !empty($sns_member);

			if ($hassns) {
				$snslevels = $plugin_sns->getLevels();
			}
		}

		$diyform_flag = 0;
		$diyform_flag_commission = 0;
		$diyform_flag_globonus = 0;
		$diyform_flag_abonus = 0;
		$diyform_flag_dividend = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			if (!empty($member['diymemberdata'])) {
				$diyform_flag = 1;
				$fields = iunserializer($member['diymemberfields']);
			}

			if (!empty($member['diycommissiondata'])) {
				$diyform_flag_commission = 1;
				$cfields = iunserializer($member['diycommissionfields']);
			}

			if (!empty($member['diyheadsfields'])) {
				$diyform_flag_dividend = 1;
				$dfields = iunserializer($member['diyheadsfields']);
			}

			if (!empty($member['diyglobonusdata'])) {
				$diyform_flag_globonus = 1;
				$gfields = iunserializer($member['diyglobonusfields']);
			}

			if (!empty($member['diyaagentdata'])) {
				$diyform_flag_abonus = 1;
				$aafields = iunserializer($member['diyaagentfields']);
			}
		}

		$groups = m('member')->getGroups();
		$levels = m('member')->getLevels();
		$openbind = false;
		if (empty($_W['shopset']['app']['isclose']) && !empty($_W['shopset']['app']['openbind']) || !empty($_W['shopset']['wap']['open'])) {
			$openbind = true;
		}

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if ($data['maxcredit'] < 0) {
				$data['maxcredit'] = 0;
			}

			if ($openbind) {
				if (!empty($data['mobileverify'])) {
					if (empty($data['mobile'])) {
						show_json(0, '绑定手机号请先填写用户手机号!');
					}

					$m = pdo_fetch('select id from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and mobileverify=1 and uniacid=:uniaicd limit 1 ', array(':mobile' => $data['mobile'], ':uniaicd' => $_W['uniacid']));
					if (!empty($m) && $m['id'] != $id) {
						show_json(0, '此手机号已绑定其他用户!(uid:' . $m['id'] . ')');
					}
				}

				$data['pwd'] = trim($data['pwd']);

				if (!empty($data['pwd'])) {
					$salt = $member['salt'];

					if (empty($salt)) {
						$salt = m('account')->getSalt();
					}

					$data['pwd'] = md5($data['pwd'] . $salt);
					$data['salt'] = $salt;
				}
				else {
					unset($data['pwd']);
					unset($data['salt']);
				}
			}

			if (is_array($_GPC['data']['groupid'])) {
				$data['groupid'] = implode(',', $_GPC['data']['groupid']);
			}

			if (empty($data['groupid'])) {
				$data['groupid'] = '';
			}

			pdo_update('ewei_shop_member', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			$member = array_merge($member, $data);
			plog('member.list.edit', '修改会员资料  ID: ' . $member['id'] . ' <br/> 会员信息:  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);

			if ($hascommission) {
				if (cv('commission.agent.edit')) {
					$adata = is_array($_GPC['adata']) ? $_GPC['adata'] : array();

					if (!empty($adata)) {
						if ($adata['agentid'] != $member['agentid']) {
							if (p('commission')) {
								p('commission')->delRelation($member['id']);
								$mem = p('commission')->saveRelation($member['id'], $adata['agentid']);

								if (is_array($mem)) {
									show_json(-1, '保存错误！' . '<br/>请修改<a style=\'color: #259fdc;\' target=\'_blank\' href=\'' . webUrl('member/list/detail', array('id' => $mem['id'])) . '\'>会员(' . $mem['nickname'] . ')</a>的上级分销商!');
								}
							}

							if (cv('commission.agent.changeagent')) {
								plog('commission.agent.changeagent', '修改上级分销商 <br/> 会员信息:  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile'] . ' <br/>上级ID: ' . $member['agentid'] . ' -> 新上级ID: ' . $adata['agentid'] . '; <br/> 固定上级: ' . ($member['fixagentid'] ? '是' : '否') . ' -> ' . ($adata['fixagentid'] ? '是' : '否'));
							}
							else {
								$adata['agentid'] = $member['agentid'];
							}
						}

						$agent_flag = 0;
						$cmember_plugin = p('cmember');

						if ($cmember_plugin) {
							$adata['cmemberagent'] = $adata['cmemberagent'];
							$adata['agentnotupgrade'] = 1;
							if ($member['level'] == 0 && 0 < intval($data['level'])) {
								$agent_flag = 1;
							}

							if (0 < intval($data['level'])) {
								$adata['isagent'] = 1;
								$adata['status'] = 1;

								if (!empty($adata['agentid'])) {
									$cmemberuid = $cmember_plugin->getCmemberuid($member['id']);

									if (0 < $cmemberuid) {
										$adata['cmemberuid'] = $cmemberuid;
									}
								}
							}
							else {
								$adata['isagent'] = 0;
								$adata['status'] = 0;
							}
						}
						else {
							if (empty($_GPC['oldstatus']) && $adata['status'] == 1) {
								$agent_flag = 1;
							}
						}

						if (!empty($agent_flag)) {
							$time = time();
							$adata['agenttime'] = time();
							$plugin_com->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);
							plog('commission.agent.check', '审核分销商 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
						}

						plog('commission.agent.edit', '修改分销商 <br/>分销商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
						pdo_update('ewei_shop_member', $adata, array('id' => $id, 'uniacid' => $_W['uniacid']));

						if ($adata['agentid'] != $member['agentid']) {
							if (p('dividend')) {
								$dividend = pdo_fetch('select id,isheads,headsid,headsstatus from ' . tablename('ewei_shop_member') . ' where id = :id', array(':id' => $adata['agentid']));
								$dividend_init = pdo_fetch('select * from ' . tablename('ewei_shop_dividend_init') . ' where headsid = :headsid', array(':headsid' => $adata['agentid']));
								if (!empty($dividend['isheads']) && !empty($dividend['headsstatus']) && !empty($dividend_init['status'])) {
									pdo_update('ewei_shop_member', array('headsid' => $adata['agentid']), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
									$data = pdo_fetchall('select id from ' . tablename('ewei_shop_commission_relation') . ' where pid = :pid', array(':pid' => $member['id']));

									if (!empty($data)) {
										$ids = array();

										foreach ($data as $k => $v) {
											$ids[] = $v['id'];
										}

										pdo_update('ewei_shop_member', array('headsid' => $adata['agentid']), array('id' => $ids));
									}
								}
								else {
									if (empty($dividend['isheads']) && !empty($dividend['headsid'])) {
										pdo_update('ewei_shop_member', array('headsid' => $dividend['headsid']), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
										$data = pdo_fetchall('select id from ' . tablename('ewei_shop_commission_relation') . ' where pid = :pid', array(':pid' => $member['id']));

										if (!empty($data)) {
											$ids = array();

											foreach ($data as $k => $v) {
												$ids[] = $v['id'];
											}

											pdo_update('ewei_shop_member', array('headsid' => $dividend['headsid']), array('id' => $ids));
										}
									}
									else {
										pdo_update('ewei_shop_member', array('headsid' => 0), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
										$data = pdo_fetchall('select id from ' . tablename('ewei_shop_commission_relation') . ' where pid = :pid', array(':pid' => $member['id']));

										if (!empty($data)) {
											$ids = array();

											foreach ($data as $k => $v) {
												$ids[] = $v['id'];
											}

											pdo_update('ewei_shop_member', array('headsid' => 0), array('id' => $ids));
										}
									}
								}
							}
						}

						if (!empty($agent_flag)) {
							if (!empty($member['agentid'])) {
								$plugin_com->upgradeLevelByAgent($member['agentid']);

								if (p('globonus')) {
									p('globonus')->upgradeLevelByAgent($member['agentid']);
								}

								if (p('author')) {
									p('author')->upgradeLevelByAgent($member['agentid']);
								}
							}
						}
					}
				}
			}

			if ($hasglobonus) {
				if (cv('globonus.partner.check')) {
					$gdata = is_array($_GPC['gdata']) ? $_GPC['gdata'] : array();

					if (!empty($gdata)) {
						if (empty($_GPC['oldpartnerstatus']) && $gdata['partnerstatus'] == 1) {
							$time = time();
							$gdata['partnertime'] = time();
							$plugin_globonus->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'partnertime' => $time), TM_GLOBONUS_BECOME);
							plog('globonus.partner.check', '审核股东 <br/>股东信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
						}

						plog('globonus.partner.edit', '修改股东 <br/>股东信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
						pdo_update('ewei_shop_member', $gdata, array('id' => $id, 'uniacid' => $_W['uniacid']));
					}
				}
			}

			if ($hasauthor) {
				if (cv('author.partner.check')) {
					$author_data = is_array($_GPC['authordata']) ? $_GPC['authordata'] : array();

					if (!empty($author_data)) {
						if (empty($_GPC['oldauthorstatus']) && $author_data['authorstatus'] == 1) {
							$author_data['authortime'] = time();

							if (method_exists($plugin_author, 'changeAuthorId')) {
								$plugin_author->changeAuthorId($member['id']);
							}

							$plugin_author->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'authortime' => time()), TM_AUTHOR_BECOME);
							plog('author.partner.check', '审核创始人 <br/>创始人信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
						}

						if ($_GPC['oldauthorstatus'] == 1 && $author_data['authorstatus'] == 0) {
							if (method_exists($plugin_author, 'changeAuthorId')) {
								$plugin_author->changeAuthorId($member['id'], intval($member['authorid']));
							}
						}

						plog('author.partner.edit', '修改创始人 <br/>创始人信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
						pdo_update('ewei_shop_member', $author_data, array('id' => $id, 'uniacid' => $_W['uniacid']));
					}
				}
			}

			if ($hasabonus) {
				if (cv('abonus.agent.check')) {
					$aadata = is_array($_GPC['aadata']) ? $_GPC['aadata'] : array();

					if (!empty($aadata)) {
						$aagentprovinces = is_array($_GPC['aagentprovinces']) ? $_GPC['aagentprovinces'] : array();
						$aagentcitys = is_array($_GPC['aagentcitys']) ? $_GPC['aagentcitys'] : array();
						$aagentareas = is_array($_GPC['aagentareas']) ? $_GPC['aagentareas'] : array();
						$aadata['aagentprovinces'] = iserializer($aagentprovinces);
						$aadata['aagentcitys'] = iserializer($aagentcitys);
						$aadata['aagentareas'] = iserializer($aagentareas);

						if ($aadata['aagenttype'] == 2) {
							$aadata['aagentprovinces'] = iserializer(array());
						}
						else {
							if ($aadata['aagenttype'] == 3) {
								$aadata['aagentprovinces'] = iserializer(array());
								$aadata['aagentcitys'] = iserializer(array());
							}
						}

						$areas = array_merge($aagentprovinces, $aagentcitys, $aagentareas);
						if (empty($_GPC['oldaagentstatus']) && $aadata['aagentstatus'] == 1) {
							$time = time();
							$aadata['aagenttime'] = time();
							$plugin_abonus->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'aagenttype' => $aadata['aagenttype'], 'aagenttime' => $time, 'aagentareas' => implode('; ', $areas)), TM_ABONUS_BECOME);
							plog('abounus.agent.check', '审核代理商 <br/>代理商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
						}

						$log = '修改代理商 <br/>代理商信息:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'];

						if (is_array($_GPC['aagentprovinces'])) {
							$log .= '<br/>代理省份:' . implode(',', $_GPC['aagentprovinces']);
						}

						if (is_array($_GPC['aagentcitys'])) {
							$log .= '<br/>代理城市:' . implode(',', $_GPC['aagentcitys']);
						}

						if (is_array($_GPC['aagentareas'])) {
							$log .= '<br/>代理地区:' . implode(',', $_GPC['aagentareas']);
						}

						plog('abounus.agent.edit', $log);
						pdo_update('ewei_shop_member', $aadata, array('id' => $id, 'uniacid' => $_W['uniacid']));
					}
				}
			}

			com_run('wxcard::updateMemberCardByOpenid', $member['openid']);

			if ($hassns) {
				if (cv('sns.member.edit')) {
					$snsdata = is_array($_GPC['snsdata']) ? $_GPC['snsdata'] : array();

					if (!empty($snsdata)) {
						plog('sns.member.edit', '修改会员资料 ID: ' . $sns_member['id']);
						pdo_update('ewei_shop_sns_member', $snsdata, array('id' => $sns_member['id'], 'uniacid' => $_W['uniacid']));
					}
				}
			}

			show_json(1);
		}

		if ($hascommission) {
			$agentlevels = $plugin_com->getLevels();
		}

		if ($hasglobonus) {
			$partnerlevels = $plugin_globonus->getLevels();
		}

		if ($hasauthor) {
			$authorlevels = $plugin_author->getLevels();
		}

		if ($hasabonus) {
			$aagentlevels = $plugin_abonus->getLevels();
		}

		if (!empty($member['agentid'])) {
			$parentagent = m('member')->getMember($member['agentid']);
		}

		$order = pdo_fetch('select finishtime from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3 order by id desc limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
		$member['last_ordertime'] = $order['finishtime'];

		if ($hasglobonus) {
			$bonus = $plugin_globonus->getBonus($member['openid'], array('ok'));
			$member['bonusmoney'] = $bonus['ok'];
		}

		if ($hasauthor) {
			$bonus = $plugin_author->getBonus($member['openid'], array('ok'));
			$member['authormoney'] = $bonus['ok'];
		}

		if ($hasabonus) {
			$bonus = $plugin_abonus->getBonus($member['openid'], array('ok', 'ok1', 'ok2', 'ok3'));
			$member['abonus_ok'] = $bonus['ok'];
			$member['abonus_ok1'] = $bonus['ok1'];
			$member['abonus_ok2'] = $bonus['ok2'];
			$member['abonus_ok3'] = $bonus['ok3'];
			$member['aagentprovinces'] = iunserializer($member['aagentprovinces']);
			$member['aagentcitys'] = iunserializer($member['aagentcitys']);
			$member['aagentareas'] = iunserializer($member['aagentareas']);
		}

		$diyform_flag = 0;
		$diyform_flag_commission = 0;
		$diyform_flag_globonus = 0;
		$diyform_flag_abonus = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			if (!empty($member['diymemberdata'])) {
				$diyform_flag = 1;
				$fields = iunserializer($member['diymemberfields']);
			}

			if (!empty($member['diycommissiondata'])) {
				$diyform_flag_commission = 1;
				$cfields = iunserializer($member['diycommissionfields']);
			}

			if (!empty($member['diyglobonusdata'])) {
				$diyform_flag_globonus = 1;
				$gfields = iunserializer($member['diyglobonusfields']);
			}

			if (!empty($member['diyauthordata'])) {
				$diyform_flag_author = 1;
				$authorfields = iunserializer($member['diyauthordata']);
			}

			if (!empty($member['diyaagentdata'])) {
				$diyform_flag_abonus = 1;
				$aafields = iunserializer($member['diyaagentfields']);
			}
		}

		include $this->template();
	}

	public function view()
	{
		global $_W;
		global $_GPC;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$shop = $_W['shopset']['shop'];
		$hascommission = false;
		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();
			$hascommission = !empty($plugin_com_set['level']);
		}

		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !empty($plugin_globonus_set['open']);
		}

		$plugin_author = p('author');

		if ($plugin_author) {
			$plugin_author_set = $plugin_author->getSet();
			$hasauthor = !empty($plugin_author_set['open']);
		}

		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !empty($plugin_abonus_set['open']);
		}

		$id = intval($_GPC['id']);

		if ($hascommission) {
			$agentlevels = $plugin_com->getLevels();
		}

		if ($hasglobonus) {
			$partnerlevels = $plugin_globonus->getLevels();
		}

		if ($hasabonus) {
			$aagentlevels = $plugin_abonus->getLevels();
		}

		$member = m('member')->getMember($id);

		if ($hascommission) {
			$member = $plugin_com->getInfo($id, array('total', 'pay'));
		}

		$member['self_ordercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
		$member['self_ordermoney'] = pdo_fetchcolumn('select sum(price) from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));

		if (!empty($member['agentid'])) {
			$parentagent = m('member')->getMember($member['agentid']);
		}

		$order = pdo_fetch('select finishtime from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and openid=:openid and status>=1 Limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
		$member['last_ordertime'] = $order['finishtime'];

		if ($hasglobonus) {
			$bonus = $plugin_globonus->getBonus($member['openid'], array('ok'));
			$member['bonusmoney'] = $bonus['ok'];
		}

		if ($hasabonus) {
			$bonus = $plugin_abonus->getBonus($member['openid'], array('ok', 'ok1', 'ok2', 'ok3'));
			$member['abonus_ok'] = $bonus['ok'];
			$member['abonus_ok1'] = $bonus['ok1'];
			$member['abonus_ok2'] = $bonus['ok2'];
			$member['abonus_ok3'] = $bonus['ok3'];
			$member['aagentprovinces'] = iunserializer($member['aagentprovinces']);
			$member['aagentcitys'] = iunserializer($member['aagentcitys']);
			$member['aagentareas'] = iunserializer($member['aagentareas']);
		}

		$plugin_sns = p('sns');

		if ($plugin_sns) {
			$plugin_sns_set = $plugin_sns->getSet();
			$sns_member = pdo_fetch('select * from ' . tablename('ewei_shop_sns_member') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $member['openid'], ':uniacid' => $_W['uniacid']));
			$sns_member['postcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid=0 and deleted = 0 and checked=1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
			$sns_member['replycount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid>0 and deleted = 0 and checked=1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
			$hassns = !empty($sns_member);

			if ($hassns) {
				$snslevels = $plugin_sns->getLevels();
			}
		}

		$diyform_flag = 0;
		$diyform_flag_commission = 0;
		$diyform_flag_globonus = 0;
		$diyform_flag_abonus = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			if (!empty($member['diymemberdata'])) {
				$diyform_flag = 1;
				$fields = iunserializer($member['diymemberfields']);
			}

			if (!empty($member['diycommissiondata'])) {
				$diyform_flag_commission = 1;
				$cfields = iunserializer($member['diycommissionfields']);
			}

			if (!empty($member['diyglobonusdata'])) {
				$diyform_flag_globonus = 1;
				$gfields = iunserializer($member['diyglobonusfields']);
			}

			if (!empty($member['diyaagentdata'])) {
				$diyform_flag_abonus = 1;
				$aafields = iunserializer($member['diyaagentfields']);
			}
		}

		$groups = m('member')->getGroups();
		$levels = m('member')->getLevels();
		$openbind = false;
		if (empty($_W['shopset']['app']['isclose']) && !empty($_W['shopset']['app']['openbind']) || !empty($_W['shopset']['wap']['open'])) {
			$openbind = true;
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
			pdo_delete('ewei_shop_member', array('id' => $member['id']));
			plog('member.list.delete', '删除会员  ID: ' . $member['id'] . ' <br/>会员信息: ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);

			if (method_exists(m('member'), 'memberRadisCountDelete')) {
				m('member')->memberRadisCountDelete();
			}
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

	public function changelevel()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$toggle = trim($_GPC['toggle']);
			$ids = $_GPC['ids'];
			$levelid = $_GPC['level'];
			!strpos($levelid, ',') && ($levelid = intval($_GPC['level']));
			if (empty($ids) || !is_array($ids)) {
				show_json(0, '请选择要操作的会员');
			}

			if (empty($toggle)) {
				show_json(0, '请选择要操作的类型');
			}

			$ids = array_filter($ids);
			$idsstr = implode(',', $ids);
			$loginfo = '批量修改';

			if ($toggle == 'group') {
				if (!empty($levelid)) {
					$levelid_arr = explode(',', $levelid);

					if (!empty($levelid_arr)) {
						foreach ($levelid_arr as $id) {
							$group = pdo_fetch('select * from ' . tablename('ewei_shop_member_group') . ' where id = :id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

							if (empty($group)) {
								show_json(0, '此分组不存在');
							}
						}
					}
					else {
						show_json(0, '此分组不存在');
					}
				}
				else {
					$group = array('groupname' => '无分组');
				}

				$loginfo .= '用户分组 分组名称：' . $group['groupname'];
			}
			else {
				if (!empty($levelid)) {
					$level = pdo_fetch('select * from ' . tablename('ewei_shop_member_level') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $levelid, ':uniacid' => $_W['uniacid']));

					if (empty($level)) {
						show_json(0, '此等级不存在');
					}
				}
				else {
					$set = m('common')->getSysset();
					$level = array('levelname' => empty($set['shop']['levelname']) ? '普通等级' : $set['shop']['levelname']);
				}

				$arr = array('level' => $levelid);
				$loginfo .= '用户等级 等级名称：' . $level['levelname'];
			}

			$changeids = array();
			$members = pdo_fetchall('select id,openid,nickname,realname,mobile from ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $idsstr . ' ) AND uniacid=') . $_W['uniacid']);

			if (!empty($members)) {
				foreach ($members as $member) {
					if ($toggle == 'group') {
						m('member')->setGroups($member['id'], $levelid, '管理员设置批量分组');
					}
					else {
						pdo_update('ewei_shop_member', $arr, array('id' => $member['id']));
						$changeids[] = $member['id'];
					}
				}
			}

			if (!empty($changeids)) {
				$loginfo .= ' 用户id：' . implode(',', $changeids);
				plog('member.list.edit', $loginfo);
			}

			show_json(1);
		}

		include $this->template();
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
		$condition = ' and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND ( `nickname` LIKE :keyword or `realname` LIKE :keyword or `mobile` LIKE :keyword )';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,avatar,nickname,openid,realname,mobile FROM ' . tablename('ewei_shop_member') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}
}

?>
