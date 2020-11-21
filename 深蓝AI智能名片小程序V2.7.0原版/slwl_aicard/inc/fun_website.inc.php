<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

// 官网-模块
if (!defined('IN_IA')) {
	exit('Access Denied');
}

// 官网-官网首页
if (!function_exists('website_index_data'))
{
	function website_index_data()
	{
		global $_GPC, $_W;

		// setting
		$res['config'] = array();
		if ($_W['slwl']['set']['wsdefault_set_settings']) {
			$settings = $_W['slwl']['set']['wsdefault_set_settings'];

			$settings['thumb_url'] = tomedia($settings['thumb']);

			if (empty($settings['titlemore'])) { $settings['titlemore'] = '更多'; }
			if (empty($settings['title_actnews2'])) { $settings['title_actnews2'] = '新闻'; }
			if (empty($settings['nav_show'])) { $settings['nav_show'] = '0'; }

			$res['config'] = $settings;
		} else {
			$res['config'] = array(
				'banner_height' => '310rpx',
				'titlemore' => '',
				'title_actnews2' => '新闻',
				'nav_show' => '0',
			);
		}


		// adv
		$psize_adv = 5;
		$condition_adv = " AND uniacid=:uniacid AND enabled='1' ";
		$params_adv = array(':uniacid' => $_W['uniacid']);
		$adv_list = pdo_fetchall('SELECT * FROM ' . sl_table_name('website_adv',TRUE) . ' WHERE 1 '
			. $condition_adv . ' ORDER BY displayorder DESC, id DESC limit 0,' . $psize_adv, $params_adv);

		$res['adv'] = array();
		if ($adv_list) {
			foreach ($adv_list as $k => $v) {
				$adv_list[$k]['thumb_url'] = tomedia($v['thumb']);
			}

			$res['adv']['banner_height'] = $res['config']['banner_height']; // 一定有值
			$res['adv']['items'] = $adv_list;
			$res['adv']['enabled'] = $res['config']['banner_show'];
		}


		// 组合广告
		$condition_adg = ' AND uniacid=:uniacid AND setting_name=:setting_name ';
		$params_adg = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_ws_adgroup_settings');
		$set_adg = pdo_fetch("SELECT * FROM " . sl_table_name('settings',TRUE) . ' WHERE 1 '
			. $condition_adg, $params_adg);

		$res['adgroup'] = array();
		if ($_W['slwl']['set']['set_ws_adgroup_settings']) {
			$adg_list = $_W['slwl']['set']['set_ws_adgroup_settings'];

			if ($adg_list) {
				foreach ($adg_list as $k => $v) {
					$adg_list[$k]['attrurl'] = tomedia($v['attachment']);
				}
			}

			$res['adgroup']['items'] = $adg_list;
			$res['adgroup']['enabled'] = $res['config']['adgroup_show'];
		}


		// nav
		$condition_buttons = " AND uniacid=:uniacid AND setting_name=:setting_name ";
		$params_buttons = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'wsbuttons_set_settings');
		$set_buttons = pdo_fetch("SELECT * FROM " . sl_table_name('settings',TRUE) . ' WHERE 1 ' . $condition_buttons, $params_buttons);

		if ($_W['slwl']['set']['wsbuttons_set_settings']) {
			$bs_list = $_W['slwl']['set']['wsbuttons_set_settings'];

			if ($bs_list['items']) {
				foreach ($bs_list['items'] as $k => $v) {
					$bs_list['items'][$k]['thumb_url'] = tomedia($v['attachment']);
				}
			}

			if (empty($bs_list['rownum'])) {
				$bs_list['rownum'] == '4';
			} else {
				if ($bs_list['rownum'] < 3 || $bs_list['rownum'] > 5) {
					$bs_list['rownum'] = '4';
				}
			}
		} else {
			$bs_list = array(
				'items' => array(),
				'rownum' => 4,
			);
		}

		if ($settings) {
			$res['nav']['items'] = $bs_list['items'];
			$res['nav']['rownum'] = $bs_list['rownum'];
			$res['nav']['enabled'] = $settings['nav_show'];
		} else {
			$res['nav']['rownum'] = 4;
			$res['nav']['enabled'] = 0;
		}


		// 新闻列表-1
		$psize_term_1 = 6;
		$condition_term_1 = " AND uniacid=:uniacid AND enabled='1' AND isrecommand='1' ";
		$params_term_1 = array(':uniacid' => $_W['uniacid']);
		$term_list_1 = pdo_fetchall("SELECT * FROM " . sl_table_name('website_act_term',TRUE) . ' WHERE 1 '
			. $condition_term_1 . ' ORDER BY displayorder DESC, id DESC limit 0,' . $psize_term_1, $params_term_1);

		$list_1 = array();
		if ($term_list_1) {
			foreach ($term_list_1 as $k => $v) {
				$psize_alist_1 = 6;
				$condition_alist_1 = " AND uniacid=:uniacid AND termid=:termid AND enabled='1' ";
				$params_alist_1 = array(':uniacid' => $_W['uniacid'], ':termid' => $v['id']);

				$news_alist_1 = pdo_fetchall('SELECT * FROM ' . sl_table_name('website_act_news',TRUE) . ' WHERE 1 '
					. $condition_alist_1 . '  ORDER BY displayorder DESC, id DESC limit 0, ' . $psize_alist_1, $params_alist_1);

				foreach ($news_alist_1 as $key => $value) {
					$news_alist_1[$key]['createtime_cn'] = date('Y-m-d H:i:s', $value['createtime']);
					$news_alist_1[$key]['thumb_url'] = tomedia($value['thumb']);
				}

				$term_list_1[$k]['list'] = $news_alist_1;
			}

			$list_1 = $term_list_1;
		}
		$res['newslist1']['items'] = $list_1;


		// 新闻列表-2
		$condition_list_2 = ' AND uniacid=:uniacid ';
		$params_list_2 = array(':uniacid' => $_W['uniacid']);
		$pindex_list_2 = 1;
		$psize_list_2 = 6;
		$sql_list_2 = "SELECT * FROM " . sl_table_name('website_act_news',TRUE). ' WHERE 1 '
			. $condition_list_2 . " ORDER BY displayorder DESC, id DESC LIMIT "
			. ($pindex_list_2 - 1) * $psize_list_2 . ',' . $psize_list_2;
		$list_list_2 = pdo_fetchall($sql_list_2, $params_list_2);

		$tmp_nav = array();
		if ($list_list_2) {

			$condition_term_list_2 = ' AND uniacid=:uniacid ';
			$params_term_list_2 = array(':uniacid' => $_W['uniacid']);
			$pindex_term_list_2 = max(1, intval($_GPC['page']));
			$psize_term_list_2 = 1000;
			$sql_term_list_2 = "SELECT * FROM " . sl_table_name('website_act_term',TRUE) . ' WHERE 1 '
				. $condition_term_list_2 . " ORDER BY displayorder DESC, id DESC LIMIT "
				. ($pindex_term_list_2 - 1) * $psize_term_list_2 .',' . $psize_term_list_2;
			$list_term_list_2 = pdo_fetchall($sql_term_list_2, $params_term_list_2);

			foreach ($list_list_2 as $key => $value) {
				foreach ($list_term_list_2 as $k => $v) {
					if ($value['termid'] == $v['id']) {
						$list_list_2[$key]['term_cn'] = $v['termname'];
					}
				}
				$list_list_2[$key]['thumb_url'] = tomedia($value['thumb']);
			}

			$tmp_title = $_W['slwl']['set']['wsdefault_set_settings']['title_actnews2'];
			$tmp_list_style = $_W['slwl']['set']['wsdefault_set_settings']['actnews2_list_style'];
			$tmp_nav = array(
				'class_name'=>isset($tmp_title)?$tmp_title:'新闻资讯',
				'list_style'=>isset($tmp_list_style)?$tmp_list_style:'column-one',
			);
		}

		$res['newslist2']['enabled'] = $settings['actnews2_show'];
		$res['newslist2']['items'] = $list_list_2;
		$res['newslist2']['nav'] = $tmp_nav;


		return result(0, 'ok', $res);
	}
}

