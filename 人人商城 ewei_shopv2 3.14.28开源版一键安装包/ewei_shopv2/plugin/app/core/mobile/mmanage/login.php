<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Login_EweiShopV2Page extends AppMobilePage
{
	protected $appid;
	protected $appsecret;

	/**
     * 登录接口
     */
	public function main()
	{
		$set = p('app')->getGlobal();

		if (empty($set['mmanage'])) {
			$set['mmanage'] = array();
		}

		return app_json(array('logo' => tomedia($set['mmanage']['logo']), 'name' => $set['mmanage']['name'], 'close' => !intval($set['mmanage']['open'])));
	}

	public function submit()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			return app_error(AppError::$RequestError);
		}

		$set = p('app')->getGlobal();

		if (empty($set['mmanage'])) {
			$set['mmanage'] = array();
		}

		if (!intval($set['mmanage']['open'])) {
			return app_error(AppError::$ManageNotOpen);
		}

		load()->model('user');
		$type = trim($_GPC['type']);

		if ($type == 'wechat') {
			$code = trim($_GPC['code']);

			if (empty($code)) {
				return app_error(AppError::$ParamsError);
			}

			if (empty($set['mmanage']['appid']) || empty($set['mmanage']['secret'])) {
				return app_error(AppError::$UserLoginFail, '微信登录参数未配置');
			}

			load()->func('communication');
			$url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $set['mmanage']['appid'] . '&secret=' . $set['mmanage']['secret'] . '&js_code=' . $code . '&grant_type=authorization_code';
			$resp = ihttp_request($url);

			if ($resp['code'] != 200) {
				return app_error(AppError::$UserLoginFail, '与微信连接失败，请稍后重试');
			}

			$arr = @json_decode($resp['content'], true);
			if (!empty($arr['errcode']) || !isset($arr['openid'])) {
				return app_error(AppError::$UserLoginFail, $arr['errmsg']);
			}

			$openid = $arr['openid'];
			$roleuser = pdo_fetch('SELECT id, uid, uniacid, username, status, openid_wa FROM' . tablename('ewei_shop_perm_user') . 'WHERE openid_wa=:openid LIMIT 1', array(':openid' => $openid));

			if (empty($roleuser)) {
				return app_error(AppError::$UserLoginFail, '当前账号未绑定操作员');
			}

			if (empty($roleuser['status'])) {
				return app_error(AppError::$UserLoginFail, '此账号暂时无法登录管理后台');
			}

			$account = user_single($roleuser['uid']);

			if (!$account) {
				return app_error(AppError::$UserLoginFail, '当前账号未绑定操作员');
			}
		}
		else {
			$username = trim($_GPC['username']);
			$password = trim($_GPC['password']);
			if (empty($username) || empty($password)) {
				return app_error(AppError::$ParamsError);
			}

			if (!user_check(array('username' => $username))) {
				return app_error(AppError::$UserLoginFail, '用户不存在');
			}

			if (!user_check(array('username' => $username, 'password' => $password))) {
				return app_error(AppError::$UserLoginFail, '用户名或密码错误');
			}

			$account = user_single(array('username' => $username));
			$founders = explode(',', $_W['config']['setting']['founder']);

			if (!in_array($account['uid'], $founders)) {
				if ($account['status'] != 2) {
					return app_error(AppError::$UserLoginFail, '操作员已被禁用');
				}
			}

			$role = $this->we_role($account['uid']);

			if (empty($role)) {
				return app_error(AppError::$UserLoginFail, '此账号没有管理权限');
			}

			if ($role == 'operator') {
				$roleuser = pdo_fetch('SELECT id, uid, uniacid FROM' . tablename('ewei_shop_perm_user') . 'WHERE uid=:uid LIMIT 1', array(':uid' => $account['uid']));

				if (empty($roleuser)) {
					return app_error(AppError::$UserLoginFail, '此账号没有管理权限');
				}

				$admin = 0;
			}
			else {
				$admin = 1;
			}
		}

		return app_json(array(
			'account' => array('uid' => $account['uid'], 'uniacid' => is_array($roleuser) ? $roleuser['uniacid'] : 0, 'username' => $account['username'], 'admin' => $admin)
		));
	}

	public function uni_owned($uid = 0)
	{
		global $_W;
		$uid = empty($uid) ? $_W['uid'] : intval($uid);
		$uniaccounts = array();
		$founders = explode(',', $_W['config']['setting']['founder']);

		if (in_array($uid, $founders)) {
			$uniaccounts = pdo_fetchall('SELECT * FROM ' . tablename('uni_account') . ' ORDER BY `uniacid` DESC', array(), 'uniacid');
		}
		else {
			$uniacids = pdo_fetchall('SELECT uniacid FROM ' . tablename('uni_account_users') . ' WHERE uid = :uid', array(':uid' => $uid), 'uniacid');

			if (!empty($uniacids)) {
				$uniaccounts = pdo_fetchall('SELECT * FROM ' . tablename('uni_account') . ' WHERE uniacid IN (' . implode(',', array_keys($uniacids)) . ') ORDER BY `uniacid` DESC', array(), 'uniacid');
			}
		}

		return $uniaccounts;
	}

	/**
     * 获取角色
     * @param int $uid
     * @return bool|string
     */
	private function we_role($uid = 0)
	{
		global $_W;
		$founders = explode(',', $_W['config']['setting']['founder']);

		if (in_array($uid, $founders)) {
			return 'founder';
		}

		$vice_founder = pdo_fetchcolumn('SELECT COUNT(id)FROM ' . tablename('uni_account_users') . 'WHERE uid=:uid AND role=:role', array(':uid' => $uid, ':role' => 'vice_founder'));

		if (!empty($vice_founder)) {
			return 'vice_founder';
		}

		$owner = pdo_fetchcolumn('SELECT COUNT(id)FROM ' . tablename('uni_account_users') . 'WHERE uid=:uid AND role=:role', array(':uid' => $uid, ':role' => 'owner'));

		if (!empty($owner)) {
			return 'owner';
		}

		$operator = pdo_fetchcolumn('SELECT COUNT(id)FROM ' . tablename('uni_account_users') . 'WHERE uid=:uid AND role=:role', array(':uid' => $uid, ':role' => 'operator'));

		if (!empty($operator)) {
			return 'operator';
		}

		$manager = pdo_fetchcolumn('SELECT COUNT(id)FROM ' . tablename('uni_account_users') . 'WHERE uid=:uid AND role=:role', array(':uid' => $uid, ':role' => 'manager'));

		if (!empty($manager)) {
			return 'manager';
		}

		return false;
	}
}

?>
