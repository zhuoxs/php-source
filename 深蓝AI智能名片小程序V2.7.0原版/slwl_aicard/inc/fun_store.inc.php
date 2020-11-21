<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

// 新版商城-模块
if (!defined('IN_IA')) { exit('Access Denied'); }

// 测试
function store_test()
{
	global $_GPC, $_W;
	return result('1', $arr);

	dump($_W);
	echo "<hr>";
	dump($_GPC);
}

// 新版商城-首页
function store_index_data()
{
	global $_GPC, $_W;
	$ver = $_GPC['ver'];
	$uid = $_GPC['uid'];
	if ($uid == 0) {
		return result(1, '用户ID不存在');
	}

	$pid = intval($_GPC['pid']);

	// setting-基本设置
	$res['config'] = array();
	if ($_W['slwl']['set']['set_store_config']) {
		$set_setting_str = $_W['slwl']['set']['set_store_config'];

		$set_setting_str['share_thumb_url'] = tomedia($set_setting_str['share_thumb']);
		$res['config'] = $set_setting_str;
	}

	// default-首页配置
	$res['default'] = array();
	if ($_W['slwl']['set']['set_store_default']) {
		$set_default_str = $_W['slwl']['set']['set_store_default'];

		if (empty($set_default_str['titlemore'])) { $set_default_str['titlemore'] = '更多'; }
		if (empty($set_default_str['brandtitle'])) { $set_default_str['brandtitle'] = '品牌制造商直供'; }
		if (empty($set_default_str['inewtitle'])) { $set_default_str['inewtitle'] = '周一周四 · 新品首发'; }
		if (empty($set_default_str['ihottitle'])) { $set_default_str['ihottitle'] = '人气推荐'; }
		if (empty($set_default_str['topictitle'])) { $set_default_str['topictitle'] = '专题精选'; }

		$res['default'] = $set_default_str;
	} else {
		$res['default'] = array(
			'banner_height' => '310rpx',
			'titlemore' => '更多',
			'brandtitle' => '品牌制造商直供',
			'inewtitle' => '周一周四 · 新品首发',
			'ihottitle' => '人气推荐',
			'topictitle' => '专题精选',
		);
	}

	// adv
	$psize_adv = 5;
	$condition_adv = " AND uniacid=:uniacid AND enabled='1' ";
	$params_adv = array(':uniacid' => $_W['uniacid']);

	$adv_list = pdo_fetchall('SELECT * FROM ' . sl_table_name('store_adv', TRUE) . ' WHERE 1 '
		. $condition_adv . ' ORDER BY displayorder DESC, id DESC limit 0,' . $psize_adv, $params_adv);

	if ($adv_list) {
		foreach ($adv_list as $k => $v) {
			$adv_list[$k]['thumb_url'] = tomedia($v['thumb']);
		}
	}

	if ($set_default_str) {
		$res['banner']['items'] = $adv_list;
		if ($set_default_str['banner_height']) {
			$res['banner']['banner_height'] = $set_default_str['banner_height'];
		}
		$res['banner']['enabled'] = $set_default_str['adv_show']=='1'?TRUE:FALSE;
	} else {
		$res['banner']['enabled'] = FALSE;
	}


	// nav-首页按钮组
	if ($_W['slwl']['set']['set_store_buttons']) {
		$bs_list = $_W['slwl']['set']['set_store_buttons'];

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
			'itmes' => array(),
			'rownum' => 4,
		);
	}
	$res['guide'] = $bs_list;


	// adgroup-组合广告
	$res['adgroup'] = array();
	if ($_W['slwl']['set']['set_store_adgroup']) {
		$adg_list = $_W['slwl']['set']['set_store_adgroup'];

		if ($adg_list) {
			foreach ($adg_list as $k => $v) {
				$adg_list[$k]['attrurl'] = tomedia($v['attachment']);
			}
			$res['adgroup'] = $adg_list;
		}
	}


	// 获取广告
	$condition_adsp = " AND uniacid=:uniacid AND enabled='1' ";
	$params_adsp = array(':uniacid' => $_W['uniacid']);
	$pindex_adsp = max(1, intval($_GPC['page']));
	$psize_adsp = 5;
	$sql_adsp = "SELECT * FROM " . sl_table_name('store_adsp',TRUE) . ' WHERE 1 '
		. $condition_adsp . " ORDER BY displayorder DESC, id ASC LIMIT " . ($pindex_adsp - 1) * $psize_adsp . ',' . $psize_adsp;
	$list_adsp = pdo_fetchall($sql_adsp, $params_adsp);

	if ($list_adsp) {
		foreach ($list_adsp as $k => $v) {
			$list_adsp[$k]['thumb_url'] = tomedia($v['thumb']);
		}
	}
	$res['adsp'] = $list_adsp;

	// brand
	$condition_brand = " AND uniacid=:uniacid AND enabled='1' ";
	$params_brand = array(':uniacid' => $_W['uniacid']);
	$pindex_brand = max(1, intval($_GPC['page']));
	$psize_brand = 4;
	$sql_brand = "SELECT * FROM " . sl_table_name('store_brand',TRUE) . ' WHERE 1 '
		. $condition_brand . " ORDER BY displayorder DESC, id ASC LIMIT " . ($pindex_brand - 1) * $psize_brand .',' .$psize_brand;
	$brand_list = pdo_fetchall($sql_brand, $params_brand);

	if ($brand_list) {
		foreach ($brand_list as $k => $v) {
			$brand_list[$k]['thumb_url'] = tomedia($v['thumb']);
		}
	}
	$res['brands'] = $brand_list;

	// 获取禁用品牌商
	$condition_brand_0 = " AND uniacid=:uniacid AND enabled='0' ";
	$params_brand_0 = array(':uniacid' => $_W['uniacid']);
	$pindex_brand_0 = 1;
	$psize_brand_0 = 1000;
	$sql_brand_0 = "SELECT * FROM " . sl_table_name('store_brand',TRUE) . ' WHERE 1 '
		. $condition_brand_0 . " ORDER BY displayorder DESC, id ASC LIMIT "
		. ($pindex_brand_0 - 1) * $psize_brand_0 .',' .$psize_brand_0;
	$list_brand_0 = pdo_fetchall($sql_brand_0, $params_brand_0);

	// 获取禁用-分类
	$condition_cate = " AND uniacid=:uniacid AND enabled='1' ";
	$params_cate = array(':uniacid' => $_W['uniacid']);
	$pindex_cate = 1;
	$psize_cate = 1000;
	$sql_cate = "SELECT * FROM " . sl_table_name('store_category',TRUE) . ' WHERE 1 '
		. $condition_cate . " ORDER BY displayorder DESC, id DESC LIMIT "
		. ($pindex_cate - 1) * $psize_cate .',' .$psize_cate;
	$list_cate = pdo_fetchall($sql_cate, $params_cate);

	// 新品首发
	$tmp = '';
	if ($list_brand_0) {
		foreach ($list_brand_0 as $k => $v) {
			$tmp .= $v['id'] . ',';
		}
	}

	if ($list_cate) {
		foreach ($list_cate as $k => $v) {
			$tmp .= $v['id'] . ',';
		}
	}

	if ($tmp) {
		$tmp = substr($tmp, 0, strlen($tmp)-1);
		$where =' AND brandid NOT IN(' . $tmp . ')';
	}
	$rpindex_new_godos = max(1, intval($_GPC['rpage']));
	$rpsize_new_godos = 100;
	$condition_new_godos = " AND uniacid=:uniacid AND isnew='1' AND deleted='0' AND enabled='1' ";
	if ($tmp) {
		$condition_new_godos .= $where;
	}
	$params_new_godos = array(':uniacid' => $_W['uniacid']);

	$new_godos_list_field = ' id,title,thumb,price,original_price,inventory,sales ';
	$new_godos_list = pdo_fetchall("SELECT " . $new_godos_list_field . " FROM "
		. sl_table_name('store_goods',TRUE) . " WHERE 1 " . $condition_new_godos
		. " ORDER BY displayorder DESC, sales DESC LIMIT "
		. ($rpindex_new_godos - 1) * $rpsize_new_godos . ',' . $rpsize_new_godos, $params_new_godos);

	if ($new_godos_list) {
		foreach ($new_godos_list as $k => $v) {
			$new_godos_list[$k]['thumb_url'] = tomedia($v['thumb']);
			$new_godos_list[$k]['price_format']   = number_format($v['price'] / 100, 2);
			$new_godos_list[$k]['original_price_format']  = number_format($v['original_price'] / 100, 2);
		}
	}
	if (isset($res['default']['newgoods_status'])) {
		$res['newgoods']['enabled'] = $res['default']['newgoods_status']=='1' ? TRUE : FALSE;
	} else {
		$res['newgoods']['enabled'] = FALSE;
	}
	$res['newgoods']['title'] = $res['default']['inewtitle'];
	$res['newgoods']['items'] = $new_godos_list;


	// 人气推荐商品
	$tmp_ishot = '';
	if ($list_brand_0) {
		foreach ($list_brand_0 as $k => $v) {
			$tmp_ishot .= $v['id'] . ',';
		}
	}

	if ($list_cate) {
		foreach ($list_cate as $k => $v) {
			$tmp_ishot .= $v['id'] . ',';
		}
	}

	if ($tmp_ishot) {
		$tmp_ishot = substr($tmp_ishot, 0, strlen($tmp_ishot)-1);
		$where_ishot =' AND brandid NOT IN(' . $tmp_ishot . ')';
	}

	$rpindex_ishot = max(1, intval($_GPC['rpage']));
	$rpsize_ishot = 100;
	$condition_ishot = " AND uniacid=:uniacid AND ishot='1' AND deleted='0' AND enabled='1' ";
	if ($tmp_ishot) {
		$condition_ishot .= $where_ishot;
	}
	$params_ishot = array(':uniacid' => $_W['uniacid']);

	$ishot_list_field = 'id,brandid,title,thumb,price,original_price,intro,inventory,sales';
	$ishot_list = pdo_fetchall("SELECT " . $ishot_list_field . " FROM "
		. sl_table_name('store_goods',TRUE) . " WHERE 1 "
		. $condition_ishot . " ORDER BY displayorder DESC, sales DESC LIMIT "
		. ($rpindex_ishot - 1) * $rpsize_ishot . ',' . $rpsize_ishot, $params_ishot);

	if ($ishot_list) {
		foreach ($ishot_list as $k => $v) {
			$ishot_list[$k]['thumb_url'] = tomedia($v['thumb']);
			$ishot_list[$k]['price_format'] = number_format($v['price'] / 100, 2);
			$ishot_list[$k]['original_price_format']  = number_format($v['original_price'] / 100, 2);
		}
	}
	if (isset($res['default']['hotgoods_status'])) {
		$res['hotgoods']['enabled'] = $res['default']['hotgoods_status']=='1'?TRUE:FALSE;
	} else {
		$res['hotgoods']['enabled'] = FALSE;
	}
	$res['hotgoods']['title'] = $res['default']['ihottitle'];
	$res['hotgoods']['items'] = $ishot_list;

	return result(0, 'ok', $res);
}

