<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Changepwd_EweiShopV2Page extends MobileLoginPage
{
	protected $member;

	public function __construct()
	{
		global $_W;
		global $_GPC;
		parent::__construct();
		$this->member = m('member')->getMember($_W['openid']);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$member = $this->member;
		$wapset = m('common')->getSysset('wap');
		if (is_weixin() || empty($_GPC['__ewei_shopv2_member_session_' . $_W['uniacid']])) {
			header('location: ' . mobileUrl());
		}

		if ($_W['ispost']) {
			$mobile = trim($_GPC['mobile']);
			$verifycode = trim($_GPC['verifycode']);
			$pwd = trim($_GPC['pwd']);
			@session_start();
			$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
			if (!isset($_SESSION[$key]) || $_SESSION[$key] !== $verifycode || !isset($_SESSION['verifycodesendtime']) || $_SESSION['verifycodesendtime'] + 600 < time()) {
				show_json(0, '验证码错误或已过期!');
			}

			$member = pdo_fetch('select id,openid,mobile,pwd,salt,credit1,credit2, createtime from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid and mobileverify=1 limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
			$salt = empty($member) ? '' : $member['salt'];

			if (empty($salt)) {
				$salt = random(16);

				while (1) {
					$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where salt=:salt limit 1', array(':salt' => $salt));

					if ($count <= 0) {
						break;
					}

					$salt = random(16);
				}
			}

			pdo_update('ewei_shop_member', array('mobile' => $mobile, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'mobileverify' => 1), array('id' => $this->member['id'], 'uniacid' => $_W['uniacid']));
			unset($_SESSION[$key]);
			show_json(1);
		}

		$sendtime = $_SESSION['verifycodesendtime'];
		if (empty($sendtime) || $sendtime + 60 < time()) {
			$endtime = 0;
		}
		else {
			$endtime = 60 - (time() - $sendtime);
		}

		include $this->template();
	}
}

?>
