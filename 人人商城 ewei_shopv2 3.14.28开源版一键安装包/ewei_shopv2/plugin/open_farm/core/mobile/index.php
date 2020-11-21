<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 用户表名称
     * @var string
     */
	private $userTable = 'ewei_open_farm_user';
	/**
     * 用户鸡信息数据表名称
     * @var string
     */
	private $chickenTable = 'ewei_open_farm_chicken';
	/**
     * 默认openid
     * @var string
     */
	private $openid = '';

	/**
     * 初始化接口
     */
	public function __construct()
	{
		parent::__construct();
		global $_W;
		$_W['openid'] = $_W['openid'];
	}

	/**
     * 主方法
     */
	public function main()
	{
		global $_W;
		$this->authorization();
		$configInfo = pdo_get('ewei_open_farm_configure', array('uniacid' => $_W['uniacid']));
		$_W['shopshare'] = array('title' => !empty($configInfo['title']) ? $configInfo['title'] : '', 'imgUrl' => !empty($configInfo['logo']) ? tomedia($configInfo['logo']) : '', 'desc' => !empty($configInfo['describe']) ? $configInfo['describe'] : '', 'link' => mobileUrl('open_farm', NULL, true));
		include $this->template();
	}

	/**
     * 用户授权
     * 判断是否存在该用户
     */
	public function authorization()
	{
		global $_W;
		global $_GPC;
		$table = 'ewei_open_farm_configure';
		$where = array('uniacid' => $_W['uniacid']);
		$configure = pdo_get($table, $where);
		$weAccount = WeAccount::create();
		$userInfo = mc_oauth_userinfo();

		if (!$userInfo) {
			$userInfo = $weAccount->fansQueryInfo($_W['openid']);
		}

		if ($userInfo) {
			$user = $this->addInfo($userInfo);
			$chicken = $this->addChicken($userInfo);
		}
	}

	/**
     * 添加新用户
     * @param $userInfo
     * @return bool
     */
	public function addInfo($userInfo)
	{
		global $_W;
		global $_GPC;
		$where = array('openid' => $_W['openid']);
		$info = pdo_get($this->userTable, $where);

		if ($info) {
			$data = array('name' => $userInfo['nickname'], 'follow' => isset($_W['fans']['follow']) ? $_W['fans']['follow'] : 0, 'portrait' => $userInfo['headimgurl']);
			$query = pdo_update($this->userTable, $data, $where);
		}
		else {
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'name' => $userInfo['nickname'], 'portrait' => $userInfo['headimgurl'], 'follow' => isset($_W['fans']['follow']) ? $_W['fans']['follow'] : 0, 'sex' => $userInfo['sex'] === 1 ? '男' : '女', 'create_time' => date('Y-m-d H:i:s'));
			$query = pdo_insert($this->userTable, $data);
		}

		return $query;
	}

	/**
     * 添加鸡信息
     * @param $userInfo
     * @return bool
     */
	public function addChicken($userInfo)
	{
		global $_W;
		global $_GPC;
		$where = array('openid' => $_W['openid']);
		$info = pdo_get($this->chickenTable, $where);

		if ($info) {
			$data = array('name' => $userInfo['nickname'], 'portrait' => $userInfo['headimgurl']);
			$query = pdo_update($this->chickenTable, $data, $where);
		}
		else {
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'name' => $userInfo['nickname'], 'portrait' => $userInfo['headimgurl'], 'create_time' => date('Y-m-d H:i:s'));
			$query = pdo_insert($this->chickenTable, $data);
		}

		return $query;
	}
}

?>
