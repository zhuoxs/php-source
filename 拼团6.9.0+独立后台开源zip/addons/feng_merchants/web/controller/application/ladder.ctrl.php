<?php 
/**
 * [weliam] Copyright (c) 2016/4/4
 * 阶梯团
 */

defined('IN_IA') or exit('Access Denied');

$ops = array('list', 'create', 'edit', 'ajax');
$op_names = array('阶梯团列表','新建阶梯团', '编辑阶梯团', '选择商品');
foreach($ops as$key=>$value){
	permissions('do', 'ac', 'op', 'application', 'ladder', $ops[$key], '应用与营销', '阶梯团', $op_names[$key]);
}
$op = in_array($op, $ops) ? $op : 'list';
wl_load()->model('goods');
if ($op == 'list') {
	$_W['page']['title'] = '应用和营销  - 阶梯团列表';
	$opp=$_GPC['opp'];
	if (empty($_GPC['opp'])) {
		$opp = 'all';
	}
	$size = 10;
	$page = !empty($_GPC['page'])?$_GPC['page']:1;
	$data = goods_get_list(array('usepage'=>1,'page'=>$page,'pagesize'=>$size,'group_level_status'=>'2','merchantid'=>MERCHANTID));
	foreach($data['list'] as$key=>&$value){
		$group_level = unserialize($value['group_level']);
		$groupnum_string = '';
		$groupprice_string = '';
		foreach($group_level as$k=>&$v){
			$groupnum_string .= $v['groupnum']." | ";
			$groupprice_string .= $v['groupprice']." | ";
		}
		$value['groupnum_string'] = $groupnum_string;
		$value['groupprice_string'] = $groupprice_string;
	}
//	wl_debug($data['list']);
	$total = pdo_fetchall("select id from".tablename('tg_coupon_template'));
	$total = $data['total'];
	$pager = pagination($total, $page, $size);
	include wl_template('application/ladder/goods_level');
}
if ($op == 'create' || $op == 'edit') {
	$goodsid = $_GPC['id'];
	$data = goods_get_list(array('group_level_status'=>' 0,1 ','merchantid'=>MERCHANTID));
	if($goodsid){
		$goods = goods_get_by_params(" id= {$goodsid} ");
		$group_level = unserialize($goods['group_level']);
	}
	if (checksubmit('submit')) {
		$param_groupnum = $_POST['param_groupnum'];
		$param_groupprice = $_POST['param_groupprice'];
		$group_level = array();
		for($i=0;$i<count($param_groupnum);$i++){
			$group_level[$i]['groupnum'] = $param_groupnum[$i];
			$group_level[$i]['groupprice'] = $param_groupprice[$i];
		}
		$group_level = serialize($group_level);
		$level_data['group_level']=$group_level;
		$level_data['group_level_status'] = $_GPC['group_level_status'];
		if (empty($goodsid)) {
			if(!empty($_GPC['goodsid'])){
				if(pdo_update('tg_goods',$level_data, array('id' => $_GPC['goodsid'])))
				message('创建成功', web_url('application/ladder/list'), 'success');exit;
			}else{
				message('创建失败', web_url('application/ladder/list'), 'success');exit;
			}
			
		} else {
			pdo_update('tg_goods',$level_data, array('id' => $goodsid));
			message('修改成功', web_url('application/ladder/list'), 'success');exit;
		}
	}
	
	include wl_template('application/ladder/ladder_edit');
}

if ($op == 'ajax') {
	$id = $_GPC['id'];
	$goods = goods_get_by_params(" id={$id} ");
	die(json_encode($goods));
}
