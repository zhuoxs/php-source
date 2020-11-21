<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Grade_EweiShopV2Page extends PluginWebPage
{
	/**     * 当前数据表名称     * @var string     */
	private $table = 'ewei_open_farm_grade';
	/**     * 当前类的所有字段     * @var array     */
	private $field = array('id', 'uniacid', 'level', 'experience', 'accelerate', 'surprised_guard', 'create_time');
	/**     * 验证数据非空     * @var array     */
	private $message = array('level' => '请填写等级', 'experience' => '请填写当前等级所对应的经验', 'accelerate' => '请填写进食加速百分比', 'surprised_guard' => '请填写彩蛋守护时间');

	/**     * 首页主方法     */
	public function main()
	{
		global $_W;
		require_once $this->template();
	}

	/**     * 初始化等级类     * Configure_EweiShopV2Page constructor.     * @param bool $_init     */
	public function __construct($_init = true)
	{
		parent::__construct($_init);
	}

	/**     * 添加等级     */
	public function saveInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$data['uniacid'] = $_W['uniacid'];
		$data['create_time'] = date('Y-m-d H:i:s');
		$this->checkInfo($data);
		$data = $this->model->removeUselessField($data, $this->field);
		$where = array('level' => $data['level']);
		$info = pdo_get($this->table, $where);

		if ($info) {
			$query = pdo_update($this->table, $data, $where);
		}
		else {
			$query = pdo_insert($this->table, $data);
		}

		$this->model->returnJson($query);
	}

	/**     * 等级列表     * Grade_EweiShopV2Page constructor.     * @param     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$condition = array('uniacid' => $_W['uniacid']);
		$currentPage = $_GPC['__input']['page'] ? $_GPC['__input']['page'] : 1;
		$pageSize = 10;
		$sql = 'SELECT * FROM ' . tablename($this->table) . ' WHERE `uniacid`= ' . $_W['uniacid'];
		$sql .= ' ORDER BY `level` ASC ';
		$sql .= ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
		$total = pdo_count($this->table, $condition);
		$context = array('before' => 5, 'after' => 4, 'ajaxcallback' => true, 'callbackfuncname' => 'function.get_list');
		$pages = pagination($total, $currentPage, $pageSize, '', $context);
		$gradeList = pdo_fetchall($sql);
		$this->model->returnJson($gradeList, $pages);
	}

	public function addInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];

		foreach ($data as $key => $value) {
			$where = array('uniacid' => $_W['uniacid'], 'experience' => $value['experience'], 'accelerate' => $value['accelerate'], 'surprised_guard' => $value['surprised_guard']);
			pdo_update($this->table, $where, array('level' => $value['level']));
		}

		$this->model->returnJson(true);
	}

	/**     * 删除等级     */
	public function deleteInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$query = pdo_delete($this->table, $data);
		$this->model->returnJson($query);
	}

	/**     * 验证提交数据     * @param $data     */
	private function checkInfo($data)
	{
		$this->model->checkDataRequired($data, $this->message);
	}
}

?>
