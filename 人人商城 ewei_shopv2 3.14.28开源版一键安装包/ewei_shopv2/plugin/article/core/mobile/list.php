<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class List_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$article_sys = pdo_fetch('select * from' . tablename('ewei_shop_article_sys') . 'where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		$article_sys['article_image'] = tomedia($article_sys['article_image']);

		if ($article_sys['article_temp'] == 2) {
			$categorys = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_article_category') . ' WHERE uniacid=:uniacid and isshow=1 order by displayorder desc ', array(':uniacid' => $_W['uniacid']));
		}

		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$page = intval($_GPC['page']);
		$article_sys = pdo_fetch('select * from' . tablename('ewei_shop_article_sys') . 'where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		$article_sys['article_image'] = tomedia($article_sys['article_image']);
		$pindex = max(1, $page);
		$psize = empty($article_sys['article_shownum']) ? '20' : $article_sys['article_shownum'];

		if ($article_sys['article_temp'] == 0) {
			$articles = pdo_fetchall('SELECT a.id, a.article_title, a.resp_img, a.article_rule_credit, a.article_rule_money, a.resp_desc, a.article_category FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category  WHERE a.article_state=1 and article_visit=0 and c.isshow=1 and a.uniacid= :uniacid order by a.displayorder desc, a.article_date desc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $_W['uniacid']));
		}
		else if ($article_sys['article_temp'] == 1) {
			$articles = pdo_fetchall('SELECT distinct article_date_v FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and c.isshow=1 and a.uniacid=:uniacid order by a.article_date_v desc limit ' . (($pindex - 1) * $psize . ',' . $psize), array(':uniacid' => $_W['uniacid']), 'article_date_v');

			foreach ($articles as &$a) {
				$a['articles'] = pdo_fetchall('SELECT id,article_title,article_date_v,resp_img,resp_desc,article_date_v,resp_desc,article_category FROM ' . tablename('ewei_shop_article') . ' WHERE article_state=1 and uniacid=:uniacid and article_date_v=:article_date_v order by article_date desc ', array(':uniacid' => $_W['uniacid'], ':article_date_v' => $a['article_date_v']));
			}

			unset($a);
		}
		else {
			if ($article_sys['article_temp'] == 2) {
				$cate = intval($_GPC['cateid']);
				$where = '';

				if (0 < $cate) {
					$where = ' and article_category=' . $cate . ' ';
				}

				$articles = pdo_fetchall('SELECT a.id, a.article_title, a.resp_img, a.article_rule_credit, a.article_rule_money, a.article_author, a.article_date_v, a.resp_desc, a.article_category FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and c.isshow=1 and a.uniacid=:uniacid ' . $where . ' order by a.displayorder desc, a.article_date_v desc limit ' . (($pindex - 1) * $psize . ',' . $psize), array(':uniacid' => $_W['uniacid']));
			}
		}

		if (!empty($articles)) {
			include $this->template('article/list_tpl');
		}
	}
}

?>