// 新版商城-商品详情
function store_good_detail()
{
	global $_GPC, $_W;
	$uid = intval($_GPC['uid']);
	$ver = $_GPC['ver'];
	$pid = intval($_GPC['pid']);

	$goods_id = intval($_GPC['id']);

	$condition_goods = " AND uniacid=:uniacid AND id=:id ";
	$params_goods = array(':uniacid' => $_W['uniacid'], ':id' => $goods_id);
	$one = pdo_fetch('SELECT * FROM ' . sl_table_name('store_goods',TRUE)
		. ' WHERE 1 ' . $condition_goods, $params_goods);
	if (empty($one)) {
		return result(1, '抱歉，商品不存在或是已经被删除！');
	}
	if ($one['istime'] == 1) {
		if (time() < $one['timestart']) {
			return result(1, '抱歉，还未到购买时间, 暂时无法购物哦~');
		}
		if (time() > $one['timeend']) {
			return result(1, '抱歉，商品限购时间已到，不能购买了哦~');
		}
	}

	$one['thumb_url'] = tomedia($one['thumb']);

	if ($one['thumbs']) {
		$goods_thumbs = json_decode($one['thumbs'], TRUE);
		foreach ($goods_thumbs as $k => $v) {
			$one['thumbs_url'][] = tomedia($v);
		}
	}

	$one['price_format'] = number_format($one['price'] / 100, 2);
	$one['original_price_format'] = number_format($one['original_price'] / 100, 2);

	//浏览量 + 1
	pdo_query("UPDATE " . sl_table_name('store_goods',TRUE)
		. " SET viewcount=viewcount+1 WHERE id=:id AND uniacid='{$_W['uniacid']}' ",
		[":id" => $goods_id]
	);

	// 处理，自定义参数
	if ($one['param']) {
		$one_param = json_decode($one['param'], TRUE);
		unset($one['param']);
		$one['param_format'] = $one_param;
	}

	// 处理，多规格
	if ($one['spec']) {
		$spec_items = json_decode($one['spec'], TRUE);
		unset($one['spec']);
		$one['spec_format'] = $spec_items;
	}

	$condition_goods_option = " AND uniacid=:uniacid AND goodid=:goodid ";
	$params_goods_option = array(':uniacid' => $_W['uniacid'], ':goodid' => $goods_id);
	$sql_goods_option = "SELECT * FROM " . sl_table_name('store_goods_option',TRUE) . ' WHERE 1 '
		. $condition_goods_option . " ORDER BY id ASC ";
	$list_goods_option = pdo_fetchall($sql_goods_option, $params_goods_option);

	if ($list_goods_option) {
		foreach ($list_goods_option as $k => $v) {
			$list_goods_option[$k]['assemble_array'] = json_decode($v['assemble_json'], TRUE);


			$list_goods_option[$k]['price_format'] = number_format($v['price'] / 100, 2);
			$list_goods_option[$k]['original_price_format'] = number_format($v['original_price'] / 100, 2);
			unset($list_goods_option[$k]['assemble_json']);
		}
		$one['goods_options'] = $list_goods_option;

		// 显示区间值
		if (count($list_goods_option) >= 2) {
			$list_money = sl_array_column($list_goods_option, 'price_format');
			sort($list_money);

			$money_min = array_shift($list_money);
			$money_max = array_pop($list_money);

			if ($one['spec_status'] == '1') {
				$one['price_min'] = $money_min;
				$one['price_max'] = $money_max;
			}
		}

	}

	// 是否为收藏商品
	$one['iscollect'] = 0;
	$condition = ' AND uniacid=:uniacid AND from_user=:from_user AND goodsid=:goodsid ';
	$params = array(':uniacid' => $_W['uniacid'], ':from_user'=>$uid, ':goodsid'=>$goods_id);
	$fav = pdo_fetch('SELECT * FROM ' . sl_table_name('store_collect',TRUE)
		. ' WHERE 1 ' . $condition, $params);

	if ($fav) {
		$one['iscollect'] = 1;
	}

	$data_bak = array(
		'goods'=>$one,
	);

	return result(0, 'ok', $data_bak);
}

// 新版商城-返回所有一级分类
function store_category_top()
{
	global $_GPC, $_W;

	$condition = " AND uniacid=:uniacid AND parentid='0' ";
	$params = array(':uniacid' => $_W['uniacid']);
	$list_category = pdo_fetchall('SELECT * FROM ' . sl_table_name('store_category',TRUE) . ' WHERE 1 '
		. $condition . 'ORDER BY displayorder DESC', $params);

	if ($list_category) {
		foreach ($list_category as $k => $v) {
			$list_category[$k]['thumb_url'] = tomedia($v['thumb']);
			$list_category[$k]['adthumb_url'] = tomedia($v['adthumb']);
		}

		$data_bak = array(
			'category'=>$list_category,
		);
	}

	return result(0, 'ok', $data_bak);
}

// 新版商城-返回指定分类下的子分类
function store_category_sub()
{
	global $_GPC, $_W;

	$id = intval($_GPC['id']); // 分类ID
	$condition_cate = ' AND uniacid=:uniacid AND id=:id ';
	$params_cate = array(':uniacid' => $_W['uniacid'], ':id'=>$id);
	$one_cate = pdo_fetch("SELECT * FROM " . sl_table_name('store_category',TRUE) . " WHERE 1 "
		. $condition_cate . " ORDER BY displayorder DESC", $params_cate);

	if ($one_cate) {
		$one_cate['thumb_url'] = tomedia($one_cate['thumb']);
		$one_cate['adthumb_url'] = tomedia($one_cate['adthumb']);

		$children = array();
		$condition = " AND uniacid=:uniacid AND parentid=:parentid AND enabled='1' ";
		$params = array(':uniacid' => $_W['uniacid'], ':parentid'=>$one_cate['id']);
		$children = pdo_fetchall("SELECT * FROM " . sl_table_name('store_category',TRUE) . " WHERE 1 "
			. $condition . " ORDER BY parentid ASC, displayorder DESC", $params);

		foreach ($children as $k => $v) {
			$children[$k]['thumb_url'] = tomedia($v['thumb']);
			$children[$k]['adthumb_url'] = tomedia($v['adthumb']);
		}

		$data_bak = array(
			'category'=>$one_cate,
			'child_cate'=>$children,
		);
	}

	return result(0, 'ok', $data_bak);
}

// 新版商城-获取指定分类下的商品
function store_goods_list()
{
	global $_GPC, $_W;

	$cate_id = intval($_GPC['id']);
	$condition_cate = ' AND uniacid=:uniacid AND id=:id ';
	$params_cate = array(':uniacid' => $_W['uniacid'], ':id'=>$cate_id);
	$one_cate = pdo_fetch("SELECT * FROM " . sl_table_name('store_category',TRUE) . " WHERE 1 "
		. $condition_cate . " ORDER BY displayorder DESC", $params_cate);

	if (empty($one_cate)) {
		return result(1, '分类不存在或是已经被删除');
	}

	// 获取禁用品牌商
	$condition_brand = " AND uniacid=:uniacid AND enabled='0' ";
	$params_brand = array(':uniacid' => $_W['uniacid']);
	$pindex_brand = 1;
	$psize_brand = 1000;
	$sql_brand = "SELECT * FROM " . sl_table_name('store_brand',TRUE) . ' WHERE 1 '
		. $condition_brand . " ORDER BY displayorder DESC, id ASC LIMIT "
		. ($pindex_brand - 1) * $psize_brand .',' .$psize_brand;
	$list_brand = pdo_fetchall($sql_brand, $params_brand);

	if ($list_brand) {
		$flags = '';
		foreach ($list_brand as $item) {
			$flags .= $item['brandid'] . ',';
		}
		$flags = substr($flags, 0, strlen($flags)-1);
		$where =' AND brandid NOT IN(' . $flags . ')';
	}

	$condition_goods = " AND uniacid=:uniacid AND deleted='0' AND (ccate=:cid OR pcate=:cid) ";
	$condition_goods .= $where;
	$params_goods = array(':uniacid' => $_W['uniacid'], ':cid'=>$cate_id);
	$pindex_goods = max(1, intval($_GPC['page']));
	$psize_goods = 10;
	$sql_goods = "SELECT * FROM " . sl_table_name('store_goods',TRUE) . ' WHERE 1 '
		. $condition_goods . " ORDER BY displayorder DESC, id DESC LIMIT "
		. ($pindex_goods - 1) * $psize_goods .',' .$psize_goods;
	$list_goods = pdo_fetchall($sql_goods, $params_goods);


	if ($list_goods) {
		foreach ($list_goods as $k => $v) {
			$list_goods[$k]['thumb_url'] = tomedia($v['thumb']);
			$list_goods[$k]['price_format'] = number_format($v['price'] / 100, 2);
			$list_goods[$k]['original_price_format'] = number_format($v['original_price'] / 100, 2);
		}
	}

	$data_bak = array(
		'list'=>$list_goods,
	);

	return result(0, 'ok', $data_bak);
}

