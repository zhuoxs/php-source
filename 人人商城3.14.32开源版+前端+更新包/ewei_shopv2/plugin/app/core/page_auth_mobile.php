<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class AppMobileAuthPage extends AppMobilePage
{
	private $key = '4mgUUFPfc5hxEisx';

	public function __construct()
	{
		$this->checkRequestAuth();
		parent::__construct();
	}

	protected function checkRequestAuth()
	{
		global $_W;
		global $_GPC;
		$set = p('app')->getGlobal();

		if (empty($set['mmanage'])) {
			$set['mmanage'] = array();
		}

		if (!is_array($set['mmanage']) || empty($set['mmanage']['open'])) {
			app_error(AppError::$ManageNotOpen);
		}

		$uid = intval($_GPC['_uid']);
		$sign = trim($_GPC['_sign']);
		$username = trim($_GPC['_username']);
		$requestTime = trim($_GPC['_requesttime']);
		if (empty($uid) || empty($sign) || empty($username) || empty($requestTime)) {
			app_error(AppError::$RequestError);
		}

		$signstr = md5($_W['uniacid'] . base64_encode($username . $requestTime . $this->key));

		if ($signstr != $sign) {
			app_error(AppError::$RequestError);
		}

		if ($_W['uniacid'] != -1 && $_GPC['r'] != 'mmanage.index.switchwx') {
			$checkrole = $this->we_permission($uid, $_W['uniacid']);

			if (empty($checkrole)) {
				return app_error(AppError::$PermError);
			}

			$GLOBALS['_W']['role'] = $checkrole;
		}

		$GLOBALS['_W']['uid'] = $uid;
	}

	/**
     * 权限判断
     * @param int $uid
     * @param int $uniacid
     * @return bool|string
     */
	private function we_permission($uid = 0, $uniacid = 0)
	{
		global $_W;
		$uid = empty($uid) ? $_W['uid'] : intval($uid);
		$uniacid = empty($uniacid) ? $_W['uniacid'] : intval($uniacid);

		if ($this->we_user_is_founder($uid)) {
			return 'founder';
		}

		$sql = 'SELECT `role` FROM ' . tablename('uni_account_users') . ' WHERE `uid`=:uid AND `uniacid`=:uniacid';
		$pars = array();
		$pars[':uid'] = $uid;
		$pars[':uniacid'] = $uniacid;
		$role = pdo_fetchcolumn($sql, $pars);

		if (in_array($role, array('manager', 'owner'))) {
			$role = 'manager';
		}

		return $role;
	}

	/**
     * 判断是不是创始人
     * @param $uid
     * @return bool
     */
	private function we_user_is_founder($uid)
	{
		global $_W;
		$founders = explode(',', $_W['config']['setting']['founder']);

		if (in_array($uid, $founders)) {
			return true;
		}

		$founder_groupid = pdo_getcolumn('users', array('uid' => $uid), 'founder_groupid');

		if ($founder_groupid == ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) {
			return true;
		}

		return false;
	}
}

?>
