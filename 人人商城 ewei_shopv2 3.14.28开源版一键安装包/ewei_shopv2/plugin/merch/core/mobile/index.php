<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$mid = intval($_GPC['mid']);
		$merchid = intval($_GPC['merchid']);
		if (!$merchid || empty($this->merch_user)) {
			$this->message('没有找到此商户', '', 'error');
		}

		$this->diypage('home');
		$index_cache = $this->getpage($merchid);

		if (!empty($mid)) {
			$index_cache = preg_replace_callback('/href=[\\\'"]?([^\\\'" ]+).*?[\\\'"]/', function($matches) use($mid) {
				$preg = $matches[1];

				if (strexists($preg, 'mid=')) {
					return 'href=\'' . $preg . '\'';
				}

				if (!strexists($preg, 'javascript')) {
					$preg = preg_replace('/(&|\\?)mid=[\\d+]/', '', $preg);

					if (strexists($preg, '?')) {
						$newpreg = $preg . ('&mid=' . $mid);
					}
					else {
						$newpreg = $preg . ('?mid=' . $mid);
					}

					return 'href=\'' . $newpreg . '\'';
				}
			}, $index_cache);
		}

		$set = $this->model->getListUserOne($merchid);

		if (!empty($set)) {
			$_W['shopshare'] = array('title' => $set['merchname'], 'imgUrl' => tomedia($set['logo']), 'desc' => $set['desc'], 'link' => mobileUrl('merch', array('merchid' => $merchid), true));

			if (p('commission')) {
				$set = p('commission')->getSet();

				if (!empty($set['level'])) {
					$member = m('member')->getMember($_W['openid']);
					if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
						$_W['shopshare']['link'] = mobileUrl('merch', array('merchid' => $merchid, 'mid' => $member['id']), true);
					}
					else {
						if (!empty($mid)) {
							$_W['shopshare']['link'] = mobileUrl('merch', array('merchid' => $merchid, 'mid' => $mid), true);
						}
					}
				}
			}
		}

		include $this->template('index');
	}

	public function get_recommand()
	{
		global $_W;
		global $_GPC;
		$set = $this->model->getListUserOne(intval($_GPC['merchid']));

		if ($set['status'] == 1) {
			$args = array('page' => intval($_GPC['page']), 'pagesize' => 6, 'isrecommand' => 1, 'order' => 'displayorder desc,createtime desc', 'by' => '', 'merchid' => intval($_GPC['merchid']));
			$recommand = m('goods')->getList($args);
		}

		show_json(1, array('list' => $recommand['list'], 'pagesize' => $args['pagesize'], 'total' => $recommand['total'], 'page' => intval($_GPC['page'])));
	}

	private function getcache()
	{
		global $_W;
		global $_GPC;
		return m('common')->createStaticFile(mobileUrl('getpage', NULL, true));
	}

	public function getpage($merchid)
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$merchid = intval($merchid);
		$defaults = array(
			'adv'    => array('text' => '幻灯片', 'visible' => 1),
			'search' => array('text' => '搜索栏', 'visible' => 1),
			'nav'    => array('text' => '导航栏', 'visible' => 1),
			'notice' => array('text' => '公告栏', 'visible' => 1),
			'cube'   => array('text' => '魔方栏', 'visible' => 1),
			'banner' => array('text' => '广告栏', 'visible' => 1),
			'goods'  => array('text' => '推荐栏', 'visible' => 1)
			);
		$shop = p('merch')->getSet('shop', $merchid);
		$sorts = isset($shop['indexsort']) ? $shop['indexsort'] : $defaults;
		$sorts['recommand'] = array('text' => '系统推荐', 'visible' => 1);
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_merch_adv') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid, ':merchid' => $merchid));
		$navs = pdo_fetchall('select id,navname,url,icon from ' . tablename('ewei_shop_merch_nav') . ' where uniacid=:uniacid and merchid=:merchid and status=1 order by displayorder desc', array(':uniacid' => $uniacid, ':merchid' => $merchid));
		$cubes = is_array($shop['cubes']) ? $shop['cubes'] : array();
		$banners = pdo_fetchall('select id,bannername,link,thumb from ' . tablename('ewei_shop_merch_banner') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid, ':merchid' => $merchid));
		$bannerswipe = $shop['bannerswipe'];

		if (!empty($shop['indexrecommands'])) {
			$goodids = implode(',', $shop['indexrecommands']);

			if (!empty($goodids)) {
				$indexrecommands = pdo_fetchall('select id, title, thumb, marketprice, productprice, minprice, total from ' . tablename('ewei_shop_goods') . (' where id in( ' . $goodids . ' ) and uniacid=:uniacid and merchid=:merchid and status=1 order by instr(\'' . $goodids . '\',id),merchdisplayorder desc'), array(':uniacid' => $uniacid, ':merchid' => $merchid));
			}
		}

		$goodsstyle = $shop['goodsstyle'];
		$notices = pdo_fetchall('select id, title, link, thumb from ' . tablename('ewei_shop_merch_notice') . ' where uniacid=:uniacid and merchid=:merchid and status=1 order by displayorder desc limit 5', array(':uniacid' => $uniacid, ':merchid' => $merchid));
		ob_start();
		ob_implicit_flush(false);
		require $this->template('index_tpl');
		return ob_get_clean();
	}
}

?>
