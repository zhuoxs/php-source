<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		header('location: ' . webUrl('diypage/shop/page'));
	}

	public function page()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getPluginset('diypage');
		$home_list = $this->model->getPageList('allpage', ' and type=2 ');
		$home_list = $home_list['list'];
		$member_list = $this->model->getPageList('allpage', ' and type=3 ');
		$member_list = $member_list['list'];
		$commission_list = $this->model->getPageList('allpage', ' and type=4 ');
		$commission_list = $commission_list['list'];
		$detail_list = $this->model->getPageList('allpage', ' and type=5 ');
		$detail_list = $detail_list['list'];
		$creditshop_list = $this->model->getPageList('allpage', ' and type=6 ');
		$creditshop_list = $creditshop_list['list'];
		$seckill_list = $this->model->getPageList('allpage', ' and type=7 ');
		$seckill_list = $seckill_list['list'];
		$exchange_list = $this->model->getPageList('allpage', ' and type=8 ');
		$exchange_list = $exchange_list['list'];

		if ($_W['ispost']) {
			$diypage = $_GPC['page'];
			$data['page'] = $diypage;
			m('common')->updatePluginset(array('diypage' => $data));
			$plog = '保存商城 自定义页面: ';

			foreach ($data['page'] as $key => $val) {
				$plog .= $key . '=>' . $val . '; ';
			}

			plog('diypage.shop.page.save', $plog);
			show_json(1);
		}

		$pluginList = array(
			'commission' => array('status' => 0, 'list' => $commission_list),
			'creditshop' => array('status' => 0, 'list' => $creditshop_list),
			'seckill'    => array('status' => 0, 'list' => $seckill_list),
			'exchange'   => array('status' => 0, 'list' => $exchange_list)
			);
		$pluginAll = m('plugin')->getAll();

		if (empty($pluginAll)) {
			$pluginList = array();
		}
		else {
			foreach ($pluginAll as $plugin) {
				$identity = $plugin['identity'];
				if (isset($pluginList[$identity]) && empty($pluginList[$identity]['status'])) {
					$pluginList[$identity]['status'] = 1;
				}
			}
		}

		include $this->template();
	}

	public function menu()
	{
		global $_W;
		global $_GPC;
		$list = pdo_fetchall('select id, name from ' . tablename('ewei_shop_diypage_menu') . ' where merch=:merch and uniacid=:uniacid order by id desc', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$data = m('common')->getPluginset('diypage');

		if ($_W['ispost']) {
			$diymenu = $_GPC['menu'];
			$data['menu'] = $diymenu;
			m('common')->updatePluginset(array('diypage' => $data));
			$plog = '保存商城 自定义菜单: ';

			foreach ($data['menu'] as $key => $val) {
				$plog .= $key . '=>' . $val . '; ';
			}

			plog('diypage.shop.menu.save', $plog);
			show_json(1);
		}

		$pluginList = array('creditshop' => 0, 'commission' => 0, 'groups' => 0, 'mr' => 0, 'sns' => 0, 'sign' => 0, 'seckill' => 0, 'threen' => 0);
		$pluginAll = m('plugin')->getAll();

		if (empty($pluginAll)) {
			$pluginList = array();
		}
		else {
			foreach ($pluginAll as $plugin) {
				$identity = $plugin['identity'];
				if (isset($pluginList[$identity]) && empty($pluginList[$identity])) {
					$pluginList[$identity] = 1;
				}
			}
		}

		include $this->template();
	}

	public function followbar()
	{
		global $_W;
		global $_GPC;
		$diypagedata = m('common')->getPluginset('diypage');
		$diyfollowbar = $diypagedata['followbar'];
		$logo = $_W['shopset']['shop']['logo'];

		if ($_W['ispost']) {
			$data = $_GPC['data'];

			if (!empty($data)) {
				$diypagedata['followbar'] = $data;
				m('common')->updatePluginset(array('diypage' => $diypagedata));
				plog('diypage.shop.followbar.main', '编辑自定义关注条');
				show_json(1);
			}

			show_json(0, '数据错误，请刷新页面重试！');
		}

		include $this->template();
	}

	public function layer()
	{
		global $_W;
		global $_GPC;
		$diypagedata = m('common')->getPluginset('diypage');
		$diylayer = $diypagedata['layer'];

		if ($_W['ispost']) {
			$data = $_GPC['data'];

			if (!empty($data)) {
				$diypagedata['layer'] = $data;
				m('common')->updatePluginset(array('diypage' => $diypagedata));
				plog('diypage.shop.layer.main', '编辑自定义悬浮按钮');
				show_json(1);
			}

			show_json(0, '数据错误，请刷新页面重试！');
		}

		include $this->template();
	}

	public function adv()
	{
	}

	public function gotop()
	{
		global $_W;
		global $_GPC;
		$diypagedata = m('common')->getPluginset('diypage');
		$diygotop = $diypagedata['gotop'];

		if ($_W['ispost']) {
			$data = $_GPC['data'];

			if (!empty($data)) {
				$diypagedata['gotop'] = $data;
				m('common')->updatePluginset(array('diypage' => $diypagedata));
				plog('diypage.shop.layer.main', '编辑自定义悬浮按钮');
				show_json(1);
			}

			show_json(0, '数据错误，请刷新页面重试！');
		}

		include $this->template();
	}

	public function danmu()
	{
		global $_W;
		global $_GPC;
		$diypagedata = m('common')->getPluginset('diypage');
		$danmu = $diypagedata['danmu'];

		if ($_W['ispost']) {
			$data = $_GPC['data'];

			if (!empty($data)) {
				$diypagedata['danmu'] = $data;
				m('common')->updatePluginset(array('diypage' => $diypagedata));
				plog('diypage.shop.danmu.main', '编辑自定义悬浮按钮');
				show_json(1);
			}

			show_json(0, '数据错误，请刷新页面重试！');
		}

		include $this->template();
	}
}

?>
