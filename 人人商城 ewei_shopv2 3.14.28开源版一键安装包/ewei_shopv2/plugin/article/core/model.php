<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

if (!class_exists('ArticleModel')) {
	class ArticleModel extends PluginModel
	{
		public function doShare($aid, $shareid, $myid)
		{
			global $_W;
			global $_GPC;
			if (empty($aid) || empty($shareid) || empty($myid) || $shareid == $myid) {
				return NULL;
			}

			$credittext = empty($_W['shopset']['trade']['credittext']) ? '积分' : $_W['shopset']['trade']['credittext'];
			$moneytext = empty($_W['shopset']['trade']['moneytext']) ? '余额' : $_W['shopset']['trade']['moneytext'];
			$article = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article') . ' WHERE id=:aid and article_state=1 and uniacid=:uniacid limit 1 ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));

			if (empty($article)) {
				return NULL;
			}

			$profile = m('member')->getMember($shareid);
			$myinfo = m('member')->getMember($myid);
			if (empty($myinfo) || empty($profile)) {
				return NULL;
			}

			$shopset = $_W['shopset'];
			$givecredit = intval($article['article_rule_credit']);
			$givemoney = floatval($article['article_rule_money']);
			$my_click = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and click_user=:click_user and uniacid=:uniacid ', array(':aid' => $article['id'], ':click_user' => $myid, ':uniacid' => $_W['uniacid']));

			if (!empty($my_click)) {
				$givecredit = intval($article['article_rule_credit2']);
				$givemoney = floatval($article['article_rule_money2']);
			}

			if (!empty($article['article_hasendtime']) && $article['article_endtime'] < time()) {
				return NULL;
			}

			$readtime = $article['article_readtime'];

			if ($readtime <= 0) {
				$readtime = 4;
			}

			$clicktime = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and share_user=:share_user and click_user=:click_user and uniacid=:uniacid ', array(':aid' => $article['id'], ':share_user' => $shareid, ':click_user' => $myid, ':uniacid' => $_W['uniacid']));

			if ($readtime <= $clicktime) {
				return NULL;
			}

			$all_click = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and share_user=:share_user and uniacid=:uniacid ', array(':aid' => $article['id'], ':share_user' => $shareid, ':uniacid' => $_W['uniacid']));

			if ($article['article_rule_allnum'] <= $all_click) {
				$givecredit = 0;
				$givemoney = 0;
			}
			else {
				$day_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				$day_end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
				$day_click = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and share_user=:share_user and click_date>:day_start and click_date<:day_end and uniacid=:uniacid ', array(':aid' => $article['id'], ':share_user' => $shareid, ':day_start' => $day_start, ':day_end' => $day_end, ':uniacid' => $_W['uniacid']));

				if ($article['article_rule_daynum'] <= $day_click) {
					$givecredit = 0;
					$givemoney = 0;
				}
			}

			$toto = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_share') . ' WHERE aid=:aid and share_user=:click_user and click_user=:share_user and uniacid=:uniacid ', array(':aid' => $article['id'], ':share_user' => $shareid, ':click_user' => $myid, ':uniacid' => $_W['uniacid']));

			if (!empty($toto)) {
				return NULL;
			}

			if (0 < $article['article_rule_credittotal'] || 0 < $article['article_rule_moneytotal']) {
				$creditlast = 0;
				$moneylast = 0;
				$firstreads = pdo_fetchcolumn('select count(distinct click_user) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $article['id'], ':uniacid' => $_W['uniacid']));
				$allreads = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $article['id'], ':uniacid' => $_W['uniacid']));
				$secreads = $allreads - $firstreads;

				if (0 < $article['article_rule_credittotal']) {
					if (!empty($article['article_advance'])) {
						$creditlast = $article['article_rule_credittotal'] - ($firstreads + ($article['article_virtualadd'] ? $article['article_readnum_v'] : 0)) * $article['article_rule_creditm'] - $secreads * $article['article_rule_creditm2'];
					}
					else {
						$creditout = pdo_fetchcolumn('select sum(add_credit) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $article['id'], ':uniacid' => $_W['uniacid']));
						$creditlast = $article['article_rule_credittotal'] - $creditout;
					}
				}

				if (0 < $article['article_rule_moneytotal']) {
					if (!empty($article['article_advance'])) {
						$moneylast = $article['article_rule_moneytotal'] - ($firstreads + ($article['article_virtualadd'] ? $article['article_readnum_v'] : 0)) * $article['article_rule_moneym'] - $secreads * $article['article_rule_moneym2'];
					}
					else {
						$moneyout = pdo_fetchcolumn('select sum(add_money) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $article['id'], ':uniacid' => $_W['uniacid']));
						$moneylast = $article['article_rule_moneytotal'] - $moneyout;
					}
				}

				$creditlast <= 0 && ($creditlast = 0);
				$moneylast <= 0 && ($moneylast = 0);

				if ($creditlast <= 0) {
					$givecredit = 0;
				}

				if ($moneylast <= 0) {
					$givemoney = 0;
				}
			}

			$insert = array('aid' => $article['id'], 'share_user' => $shareid, 'click_user' => $myid, 'click_date' => time(), 'add_credit' => $givecredit, 'add_money' => $givemoney, 'uniacid' => $_W['uniacid']);
			pdo_insert('ewei_shop_article_share', $insert);

			if (0 < $givecredit) {
				m('member')->setCredit($profile['openid'], 'credit1', $givecredit, array(0, $shopset['name'] . ' 文章营销奖励积分'));
			}

			if (0 < $givemoney) {
				m('member')->setCredit($profile['openid'], 'credit2', $givemoney, array(0, $shopset['name'] . ' 文章营销奖励余额'));
			}

			if (0 < $givecredit || 0 < $givemoney) {
				$article_sys = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article_sys') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));
				$detailurl = mobileUrl('member', NULL, true);
				$p = '';

				if (0 < $givecredit) {
					$p .= $givecredit . ('个' . $credittext . '、');
				}

				if (0 < $givemoney) {
					$p .= $givemoney . ('元' . $moneytext);
				}

				$datas = array(
					array('name' => '昵称', 'value' => $profile['nickname']),
					array('name' => '任务名称', 'value' => '分享得奖励'),
					array('name' => '通知类型', 'value' => '用户通过您的分享进入文章《' . $article['article_title'] . '》，系统奖励您' . $p . '。'),
					array('name' => '完成时间', 'value' => date('Y-m-d H:i', time())),
					array('name' => '备注', 'value' => '奖励已发放成功，请到会员中心查看。')
				);
				$remark = '
<a href=\'' . $detailurl . '\'>点击进入查看奖励详情</a>';
				$text = '亲爱的[昵称]，用户通过您的分享进入文章《' . $article['article_title'] . '》，系统奖励您' . $p . '。' . $remark;
				$message = array(
					'first'    => array('value' => '您的奖励已到帐！', 'color' => '#4a5077'),
					'keyword2' => array('title' => '处理进度', 'value' => '分享得奖励', 'color' => '#4a5077'),
					'keyword3' => array('title' => '处理内容', 'value' => '用户通过您的分享进入文章《' . $article['article_title'] . '》，系统奖励您' . $p . '。', 'color' => '#4a5077'),
					'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
					'remark'   => array('value' => '奖励已发放成功，请到会员中心查看。', 'color' => '#4a5077')
				);

				if (empty($article_sys['article_close_advanced'])) {
					m('notice')->sendNotice(array('openid' => $profile['openid'], 'tag' => 'article', 'default' => $message, 'cusdefault' => $text, 'url' => $detailurl, 'datas' => $datas, 'plugin' => 'article'));
				}
			}
		}

		public function mid_replace($content)
		{
			global $_GPC;
			preg_match_all('/href\\=["|\\\'](.*?)["|\\\']/is', $content, $links);

			foreach ($links[1] as $key => $lnk) {
				$newlnk = $this->href_replace($lnk);
				$content = str_replace($links[0][$key], 'href="' . $newlnk . '"', $content);
			}

			return $content;
		}

		public function href_replace($lnk)
		{
			global $_GPC;
			$newlnk = $lnk;
			if (strexists($lnk, 'ewei_shop') && !strexists($lnk, '&mid')) {
				if (strexists($lnk, '?')) {
					$newlnk = $lnk . '&mid=' . intval($_GPC['mid']);
				}
				else {
					$newlnk = $lnk . '?mid=' . intval($_GPC['mid']);
				}
			}

			return $newlnk;
		}

		public function perms()
		{
			return array(
				'article' => array(
					'text'     => $this->getName(),
					'isplugin' => true,
					'child'    => array(
						'cate' => array('text' => '分类设置', 'addcate' => '添加分类-log', 'editcate' => '编辑分类-log', 'delcate' => '删除分类-log'),
						'page' => array('text' => '文章设置', 'add' => '添加文章-log', 'edit' => '修改文章-log', 'delete' => '删除文章-log', 'showdata' => '查看数据统计', 'otherset' => '其他设置', 'report' => '举报记录')
					)
				)
			);
		}
	}
}

?>
