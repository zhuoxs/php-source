<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}
//cc_zhong 小程序文章接口
require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Article_EweiShopV2Page extends AppMobilePage
{
	public function get_list()
	{
		global $_GPC;
		global $_W;
		$categorys = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_article_category') . ' WHERE uniacid=:uniacid and isshow=1 order by displayorder desc ', array(':uniacid' => $_W['uniacid']));
		$page = intval($_GPC['page']);
		$article_sys = pdo_fetch('select * from ' . tablename('ewei_shop_article_sys') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		$article_sys['article_image'] = tomedia($article_sys['article_image']);
		$pindex = max(1, $page);
		$psize = (empty($article_sys['article_shownum']) ? '10' : $article_sys['article_shownum']);

		if (intval($article_sys['article_temp']) == 0) {
			$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category  WHERE a.article_state=1 and article_visit=0 and c.isshow=1 and a.uniacid= :uniacid', array(':uniacid' => $_W['uniacid']));
			$articles = pdo_fetchall('SELECT a.id, a.article_title, a.resp_img, a.article_rule_credit, a.article_rule_money, a.resp_desc, a.article_category FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category  WHERE a.article_state=1 and article_visit=0 and c.isshow=1 and a.uniacid= :uniacid order by a.displayorder desc, a.article_date desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid']));
			$articles = set_medias($articles, 'resp_img');
		}
		else if ($article_sys['article_temp'] == 1) {
			$total = pdo_fetchcolumn('SELECT count(distinct article_date_v) FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and article_visit=0 and c.isshow=1 and a.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
			$list = pdo_fetchall('SELECT distinct article_date_v FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and article_visit=0 and c.isshow=1 and a.uniacid=:uniacid order by a.article_date_v desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid']), 'article_date_v');
			foreach ($list as &$a) {
				$a['articles'] = pdo_fetchall('SELECT id,article_title,article_date_v,resp_img,resp_desc,article_category FROM ' . tablename('ewei_shop_article') . ' WHERE article_state=1 and article_visit=0 and uniacid=:uniacid and article_date_v=:article_date_v order by article_date desc ', array(':uniacid' => $_W['uniacid'], ':article_date_v' => $a['article_date_v']));
				$a['articles'] = set_medias($a['articles'], 'resp_img');
			}
			unset($a);
			$articles = array();
			foreach($list as $v) $articles[] = $v;
			unset($list);
		}
		else {
			if ($article_sys['article_temp'] == 2) {
				$cate = intval($_GPC['cateid']);
				$where = ' and article_visit=0';
				if (0 < $cate) {
					$where = ' and article_category=' . $cate . ' ';
				}
				$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and c.isshow=1 and a.uniacid=:uniacid ' . $where, array(':uniacid' => $_W['uniacid']));
				$articles = pdo_fetchall('SELECT a.id, a.article_title, a.resp_img, a.article_rule_credit, a.article_rule_money, a.article_author, a.article_date_v, a.resp_desc, a.article_category FROM ' . tablename('ewei_shop_article') . ' a left join ' . tablename('ewei_shop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and c.isshow=1 and a.uniacid=:uniacid ' . $where . ' order by a.displayorder desc, a.article_date_v desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid']));
				$articles = set_medias($articles, 'resp_img');
			}
		}
		return app_json(array('article_sys' => $article_sys, 'list' => $articles, 'total' => intval($total), 'pagesize' => intval($psize), 'cates'=>$categorys));
	}

	public function get_detail()
	{
		global $_W;
		global $_GPC;
		$result = array();
		$uniacid = $_W['uniacid'];
		$aid = intval($_GPC['id']);

		if (empty($aid)) {
			return app_error(AppError::$ParamsError);
		}

		$article = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article') . ' WHERE id=:aid and article_state=1 and uniacid=:uniacid limit 1 ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));

		if (empty($article)) {
			return app_error('文章不存在!');
		}
		$openid = $_W['openid'];
		//$article['article_content'] = $this->model->mid_replace(htmlspecialchars_decode($article['article_content']));
		$readnum = intval($article['article_readnum'] + $article['article_readnum_v']);
		$readnum = (100000 < $readnum ? '100000+' : $readnum);
		$likenum = intval($article['article_likenum'] + $article['article_likenum_v']);
		$likenum = (100000 < $likenum ? '100000+' : $likenum);
		$article['readnum'] = $readnum?$readnum:1;
		$article['likenum'] = $likenum;
		$shopset = m('common')->getSysset('shop');
		$article['resp_img'] = empty($article['resp_img'])?tomedia($shopset['logo']):tomedia($article['resp_img']);
		//print_r($shopset);exit;
		if (empty($article['article_mp'])) {
			//$mp = pdo_fetch('SELECT acid,uniacid,name FROM ' . tablename('account_wechats') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));
			//if(empty($mp)) $mp = pdo_fetch('SELECT acid,uniacid,name FROM ' . tablename('account_wxapp') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));))
			$article['article_mp'] = $shopset['name'];
		}

		if (!empty($article['article_visit'])) {
			if (empty($_W['openid'])) {
				return app_error('对不起，您无法访问!');
			}

			$article['article_visit_tip'] = iunserializer($article['article_visit_tip']);
			$article['article_visit_level'] = iunserializer($article['article_visit_level']);
			$visit_text = (!empty($article['article_visit_tip']['text']) ? $article['article_visit_tip']['text'] : '您没有权限访问!');
			$visit_link = (!empty($article['article_visit_tip']['link']) ? $article['article_visit_tip']['link'] : mobileUrl());
			$member = m('member')->getMember($_W['openid']);
			$visit_level_member = (is_array($article['article_visit_level']['member']) ? $article['article_visit_level']['member'] : array());
			$visit_level_commission = (is_array($article['article_visit_level']['commission']) ? $article['article_visit_level']['commission'] : array());
			if (!in_array(!empty($member['level']) ? $member['level'] : 'default', $visit_level_member) && (!in_array($member['agentlevel'], $visit_level_commission) || empty($member['isagent']))) {
				return app_error($visit_text);
			}
		}

		if (!empty($article['article_areas'])) {
			$article['areas'] = explode(',', $article['article_areas']);
		}

		$myid = m('member')->getMid();
		if (!empty($openid) && !empty($myid)) {
			$state = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article_log') . ' WHERE openid=:openid and aid=:aid and uniacid=:uniacid limit 1 ', array(':openid' => $openid, ':aid' => $article['id'], ':uniacid' => $_W['uniacid']));

			if (empty($state['id'])) {
				$insert = array('aid' => $aid, 'read' => 1, 'uniacid' => $_W['uniacid'], 'openid' => $openid);
				pdo_insert('ewei_shop_article_log', $insert);
				$sid = pdo_insertid();
				pdo_update('ewei_shop_article', array('article_readnum' => $article['article_readnum'] + 1), array('id' => $article['id']));
			}
			else {
				$readtime = $article['article_readtime'];

				if ($readtime <= 0) {
					$readtime = 4;
				}

				if ($state['read'] < $readtime) {
					pdo_update('ewei_shop_article_log', array('read' => $state['read'] + 1), array('id' => $state['id']));
					pdo_update('ewei_shop_article', array('article_readnum' => $article['article_readnum'] + 1), array('id' => $article['id']));
				}
			}

			$_W['shopshare'] = array('title' => $article['article_title'], 'imgUrl' => tomedia($article['resp_img']), 'desc' => $article['resp_desc'], 'link' => mobileUrl('article', array('aid' => $article['id'], 'shareid' => $myid), true));

			if (p('commission')) {
				$set = p('commission')->getSet();

				if (!empty($set['level'])) {
					$member = m('member')->getMember($openid);
					if (!empty($member) && ($member['status'] == 1) && ($member['isagent'] == 1)) {
						$_W['shopshare']['link'] = mobileUrl('article', array('aid' => $article['id'], 'shareid' => $myid, 'mid' => $member['id']), true);
					}
					else {
						if (!empty($_GPC['mid'])) {
							$_W['shopshare']['link'] = mobileUrl('article', array('aid' => $article['id'], 'shareid' => $myid, 'mid' => $_GPC['mid']), true);
						}
					}
				}
			}

			/*$_W['shopshare']['hideMenus'] = array('menuItem:share:qq', 'menuItem:share:QZone', 'menuItem:share:email');

			if ($article['page_set_option_nocopy']) {
				$_W['shopshare']['hideMenus'][] = 'menuItem:copyUrl';
				$_W['shopshare']['hideMenus'][] = 'menuItem:openWithSafari';
				$_W['shopshare']['hideMenus'][] = 'menuItem:openWithBrowser';
			}

			if ($article['page_set_option_noshare_tl']) {
				$_W['shopshare']['hideMenus'][] = 'menuItem:share:timeline';
			}

			if ($article['page_set_option_noshare_msg']) {
				$_W['shopshare']['hideMenus'][] = 'menuItem:share:appMessage';
			}*/

			/*if (empty($article['article_areas'])) {
				$shareid = intval($_GPC['shareid']);
				$this->model->doShare($article['id'], $shareid, $myid);
			}*/
		}
		else {
			$_W['shopshare'] = array('title' => $article['article_title'], 'imgUrl' => tomedia($article['resp_img']), 'desc' => $article['resp_desc'], 'link' => mobileUrl('article', array('aid' => $article['id']), true));
		}