// 新版商城-搜索
function store_search()
{
	global $_GPC, $_W;

	$keyword = $_GPC['key'];
	// $sorttype = $_GPC['sorttype'];
	// $sortorder = $_GPC['sortorder'];
	$search_good_type = $_GPC['type']; // 搜索类型 hot=人气  new=新品
	$search_term_id = $_GPC['id']; // 按分类ID搜索

	$condition_goods = " AND uniacid=:uniacid AND deleted='0' AND enabled='1' ";
	$params_goods = array(':uniacid' => $_W['uniacid']);

	// $where = '';
	// if ($sorttype && $sortorder) {
	//     if ($sorttype == 'price') {
	//         $where = ' price '.$sortorder.', ';
	//     }
	// }

	if ($keyword != '') {
		$where = " AND title LIKE :keyword ";
		$condition_goods .= $where;
		$params_goods[':keyword'] = '%'.$keyword.'%';
	}

	if ($search_term_id) {
		$where = " AND ccate=:cid ";
		$condition_goods .= $where;
		$params_goods[':cid'] = $search_term_id;
	}

	if ($search_good_type == 'new') {
		$where = " AND isnew='1' ";
	}

	if ($search_good_type == 'hot') {
		$where = " AND ishot='1' ";
	}

	// 获取禁用品牌商
	// $condition_brand = " AND uniacid=:uniacid AND enabled='0' ";
	// $params_brand = array(':uniacid' => $_W['uniacid']);
	// $pindex_brand = 1;
	// $psize_brand = 1000;
	// $sql_brand = "SELECT * FROM " . sl_table_name('store_brand',TRUE) . ' WHERE 1 '
	//   . $condition_brand . " ORDER BY displayorder DESC, id ASC LIMIT "
	//   . ($pindex_brand - 1) * $psize_brand .',' .$psize_brand;
	// $list_brand = pdo_fetchall($sql_brand, $params_brand);

	// if ($list_brand) {
	//     $flags = '';
	//     foreach ($list_brand as $item) {
	//         $flags .= $item['brandid'] . ',';
	//     }
	//     $flags = substr($flags, 0, strlen($flags)-1);
	//     $where =' AND brandid NOT IN(' . $flags . ')';
	// }


	$pindex_goods = max(1, intval($_GPC['page']));
	$psize_goods = 10;

	$condition_goods .= $where;
	$sql_goods_field = ' id,title,intro,thumb,price,original_price ';
	$sql_goods = "SELECT " . $sql_goods_field . " FROM " . sl_table_name('store_goods',TRUE) .' WHERE 1 '
		. $condition_goods . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex_goods - 1) * $psize_goods .',' .$psize_goods;
	$list_goods = pdo_fetchall($sql_goods, $params_goods);

	if ($list_goods) {
		foreach ($list_goods as $k => $v) {
			$list_goods[$k]['thumb_url'] = tomedia($v['thumb']);
			$list_goods[$k]['price_format'] = number_format($v['price'] / 100, 2);
			$list_goods[$k]['original_price_format'] = number_format($v['original_price'] / 100, 2);
		}
	}

	$data_bak = array(
		'list'=>$list_goods,
	);

	return result(0, 'ok', $data_bak);
}

// 新版商城-收藏
function store_collect()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']);
	if ($uid == 0) {
		return result(1, '用户ID不存在');
	}

	$pid = intval($_GPC['pid']);
	$ver = $_GPC['ver'];

	$operation = $_GPC['op'] ? $_GPC['op'] : 'display';
	if ($operation == 'display') {
		$condition_collect = " AND uniacid=:uniacid AND from_user=:uid ";
		$params_collect = array(':uniacid' => $_W['uniacid'], ':uid'=>$uid);
		$pindex_collect = max(1, intval($_GPC['page']));
		$psize_collect = 1000;
		$sql_collect = "SELECT goodsid FROM " . sl_table_name('store_collect',TRUE) . ' WHERE 1 '
			. $condition_collect . " ORDER BY displayorder DESC, id DESC LIMIT "
			. ($pindex_collect - 1) * $psize_collect .',' .$psize_collect;
		$list_collect = pdo_fetchall($sql_collect, $params_collect);

		if ($list_collect) {
			$flags = '';
			foreach ($list_collect as $item) {
				$flags .= $item['goodsid'] . ',';
			}

			$flags = substr($flags, 0, strlen($flags)-1);
			$where =' AND id in(' . $flags . ')';

			$condition_goods = " AND uniacid=:uniacid AND deleted='0' AND brandid='0' ";
			$condition_goods .= $where;
			$params_goods = array(':uniacid' => $_W['uniacid']);
			$pindex_goods = max(1, intval($_GPC['page']));
			$psize_goods = 10;
			$sql_goods = "SELECT * FROM " . sl_table_name('store_goods',TRUE) . ' WHERE 1 '
				. $condition_goods . " ORDER BY displayorder DESC, id DESC LIMIT "
				. ($pindex_goods - 1) * $psize_goods .',' .$psize_goods;

			$list_goods = pdo_fetchall($sql_goods, $params_goods);

			if ($list_goods) {
				foreach ($list_goods as $k => $v) {
					$list_goods[$k]['thumb_url'] = tomedia($v['thumb']);
					$list_goods[$k]['price_format'] = number_format($v['price'] / 100, 2);
					$list_goods[$k]['original_price_format'] = number_format($v['original_price'] / 100, 2);
				}
			}
		}

		$data_bak = array(
			'list'=>$list_goods,
		);

		return result(0, 'ok', $data_bak);


	} else if ($operation == 'post') {
		$goods_id = intval($_GPC['id']); // 商品ID

		$collect_str = trim($_GPC['iscollect']); // 是否收藏
		$collect_str = strtoupper($collect_str);
		$is_collect = $data['iscollect'] = $collect_str == 'TRUE' ? 1 : 0; // 1=收藏，0=取消收藏

		if ($is_collect == 1) {
			$condition_goods = " AND uniacid=:uniacid AND from_user=:from_user AND goodsid=:goodsid ";
			$params_goods = array(':uniacid' => $_W['uniacid'], ':from_user'=>$uid, ':goodsid'=>$goods_id);
			$one_goods = pdo_fetch("SELECT * FROM " . sl_table_name('store_collect',TRUE) . ' WHERE 1 '
				. $condition_goods, $params_goods);

			if (empty($one_goods)) {
				$data = array(
					'uniacid' => $_W['uniacid'],
					'from_user' => $uid,
					'goodsid' => $goods_id,
				);
				$data['addtime'] = $_W['slwl']['datetime']['now'];
				$rst = pdo_insert('slwl_aicard_store_collect', $data);
				// $id = pdo_insertid();


				if ($rst !== FALSE) {
					return result(0, '成功');
				} else {
					return result(1, '失败');
				}
			} else {
				return result(0, 'err', '收藏商品已存在');
			}
		} else {
			$condition_goods = " AND uniacid=:uniacid AND from_user=:from_user AND goodsid=:goodsid ";
			$params_goods = array(':uniacid' => $_W['uniacid'], ':from_user'=>$uid, ':goodsid'=>$goods_id);
			$one_goods = pdo_fetch("SELECT * FROM " . sl_table_name('store_collect',TRUE) . ' WHERE 1 '
				. $condition_goods, $params_goods);

			if (empty($one_goods)) {
				return result(2, '收藏商品不存在');
			}
			$rst = pdo_delete('slwl_aicard_store_collect', array('id' => $one_goods['id'], "uniacid" => $_W['uniacid']));

			if ($rst !== FALSE) {
				return result(0, '成功');
			} else {
				return result(1, '失败');
			}
		}
	}
}

// 新版商城-地址
function store_address()
{
	global $_GPC, $_W;

	// $ver = $_GPC['ver'];
	$uid = intval($_GPC['uid']);
	// if ($ver == '') { return result(1, '版本不存在'); }
	if ($uid == 0) { return result(1, '用户ID不存在'); }

	$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

	if ($operation == 'display') {
		$condition_address = " AND uniacid=:uniacid AND uid=:uid ";
		$params_address = array(':uniacid' => $_W['uniacid'], ':uid'=>$uid);
		$pindex_address = max(1, intval($_GPC['page']));
		$psize_address = 10;
		$sql_address = "SELECT * FROM " . sl_table_name('store_address',TRUE) . ' WHERE 1 '
			. $condition_address . " ORDER BY isdefault DESC, displayorder DESC, id DESC LIMIT "
			. ($pindex_address - 1) * $psize_address .',' .$psize_address;

		$list_address = pdo_fetchall($sql_address, $params_address);

		$data_bak = array(
			'list'=>$list_address,
		);
		return result(0, 'ok', $data_bak);


	} else if ($operation == 'post') {
		$id = intval($_GPC['id']);
		if ($id) {
			$data = array();
			if (isset($_GPC['name'])) {
				$data['realname'] = $_GPC['name'];
			}
			if (isset($_GPC['mobile'])) {
				$data['mobile'] = $_GPC['mobile'];
			}
			if (isset($_GPC['province'])) {
				$data['province'] = $_GPC['province'];
			}
			if (isset($_GPC['city'])) {
				$data['city'] = $_GPC['city'];
			}
			if (isset($_GPC['area'])) {
				$data['area'] = $_GPC['area'];
			}
			if (isset($_GPC['address'])) {
				$data['address'] = $_GPC['address'];
			}
			if (isset($_GPC['isdefault'])) {
				$data['isdefault'] = $_GPC['isdefault'] == 'TRUE' ? 1 : 0;
				pdo_update('slwl_aicard_store_address', array('isdefault'=>0), array('uid' => $uid));
			}
			$rst = pdo_update('slwl_aicard_store_address', $data, array('id' => $id));
			if ($rst !== FALSE) {
				return result(0, '成功');
			} else {
				return result(1, '失败');
			}
		} else {
			if (trim($_GPC['name']) == '') {
				return result(1, '失败-姓名不能为空') ;
			}
			if (trim($_GPC['mobile']) == '') {
				return result(1, '失败-手机不能为空') ;
			}
			if (trim($_GPC['province']) == '') {
				return result(1, '失败-省份不能为空') ;
			}
			if (trim($_GPC['city']) == '') {
				return result(1, '失败-城市不能为空') ;
			}
			if (trim($_GPC['area']) == '') {
				return result(1, '失败-地区不能为空') ;
			}
			if (trim($_GPC['address']) == '') {
				return result(1, '失败-详细地址不能为空') ;
			}
			$data = array(
				'uniacid' => $_W['uniacid'],
				'uid' => $uid,
				'realname' => $_GPC['name'],
				'mobile' => $_GPC['mobile'],
				'province' => $_GPC['province'],
				'city' => $_GPC['city'],
				'area' => $_GPC['area'],
				'address' => $_GPC['address'],
				'isdefault' => $_GPC['isdefault'],
				'addtime' => $_W['slwl']['datetime']['now'],
			);
			$rst = pdo_insert('slwl_aicard_store_address', $data);
			$id = pdo_insertid();
			if ($rst !== FALSE) {
				return result(0, '成功', array('id' => $id));
			} else {
				return result(1, '失败');
			}
		}
		return result(0, 'ok');


	} else if ($operation == 'delete') {
		$id = intval($_GPC['id']);

		$rst = pdo_delete('slwl_aicard_store_address', array('id' => $id, "uniacid" => $_W['uniacid']));
		if ($rst !== FALSE) {
			return result(0, '成功');
		} else {
			return result(1, '不存在或已删除');
		}


	} else {
		return result(1, 'err');
	}
}

