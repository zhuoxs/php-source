<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'commission/core/page_login_mobile.php';
class Rank_EweiShopV2Page extends CommissionMobileLoginPage
{
	private $commission_rank;
	private $len = 1;

	public function __construct()
	{
		global $_W;
		parent::__construct();
		$this->commission_rank = $_W['shopset']['commission']['rank'];
	}

	public function main()
	{
		global $_W;
		global $_GPC;

		if (empty($this->commission_rank)) {
			header('location: ' . mobileUrl('commission'));
			exit();
		}

		$commission_rank = $this->commission_rank;

		switch ($this->commission_rank['type']) {
		case '0':
			$user = pdo_fetch('SELECT id,uid,credit1,nickname,avatar,commission_total FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['mopenid']));
			$user['paiming'] = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND commission_total >= :commission_total', array(':uniacid' => $_W['uniacid'], ':commission_total' => $user['commission_total']));
			$commission_title = '累计佣金';
			break;

		case '1':
			$user = pdo_fetch('SELECT id,uid,credit1,nickname,avatar,commission_total FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['mopenid']));
			$result = pdo_fetchall('SELECT c.id,c.mid,SUM(c.commission_pay)  as commission_pay,m.nickname,m.avatar FROM ' . tablename('ewei_shop_commission_apply') . ' c LEFT JOIN ' . tablename('ewei_shop_member') . ' m ON c.mid=m.id WHERE c.uniacid = :uniacid AND c.status=3  GROUP BY c.mid ORDER BY commission_pay DESC LIMIT ' . intval($commission_rank['num']), array(':uniacid' => $_W['uniacid']));
			$paiming = 0;

			foreach ($result as $key => $val) {
				if ($val['mid'] == $user['id']) {
					$paiming += $key + 1;
				}
			}

			$user['paiming'] = empty($paiming) ? '未上榜' : $paiming;
			$commission_title = '已提现佣金';
			break;

		case '2':
			$user = pdo_fetch('SELECT id,uid,credit1,nickname,avatar,commission_total FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['mopenid']));
			$commission_title = $this->commission_rank['title'];
		}

		include $this->template();
	}

	public function ajaxpage()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, (int) $_GPC['page']);
		$psize = 20;

		if ($this->commission_rank['num'] <= $pindex * $psize) {
			$psize = $this->commission_rank['num'] % $psize == 0 ? 20 : $this->commission_rank['num'] % $psize;
			$pindex = ceil($this->commission_rank['num'] / $psize);
			$this->len = 0;
		}

		switch ($this->commission_rank['type']) {
		case '0':
			$this->commissionTotal($pindex, $psize);
			break;

		case '1':
			$this->commissionPay($pindex, $psize);
			break;

		case '2':
			$this->commissionVirtual($pindex, $psize);
			break;
		}
	}

	/**
     * 查询累计佣金排名
     * @param $pindex
     * @param $psize
     */
	protected function commissionTotal($pindex, $psize)
	{
		global $_W;
		$limit = ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$result = pdo_fetchall('SELECT id,uid,nickname,avatar,commission_total FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid ORDER BY commission_total DESC ' . $limit, array(':uniacid' => $_W['uniacid']));

		if (!empty($result)) {
			$result_tmp = array();

			foreach ($result as $val) {
				$val['commission_total'] = number_format($val['commission_total'], 2);
				$result_tmp[] = $val;
			}

			$result = $result_tmp;
		}

		show_json(1, array('list' => $result, 'len' => $this->len));
	}

	/**
     * 查询已提现佣金排名
     * @param $pindex
     * @param $psize
     */
	protected function commissionPay($pindex, $psize)
	{
		global $_W;
		$limit = ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$result = pdo_fetchall('SELECT c.id,c.mid,SUM(c.commission_pay)  as commission_pay,m.nickname,m.avatar FROM ' . tablename('ewei_shop_commission_apply') . ' c LEFT JOIN ' . tablename('ewei_shop_member') . ' m ON c.mid=m.id WHERE c.uniacid = :uniacid AND c.status=3  GROUP BY c.mid ORDER BY commission_pay DESC' . $limit, array(':uniacid' => $_W['uniacid']));

		if (!empty($result)) {
			$result_tmp = array();

			foreach ($result as $val) {
				$val['commission_total'] = number_format($val['commission_pay'], 2);
				$result_tmp[] = $val;
			}

			$result = $result_tmp;
		}

		show_json(1, array('list' => $result, 'len' => $this->len));
	}

	protected function commissionVirtual($pindex, $psize)
	{
		global $_W;

		if (!is_array($this->commission_rank['content'])) {
			$list = @json_decode($this->commission_rank['content'], true);
		}
		else {
			$list = $this->commission_rank['content'];
		}

		if (!empty($list)) {
			usort($list, function($a, $b) {
				$al = (int) $a['commission_total'];
				$bl = (int) $b['commission_total'];

				if ($al == $bl) {
					return 0;
				}

				return $bl < $al ? -1 : 1;
			});
			$list_tmp = array();

			foreach ($list as $val) {
				$val['commission_total'] = number_format($val['commission_total'], 2);
				$list_tmp[] = array('commission_total' => $val['commission_total'], 'nickname' => $val['nickname'], 'avatar' => tomedia($val['avatar']));
			}

			$list = array_slice($list_tmp, ($pindex - 1) * $psize, $psize);
		}

		show_json(1, array('list' => $list, 'len' => $this->len));
	}
}

?>