/*
		$advs = json_decode($article['product_advs'], true);
		if (!empty($advs) && ($article['product_advs_type'] == 2)) {
			$advnum = count($advs);
			$advrand = rand(0, $advnum - 1);
			$adv = $advs[$advrand];
			$advs = array();
			$advs[] = $adv;
		}

		if (!empty($advs)) {
			foreach ($advs as $i => $v) {
				$advs[$i]['link'] = $this->model->href_replace($v['link']);
			}
		}
		//$article['product_advs_link'] = $this->model->href_replace($article['product_advs_link']);
		//$article['article_linkurl'] = $this->model->href_replace($article['article_linkurl']);*/
		//详情页一键拨号
		if(empty($article['phone']) && intval($_W['shopset']['app']['phone']) && !empty($_W['shopset']['app']['phonenumber'])) $article['phone'] = $_W['shopset']['app']['phonenumber'];
		if(!empty($article['phone'])) $article['phonecolor'] = empty($_W['shopset']['app']['phonecolor']) ? '#ff5555' : $_W['shopset']['app']['phonecolor'];
		return app_json(array('article' => $article));
	}
	//点赞
	public function like()
	{
		global $_W;
		global $_GPC;
		$aid = intval($_GPC['id']);
		$openid = $_W['openid'];
		if (!empty($aid) && !empty($openid)) {
			$state = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article_log') . ' WHERE openid=:openid and aid=:aid and uniacid=:uniacid limit 1 ', array(':openid' => $_W['openid'], ':aid' => $aid, ':uniacid' => $_W['uniacid']));
			if (empty($state['like'])) {
				pdo_update('ewei_shop_article', 'article_likenum=article_likenum+1', array('id' => $aid));
				pdo_update('ewei_shop_article_log', array('like' => $state['like'] + 1), array('id' => $state['id']));
				return app_json(array('success'=>1,'status' => 1));
			}
			else {
				pdo_update('ewei_shop_article', 'article_likenum=article_likenum-1', array('id' => $aid));
				pdo_update('ewei_shop_article_log', array('like' => $state['like'] - 1), array('id' => $state['id']));
				return app_json(array('success'=>1,'status' => 0));
			}
		}
		return app_error('参数错误！');
	}
	public function confirmjoin()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['merch'];
		if (empty($set['apply_openmobile'])) 
		{
			return app_error(0,'未开启商户入驻申请', '');
		}
		$user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
	
		if (empty($user) || $user['status']) 
		{
			return app_error(0,'无权操作!');
		}
		if ($_W['ispost']) 
		{
			pdo_update('ewei_shop_merch_user', array('status'=>1,'jointime'=>time()), array('id' => $user['id']));
			//p('merch')->sendMessage(array('merchname' => $data['merchname'], 'salecate' => $data['salecate'], 'realname' => $data['realname'], 'mobile' => $data['mobile'], 'applytime' => time()), 'merch_apply');
			show_json(1);
		}
		return app_error(0,'失败!');
	}
}

?>
