<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;

load()->func('tpl');
$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($_W['ispost']) {
	$agreement = intval($_GPC['agreement']);
	if ($agreement != '1') {
		sl_ajax(1, '请勾选协议！');
	}

	$ws_act_news = intval($_GPC['ws_act_news']); // 官网模块-修正文章标题显示问题
	$dy_index = intval($_GPC['dy_index']); // 动态模块-修正文章标题显示问题
	$ai_sync_mobile = intval($_GPC['ai_sync_mobile']); // AI助手-修正客户手机号显示问题
	$store_class = intval($_GPC['store_class']); // 商城模块-分类-旧版转到新版
	// $store_goods = intval($_GPC['store_goods']); // 商城模块-商品-旧版转到新版

	// 官网模块-文章
	if ($ws_act_news == '1')
	{
		$condition_act_news = " AND uniacid=:uniacid AND title='' ";
		$params_act_news = array(':uniacid' => $_W['uniacid']);
		$sql_act_news = "SELECT * FROM " . tablename('slwl_aicard_website_act_news'). ' WHERE 1 ' . $condition_act_news;
		$list_act_news = pdo_fetchall($sql_act_news, $params_act_news);

		if ($list_act_news) {
			foreach ($list_act_news as $k => $v) {
				if ((isset($v['newsname'])) && ($v['newsname'] != '')) {
					$data_act_news = array(
						'title'=>$v['newsname'],
					);
					@pdo_update('slwl_aicard_website_act_news', $data_act_news, array('id'=>$v['id']));
				}
			}
		}
	}

	// 动态模块-文章
	if ($dy_index == '1')
	{
		$condition_act_news = " AND uniacid=:uniacid AND title='' ";
		$params_act_news = array(':uniacid' => $_W['uniacid']);
		$sql_act_news = "SELECT * FROM " . tablename('slwl_aicard_dynamic_act'). ' WHERE 1 ' . $condition_act_news;
		$list_act_news = pdo_fetchall($sql_act_news, $params_act_news);

		if ($list_act_news) {
			foreach ($list_act_news as $k => $v) {
				if ((isset($v['dy_title'])) && ($v['dy_title'] != '')) {
					$data_act_news = array(
						'title'=>$v['dy_title'],
					);
					@pdo_update('slwl_aicard_dynamic_act', $data_act_news, array('id'=>$v['id']));
				}
			}
		}
	}

	// 发送手机号到AI 助手
	if ($ai_sync_mobile == '1')
	{
		$condition_sync = " AND uniacid=:uniacid AND mobile<>'' ";
		$params_sync = array(':uniacid' => $_W['uniacid']);
		$sql_sync = "SELECT openid AS user_id,mobile FROM " . tablename('slwl_aicard_users'). ' WHERE 1 ' . $condition_sync;
		$list_sync = pdo_fetchall($sql_sync, $params_sync);

		if ($list_sync) {
			$rst = set_sync_user_mobile($list_sync);
			if ($rst['errcode']!='0') {
				sl_ajax(1, $rst['errmsg'].'-'.$rst['data']);
			}
		}
	}

	// 商城模块-分类-旧版转到新版
	if ($store_class == '1')
	{
		// 父类
		$condition_old_category = " AND weid=:weid AND parentid='0' ";
		$params_old_category = array(':weid' => $_W['uniacid']);
		$pindex_old_category = max(1, intval($_GPC['page']));
		$psize_old_category = 1000;
		$sql_old_category = "SELECT * FROM " . tablename('slwl_aicard_shop_category'). ' WHERE 1 '
			. $condition_old_category . " ORDER BY id DESC LIMIT "
			. ($pindex_old_category - 1) * $psize_old_category .',' .$psize_old_category;
		$list_old_category = pdo_fetchall($sql_old_category, $params_old_category);

		// 子类
		$condition_child_category = " AND weid=:weid AND parentid<>'0' ";
		$params_child_category = array(':weid' => $_W['uniacid']);
		$pindex_child_category = max(1, intval($_GPC['page']));
		$psize_child_category = 1000;
		$sql_child_category = "SELECT * FROM " . tablename('slwl_aicard_shop_category'). ' WHERE 1 '
			. $condition_child_category . " ORDER BY id DESC LIMIT "
			. ($pindex_child_category - 1) * $psize_child_category .',' .$psize_child_category;
		$list_child_category = pdo_fetchall($sql_child_category, $params_child_category);

		if ($list_old_category) {
			foreach ($list_old_category as $k => $v) {
				$data_old_category = array(
					'uniacid'=>$_W['uniacid'],
					'title'=>$v['name'],
					'thumb'=>$v['thumb'],
					'parentid'=>$v['parentid'],
					'isrecommand'=>$v['isrecommand'],
					'adthumb'=>$v['adthumb'],
					'intro'=>$v['description'],
					'addtime'=>$_W['slwl']['datetime']['now'],
				);
				$rst = pdo_insert('slwl_aicard_store_category', $data_old_category);
				$parent_id_category = pdo_insertid();
				if ($rst === false) {
					sl_ajax(1, '失败-商品-旧版转到新版-父类');
					break;
				}

				if ($list_child_category) {
					foreach ($list_child_category as $key => $value) {
						if ($value['parentid'] == $v['id']) {
							$data_child = array(
								'uniacid'=>$_W['uniacid'],
								'title'=>$v['name'],
								'thumb'=>$v['thumb'],
								'parentid'=>$parent_id_category,
								'isrecommand'=>$v['isrecommand'],
								'adthumb'=>$v['adthumb'],
								'intro'=>$v['description'],
								'addtime'=>$_W['slwl']['datetime']['now'],
							);
							$rst_child = pdo_insert('slwl_aicard_store_category', $data_child);
							if ($rst_child === false) {
								sl_ajax(1, '失败-商品-旧版转到新版-子类');
								break;
							}
							break;
						}
					}
				}
			}
		}
	}

	// 商城模块-商品-旧版转到新版
	if ($store_goods == '1')
	{
		// 商品
		$condition_old_goods = " AND weid=:weid ";
		$params_old_goods = array(':weid' => $_W['uniacid']);
		$pindex_old_goods = max(1, intval($_GPC['page']));
		$psize_old_goods = 1000;
		$sql_old_goods = "SELECT * FROM " . tablename('slwl_aicard_shop_goods'). ' WHERE 1 '
			. $condition_old_goods . " ORDER BY id DESC LIMIT "
			. ($pindex_old_goods - 1) * $psize_old_goods .',' .$psize_old_goods;
		$list_old_goods = pdo_fetchall($sql_old_goods, $params_old_goods);

		// 规格
		$condition_old_spec = " AND weid=:weid ";
		$params_old_spec = array(':weid' => $_W['uniacid']);
		$pindex_old_spec = max(1, intval($_GPC['page']));
		$psize_old_spec = 1000;
		$sql_old_spec = "SELECT * FROM " . tablename('slwl_aicard_shop_spec'). ' WHERE 1 '
			. $condition_old_spec . " ORDER BY id DESC LIMIT "
			. ($pindex_old_spec - 1) * $psize_old_spec .',' .$psize_old_spec;
		$list_old_spec = pdo_fetchall($sql_old_spec, $params_old_spec);

		if ($list_old_goods) {
			foreach ($list_old_goods as $k => $v) {
				$spec = '';
				if ($list_old_spec) {
					foreach ($list_old_spec as $key => $value) {
						if ($value['goodsid'] == $v['id']) {
							$tmp = str_ireplace('gditemname', 'title', $value['content']);
							$spec = $tmp;
							break;
						}
					}
				}

				$data_goods = array(
					'uniacid'=>$_W['uniacid'],
					'pcate'=>$v['pcate'],
					'ccate'=>$v['ccate'],
					'title'=>$v['title'],
					'thumb'=>$v['thumb'],
					'intro'=>$v['intro'],
					'unit'=>$v['unit'],
					'content'=>$v['content'],
					'price'=>$v['marketprice'] * 100,
					'original_price'=>$v['productprice'] * 100,
					'inventory'=>$v['total'],
					'inventory_status'=>$v['totalcnf'],
					'sales'=>$v['sales'],
					'param'=>$v['param'],
					'enabled'=>$v['status'],
					'displayorder'=>$v['displayorder'],
					'addtime'=>$_W['slwl']['datetime']['now'],
				);
				if ($spec) {
					$data_goods['spec'] = $spec;
					$data_goods['spec_status'] = '1';
				}
				$rst = pdo_insert('slwl_aicard_store_goods', $data_goods);
				$parent_id = pdo_insertid();
				if ($rst === false) {
					sl_ajax(1, '失败-商城模块-商品-旧版转到新版');
					break;
				}
			}
		}
	}

	sl_ajax(0, '数据更新成功');
}

include $this->template('web/other/data-transfer');

