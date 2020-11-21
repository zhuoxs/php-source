<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		header('location: ' . webUrl('diypage'));
	}

	public function create()
	{
		global $_W;
		global $_GPC;
		$tid_member = pdo_fetchcolumn('select id from' . tablename('ewei_shop_diypage_template') . ' where tplid=9 limit 1');
		$tid_commission = pdo_fetchcolumn('select id from' . tablename('ewei_shop_diypage_template') . ' where tplid=15 order by id desc limit 1');
		$tid_detail = pdo_fetchcolumn('select id from' . tablename('ewei_shop_diypage_template') . ' where tplid=11 limit 1');
		$tid_seckill = pdo_fetchcolumn('select id from' . tablename('ewei_shop_diypage_template') . ' where tplid=12 limit 1');
		$tid_creditshop = pdo_fetchcolumn('select id from' . tablename('ewei_shop_diypage_template') . ' where tplid=13 limit 1');
		$tid_exchange = pdo_fetchcolumn('select id from' . tablename('ewei_shop_diypage_template') . ' where tplid=14 limit 1');
		include $this->template('diypage/page/create');
	}

	public function keyword()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$result = m('common')->keyExist($keyword);

			if (!empty($result)) {
				if ($result['name'] != 'ewei_shopv2:diypage:' . $id) {
					show_json(0);
				}
			}
		}

		show_json(1);
	}

	public function preview()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			header('location: ' . webUrl('diypage'));
		}

		$pagetype = '';
		$page = $this->model->getPage($id);

		if (!empty($page)) {
			if ($page['type'] == 1) {
				$pagetype = 'diy';
			}
			else {
				if (1 < $page['type'] && $page['type'] < 99) {
					$pagetype = 'sys';
				}
				else {
					if ($page['type'] == 99) {
						$pagetype = 'mod';
					}
				}
			}

			if ($page['type'] == 5) {
				$this->message('商品详情页涉及商品数据问题，请至手机端预览！', webUrl('diypage/page/sys'));
				exit();
			}
			else {
				if ($page['type'] == 7) {
					$this->message('秒杀专题页涉及商品数据问题，请至手机端预览！', webUrl('diypage/page/sys'));
					exit();
				}
			}
		}

		include $this->template();
	}
}

?>
