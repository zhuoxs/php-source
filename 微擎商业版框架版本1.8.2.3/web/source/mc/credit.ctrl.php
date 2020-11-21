<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('mc_credit');
$dos = array('display', 'strategy');
$do = in_array($do, $dos) ? $do : 'display';

if($do == 'display') {
	$_W['page']['title'] = '积分列表 - 积分设置 - 会员中心';
	if(checksubmit('submit')) {
		$titlearr = $_GPC['title'];
		$enabledarr = $_GPC['enabled'];
		foreach($titlearr as $key => $value){
			if($key == 'credit1' || $key == 'credit2') {
				$enabled_tmp = 1;
			} else {
				$enabled_tmp = isset($enabledarr[$key]) ? intval($enabledarr[$key]) : 0;
			}
			$creditnamearr[$key] = array('title' => $value,'enabled' => $enabled_tmp);
		}
		$list = pdo_fetch("SELECT creditbehaviors FROM ".tablename('uni_settings') . " WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
		$list = iunserializer($list['creditbehaviors']);
		$type = array('activity' => '基本&营销', 'currency' => '交易&支付(余额)');
				foreach ($list as $key=>$value) {
			foreach ($creditnamearr as $k=>$v) {
				if ($v['enabled'] === 0) {
					if ($value == $k) {
						message("关闭前请先更改 $type[$key] 积分策略", url('mc/credit/strategy'), 'error');
					}
				}
			}
		}
		
		$data = array(
				'uniacid' => $_W['uniacid'],
				'creditnames' => iserializer($creditnamearr)
		);
		$row = pdo_fetch("SELECT uniacid FROM ".tablename('uni_settings') . " WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
		if(empty($row)) {
			pdo_insert('uni_settings', $data);
			cache_delete("unisetting:{$_W['uniacid']}");
			message('积分列表更新成功！', referer(), 'success');
		} else {
			pdo_update('uni_settings', $data, array('uniacid' => $_W['uniacid']));
			cache_delete("unisetting:{$_W['uniacid']}");
			message('积分列表更新成功！', referer(), 'success');
		}
	}
	
	$credits = array();
	$credits['credit1'] = array('enabled' => 0, 'title' => '');
	$credits['credit2'] = array('enabled' => 0, 'title' => '');
	$credits['credit3'] = array('enabled' => 0, 'title' => '');
	$credits['credit4'] = array('enabled' => 0, 'title' => '');
	$credits['credit5'] = array('enabled' => 0, 'title' => '');
	$list = pdo_fetch("SELECT creditnames FROM ".tablename('uni_settings') . " WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
	if(!empty($list['creditnames'])) {
		$list = iunserializer($list['creditnames']);
		if(is_array($list)) {
			foreach($list as $k => $v) {
				$credits[$k] = $v;
			}
		}
	}
}

if($do == 'strategy') {
	$_W['page']['title'] = '积分策略 - 积分设置 - 会员中心';
	$row = pdo_fetch("SELECT creditnames,creditbehaviors FROM ".tablename('uni_settings') . " WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
	if(!empty($row['creditnames'])) {
		$list = iunserializer($row['creditnames']);
		$creditbehaviors = iunserializer($row['creditbehaviors']);
		if(!is_array($creditbehaviors)) {
			$creditbehaviors=array();
		}
		if(is_array($list)) {
			foreach($list as $key => $v) {
				if($v['enabled'] == '1') {
					$credits[$key] = $v;
				}
			}
		}
	}	
	if(checksubmit('submit')) {
		$activity = $_GPC['activity'];
		$currency = $_GPC['currency'];
		$arr = array('activity' => $activity,'currency' => $currency);
		$data = array(
				'uniacid' => $_W['uniacid'],
				'creditbehaviors' => iserializer($arr)
		);
		$row = pdo_fetch("SELECT uniacid FROM ".tablename('uni_settings') . " WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
		if(empty($row)) {
			pdo_insert('uni_settings', $data);
			cache_delete("unisetting:{$_W['uniacid']}");
			message('积分列表更新成功！', referer(), 'success');
		} else {
			pdo_update('uni_settings', $data, array('uniacid' => $_W['uniacid']));
			cache_delete("unisetting:{$_W['uniacid']}");
			message('积分列表更新成功！', referer(), 'success');
		}
	}
}

template('mc/credit');