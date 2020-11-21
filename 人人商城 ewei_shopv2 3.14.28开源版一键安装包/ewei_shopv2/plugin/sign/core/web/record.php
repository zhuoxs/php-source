<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Record_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$aid = intval($_GPC['aid']);
		$page = ((empty($_GPC['page']) ? '' : $_GPC['page']));
		$pindex = max(1, intval($page));
		$psize = 20;
		$type = trim($_GPC['type']);
		empty($type) && ($type = 'read');
		$article = pdo_fetch('SELECT a.*,c.category_name FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category  WHERE a.id=:aid and a.uniacid= :uniacid LIMIT 1 ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
		$firstreads = pdo_fetchcolumn('select count(distinct click_user) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
		$allreads = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
		$secreads = $allreads - $firstreads;
		$add_credit = pdo_fetchcolumn('SELECT sum(add_credit) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and uniacid=:uniacid ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
		$add_money = pdo_fetchcolumn('SELECT sum(add_money) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and uniacid=:uniacid ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
		$add_credit1 = 0;
		$add_money1 = 0;

		if ($article['article_advance']) {
			if (0 < $article['article_rule_credittotal']) {
				$add_credit1 = (($firstreads + (($article['article_virtualadd'] ? $article['article_readnum_v'] : 0))) * $article['article_rule_creditm']) + ($secreads * $article['article_rule_creditm2']);
			}


			if (0 < $article['article_rule_moneytotal']) {
				$add_money1 = (($firstreads + (($article['article_virtualadd'] ? $article['article_readnum_v'] : 0))) * $article['article_rule_moneym']) + ($secreads * $article['article_rule_moneym2']);
			}

		}


		$add_credit = pdo_fetchcolumn('SELECT sum(add_credit) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and uniacid=:uniacid ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
		$add_money = pdo_fetchcolumn('SELECT sum(add_money) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and uniacid=:uniacid ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));

		if ($type == 'read') {
			$list_reads = pdo_fetchall('SELECT l.id,l.aid,l.read,l.like,u.nickname,u.uid, u.id as mid FROM ' . tablename('ewei_shop_article_log') . ' l left join ' . tablename('ewei_shop_member') . ' u on u.openid=l.openid WHERE l.aid=:aid and l.uniacid=:uniacid and u.uniacid=:uniacid order by l.id desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_log') . ' WHERE aid=:aid and uniacid=:uniacid ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
			$pager = pagination($total, $pindex, $psize);
		}
		 else {
			$list_shares = pdo_fetchall('SELECT s.id,s.click_date,s.add_credit,s.add_money, u.nickname as share_user,c.nickname as click_user, c.id as click_id, u.id as share_id FROM ' . tablename('ewei_shop_article_share') . ' s left join ' . tablename('ewei_shop_member') . ' u on u.id=s.share_user left join ' . tablename('ewei_shop_member') . ' c on c.id=s.click_user  WHERE s.aid=:aid and s.uniacid=:uniacid order by s.id desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and uniacid=:uniacid ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
			$pager = pagination($total, $pindex, $psize);
		}

		include $this->template();
	}
}


?>