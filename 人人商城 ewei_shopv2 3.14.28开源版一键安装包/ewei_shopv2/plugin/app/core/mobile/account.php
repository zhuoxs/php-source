<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Account_EweiShopV2Page extends AppMobilePage
{
	protected $key = '';
	protected $expire = 0;

	public function __construct()
	{
		global $_W;
		$this->authkey = $_W['setting']['site']['token'] . '_' . $_W['uniacid'];
		$this->expire = 3600 * 24 * 30;
	}

	public function main()
	{
		global $_W;
		$set = $_W['shopset']['wap'];
		$result = array('color' => $set['color'], 'bg' => tomedia($set['bg']), 'logo' => tomedia($_W['shopset']['shop']['logo']), 'template' => $set['style'], 'wx' => $set['sns']['wx'], 'qq' => $set['sns']['qq'], 'closecolor' => '#ffffff');
		return app_json($result);
	}

	public function login()
	{
		global $_W;
		global $_GPC;
		$mobile = trim($_GPC['mobile']);
		$pwd = trim($_GPC['pwd']);
		if (empty($mobile) || empty($pwd)) {
			return app_error(AppError::$ParamsError);
		}

		$member = pdo_fetch('select id,openid,mobile,pwd,salt,avatar,nickname from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));

		if (empty($member)) {
			return app_error(AppError::$UserLoginFail);
		}

		if (md5($pwd . $member['salt']) !== $member['pwd']) {
			return app_error(AppError::$UserLoginFail);
		}

		$token = base64_encode(authcode($member['id'] . '|' . $member['salt'], 'ENCODE', $this->authkey, $this->expire));
		return app_json(array(
			'token'  => $token,
			'expire' => $this->expire,
			'member' => array('id' => $member['id'], 'mobile' => $member['mobile'], 'salt' => $member['salt'], 'nickname' => $member['nickname'], 'avatar' => $member['avatar'], 'openid' => $member['openid'])
		));
	}

	/**
     * 用户注册
     */
	public function register()
	{
		global $_W;
		global $_GPC;
		$mobile = trim($_GPC['mobile']);
		$pwd = trim($_GPC['pwd']);
		$verifycode = trim($_GPC['verifycode']);
		if (empty($mobile) || empty($pwd) || empty($verifycode)) {
			return app_error(AppError::$ParamsError);
		}

		@session_start();
		$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
		$key_time = '__ewei_shopv2_member_verifycodesendtime_' . $_W['uniacid'];
		$sendcode = m('cache')->get($key);
		$sendtime = m('cache')->get($key_time);
		if (!isset($sendcode) || $sendcode !== $verifycode) {
			return app_error(AppError::$VerifyCodeError);
		}

		if (!isset($sendtime) || 600 * 1000 < time() - $sendtime) {
			return app_error(AppError::$VerifyCodeTimeOut);
		}

		$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
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

		$openid = empty($member) ? '' : $member['openid'];
		$nickname = empty($member) ? '' : $member['nickname'];

		if (empty($openid)) {
			$openid = 'wap_user_' . $_W['uniacid'] . '_' . $mobile;
			$nickname = substr($mobile, 0, 3) . 'xxxx' . substr($mobile, 7, 4);
		}

		if (empty($member)) {
			$member = array('uniacid' => $_W['uniacid'], 'mobile' => $mobile, 'nickname' => $nickname, 'openid' => $openid, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'createtime' => time(), 'mobileverify' => 1, 'comefrom' => 'app_mobile');
			pdo_insert('ewei_shop_member', $member);

			if (method_exists(m('member'), 'memberRadisCountDelete')) {
				m('member')->memberRadisCountDelete();
			}
		}
		else {
			pdo_update('ewei_shop_member', array('openid' => $openid, 'salt' => $salt, 'pwd' => md5($pwd . $salt), 'mobileverify' => 1), array('id' => $member['id']));
		}

		if (p('commission')) {
			p('commission')->checkAgent($openid);
		}

		$token = base64_encode(authcode($member['id'] . '|' . $salt, 'ENCODE', $this->authkey, $this->expire));
		return app_json(array(
			'token'  => $token,
			'expire' => $this->expire,
			'member' => array('id' => $member['id'], 'mobile' => $member['mobile'], 'salt' => $member['salt'], 'nickname' => $member['nickname'], 'avatar' => $member['avatar'], 'openid' => $member['openid'])
		));
	}

	/**
     * 登录token验证
     */
	public function checktoken()
	{
		global $_GPC;
		$token = trim($_GPC['token']);

		if (!empty($token)) {
			$token = authcode(base64_decode($token), 'DECODE', $this->authkey, $this->expire);

			if (!empty($token)) {
				return app_json(array('token' => $token));
			}

			return app_error(AppError::$UserTokenFail);
		}

		return app_json();
	}

	/**
     * 验证手机号唯一
     */
	public function checkmobile()
	{
		global $_W;
		global $_GPC;
		$mobile = trim($_GPC['mobile']);
		$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));

		if (!empty($member)) {
			return app_error(AppError::$UserMobileExists);
		}

		return app_json();
	}

	/**
     * 获取修改密码信息
     */
	public function getchangepwd()
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid']);
		if (empty($member['mobile']) || empty($member['mobileverify'])) {
			return app_error(AppError::$UserNotBindMobile, '不用通过手机号找回密码');
		}

		$key_time = '__ewei_shopv2_member_verifycodesendtime_' . $_W['uniacid'];
		$sendtime = m('cache')->get($key_time);
		if (empty($sendtime) || $sendtime + 60 < time()) {
			$endtime = 0;
		}
		else {
			$endtime = 60 - (time() - $sendtime);
		}

		return app_json(array('mobile' => $member['mobile'], 'endtime' => $endtime));
	}

	/**
     * 执行修改密码
     */
	public function changepwd()
	{
		global $_W;
		global $_GPC;
		$mobile = trim($_GPC['mobile']);
		$pwd = trim($_GPC['pwd']);
		$verifycode = trim($_GPC['verifycode']);
		if (empty($mobile) || empty($pwd) || empty($verifycode)) {
			return app_error(AppError::$ParamsError);
		}

		$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
		$key_time = '__ewei_shopv2_member_verifycodesendtime_' . $_W['uniacid'];
		$sendcode = m('cache')->get($key);
		$sendtime = m('cache')->get($key_time);
		if (!isset($sendcode) || $sendcode !== $verifycode) {
			return app_error(AppError::$VerifyCodeError);
		}

		if (!isset($sendtime) || 600 * 1000 < time() - $sendtime) {
			return app_error(AppError::$VerifyCodeTimeOut);
		}

		$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));

		if (empty($member)) {
			return app_error(AppError::$UserNotFound);
		}

		$salt = random(16);

		while (1) {
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where salt=:salt limit 1', array(':salt' => $salt));

			if ($count <= 0) {
				break;
			}

			$salt = random(16);
		}

		pdo_update('ewei_shop_member', array('salt' => $salt, 'pwd' => md5($pwd . $salt)), array('id' => $member['id']));
		return app_json(array('salt' => $member['salt']));
	}

	/**
     * 忘记密码
     */
	public function forget()
	{
		$this->changepwd();
	}

	/**
     * 修改手机号
     */
	public function changemobile()
	{
		global $_W;
		global $_GPC;
		$mobile = trim($_GPC['mobile']);
		$newmobile = trim($_GPC['newmobile']);
		$verifycode = trim($_GPC['verifycode']);
		if (empty($mobile) || empty($pwd) || empty($verifycode)) {
			return app_error(AppError::$ParamsError);
		}

		$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
		$key_time = '__ewei_shopv2_member_verifycodesendtime_' . $_W['uniacid'];
		$sendcode = m('cache')->get($key);
		$sendtime = m('cache')->get($key_time);
		if (!isset($sendcode) || $sendcode !== $verifycode) {
			return app_error(AppError::$VerifyCodeError);
		}

		if (!isset($sendtime) || 600 * 1000 < time() - $sendtime) {
			return app_error(AppError::$VerifyCodeTimeOut);
		}

		$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));

		if (empty($member)) {
			return app_error(AppError::$UserNotFound);
		}

		$newmember = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and uniacid=:uniacid limit 1', array(':mobile' => $newmobile, ':uniacid' => $_W['uniacid']));

		if (empty($newmember)) {
			return app_error(AppError::$UserMobileExists);
		}

		pdo_update('ewei_shop_member', array('mobile' => $newmobile), array('id' => $member['id']));
		return app_json(array('mobile' => $newmobile));
	}

	/**
     * SNS授权登录
     */
	public function sns()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
		}

		$type = trim($_GPC['type']);

		if ($type == 'qq') {
			if (empty($_GPC['openid'])) {
				return app_error(AppError::$ParamsError, '参数错误(OPENID字段为空)');
			}

			if (empty($_GPC['userinfo'])) {
				return app_error(AppError::$ParamsError, '参数错误(USERINFO字段为空)');
			}
		}
		else if ($type == 'wx') {
			if (empty($_GPC['code']) && empty($_GPC['token'])) {
				return app_error(AppError::$ParamsError, '参数错误(CODE、TOKEN为空)');
			}
		}
		else {
			return app_error(AppError::$ParamsError, '参数错误(SNS类型错误)');
		}

		$mid = m('member')->checkMemberSNS($type);
		$member = m('member')->getMember($mid);
		$token = base64_encode(authcode($member['id'] . '|' . $member['salt'], 'ENCODE', $this->authkey, $this->expire));
		return app_json(array(
			'token'  => $token,
			'expire' => $this->expire,
			'member' => array('id' => $member['id'], 'mobile' => $member['mobile'], 'salt' => $member['salt'], 'nickname' => $member['nickname'], 'avatar' => $member['avatar'], 'openid' => $member['openid'])
		));
	}
}

?>