// 官网-文章列表，传分类ID
if (!function_exists('website_act_list'))
{
	function website_act_list()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$termid = max(0, intval($_GPC['tid'])); // 分类ID

		$form_id = $_GPC['fmid'];

		$page = ((empty($_GPC['page']) ? '' : $_GPC['page']));
		$pindex = max(1, intval($page));
		$psize =  max(10, intval($_GPC['psize']));

		$condition = " AND uniacid=:uniacid AND enabled='1' AND termid=:termid ";
		$params = array(':uniacid' => $_W['uniacid'], ':termid'=>$termid);
		$fields = ' id,termid,newsname,subtitle,thumb,createtime,displayorder ';
		$list = pdo_fetchall('SELECT ' . $fields .' FROM ' . sl_table_name('website_act_news',TRUE)
			. ' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC, id DESC limit '
			. (($pindex - 1) * $psize) . ',' . $psize, $params);


		$condition_term = " AND uniacid=:uniacid AND id=:id ";
		$params_term = array(':uniacid' => $_W['uniacid'], ':id'=>$termid);
		$list_term = pdo_fetch('SELECT * FROM ' . sl_table_name('website_act_term',TRUE) . ' WHERE 1 '
			. $condition_term . ' ORDER BY displayorder DESC, id DESC ', $params_term);

		foreach ($list as $k => $v) {
			$list[$k]['createtime_cn'] = date('Y-m-d H:i:s', $v['createtime']);
			$list[$k]['thumb_url'] = tomedia($v['thumb']);
			$list[$k]['term_cn'] = $list_term['termname'];
		}

		$list_news['items'] = $list;
		$list_news['title'] = $list_term['termname'];

		$rs = array(
			'news'=>$list_news,
		);

		return result(0, 'ok', $rs);
	}
}

