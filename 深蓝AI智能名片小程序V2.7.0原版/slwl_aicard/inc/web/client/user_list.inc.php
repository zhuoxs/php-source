<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$keyword = $_GPC['query'];

} else if ($operation == 'display_table') {
	$keyword = $_GPC['keyword'];

	$condition = " AND uniacid=:uniacid ";
	$params = [':uniacid'=>$_W['uniacid']];
	if ($keyword != '') {
		if (strpos($keyword, 'label*') !== FALSE) {
			$condition .= " AND id_label LIKE :query ";
			$tmp_query = ltrim($keyword, 'label*');
			$params = array_merge($params, [':query'=>'%\"'.$tmp_query.'\"%']);

		} else {
			$condition .= " AND (
				nicename LIKE :keywordjson
				OR nicename LIKE :keyword
				OR real_name LIKE :keyword
				OR mobile LIKE :keyword
			)";
			$tmp_params = [
				':keywordjson'=>'%'.trim(json_encode($keyword), '"').'%',
				':keyword'=>'%'.$keyword.'%',
			];
			$params = array_merge($params, $tmp_params);

		}
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = max(10, intval($_GPC['limit']));
	$sql = "SELECT * FROM " . sl_table_name('users',TRUE) . ' WHERE 1 '
		. $condition . " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$list = pdo_fetchall($sql, $params);

	if ($list) {
		foreach ($list as $k => $v) {
			$list[$k]['avatar_url'] = tomedia($v['avatar']);
			$list[$k]['gender_format'] = $v['gender']?($v['gender']=='1'?'男':'女'):'未知';
			$list[$k]['nicename_format'] = sl_nickname($v['nicename']);

			if ($v['mobile'] == '') {
				$list[$k]['mobile'] = '暂无';
			}

			$time_db = strtotime($v['last_time']);
			$time_default = strtotime('2000-01-01');
			if ($time_db <= $time_default) {
				$list[$k]['last_time'] = '最近';
			}
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . sl_table_name('users',TRUE)
			. ' WHERE 1 ' . $condition, $params);

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
	$id = intval($_GPC['id']);


	if ($_W['ispost']) {
		$options = $_GPC['options'];
		if ($options) {
			$ids = array_values($options);
			$id_label = json_encode($ids);
		}

		$data = [
			'id_label'  => $id_label,
			'real_name' => trim($_GPC['real_name']),
			'mobile'    => trim($_GPC['mobile']),
			'mark'      => $_GPC['mark'],
		];

		if ($id) {
			pdo_update('slwl_aicard_users', $data, array('id' => $id));
		}
		sl_ajax(0, '保存成功');
	}
	$where = ['uniacid'=>$_W['uniacid'], 'id'=>$id];
	$one = pdo_get(sl_table_name('users'), $where);

	// 所有标签分组
	$where = ['uniacid'=>$_W['uniacid']];
	$order_by = ['sort DESC, id DESC'];
	$list_user_label = pdo_getall(sl_table_name('users_label'), $where, '', '', $order_by);

	if ($list_user_label) {
		$ids_my = json_decode($one['id_label'], TRUE);

		if ($ids_my) {
			foreach ($list_user_label as $key => $value) {
				$list_user_label[$key]['checked'] = 0;
				foreach ($ids_my as $k => $v) {
					if ($value['id'] == $v) {
						$list_user_label[$key]['checked'] = 1;
						break;
					}
				}
			}
		}
	}
	$users_label_list = $list_user_label;


} else if ($operation == 'export') {
	$timestart = date('Y-m-d', time());
	$timeend = date('Y-m-d', time());


} else if ($operation == 'export_post') {
	$time_start = $_GPC['timestart'];
	$time_end = $_GPC['timeend'];

	if (empty($time_start) || empty($time_end)) {
		message('时间段不能为空');
		exit;
	}

	// 读取记录
	$condition = " AND uniacid=:uniacid AND addtime>=:time_start AND addtime<=:time_end ";
	$params = array(':uniacid' => $_W['uniacid'], ':time_start'=>$time_start, ':time_end'=>$time_end);
	$pindex = 1;
	$psize = 5000;
	$sql = "SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 '
		. $condition . " ORDER BY addtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$list = pdo_fetchall($sql, $params);

	if ($list) {
		foreach ($list as $k => $v) {
			$list[$k]['nickname'] = json_decode($v['nicename']);
		}
	}

	require_once MODULE_ROOT . "/lib/PHPExcel/PHPExcel.php";
	require_once MODULE_ROOT . "/lib/PHPExcel/ExcelHelper.php";

	//导出Excel
	$xlsName = '客户统计';
	$xlsCell = array(
		array('nickname', '昵称'),
		array('mobile', '手机'),
		array('source_txt', '来源'),
		array('addtime', '时间'),
		array('mark', '备注'),
	);

	$myExcel = new \ExcelHelper();

	$myExcel->exportExcel($xlsName, $xlsCell, $list);

	exit;


} else if ($operation == 'users_label') {
} else if ($operation == 'users_label_list') {
	$keyword = $_GPC['keyword'];

	$condition = " AND uniacid=:uniacid ";
	$params = [':uniacid'=>$_W['uniacid']];
	if ($keyword != '') {
		$condition .= " AND title LIKE :keyword ";
		$tmp_params = [
			':keyword'=>'%'.$keyword.'%',
		];
		$params = array_merge($params, $tmp_params);
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = max(10, intval($_GPC['limit']));
	$sql = "SELECT users_label.*, (SELECT COUNT(*) FROM " . sl_table_name('users',TRUE)
		. " WHERE `id_label` LIKE CONCAT('%\"', users_label.id, '\"%')) AS user_total FROM "
		. sl_table_name('users_label',TRUE) . ' AS users_label WHERE 1 '
		. $condition . " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$list = pdo_fetchall($sql, $params);

	if ($list) {
		$total = pdo_count(sl_table_name('users_label'), $where);
	}
	$data_return = [
		'code'  => 0,
		'msg'   => '',
		'count' => $total,
		'data'  => $list,
	];
	echo json_encode($data_return);
	exit;


} else if ($operation == 'users_label_post') {
	$id = intval($_GPC['id']);

	if ($_W['ispost']) {
		$data = array(
			'uniacid'  => $_W['uniacid'],
			'sort'     => $_GPC['sort'],
			'title'    => $_GPC['title'],
			'subtitle' => $_GPC['subtitle'],
		);
		if ($id) {
			pdo_update(sl_table_name('users_label'), $data, ['id'=>$id]);
		} else {
			$data['create_time'] = $_W['slwl']['datetime']['now'];
			pdo_insert(sl_table_name('users_label'), $data);
			$id = pdo_insertid();
		}
		sl_ajax(0, '保存成功');
	}

	$where = ['uniacid'=>$_W['uniacid'], 'id'=>$id];
	$one = pdo_get(sl_table_name('users_label'), $where);


} else if ($operation == 'users_label_delete') {

	$post = file_get_contents('php://input');
	if (!$post) { sl_ajax(1, '参数不存在'); }

	$params = @json_decode($post, true);
	if (!$params) { sl_ajax(1, '参数解析出错'); }

	$ids = isset($params['ids']) ? $params['ids'] : '';
	if (!$ids) { sl_ajax(1, 'ID为空'); }

	$where = [];
	$where['id IN'] = $ids;

	$rst = @pdo_delete(sl_table_name('users_label'), $where);

	if ($rst !== false) {
		sl_ajax(0, '成功');
	} else {
		sl_ajax(1, '不存在或已删除');
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/client/user_list');

