<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Set_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$_W['uid'] = 2;
		load()->model('user');
		$account = user_single(array('username' => trim($_GPC['_username'])));

		if (empty($account)) {
			return app_error(AppError::$UserLoginFail, '未查询到此用户');
		}

		$editinfo = true;
		$founders = explode(',', $_W['config']['setting']['founder']);

		if (in_array($account['uid'], $founders)) {
			$editinfo = false;
		}

		if ($editinfo) {
			$account_user = pdo_fetch('SELECT * FROM ' . tablename('uni_account_users') . ' WHERE uid=:uid', array(':uid' => $account['uid']));

			if ($account_user['role'] != 'operator') {
				$editinfo = false;
			}
		}

		$roleuser = pdo_fetch('SELECT id, uid, username, status, openid, realname, mobile, openid_wa, member_nick FROM' . tablename('ewei_shop_perm_user') . 'WHERE uid=:uid AND uniacid=:uniacid', array(':uid' => $account['uid'], ':uniacid' => $_W['uniacid']));

		if (!empty($roleuser)) {
			if (!empty($roleuser['openid_wa']) && empty($roleuser['member_nick'])) {
				$roleuser['member_nick'] = '昵称未获取';
			}
		}

		if ($_W['ispost']) {
			$realname = trim($_GPC['realname']);
			$mobile = trim($_GPC['mobile']);
			$password = trim($_GPC['password']);
			$password2 = trim($_GPC['password2']);

			if (empty($realname)) {
				return app_error(AppError::$ParamsError, '请输入真实姓名');
			}

			if (empty($realname)) {
				return app_error(AppError::$ParamsError, '请输入手机号');
			}

			if (!empty($password) || !empty($password2)) {
				if (empty($password)) {
					return app_error(AppError::$ParamsError, '请输入密码');
				}

				if (empty($password2)) {
					return app_error(AppError::$ParamsError, '请重复输入密码');
				}

				if ($password != $password2) {
					return app_error(AppError::$ParamsError, '两次输入的密码不一致');
				}

				$changepass = true;
			}

			if ($changepass) {
				$changepassresult = user_update(array('uid' => $roleuser['uid'], 'password' => $password, 'salt' => $account['salt']));
				$data['password'] = $account['password'];
			}

			$data = array('realname' => $realname, 'mobile' => $mobile);
			pdo_update('ewei_shop_perm_user', $data, array('id' => $roleuser['id'], 'uniacid' => $_W['uniacid']));
			return app_json(array('changepass' => intval($changepassresult)));
		}

		return app_json(array(
			'user'     => $roleuser,
			'account'  => array('username' => $account['username'], 'uid' => $account['uid']),
			'editinfo' => $editinfo
		));
	}

	/**
     * 绑定微信号
     */
	public function bindwx()
	{
		global $_W;
		global $_GPC;
		$username = trim($_GPC['_username']);
		$userinfo = $_GPC['userinfo'];
		$confirm = intval($_GPC['confirm']);

		if (empty($confirm)) {
			$code = trim($_GPC['code']);

			if (empty($code)) {
				return app_error(AppError::$ParamsError);
			}

			$openid = $this->getOpenid($code);
		}
		else {
			$openid = trim($_GPC['openid']);
		}

		load()->model('user');
		$roleuser = pdo_fetch('SELECT id, uid, username, status, openid, realname, mobile, openid_wa, member_nick FROM' . tablename('ewei_shop_perm_user') . 'WHERE openid_wa=:openid AND uniacid=:uniacid', array(':openid' => $openid, ':uniacid' => $_W['uniacid']));
		$account = user_single(array('username' => $username));

		if (empty($account)) {
			return app_error(AppError::$UserLoginFail);
		}

		if (!empty($roleuser) && empty($confirm)) {
			if ($account['uid'] == $roleuser['uid'] . '0') {
				return app_error(AppError::$BindError, '操作账号已绑定当前微信');
			}

			$member_wa = iunserializer($roleuser['member_wa']);
			return app_json(array('error' => AppError::$BindConfirm, 'message' => '操作账号已绑定' . $member_wa['nickname'] . ' 确定要取消之前绑定？', 'openid' => $openid));
		}

		$data = array('openid_wa' => $openid, 'member_nick' => $userinfo['nickName']);
		pdo_update('ewei_shop_perm_user', $data, array('uid' => $account['uid'], 'uniacid' => $_W['uniacid']));

		if (!empty($roleuser)) {
			pdo_update('ewei_shop_perm_user', array('openid_wa' => '', 'member_nick' => ''), array('id' => $roleuser['id']));
		}

		return app_json();
	}

	/**
     * 获取用户openid
     * @param $code
     * @return mixed
     */
	protected function getOpenid($code)
	{
		$set = p('app')->getGlobal();

		if (empty($set['mmanage'])) {
			$set['mmanage'] = array();
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

		return $arr['openid'];
	}
}

?>
