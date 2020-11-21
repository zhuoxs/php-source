<?php 
/**
 * [weliam] Copyright (c) 2016/4/4
 * 阶梯团
 */

defined('IN_IA') or exit('Access Denied');

$ops = array('list', 'create', 'edit', 'ajax');
$op = in_array($op, $ops) ? $op : 'list';
if ($op == 'list') {
	$_W['page']['title'] = '应用和营销  - 阶梯团列表';
	$opp=$_GPC['opp'];
	if (empty($_GPC['opp'])) {
		$opp = 'all';
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$where=array();
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
	$where['group_level_status'] = 2;
	$dataData = model_goods::getNumGoods('*', $where, 'id desc', $pindex, $psize, 1);
	$data['list'] = $dataData[0]?$dataData[0]:array();
	$pager = $dataData[1];
	foreach($data['list'] as$key=>&$value){
		$merchant = pdo_fetch("SELECT name FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' ".TG_ID."");
		$group_level = unserialize($value['group_level']);
		$groupnum_string = '';
		$groupprice_string = '';
		$value['merchant'] = $merchant;
		foreach($group_level as$k=>&$v){
			$groupnum_string .= $v['groupnum']." | ";
			$groupprice_string .= $v['groupprice']." | ";
		}
		$value['groupnum_string'] = $groupnum_string;
		$value['groupprice_string'] = $groupprice_string;
	}
	include wl_template('application/ladder/goods_level');
}
if ($op == 'create' || $op == 'edit') {
	$goodsid = $_GPC['id'];
	$where=array();
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
	$where['#group_level_status#'] = '(0,1)';
	$where['isshow'] = 1;
	$dataData = model_goods::getNumGoods('*', $where, 'id desc', 0, 0, 0);
	$data['list'] = $dataData[0];
	if($goodsid){
		$goods = model_goods::getSingleGoods($goodsid, '*');
		$group_level = unserialize($goods['group_level']);
	}
	$merchant = pdo_fetch("SELECT name FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' ".TG_ID."");
	$goods['merchant'] = $merchant;
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
		if($level_data['group_level_status']==2){
			$level_data['hasoption'] = 0;
		}
		if (empty($goodsid)) {
			if(!empty($_GPC['goodsid'])){
				if(pdo_update('tg_goods',$level_data, array('id' => $_GPC['goodsid']))){
					Util::deleteCache('goods', $_GPC['goodsid']);
					message('创建成功', web_url('application/ladder/list'), 'success');exit;
				}
				
			}else{
				message('创建失败', web_url('application/ladder/list'), 'success');exit;
			}
			
		} else {
			pdo_update('tg_goods',$level_data, array('id' => $goodsid));
			Util::deleteCache('goods', $goodsid);
			message('修改成功', web_url('application/ladder/list'), 'success');exit;
		}
		
	}
	
	include wl_template('application/ladder/ladder_edit');
}

if ($op == 'ajax') {
	$id = $_GPC['id'];
	$goods =  model_goods::getSingleGoods($id, '*');
	die(json_encode($goods));
}
