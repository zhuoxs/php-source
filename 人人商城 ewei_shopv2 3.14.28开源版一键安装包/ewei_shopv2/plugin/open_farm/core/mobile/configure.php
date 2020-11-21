<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Configure_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_configure';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'name', 'url', 'qrcode', 'keyword', 'title', 'logo', 'describe', 'public_qrcode', 'force_follow', 'create_time');

	/**
     * 首页主方法
     */
	public function main()
	{
		require_once $this->template();
	}

	/**
     * 获取农场信息
     */
	public function getInfo()
	{
		global $_W;
		$where = array('uniacid' => $_W['uniacid']);
		$configInfo = pdo_get($this->table, $where);
		$configInfo['show_public_qrcode'] = tomedia($configInfo['public_qrcode']);
		$configInfo['show_logo'] = tomedia($configInfo['logo']);
		$configInfo['logo'] = tomedia($configInfo['logo']);
		$this->model->returnJson($configInfo);
	}
}

?>
