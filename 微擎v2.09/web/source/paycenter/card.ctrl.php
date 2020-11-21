<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$dos = array('check');
$do = in_array($do, $dos) ? $do : 'check';
load()->model('card');

if($do == 'check') {
	$set = card_setting();
	if(is_error($set)) {
		message($set, '', 'ajax');
	}
	$_GPC = $_GPC['__input'];
	$cardsn = trim($_GPC['cardsn']);
	$card_member = pdo_getall('mc_card_members', array('uniacid' => $_W['uniacid'], 'cardsn' => $cardsn));
	if(empty($card_member)) {
		message(error(-1, '卡号不存在或已经删除'), '', 'ajax');
	}
	if(count($card_member) > 1) {
		message(error(-1, '卡号对应用户不唯一'), '', 'ajax');
	}
	$card_member = $card_member[0];
	if($card_member['status'] != 1) {
		message(error(-1, '该会员卡已被禁用'), '', 'ajax');
	}
	$member = pdo_get('mc_members', array('uniacid' => $_W['uniacid'], 'uid' => $card_member['uid']));
	if(empty($member)) {
		message(error(-1, '会员卡对应的会员不存在'), '', 'ajax');
	}
	$member['openid'] = $card_member['openid'];
	$member['createtime'] = $card_member['createtime'];
	$member['cardsn'] = $card_member['cardsn'];
	$member['groupname'] = $_W['account']['groups'][$member['groupid']]['title'];
	$member['discount_type'] = 0;
	$member['discount'] = array();
	$member['discount_cn'] = '暂无';
	$member['credit1'] = floatval($member['credit1']);
	$member['credit2'] = floatval($member['credit2']);
	$member['offset_rate'] = $set['offset_rate'];
	$member['offset_max'] = $set['offset_max'];
	if($set['discount_type'] > 0 && !empty($set['discount'])) {
		$discount = $set['discount'][$member['groupid']];
		if(!empty($discount)) {
			$member['discount'] = $discount;
			$member['discount_type'] = $set['discount_type'];
			if($set['discount_type'] == 1 ) {
				$member['discount_cn'] = "满 {$discount['condition']} 元减 {$discount['discount']}元";
			} else {
				$zhe = $discount['discount'] * 10;
				$member['discount_cn'] = "满 {$discount['condition']} 元打 {$zhe}折";
			}
		}
	}
	message(error(0, $member), '', 'ajax');
}


