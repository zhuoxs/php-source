<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function message_notice_read($id) {
	$id = intval($id);
	if (empty($id)) {
		return true;
	}
	pdo_update('message_notice_log', array('is_read' => MESSAGE_READ), array('id' => $id));
	return true;
}


function message_notice_all_read($type = '') {
	global $_W;
	$message_table = table('message');
	if (!empty($type)) {
		$message_table->whereType($type);
	}
	if (user_is_founder($_W['uid']) && !user_is_vice_founder($_W['uid'])) {
		$message_table->fillIsRead(MESSAGE_READ)->whereIsRead(MESSAGE_NOREAD)->save();
		return true;
	}
	$message_table->fillIsRead(MESSAGE_READ)->whereIsRead(MESSAGE_NOREAD)->whereUid($_W['uid'])->save();
	return true;
}


function message_notice_record($content, $uid, $sign, $type, $extend_message = array()) {
	$message['message'] = $content;
	$message['uid'] = $uid;
	$message['sign'] = $sign;
	$message['type'] = $type;
	$message_notice_log = array_merge($message, $extend_message);
	$message_exists = message_validate_exists($message_notice_log);
	if (!empty($message_exists)) {
		return true;
	}
	if (empty($message_notice_log['create_time'])) {
		$message_notice_log['create_time'] = TIMESTAMP;
	}
	if (empty($message_notice_log['is_read'])) {
		$message_notice_log['is_read'] = MESSAGE_NOREAD;
	}
	$push_cloud_message_type = array(MESSAGE_ORDER_TYPE, MESSAGE_WORKORDER_TYPE, MESSAGE_REGISTER_TYPE);
	if (in_array($type, $push_cloud_message_type)) {
		message_notice_record_cloud($message_notice_log);
	}
	pdo_insert('message_notice_log', $message_notice_log);
	return true;
}


function message_validate_exists($message) {
	$message_exists = pdo_get('message_notice_log', $message);
	if (!empty($message_exists)) {
		return true;
	}
	return false;
}



function message_event_notice_list() {
	load()->model('user');
	global $_W;
	$message_table = table('message');
	$message_table->searchWithIsRead(MESSAGE_NOREAD);
	$message_table->searchWithType(array(MESSAGE_SYSTEM_UPGRADE, MESSAGE_OFFICIAL_DYNAMICS));
	$type = '';
	if (user_is_vice_founder() || !user_is_founder($_W['uid'])) {
		$type = array(MESSAGE_ACCOUNT_EXPIRE_TYPE, MESSAGE_WECHAT_EXPIRE_TYPE, MESSAGE_USER_EXPIRE_TYPE, MESSAGE_WEBAPP_EXPIRE_TYPE, MESSAGE_WXAPP_MODULE_UPGRADE);
		$message_table->searchWithType($type);
	}

	$message_table->searchWithPage(1, 10);
	$lists = $message_table->messageList();

	$message_table->searchWithIsRead(MESSAGE_NOREAD);
	if (user_is_vice_founder() || !user_is_founder($_W['uid'])) {
		$message_table->searchWithType($type);
	}
	$total = $message_table->messageNoReadCount();

	$lists = message_list_detail($lists);
	return array(
		'lists' => $lists,
		'total' => $total
	);
}



function message_account_expire() {
	load()->model('account');
	if (!pdo_tableexists('message_notice_log')) {
		return true;
	}
	$account_table = table('account');
	$expire_account_list = $account_table->searchAccountList();
	if (empty($expire_account_list)) {
		return true;
	}
	foreach ($expire_account_list as $account) {
		$account_detail = uni_fetch($account['uniacid']);
		if (empty($account_detail['uid'])) {
			continue;
		}
		if ($account_detail['endtime'] > 0 && $account_detail['endtime'] < TIMESTAMP) {
			switch ($account_detail['type']) {
				case ACCOUNT_TYPE_APP_NORMAL:
					$type = MESSAGE_WECHAT_EXPIRE_TYPE;
					$account_name = '-小程序过期';
					break;
				case ACCOUNT_TYPE_WEBAPP_NORMAL:
					$type = MESSAGE_WEBAPP_EXPIRE_TYPE;
					$account_name = '-pc过期';
					break;
				default:
					$type = MESSAGE_ACCOUNT_EXPIRE_TYPE;
					$account_name = '-公众号过期';
					break;
			}
			$message = array(
				'end_time' => $account_detail['endtime']
			);
			message_notice_record($account_detail['name'] . $account_name, $account_detail['uid'], $account['uniacid'], $type, $message);
		}
	}
	return true;
}


