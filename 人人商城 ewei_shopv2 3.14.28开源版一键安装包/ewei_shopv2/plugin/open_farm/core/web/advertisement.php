<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Advertisement_EweiShopV2Page extends PluginWebPage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_advertisement';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'name', 'logo', 'url', 'create_time');
	/**
     * 需要验证是否非空的字段以及其回复
     * @var array
     */
	private $message = array('name' => '请填写按钮名字', 'logo' => '请上传按钮图标', 'url' => '请填写跳转链接');

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
			$noticeInfo = pdo_update($this->table, $data, $where);
		}
		else {
			$noticeInfo = pdo_insert($this->table, $data);
		}

		$this->model->returnJson($noticeInfo);
	}

	/**
     * 首页主方法
     */
	public function main()
	{
		require_once $this->template();
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
		$configInfo['show_logo'] = tomedia($configInfo['logo']);
		$this->model->returnJson($configInfo);
	}

	/**
     * 按钮列表
     * Advertisement_EweiShopV2Page constructor.
     * @param
     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$condition = array('uniacid' => $_W['uniacid']);

		try {
			$sql = 'SELECT * FROM ' . tablename($this->table) . 'WHERE `uniacid`=' . $_W['uniacid'];
			$sql .= ' ORDER BY id DESC ';
			$advertisementList = pdo_fetchall($sql, $condition);
			$advertisementList = $this->model->forTomedia($advertisementList, 'logo', 'show_logo');
			$this->model->returnJson($advertisementList);
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
