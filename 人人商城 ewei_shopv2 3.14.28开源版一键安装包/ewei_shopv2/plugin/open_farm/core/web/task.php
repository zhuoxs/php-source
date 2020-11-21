<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Task_EweiShopV2Page extends PluginWebPage
{
	/**     * 当前数据表名称     * @var string     */
	private $table = 'ewei_open_farm_task';
	/**     * 当前类的所有字段     * @var array     */
	private $field = array('id', 'uniacid', 'logo', 'title', 'feed', 'get_max', 'start_time', 'end_time', 'category', 'core', 'order_feed', 'money_feed', 'goods_id', 'goods_feed', 'core_feed', 'member_level', 'member_level_feed', 'create_time');
	/**     * 需要验证是否非空的字段以及其回复     * @var array     */
	private $message = array('title' => '请输入任务标题', 'logo' => '请选择任务logo', 'category' => '请选择任务种类', 'get_max' => '请选择当前任务每天能够最多获取多少饲料', 'start_time' => '请选择开始时间', 'end_time' => '请选择结束时间');
	/**     * 需要验证是否非空的字段以及其回复     * @var array     */
	private $categoryMessage = array(
		'签到'       => array('feed' => '请填写签到所获取的饲料数'),
		'任务中心' => array('core_feed' => '请填写完成任务所获取的饲料数', 'core' => '请选择任务'),
		'购买商品' => array('goods_feed' => '请填写购买一个商品所获取的饲料数', 'goods_id' => '请选择商品'),
		'商城下单' => array('order_feed' => '请填写每单可获取的饲料数', 'money_feed' => '请填写多少元可获得一克饲料'),
		'会员领取' => array('member_level_feed' => '请填写会员一次可领取的饲料数', 'member_level' => '请选择会员等级')
	);
	/**     * 需要验证图片文件是否存在     * @var array     */
	private $imageArr = array('logo');

	/**     * 初始化配置类     * Task_EweiShopV2Page constructor.     * @param bool $_init     */
	public function __construct($_init = true)
	{
		parent::__construct($_init);
	}

	/**     * 首页主方法     */
	public function main()
	{
		global $_W;
		require_once $this->template();
	}

	/**     * 添加一条数据     */
	public function addInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$this->checkInfo($data);

		if (strtotime($data['end_time']) <= strtotime($data['start_time'])) {
			$this->model->returnJson(false, false, '开始时间不能大于或者等于结束时间');
		}

		$data = $this->model->removeUselessField($data, $this->field);
		$data['uniacid'] = $_W['uniacid'];
		$data['create_time'] = date('Y-m-d H:i:s');
		$where = array('id' => $data['id']);

		if ($data['id']) {
			$taskInfo = pdo_update($this->table, $data, $where);
		}
		else {
			$taskInfo = pdo_insert($this->table, $data);
		}

		$this->model->returnJson($taskInfo);
	}

	/**     * 获取任务信息     */
	public function getInfo()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$taskInfo = pdo_get($this->table, array('id' => $id));
		$this->model->returnJson($taskInfo);
	}

	/**     * 编辑任务信息     */
	public function editInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$this->checkInfo($data);
		$data = $this->model->removeUselessField($data, $this->field);
		$query = pdo_update($this->table, $data, array('id' => $data['id']));
		$this->model->returnJson($query);
	}

	/**     * 获取任务种类     */
	public function getCategory()
	{
		$table = 'ims_ewei_open_farm_task';
		$field = 'category';
		$categoryArr = $this->model->getEnumList($table, $field);
		$this->model->returnJson($categoryArr);
	}

	/**     * 获取所有用户等级     */
	public function getMemberLevel()
	{
		$taskArr = $this->model->getAllMemberLevel();
		$this->model->returnJson($taskArr);
	}

	/**     * 获取任务中心任务     */
	public function getTaskCore()
	{
		$taskArr = $this->model->getAllTask();
		$this->model->returnJson($taskArr);
	}

	/**     * 获取任务中心任务     */
	public function getGoods()
	{
		$taskArr = $this->model->getAllGoods();
		$this->model->returnJson($taskArr);
	}

	/**     * 删除任务     */
	public function deleteInfo()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['__input']['id'];
		$where = array('id' => $id);
		$query = pdo_delete($this->table, $where);
		$this->model->returnJson($query);
	}

	/**     * 验证提交数据     * @param $data     */
	private function checkInfo($data)
	{
		$this->model->checkDataRequired($data, $this->message);
		$field = 'category';
		$this->model->checkCarefulRequired($data, $field, $this->categoryMessage);
		$this->model->checkImageExists($data, $this->imageArr);
	}

	/**     * 任务列表     * Task_EweiShopV2Page constructor.     * @param     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$currentPage = intval($_GPC['__input']['page']);
		$search = $_GPC['__input']['search'];
		$pageSize = 10;
		$condition = array('uniacid' => $_W['uniacid']);
		$sql = 'SELECT * FROM ' . tablename($this->table) . ' WHERE `uniacid`=' . $_W['uniacid'];

		if ($search) {
			$sql .= ' AND `title` LIKE "%' . $search . '%" ';
			$countSql = 'SELECT COUNT(*) as `count` FROM ' . tablename($this->table) . 'WHERE `title` LIKE "%' . $search . '%" AND `uniacid`=' . $_W['uniacid'];
			$totalArr = pdo_fetchall($countSql, $condition);
			$total = $totalArr[0]['count'];
		}
		else {
			$total = pdo_count($this->table, $condition);
		}

		$sql .= ' ORDER BY `id` DESC ';
		$sql .= ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
		$list = pdo_fetchall($sql);
		$context = array('before' => 5, 'after' => 4, 'ajaxcallback' => true, 'callbackfuncname' => 'function.get_list');
		$pages = pagination($total, $currentPage, $pageSize, '', $context);
		$list = $this->getTaskName($list);
		$list = $this->model->forTomedia($list, 'logo', 'show_logo');
		$this->model->returnJson($list, $pages);
	}

	/**     * 查询任务名     * @param $data     * @return mixed     */
	private function getTaskName($data)
	{
		if (!$data || !(0 < count($data))) {
			return $data;
		}

		$idArr = array();

		foreach ($data as $key => $value) {
			if ($value['category'] === '任务中心') {
				if ($value['core']) {
					$idArr[] = $value['core'];
				}
			}
		}

		if (!$idArr || !(0 < count($idArr))) {
			return $data;
		}

		$idStr = implode(',', $idArr);
		$field = ' `id`,`title` ';
		$taskArr = pdo_fetchall(' SELECT ' . $field . ' FROM ' . tablename('ewei_shop_task_list') . (' WHERE `id` in(' . $idStr . ') '));

		foreach ($data as $key => $value) {
			foreach ($taskArr as $k => $v) {
				if ($value['value'] === $v['id']) {
					$data[$key]['task_name'] = $v['title'];
				}
			}
		}

		return $data;
	}
}

?>
