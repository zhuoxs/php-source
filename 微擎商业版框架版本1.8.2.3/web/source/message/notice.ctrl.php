<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

$dos = array('display', 'change_read_status', 'event_notice', 'all_read', 'setting', 'read');
$do = in_array($do, $dos) ? $do : 'display';
load()->model('message');

$_W['page']['title'] = '系统管理 - 消息提醒 - 消息提醒';

if (in_array($do, array('display', 'all_read'))) {
	$type = $types = intval($_GPC['type']);
	if ($type == MESSAGE_ACCOUNT_EXPIRE_TYPE) {
		$types = array(MESSAGE_ACCOUNT_EXPIRE_TYPE, MESSAGE_WECHAT_EXPIRE_TYPE, MESSAGE_WEBAPP_EXPIRE_TYPE);
	}

	if (empty($type) && (!user_is_founder($_W['uid']) || user_is_vice_founder())){
		$types = array(MESSAGE_ACCOUNT_EXPIRE_TYPE, MESSAGE_WECHAT_EXPIRE_TYPE, MESSAGE_WEBAPP_EXPIRE_TYPE, MESSAGE_USER_EXPIRE_TYPE, MESSAGE_WXAPP_MODULE_UPGRADE);
	}
}

if ($do == 'display') {
	$message_id = intval($_GPC['message_id']);
	message_notice_read($message_id);

	$pindex = max(intval($_GPC['page']), 1);
	$psize = 10;

	$message_table = table('message');
	$is_read = !empty($_GPC['is_read']) ? intval($_GPC['is_read']) : '';

	if (!empty($is_read)) {
		$message_table->searchWithIsRead($is_read);
	}

	if (!empty($types)) {
		$message_table->searchWithType($types);
	}
	$message_table->searchWithPage($pindex, $psize);
	$lists = $message_table->messageList($type);

	$lists = message_list_detail($lists);

	$total = $message_table->getLastQueryTotal();
	$pager = pagination($total, $pindex, $psize);
}


if ($do == 'change_read_status') {
	$id = $_GPC['id'];
	message_notice_read($id);
	iajax(0, '成功');
}

if ($do == 'event_notice') {
	if (!pdo_tableexists('message_notice_log')) {
		iajax(-1);
	}

	if (user_is_founder($_W['uid'], true)) {
		message_store_notice();
	}

	$message = message_event_notice_list();
	if (!empty($message) && !empty($message['lists'])) {
		$setting = message_setting();
		$setting_status = array();
		if (!empty($setting)) {
			foreach ($setting as $property => $property_info) {
				foreach ($property_info['types'] as $type => $type_info) {
					if ($property_info['status'] == MESSAGE_DISABLE) {
						$setting_status[$type]['property'] = MESSAGE_DISABLE;
					} else {
						$setting_status[$type]['property'] = MESSAGE_ENABLE;
					}
					if ($type_info['status'] == MESSAGE_DISABLE) {
						$setting_status[$type]['type'] = MESSAGE_DISABLE;
					} else {
						$setting_status[$type]['type'] = MESSAGE_ENABLE;
					}
				}
			}
		}
		foreach ($message['lists'] as $k => $notice) {
			if (empty($setting_status[$notice['type']])) {
				continue;
			}
			if ($setting_status[$notice['type']]['property'] == MESSAGE_ENABLE && $setting_status[$notice['type']]['type'] == MESSAGE_ENABLE) {
				continue;
			}
			unset($message['lists'][$k]);
		}
	}
	sort($message['lists']);
	$message['total'] = count($message['lists']);
	$cookie_name = $_W['config']['cookie']['pre'] . '__notice';
	if (empty($_COOKIE[$cookie_name]) || $_COOKIE[$cookie_name] < TIMESTAMP) {
		message_account_expire();
		message_notice_worker();
		message_sms_expire_notice();
		message_user_expire_notice();
		message_wxapp_modules_version_upgrade();
	}
	iajax(0, $message);

}

if ($do == 'read') {
	$message_id = pdo_getcolumn('message_notice_log', array('id' => intval($_GPC['id'])), 'id');
	if (!empty($message_id)) {
		pdo_update('message_notice_log', array('is_read' => MESSAGE_READ), array('id' => $message_id));
	}
	iajax(0, '已标记已读');
}

if ($do == 'all_read') {
	message_notice_all_read($types);
	if ($_W['isajax']) {
		iajax(0, '全部已读', url('message/notice', array('type' => $type)));
	}
	itoast('', referer());
}

if ($do == 'setting') {
	$setting = message_setting();
	if (!empty($_GPC['property']) && !empty($_GPC['type'])) {
		$property = trim($_GPC['property']);
		$type = '';
		if (is_numeric($_GPC['type'])) {
			$type = intval($_GPC['type']);
			if (empty($setting[$property]['types'][$type]['status']) || $setting[$property]['types'][$type]['status'] == MESSAGE_ENABLE) {
				$setting[$property]['types'][$type]['status'] = MESSAGE_DISABLE;
			} else {
				$setting[$property]['types'][$type]['status'] = MESSAGE_ENABLE;
			}
		} else {
			if (empty($setting[$property]['status']) || $setting[$property]['status'] == MESSAGE_ENABLE) {
				$setting[$property]['status'] = MESSAGE_DISABLE;
			} else {
				$setting[$property]['status'] = MESSAGE_ENABLE;
			}
		}
		setting_save($setting, 'message_notice_setting');
		iajax(0, '更新成功', url('message/notice/setting'));
	}
}
template('message/notice');