<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'mmanage/core/inc/page_mmanage.php';
class Recharge_EweiShopV2Page extends MmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = intval($_GPC['type']);

		if (empty($id)) {
			if ($_W['isajax']) {
				show_json(0, '参数错误');
			}
			else {
				$this->message('参数错误');
			}
		}

		$member = m('member')->getMember($id);

		if (empty($member)) {
			if ($_W['isajax']) {
				show_json(0, '会员不存在');
			}
			else {
				$this->message('会员不存在');
			}
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
			show_json(1, array('url' => referer()));
			show_json(1);
		}

		include $this->template();
	}
}

?>
