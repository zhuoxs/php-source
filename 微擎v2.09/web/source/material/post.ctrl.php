<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('material_mass');
$_W['page']['title'] = '新增素材-微信素材';
$dos = array('edit', 'thumb', 'details', 'image', 'submit');
$do = in_array($do, $dos) ? $do : 'edit';

if($do == 'edit') {
	template('material/post');
}

if($do == 'thumb') {
	$post = $_GPC['__input'];
	$thumb = $post['val'];
	load()->func('file');
	$thumb = file_fetch(tomedia($thumb), 2048, 'material/images');
	if(is_error($thumb)) {
		message($thumb, '', 'ajax');
	}
		load()->model('account');
	$acc = WeAccount::create($_W['acid']);
	$token = $acc->getAccessToken();
	if (is_error($token)) {
		message(error(-1, $token['message']), '', 'ajax');
	}
	$fullname = ATTACHMENT_ROOT . $thumb;
	$sendapi = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$token}&type=thumb";
	$data = array(
		'media' => '@'.$fullname
	);
	load()->func('communication');
	$resp = @ihttp_request($sendapi, $data);
	if(is_error($resp)) {
		message($resp, '', 'ajax');
	}
	$content = @json_decode($resp['content'], true);
	if(empty($content)) {
		message(error(-1, "接口调用失败, 元数据: {$resp['meta']}"), '', 'ajax');
	}
	if(!empty($content['errcode'])) {
		$message = "访问微信接口错误, 错误代码: {$content['errcode']}, 错误信息: {$content['errmsg']}";
		message(error(-1, $message), '', 'ajax');
	}
	message(error(0, $content), '', 'ajax');
}

if($do == 'details') {
	$post = $_GPC['__input'];
	$images = array();
	foreach($post as $key => $val) {
		$match = array();
		preg_match_all('/<img.*src=[\'"](.*\.(?:png|jpg|jpeg|jpe|gif))[\'"].*\/?>/iU', $val['val'], $match);	
		if(!empty($match[1])) {
			foreach($match[1] as $val) {
				if((strexists($val, 'http://') || strexists($val, 'https://')) && !strexists($val, 'mmbiz.qlogo.cn') && !strexists($val, 'mmbiz.qpic.cn')) {
					$images[] = $val;
				} else {
					if(strexists($val, './attachment/images/')) {
						$images[] = tomedia($val);
					}
				}
			}
		}
	}
	message(error(0, $images), '', 'ajax');
}

if($do == 'image') {
	$post = $_GPC['__input'];
	$thumb = $post['image'];
	$hasimgs = $post['hasimgs'];
	$wximgs = $post['wximgs'];
	if($index = in_array($thumb, $hasimgs)) {
		message(error(0, $wximgs[$index]), '', 'ajax');
	}
	if(empty($thumb)) {
		message(error(0, ''), '', 'ajax');
	}
	load()->func('file');
	$thumb = file_fetch(tomedia($thumb), 1024, 'material/images');
	if(is_error($thumb)) {
		message($thumb, '', 'ajax');
	}
		load()->model('account');
	$acc = WeAccount::create($_W['acid']);
	$token = $acc->getAccessToken();
	if (is_error($token)) {
		message(error(-1, $token['message']), '', 'ajax');
	}
	$fullname = ATTACHMENT_ROOT . $thumb;
	$sendapi = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token={$token}";
	$data = array(
		'media' => '@'.$fullname
	);
	load()->func('communication');
	$resp = @ihttp_request($sendapi, $data);
	if(is_error($resp)) {
		message($resp, '', 'ajax');
	}
	$content = @json_decode($resp['content'], true);
	if(empty($content)) {
		message(error(-1, "接口调用失败, 元数据: {$resp['meta']}"), '', 'ajax');
	}
	if(!empty($content['errcode'])) {
		$message = "访问微信接口错误, 错误代码: {$content['errcode']}, 错误信息: {$content['errmsg']}";
		message(error(-1, $message), '', 'ajax');
	}
	message(error(0, $content['url']), '', 'ajax');
}

if($do == 'submit') {
	$post = $_GPC['__input'];
	$hasimgs = $post['hasimgs'];
	$wximgs = $post['wximgs'];
	$need_sort = false;
	foreach($post['items'] as $key => $val) {
		if ($val['displayorder'] != '0') {
			$need_sort = true;
		}
		$displayorder[$key] = $val['displayorder'];
	}
	if (!empty($need_sort)) {
		array_multisort($displayorder, SORT_DESC, SORT_NUMERIC, $post['items']);
	}
	foreach($post['items'] as &$reply) {
		if(!empty($hasimgs)) {
			$reply['content'] =  str_replace($hasimgs, $wximgs, $reply['content']);
		}
		$row = array(
			'title' => $reply['title'],
			'author' => $reply['author'],
			'digest' => $reply['description'],
			'content' => $reply['content'],
			'show_cover_pic' => intval($reply['incontent']),
			'content_source_url' => $reply['url'],
			'thumb_media_id' => $reply['media_id'],
		);
		$articles['articles'][] = $row;
	}
	$acc = WeAccount::create($_W['acid']);
	$result = $acc->addMatrialNews($articles);
	if(is_error($result)) {
		message($result, '', 'ajax');
	}
	message(error(0, ''), '', 'ajax');
}