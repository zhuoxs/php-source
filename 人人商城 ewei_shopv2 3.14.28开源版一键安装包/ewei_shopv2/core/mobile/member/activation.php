<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Activation_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$iserror = false;
		$card_id = $_GPC['card_id'];
		$encrypt_code = $_GPC['encrypt_code'];
		if (empty($card_id) || empty($encrypt_code)) {
			$iserror = true;
		}

		$encrypt_code = htmlspecialchars_decode($encrypt_code, ENT_QUOTES);
		$result = com_run('wxcard::wxCardCodeDecrypt', $encrypt_code);
		if (empty($result) || is_wxerror($result)) {
			$iserror = true;
		}

		$code = $result['code'];

		if (empty($_W['openid'])) {
			$iserror = true;
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid and openid =:openid limit 1 ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if ($iserror) {
			$this->message(array('message' => '激活链接错误!', 'title' => '激活链接错误!', 'buttondisplay' => true), mobileUrl('member'), 'error');
		}

		$arr = array('membercardid' => $card_id, 'membercardcode' => $code, 'membershipnumber' => $code, 'membercardactive' => 0);
		$CardActivation = m('common')->getSysset('memberCardActivation');
		pdo_update('ewei_shop_member', $arr, array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));

		if (empty($CardActivation['openactive'])) {
			$result = com_run('wxcard::ActivateMembercardbyopenid', $_W['openid']);
			if (empty($result) || is_wxerror($result)) {
				$this->message(array('message' => '会员卡激活失败!', 'title' => '激活链接错误!', 'buttondisplay' => true), mobileUrl('member'), 'error');
			}
			else if (empty($item['membercardactive'])) {
				pdo_update('ewei_shop_member', array('membercardactive' => 1), array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));
				$this->sendGift($_W['openid']);
				$this->message(array('message' => '您的会员卡已成功激活!', 'title' => '激活成功!', 'buttondisplay' => true), mobileUrl('member'), 'success');
			}
			else {
				header('location: ' . mobileUrl('member'));
			}
		}

		if (empty($CardActivation)) {
			$needrealname = 0;
			$needmobile = 0;
			$needsmscode = 0;
			$needsbirthday = 0;
			$needsidnumber = 0;
		}
		else {
			$needrealname = intval($CardActivation['realname']);
			$needmobile = intval($CardActivation['mobile']);
			$needsmscode = intval($CardActivation['sms_active']);
			$needsbirthday = intval($CardActivation['birthday']);
			$needsidnumber = intval($CardActivation['idnumber']);
		}

		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$iserror = false;
		$card_id = $_GPC['card_id'];
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['uniacid'] . '_member_card__active_' . $_W['openid'];
			$redis = redis();

			if (!is_error($redis)) {
				if ($redis->get($redis_key)) {
					show_json(0, '请勿重复点击');
				}

				$redis->setex($redis_key, 1, time());
			}
		}

		$encrypt_code = $_GPC['encrypt_code'];
		if (empty($card_id) || empty($encrypt_code)) {
			show_json(0, '激活链接错误!');
		}

		$encrypt_code = htmlspecialchars_decode($encrypt_code, ENT_QUOTES);
		$result = com_run('wxcard::wxCardCodeDecrypt', $encrypt_code);
		if (empty($result) || is_wxerror($result)) {
			show_json(0, '激活链接错误!');
		}

		$code = $result['code'];

		if (empty($_W['openid'])) {
			show_json(0, '激活链接错误!');
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid and openid =:openid limit 1 ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		$arr = array('membercardid' => $card_id, 'membercardcode' => $code, 'membershipnumber' => $code, 'membercardactive' => 0);
		$CardActivation = m('common')->getSysset('memberCardActivation');

		if (!empty($CardActivation['openactive'])) {
			if (!empty($CardActivation['sms_active']) && !empty($CardActivation['mobile'])) {
				@session_start();
				$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . trim($_GPC['mobile']);
				$code = $_SESSION[$key];

				if (empty($code)) {
					show_json(0, '请获取验证码!');
				}

				if (trim($_GPC['sms_code']) != $code) {
					show_json(0, '验证码错误!');
				}
			}

			if (!empty($CardActivation['realname'])) {
				if (empty($_GPC['realname'])) {
					show_json(0, '真实姓名不能为空!');
				}

				$arr['realname'] = trim($_GPC['realname']);
			}

			if (!empty($CardActivation['mobile'])) {
				if (empty($_GPC['mobile'])) {
					show_json(0, '电话号码不能为空');
				}

				$arr['mobile'] = trim($_GPC['mobile']);
			}

			if (!empty($CardActivation['birthday'])) {
				if (empty($_GPC['birthyear'])) {
					show_json(0, '出生日期未选择');
				}

				$arr['birthyear'] = trim($_GPC['birthyear']);
				$arr['birthmonth'] = trim($_GPC['birthmonth']);
				$arr['birthday'] = trim($_GPC['birthday']);
			}

			if (!empty($CardActivation['idnumber'])) {
				if (empty($_GPC['idnumber'])) {
					show_json(0, '身份证号码未填写');
				}

				$arr['idnumber'] = trim($_GPC['idnumber']);
			}
		}

		pdo_update('ewei_shop_member', $arr, array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));
		$result = com_run('wxcard::ActivateMembercardbyopenid', $_W['openid']);
		if (empty($result) || is_wxerror($result)) {
			show_json(0, '会员卡激活失败');
		}
		else {
			if (empty($item['membercardactive'])) {
				$this->sendGift($_W['openid']);
			}

			pdo_update('ewei_shop_member', array('membercardactive' => 1), array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));
			show_json(1, '您的会员卡已成功激活');
		}
	}

	public function sendGift($openid)
	{
		$CardActivation = m('common')->getSysset('memberCardActivation');
		$credit1 = intval($CardActivation['credit1']);
		$credit2 = intval($CardActivation['credit2']);
		$couponid = intval($CardActivation['couponid']);
		$levelid = intval($CardActivation['levelid']);

		if (!empty($credit1)) {
			m('member')->setCredit($openid, 'credit1', $credit1, array(0, '激活会员卡,积分+' . $credit1));
		}

		if (!empty($credit2)) {
			m('member')->setCredit($openid, 'credit2', $credit2, array(0, '激活会员卡,余额+' . $credit2));
		}

		if (!empty($couponid)) {
			$member = m('member')->getMember($openid);

			if (com('coupon')) {
				com('coupon')->poster($member, $couponid, 1, 10);
			}
		}

		if (!empty($levelid)) {
			$member = m('member')->upgradeLevelByLevelId($openid, $levelid);
		}
	}

	public function verifycode()
	{
		global $_W;
		global $_GPC;
		@session_start();
		$mobile = trim($_GPC['mobile']);

		if (empty($mobile)) {
			show_json(0, '请输入手机号');
		}

		if (!empty($_SESSION['verifycodesendtime']) && time() < $_SESSION['verifycodesendtime'] + 60) {
			show_json(0, '请求频繁请稍后重试');
		}

		$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and openid <>:openid  and mobileverify=1 and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));

		if (!empty($member)) {
			show_json(0, '该手机号已经被绑定');
		}

		$CardActivation = m('common')->getSysset('memberCardActivation');
		$sms_id = $CardActivation['sms_id'];

		if (empty($sms_id)) {
			show_json(0, '短信发送失败(NOSMSID)');
		}

		$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
		$code = random(5, true);
		$shopname = $_W['shopset']['shop']['name'];
		$ret = array('status' => 0, 'message' => '发送失败');

		if (com('sms')) {
			$ret = com('sms')->send($mobile, $sms_id, array('验证码' => $code, '商城名称' => !empty($shopname) ? $shopname : '商城名称'));
		}

		if ($ret['status']) {
			$_SESSION[$key] = $code;
			$_SESSION['verifycodesendtime'] = time();
			show_json(1, '短信发送成功');
		}

		show_json(0, $ret['message']);
	}

	public function success()
	{
		$this->message(array('message' => '您的会员卡已成功激活!', 'title' => '激活成功!', 'buttondisplay' => true), mobileUrl('member'), 'success');
	}
}

?>
