<?php
class Bind_EweiShopV2Model
{
	/**
     * @param array $member
     * @return bool
     */
	public function iswxm($member = array())
	{
		if (empty($member) || !is_array($member)) {
			return true;
		}

		if (strexists($member['openid'], 'sns_wx_') || strexists($member['openid'], 'sns_qq_') || strexists($member['openid'], 'sns_wa_') || strexists($member['openid'], 'wap_user_')) {
			return false;
		}

		return true;
	}

	/**
     * @param int $mid
     * @param array $arr
     */
	public function update($mid = 0, $arr = array())
	{
		global $_W;
		if (empty($mid) || empty($arr) || !is_array($arr)) {
			return NULL;
		}

		pdo_update('ewei_shop_member', $arr, array('id' => $mid, 'uniacid' => $_W['uniacid']));
	}

	/**
     * @param array $a
     * @param array $b
     * @return array
     */
	public function merge($a = array(), $b = array())
	{
		global $_W;
		if (empty($a) || empty($b) || $a['id'] == $b['id']) {
			return error(0, 'params error');
		}

		$createtime = $b['createtime'] < $a['createtime'] ? $b['createtime'] : $a['createtime'];
		$childtime = $b['childtime'] < $a['childtime'] ? $b['childtime'] : $a['childtime'];
		$comparelevel = m('member')->compareLevel(array($a['level'], $b['level']));
		$level = $comparelevel ? $b['level'] : $a['level'];
		$isblack = !empty($a['isblack']) || !empty($b['isblack']) ? 1 : 0;
		$openid_qq = !empty($b['openid_qq']) && empty($a['openid_qq']) ? $b['openid_qq'] : $a['openid_qq'];
		$openid_wx = !empty($b['openid_wx']) && empty($a['openid_wx']) ? $b['openid_wx'] : $a['openid_wx'];
		$openid_wa = !empty($b['openid_wa']) && empty($a['openid_wa']) ? $b['openid_wa'] : $a['openid_wa'];
		if (!empty($a['isagent']) && empty($b['isagent'])) {
			$isagent = 1;
			$agentid = $a['agentid'];
			$status = !empty($a['status']) ? 1 : 0;
			$agenttime = $a['agenttime'];
			$agentlevel = $a['agentlevel'];
			$agentblack = $a['agentblack'];
			$fixagentid = $a['fixagentid'];
		}
		else {
			if (!empty($b['isagent']) && empty($a['isagent'])) {
				$isagent = 1;
				$agentid = $b['agentid'];
				$status = !empty($b['status']) ? 1 : 0;
				$agenttime = $b['agenttime'];
				$agentlevel = $b['agentlevel'];
				$agentblack = $b['agentblack'];
				$fixagentid = $b['fixagentid'];
			}
			else {
				if (!empty($b['isagent']) && !empty($a['isagent'])) {
					$compare = p('commission')->compareLevel(array($a['agentlevel'], $b['agentlevel']));
					$isagent = 1;

					if ($compare) {
						$agentid = $b['agentid'];
						if (empty($b['agentid']) && !empty($a['agentid'])) {
							$agentid = $a['agentid'];
						}

						$status = !empty($b['status']) ? 1 : 0;
						$agentblack = !empty($b['agentblack']) ? 1 : 0;
						$fixagentid = !empty($b['fixagentid']) ? 1 : 0;
					}
					else {
						$agentid = $a['agentid'];
						if (empty($a['agentid']) && !empty($b['agentid'])) {
							$agentid = $b['agentid'];
						}

						$status = !empty($a['status']) ? 1 : 0;
						$agentblack = !empty($a['agentblack']) ? 1 : 0;
						$fixagentid = !empty($a['fixagentid']) ? 1 : 0;
					}

					$agenttime = $compare ? $b['agenttime'] : $a['agenttime'];
					$agentlevel = $compare ? $b['agentlevel'] : $a['agentlevel'];
				}
				else {
					if (empty($b['isagent']) && empty($a['isagent'])) {
						if (!empty($a['agentid']) && !empty($b['agentid'])) {
							$agentid = $a['agentid'];
						}
						else {
							if (empty($a['agentid']) && !empty($b['agentid'])) {
								$agentid = $b['agentid'];
							}
							else {
								if (!empty($a['agentid']) && empty($b['agentid'])) {
									$agentid = $a['agentid'];
								}
							}
						}

						if (!empty($a['inviter']) && !empty($b['inviter'])) {
							$inviter = $a['inviter'];
						}
						else {
							if (empty($a['inviter']) && !empty($b['inviter'])) {
								$inviter = $b['inviter'];
							}
							else {
								if (!empty($a['inviter']) && empty($b['inviter'])) {
									$inviter = $a['inviter'];
								}
							}
						}
					}
				}
			}
		}

		if (!empty($a['isauthor']) && empty($b['isauthor'])) {
			$isauthor = $a['isauthor'];
			$authorstatus = !empty($a['authorstatus']) ? 1 : 0;
			$authortime = $a['authortime'];
			$authorlevel = $a['authorlevel'];
			$authorblack = $a['authorblack'];
		}
		else {
			if (!empty($b['isauthor']) && empty($a['isauthor'])) {
				$isauthor = $b['isauthor'];
				$authorstatus = !empty($b['authorstatus']) ? 1 : 0;
				$authortime = $b['authortime'];
				$authorlevel = $b['authorlevel'];
				$authorblack = $b['authorblack'];
			}
			else {
				if (!empty($b['isauthor']) && !empty($a['isauthor'])) {
					return error(0, '此手机号已绑定另一用户(a1)<br>请联系管理员');
				}
			}
		}

		if (!empty($a['ispartner']) && empty($b['ispartner'])) {
			$ispartner = 1;
			$partnerstatus = !empty($a['partnerstatus']) ? 1 : 0;
			$partnertime = $a['partnertime'];
			$partnerlevel = $a['partnerlevel'];
			$partnerblack = $a['partnerblack'];
		}
		else {
			if (!empty($b['ispartner']) && empty($a['ispartner'])) {
				$ispartner = 1;
				$partnerstatus = !empty($b['partnerstatus']) ? 1 : 0;
				$partnertime = $b['partnertime'];
				$partnerlevel = $b['partnerlevel'];
				$partnerblack = $b['partnerblack'];
			}
			else {
				if (!empty($b['ispartner']) && !empty($a['ispartner'])) {
					return error(0, '此手机号已绑定另一用户(p)<br>请联系管理员');
				}
			}
		}

		if (!empty($a['isaagent']) && empty($b['isaagent'])) {
			$isaagent = $a['isaagent'];
			$aagentstatus = !empty($a['aagentstatus']) ? 1 : 0;
			$aagenttime = $a['aagenttime'];
			$aagentlevel = $a['aagentlevel'];
			$aagenttype = $a['aagenttype'];
			$aagentprovinces = $a['aagentprovinces'];
			$aagentcitys = $a['aagentcitys'];
			$aagentareas = $a['aagentareas'];
		}
		else {
			if (!empty($b['isaagent']) && empty($a['isaagent'])) {
				$isaagent = $b['isaagent'];
				$aagentstatus = !empty($b['aagentstatus']) ? 1 : 0;
				$aagenttime = $b['aagenttime'];
				$aagentlevel = $b['aagentlevel'];
				$aagenttype = $b['aagenttype'];
				$aagentprovinces = $b['aagentprovinces'];
				$aagentcitys = $b['aagentcitys'];
				$aagentareas = $b['aagentareas'];
			}
			else {
				if (!empty($b['isaagent']) && !empty($a['isaagent'])) {
					return error(0, '此手机号已绑定另一用户(a2)<br>请联系管理员');
				}
			}
		}

		$arr = array();

		if (isset($createtime)) {
			$arr['createtime'] = $createtime;
		}

		if (isset($childtime)) {
			$arr['childtime'] = $childtime;
		}

		if (isset($level)) {
			$arr['level'] = $level;
		}

		if (isset($groupid)) {
			$arr['groupid'] = $groupid;
		}

		if (isset($isblack)) {
			$arr['isblack'] = $isblack;
		}

		if (isset($openid_qq)) {
			$arr['openid_qq'] = $openid_qq;
		}

		if (isset($openid_wx)) {
			$arr['openid_wx'] = $openid_wx;
		}

		if (isset($openid_wa)) {
			$arr['openid_wa'] = $openid_wa;
		}

		if (isset($status)) {
			$arr['status'] = $status;
		}

		if (isset($isagent)) {
			$arr['isagent'] = $isagent;
		}

		if (isset($agentid)) {
			$arr['agentid'] = $agentid;
		}

		if (isset($agenttime)) {
			$arr['agenttime'] = $agenttime;
		}

		if (isset($agentlevel)) {
			$arr['agentlevel'] = $agentlevel;
		}

		if (isset($agentblack)) {
			$arr['agentblack'] = $agentblack;
		}

		if (isset($fixagentid)) {
			$arr['fixagentid'] = $fixagentid;
		}

		if (isset($isauthor)) {
			$arr['isauthor'] = $isauthor;
		}

		if (isset($authorstatus)) {
			$arr['authorstatus'] = $authorstatus;
		}

		if (isset($authortime)) {
			$arr['authortime'] = $authortime;
		}

		if (isset($authorlevel)) {
			$arr['authorlevel'] = $authorlevel;
		}

		if (isset($authorblack)) {
			$arr['authorblack'] = $authorblack;
		}

		if (isset($ispartner)) {
			$arr['ispartner'] = $ispartner;
		}

		if (isset($partnerstatus)) {
			$arr['partnerstatus'] = $partnerstatus;
		}

		if (isset($partnertime)) {
			$arr['partnertime'] = $partnertime;
		}

		if (isset($partnerlevel)) {
			$arr['partnerlevel'] = $partnerlevel;
		}

		if (isset($partnerblack)) {
			$arr['partnerblack'] = $partnerblack;
		}

		if (isset($isaagent)) {
			$arr['isaagent'] = $isaagent;
		}

		if (isset($aagentstatus)) {
			$arr['aagentstatus'] = $aagentstatus;
		}

		if (isset($aagenttime)) {
			$arr['aagenttime'] = $aagenttime;
		}

		if (isset($aagentlevel)) {
			$arr['aagentlevel'] = $aagentlevel;
		}

		if (isset($aagenttype)) {
			$arr['aagenttype'] = $aagenttype;
		}

		if (isset($aagentprovinces)) {
			$arr['aagentprovinces'] = $aagentprovinces;
		}

		if (isset($aagentcitys)) {
			$arr['aagentcitys'] = $aagentcitys;
		}

		if (isset($aagentareas)) {
			$arr['aagentareas'] = $aagentareas;
		}

		if (isset($inviter)) {
			$arr['inviter'] = $inviter;
		}

		if (!empty($arr) && is_array($arr)) {
			pdo_update('ewei_shop_member', $arr, array('id' => $b['id']));
		}

		pdo_update('ewei_shop_commission_apply', array('mid' => $b['id']), array('uniacid' => $_W['uniacid'], 'mid' => $a['id']));
		pdo_update('ewei_shop_order', array('agentid' => $b['id']), array('agentid' => $a['id']));
		pdo_update('ewei_shop_member', array('agentid' => $b['id']), array('agentid' => $a['id']));
		$mergeinfo = ' 合并前用户: ' . $a['nickname'] . '(' . $a['id'] . ') 合并后用户: ' . $b['nickname'] . '(' . $b['id'] . ')';

		if (0 < $a['credit1']) {
			m('member')->setCredit($b['openid'], 'credit1', abs($a['credit1']), '全网通会员数据合并增加积分 +' . $a['credit1'] . $mergeinfo);
		}

		if (0 < $a['credit2']) {
			m('member')->setCredit($b['openid'], 'credit2', abs($a['credit2']), '全网通会员数据合并增加余额 +' . $a['credit2'] . $mergeinfo);
		}

		pdo_delete('ewei_shop_member', array('id' => $a['id'], 'uniacid' => $_W['uniacid']));

		if (method_exists(m('member'), 'memberRadisCountDelete')) {
			m('member')->memberRadisCountDelete();
		}

		$tables = pdo_fetchall('SHOW TABLES like \'%_ewei_shop_%\'');

		foreach ($tables as $k => $v) {
			$v = array_values($v);
			$tablename = str_replace($_W['config']['db']['tablepre'], '', $v[0]);
			if (pdo_fieldexists($tablename, 'openid') && pdo_fieldexists($tablename, 'uniacid')) {
				pdo_update($tablename, array('openid' => $b['openid']), array('uniacid' => $_W['uniacid'], 'openid' => $a['openid']));
			}

			if (pdo_fieldexists($tablename, 'openid') && pdo_fieldexists($tablename, 'acid')) {
				pdo_update($tablename, array('openid' => $b['openid']), array('acid' => $_W['acid'], 'openid' => $a['openid']));
			}

			if (pdo_fieldexists($tablename, 'mid') && pdo_fieldexists($tablename, 'uniacid')) {
				pdo_update($tablename, array('mid' => $b['id']), array('uniacid' => $_W['uniacid'], 'mid' => $a['id']));
			}
		}

		$c = m('member')->getMember($b['openid']);
		pdo_insert('ewei_shop_member_mergelog', array('uniacid' => $_W['uniacid'], 'mergetime' => time(), 'openid_a' => $a['openid'], 'openid_b' => $b['openid'], 'mid_a' => $a['id'], 'mid_b' => $b['id'], 'detail_a' => iserializer($a), 'detail_b' => iserializer($b), 'detail_c' => iserializer($c)));
		return error(1);
	}