// 新版商城-优惠券，列表
function store_coupon()
{
	global $_GPC, $_W;
	$uid = intval($_GPC['uid']);
	if ($uid == 0) {
		return result(1, '用户ID不存在');
	}

	$condition_coupon = " AND uniacid=:uniacid ";
	$params_coupon = array(':uniacid' => $_W['uniacid']);
	$pindex_coupon = max(1, intval($_GPC['page']));
	$psize_coupon = 10;
	$sql_coupon = "SELECT * FROM " . sl_table_name('store_sale',TRUE) . ' WHERE 1 '
		. $condition_coupon . " ORDER BY displayorder DESC, id DESC LIMIT "
		. ($pindex_coupon - 1) * $psize_coupon .',' .$psize_coupon;
	$list_sale = pdo_fetchall($sql_coupon, $params_coupon);

	if ($list_sale) {
		foreach ($list_sale as $k => $v) {
			$time = json_decode($v['timedays2'], TRUE);
			if ($time['start']) {
				$list_sale[$k]['timestart'] = $time['start'];
			} else {
				$list_sale[$k]['timestart'] = '';
			}
			if ($time['end']) {
				$list_sale[$k]['timeend'] = $time['end'];
			} else {
				$list_sale[$k]['timeend'] = '';
			}

			if ($v['timelimit']=='0') {
				if ($v['timedays1'] == '0') {
					$list_sale[$k]['use_end_time'] = '无使用期制';
				} else {
					$list_sale[$k]['use_end_time'] = '获得后'.$v['timedays1'].'天有效';
				}
			} else {
				$list_sale[$k]['use_end_time'] = $time['start'].'-'.$time['end'];
				$timeend = strtotime($time['end']);
				if ($_W['slwl']['datetime']['timestamp'] > $timeend) {
					unset($list_sale[$k]);
				}
			}
		}

		$condition_sale_user = ' AND uniacid=:uniacid AND user=:user ';
		$params_sale_user = array(':uniacid' => $_W['uniacid'], ':user'=>$uid);
		$list_sale_user = pdo_fetchall("SELECT * FROM " . sl_table_name('store_sale_user',TRUE) . ' WHERE 1 '
			. $condition_sale_user, $params_sale_user);

		foreach ($list_sale as $k => $v) {
			if ($list_sale_user) {
				foreach ($list_sale_user as $key => $value) {
					if ($v['id'] == $value['saleid']) {
						$list_sale[$k]['isreceive'] = '1';
						break;
					}
				}
			} else {
				$list_sale[$k]['isreceive'] = '0';
			}

			$list_sale[$k]['backmoney_format'] = number_format($v['backmoney'] / 100, 0);
		}
	}

	return result(0, 'ok', $list_sale);
}

// 新版商城-我的优惠券，列表
function store_coupon_my()
{
	global $_GPC, $_W;
	$uid = intval($_GPC['uid']);

	if ($uid == 0) {
		return result(1, '用户ID不存在');
	}

	$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

	if ($operation == 'display') {
		$coupon_type = intval($_GPC['type']); // 0=未使用，1=已使用，2=已过期

		if ($coupon_type == '1') {
			$where =" AND (status='1' OR status='2') ";
		} else if ($coupon_type == '0') {
			$where =" AND (status='0' OR status='2') ";
		} else {
			$where =" AND status='0' ";
		}

		$condition_sale_my = " AND uniacid=:uniacid AND user=:user ";
		$condition_sale_my .= $where;
		$params_sale_my = array(':uniacid' => $_W['uniacid'], ':user' => $uid);
		$pindex_sale_my = max(1, intval($_GPC['page']));
		$psize_sale_my = 10;
		$sql_sale_my = "SELECT * FROM " . sl_table_name('store_sale_user',TRUE) . ' WHERE 1 '
			. $condition_sale_my . " ORDER BY id DESC LIMIT " . ($pindex_sale_my - 1) * $psize_sale_my .',' .$psize_sale_my;
		$list_sale_my = pdo_fetchall($sql_sale_my, $params_sale_my);

		if ($list_sale_my) {
			foreach ($list_sale_my as $k => $v) {
				$option = json_decode($v['option_value'], TRUE);

				$list_sale_my[$k]['intro'] = $option['intro'];
				$list_sale_my[$k]['thumb'] = $option['thumb'];
				$list_sale_my[$k]['thumb_url'] = tomedia($option['thumb']);
				$list_sale_my[$k]['enough'] = $option['enough'];
				$list_sale_my[$k]['timelimit'] = $option['timelimit'];
				$list_sale_my[$k]['backtype'] = $option['backtype'];
				$list_sale_my[$k]['backmoney'] = $option['backmoney'];
				$list_sale_my[$k]['backmoney_format'] = number_format($v['backmoney'] / 100, 2);
				$list_sale_my[$k]['discount'] = $option['discount'];

				if ($option['timelimit']=='0') {
					if ($option['timedays1'] == '0') {
						$list_sale_my[$k]['use_end_time'] = '无使用期限制';
						$list_sale_my[$k]['usable'] = '1';
					} else {
						$datetime1 = new DateTime($v['time_start']);
						$datetime2 = new DateTime($v['time_end']);
						// $interval = $datetime1->diff($datetime2);
						// $list_sale_my[$k]['use_end_time'] = $interval->format('有效期 %a 天');
						$list_sale_my[$k]['use_end_time'] = $datetime1->format('Y-m-d').' 至 '.$datetime2->format('Y-m-d');
					}
				} else {
					$datetime1 = new DateTime($v['time_start']);
					$datetime2 = new DateTime($v['time_end']);
					$list_sale_my[$k]['use_end_time'] = $datetime1->format('Y-m-d').' 至 '.$datetime2->format('Y-m-d');
				}

				$timestart = strtotime($v['time_start']);
				$timeend = strtotime($v['time_end']);
				// 是否可用
				if ($_W['slwl']['datetime']['timestamp'] > $timestart && $_W['slwl']['datetime']['timestamp'] < $timeend) {
					$list_sale_my[$k]['usable'] = '1';
				} else {
					$list_sale_my[$k]['usable'] = '0';
				}

				if ($_W['slwl']['datetime']['timestamp'] > $timeend) {
					if ($coupon_type == '0') {
						pdo_update('slwl_aicard_store_sale_user', array('status' => '2'), array('id' => $v['id']));
						unset($list_sale_my[$k]);
					}
				}
			}
		}

		foreach ($list_sale_my as $k => $v) {
			$list_sale_my[$k]['backmoney_format'] = number_format($v['backmoney'] / 100, 0);
		}

		$data_bak = $list_sale_my;

		return result(0, 'ok', $data_bak);


	} else if ($operation == 'add') {
		$id = intval($_GPC['id']); // 优惠券的ID

		$condition = ' AND uniacid=:uniacid AND user=:user AND saleid=:saleid ';
		$params = array(':uniacid' => $_W['uniacid'], ':user'=>$uid, ':saleid'=>$id);
		$sale = pdo_fetch("SELECT * FROM " . sl_table_name('store_sale_user',TRUE) . ' WHERE 1 ' . $condition, $params);

		if ($sale) {
			return result(1, '不能重复领取');
		} else {
			$condition_sale = ' AND uniacid=:uniacid AND id=:id ';
			$params_sale = array(':uniacid' => $_W['uniacid'], ':id'=>$id);
			$one_sale = pdo_fetch("SELECT * FROM " . sl_table_name('store_sale',TRUE) . ' WHERE 1 ' . $condition_sale, $params_sale);

			if ($one_sale) {
				if ($one_sale['total'] > 0) {
					$data = array(
						'uniacid' => $_W['uniacid'],
						'user' => $uid,
						'saleid' => $id,
						'title' => $one_sale['title'],
						'addtime' => $_W['slwl']['datetime']['now'],
					);
					$data['option_value'] = json_encode(array(
						'intro'=>$one_sale['intro'],
						'thumb'=>$one_sale['thumb'],
						'enough'=>$one_sale['enough'],
						'timelimit'=>$one_sale['timelimit'],
						'timedays1'=>$one_sale['timedays1'],
						'timedays2'=>$one_sale['timedays2'],
						'backtype'=>$one_sale['backtype'],
						'backmoney'=>$one_sale['backmoney'],
						'discount'=>$one_sale['discount'],
						'flbackmoney'=>$one_sale['flbackmoney'],
						'backwhen'=>$one_sale['backwhen'],
					));
					if ($one_sale['timelimit'] == '0') {
						$data['time_start'] = $_W['slwl']['datetime']['now000000'];
						if ($one_sale['timedays1'] == '0') {
							$data['time_end'] = date('Y-m-d 23:59:59', strtotime('+3650 days', $_W['slwl']['datetime']['timestamp']));
						} else {
							$data['time_end'] = date('Y-m-d 23:59:59', strtotime('+'.$one_sale['timedays1'].' days', $_W['slwl']['datetime']['timestamp']));
						}
					} else {
						$time = json_decode($one_sale['timedays2'], TRUE);
						if ($time['start']) {
							$data['time_start'] = $time['start'];
						} else {
							$data['time_start'] = '';
						}
						if ($time['end']) {
							$data['time_end'] = $time['end'] . ' 23:59:59';
						} else {
							$data['time_end'] = '';
						}
					}
					$rst = pdo_insert('slwl_aicard_store_sale_user', $data);

					$rst_2 = pdo_query("UPDATE " . sl_table_name('store_sale',TRUE) . " SET total=total-1, receive=receive+1 WHERE id=:id ", array(':id'=>$one_sale['id']));

					if ($rst !== FALSE) {
						if ($rst_2 !== FALSE) {
							return result(0, '领取成功');
						} else {
							return result(1, '减少数量出错');
						}
					} else {
						return result(1, '领取失败');
					}
				} else {
					return result(1, '没有了下次早点');
				}
			} else {
				return result(1, '券不存在');
			}
		}
	} else {
		return result(1, '不存在的方法');
	}
}

