<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Presentation_EweiShopV2Page extends PluginWebPage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_presentation';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'openid', 'content', 'create_time');
	/**
     * 需要验证是否非空的字段以及其报告
     * @var array
     */
	private $message = array('content' => '请填写回复内容');

	/**
     * 首页主方法
     */
	public function main()
	{
		require_once $this->template();
	}

	/**
     * 报告列表
     * Reply_EweiShopV2Page constructor.
     * @param
     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$condition = array('uniacid' => $_W['uniacid']);
		$search = $_GPC['__input']['search'];
		$currentPage = intval($_GPC['page']);
		$pageSize = 10;
		$context = array('before' => 5, 'after' => 4, 'ajaxcallback' => true, 'callbackfuncname' => 'function.get_list');

		try {
			$sql = 'SELECT * FROM ' . tablename($this->table) . 'WHERE `uniacid`=' . $_W['uniacid'];

			if ($search) {
				$sql .= ' AND `content` LIKE \'%' . $search . '%\' ';
				$sqlcount = 'SELECT COUNT(*) AS `count` FROM ' . tablename($this->table) . (' WHERE `uniacid`=' . $_W['uniacid'] . ' AND( `content` LIKE "%' . $search . '%") ');
				$totalArr = pdo_fetchall($sqlcount);
				$total = $totalArr[0]['count'];
			}
			else {
				$total = pdo_count($this->table, $condition);
			}

			$sql .= ' ORDER BY id DESC ';
			$sql .= ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
			$presentationList = pdo_fetchall($sql, $condition);
			$pages = pagination($total, $currentPage, $pageSize, '', $context);
			$this->model->returnJson($presentationList, $pages);
		}
		catch (Exception $e) {
			$this->model->errorMessage($_W['isajax'], $e->getMessage());
		}
	}

	/**
     * 添加一条，编辑一条
     * @param $data
     * @return bool
     */
	public function addInfo($data)
	{
		global $_W;
		global $_GPC;
		$data['uniacid'] = $_W['uniacid'];
		$this->checkInfo($data);
		$data['create_time'] = date('Y-m-d H:i:s');
		$data = $this->model->removeUselessField($data, $this->field);
		$presentationInfo = pdo_insert($this->table, $data);
		return $presentationInfo;
	}

	/**
     * 获取报告信息
     */
	public function getInfo()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['__input']['id'];
		$presentationInfo = pdo_get($this->table, array('id' => $id));
		$this->model->returnJson($presentationInfo);
	}

	/**
     * 删除报告
     */
	public function deleteInfo()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['__input']['id'];
		$query = pdo_delete($this->table, array('id' => $id));
		$this->model->returnJson($query);
	}

	/**
     * 删除多条报告
     */
	public function deleteAll()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['ids'];
		pdo_delete($this->table, array('id' => $id));
		show_json(1, '删除成功');
	}

	/**
     * 验证提交数据
     * @param $data
     */
	private function checkInfo($data)
	{
		$this->model->checkDataRequired($data, $this->message);
	}
}

?>
