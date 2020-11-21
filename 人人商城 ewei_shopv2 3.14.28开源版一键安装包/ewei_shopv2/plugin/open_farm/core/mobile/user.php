<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class User_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_user';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'name', 'openid', 'tofakeid', 'follow', 'consume', 'parent_id', 'portrait', 'autograph', 'sex', 'birthday', 'distribution', 'create_time');

	/**
     * 获取用户信息
     * @param $method
     * @return bool
     */
	public function getInfo($method)
	{
		global $_W;
		$sql = 'SELECT * FROM ' . tablename($this->table) . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' AND `openid` = \'' . $_W['openid'] . '\' ');
		$info = pdo_fetch($sql);

		if ($method) {
			return $info;
		}

		$this->model->returnJson($info);
	}
}

?>
