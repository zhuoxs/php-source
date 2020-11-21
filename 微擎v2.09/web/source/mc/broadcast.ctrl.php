<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('mc_broadcast');
$dos = array('display', 'send');
if($_W['isajax']) {
	$post = $_GPC['__input'];
	if(!empty($post['method'])) {
		$do = $post['method'];
	}
}
$do = in_array($do, $dos) ? $do : 'display';

if($do == 'display') {
	$_W['page']['title'] = '发送通知消息 - 群发消息&通知 - 通知中心';
	if($_W['ispost']) {
		$sql = 'SELECT COUNT(*) FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		if(!empty($_GPC['group'])) {
			$sql .= ' AND `groupid`=:group';
			$pars[':group'] = intval($_GPC['group']);
		}
		if(!empty($_GPC['username'])) {
			$sql .= ' AND `nickname` LIKE :nickname';
			$pars[':nickname'] = "%{$_GPC['username']}%";
		}
		if($_GPC['type'] == 'email') {
			$sql .= " AND `email`!=''";
		}
		$count = pdo_fetchcolumn($sql, $pars);
	}
	$groups = pdo_fetchall('SELECT groupid,title FROM ' . tablename('mc_groups') . " WHERE uniacid = '{$_W['uniacid']}' ");
	template('mc/broadcast');
}

if($do == 'send') {
	load()->func('communication');
	$ret = array(
		'total' => 0,
		'success' => 0,
		'failed' => 0,
		'next' => -1
	);
	$sql = ' FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid';
	$pars = array();
	$pars[':uniacid'] = $_W['uniacid'];
	if(!empty($post['group'])) {
		$sql .= ' AND `groupid`=:group';
		$pars[':group'] = intval($post['group']);
	}
	if(!empty($post['username'])) {
		$sql .= ' AND `nickname` LIKE :nickname';
		$pars[':nickname'] = "%{$post['username']}%";
	}
	
	if($post['type'] == 'email') {
		$sql .= " AND `email`!=''";
		$countSql = 'SELECT COUNT(*)' . $sql;
		$ret['total'] = pdo_fetchcolumn($countSql, $pars);
		$ret['total'] = intval($ret['total']);
		$psize = 1;
		$pindex = intval($post['next']);
		$pindex = max(1, $pindex);
		$start = $psize * ($pindex - 1);
		$sql = 'SELECT `email`' . $sql . " LIMIT {$start}, {$psize}";
		$ds = pdo_fetchall($sql, $pars);
		if(is_array($ds)) {
			foreach($ds as $row) {
				$str_find = array('../attachment/images');
				$str_replace = array($_W['siteroot'] . 'attachment/images');
				$post['content'] =  str_replace($str_find, $str_replace, $post['content']);
				$r = ihttp_email($row['email'], $post['title'], $post['content']);
				if(is_error($r)) {
					$ret['failed']++;
				} else {
					$ret['success']++;
				}
			}
		}
		if($start + $psize < $ret['total']) {
			$ret['next'] = $pindex + 1;
		}
	}
	exit(json_encode($ret));
}