function message_notice_worker() {
	global $_W;
	load()->func('communication');
	load()->classs('cloudapi');
	$api = new CloudApi();
	$table = table('message');
	$time = 0;
	$table->searchWithType(MESSAGE_WORKORDER_TYPE);
	$message_record = $table->messageRecord();

	if (!empty($message_record)) {
		$time = $message_record['create_time'];
	}

	if (!empty($time) && TIMESTAMP - $time < 60 * 60 * 6) {
		return true;
	}

	$api_url = $api->get('system', 'workorder', array('do' => 'notload', 'time' => $time), 'json', false);
	if (is_error($api_url)) {
		return true;
	}

	$request_url = $api_url['data']['url'];
	$response = ihttp_get($request_url);
	$uid = $_W['config']['setting']['founder'];
	if ($response['code'] == 200) {
		$content = $response['content'];
		$worker_notice_lists = json_decode($content, JSON_OBJECT_AS_ARRAY);
		if (!empty($worker_notice_lists)) {
			foreach ($worker_notice_lists as $list) {
				message_notice_record($list['note'], $uid, $list['uuid'], MESSAGE_WORKORDER_TYPE, array('create_time' => strtotime($list['updated_at'])));
			}
		}
	}
	return true;
}


function message_sms_expire_notice() {
	load()->model('cloud');
	load()->model('setting');
	$setting_user_expire = setting_load('user_expire');
	if (empty($setting_user_expire['user_expire']['status'])) {
		return true;
	}

	$setting_sms_sign = setting_load('site_sms_sign');
	$custom_sign = !empty($setting_sms_sign['site_sms_sign']['user_expire']) ? $setting_sms_sign['site_sms_sign']['user_expire'] : '';

	$day = !empty($setting_user_expire['user_expire']['day']) ? $setting_user_expire['user_expire']['day'] : 1;

	$user_table = table('users');
	$user_table->searchWithMobile();
	$user_table->searchWithEndtime($day);
	$user_table->searchWithSendStatus();
	$users_expire = $user_table->searchUsersList();

	if (empty($users_expire)) {
		return true;
	}
	foreach ($users_expire as $v) {
		if (empty($v['puid'])) {
			continue;
		}
		if (!empty($v['mobile']) && preg_match(REGULAR_MOBILE, $v['mobile'])) {
			$result = cloud_sms_send($v['mobile'], '800015', array('username' => $v['username']), $custom_sign);
			if (is_error($result)) {
				$content = "您的用户名{$v['username']}即将过期。";
				pdo_insert('core_sendsms_log', array('mobile' => $v['mobile'], 'content' => $content, 'result' => $result['errno'] . $result['message'], 'createtime' => TIMESTAMP));
			} else {
				pdo_update('users_profile', array('send_expire_status' => 1), array('uid' => $v['uid']));
			}
		}
	}
	return true;
}


function message_user_expire_notice() {
	global $_W;
	if (!empty($_W['user']['endtime']) && $_W['user']['endtime'] < strtotime('+7 days')) {
		$content = $_W['user']['username'] . '即将过期';
		message_notice_record($content, $_W['uid'], $_W['uid'], MESSAGE_USER_EXPIRE_TYPE, array('end_time' => $_W['user']['endtime']));
	}
	return true;
}


function message_notice_record_cloud($message) {
	load()->classs('cloudapi');
	$api = new CloudApi();
	$result = $api->post('system', 'notify', array('json' => $message), 'html', false);
	return $result;
}


