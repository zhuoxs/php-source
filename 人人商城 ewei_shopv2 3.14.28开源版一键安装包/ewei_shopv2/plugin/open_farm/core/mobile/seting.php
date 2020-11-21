<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Seting_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_seting';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'eat_time', 'time_steal', 'steal_eat_time', 'eat_tips', 'warehouse', 'bowl', 'lay_eggs_eat', 'lay_eggs_tips', 'lay_eggs_number_min', 'lay_eggs_number_max', 'obtain_feed_max', 'exchange_integral_max', 'feed_invalid_time', 'egg_invalid_time', 'eat_experience', 'rate', 'advertisement_max', 'surprised_probability', 'shop', 'create_time');

	/**
     * 主方法
     */
	public function main()
	{
		echo '商城配置';
	}

	/**
     * 获取农场设置信息
     * @param $method
     * @return bool
     */
	public function getInfo($method = false)
	{
		global $_W;
		$where = array('uniacid' => $_W['uniacid']);
		$info = pdo_get($this->table, $where);

		if ($method) {
			return $info;
		}

		$this->model->returnJson($info);
	}

	/**
     * 获取商城URL
     */
	public function getShopUrl()
	{
		global $_W;
		$where = array('uniacid' => $_W['uniacid']);
		$field = 'shop';
		$shopUrl = pdo_getcolumn($this->table, $where, $field);
		$this->model->returnJson($shopUrl);
	}
}

?>
