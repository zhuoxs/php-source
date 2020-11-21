<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$select_category = empty($_GPC['category']) ? '' : ' and a.article_category=' . intval($_GPC['category']) . ' ';
		$select_title = empty($_GPC['keyword']) ? '' : ' and a.article_title LIKE \'%' . $_GPC['keyword'] . '%\' ';
		$page = empty($_GPC['page']) ? '' : $_GPC['page'];
		$pindex = max(1, intval($page));
		$psize = 20;
		$articles = array();
		$articles = pdo_fetchall('SELECT a.id,a.displayorder, a.article_title,a.article_category,a.article_keyword2,a.article_date,a.article_readnum,a.article_likenum,a.article_state,c.category_name FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category  WHERE a.uniacid= :uniacid ' . $select_title . $select_category . ' order by displayorder desc,article_date desc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category  WHERE a.uniacid= :uniacid ' . $select_title . $select_category, array(':uniacid' => $_W['uniacid']));
		$pager = pagination2($total, $pindex, $psize);

		if (!empty($articles)) {
			foreach ($articles as $key => &$value) {
				$url = mobileUrl('article', array('aid' => $value['id']), true);
				$value['qrcode'] = m('qrcode')->createQrcode($url);
			}
		}

		$articlenum = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article') . ' WHERE uniacid= :uniacid ', array(':uniacid' => $_W['uniacid']));
		$categorys = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_article_category') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$aid = intval($_GPC['aid']);

		if ($_W['ispost']) {
			$article = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article') . ' WHERE id=:aid and uniacid=:uniacid limit 1 ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
			$data = array('article_title' => trim($_GPC['article_title']), 'resp_desc' => trim($_GPC['resp_desc']), 'resp_img' => trim($_GPC['resp_img']), 'article_content' => m('common')->html_images($_GPC['editor'], true), 'article_category' => intval($_GPC['article_category']), 'article_date_v' => trim($_GPC['article_date_v']), 'article_mp' => trim($_GPC['article_mp']), 'article_author' => trim($_GPC['article_author']), 'article_readnum_v' => intval($_GPC['article_readnum_v']), 'article_likenum_v' => intval($_GPC['article_likenum_v']), 'article_linkurl' => trim($_GPC['article_linkurl']), 'article_rule_daynum' => trim($_GPC['article_rule_daynum']), 'article_rule_allnum' => trim($_GPC['article_rule_allnum']), 'article_rule_credit' => intval($_GPC['article_rule_credit']), 'article_rule_money' => trim($_GPC['article_rule_money']), 'page_set_option_nocopy' => intval($_GPC['page_set_option_nocopy']), 'page_set_option_noshare_tl' => intval($_GPC['page_set_option_noshare_tl']), 'page_set_option_noshare_msg' => intval($_GPC['page_set_option_noshare_msg']), 'article_keyword2' => trim($_GPC['article_keyword2']), 'article_report' => intval($_GPC['article_report']), 'product_advs_type' => intval($_GPC['product_advs_type']), 'product_advs_title' => trim($_GPC['product_advs_title']), 'product_advs_more' => trim($_GPC['product_advs_more']), 'product_advs_link' => trim($_GPC['product_advs_link']), 'article_state' => intval($_GPC['article_state']), 'uniacid' => $_W['uniacid'], 'article_rule_credittotal' => intval($_GPC['article_rule_credittotal']), 'article_rule_moneytotal' => trim($_GPC['article_rule_moneytotal']), 'article_rule_credit2' => intval($_GPC['article_rule_credit2']), 'article_rule_money2' => trim($_GPC['article_rule_money2']), 'article_rule_creditm' => intval($_GPC['article_rule_creditm']), 'article_rule_moneym' => trim($_GPC['article_rule_moneym']), 'article_rule_creditm2' => intval($_GPC['article_rule_creditm2']), 'article_rule_moneym2' => trim($_GPC['article_rule_moneym2']), 'article_readtime' => trim($_GPC['article_readtime']), 'article_areas' => trim($_GPC['article_areas']), 'article_endtime' => strtotime($_GPC['article_endtime']), 'article_hasendtime' => intval($_GPC['article_hasendtime']), 'displayorder' => intval($_GPC['displayorder']), 'article_advance' => intval($_GPC['article_advance']), 'article_virtualadd' => intval($_GPC['article_virtualadd']), 'article_visit' => intval($_GPC['article_visit']), 'article_visit_level' => iserializer($_GPC['article_visit_level']), 'article_visit_tip' => iserializer($_GPC['article_visit_tip']));
			$advs = array();

			if (is_array($_GPC['adv_img'])) {
				foreach ($_GPC['adv_img'] as $key => $img) {
					if (empty($img)) {
						continue;
					}

					$advs[] = array('img' => trim($img), 'link' => $_GPC['adv_link'][$key]);
				}
			}

			$data['product_advs'] = json_encode($advs);

			if (!empty($data['article_keyword2'])) {
				$keyword = m('common')->keyExist($data['article_keyword2']);

				if (!empty($keyword)) {
					if ($keyword['name'] != 'ewei_shopv2:article:' . $aid) {
						show_json(0, '关键字"' . $data['article_keyword2'] . '"已存在!');
					}
				}
			}

			if (empty($aid)) {
				$data['article_date'] = date('Y-m-d H:i:s');
				pdo_insert('ewei_shop_article', $data);
				$aid = pdo_insertid();
				plog('article.add', '添加文章 ID: ' . $aid . ' 标题: ' . $data['article_title']);
			}
			else {
				pdo_update('ewei_shop_article', $data, array('id' => $aid));
				plog('article.edit', '编辑文章 ID: ' . $aid . ' 标题: ' . $article['article_title']);
			}

			if (!empty($data['article_keyword2'])) {
				$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:article:' . $aid));

				if (!empty($rule)) {
					pdo_update('rule_keyword', array('content' => trim($data['article_keyword2'])), array('rid' => $rule['id']));
				}
				else {
					$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:article:' . $aid, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
					pdo_insert('rule', $rule_data);
					$rid = pdo_insertid();
					$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => trim($data['article_keyword2']), 'type' => 1, 'displayorder' => 0, 'status' => 1);
					pdo_insert('rule_keyword', $keyword_data);
				}
			}
			else {
				$this->delKey($article['article_keyword2']);
			}

			show_json(1, array('url' => webUrl('article/edit', array('aid' => $aid, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$categorys = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_article_category') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$article = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article') . ' WHERE id=:aid and uniacid=:uniacid limit 1 ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));

		if (!empty($article)) {
			$article['product_advs'] = htmlspecialchars_decode($article['product_advs']);
			$advs = json_decode($article['product_advs'], true);
			$article['article_visit_level'] = iunserializer($article['article_visit_level']);
			$article['article_visit_tip'] = iunserializer($article['article_visit_tip']);
			$article['article_rule_creditlast'] = 0;
			$article['article_rule_moneylast'] = 0;
			$article['article_rule_creditreallast'] = 0;
			$article['article_rule_moneyreallast'] = 0;
			if (0 < $article['article_rule_credittotal'] || 0 < $article['article_rule_moneytotal']) {
				$firstreads = pdo_fetchcolumn('select count(distinct click_user) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
				$allreads = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
				$secreads = $allreads - $firstreads;

				if (0 < $article['article_rule_credittotal']) {
					$creditout = pdo_fetchcolumn('select sum(add_credit) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
					$article['article_rule_creditreallast'] = $article['article_rule_credittotal'] - $creditout;
					$article['article_rule_creditreallast'] <= 0 && $article['article_rule_creditreallast'] = 0;

					if (!empty($article['article_advance'])) {
						$article['article_rule_creditlast'] = $article['article_rule_credittotal'] - ($firstreads + (empty($article['article_virtualadd']) ? 0 : $article['article_readnum_v'])) * $article['article_rule_creditm'] - $secreads * $article['article_rule_creditm2'];
						$article['article_rule_creditlast'] <= 0 && $article['article_rule_creditlast'] = 0;
					}
				}

				if (0 < $article['article_rule_moneytotal']) {
					$moneyout = pdo_fetchcolumn('select sum(add_money) from ' . tablename('ewei_shop_article_share') . ' where aid=:aid and uniacid=:uniacid limit 1', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));
					$article['article_rule_moneyreallast'] = $article['article_rule_moneytotal'] - $moneyout;
					$article['article_rule_moneyreallast'] <= 0 && $article['article_rule_moneyreallast'] = 0;

					if (!empty($article['article_advance'])) {
						$article['article_rule_moneylast'] = $article['article_rule_moneytotal'] - ($firstreads + (empty($article['article_virtualadd']) ? 0 : $article['article_readnum_v'])) * $article['article_rule_moneym'] - $secreads * $article['article_rule_moneym2'];
						$article['article_rule_moneylast'] <= 0 && $article['article_rule_moneylast'] = 0;
					}
				}
			}

			$article['article_content'] = m('common')->html_to_images($article['article_content']);
		}

		$mp = pdo_fetch('SELECT acid,uniacid,name FROM ' . tablename('account_wechats') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$article_sys = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article_sys') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));
		$levels = array();
		$levels['member'] = m('member')->getLevels(false);
		array_unshift($levels['member'], array('id' => 'default', 'levelname' => '默认等级'));

		if (p('commission')) {
			$levels['commission'] = p('commission')->getLevels(true, true);
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,article_title,article_keyword2 FROM ' . tablename('ewei_shop_article') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_article', array('id' => $item['id']));
			$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and module=:module and uniacid=:uniacid limit 1 ', array(':content' => $item['article_keyword2'], ':module' => 'ewei_shopv2', ':uniacid' => $_W['uniacid']));

			if (!empty($keyword)) {
				pdo_delete('rule_keyword', array('id' => $keyword['id']));
				pdo_delete('rule', array('id' => $keyword['rid']));
			}

			pdo_delete('ewei_shop_article_log', array('aid' => $item['id']));
			pdo_delete('ewei_shop_article_share', array('aid' => $item['id']));
			plog('article.delete', '删除文章 ID: ' . $item['id'] . ' 标题: ' . $item['article_title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,article_title FROM ' . tablename('ewei_shop_article') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($item)) {
			pdo_update('ewei_shop_article', array('displayorder' => $displayorder), array('id' => $id));
			plog('article.edit', '修改文章排序 ID: ' . $item['id'] . ' 标题: ' . $item['article_title'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function state()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,article_title FROM ' . tablename('ewei_shop_article') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_article', array('article_state' => intval($_GPC['state'])), array('id' => $item['id']));
			plog('article.edit', '修改文章状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['article_title'] . '<br/>状态: ' . $_GPC['state'] == 1 ? '开启' : '关闭');
		}

		show_json(1, array('url' => referer()));
	}

	protected function delKey($keyword)
	{
		global $_W;

		if (empty($keyword)) {
			return NULL;
		}

		$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and `module`=:module and uniacid=:uniacid limit 1 ', array(':content' => $keyword, ':module' => 'ewei_shopv2', ':uniacid' => $_W['uniacid']));

		if (!empty($keyword)) {
			pdo_delete('rule_keyword', array('id' => $keyword['id']));
			pdo_delete('rule', array('id' => $keyword['rid']));
		}
	}
}

?>
