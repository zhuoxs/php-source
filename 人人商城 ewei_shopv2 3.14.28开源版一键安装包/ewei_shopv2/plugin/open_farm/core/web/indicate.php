<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Indicate_EweiShopV2Page extends PluginWebPage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_indicate';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'image', 'describe', 'create_time');
	/**
     * 需要验证是否非空的字段以及其回复
     * @var array
     */
	private $message = array('image' => '请上传指示图片', 'describe' => '请填写指导描述');

	/**
     * 初始化配置类
     * Configure_EweiShopV2Page constructor.
     * @param bool $_init
     */
	public function __construct($_init = true)
	{
		parent::__construct($_init);
	}

	/**
     * 首页主方法
     */
	public function main()
	{
		require_once $this->template();
	}

	/**
     * 新增或者更新一条数据
     */
	public function addInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$where = array('id' => $data['id']);
		$data['uniacid'] = $_W['uniacid'];
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

	/**
     * 获取按钮信息
     */
	public function getInfo()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['__input']['id'];
		$configInfo = pdo_get($this->table, array('id' => $id));
		$configInfo['show_image'] = tomedia($configInfo['image']);
		$this->model->returnJson($configInfo);
	}

	/**
     * 指导列表
     * indicate_EweiShopV2Page constructor.
     * @param
     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$condition = array('uniacid' => $_W['uniacid']);
		$currentPage = intval($_GPC['page']);
		$pageSize = 10;
		$context = array('before' => 5, 'after' => 4, 'ajaxcallback' => true, 'callbackfuncname' => 'function.get_list');

		try {
			$sql = 'SELECT * FROM ' . tablename($this->table) . 'WHERE `uniacid`=' . $_W['uniacid'];
			$sql .= ' ORDER BY id DESC ';
			$sql .= ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
			$indicateList = pdo_fetchall($sql, $condition);
			$total = pdo_count($this->table, $condition);
			$indicateList = $this->model->forTomedia($indicateList, 'image', 'show_image');
			$pages = pagination($total, $currentPage, $pageSize, '', $context);
			$this->model->returnJson($indicateList, $pages);
		}
		catch (Exception $e) {
			$this->model->errorMessage($_W['isajax'], $e->getMessage());
		}
	}

	/**
     * 删除按钮
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
     * 验证提交数据
     * @param $data
     */
	private function checkInfo($data)
	{
		$this->model->checkDataRequired($data, $this->message);
	}
}

?>
