<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('mc_fangroup');
load()->model('mc');
$dos = array('post', 'display', 'del');
$do = !empty($_GPC['do']) && in_array($do, $dos) ? $do : 'display';

if ($do == 'display') {
	$tags = mc_fans_groups(true);
}

if ($do == 'post') {
	$account = WeAccount::create($_W['acid']);
	if (!empty($_GPC['tagname'])) {
		foreach ($_GPC['tagname'] as $key => $value) {
			$value = trim($value);
			if (!empty($value) && trim($_GPC['origin_name'][$key]) != $value) {
				$state = $account->fansTagEdit($_GPC['tagid'][$key], $value);
				if (is_error($state)) {
					message($state['message'], url('mc/fangroup/'), 'error');
				}
			}
		}
	}
	if (!empty($_GPC['tag_add'])) {
		foreach ($_GPC['tag_add'] as $value) {
			$value = trim($value);
			if (!empty($value)) {
				$state = $account->fansTagAdd($value);
				if (is_error($state)) {
					message($state['message'], url('mc/fangroup/'), 'error');
				}
			}
		}
	}
	message('保存标签名称成功', url('mc/fangroup/'), 'success');
}

if ($do == 'del') {
	$tagid = intval($_GPC['__input']['id']);
	$account = WeAccount::create($_W['acid']);
	$tags = $account->fansTagDelete($tagid);
	if (!is_error($tags)) {
		$fans_list = pdo_getall('mc_mapping_fans', array('groupid LIKE' => "%,{$tagid},%"));
		$count = count($fans_list);
		if (!empty($count)) {
			$buffSize = ceil($count / 500);
			for ($i = 0; $i < $buffSize; $i++) {
				$sql = '';
				$buffer = array_slice($fans_list, $i * 500, 500);
				foreach ($buffer as $fans) {
					$tagids = trim(str_replace(','.$tagid.',', ',', $fans['groupid']), ',');
					if ($tagids == ',') {
						$tagids = '';
					}
					$sql .= 'UPDATE ' . tablename('mc_mapping_fans') . " SET `groupid`='" . $tagids . "' WHERE `fanid`={$fans['fanid']};";
				}
				pdo_query($sql); 					}	
		}
		pdo_delete('mc_fans_tag_mapping', array('tagid' => $tagid));
		message(error(0, 'success'), '', 'ajax');
	} else {
		message(error(-1, $tags['message']), '', 'ajax');
	}
}
template('mc/fansgroup');