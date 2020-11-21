<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once 'chicken.php';
require_once 'seting.php';
require_once 'presentation.php';
class Integral_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_integral';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'openid', 'nickname', 'integral', 'egg', 'receive', 'create_time');
	/**
     * 需要验证是否非空的字段以及其回复
     * @var array
     */
	private $message = array('egg' => '请输入蛋的数量', 'integral' => '请输入积分的数量');
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
     * 首页方法
     */
	public function main()
	{
		require_once $this->template();
	}

	/**
     * 获取信息
     */
	public function addInfo()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];
		$seting = new Seting_EweiShopV2Page();
		$setingInfo = $seting->getInfo(true);
		$chicken = new Chicken_EweiShopV2Page();
		$chickenInfo = $chicken->getInfo(true);

		if ($chickenInfo['egg_stock'] < $data['egg']) {
			$this->model->returnJson(false, false, '抱歉,您没有这么多鸡蛋!');
		}

		$data['integral'] = $data['egg'] * $setingInfo['rate'];
		$integralTable = 'ewei_open_farm_integral';
		$table = tablename($integralTable);
		$now = date('Y-m-d');
		$start = $now . ' 00:00:00';
		$end = $now . ' 23:59:59';
		$sql = ' SELECT * FROM ' . $table . ' ' . ' WHERE ' . (' `uniacid` = \'' . $_W['uniacid'] . '\' AND ') . (' `openid` = \'' . $_W['openid'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);
		$convertibility = 0;

		foreach ($query as $key => $value) {
			$convertibility += $value['integral'];
		}

		if ($setingInfo['exchange_integral_max'] < $convertibility + $data['integral']) {
			$this->model->returnJson(false, false, '兑换数量超过每天兑换上限 ' . $setingInfo['exchange_integral_max'] . ' 积分,今天已兑换' . $convertibility . ' 积分');
		}
		else {
			$data['uniacid'] = $_W['uniacid'];
			$data['openid'] = $_W['openid'];
			$weAccount = WeAccount::create();
			$userInfo = $weAccount->fansQueryInfo($_W['openid']);
			$data['nickname'] = $userInfo['nickname'];
			$data['receive'] = '否';
			$orderId = uniqid();
			m('member')->setCredit($_W['openid'], 'credit1', $data['integral'], array(0, '农场鸡蛋兑换'));
			$data['order_id'] = $orderId;
			$data['create_time'] = date('Y-m-d H:i:s');
			$this->checkInfo($data);
			$this->model->removeUselessField($data, $this->field);
			pdo_insert($this->table, $data);
			$chicken = new Chicken_EweiShopV2Page();
			$chicken->redEggs($data['egg']);
			$chicken->incIntegral($data['integral']);
			if ($data['egg'] && $data['integral']) {
				$presentation = new Presentation_EweiShopV2Page();
				$content = '主人主人,你成功使用' . $data['egg'] . '颗蛋兑换了' . $data['integral'] . '积哦~';
				$presentation->addInfo($content);
			}

			$this->model->returnJson(true, false, '兑换 ' . $data['integral'] . ' 积分成功!');
		}
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
