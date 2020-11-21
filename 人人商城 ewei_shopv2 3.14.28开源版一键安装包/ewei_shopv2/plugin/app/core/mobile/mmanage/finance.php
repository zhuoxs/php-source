<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Finance_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		return app_json(array(
			'perm' => array('finance_recharge' => cv('finance.log.recharge'), 'finance_withdraw' => cv('finance.log.withdraw'), 'finance_credit2' => cv('finance.credit.credit2'))
		));
	}

	/**
     * 获取列表
     */
	public function get_list()
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		if ($type == 0 || $type == 1) {
			if ($type == 0 && !cv('finance.log.recharge') || $type == 1 && !cv('finance.log.withdraw')) {
				return app_error(AppError::$PermError, '您无操作权限');
			}

			$this->log($type);
		}
		else {
			if ($type == 2 || $type == 3) {
				if ($type == 2 && !cv('finance.credit.credit1') || $type == 3 && !cv('finance.credit.credit2')) {
					return app_error(AppError::$PermError, '您无操作权限');
				}

				$this->credit($type);
			}
		}
	}

	/**
     * 读取充值提现
     * @param $type
     */
	protected function log($type)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and log.uniacid=:uniacid and m.uniacid=:uniacid and log.type=:type and log.money<>0';
		$params = array(':uniacid' => $_W['uniacid'], ':type' => $type);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ((m.realname like :keyword or m.nickname like :keyword or m.mobile like :keyword) or log.logno like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if (!empty($_GPC['id'])) {
			$condition .= ' and m.id=' . intval($_GPC['id']);
		}

		if (!empty($_GPC['level'])) {
			$condition .= ' and m.level=' . intval($_GPC['level']);
		}

		if (!empty($_GPC['groupid'])) {
			$condition .= ' and m.groupid=' . intval($_GPC['groupid']);
		}

		if (!empty($_GPC['rechargetype'])) {
			$_GPC['rechargetype'] = trim($_GPC['rechargetype']);

			if ($_GPC['rechargetype'] == 'system1') {
				$condition .= ' AND log.rechargetype=\'system\' and log.money<0';
			}
			else {
				$condition .= ' AND log.rechargetype=:rechargetype';
				$params[':rechargetype'] = $_GPC['rechargetype'];
			}
		}

		if ($_GPC['status'] != '') {
			$condition .= ' and log.status=' . intval($_GPC['status']);
		}

		$sql = 'select log.id,m.id as mid, m.realname,m.avatar,log.logno,log.type,log.status,log.rechargetype,m.nickname,m.mobile,log.money,log.createtime,log.realmoney,log.deductionmoney,log.charge,log.remark,log.alipay,log.bankname,log.bankcard,log.realname as applyrealname,log.applytype,log.apppay from ' . tablename('ewei_shop_member_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=log.openid' . ' left join ' . tablename('ewei_shop_member_group') . ' g on m.groupid=g.id' . ' left join ' . tablename('ewei_shop_member_level') . ' l on m.level =l.id' . (' where 1 ' . $condition . ' ORDER BY log.createtime DESC ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$list = set_medias($list, 'avatar');
		$apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');

		if (!empty($list)) {
			foreach ($list as $key => $value) {
				$list[$key]['typestr'] = $apply_type[$value['applytype']];

				if ($value['deductionmoney'] == 0) {
					$list[$key]['realmoney'] = $value['money'];
				}

				$list[$key]['createtime'] = date('Y/m/d H:i:s', $value['createtime']);
			}
		}

		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=log.openid and m.uniacid= log.uniacid' . ' left join ' . tablename('ewei_shop_member_group') . ' g on m.groupid=g.id' . ' left join ' . tablename('ewei_shop_member_level') . ' l on m.level =l.id' . (' where 1 ' . $condition . ' '), $params);
		return app_json(array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}

	/**
     * 读取积分余额明细
     * @param $type
     */
	protected function credit($type)
	{
		global $_W;
		global $_GPC;
		$type = $type == 2 ? 'credit1' : 'credit2';
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and log.uniacid=:uniacid and (log.module=:module1  or log.module=:module2)and m.uniacid=:uniacid  and log.credittype=:credittype';
		$params = array(':uniacid' => $_W['uniacid'], ':module1' => 'ewei_shopv2', ':module2' => 'ewei_shop', ':credittype' => $type);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and (m.realname like :keyword or m.nickname like :keyword or m.mobile like :keyword or u.username like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if (!empty($_GPC['id'])) {
			$condition .= ' and m.id=' . intval($_GPC['id']);
		}

		if (!empty($_GPC['level'])) {
			$condition .= ' and m.level=' . intval($_GPC['level']);
		}

		if (!empty($_GPC['groupid'])) {
			$condition .= ' and m.groupid=' . intval($_GPC['groupid']);
		}

		$condition .= ' and log.uid<>0';
		$sql = 'select log.*,m.id as mid, m.realname,m.avatar,m.nickname,m.avatar, m.mobile, m.weixin,u.username from ' . tablename('mc_credits_record') . ' log ' . ' left join ' . tablename('users') . ' u on log.operator<>0 and log.operator<>log.uid and  log.operator=u.uid' . ' left join ' . tablename('ewei_shop_member') . ' m on m.uid=log.uid' . ' left join ' . tablename('ewei_shop_member_group') . ' g on m.groupid=g.id' . ' left join ' . tablename('ewei_shop_member_level') . ' l on m.level =l.id' . (' where 1 ' . $condition . ' ORDER BY log.createtime DESC ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$list = set_medias($list, 'avatar');

		if (!empty($list)) {
			foreach ($list as $index => &$item) {
				$item['createtime'] = date('Y/m/d H:i:s', $item['createtime']);
			}

			unset($item);
		}

		$total = pdo_fetchcolumn('select count(*) from ' . tablename('mc_credits_record') . ' log ' . ' left join ' . tablename('users') . ' u on log.operator<>0 and log.operator<>log.uid and  log.operator=u.uid' . ' left join ' . tablename('ewei_shop_member') . ' m on m.uid=log.uid' . ' left join ' . tablename('ewei_shop_member_group') . ' g on m.groupid=g.id' . ' left join ' . tablename('ewei_shop_member_level') . ' l on m.level =l.id' . (' where 1 ' . $condition . ' '), $params);
		return app_json(array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}

	/**
     * 充值
     */
	public function recharge()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = intval($_GPC['type']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$typestr = $type == 1 ? 'credit1' : 'credit2';

		if (!cv('finance.recharge.' . $typestr)) {
			return app_error(AppError::$PermError);
		}

		$member = m('member')->getMember($id);

		if (empty($member)) {
			return app_error(AppError::$MemberRechargeError, '用户不存在');
		}

		if ($_W['ispost']) {
			$type = $type == 1 ? 'credit1' : 'credit2';
			ca('finance.recharge.' . $type);
			$typestr = $type == 'credit1' ? '积分' : '余额';
			$num = floatval($_GPC['num']);
			$remark = trim($_GPC['remark']);

			if ($num <= 0) {
				show_json(0, '请填写大于0的数字');
			}

			$changetype = intval($_GPC['changetype']);

			if ($changetype == 2) {
				$num -= $member[$type];
			}
			else {
				if ($changetype == 1) {
					$num = 0 - $num;
				}
			}

			m('member')->setCredit($member['openid'], $type, $num, array($_W['uid'], '手机后台会员充值' . $typestr . ' ' . $remark));
			$changetype = 0;
			$changenum = 0;

			if (0 <= $num) {
				$changetype = 0;
				$changenum = $num;
			}
			else {
				$changetype = 1;
				$changenum = 0 - $num;
			}

			if ($type == 'credit1') {
				m('notice')->sendMemberPointChange($member['openid'], $changenum, $changetype);
			}
			else {
				if ($type == 'credit2') {
					$set = m('common')->getSysset('shop');
					$logno = m('common')->createNO('member_log', 'logno', 'RC');
					$data = array('openid' => $member['openid'], 'logno' => $logno, 'uniacid' => $_W['uniacid'], 'type' => '0', 'createtime' => TIMESTAMP, 'status' => '1', 'title' => $set['name'] . '会员充值', 'money' => $num, 'remark' => $remark, 'rechargetype' => 'system');
					pdo_insert('ewei_shop_member_log', $data);
					$logid = pdo_insertid();
					m('notice')->sendMemberLogMessage($logid, 0, true);
				}
			}

			plog('finance.recharge.' . $type, '充值' . $typestr . ': ' . $_GPC['num'] . ' <br/>会员信息: ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			return app_json();
		}

		return app_json(array(
			'member' => array('id' => $member['id'], 'nickname' => $member['nickname'], 'avatar' => tomedia($member['avatar']), 'credit1' => $member['credit1'], 'credit2' => $member['credit2']),
			'perm'   => array('recharge_credit1' => cv('finance.recharge.credit1'), 'recharge_credit2' => cv('finance.recharge.credit2'))
		));
	}
}

?>
