<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_chicken';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'openid', 'name', 'portrait', 'level', 'experience', 'accelerate', 'egg_stock', 'feed_stock', 'bowl_stock', 'integral', 'feeding_time', 'create_time');
	/**
     * 需要验证是否非空的字段以及其回复
     * @var array
     */
	private $message = array();

	/**
     * 用户统计首页
     */
	public function main()
	{
		global $_W;
		require_once $this->template();
	}

	/**
     * 查询当前所有用户
     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$currentPage = intval($_GPC['__input']['page']);
		$search = $_GPC['__input']['search'];
		$pageSize = 10;
		$sql = 'SELECT * FROM ' . tablename($this->table);
		$sql .= ' WHERE `uniacid` = ' . $_W['uniacid'] . ' ';

		if ($search) {
			$sql .= 'AND `name` LIKE "%' . $search . '%" ';
			$countSql = 'SELECT COUNT(*) as `count` FROM ' . tablename($this->table) . 'WHERE `name` LIKE "%' . $search . '%" ';
			$totalArr = pdo_fetchall($countSql);
			$total = $totalArr[0]['count'];
		}
		else {
			$total = pdo_count($this->table);
		}

		$sql .= ' ORDER BY `id` DESC ';
		$sql .= ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
		$list = pdo_fetchall($sql);
		$context = array('before' => 5, 'after' => 4, 'ajaxcallback' => true, 'callbackfuncname' => 'function.get_list');
		$pages = pagination($total, $currentPage, $pageSize, '', $context);
		$list = $this->model->forTomedia($list, 'portrait', 'show_portrait');
		$this->model->returnJson($list, $pages);
	}
}

?>