// 官网-普通文章-内容
if (!function_exists('website_act_one'))
{
	function website_act_one()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$condition = " AND uniacid=:uniacid AND id=:id AND enabled='1' ";
		$id = intval($_GPC['aid']);
		$params = array(':uniacid' => $_W['uniacid'], 'id' => $id);

		$one = pdo_fetch('SELECT * FROM ' . sl_table_name('website_act_news',TRUE)
			. ' WHERE 1 ' . $condition, $params);

		if ($one) {
			$one['thumb_url'] = tomedia($one['thumb']);
			$one['createtime_cn'] = date('Y-m-d H:i:s', $one['createtime']);
			$one['out_thumb_url'] = tomedia($one['out_thumb']);
		}

		$res = array(
			'one'=>$one
		);

		return result(0, 'ok', $res);
	}
}

// 官网-单页面文章-内容
if (!function_exists('website_adact_one'))
{
	function website_adact_one()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$form_id = $_GPC['fmid'];

		$condition = " AND uniacid=:uniacid AND id=:id AND enabled='1' ";
		$id = max(0, intval($_GPC['aid']));
		$params = array(':uniacid' => $_W['uniacid'], 'id' => $id);

		$one = pdo_fetch('SELECT * FROM ' . sl_table_name('adact',TRUE)
			. ' WHERE 1 ' . $condition, $params);

		if ($one) {
			$one['thumb_url'] = tomedia($one['thumb']);
			$one['out_thumb_url'] = tomedia($one['out_thumb']);
		}

		$res = array(
			'one'=>$one
		);

		return result(0, 'ok', $res);
	}
}

// 官网-获取所有分类
if (!function_exists('website_act_list_nav'))
{
	function website_act_list_nav()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];

		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$form_id = $_GPC['fmid'];

		$nav = array();
		$psize = 100;
		$condition = " AND uniacid=:uniacid AND enabled='1' ";
		$params = array(':uniacid' => $_W['uniacid']);

		$nav = pdo_fetchall('SELECT * FROM ' . sl_table_name('website_act_term',TRUE) . ' WHERE 1 '
			. $condition . ' ORDER BY displayorder DESC, id DESC limit 0,' . $psize, $params);

		foreach ($nav as $k => $v) {
			$nav[$k]['thumb_url'] = tomedia($v['thumb']);
		}

		$data_bak = array(
			'nav'=>$nav,
		);

		return result(0, 'ok', $data_bak);
	}
}

// 官网-返回指定分类下的文章
if (!function_exists('website_term_act_list'))
{
	function website_term_act_list()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$termid = max(0, intval($_GPC['tid'])); // 分类ID

		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$form_id = $_GPC['fmid'];

		$page = ((empty($_GPC['page']) ? '' : $_GPC['page']));
		$pindex = max(1, intval($page));
		$psize =  max(10, intval($_GPC['psize']));
		$condition = " AND uniacid=:uniacid AND enabled='1' ";
		$params = array(':uniacid' => $_W['uniacid']);
		$orderby = " ORDER BY displayorder DESC, id DESC ";

		if ($termid>0) {
			$condition .= " AND termid=:termid ";
			$params[':termid'] = $termid;
		}

		$list = pdo_fetchall('SELECT * FROM ' . sl_table_name('website_act_news',TRUE) . ' WHERE 1 '
			. $condition . $orderby . ' limit ' . (($pindex - 1) * $psize) . ',' . $psize, $params);

		$condition_term = " AND uniacid=:uniacid AND id=:id ";
		$params_term = array(':uniacid' => $_W['uniacid'], ':id'=>$termid);
		$list_term = pdo_fetch('SELECT * FROM ' . sl_table_name('website_act_term',TRUE) . ' WHERE 1 '
			. $condition_term . ' ORDER BY displayorder DESC, id DESC ', $params_term);

		foreach ($list as $k => $v) {
			$list[$k]['thumb_url'] = tomedia($v['thumb']);
		}


		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . sl_table_name('users',TRUE) . ' WHERE 1 ' . $condition_user, $params_user);

		// 卡片信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . sl_table_name('card',TRUE) . ' WHERE 1 ' . $condition_card, $params_card);

		if ($one_card) {
			if ($one_user) {
				$s_data = array(
					'op_user'=>$one_user['openid'],
					'op_avatar'=>$one_user['avatar'],
					'op_user_name'=>$one_user['nicename'],
					'openid'=>$one_user['openid'],
					'verwxapp'=>$ver,

					'opid'=>'slwl-000015',
					'optxt'=>$list_term['termname'],
					'op_obj'=>$one_card['userid'],
					'op_obj_name'=>$one_card['last_name'].$one_card['first_name'],
				);
				$rst = send_op_msg($s_data);
			}

			if ($form_id != 'the formId is a mock one') {
				$formid_data = array(
					'uniacid' => $_W['uniacid'],
					'user_id' => $uid,
					'openid' => $one_user['openid'],
					'form_id' => $form_id,
					'op_code' => 'slwl-000015',
					'op_text' => $list_term['termname'],
					'addtime' => $_W['slwl']['datetime']['now'],
				);
				pdo_insert('slwl_aicard_formid', $formid_data);
			}
		}

		return result(0, 'ok', $list);
	}
}

?>
