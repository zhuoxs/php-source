<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Notice_EweiShopV2Page extends PluginWebPage
{
	/**     * 当前数据表名称     * @var string     */
	private $table = 'ewei_open_farm_notice';
	/**     * 当前类的所有字段     * @var array     */
	private $field = array('id', 'uniacid', 'title', 'content', 'create_time');
	/**     * 需要验证是否非空的字段以及其回复     * @var array     */
	private $message = array('title' => '请填写公告标题', 'content' => '请填写公告内容');

	/**     * 首页主方法     */
	public function main()
	{
		global $_W;
		require_once $this->template();
	}

	/**     * 公告列表     * Notice_EweiShopV2Page constructor.     * @param     */
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
				$sql .= ' AND `title` LIKE \'%' . $search . '%\' OR `content` LIKE  \'%' . $search . '%\' ';
				$sqlcount = 'SELECT COUNT(*) AS `count` FROM ' . tablename($this->table) . (' WHERE `uniacid`=' . $_W['uniacid'] . ' AND( `title` LIKE "%' . $search . '%" OR `content` LIKE  "%' . $search . '%") ');
				$totalArr = pdo_fetchall($sqlcount);
				$total = $totalArr[0]['count'];
			}
			else {
				$total = pdo_count($this->table, $condition);
			}

			$sql .= ' ORDER BY id DESC ';
			$sql .= ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
			$noticeList = pdo_fetchall($sql, $condition);
			$pages = pagination($total, $currentPage, $pageSize, '', $context);
			$this->model->returnJson($noticeList, $pages);
		}
		catch (Exception $e) {
			$this->model->errorMessage($_W['isajax'], $e->getMessage());
		}
	}

	/**     * 新增，编辑一条     */
	public function addInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$where = array('id' => $data['id']);
		$data['uniacid'] = $_W['uniacid'];
		$data['create_time'] = date('Y-m-d H:i:s');
		$this->checkInfo($data);
		$data = $this->model->removeUselessField($data, $this->field);

		if ($data['id']) {
			$noticeAdd = pdo_update($this->table, $data, $where);
		}
		else {
			$noticeAdd = pdo_insert($this->table, $data);
		}

		$this->model->returnJson($noticeAdd);
	}

	/**     * 获取公告信息     */
	public function getInfo()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['__input']['id'];
		$noticeInfo = pdo_get($this->table, array('id' => $id));
		$this->model->returnJson($noticeInfo);
	}

	/**     * 删除公告     */
	public function deleteInfo()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['__input']['id'];
		$query = pdo_delete($this->table, array('id' => $id));
		$this->model->returnJson($query);
	}

	/**     * 删除多条公告     */
	public function deleteAll()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['ids'];
		$query = pdo_delete($this->table, array('id' => $id));
		show_json(1, '删除成功');
	}

	/**     * 验证提交数据     * @param $data     */
	private function checkInfo($data)
	{
		$this->model->checkDataRequired($data, $this->message);
	}
}

?>
