<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Order_EweiShopV2Page extends PluginWebPage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_order';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'openid', 'username', 'market_id', 'market_title', 'receive', 'create_time');
	/**
     * 需要验证是否非空的字段以及其回复
     * @var array
     */
	private $message = array();

	/**
     * 订单统计首页
     */
	public function main()
	{
		require_once $this->template();
	}

	/**
     * 查询当前所有订单
     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$currentPage = intval($_GPC['__input']['page']);
		$pageSize = 10;
		$condition = array('uniacid' => $_W['uniacid']);
		$sql = 'SELECT * FROM ' . tablename($this->table);
		$total = pdo_count($this->table, $condition);
		$sql .= ' ORDER BY `id` DESC ';
		$sql .= ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
		$list = pdo_fetchall($sql);
		$context = array('before' => 5, 'after' => 4, 'ajaxcallback' => true, 'callbackfuncname' => 'function.get_list');
		$pages = pagination($total, $currentPage, $pageSize, '', $context);
		$this->model->returnJson($list, $pages);
	}
}

?>
