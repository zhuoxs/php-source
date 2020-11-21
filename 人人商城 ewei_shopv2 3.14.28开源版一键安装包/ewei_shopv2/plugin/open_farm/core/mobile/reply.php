<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Reply_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_reply';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'brief_introduce', 'create_time');

	/**
     * 获取回复列表
     * presentation_EweiShopV2Page constructor.
     * @return void
     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$filed = ' `id`,`brief_introduce` ';
		$sql = 'SELECT ' . $filed . ' FROM ' . tablename($this->table);
		$sql .= ' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ';
		$list = pdo_fetchall($sql);
		$this->model->returnJson($list);
	}
}

?>