// 新版商城-我的购物车
function store_cart()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']);
	if ($uid == 0) {
		return result(1, '用户ID不存在');
	}
	$op = $_GPC['op'];

	if ($op == 'add') {
		$goodsid = intval($_GPC['id']);
		$count = intval($_GPC['count']);
		// $spec = $_GPC['spec'];
		$count = empty($count) ? 1 : $count;
		$option_id = $_GPC['optionsID'];

		$goods = pdo_fetch("SELECT * FROM " . sl_table_name('store_goods',TRUE) . " WHERE id = :id", array(':id' => $goodsid));
		if (empty($goods)) {
			return result(1, '抱歉，该商品不存在或是已经被删除！', $goods);
		}
		unset($goods['content']);

		// 查规格
		$condition_goods_option = " AND uniacid=:uniacid AND goodid=:goodid ";
		$params_goods_option = array(':uniacid' => $_W['uniacid'], ':goodid' => $goodsid);
		$sql_goods_option = "SELECT * FROM " . sl_table_name('store_goods_option',TRUE) . ' WHERE 1 ' . $condition_goods_option;
		$one_goods_option = pdo_fetch($sql_goods_option, $params_goods_option);
		if ($one_goods_option) {
			$goods_option = $one_goods_option;
		} else {
			$goods_option = array();
		}

		$condition = " AND uniacid=:uniacid AND from_user=:from_user AND goodsid = :goodsid AND option_id=:option_id ";
		$params = array(':uniacid'=>$_W['uniacid'], ':from_user'=>$uid, ':goodsid'=>$goodsid, ':option_id'=>$option_id);
		$one = pdo_fetch('SELECT id, count FROM ' . sl_table_name('store_cart',TRUE) . ' WHERE 1 ' . $condition, $params);

		$good_count_price = $goods['price'] * $count;

		if (!$one) {
			//不存在
			$data = array(
				'uniacid' => $_W['uniacid'],
				'goodsid' => $goodsid,
				'goodstype' => $goods['type'],
				'price' => $good_count_price,
				'from_user' => $uid,
				'option_id' => $option_id,
				'option' => json_encode($goods_option),
				'count' => $count,
				'addtime' => $_W['slwl']['datetime']['now'],

			);
			$rst = pdo_insert('slwl_aicard_store_cart', $data);
			$id = pdo_insertid();

			$data_bak = array(
				'id'=> $id,
			);
			if ($rst !== FALSE) {
				return result(0, 'ok', $data_bak);
			} else {
				return result(1, 'err');
			}
		} else {
			//累加最多限制购买数量
			$count_total = $count + $one['count'];

			//存在
			$data = array(
				'price' => $good_count_price,
				'count' => $count_total,
				'option' => json_encode($goods_option),
				'option_id' => $option_id
			);
			$rst = pdo_update('slwl_aicard_store_cart', $data, array('id' => $one['id']));
			if ($rst !== FALSE) {
				return result(0, 'ok');
			} else {
				return result(1, 'err');
			}
		}


	} else if ($op == 'clear') {
		$rst = pdo_delete('slwl_aicard_store_cart', array('from_user' => $uid, 'uniacid' => $_W['uniacid']));
		if ($rst !== FALSE) {
			return result(0, 'ok');
		} else {
			return result(1, 'err');
		}


	} else if ($op == 'delete') {
		$id = intval($_GPC['id']);

		$rst = pdo_delete('slwl_aicard_store_cart', array('from_user' => $uid, 'uniacid' => $_W['uniacid'], 'id' => $id));
		if ($rst !== FALSE) {
			return result(0, 'ok');
		} else {
			return result(1, 'err');
		}


	} else if ($op == 'update') {
		$id = intval($_GPC['id']);
		$data = array();
		if (isset($_GPC['count'])) {
				$data['count'] = $_GPC['count'];
			}
		if (isset($_GPC['checked'])) {
			$data['checked'] = $_GPC['checked'] == 'TRUE' ? 1 : 0;
		}
		$rst = pdo_update('slwl_aicard_store_cart', $data, array('id' => $id));

		if ($rst !== FALSE) {
			return result(0, 'ok');
		} else {
			return result(1, 'err');
		}


	// 全选与反选
	} else if ($op == 'check') {
		$type = $_GPC['type'];
		if ($type == 'all') {
			$rst = pdo_update('slwl_aicard_store_cart', array('checked'=>'1'), array('from_user' => $uid));
		} else if ($type == 'clean') {
			$rst = pdo_update('slwl_aicard_store_cart', array('checked'=>'0'), array('from_user' => $uid));
		}

		if ($rst !== FALSE) {
			return result(0, 'ok');
		} else {
			return result(1, 'err');
		}


	} else {
		$condition_cart = " AND uniacid=:uniacid AND from_user=:uid ";
		$params_cart = array(':uniacid' => $_W['uniacid'], ':uid' => $uid);
		$pindex_cart = max(1, intval($_GPC['page']));
		$psize_cart = 100;
		$sql_cart = "SELECT * FROM " . sl_table_name('store_cart',TRUE) . ' WHERE 1 '
			. $condition_cart . " ORDER BY id DESC LIMIT " . ($pindex_cart - 1) * $psize_cart . ',' .$psize_cart;
		$list_cart = pdo_fetchall($sql_cart, $params_cart);

		if ($list_cart) {
			$flags = '';
			$flags_option = '';
			foreach ($list_cart as $item) {
				$flags .= $item['goodsid'] . ',';
				$flags_option .= $item['option_id'] . ',';
			}
			$flags = substr($flags, 0, strlen($flags)-1);
			$where =' AND id IN(' . $flags . ')';

			$flags_option = substr($flags_option, 0, strlen($flags_option)-1);
			$where_option =' AND id IN(' . $flags_option . ')';

			// 查商品
			$condition_goods = " AND uniacid=:uniacid ";
			$condition_goods .= $where;
			$params_goods = array(':uniacid' => $_W['uniacid']);
			$pindex_goods = max(1, intval($_GPC['page']));
			$psize_goods = 10;
			$sql_goods = "SELECT * FROM " . sl_table_name('store_goods',TRUE). ' WHERE 1 '
				. $condition_goods . " ORDER BY displayorder DESC, id DESC LIMIT "
				. ($pindex_goods - 1) * $psize_goods .',' .$psize_goods;
			$list_goods = pdo_fetchall($sql_goods, $params_goods);

			// 查选项
			$condition_goods_option = " AND uniacid=:uniacid ";
			$condition_goods_option .= $where_option;
			$params_goods_option = array(':uniacid' => $_W['uniacid']);
			$pindex_goods_option = max(1, intval($_GPC['page']));
			$psize_goods_option = 10;
			$sql_goods_option = "SELECT * FROM " . sl_table_name('store_goods_option',TRUE) . ' WHERE 1 '
				. $condition_goods_option . " ORDER BY displayorder DESC, id DESC LIMIT "
				. ($pindex_goods_option - 1) * $psize_goods_option .',' .$psize_goods_option;
			$list_goods_option = pdo_fetchall($sql_goods_option, $params_goods_option);

			foreach ($list_cart as $k => $v) {
				foreach ($list_goods as $key => $value) {
					if ($v['goodsid'] == $value['id']) {
						$value['thumb_url'] = tomedia($value['thumb']);
						$value['price_format']   = number_format($value['price'] / 100, 2);
						$value['original_price_format']  = number_format($value['original_price'] / 100, 2);
						$list_cart[$k]['goods'] = $value;
						break;
					}
				}

				$list_cart[$k]['good_stauts'] = 0;
				foreach ($list_goods_option as $key => $value) {
					if ($v['option_id'] == $value['id']) {
						// dump($value);exit;
						$option_array = json_decode($value['assemble_json'], TRUE);

						foreach ($option_array as $key_k => $value_v) {
							$option_array[$key_k]['thumb_url'] = tomedia($value_v['thumb']);
						}

						$value['price_format']   = number_format($value['price'] / 100, 2);
						$value['original_price_format']  = number_format($value['original_price'] / 100, 2);
						$value['assemble_format'] = $option_array;
						unset($value['assemble_json']);

						$list_cart[$k]['good_option'] = $value;
						$list_cart[$k]['good_stauts'] = 1;
						break;
					}
				}
			}
		} else {
			$list_cart = array();
		}

		$data_bak = array(
			'list'=>$list_cart,
		);

		return result(0, 'ok', $data_bak);
	}
}

