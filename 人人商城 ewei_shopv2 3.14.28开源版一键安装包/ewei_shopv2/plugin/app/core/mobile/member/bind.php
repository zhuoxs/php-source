<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Bind_EweiShopV2Page extends AppMobilePage
{
	protected $member;

	public function __construct()
	{
		global $_W;
		parent::__construct();
		$this->member = m('member')->getInfo($_W['openid']);

		if ($this->iswxapp) {
			$needbind = false;
			if (empty($_W['shopset']['app']['isclose']) && !empty($_W['shopset']['app']['openbind']) || !empty($_W['shopset']['wap']['open'])) {
				$needbind = true;
			}

			if (!$needbind) {
				return app_error(AppError::$BindNotOpen);
			}
		}
	}

	public function main()
	{
		global $_W;
		$member = $this->member;
		$key_time = '__ewei_shopv2_member_verifycodesendtime_' . $_W['uniacid'];
		$sendtime = m('cache')->get($key_time);
		if (empty($sendtime) || $sendtime + 60 < time()) {
			$endtime = 0;
		}
		else {
			$endtime = 60 - (time() - $sendtime);
		}

		$memberArr = array('mobile' => $member['mobile']);
		$wapset = m('common')->getSysset('wap');
		$domain = 'https://' . $_SERVER['HTTP_HOST'];
		$verifycode_img = $domain . '/app/ewei_shopv2_api.php?i=' . $_W['uniacid'] . '&r=sms.captcha&time=' . time() . '&openid=' . $_W['openid'];
		return app_json(array('member' => $memberArr, 'binded' => !empty($member['mobile']) && !empty($member['mobileverify']) ? 1 : 0, 'endtime' => $endtime, 'smsimgcode' => $wapset['smsimgcode'], 'verifycode_img' => $verifycode_img));
	}

	public function submit()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$mobile = trim($_GPC['mobile']);
			$verifycode = trim($_GPC['code']);
			$pwd = trim($_GPC['password']);
			$confirm = intval($_GPC['confirm']);
			$member = $this->member;
			$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
			$key_time = '__ewei_shopv2_member_verifycodesendtime_' . $_W['uniacid'];
			$sendcode = m('cache')->get($key);
			$sendtime = m('cache')->get($key_time);
			if (!isset($sendcode) || $sendcode !== $verifycode || !isset($sendtime) || $sendtime + 600 < time()) {
				return app_error(AppError::$VerifyCodeError, '验证码错误或已过期');
			}

			$member2 = pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid and mobileverify=1 limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));

			if (empty($member2)) {
				$salt = m('account')->getSalt();
				m('bind')->update($member['id'], array('mobile' => $mobile, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'mobileverify' => 1));
				m('cache')->del($key);
				m('account')->setLogin($member['id']);

				if (empty($member['mobileverify'])) {
					m('bind')->sendCredit($member);
				}

				return app_json();
			}

			if ($member['id'] == $member2['id']) {
				return app_error(AppError::$BindSelfBinded);
			}

			if (m('bind')->iswxm($member) && m('bind')->iswxm($member2)) {
				if ($confirm) {
					$salt = m('account')->getSalt();
					m('bind')->update($member['id'], array('mobile' => $mobile, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'mobileverify' => 1));
					m('bind')->update($member2['id'], array('mobileverify' => 0));
					m('cache')->del($key);
					m('account')->setLogin($member['id']);
					return app_json();
				}

				return app_error(AppError::$BindWillRelieve, '此手机号已与其他帐号绑定, 如果继续将会解绑之前帐号, 确定继续吗？');
			}

			if (!m('bind')->iswxm($member2)) {
				if ($confirm) {
					$result = m('bind')->merge($member2, $member);

					if (empty($result['errno'])) {
						return app_error(AppError::$BindError, $result['message']);
					}

					$salt = m('account')->getSalt();
					m('bind')->update($member['id'], array('mobile' => $mobile, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'mobileverify' => 1));
					m('cache')->del($key);
					m('account')->setLogin($member['id']);
					return app_json();
				}

				return app_error(AppError::$BindWillMerge, '此手机号已通过其他方式注册, 如果继续将会合并账号信息, 确定继续吗？');
			}

			if (!m('bind')->iswxm($member)) {
				if ($confirm) {
					$result = m('bind')->merge($member, $member2);

					if (empty($result['errno'])) {
						return app_error(AppError::$BindError, $result['message']);
					}

					$salt = m('account')->getSalt();
					m('bind')->update($member2['id'], array('mobile' => $mobile, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'mobileverify' => 1));
					m('cache')->del($key);
					m('account')->setLogin($member2['id']);
					return app_json();
				}

				return app_error(AppError::$BindWillMerge, '此手机号已通过其他方式注册, 如果继续将会合并账号信息, 确定继续吗？');
			}
		}

		return app_error(AppError::$ParamsError);
	}

	public function imageChange()
	{
		global $_W;
		global $_GPC;
		$domain = 'https://' . $_SERVER['HTTP_HOST'];
		$verifycode_img = $domain . '/app/ewei_shopv2_api.php?i=' . $_W['uniacid'] . '&r=sms.captcha&time=' . time() . '&openid=' . $_W['openid'];
		return app_json(array('verifycode_img' => $verifycode_img));
	}
}

?>
