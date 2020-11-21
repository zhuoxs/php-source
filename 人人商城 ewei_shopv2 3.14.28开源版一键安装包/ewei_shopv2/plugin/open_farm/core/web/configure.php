<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Configure_EweiShopV2Page extends PluginWebPage
{
	/**

     * 当前数据表名称

     * @var string

     */
	private $table = 'ewei_open_farm_configure';
	/**

     * 当前类的所有字段

     * @var array

     */
	private $field = array('id', 'uniacid', 'name', 'url', 'qrcode', 'keyword', 'title', 'logo', 'describe', 'public_qrcode', 'force_follow', 'create_time');
	/**

     * 需要验证是否非空的字段以及其回复

     * @var array

     */
	private $message = array('name' => '请填写农场名', 'qrcode' => '请上传公众号二维码', 'keyword' => '请填写关键字', 'title' => '请填写分享标题', 'logo' => '请上传分享图标', 'describe' => '请填写分享描述', 'public_qrcode' => '请上传公众号二维码', 'force_follow' => '请选择是否强制关注');
	/**

     * 需要验证是否非空的字段以及其回复

     * @var array

     */
	private $imageArr = array('public_qrcode', 'logo');

	/**

     * 初始化配置类

     * Configure_EweiShopV2Page constructor.

     * @param bool $_init

     */
	public function __construct($_init = true)
	{
		parent::__construct($_init);
		$this->addInfo();
	}

	/**

     * 首页主方法

     */
	public function main()
	{
		global $_W;
		require_once $this->template();
	}

	/**

     * 判断当前公众号是否已经有数据在数据库中

     * 若没有则添加

     */
	private function addInfo()
	{
		global $_W;
		$where = array('uniacid' => $_W['uniacid']);
		$url = mobileUrl('open_farm', NULL, true);
		$qrcode = m('qrcode')->createQrcode($url);
		$info = array('uniacid' => $_W['uniacid'], 'url' => $url, 'qrcode' => $qrcode);
		$configInfo = pdo_get($this->table, $where);

		if (!$configInfo) {
			pdo_insert($this->table, $info);
		}
	}

	/**

     * 获取农场信息

     */
	public function getInfo()
	{
		global $_W;
		$configInfo = pdo_get($this->table, array('uniacid' => $_W['uniacid']));
		$configInfo['show_public_qrcode'] = tomedia($configInfo['public_qrcode']);
		$configInfo['show_logo'] = tomedia($configInfo['logo']);
		$configInfo['url'] = mobileUrl('open_farm', NULL, true);
		$this->model->returnJson($configInfo);
	}

	/**

     * 编辑农场信息

     */
	public function editInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$this->checkInfo($data);
		$data = $this->model->removeUselessField($data, $this->field);
		$where = array('uniacid' => $_W['uniacid']);
		$query = pdo_update($this->table, $data, $where);

		if ($query !== false) {
			$this->setReplyKeywordRule($data);
		}

		$this->model->returnJson($query);
	}

	/**

     * 设置农场关键字

     * @param $configure

     */
	public function setReplyKeywordRule($configure)
	{
		global $_W;
		$rule = $this->getRule();
		$replyData = array('uniacid' => $_W['uniacid'], 'rid' => $rule['id'], 'module' => 'ewei_shopv2', 'title' => $configure['title'], 'description' => $configure['describe'], 'thumb' => $configure['logo'], 'url' => $configure['url']);
		$this->setReply($rule, $replyData);
		$keywordData = array('rid' => $rule['id'], 'uniacid' => $_W['uniacid'], 'module' => 'cover', 'content' => $configure['keyword'], 'type' => '1', 'status' => '1');
		$this->setKeyword($rule, $keywordData);
	}

	/**

     * 验证提交数据

     * @param $data

     */
	private function checkInfo($data)
	{
		$this->model->checkDataRequired($data, $this->message);
		$this->model->checkImageExists($data, $this->imageArr);
	}

	/**

     * @return bool

     */
	public function getRule()
	{
		global $_W;
		$table = 'rule';
		$data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:open:open_farm', 'module' => 'ewei_shopv2', 'status' => '1');
		$rule = pdo_get($table, $data);

		if (!$rule) {
			pdo_insert($table, $data);
			$id = pdo_insertid();
			$where = array('id' => $id);
			$rule = pdo_get($table, $where);
		}

		return $rule;
	}

	/**

     * 设置回复信息

     * @param $rule

     * @param array $data

     */
	public function setReply($rule, array $data)
	{
		global $_W;
		$table = 'cover_reply';
		$where = array('uniacid' => $_W['uniacid'], 'rid' => $rule['id']);
		$field = array('uniacid', 'rid', 'module', 'title', 'description', 'thumb', 'url');
		$reply = pdo_get($table, $where, $field);

		if (!$reply) {
			pdo_insert($table, $data);
			$id = pdo_insertid();
			$where = array('id' => $id);
			$reply = pdo_get($table, $where);
		}

		$dataSequence = serialize($data);
		$replySequence = serialize($reply);

		if ($dataSequence != $replySequence) {
			pdo_update($table, $data, $where);
		}
	}

	/**

     * 设置触发关键字

     * @param $rule

     * @param array $data

     */
	public function setKeyword($rule, array $data)
	{
		global $_W;
		$table = 'rule_keyword';
		$where = array('uniacid' => $_W['uniacid'], 'rid' => $rule['id']);
		$field = array('rid', 'uniacid', 'module', 'content', 'type', 'status');
		$keyword = pdo_get($table, $where, $field);

		if (!$keyword) {
			pdo_insert($table, $data);
			$id = pdo_insertid();
			$where = array('id' => $id);
			$keyword = pdo_get($table, $where);
		}

		$dataSequence = serialize($data);
		$keywordSequence = serialize($keyword);

		if ($dataSequence != $keywordSequence) {
			pdo_update($table, $data, $where);
		}
	}
}

?>
