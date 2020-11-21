<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 100;
		$results = $this->model->get_Allcard($pindex, $psize);
		$list = array();
		$list = $results['list'];

		foreach ($list as $key => &$value) {
			$card_history = $this->model->getMembercard_order_history($value['id']);

			if ($card_history) {
				$kaitong = false;
			}
			else {
				$kaitong = true;
			}

			$expire_card_history = $card_history = $this->model->getExpireMembercard_order_history($value['id']);

			if ($expire_card_history) {
				$chongxin_kaitong = true;
			}
			else {
				$chongxin_kaitong = false;
			}

			$value['kaitong'] = $kaitong;
			$value['chongxin_kaitong'] = $chongxin_kaitong;
			$value['expire_time'] = $card_history['expire_time'];
			$list[$key] = $value;
		}

		$results_my = $this->model->get_Mycard('', 0, 100);

		if (empty($results_my['list']) != true) {
			$cate = 'my';
		}
		else {
			$cate = 'all';
		}

		$list_my = array();
		$list_my = $results_my['list'];
		include $this->template();
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$list = $this->model->get_Mycard('', 0, 100);

		foreach ($list['list'] as $key => $value) {
			$list['list'][$key]['expire_time'] = date('Y-m-d H:i', $value['expire_time']);

			if ($value['expire_time'] != '-1') {
				$list['list'][$key]['expire_time'] = date('Y-m-d H:i', $value['expire_time']);
			}
			else {
				$list['list'][$key]['expire_time'] = '-1';
			}
		}

		show_json(1, array('cards' => $list['list']));
	}

	public function picker()
	{
		include $this->template();
	}

	public function get_query()
	{
		global $_W;
		global $_GPC;
		$all_lists = $this->model->get_Allcard(1, 100);
		$my_lists = $this->model->get_Mycard('', 0, 100);
		show_json(1, array('all_counts' => count($all_lists['list']), 'my_counts' => count($my_lists['list'])));
	}
}

?>
