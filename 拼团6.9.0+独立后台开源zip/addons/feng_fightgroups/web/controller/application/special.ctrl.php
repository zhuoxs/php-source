<?php 
/**
 * [weliam] Copyright (c) 2016/4/4
 * 阶梯团
 */

defined('IN_IA') or exit('Access Denied');

$ops = array('list', 'create', 'edit', 'ajax','delete');
$op = in_array($op, $ops) ? $op : 'list';
if ($op == 'list') {
	$_W['page']['title'] = '应用和营销  - 特殊商品列表';
	$data = pdo_fetchall("select * from".tablename('tg_goods')."where isshow=1 and uniacid={$_W['uniacid']} and (credits >1 or give_coupon_id<>'' or give_gift_id<>'')");
	include wl_template('application/special/special_list');
}
if ($op == 'create' || $op == 'edit') {
	$id = $_GPC['id'];
	if($id) $goods = model_goods::getSingleGoods($id, '*');
	$sql = "select * from".tablename('tg_coupon_template')." WHERE uniacid = {$_W['uniacid']} and enable=1";
	$tg_coupon_templates = pdo_fetchall($sql);
	$time= TIMESTAMP;
	$giftData = model_goods::getNumGoods("*", array('g_type'=>2), 'id desc', 0, 0, 0);
	$gift =$giftData[0];
	$data =   pdo_fetchall("select id,gname from".tablename('tg_goods')."where isshow=1 and uniacid={$_W['uniacid']} and g_type=1");
	if (checksubmit('submit')) {
		$special_type = $_GPC['special_type'];
		$goodsid = $_GPC['goodsid'];
		$goods = $_GPC['goods'];
		if($special_type==1){
			$credit=$goods['credits'];$give_coupon_id='';$give_gift_id='';
		}elseif($special_type==2){
			$give_coupon_id = $goods['coupon_id'];$credit='';$give_gift_id='';
		}elseif($special_type==3){
			$give_gift_id = $goods['gift_id'];$credit='';$give_coupon_id='';
		}
		$data = array(
			'give_coupon_id'=>$give_coupon_id,
			'give_gift_id'=>$give_gift_id,
			'credits'=>$credit
		);
		if (empty($id)) {
			if(!empty($goodsid)){
				if(pdo_update('tg_goods',$data, array('id' => $goodsid)))
				message('创建成功', web_url('application/special/list'), 'success');exit;
			}else{
				message('创建失败', web_url('application/special/list'), 'success');exit;
			}
			Util::deleteCache('goods', $goodsid);
		} else {
			pdo_update('tg_goods',$data, array('id' => $id));
			Util::deleteCache('goods', $id);
			message('修改成功', web_url('application/special/list'), 'success');exit;
		}
	}
	
	include wl_template('application/special/special_edit');
}

if ($op == 'ajax') {
	$id = $_GPC['id'];
	$goods = model_goods::getSingleGoods($id, '*');
	die(json_encode($goods));
}
if ($op == 'delete') {
	$id = $_GPC['id'];
	$data = array(
		'give_coupon_id'=>0,
		'give_gift_id'=>0,
		'credits'=>0
	);
	pdo_update('tg_goods',$data, array('id' => $id));
	message('删除成功', web_url('application/special/list'), 'success');exit;
}
