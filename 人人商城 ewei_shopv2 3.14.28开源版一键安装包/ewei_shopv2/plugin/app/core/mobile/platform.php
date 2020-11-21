<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Platform_EweiShopV2Page extends AppMobilePage
{
	/**
     * 获取公众号列表
     */
	public function get_wx_list()
	{
		global $_GPC;
		$this->verifySign();
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		list($list, $total) = $this->oldAccount($pindex, $psize);

		if (!empty($list)) {
			foreach ($list as &$account) {
				$account_details = uni_accounts($account['uniacid']);

				if (!empty($account_details)) {
					$account_detail = $account_details[$account['uniacid']];
					$account['thumb'] = tomedia('headimg_' . $account_detail['acid'] . '.jpg') . '?time=' . time();
					$account['appid'] = $account_detail['key'];
				}
			}

			unset($account_val);
			unset($account);
		}

		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	/**
     * 验证域名
     */
	public function verifydomain()
	{
		$this->verifySign();
		load()->func('communication');
		$result = ihttp_post(EWEI_SHOPV2_AUTH_WXAPP . 'auth/auth', array('host' => $_SERVER['HTTP_HOST']));
	}

	/**
     * 验证权限
     */
	private function verifySign()
	{
		global $_GPC;
		$time = trim($_GPC['time']);

		if (empty($time)) {
			return app_error(AppError::$ParamsError, '参数错误(time)');
		}

		if ($time + 300 < time()) {
			return app_error(AppError::$ParamsError, 'sign失效');
		}

		$sign = trim($_GPC['sign']);

		if (empty($time)) {
			return app_error(AppError::$ParamsError, '参数错误(sign)');
		}

		$setting = setting_load('site');
		$site_id = isset($setting['site']['key']) ? $setting['site']['key'] : (isset($setting['key']) ? $setting['key'] : '0');

		if (empty($site_id)) {
			return app_error(AppError::$ParamsError, '参数错误(site_id)');
		}

		$sign_str = md5(md5('site_id=' . $site_id . '&request_time=' . $time . '&salt=FOXTEAM'));

		if ($sign != $sign_str) {
			return app_error(AppError::$RequestError);
		}
	}

	/**
     * 读取公众号列表
     * @param $pindex
     * @param $psize
     * @return array
     */
	private function oldAccount($pindex, $psize)
	{
		global $_GPC;
		global $_W;
		$start = ($pindex - 1) * $psize;
		$condition = '';
		$param = array();
		$keyword = trim($_GPC['keyword']);
		$condition .= ' WHERE a.default_acid <> 0 AND b.isdeleted <> 1 AND (b.type = ' . ACCOUNT_TYPE_OFFCIAL_NORMAL . ' OR b.type = ' . ACCOUNT_TYPE_OFFCIAL_AUTH . ')';
		$order_by = ' ORDER BY a.`rank` DESC';

		if (!empty($keyword)) {
			$condition .= ' AND a.`name` LIKE :name';
			$param[':name'] = '%' . $keyword . '%';
		}

		$tsql = 'SELECT COUNT(*) FROM ' . tablename('uni_account') . ' as a LEFT JOIN' . tablename('account') . (' as b ON a.default_acid = b.acid ' . $condition . ' ' . $order_by . ', a.`uniacid` DESC');
		$total = pdo_fetchcolumn($tsql, $param);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT a.name, a.uniacid FROM ' . tablename('uni_account') . ' as a LEFT JOIN' . tablename('account') . (' as b ON a.default_acid = b.acid ' . $condition . ' ' . $order_by . ', a.`uniacid` DESC LIMIT ' . $start . ', ' . $psize);
			$list = pdo_fetchall($sql, $param);
		}

		return array($list, $total);
	}
}

?>
