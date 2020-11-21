<?php
//QQ63779278
function ranksort1($a, $b)
{
	return $b['credit1'] < $a['credit1'] ? -1 : 1;
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Rank_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$rank = array('status' => intval($_GPC['status']), 'order_status' => intval($_GPC['order_status']), 'num' => empty($_GPC['num']) ? 50 : intval($_GPC['num']), 'order_num' => empty($_GPC['order_num']) ? 50 : intval($_GPC['order_num']));
			m('common')->updateSysset(array('rank' => $rank));
			plog('member.rank.edit', '修改积分排名设置');
			$result = pdo_fetchall('SELECT sm.id,sm.uid,m.credit1,sm.nickname,sm.avatar,sm.openid FROM ' . tablename('ewei_shop_member') . ' sm RIGHT JOIN ' . tablename('mc_members') . (' m ON m.uid=sm.uid WHERE sm.uniacid = :uniacid ORDER BY m.credit1 DESC LIMIT ' . $rank['num']), array(':uniacid' => $_W['uniacid']));
			$result1 = pdo_fetchall('SELECT id,uid,credit1,nickname,avatar,openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = :uniacid AND uid=0 ORDER BY credit1 DESC LIMIT ' . $rank['num']), array(':uniacid' => $_W['uniacid']));
			$result = array_merge($result, $result1);
			usort($result, 'ranksort1');
			$num = $rank['num'];
			$result = array_slice($result, 0, $num);
			m('cache')->set('member_rank', array('time' => TIMESTAMP + 3600, 'result' => $result));
			show_json(1);
		}

		$item = $_W['shopset']['rank'];
		$item['num'] = intval($item['num']);
		$item['order_num'] = intval($item['order_num']);
		$url_credit = mobileUrl('member/rank', array(), true);
		$qrcode_credit = m('qrcode')->createQrcode($url_credit);
		$url_money = mobileUrl('member/rank/order_rank', array(), true);
		$qrcode_money = m('qrcode')->createQrcode($url_money);
		include $this->template();
	}
}

?>
