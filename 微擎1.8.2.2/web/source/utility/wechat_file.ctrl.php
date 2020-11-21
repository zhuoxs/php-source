<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');
error_reporting(0);
global $_W;
load()->func('file');
load()->func('communication');
load()->model('account');
$limit = array();
$limit['temp'] = array(
	'image' => array(
		'ext' => array('jpg', 'logo'),
		'size' => 1024 * 1024,
		'errmsg' => '临时图片只支持jpg/logo格式,大小不超过为1M',
	),
	'voice' => array(
		'ext' => array('amr', 'mp3'),
		'size' => 2048 * 1024,
		'errmsg' => '临时语音只支持amr/mp3格式,大小不超过为2M',
	),
	'video' => array(
		'ext' => array('mp4'),
		'size' => 10240 * 1024,
		'errmsg' => '临时视频只支持mp4格式,大小不超过为10M',
	),
	'thumb' => array(
		'ext' => array('jpg', 'logo'),
		'size' => 64 * 1024,
		'errmsg' => '临时缩略图只支持jpg/logo格式,大小不超过为64K',
	),
);
$limit['perm'] = array(
	'image' => array(
		'ext' => array('bmp', 'png', 'jpeg', 'jpg', 'gif'),
		'size' => 2048 * 1024,
		'max' => 5000,
		'errmsg' => '永久图片只支持bmp/png/jpeg/jpg/gif格式,大小不超过为2M',
	),
	'voice' => array(
		'ext' => array('amr', 'mp3', 'wma', 'wav', 'amr'),
		'size' => 5120 * 1024,
		'max' => 1000,
		'errmsg' => '永久语音只支持mp3/wma/wav/amr格式,大小不超过为5M,长度不超过60秒',
	),
	'video' => array(
		'ext' => array('rm', 'rmvb', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4'),
		'size' => 10240 * 1024 * 2,
		'max' => 1000,
		'errmsg' => '永久视频只支持rm/rmvb/wmv/avi/mpg/mpeg/mp4格式,大小不超过为20M',
	),
	'thumb' => array(
		'ext' => array('bmp', 'png', 'jpeg', 'jpg', 'gif'),
		'size' => 2048 * 1024,
		'max' => 5000,
		'errmsg' => '永久缩略图只支持bmp/png/jpeg/jpg/gif格式,大小不超过为2M',
	),

);

$limit['file_upload'] = array(
	'image' => array(
		'ext' => array('jpg'),
		'size' => 1024 * 1024,
		'max' => -1,
		'errmsg' => '图片只支持jpg格式,大小不超过为1M',
	)
);

$apis = array();
$apis['temp'] = array(
	'add' => 'https://api.weixin.qq.com/cgi-bin/media/upload',
	'get' => 'https://api.weixin.qq.com/cgi-bin/media/get',
	'post_key' => 'media'
);
$apis['perm'] = array(
	'add' => 'https://api.weixin.qq.com/cgi-bin/material/add_material',
	'get' => 'https://api.weixin.qq.com/cgi-bin/material/get_material',
	'del' => 'https://api.weixin.qq.com/cgi-bin/material/del_material',
	'count' => 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount',
	'batchget' => 'https://api.weixin.qq.com/cgi-bin/material/batchget_material',
	'post_key' => 'media',
);

$apis['file_upload'] = array(
	'add' => 'https://api.weixin.qq.com/cgi-bin/media/uploadimg',
	'post_key' => 'buffer',
);

$result = array(
	'error' => 1,
	'message' => '',
	'data' => ''
);

$type =  trim($_GPC['types']);
if($type == 'image' || $type == 'thumb') {
	$type = 'image';
}
if($type == 'voice' || $type == 'video') {
	$type = 'audio';
}

$setting['folder'] = "{$type}s/{$_W['uniacid']}" . '/'.date('Y/m/');


if ($do == 'upload') {
	$type = trim($_GPC['types']);
	$mode = trim($_GPC['mode']);
	$acid = $_W['acid'];
	if($mode == 'perm') {
		$now_count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wechat_attachment') . ' WHERE uniacid = :aid AND acid = :acid AND model = :model AND type = :type', array(':aid' => $_W['uniacid'], ':acid' => $acid, ':model' => $mode, ':type' => $type));
		if($now_count >= $limit['perm'][$type]['max']) {
			$result['message'] = '文件数量超过限制,请先删除部分文件再上传';
			die(json_encode($result));
		}
	}

	if(empty($mode) || empty($type) || !$_W['acid']) {
		$result['message'] = '上传配置出错';
		die(json_encode($result));
	}

	if (empty($_FILES['file']['name'])) {
		$result['message'] = '上传失败, 请选择要上传的文件！';
		die(json_encode($result));
	}

	if ($_FILES['file']['error'] != 0) {
		$result['message'] = '上传失败, 请重试.';
		die(json_encode($result));
	}

	$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	$size = intval($_FILES['file']['size']);
	$originname = $_FILES['file']['name'];

		if(!in_array($ext, $limit[$mode][$type]['ext']) || ($size > $limit[$mode][$type]['size'])) {
		$result['message'] = $limit[$mode][$type]['errmsg'];
		die(json_encode($result));
	}

	$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
	$file = file_wechat_upload($_FILES['file'], $type, $setting['folder'] . $filename);
	if (is_error($file)) {
		$result['message'] = $file['message'];
		die(json_encode($result));
	}

	$pathname = $file['path'];
	$fullname = ATTACHMENT_ROOT  . '/' . $pathname;

		$acc = WeAccount::create($acid);
	$token = $acc->getAccessToken();
	if (is_error($token)) {
		$result['message'] = $token['message'];
		die(json_encode($result));
	}
	if($mode == 'perm' || $mode == 'temp') {
		$sendapi = $apis[$mode]['add'] . "?access_token={$token}&type={$type}";
		$media = '@'.$fullname;
		$data = array(
			'media' => $media
		);
		if($type == 'video') {
			$description = array(
				'title' => $filename,
				'introduction' =>  $filename,
			);
			$data['description'] = urldecode(json_encode($description));
		}
	} elseif($mode == 'file_upload') {
		$sendapi = $apis[$mode]['add'] . "?access_token={$token}";
		$data = array(
			'buffer' => '@'.$fullname
		);
		$type = 'image';
	}
	$resp = ihttp_request($sendapi, $data);
	if(is_error($resp)) {
		$result['error'] = 0;
		$result['message'] = $resp['message'];
		die(json_encode($result));
	}
	$content = @json_decode($resp['content'], true);
	if(empty($content)) {
		$result['error'] = 0;
		$result['message'] = "接口调用失败, 元数据: {$resp['meta']}";
		die(json_encode($result));
	}
	if(!empty($content['errcode'])) {
		$result['error'] = 0;
		$result['message'] = "访问微信接口错误, 错误代码: {$content['errcode']}, 错误信息: {$content['errmsg']},错误详情：{$acc->error_code($content['errcode'])}";
		die(json_encode($result));
	}
	if($mode == 'perm' || $mode == 'temp') {
		if(!empty($content['media_id'])){
			$result['media_id'] = $content['media_id'];
		}
		if(!empty($content['thumb_media_id'])){
			$result['media_id'] = $content['thumb_media_id'];
		}
	} elseif($mode == 'file_upload') {
		$result['media_id'] = $content['url'];
	}

	if ($type == 'image' || $type == 'thumb' ) {
				$file['path'] = file_image_thumb($fullname, '', 300);
	}
	if (!empty($_W['setting']['remote']['type']) && !empty($file['path'])) {
		$remotestatus = file_remote_upload($file['path']);
		if (is_error($remotestatus)) {
						file_delete($pathname);
			if($type == 'image' || $type == 'thumb'){
				file_delete($file['path']);
			}
			$result['error'] = 0;
			$result['message'] = '远程附件上传失败，请检查配置并重新上传';
			die(json_encode($result));
		} else {
						file_delete($pathname);
			if($type == 'image' || $type == 'thumb'){
				file_delete($file['path']);
			}
		}
	}
	$insert = array(
		'uniacid' => $_W['uniacid'],
		'acid' => $acid,
		'uid' => $_W['uid'],
		'filename' => $originname,
		'attachment' => $file['path'],
		'media_id' => $result['media_id'],
		'type' => $type,
		'model' => $mode,
		'createtime' => TIMESTAMP
	);
	if($type == 'image' || $type == 'thumb') {
		$size = getimagesize($fullname);
		$insert['width'] = $size[0];
		$insert['height'] = $size[1];
		if($mode == 'perm') {
						$insert['tag'] = $content['url'];
		}
		if(!empty($insert['tag'])) {
			$insert['attachment'] = $content['url'];
		}
		$result['width'] = $size[0];
		$result['hieght'] = $size[1];
	}
	if($type == 'video') {
		$insert['tag'] = iserializer($description);
	}
	pdo_insert('wechat_attachment', $insert);
	$result['type'] = $type;
	$result['url'] = tomedia($file['path']);

	if($type == 'image' || $type == 'thumb') {
		@unlink($fullname);
	}
	if($type == 'video') {
		$result['title'] = $description['title'];
		$result['introduction'] = $description['introduction'];
	}
	$result['mode'] = $mode;
	die(json_encode($result));
}

if ($do == 'browser') {
	$types = array('image', 'thumb', 'voice', 'video');
	$type = in_array($_GPC['type'], $types) ? $_GPC['type'] : 'image';
	$mode = trim($_GPC['mode']);
	$acid = $_W['acid'];
	$condition = ' WHERE uniacid = :uniacid AND acid = :acid';
	$param = array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']);
	if(empty($mode)) {
		$condition .= ' AND type = :type AND model = :model';
		$param[':type'] = $type;
		$param[':model'] = 'perm';
	} else {
		$condition .= ' AND model = :model';
		$param[':model'] = $mode;
	}
	$page = intval($_GPC['page']);
	$page = max(1, $page);
	$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
	$sql = 'SELECT * FROM '.tablename('wechat_attachment')."{$condition} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
	$list = pdo_fetchall($sql, $param, 'id');
	foreach ($list as &$item) {
		$item['url'] = tomedia($item['attachment']);
		$item['createtime'] = date('Y-m-d H:i', $item['createtime']);
		if($item['type'] == 'video') {
			$item['tag'] = iunserializer($item['tag']);
		}
		unset($item['uid']);
	}
	$total = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('wechat_attachment') . $condition, $param);
	iajax(0, array('page'=> pagination($total, $page, $size, '', array('before' => '2', 'after' => '3', 'ajaxcallback'=>'null')), 'items' => $list));
}