	/**
     * 绑定送积分
     * @param array $member
     */
	public function sendCredit($member = array())
	{
		if (empty($member)) {
			return NULL;
		}

		$data = m('common')->getPluginset('sale');
		if (!empty($data['bindmobile']) && 0 < intval($data['bindmobilecredit'])) {
			m('member')->setCredit($member['openid'], 'credit1', abs($data['bindmobilecredit']), '绑定手机号送积分 +' . $data['bindmobilecredit']);
		}
	}

	/**
     * 数据迁移
     * @param array $a
     * @param array $b
     * @return array
     */
	public function mergeforuniacid($a = array(), $b = array())
	{
		global $_W;
		if (empty($a) || empty($b) || $a['id'] == $b['id']) {
			return error(0, 'params error');
		}

		if (!empty($b['mobileverify'])) {
			return error(0, 'params error');
		}

		$createtime = $b['createtime'] < $a['createtime'] ? $b['createtime'] : $a['createtime'];
		$childtime = $b['childtime'] < $a['childtime'] ? $b['childtime'] : $a['childtime'];
		$comparelevel = m('member')->compareLevel(array($a['level'], $b['level']));
		$level = $comparelevel ? $b['level'] : $a['level'];
		$isblack = !empty($a['isblack']) || !empty($b['isblack']) ? 1 : 0;
		$openid_qq = !empty($b['openid_qq']) && empty($a['openid_qq']) ? $b['openid_qq'] : $a['openid_qq'];
		$openid_wx = !empty($b['openid_wx']) && empty($a['openid_wx']) ? $b['openid_wx'] : $a['openid_wx'];
		$openid_wa = !empty($b['openid_wa']) && empty($a['openid_wa']) ? $b['openid_wa'] : $a['openid_wa'];
		if (!empty($a['isagent']) && empty($b['isagent'])) {
			$isagent = 1;
			$agentid = $a['agentid'];
			$status = !empty($a['status']) ? 1 : 0;
			$agenttime = $a['agenttime'];
			$agentlevel = $a['agentlevel'];
			$agentblack = $a['agentblack'];
			$fixagentid = $a['fixagentid'];
		}
		else {
			if (!empty($b['isagent']) && empty($a['isagent'])) {
				$isagent = 1;
				$agentid = $b['agentid'];
				$status = !empty($b['status']) ? 1 : 0;
				$agenttime = $b['agenttime'];
				$agentlevel = $b['agentlevel'];
				$agentblack = $b['agentblack'];
				$fixagentid = $b['fixagentid'];
			}
			else {
				if (!empty($b['isagent']) && !empty($a['isagent'])) {
					$compare = p('commission')->compareLevel(array($a['agentlevel'], $b['agentlevel']));
					$isagent = 1;

					if ($compare) {
						$agentid = $b['agentid'];
						if (empty($b['agentid']) && !empty($a['agentid'])) {
							$agentid = $a['agentid'];
						}

						$status = !empty($b['status']) ? 1 : 0;
						$agentblack = !empty($b['agentblack']) ? 1 : 0;
						$fixagentid = !empty($b['fixagentid']) ? 1 : 0;
					}
					else {
						$agentid = $a['agentid'];
						if ($a['agentid'] && !empty($b['agentid'])) {
							$agentid = $b['agentid'];
						}

						$status = !empty($a['status']) ? 1 : 0;
						$agentblack = !empty($a['agentblack']) ? 1 : 0;
						$fixagentid = !empty($a['fixagentid']) ? 1 : 0;
					}

					$agenttime = $compare ? $b['agenttime'] : $a['agenttime'];
					$agentlevel = $compare ? $b['agentlevel'] : $a['agentlevel'];
				}
			}
		}

		$arr = array();
		$arr['ishb'] = 1;

		if (isset($createtime)) {
			$arr['createtime'] = $createtime;
		}

		if (isset($childtime)) {
			$arr['childtime'] = $childtime;
		}

		if (isset($level)) {
			$arr['level'] = $level;
		}

		if (isset($groupid)) {
			$arr['groupid'] = $groupid;
		}

		if (isset($isblack)) {
			$arr['isblack'] = $isblack;
		}

		if (isset($openid_qq)) {
			$arr['openid_qq'] = $openid_qq;
		}

		if (isset($openid_wx)) {
			$arr['openid_wx'] = $openid_wx;
		}

		if (isset($openid_wa)) {
			$arr['openid_wa'] = $openid_wa;
		}

		if (isset($status)) {
			$arr['status'] = $status;
		}

		if (isset($isagent)) {
			$arr['isagent'] = $isagent;
		}

		if (isset($agentid)) {
			$arr['agentid'] = $agentid;
		}

		if (isset($agenttime)) {
			$arr['agenttime'] = $agenttime;
		}

		if (isset($agentlevel)) {
			$arr['agentlevel'] = $agentlevel;
		}

		if (isset($agentblack)) {
			$arr['agentblack'] = $agentblack;
		}

		if (isset($fixagentid)) {
			$arr['fixagentid'] = $fixagentid;
		}

		if (!empty($arr) && is_array($arr)) {
			pdo_update('ewei_shop_member', $arr, array('id' => $b['id']));
		}

		pdo_update('ewei_shop_commission_apply', array('mid' => $b['id']), array('mid' => $a['id']));
		pdo_update('ewei_shop_order', array('agentid' => $b['id']), array('agentid' => $a['id']));
		pdo_update('ewei_shop_member', array('agentid' => $b['id']), array('agentid' => $a['id']));
		$mergeinfo = ' 合并前用户: ' . $a['nickname'] . '(' . $a['id'] . ') 合并后用户: ' . $b['nickname'] . '(' . $b['id'] . ')';

		if (0 < $a['credit1']) {
			m('member')->setCredit($b['openid'], 'credit1', abs($a['credit1']), '数据迁移会员数据合并增加积分 +' . $a['credit1'] . $mergeinfo);
		}

		if (0 < $a['credit2']) {
			m('member')->setCredit($b['openid'], 'credit2', abs($a['credit2']), '数据迁移会员数据合并增加余额 +' . $a['credit2'] . $mergeinfo);
		}

		$tables = pdo_fetchall('SHOW TABLES like \'%_ewei_shop_%\'');

		foreach ($tables as $k => $v) {
			$v = array_values($v);
			$tablename = str_replace($_W['config']['db']['tablepre'], '', $v[0]);
			if (pdo_fieldexists($tablename, 'openid') && pdo_fieldexists($tablename, 'uniacid')) {
				if ($tablename != 'ewei_shop_member') {
					pdo_update($tablename, array('openid' => $b['openid']), array('uniacid' => $_W['uniacid'], 'openid' => $a['openid']));
				}
			}

			if (pdo_fieldexists($tablename, 'openid') && pdo_fieldexists($tablename, 'acid')) {
				pdo_update($tablename, array('openid' => $b['openid']), array('acid' => $_W['acid'], 'openid' => $a['openid']));
			}

			if (pdo_fieldexists($tablename, 'mid') && pdo_fieldexists($tablename, 'uniacid')) {
				pdo_update($tablename, array('mid' => $b['id']), array('uniacid' => $_W['uniacid'], 'mid' => $a['id']));
			}
		}

		$c = m('member')->getMember($b['openid']);
		pdo_insert('ewei_shop_member_mergelog', array('uniacid' => $_W['uniacid'], 'fromuniacid' => $_W['uniacid'], 'mergetime' => time(), 'openid_a' => $a['openid'], 'openid_b' => $b['openid'], 'mid_a' => $a['id'], 'mid_b' => $b['id'], 'detail_a' => iserializer($a), 'detail_b' => iserializer($b), 'detail_c' => iserializer($c)));
		return error(1);
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