function message_wxapp_modules_version_upgrade() {
	global $_W;
	load()->model('miniapp');
	load()->model('account');

	$wxapp_table = table('account');
	$wxapp_table->searchWithType(array(ACCOUNT_TYPE_APP_NORMAL));
	$uniacid_list = $wxapp_table->searchAccountList();

	if (empty($uniacid_list)) {
		return true;
	}
	$wxapp_list = table('account_wxapp')->wxappInfo(array_keys($uniacid_list));
	$wxapp_modules = table('modules')->getSupportWxappList();

	foreach ($uniacid_list as $uniacid_info) {
		$account_owner = account_owner($uniacid_info['uniacid']);
		if (empty($account_owner) || $account_owner['uid'] != $_W['uid']) {
			continue;
		}

		$uniacid_modules = miniapp_version_all($uniacid_info['uniacid']);

		if (empty($uniacid_modules[0]['modules'])) {
			continue;
		}

		foreach ($uniacid_modules[0]['modules'] as $module) {
			if ($module['version'] < $wxapp_modules[$module['mid']]['version']) {
				$content = $wxapp_list[$uniacid_info['uniacid']]['name'] . '-' . '小程序中的' . $module['title'] . '应用有更新';
				message_notice_record($content, $_W['uid'], $uniacid_info['uniacid'], MESSAGE_WXAPP_MODULE_UPGRADE);
			}
		}
	}
	return true;
}


function message_list_detail($lists) {
	if (empty($lists)) {
		return $lists;
	}
	foreach ($lists as &$message) {
		$message['create_time'] = date('Y-m-d H:i:s', $message['create_time']);

		if ($message['type'] == MESSAGE_ORDER_TYPE) {
			$message['url'] = url('site/entry/orders', array('m' => 'store', 'direct'=>1, 'message_id' => $message['id']));
		}
		if ($message['type'] == MESSAGE_ACCOUNT_EXPIRE_TYPE) {
			$message['url'] = url('account/manage', array('account_type' => ACCOUNT_TYPE_OFFCIAL_NORMAL, 'message_id' => $message['id']));
		}
		if ($message['type'] == MESSAGE_WECHAT_EXPIRE_TYPE) {
			$message['url'] = url('account/manage', array('account_type' => ACCOUNT_TYPE_APP_NORMAL, 'message_id' => $message['id']));
		}

		if ($message['type'] == MESSAGE_WEBAPP_EXPIRE_TYPE) {
			$message['url'] = url('account/manage', array('account_type' => ACCOUNT_TYPE_WEBAPP_NORMAL, 'message_id' => $message['id']));
		}

		if ($message['type'] == MESSAGE_REGISTER_TYPE) {
			if ($message['status'] == USER_STATUS_CHECK) {
				$message['url'] = url('user/display', array('type' => 'check', 'message_id' => $message['id']));
			}
			if ($message['status'] == USER_STATUS_NORMAL) {
				$message['url'] = url('user/display', array('message_id' => $message['id']));
			}
			$source_array = array('mobile' => '手动注册', 'system' => '手动注册', 'qq' => 'QQ 注册', 'wechat' => '微信注册', 'admin' => '管理员添加');
			$msg = explode('--', $message['message']);
			if (count($msg) > 1 && !empty($source_array[$msg[1]])) {
				$message['message'] = $msg[0];
				$message['source'] = $source_array[$msg[1]];
			}
		}

		if ($message['type'] == MESSAGE_USER_EXPIRE_TYPE) {
			$message['url'] = url('user/profile', array('message_id' => $message['id']));
		}
		if ($message['type'] == MESSAGE_WXAPP_MODULE_UPGRADE) {
			$message['url'] = url('message/notice', array('message_id' => $message['id']));
		}

		if ($message['type'] == MESSAGE_WORKORDER_TYPE) {
			$message['url'] = url('system/workorder/display', array('uuid' => $message['sign'], 'message_id' => $message['id']));
		}
	}

	return $lists;
}


