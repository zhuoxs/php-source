<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;

load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {


} else if ($operation == 'display_table') {
	$keyword = $_GPC['keyword'];

	$condition = " AND uniacid=:uniacid AND brandid='0' ";
	$params = array(':uniacid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = max(10, intval($_GPC['limit']));
	if ($keyword != '') {
		$condition .= ' AND (title LIKE :title) ';
		$params[':title'] = '%'.$keyword.'%';
	}

	$sql = "SELECT * FROM " . tablename('slwl_aicard_store_goods'). ' WHERE 1 '
		. $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

	$list = pdo_fetchall($sql, $params);
	if ($list) {
		foreach ($list as $k => $v) {
			$list[$k]['thumb_url'] = tomedia($v['thumb']);
			$list[$k]['price_format'] = number_format($v['price'] / 100, 2);
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_store_goods') . ' WHERE 1 ' . $condition, $params);
		// $pager = pagination($total, $pindex, $psize);
	}
	$data_return = [
		'code'  => 0,
		'msg'   => '',
		'count' => $total,
		'data'  => $list,
	];
	echo json_encode($data_return);
	exit;


} else if ($operation == 'post') {
	$good_id = intval($_GPC['id']);

	if ($_W['ispost']) {

		$curr_datetime = $_W['slwl']['datetime']['now'];
		$price = $_GPC['price'] * 100;    // 销售价
		$original_price = $_GPC['original_price'] * 100;   //市场价

		// 基本属性
		$data = array(
			'uniacid' => $_W['uniacid'],
			'displayorder' => $_GPC['displayorder'],
			'title' => $_GPC['title'],
			'intro' => $_GPC['intro'],
			'pcate' => intval($_GPC['category']['parentid']),
			'ccate' => intval($_GPC['category']['childid']),
			'thumb'=> $_GPC['pic'],
			'isrecommand' => intval($_GPC['isrecommand']),
			'ishot' => intval($_GPC['ishot']),
			'isnew' => intval($_GPC['isnew']),
			'istime' => intval($_GPC['istime']),
			'timestart' => strtotime($_GPC['timestart']),
			'timeend' => strtotime($_GPC['timeend']),
			'content' => htmlspecialchars_decode($_GPC['content']),
			'goodsn' => $_GPC['goodsn'],
			'barcode' => $_GPC['barcode'],
			'unit' => $_GPC['unit'],
			'inventory' => $_GPC['inventory'],
			'inventory_status' => intval($_GPC['inventory_status']),
			'price' => $price,
			'original_price' => $original_price,
			'spec_status' => intval($_GPC['spec_status']),
			'sales' => intval($_GPC['sales']),
			'enabled' => intval($_GPC['enabled']),
		);

		// 多图
		$data['thumbs'] = '';
		$thumbs = array();
		if ($_GPC['thumbs']) {
			foreach ($_GPC['thumbs'] as $k => $v) {
				$thumbs[] = $v;
			}
			$data['thumbs'] = json_encode($thumbs);
		}

		// 处理，自定义参数
		if ($_GPC['param_tv']) {
			$options = $_GPC['param_tv'];

			foreach ($options['title'] as $k => $v) {
				$tmp_param[$k]['title'] = $v;
			}
			foreach ($options['value'] as $k => $v) {
				$tmp_param[$k]['value'] = $v;
			}
			foreach ($tmp_param as $k=>$v){
				$param_items[] = $v;
			}
			$data['param'] = json_encode($param_items); // 压缩
		}

		// 处理规格
		if ($_GPC['spec']) {
			$spec_post = $_GPC['spec'];

			foreach ($spec_post['spec'] as $k => $v) {
				$v_items = array();
				foreach ($v['items'] as $key => $value) {
					$value['thumb_url'] = tomedia($value['thumb']);
					$v_items[] = $value;
				}
				$spec_options[$k]['title'] = $v['title'];
				$spec_options[$k]['items'] = $v_items;
			}
			$data['spec'] = json_encode($spec_options); // 压缩
		}

		// 保存商品
		if ($good_id) {
			pdo_update('slwl_aicard_store_goods', $data, array('id' => $good_id));
		} else {
			$data['addtime'] = $_W['slwl']['datetime']['now'];
			pdo_insert('slwl_aicard_store_goods', $data);
			$good_insert_id = pdo_insertid();
		}

		// 处理，规格项目表
		if ($_GPC['specop']) {
			$specop = $_GPC['specop'];
			// 标题
			foreach ($specop['option_title'] as $k => $v) {
				$tmp_specop[$k]['option_title'] = $v;
			}
			// ID集合
			foreach ($specop['option_assemble'] as $k => $v) {
				$array_exp = explode('+', $v);
				if ($array_exp) {
					$tmp_arr = null;
					foreach ($array_exp as $key => $value) {
						$tmp_arr[$key]['id'] = $value;
						foreach ($spec_options[$key]['items'] as $key_key => $value_value) {
							if ($value == $value_value['id']) {
								$tmp_arr[$key]['title'] = $value_value['title'];
								$tmp_arr[$key]['thumb'] = $value_value['thumb'];
								// $tmp_arr[$key]['thumb_url'] = tomedia($value_value['thumb']);
								break;
							}
						}
					}
					$tmp_specop[$k]['option_assemble_json'] = json_encode($tmp_arr, JSON_UNESCAPED_UNICODE);
				} else {
					$tmp_specop[$k]['option_assemble_json'] = '';
				}
				$tmp_specop[$k]['option_assemble'] = $v;
			}
			// 库存
			foreach ($specop['option_inventory'] as $k => $v) {
				$tmp_specop[$k]['option_inventory'] = $v;
			}
			// 销售价格
			foreach ($specop['option_price'] as $k => $v) {
				$tmp_specop[$k]['option_price'] = $v * 100;
			}
			// 市场价格
			foreach ($specop['option_original_price'] as $k => $v) {
				$tmp_specop[$k]['option_original_price'] = $v * 100;
			}
			// 编码
			foreach ($specop['option_goodsn'] as $k => $v) {
				$tmp_specop[$k]['option_goodsn'] = $v;
			}
			// 条码
			foreach ($specop['option_barcode'] as $k => $v) {
				$tmp_specop[$k]['option_barcode'] = $v;
			}

			if ($good_id) {
				$tmp_goodid = $good_id;
			} else {
				$tmp_goodid = $good_insert_id;
			}
			$data_option = array();
			foreach ($tmp_specop as $k => $v){
				$data_option[] = array(
					'uniacid' => $_W['uniacid'],
					'goodid' => $tmp_goodid,
					'title' => $v['option_title'],
					'assemble' => $v['option_assemble'],
					'assemble_json' => $v['option_assemble_json'],
					'inventory' => $v['option_inventory'],
					'price' => $v['option_price'],
					'original_price' => $v['option_original_price'],
					'goodsn' => $v['option_goodsn'],
					'barcode' => $v['option_barcode'],
					'addtime' => $curr_datetime,
				);
			}

			pdo_delete('slwl_aicard_store_goods_option', array("goodid"=>$good_id));

			foreach ($data_option as $k => $v) {
				pdo_insert('slwl_aicard_store_goods_option', $v);
			}
		}
		sl_ajax(0, '保存成功！');
	}

	$condition_cate = " AND uniacid=:uniacid ";
	$params_cate = array(':uniacid' => $_W['uniacid']);
	$sql_cate = 'SELECT * FROM ' . tablename('slwl_aicard_store_category') . ' WHERE 1 '
		. $condition_cate . ' ORDER BY displayorder DESC, id DESC ';
	$list_category = pdo_fetchall($sql_cate, $params_cate);

	if ($list_category) {
		$parent = $children = array();
		foreach ($list_category as $key => $value) {
			if ($value['parentid'] == '0') {
				$parent[] = $value;
			} else {
				$children[] = $value;
			}
		}
	}

	$condition = " AND uniacid=:uniacid AND id=:id ";
	$params = array(':uniacid' => $_W['uniacid'], ':id' => $good_id);
	$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_store_goods') . ' WHERE 1 ' . $condition, $params);

	$one['price'] = $one['price'] / 100; // 销售价
	$one['original_price'] = $one['original_price'] / 100; //市场价

	$thumbs = array();
	$pl = json_decode($one['thumbs'], true);
	if ($pl) {
		foreach ($pl as $k => $v) {
			$thumbs[] = $v;
		}
	}

	// 处理，自定义参数
	if ($one['param']) {
		$one_param = json_decode($one['param'], true);
	}

	// 处理，多规格
	if ($one['spec']) {
		$spec_items = json_decode($one['spec'], true);
	}

	// 获取规格项
	$condition_goods_option = " AND uniacid=:uniacid AND goodid=:goodid ";
	$params_goods_option = array(':uniacid' => $_W['uniacid'], ':goodid' => $good_id);
	$sql_goods_option = "SELECT * FROM " . tablename('slwl_aicard_store_goods_option'). ' WHERE 1 '
		. $condition_goods_option . " ORDER BY id DESC ";

	$list_goods_option = pdo_fetchall($sql_goods_option, $params_goods_option);

	foreach ($list_goods_option as $k => $v) {
		$list_goods_option[$k]['price'] = $v['price'] / 100; // 销售价
		$list_goods_option[$k]['original_price'] = $v['original_price'] / 100; //市场价
	}

	$list_goods_option_json = json_encode($list_goods_option, JSON_UNESCAPED_UNICODE);


} else if ($operation == 'goods_property') {

	global $_GPC, $_W;

	$id = intval($_GPC['id']);
	$type = $_GPC['type'];
	$data = intval($_GPC['data']);

	if (in_array($type, array('new', 'hot', 'recommand', 'discount'))) {
		$data = ($data==1?'0':'1');
		pdo_update("slwl_aicard_store_goods", array("is" . $type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
		die(json_encode(array("result" => 0, "data" => $data)));
	}
	if (in_array($type, array('enabled'))) {
		$data = ($data==1?'0':'1');
		pdo_update("slwl_aicard_store_goods", array($type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
		die(json_encode(array("result" => 0, "data" => $data)));
	}
	if (in_array($type, array('type'))) {
		$data = ($data==1?'2':'1');
		pdo_update("slwl_aicard_store_goods", array($type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
		die(json_encode(array("result" => 0, "data" => $data)));
	}
	die(json_encode(array("result" => 2)));


} else if ($operation == 'delete') {

	$post = file_get_contents('php://input');
	if (!$post) { sl_ajax(1, '参数不存在'); }

	$params = @json_decode($post, true);
	if (!$params) { sl_ajax(1, '参数解析出错'); }

	$ids = isset($params['ids']) ? $params['ids'] : '';
	if (!$ids) { sl_ajax(1, 'ID为空'); }

	$where = [];
	$where['id IN'] = $ids;

	$where_option = [];
	$where_option['goodid IN'] = $ids;

	$rst_1 = @pdo_delete('slwl_aicard_store_goods', $where);
	$rst_2 = @pdo_delete('slwl_aicard_store_goods_option', $where_option);
	if ($rst_1 !== false && $rst_2 !== false) {
		sl_ajax(0, '成功');
	} else {
		sl_ajax(1, '不存在或已删除');
	}


} else {
	message('请求方式不存在');
}


include $this->template('web/store/goods');