// 新版商城-品牌商
function store_brand()
{
	global $_GPC, $_W;

	$condition = " AND uniacid=:uniacid AND enabled='1' ";
	$params = array(':uniacid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$sql = "SELECT * FROM " . sl_table_name('store_brand',TRUE) . ' WHERE 1 '
		. $condition . " ORDER BY displayorder DESC, id ASC LIMIT " . ($pindex - 1) * $psize . ',' .$psize;
	$list = pdo_fetchall($sql, $params);

	foreach ($list as $k => $v) {
		$list[$k]['thumb_url'] = tomedia($v['thumb']);
		$list[$k]['thumb_brand_url'] = tomedia($v['thumb_brand']);
	}

	return result(0, 'ok', $list);
}

// 新版商城-品牌商-只获取一条
function store_brand_one()
{
	global $_GPC, $_W;
	$id = intval($_GPC['id']);

	$condition = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
	$params = array(':uniacid' => $_W['uniacid'], ':id'=>$id);
	$one = pdo_fetch('SELECT * FROM ' . sl_table_name('store_brand',TRUE) . ' WHERE 1 '
		. $condition . ' ORDER BY displayorder DESC, id DESC', $params);

	if ($one) {
		$one['thumb_brand_url'] = tomedia($one['thumb_brand']);
	}

	$data_bak = array(
		'one'=>$one,
	);

	return result(0, 'ok', $data_bak);
}

// 新版商城-获取指定品牌商的商品
function store_brand_one_goods()
{
	global $_GPC, $_W;

	$list = array();
	if ($_GPC['id']) {
		$id = intval($_GPC['id']);

		$condition = " AND uniacid=:uniacid AND brandid=:brandid ";
		$params = array(':uniacid' => $_W['uniacid'], ':brandid'=>$id);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$fields = ' id,title,thumb,price,original_price ';
		$sql = "SELECT ". $fields . " FROM " . sl_table_name('store_goods',TRUE). ' WHERE 1 '
			. $condition . " ORDER BY displayorder DESC, id ASC LIMIT " . ($pindex - 1) * $psize . ',' .$psize;
		$list = pdo_fetchall($sql, $params);

		if ($list) {
			foreach ($list as $k => $v) {
				$list[$k]['thumb_url'] = tomedia($v['thumb']);
				$list[$k]['price_format']   = number_format($v['price'] / 100, 2);
				$list[$k]['original_price_format']  = number_format($v['original_price'] / 100, 2);
			}
		}
	}

	return result(0, 'ok', $list);
}

// 新版商城-订单
function store_order()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']);
	if ($uid == 0) {
		return result(1, '用户ID不存在');
	}
	$op = $_GPC['op'];

	if ($op == 'add') {
		$order_json = $_GPC['__input']; // 参数

		if ($order_json) {
			// 地址ID
			$address_id = isset($order_json['address']) ? $order_json['address'] : '';
			// 是否购物车购买，0=立即购买，1=购物车购买
			$settle_accounts = isset($order_json['cart']) ? $order_json['cart'] : '';
			// 商品
			$goods_items = isset($order_json['items']) ? $order_json['items'] : '';
			// 优惠券ID
			$coupon_id = isset($order_json['coupon']) ? $order_json['coupon'] : '';
		}

		if (empty($goods_items)) {
			return result(1, '商品不能为空');
		}

		// 读取地址
		$condition_address = ' AND uniacid=:uniacid AND id=:id ';
		$params_address = array(':uniacid' => $_W['uniacid'], ':id'=>$address_id);
		$address = pdo_fetch('SELECT * FROM ' . sl_table_name('store_address',TRUE) . ' WHERE 1 ' . $condition_address, $params_address);

		if (empty($address)) {
			return result(1, '请您填写收货地址');
		}

		$goodsAmount = 0; // 总价格
		$total = 0; // 总商品数
		$goods_all = []; // 所有商品列表
		if ($settle_accounts == '0') {
			$condition_goods = " AND uniacid=:uniacid AND deleted='0' AND id=:id ";
			$params_goods = array(':uniacid' => $_W['uniacid'], ':id' => $goods_items[0]['id']);
			$sql_goods = "SELECT * FROM " . sl_table_name('store_goods',TRUE) . ' WHERE 1 ' . $condition_goods;
			$list_goods = pdo_fetchall($sql_goods, $params_goods);
			// dump(pdo_debug());

			if ($list_goods) {
				foreach ($list_goods as $k => $v) {
					if ($v['inventory'] <= 0) {
						return result(1, '库存不足');
					}
				}
			} else {
				return result(1, '商品不存在');
			}

			// 算总价格
			if ($list_goods) {
				// 加入规格 与 购买数量
				if ($goods_items[0]['optionsID'] > 0) {
					$condition_goods_option = " AND uniacid=:uniacid AND id=:id ";
					$params_goods_option = array(':uniacid' => $_W['uniacid'], ':id' => $goods_items[0]['optionsID']);
					$sql_goods_option = "SELECT * FROM " . sl_table_name('store_goods_option',TRUE) . ' WHERE 1 '
						. $condition_goods_option;
					$one_goods_option = pdo_fetch($sql_goods_option, $params_goods_option);

					foreach ($list_goods as $k => $v) {
						$goodsAmount += $one_goods_option['price'] * $goods_items[0]['number'];
					}

					$assemble_array = array();
					if ($one_goods_option['assemble_json']) {
						$tmp_assemble_array = json_decode($one_goods_option['assemble_json'], TRUE);
						unset($one_goods_option['assemble_json']);

						foreach ($tmp_assemble_array as $key => $value) {
							$value['thumb_url'] = tomedia($value['thumb']);
							$assemble_array[] = $value;
						}

						$one_goods_option['assemble_array'] = $assemble_array;
					}

					$list_goods[0]['option'] = $one_goods_option;
				} else {
					foreach ($list_goods as $k => $v) {
						$goodsAmount += $v['price'] * $goods_items[0]['number'];
					}
				}

				foreach ($list_goods as $k => $v) {
					$list_goods[$k]['price'] = $v['price'];
					$list_goods[$k]['price_format'] = number_format($v['price'] / 100, 2);
					$list_goods[$k]['thumb_url'] = tomedia($v['thumb']);
					$list_goods[$k]['number'] = $goods_items[0]['number'];

					if ($v['spec_status'] == '1') {
						$rst_count_decrease = pdo_query("UPDATE " . sl_table_name('store_goods_option',TRUE)
							. " SET inventory=inventory-1 WHERE id=:id ", array(':id'=>$goods_items[0]['optionsID']));
						if ($rst_count_decrease === FALSE) {
							iajax(1, '减少库存出错');
						}
					} else {
						$rst_count_decrease = pdo_query("UPDATE " . sl_table_name('store_goods',TRUE)
							. " SET inventory=inventory-1 WHERE id=:id ", array(':id'=>$v['id']));
						if ($rst_count_decrease === FALSE) {
							iajax(1, '减少库存出错');
						}
					}
				}

				$total = 1;
				$goods_all = $list_goods;
			} else {
				return result(1, '商品不存在');
			}
		} else {
			// ID=购物车项的ID，optionsID=规格ID
			if ($goods_items) {
				$flags = '';
				$flags_options = '';
				foreach ($goods_items as $item) {
					$flags .= $item['id'] . ',';
					$flags_options .= $item['optionsID'] . ',';
				}
				$flags = substr($flags, 0, strlen($flags)-1);
				$flags_options = substr($flags_options, 0, strlen($flags_options)-1);
				$where_cart =' AND id in(' . $flags . ')';
				$where_goods_option =' AND id in(' . $flags_options . ')';
			}

			// 购物车
			$condition_cart = " AND uniacid=:uniacid ";
			$condition_cart .= $where_cart;
			$params_cart = array(':uniacid' => $_W['uniacid']);
			$sql_cart = "SELECT * FROM " . sl_table_name('store_cart',TRUE) . ' WHERE 1 '
				. $condition_cart . " ORDER BY id DESC ";
			$list_cart = pdo_fetchall($sql_cart, $params_cart);

			if (empty($list_cart)) {
				return result(1, '购买车为空');
			}

			if ($list_cart) {
				$flags = '';
				foreach ($list_cart as $item) {
					$flags .= $item['goodsid'] . ',';
				}
				$flags = substr($flags, 0, strlen($flags)-1);
				$where_goods =' AND id in(' . $flags . ')';
			}

			// 查商品
			$condition_goods = " AND uniacid=:uniacid AND deleted='0' ";
			$condition_goods .= $where_goods;
			$params_goods = array(':uniacid' => $_W['uniacid']);
			$sql_goods = "SELECT * FROM " . sl_table_name('store_goods',TRUE) . ' WHERE 1 '
				. $condition_goods . " ORDER BY id DESC ";
			$list_goods = pdo_fetchall($sql_goods, $params_goods);

			// 查规格
			$condition_goods_options = " AND uniacid=:uniacid ";
			$condition_goods_options .= $where_goods_option;
			$params_goods_options = array(':uniacid' => $_W['uniacid']);
			$sql_goods_options = "SELECT * FROM " . sl_table_name('store_goods_option',TRUE) . ' WHERE 1 ' . $condition_goods_options . " ORDER BY id DESC ";
			$list_goods_options = pdo_fetchall($sql_goods_options, $params_goods_options);

			// return result(1, pdo_debug());
			if ($goods_items[0]['optionsID'] > 0 && empty($list_goods_options)) {
				return result(1, '规格项不存在');
			}

			foreach ($list_goods as $k => $v) {
				$list_goods[$k]['price_format'] = number_format($v['price'] / 100, 2);
				$list_goods[$k]['thumb_url'] = tomedia($v['thumb']);

				if ($v['spec_status'] == '1') {
					foreach ($list_goods_options as $key => $value) {
						if ($v['option_id'] == $value['id']) {
							$rst_count_decrease = pdo_query("UPDATE " . sl_table_name('store_goods_option',TRUE)
								. " SET inventory=inventory-1 WHERE id=:id ", array(':id'=>$value['id']));
							if ($rst_count_decrease === FALSE) {
								iajax(1, '减少库存出错');
							}
							break;
						}
					}
				} else {
					$rst_count_decrease = pdo_query("UPDATE " . sl_table_name('store_goods',TRUE)
						. " SET inventory=inventory-1 WHERE id=:id ", array(':id'=>$v['id']));
					if ($rst_count_decrease === FALSE) {
						iajax(1, '减少库存出错');
					}
				}
			}

			// 购物车项加入传的参数
			foreach ($list_cart as $k => $v) {
				// 加入规格选项前端保存
				foreach ($goods_items as $key => $value) {
					if ($v['id'] == $value['id']) {
						$list_cart[$k]['number'] = $value['number'];
						$list_cart[$k]['option_id'] = $value['optionsID'];
						break;
					}
				}

				// 加入商品
				foreach ($list_goods as $key => $value) {
					if ($v['goodsid'] == $value['id']) {
						// 自定义参数
						$value['param_format'] = json_decode($value['param'], TRUE);
						// 商品图
						$value['thumb_url'] = tomedia($value['thumb']);
						// 其它图片
						$thumbs = json_decode($value['thumbs'], TRUE);
						if ($thumbs) {
							foreach ($thumbs as $key_k => $value_v) {
								$value['thumbs_url'][] = tomedia($value_v);
							}
						}
						$list_cart[$k]['good'] = $value;
						unset($value['content']);
						unset($value['param']);
						unset($value['spec']);
						unset($value['thumb']);
						unset($value['thumbs']);
					}
				}

			}
			// 加入规格 与 购买数量
			if ($list_goods_options) {
				foreach ($list_cart as $k => $v) {
					foreach ($list_goods_options as $key => $value) {
						if ($v['option_id'] == $value['id']) {
							$value['assemble_array']= json_decode($value['assemble_json'], TRUE);
							unset($value['assemble_json']);

							$list_cart[$k]['good']['option'] = $value;
							$list_cart[$k]['good']['price'] = $value['price'];
							$list_cart[$k]['good']['number'] = $v['number'];
							break;
						}
					}
				}
			} else {
				foreach ($list_cart as $k => $v) {
					$list_cart[$k]['good']['number'] = $v['number'];
				}
			}

			// 算总价格
			foreach ($list_cart as $k => $v) {
				// return result(1, $v);
				$goodsAmount += ($v['good']['price'] * $v['good']['number']);
			}

			 // 所有商品
			foreach ($list_cart as $k => $v) {
				$goods_all[] = $v['good'];
			}

			// 总商品数
			$total = count($list_cart);
		}

		// 优惠券
		if ($coupon_id) {
			// 我的优惠券
			$condition_coupon_my = " AND uniacid=:uniacid AND user=:user AND id=:id AND status='0' ";
			$params_coupon_my = array(':uniacid' => $_W['uniacid'], ':user'=>$uid, ':id'=>$coupon_id);
			$one_coupon_my = pdo_fetch('SELECT * FROM ' . sl_table_name('store_sale_user',TRUE) . ' WHERE 1 ' . $condition_coupon_my, $params_coupon_my);

			if ($one_coupon_my) {
				$condition_coupon = " AND uniacid=:uniacid AND id=:id ";
				$params_coupon = array(':uniacid' => $_W['uniacid'], ':id'=>$one_coupon_my['saleid']);
				$one_coupon = pdo_fetch('SELECT * FROM ' . sl_table_name('store_sale',TRUE) . ' WHERE 1 ' . $condition_coupon, $params_coupon);
			} else {
				return result(1, '我的优惠券不存在');
			}

			$discountsCount = 0; // 优惠金额
			if ($one_coupon) {
				if ($one_coupon['backtype'] == '0') {
					$discountsCount = $one_coupon['backmoney'];
				} else if ($one_coupon['backtype'] == '1') {
					$discountsCount = $goodsAmount * ((10 - $one_coupon['discount']) / 10);
				} else {
					// echo '3';
				}
			} else {
				return result(1, '优惠券不存在');
			}

			$goodsAmount = $goodsAmount - $discountsCount;
		}

		if ($goodsAmount < 0) {
			$goodsAmount = 0;
		}

		$data_order = array(
			'uniacid' => $_W['uniacid'],
			'from_user' => $uid,
			'ordersn' => 'SL' . date('YmdHis') . random(4, 1),
			'price' => $goodsAmount,
			'mark' => $_GPC['mark'],
			'address' => json_encode($address, JSON_UNESCAPED_UNICODE),
			'goods' => json_encode($goods_all, JSON_UNESCAPED_UNICODE),
			'discount_money' => $discountsCount,
			'goods_first_id' => $goods_all[0]['id'],
			'goods_first_price' => $goods_all[0]['price'],
			'total' => $total,
			'addtime' => $_W['slwl']['datetime']['now'],
		);

		if ($goodsAmount <= 0) {
			$data_order['status'] = 2;
		}

		if ($one_coupon) {
			$data_order['coupon'] = json_encode($one_coupon, JSON_UNESCAPED_UNICODE);
		}
		$rst_order = pdo_insert('slwl_aicard_store_order', $data_order);
		$order_id = pdo_insertid();
		$data_order['id'] = $order_id;

		if ($rst_order === FALSE) {
			return result(1, '插入订单商品失败');
		}

		if ($goodsAmount < 0) {
			sl_print($data_order); // 打印订单
		}

		// 修改优惠券状态
		$data_update = array(
			'status' => '1',
		);
		$rst_coupon_my = pdo_update('slwl_aicard_store_sale_user', $data_update, array('id' => $one_coupon_my['id']));
		if ($rst_coupon_my === FALSE) {
			return result(1, '使用优惠券失败');
		}

		//插入订单商品
		$err_order_goods = 0;
		foreach ($goods_all as $k => $v) {

			$data_order_goods = array(
				'uniacid' => $_W['uniacid'],
				'brandid' => $v['brandid'],
				'orderid' => $order_id,
				'goodsid' => $v['id'],
				'total' => $v['number'],
				'price' => $v['price'],
				'option_id' => $v['option']['id'],
				'option' => json_encode($v['option']),
				'addtime' => $_W['slwl']['datetime']['now'],
			);

			$rst_order_goods = pdo_insert('slwl_aicard_store_order_goods', $data_order_goods);

			if ($rst_order_goods === FALSE) {
				$err_order_goods += 1;
			}
		}

		if ($err_order_goods > 0) {
			return result(1, '插入订单商品失败');
		}

		// 清空购物车-选中商品
		if ($settle_accounts == '1') {
			// 1=购物车购买
			if ($goods_items) {
				$flags = '';
				foreach ($goods_items as $item) {
					$flags .= $item['id'] . ',';
				}

				if ($flags) {
					$flags = substr($flags, 0, strlen($flags)-1);
					$where_cart_clean = 'id IN(' . $flags . ')';

					$rst_delete_cart = pdo_delete("slwl_aicard_store_cart", $where_cart_clean);

					if ($rst_delete_cart === FALSE) {
						return result(1, '清空购物车选中商品失败');
					}
				}
			}
		}

		// 分销记录
		$rst = sl_store_commission_rebate($uid, $order_id, $goodsAmount, 'good');
		if ($rst && $rst['code'] != 0) {
			@putlog('健身房-分销回扣记录', $rst['msg']);
		}

		$data_bak = array(
			'order_id'=>$order_id,
		);
		return result(0, 'ok', $data_bak);


	// 设置已付款
	} else if ($op == 'update') {
		$order_id = intval($_GPC['id']);

		$condition_order = ' AND uniacid=:uniacid AND id=:id ';
		$params_order = array(':uniacid'=>$_W['uniacid'], ':id'=>$order_id);
		$one_order = pdo_fetch('SELECT * FROM ' . sl_table_name('store_order',TRUE)
			. ' WHERE 1 ' . $condition_order, $params_order);

		if (empty($one_order)) {
			return result(1, '订单不存在，请联系管理员');
		}

		$data_update = array(
			'status' => '2',
		);
		$rst = pdo_update('slwl_aicard_store_order', $data_update, array('id' => $order_id));

		if ($rst !== FALSE) {


			//打印


			return result(0, 'ok', array('status'=>'2'));
		} else {
			return result(1, 'err');
		}


	// 设置已收货
	} else if ($op == 'update_good_over') {
		$order_id = intval($_GPC['id']);

		$condition_order = ' AND uniacid=:uniacid AND id=:id ';
		$params_order = array(':uniacid'=>$_W['uniacid'], ':id'=>$order_id);
		$one_order = pdo_fetch('SELECT * FROM ' . sl_table_name('store_order',TRUE) . ' WHERE 1 '
			. $condition_order, $params_order);

		if (empty($one_order)) {
			return result(1, '订单不存在，请联系管理员');
		}

		$data_update = array(
			'status' => '4',
		);
		$rst = pdo_update('slwl_aicard_store_order', $data_update, array('id' => $order_id));

		if ($rst !== FALSE) {
			return result(0, 'ok', array('status'=>'4'));
		} else {
			return result(1, 'err');
		}


	} else if ($op == 'delete') {

	} else if ($op == 'detail') {
		$order_id = intval($_GPC['id']);
		// $open_type = intval($_GPC['type']); // 打开方式，1=下单跳转，其他正常打开

		$condition_order = ' AND uniacid=:uniacid AND id=:id ';
		$params_order = array(':uniacid'=>$_W['uniacid'], ':id'=>$order_id);
		$one_order = pdo_fetch('SELECT * FROM ' . sl_table_name('store_order',TRUE) . ' WHERE 1 '
			. $condition_order, $params_order);

		if (empty($one_order)) {
			return result(1, '订单不存在，请联系管理员');
		}

		// 地址信息
		if ($one_order['address']) {
			$list_address = json_decode($one_order['address'], TRUE);
		} else {
			return result(1, '地址信息不存在');
		}
		$one_order['address'] = $list_address;

		// 优惠券信息
		if ($one_order['coupon']) {
			$list_coupon = json_decode($one_order['coupon'], TRUE);
			$list_coupon['backmoney_format'] = number_format($list_coupon['backmoney'] / 100, 0);
		}
		$one_order['coupon'] = $list_coupon;

		// 商品信息
		if ($one_order['goods']) {
			$list_goods = json_decode($one_order['goods'], TRUE);
			foreach ($list_goods as $k => $v) {
				$list_goods[$k]['thumb_url'] = tomedia($v['thumb']);
				$list_goods[$k]['price_format']   = number_format($v['price'] / 100, 2);
				$list_goods[$k]['origina_price_format']  = number_format($v['original_price'] / 100, 2);

				if ($v['option']['assemble_array']) {
					foreach ($v['option']['assemble_array'] as $key => $value) {
						$list_goods[$k]['option']['assemble_array'][$key]['thumb_url'] = tomedia($value['thumb']);
					}
				}
			}
		} else {
			return result(1, '商品信息不存在');
		}
		$one_order['goods'] = $list_goods;

		$one_order['price_format'] = number_format($one_order['price'] / 100, 2);
		$one_order['discount_money_format'] = number_format($one_order['discount_money'] / 100, 2);
		$originalprice = $one_order['price'] + $one_order['discount_money']; // 原价 = 优惠后的价格 + 优惠价格
		$one_order['originalprice'] = $originalprice;
		$one_order['originalprice_format'] = number_format($originalprice / 100, 2);

		$data_bak = array(
			'order'=>$one_order,
		);

		$pay_bak = store_pay($uid, $one_order);

		if ($pay_bak['code'] == '0') {
			$data_bak['pay'] = array(
				'code'=>'0',
				'info'=>$pay_bak['data'],
			);
		} else {
			$data_bak['pay'] = array(
				'code'=>'1',
				'info'=>$pay_bak['data'],
			);
		}

		return result(0, 'ok', $data_bak);


	} else {
		$order_status_type = $_GPC['type']; // 状态，0=取消，1=待付款，2=待发货，3=待收货，4=已完成，5=退款

		if ($order_status_type == '0') {
			$where_st = " AND `status`='0' ";
		} else if ($order_status_type == '1') {
			$where_st = " AND `status`='1' ";
		} else if ($order_status_type == '2') {
			$where_st = " AND `status`='2' ";
		} else if ($order_status_type == '3') {
			$where_st = " AND `status`='3' ";
		} else if ($order_status_type == '4') {
			$where_st = " AND `status`='4' ";
		} else if ($order_status_type == '5') {
			$where_st = " AND `status`='5' ";
		} else {
		}

		$condition_order = " AND uniacid=:uniacid AND from_user=:uid ";
		$condition_order .= $where_st;
		$params_order = array(':uniacid' => $_W['uniacid'], ':uid'=>$uid);
		$pindex_order = max(1, intval($_GPC['page']));
		$psize_order = 10;
		$sql_order = "SELECT * FROM " . sl_table_name('store_order',TRUE). ' WHERE 1 '
			. $condition_order . " ORDER BY id DESC LIMIT "
			. ($pindex_order - 1) * $psize_order .',' .$psize_order;
		$list_order = pdo_fetchall($sql_order, $params_order);

		if ($list_order) {
			foreach ($list_order as $k => $v) {
				// 地址信息
				if ($v['address']) {
					$list_address_tmp = json_decode($v['address'], TRUE);
				}
				$list_order[$k]['address'] = $list_address_tmp;

				// 优惠券信息
				if ($v['coupon']) {
					$list_coupon_tmp = json_decode($v['coupon'], TRUE);
					$list_coupon_tmp['backmoney_format'] = number_format($list_coupon_tmp['backmoney'] / 100, 0);
				}
				$list_order[$k]['coupon'] = $list_coupon_tmp;

				// 商品信息
				if ($v['goods']) {
					$list_goods_tmp = json_decode($v['goods'], TRUE);
					// dump($list_goods_tmp);exit;

					if ($list_goods_tmp) {
						$one_goods = array();
						$show_num = 1;
						foreach ($list_goods_tmp as $key => $value) {
							$show_num += 1;
							$value['thumb_url'] = tomedia($value['thumb']);
							$value['price_format'] = number_format($value['price'] / 100, 2);
							$value['original_price_format'] = number_format($value['original_price'] / 100, 2);

							if ($value['option']['assemble_array']) {
								foreach ($value['option']['assemble_array'] as $key_k => $value_v) {
									$value['option']['assemble_array'][$key_k]['thumb_url'] = tomedia($value_v['thumb']);
								}
							}
							$one_goods[] = $value;

							if ($show_num > 2) {
								break;
							}
						}

						$list_order[$k]['goods'] = $one_goods;
					}
				}

			}
		}

		foreach ($list_order as $k => $v) {
			$list_order[$k]['price_format']  = number_format($v['price'] / 100, 2);
		}

		$data_bak = array(
			'order'=>$list_order,
		);

		return result(0, 'ok', $data_bak);
	}
}