function message_setting() {
	$setting = setting_load('message_notice_setting');
	if (!empty($setting['message_notice_setting'])) {
		return $setting['message_notice_setting'];
	}
	return array(
		'order'	=> array(
			'title' => '订单消息',
			'msg' => '用户购买模块，服务等，提交订单或付款后，将会有消息提醒，建议打开',
			'types' => array(
				MESSAGE_ORDER_TYPE => array(
					'type' => MESSAGE_ORDER_TYPE,
					'title' => '提交订单',
					'msg' => '用户购买模块，服务等，提交订单后，将会有消息提醒，建议打开',
				),
				MESSAGE_ORDER_PAY_TYPE => array(
					'type' => MESSAGE_ORDER_PAY_TYPE,
					'title' => '支付成功',
					'msg' => '用户购买模块，服务等，付款后，将会有消息提醒，建议打开',
				),
			),
		),
		'expire' => array(
			'title' => '到期消息',
			'msg' => '用户公众号到，小程序到期，平台类型到期，将会有消息提醒，建议打开',
			'types' => array(
				MESSAGE_ACCOUNT_EXPIRE_TYPE => array(
					'type' => MESSAGE_ACCOUNT_EXPIRE_TYPE,
					'title' => '公众号到期',
					'msg' => '用户公众号到期后，将会有消息提醒，建议打开',
				),
				MESSAGE_WECHAT_EXPIRE_TYPE => array(
					'type' => MESSAGE_WECHAT_EXPIRE_TYPE,
					'title' => '小程序到期',
					'msg' => '用户小程序到期后，将会有消息提醒，建议打开',
				),
				MESSAGE_WEBAPP_EXPIRE_TYPE => array(
					'type' => MESSAGE_WEBAPP_EXPIRE_TYPE,
					'title' => 'pc过期',
					'msg' => '用户pc类型到期后，将会有消息提醒，建议打开',
				),
				MESSAGE_USER_EXPIRE_TYPE => array(
					'type' => MESSAGE_USER_EXPIRE_TYPE,
					'title' => '用户账号到期',
					'msg' => '用户账号到期后，将会有消息提醒，建议打开',
				),
			),
		),
		'work' => array(
			'title' => '工单提醒',
			'msg' => '站点有工单消息时，将会有消息提醒，建议打开',
			'types' => array(
				MESSAGE_WORKORDER_TYPE => array(
					'type' => MESSAGE_WORKORDER_TYPE,
					'title' => '新工单',
					'msg' => '站点有新工时，将会有消息提醒，建议打开',
				),
			),
		),
		'register' => array(
			'title' => '注册提醒',
			'msg' => '用户注册后，将会有消息提醒，建议打开',
			'types' => array(
				MESSAGE_REGISTER_TYPE => array(
					'type' => MESSAGE_REGISTER_TYPE,
					'title' => '新用户注册',
					'msg' => '新用户注册后，将会有消息提醒，建议打开',
				),
			),
		),
	);
}



function message_store_notice() {
	load()->model('cloud');
	$data = cloud_get_store_notice();
	if (is_error($data)) {
		return $data;
	}

	$insert_data = array();
	$signs = array();
	$create_time = array();
	foreach ($data['version'] as $item) {
		$signs[] = $item['itemid'];
		$create_time[] = $item['datetime'];
		$insert_data[] = array(
			'sign' => $item['itemid'],
			'message' => $item['title'],
			'url' => $item['url'],
			'create_time' => $item['datetime'],
			'type' => MESSAGE_SYSTEM_UPGRADE,
			'is_read' => MESSAGE_NOREAD,
		);
	}
	foreach ($data['info'] as $item) {
		$signs[] = $item['itemid'];
		$create_time[] = $item['datetime'];
		$insert_data[] = array(
			'sign' => $item['itemid'],
			'message' => $item['title'],
			'url' => $item['url'],
			'create_time' => $item['datetime'],
			'type' => MESSAGE_OFFICIAL_DYNAMICS,
			'is_read' => MESSAGE_NOREAD,
		);
	}

	if (!empty($signs)) {
		array_multisort($create_time, SORT_ASC, SORT_NUMERIC, $insert_data);

		$signs = pdo_getall('message_notice_log', array('sign' => $signs), array('sign'), 'sign');
		$signs = array_keys($signs);
		foreach ($insert_data as $item) {
			if (!in_array($item['sign'], $signs)) {
				pdo_insert('message_notice_log', $item);
			}
		}
	}
	return true;
}
