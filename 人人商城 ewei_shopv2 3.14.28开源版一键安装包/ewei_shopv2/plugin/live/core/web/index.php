<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		$wsConfig = json_encode(array('address' => $this->model->getWsAddress()));
		$plugin = pdo_fetch('select `desc` from ' . tablename('ewei_shop_plugin') . ' where `identity`=:identyty limit  1', array(':identyty' => 'live'));
		$livenum = pdo_fetchcolumn('SELECT count(0) FROM ' . tablename('ewei_shop_live') . 'WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$livingnum = pdo_fetchcolumn('SELECT count(0) FROM ' . tablename('ewei_shop_live') . 'WHERE uniacid=:uniacid AND living=1 ', array(':uniacid' => $_W['uniacid']));
		$liveprice = array();
		$liveprice[0] = $this->model->selectOrderPrice(0);
		$liveprice[7] = $this->model->selectOrderPrice(7);
		$liveprice[30] = $this->model->selectOrderPrice(30);
		include $this->template();
	}

	/**
     * 获取视频地址
     */
	public function get()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$url = trim($_GPC['url']);
			$type = 'auto';

			if (empty($url)) {
				show_json(0, '请输入PC端直播地址');
			}

			if (!strexists($url, 'http://') && !strexists($url, 'https://')) {
				show_json(0, '直播地址请以http://或https://开头');
			}

			$result = $this->model->getLiveInfo($url, $type);

			if (is_error($result)) {
				show_json(0, $result['message']);
			}

			show_json(1, $result);
		}

		$list = $this->model->getLiveList();
		include $this->template();
	}

	/**
     * 服务平滑重启
     */
	public function service()
	{
		global $_W;
		$wsConfig = json_encode(array('address' => $this->model->getWsAddress()));
		include $this->template();
	}
}

?>
