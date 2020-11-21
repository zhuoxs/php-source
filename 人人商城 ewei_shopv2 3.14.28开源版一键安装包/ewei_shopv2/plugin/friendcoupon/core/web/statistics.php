<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Statistics_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = isset($_GPC['page']) ? max(1, intval($_GPC['page'])) : 1;
		$psize = 20;
		$keyword = isset($_GPC['keyword']) ? trim($_GPC['keyword']) : '';

		if (!empty($keyword)) {
			$condition = ' and title like \'%' . $keyword . '%\' ';
		}

		$list = pdo_fetchall('select id,uniacid,deleted,title,people_count,stop_time,create_time,coupon_money,launches_limit,status,launches_count from ' . tablename('ewei_shop_friendcoupon') . (' where 1 ' . $condition . ' and uniacid = :uniacid order by create_time desc limit ') . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('select count(1) from' . tablename('ewei_shop_friendcoupon') . (' where 1 ' . $condition . ' and uniacid = :uniacid'), array(':uniacid' => $_W['uniacid']));

		foreach ($list as &$item) {
			$peopleCount = $item['people_count'];
			$data = pdo_fetch('select sum(deduct) as total,count(id) as takePartPeopleCount from ' . tablename('ewei_shop_friendcoupon_data') . (' where activity_id = ' . $item['id'] . ' and openid <> \'\''));
			$item['successCount'] = floor(pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_friendcoupon_data') . ' where activity_id = :activity_id and status = 1', array(':activity_id' => $item['id'])) / $peopleCount);
			$item['total'] = number_format($item['successCount'] * $item['coupon_money'], 2);
			$item['takePartPeopleCount'] = !empty($data['takePartPeopleCount']) ? $data['takePartPeopleCount'] : 0;
		}

		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
