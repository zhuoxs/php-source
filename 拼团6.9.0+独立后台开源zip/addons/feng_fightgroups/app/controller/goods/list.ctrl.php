<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if($op =='display'){
	$pagetitle = !empty($config['tginfo']['sname']) ? '商品列表 - '.$config['tginfo']['sname'] : '商品列表';
	$gid = intval($_GPC['gid']);
	$cid = intval($_GPC['cid']);
	$categoryData=model_category::getNumCategory();
	$category = $categoryData[0];
	include wl_template('goods/goods_list');
}

if($op =='ajax'){
	
	$where =array();
	$where['#isshow#'] = '(1,3)';
	$where['#g_type#'] = '(1,3)';
	$pindex = $_GPC['page']?$_GPC['page']:1;
	$psize = $_GPC['pagesize']?$_GPC['pagesize']:10;
	if (!empty($_GPC['recommand']))$where['isrecommand'] = 1;
	if (!empty($_GPC['cid'])) $where['category_childid'] = intval($_GPC['cid']);
	if (!empty($_GPC['gid']))$where['category_parentid'] = intval($_GPC['gid']);
	if (!empty($_GPC['keyword']))$where['@gname@'] = $_GPC['keyword'];
	$listData = model_goods::getNumGoods('*', $where, 'displayorder desc', $pindex, $psize, 1);
	$data = array();
	$data['list'] = $listData[0]?$listData[0]:array();
	$data['total'] = $listData[2];
	if($data['list']){
		foreach ($data['list'] as $key => &$v) {
			$v['sale'] = $v['salenum'] + $v['falsenum'];
		}
	}
	die(json_encode($data));
}

if($op =='search'){
	$keyword = $_GPC['keyword'];
	include wl_template('goods/goods_list');
}

if($op =='merchant'){
	$id = $_GPC['id'];
	$merchant = model_merchant::getSingleMerchant($id, '*');
	include wl_template('goods/merchant_goods');
}

if($op =='merchant_ajax'){
	$id = $_GPC['id'];//商家id
	$page = $_GPC['page'];
	$pagesize = $_GPC['pagesize'];
	$data = model_goods::getNumGoods('*', array('#isshow#'=>'(1,3)','merchantid' => $id), 'displayorder DESC', $page, $pagesize, TRUE);
	$goodses['list'] = $data[0];
	if($goodses['list']){
		foreach ($goodses['list'] as $key => &$v) {
			$v['sale'] = $v['salenum'] + $v['falsenum'];
		}
	}
	die(json_encode($goodses));
}