// 新版商城-支付
function store_pay($uid, $order, $return_type=TRUE)
{
	global $_GPC, $_W;

	if (empty($uid)) {
		$data_bak = array(
			'code'=>'1',
			'msg'=>'用户ID不存在',
		);
		if ($return_type) {
			return $data_bak;
		} else {
			return result(1, 'err', '用户ID不存在');
		}
	}

	require_once MODULE_ROOT . "/lib/Common.class.php";

	$sys_id = $_W['uniacid'];
	$app = Common::get_app_info($sys_id);

	$condition = " AND id=:id ";
	$params = array(':id'=>$uid);
	$user = pdo_fetch("SELECT * FROM " . sl_table_name('users',TRUE) . ' WHERE 1 '
		. $condition, $params);

	if ($user) {
		$openid = $user['openid'];

		define('MY_APPID', $app['appid']);
		define('MY_SECRET', $app['secret']);
		define('MY_MCHID', $app['mchid']);
		define('MY_SIGNKEY', $app['signkey']);

		// 统一下单
		$jsApiParameters = Common::run_pay($openid, $order['ordersn'], $order['price']);
		if ($jsApiParameters['return_code']=='SUCCESS') {
			$data_bak = array(
				'code'=>'0',
				'msg'=>'ok',
				'data'=>json_decode($jsApiParameters['return_msg'])
			);
			if ($return_type) {
				return $data_bak;
			} else {
				return result(0, 'ok', json_decode($jsApiParameters['return_msg']));
			}
		} else {
			$data_bak = array(
				'code'=>'1',
				'msg'=>'err',
				'data'=>$jsApiParameters['return_msg']
			);
			if ($return_type) {
				return $data_bak;
			} else {
				return result(1, 'err', $jsApiParameters['return_msg']);
			}
		}
	} else {
		$data_bak = array(
			'code'=>'1',
			'msg'=>'err',
			'data'=>'err not openid'
		);
		if ($return_type) {
			return $data_bak;
		} else {
			return result(1, 'err', 'err not openid');
		}
	}
}

