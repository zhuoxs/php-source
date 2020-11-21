<?php
defined('IN_IA') or exit('Access Denied');

$ops = array('display', 'post', 'delete', 'status');
$op = in_array($op, $ops) ? $op : 'display';
if ($op == 'display') {
	$_W['page']['title'] = '商品分类管理 - 商品分类';
	$cateTitle = '添加';
	
	if (checksubmit('submit')) {
		if (!empty($_GPC['add_parent_name'])) {
			foreach ($_GPC['add_parent_name'] as $key => $value) {
				if (!empty($value)) {
					$insert = array(
						'name' => $value,
						'description' => $_GPC['add_parent_description'][$key],
						'displayorder' => $_GPC['add_parent_displayorder'][$key]
					);
					pdo_insert('tg_category', $insert);
				}
			}
		}
		if (!empty($_GPC['add_name'])) {
			foreach ($_GPC['add_name'] as $key => $value) {
				if (!empty($value)) {
					$insert = array(
						'parentid' => $_GPC['add_pid'][$key],
						'name' => $value,
						'description' => $_GPC['add_description'][$key],
						'displayorder' => $_GPC['add_displayorder'][$key]
					);
					pdo_insert('tg_category', $insert);
				}
				
			}
		}
		foreach ($_GPC['displayorder'] as $id => $displayorder) {
			$update = array(
				'displayorder' => intval($displayorder),
				'name' => $_GPC['name'][$id],
				'description' => $_GPC['description'][$id]
			);
			pdo_update('tg_category', $update, array('id' => $id));
			Util::deleteCache('goods', $id);
		}
		
		message('商品分类更新成功', 'refresh', 'success');
	}
	$category = pdo_fetchall("SELECT * FROM ".tablename('tg_category')."WHERE uniacid = {$_W['uniacid']} ORDER BY visible_level desc, `parentid` DESC, `displayorder` DESC, id ASC");
	$children = array();
	if (!empty($category)) {
		foreach ($category as $index => $row) {
			if (!empty($row['parentid'])){
				$children[$row['parentid']][] = $row;
				unset($category[$index]);
			}
		}
	}

} elseif ($op == 'post') {
	$cateId = intval($_GPC['id']);
	$level = $_GPC['visible_level']?$_GPC['visible_level']:0;//=isfounder为首页分类
	$catePid =pdo_fetch_value('tg_category', 'parentid', array('id' => $cateId));
	$faterId = intval($_GPC['fatherid']);
	$cateTitle = empty($cateId) ? '添加' : '更新';
	$_W['page']['title'] = $cateTitle . '商品分类 - 商品分类';

	if (checksubmit('submit')) {
		if (empty($_GPC['name'])) {
			message('分类名称不能为空');
		}
		$data = array(
			'uniacid'       =>$_W['uniacid'],
			'name' 			=> $_GPC['name'],
			'description' 	=> $_GPC['description'],
			'displayorder' 	=> $_GPC['displayorder'],
			'enabled' 		=> $_GPC['enabled'],
			'open' 			=> $_GPC['open'],
			'thumb' 		=> $_GPC['thumb'],
			'parentid' 		=> $catePid,
			'visible_level' => $level
		);
		if (!empty($faterId)) {
			$data['parentid'] = $faterId;
		}
		if (empty($cateId) || !empty($faterId)) {
			pdo_insert('tg_category', $data);
			$cateId = pdo_insertid();
		} else {
			pdo_update('tg_category', $data, array('id' => $cateId));
			Util::deleteCache('goods', $id);
		}
		
		message('商品分类更新成功', web_url('goods/category/post', array('id' => $cateId)), 'success');
	}

	$category = array();
	if (!empty($cateId)) {
		$category = pdo_fetch_one('tg_category', array('id' => $cateId));
	}

} elseif ($op == 'delete') {
	$category_id = intval($_GPC['cateid']);
	if ($category_id) {
		$category = pdo_select_count('tg_category', array('id' => $category_id));
	}
	if (empty($category)) {
		message(error('1', '删除失败: 未指定商品分类.'));
	}
	
	$pcatetotal = pdo_select_count('tg_goods', array('category_parentid' => $category_id));
	$ccatetotal = pdo_select_count('tg_goods', array('category_childid' => $category_id));
	if ($pcatetotal + $ccatetotal > 0) {
		die(json_encode(array('errno'=>1,'message'=>'有商品正使用改分类，不可删除！')));
	}
	$child_category_count = pdo_select_count('tg_category', array('parentid' => $category_id));
	if ($child_category_count > 0) {
		message(error('1', '该分类有子分类, 请先删除子分类'));
	}
	pdo_delete('tg_category', array('id' => $category_id));
	
	message(error('0', '成功删除!'));
	
} elseif ($op == 'status') {
	$id = intval($_GPC['id']);
	$status = intval($_GPC['status']);
	pdo_update('tg_category', array('enabled' => $status), array('id' => $id));
	Util::deleteCache('goods', $id);
	
	message(error('0', '设置成功!'));
}

include wl_template('goods/category');