<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class MmanageModel extends PluginModel
{
	public function uni_permission($uid = 0, $uniacid = 0)
	{
		global $_W;
		$uid = empty($uid) ? $_W['uid'] : intval($uid);
		$uniacid = empty($uniacid) ? $_W['uniacid'] : intval($uniacid);
		$founders = explode(',', $_W['config']['setting']['founder']);

		if (in_array($uid, $founders)) {
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
}

?>