/**
 * 打印前获取订单信息
 * @param  array $order  订单信息
 * @return [type]        [description]
 */
function getOrderInfo($order)
{
	global $_GPC, $_W;
	$str = '';
	// $enter = '<br >';
	$enter = '\n';
	// 订单信息
	// $condition_order = ' AND weid=:uniacid AND id=:id ';
	// $params_order = array(':uniacid'=>$_W['uniacid'], ':id'=>$orderid);
	// $list = pdo_fetch('SELECT * FROM ' . sl_table_name('store_order',TRUE) . ' WHERE 1 '
	// 		. $condition_order, $params_order);

	$str_goods = '';
	if ($order) {
		// 商品信息
		if ($one_order['goods']) {
			$list_goods = json_decode($one_order['goods'], TRUE);
			foreach ($list_goods as $k => $v) {
				$list_goods[$k]['thumb_url'] = tomedia($v['thumb']);
				$list_goods[$k]['price_format']   = number_format($v['price'] / 100, 2);
				$list_goods[$k]['original_price_format']  = number_format($v['original_price'] / 100, 2);
			}
		} else {
			return result(1, '商品信息不存在');
		}

		foreach ($list_goods as $k => $v) {
			# code...
			$str_goods .= $v['title'].$enter;
			$str_goods .= '[价：'.$v['price'].']';
			$str_goods .= '[量：'.$v['total'].']';
			// $str_goods .= '[规：'.$v['optionname'].']';
			$str_goods .= $enter;
		}

		foreach ($goods as &$item) {


		}

		// 地址信息
		if ($order['address']) {
			$address = json_decode($order['address'], TRUE);
		} else {
			return result(1, '地址信息不存在');
		}
	}
	// 订单信息

	$str = '订单号：'.$order['ordersn'].$enter;
	$str .= '----------------'.$enter;
	$str .= $str_goods;
	$str .= '----------------'.$enter;
	$str .= '总价：'.$order['price'].$enter;
	$str .= '----------------'.$enter;
	$str .= '收件人信息'.$enter;
	$str .= '姓名：'.$address['realname'].$enter;
	$str .= '电话：'.$address['mobile'].$enter;
	$str .= '地址：'.$address['province'].$address['city'].$address['area'].$address['address'].$enter;
	$str .= '时间：'.$order['addtime'].$enter;

	return $str;
}

/**
 * 打印订单
 * @param  array $order  订单信息
 * @return [type]        [description]
 */
function sl_print($order)
{
	global $_GPC, $_W;

	require_once MODULE_ROOT . "/lib/yilianyun/print.class.php";

	$condition = " AND uniacid=:uniacid AND printer_name=:printer_name ";
	$params = array(':uniacid' => $_W['uniacid'], ':printer_name'=>'ylyun_printers');
	$set = pdo_fetch("SELECT * FROM " . sl_table_name('store_printers',TRUE) . ' WHERE 1 '
		. $condition . ' limit 1', $params);

	if ($set && $set['enabled']=='1') {
		$printers = json_decode($set['printer_value'], TRUE);
		$content = getOrderInfo($order);

		// $print->action_print($printers['partner'],$printers['machine_code'],$content,$printers['apiKey'],$printers['msign']);
	}
}


?>
