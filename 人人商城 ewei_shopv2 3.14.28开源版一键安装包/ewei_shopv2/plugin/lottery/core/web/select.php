<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Select_EweiShopV2Page extends PluginWebPage
{
	public function query()
	{
		global $_W;
		global $_GPC;
		load()->func('logging');
		$type = trim($_GPC['type']);
		$title = trim($_GPC['title']);
		$page = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
		$psize = 8;

		if (!empty($type)) {
			if ($type == 'good') {
				$goodsgroup = intval($_GPC['goodsgroup']);
				$goodsgroup_where = '';

				if (!empty($goodsgroup)) {
					$goodsgroup_where = ' and (find_in_set(\'' . $goodsgroup . '\',ccates) or find_in_set(\'' . $goodsgroup . '\',pcates) or find_in_set(\'' . $goodsgroup . '\',tcates)) ';
				}

				$params = array(':title' => '%' . $title . '%', ':uniacid' => $_W['uniacid'], ':status' => '1');
				$totalsql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_goods') . ' WHERE `uniacid`= :uniacid and `status`=:status and `deleted`=0 AND merchid=0 AND title ' . $goodsgroup_where . ' LIKE :title ';
				$searchsql = 'SELECT id,title,productprice,marketprice,thumb,sales,unit,minprice,hasoption,`total`,`status`,`deleted` FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= :uniacid and `status`=:status and `deleted`=0 AND merchid=0 AND title ' . $goodsgroup_where . ' LIKE :title ORDER BY `status` DESC, `displayorder` DESC,`id` DESC LIMIT ' . ($page - 1) * $psize . ',' . $psize;
				$total = pdo_fetchcolumn($totalsql, $params);
				$pager = pagination2($total, $page, $psize, '', array('ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
				$list = pdo_fetchall($searchsql, $params);
				$spcSql = 'SELECT * FROM ' . tablename('ewei_shop_goods_option') . ' WHERE uniacid= :uniacid AND  goodsid= :goodsid';

				foreach ($list as $key => $value) {
					if ($value['hasoption']) {
						$spcwhere = array(':uniacid' => $_W['uniacid'], ':goodsid' => $value['id']);
						$spclist = pdo_fetchall($spcSql, $spcwhere);

						if (!empty($spclist)) {
							$list[$key]['spc'] = $spclist;
						}
						else {
							$list[$key]['spc'] = '';
						}
					}
				}

				$list = set_medias($list, 'thumb');
			}
			else {
				if ($type == 'coupon') {
					$params = array(':title' => '%' . $title . '%', ':uniacid' => $_W['uniacid']);
					$totalsql = 'select count(*) from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ';
					$searchsql = 'select id,couponname,coupontype,enough,thumb,backtype,deduct,backmoney,backcredit,`total`,backredpack,discount,displayorder from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ORDER BY `displayorder` DESC,`id` DESC LIMIT ' . ($page - 1) * $psize . ',' . $psize;
					$total = pdo_fetchcolumn($totalsql, $params);
					$pager = pagination2($total, $page, $psize, '', array('ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
					$list = pdo_fetchall($searchsql, $params);

					foreach ($list as &$d) {
						$d = com('coupon')->setCoupon($d, time(), false);
						$d['last'] = com('coupon')->get_last_count($d['id']);

						if ($d['last'] == -1) {
							$d['last'] = '不限';
						}
					}

					unset($d);
				}
			}
		}

		include $this->template('lottery/query/select_tpl');
	}
}

?>
