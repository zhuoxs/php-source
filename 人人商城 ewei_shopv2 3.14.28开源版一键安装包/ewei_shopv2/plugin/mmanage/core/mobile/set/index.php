<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'mmanage/core/inc/page_mmanage.php';
class Index_EweiShopV2Page extends MmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$roleuser = pdo_fetch('SELECT id, uid, username, status, openid, realname, mobile FROM' . tablename('ewei_shop_perm_user') . 'WHERE uid=:uid AND uniacid=:uniacid', array(':uid' => $_W['uid'], ':uniacid' => $_W['uniacid']));

		if (!empty($_W['openid'])) {
			$member = m('member')->getMember($_W['openid']);

			if ($_W['openid'] == $roleuser['openid']) {
				$member['bindrole'] = true;
			}
		}

		if ($_W['ispost']) {
			$realname = trim($_GPC['realname']);
			$mobile = trim($_GPC['mobile']);
			$password = trim($_GPC['password']);
			$password2 = trim($_GPC['password2']);

			if (empty($realname)) {
				show_json(0, '请输入真实姓名');
			}

			if (empty($realname)) {
				show_json(0, '请输入手机号');
			}

			if (!empty($password) || !empty($password2)) {
				if (empty($password)) {
					show_json(0, '请输入密码');
				}

				if (empty($password2)) {
					show_json(0, '请重复输入密码');
				}

				if ($password != $password2) {
					show_json(0, '两次输入的密码不一致');
				}

				$changepass = true;
			}

			load()->model('user');
			$account = user_single(array('username' => $roleuser['username']));

			if ($changepass) {
				$changepassresult = user_update(array('uid' => $roleuser['uid'], 'password' => $password, 'salt' => $account['salt']));
				$data['password'] = $account['password'];
			}

			$data = array('realname' => $realname, 'mobile' => $mobile);
			pdo_update('ewei_shop_perm_user', $data, array('id' => $roleuser['id'], 'uniacid' => $_W['uniacid']));
			show_json(1, array('changepass' => intval($changepassresult)));
		}

		include $this->template();
	}
}

?>
