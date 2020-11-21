<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'creditshop/core/page_mobile.php';
class Index_EweiShopV2Page extends CreditshopMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$this->diyPage('creditshop');
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$contation = ' uniacid=:uniacid ';

		if (0 < intval($_GPC['merchid'])) {
			$contation .= 'and merchid = ' . intval($_GPC['merchid']) . ' ';
		}

		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$shop = m('common')->getSysset('shop');
		$member = m('member')->getMember($openid);

		if (!empty($member)) {
			$levelid = intval($member['level']);
			$groupid = trim($member['groupid']);
			$contation .= ' and ( ifnull(showlevels,\'\')=\'\' or FIND_IN_SET( ' . $levelid . ',showlevels)<>0 ) ';

			if (strpos($groupid, ',') !== false) {
				$groupidArr = explode(',', $groupid);
				$groupidStr = '';

				foreach ($groupidArr as $grk => $grv) {
					$groupidStr .= 'INSTR( showgroups,\'' . $grv . '\')<>0 or ';

					if ($grk == count($groupidArr) - 1) {
						$groupidStr .= 'INSTR( showgroups,\'' . $grv . '\')<>0 ';
					}
				}

				$contation .= 'and ( ifnull(showgroups,\'\')=\'\' or  ' . $groupidStr . ' )';
			}
			else {
				$contation .= ' and ( ifnull(showgroups,\'\')=\'\' or FIND_IN_SET( \'' . $groupid . '\',showgroups)<>0 ) ';
			}
		}
		else {
			$contation .= ' and ifnull(showlevels,\'\')=\'\' ';
			$contation .= ' and   ifnull(showgroups,\'\')=\'\' ';
		}

		$advs = pdo_fetchall('select uniacid,id,advname,link,thumb from ' . tablename('ewei_shop_creditshop_adv') . ' where   uniacid = :uniacid and  enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$advs = set_medias($advs, 'thumb');
		$credit = m('member')->getCredit($openid, 'credit1');
		$category = array();

		if (0 < intval($_GPC['merchid'])) {
			$merch_category = p('merch')->getSet('merch_creditshop_category', $_GPC['merchid']);

			if (!empty($merch_category)) {
				$i = 0;

				foreach ($merch_category as $index => $row) {
					if (0 < $row) {
						$list = pdo_fetch('select id,name,thumb,isrecommand from ' . tablename('ewei_shop_creditshop_category') . '
						where id = ' . $index . ' and uniacid=:uniacid and  enabled=1 ', array(':uniacid' => $uniacid));
						$list = set_medias($list, 'thumb');
						$category[$i] = $list;
						++$i;
					}
				}
			}
		}
		else {
			$category = pdo_fetchall('select id,name,thumb,isrecommand from ' . tablename('ewei_shop_creditshop_category') . ' where uniacid=:uniacid and  enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
			$category = set_medias($category, 'thumb');
		}

		array_values($category);
		$lotterydraws = pdo_fetchall('select id, title,goodstype, subtitle, credit, money, thumb,`type`,price from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and `type` = 1 and  status=1 and deleted=0 order by displayorder,id desc limit 4', array(':uniacid' => $uniacid));
		$lotterydraws = set_medias($lotterydraws, 'thumb');
		is_array($lotterydraws) ? $lotterydraws : ($lotterydraws = array());

		foreach ($lotterydraws as $key => $value) {
			if (intval($value['money']) - $value['money'] == 0) {
				$lotterydraws[$key]['money'] = intval($value['money']);
			}
		}

		$exchanges = pdo_fetchall('select id, title,goodstype, subtitle, credit, money, thumb,`type`,showgroups,showlevels,buylevels,buygroups from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and goodstype = 0 and `type` = 0 and  status=1 and deleted=0 order by displayorder,id desc limit 4', array(':uniacid' => $uniacid));
		$exchanges = set_medias($exchanges, 'thumb');
		is_array($exchanges) ? $exchanges : ($exchanges = array());

		foreach ($exchanges as $key => $value) {
			if (intval($value['money']) - $value['money'] == 0) {
				$exchanges[$key]['money'] = intval($value['money']);
			}
		}

		$coupons = pdo_fetchall('select id, title, subtitle, credit, money, thumb,`type` from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and goodstype = 1 and `type` = 0 and  status=1 and deleted=0 order by displayorder,id desc limit 4', array(':uniacid' => $uniacid));
		$coupons = set_medias($coupons, 'thumb');
		is_array($coupons) ? $coupons : ($coupons = array());

		foreach ($coupons as $key => $value) {
			if (intval($value['money']) - $value['money'] == 0) {
				$coupons[$key]['money'] = intval($value['money']);
			}
		}

		$balances = pdo_fetchall('select id, title, subtitle, credit, money, thumb,`type` from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and goodstype = 2 and `type` = 0 and  status=1 and deleted=0 order by displayorder,id desc limit 4', array(':uniacid' => $uniacid));
		$balances = set_medias($balances, 'thumb');
		is_array($balances) ? $balances : ($balances = array());

		foreach ($balances as $key => $value) {
			if (intval($value['money']) - $value['money'] == 0) {
				$balances[$key]['money'] = intval($value['money']);
			}
		}

		$redbags = pdo_fetchall('select id, title, subtitle, credit, money, thumb,`type` from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and goodstype = 3 and `type` = 0 and  status=1 and deleted=0 order by displayorder,id desc limit 4', array(':uniacid' => $uniacid));
		$redbags = set_medias($redbags, 'thumb');
		is_array($redbags) ? $redbags : ($redbags = array());

		foreach ($redbags as $key => $value) {
			if (intval($value['money']) - $value['money'] == 0) {
				$redbags[$key]['money'] = intval($value['money']);
			}
		}

		$member = m('member')->getMember($openid);
		$_W['shopshare'] = array('title' => $this->set['share_title'], 'imgUrl' => tomedia($this->set['share_icon']), 'link' => mobileUrl('creditshop', array(), true), 'desc' => $this->set['share_desc']);
		$com = p('commission');

		if ($com) {
			$cset = $com->getSet();

			if (!empty($cset)) {
				if ($member['isagent'] == 1 && $member['status'] == 1) {
					$_W['shopshare']['link'] = mobileUrl('creditshop', array('mid' => $member['id']), true);
					if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
						$trigger = true;
					}
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('mid' => $_GPC['mid']), true);
					}
				}
			}
		}

		include $this->template();
	}
}

?>
