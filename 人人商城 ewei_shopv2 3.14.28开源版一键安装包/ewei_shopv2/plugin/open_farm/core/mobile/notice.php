<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Notice_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_notice';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'title', 'content', 'create_time');

	/**
     *公告列表
     * Task_EweiShopV2Page constructor.
     * @param
     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$condition = array('uniacid' => $_W['uniacid']);
		$currentPage = intval($_GPC['__input']['page']) ? intval($_GPC['__input']['page']) : 1;
		$pageSize = 10;

		try {
			$sql = 'SELECT * FROM ' . tablename($this->table) . 'WHERE `uniacid`=' . $_W['uniacid'];
			$sql .= ' ORDER BY id DESC ';
			$sql .= ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
			$noticeList = pdo_fetchall($sql, $condition);
			$this->model->returnJson($noticeList);
		}
		catch (Exception $e) {
			$this->model->errorMessage($_W['isajax'], $e->getMessage());
		}
	}
}

?>