if ($do == 'delete') {
	$id = intval($_GPC['id']);
	$acid = $_W['acid'];
	$data = pdo_fetch('SELECT * FROM ' . tablename('wechat_attachment') . ' WHERE acid = :acid AND id = :id', array(':acid' => $acid, ':id' => $id));
	if(empty($data)) {
		$result['error'] = 0;
		$result['message'] = '素材不存在';
		die(json_encode($result));
	}
	$acc = WeAccount::create($acid);
	$token = $acc->getAccessToken();
	if (is_error($token)) {
		$result['error'] = 0;
		$result['message'] = $token['message'];
		die(json_encode($result));
	}
	$sendapi = $apis[$data['model']]['del'] . "?access_token={$token}";
	$post = array(
		'media_id' => $data['media_id']
	);
	$resp = ihttp_request($sendapi, json_encode($post));
	if(is_error($resp)) {
		$result['error'] = 0;
		$result['message'] = $resp['message'];
		die(json_encode($result));
	}
	$content = @json_decode($resp['content'], true);
	if(empty($content)) {
		$result['error'] = 0;
		$result['message'] = "接口调用失败, 元数据: {$resp['meta']}";
		die(json_encode($result));
	}
	if(!empty($content['errcode'])) {
		$result['error'] = 0;
		$result['message'] = "访问微信接口错误, 错误代码: {$content['errcode']}, 错误信息: {$content['errmsg']},错误详情：{$acc->error_code($content['errcode'])}";
		die(json_encode($result));
	}
	pdo_delete('wechat_attachment', array('acid' => $acid, 'id' => $id));
	die(json_encode($result));
}

function delete_temp(){
	pdo_query('DELETE FROM ' . tablename('wechat_attachment') . ' WHERE createtime + 259200 < :time', array(':time' => time()));
}