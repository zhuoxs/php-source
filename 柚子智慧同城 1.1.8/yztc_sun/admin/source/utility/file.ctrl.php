<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->func('file');
load()->func('communication');
load()->model('account');
load()->model('material');
load()->model('attachment');
load()->model('mc');

if (!in_array($do, array('upload', 'fetch', 'browser', 'delete', 'image' ,'module' ,'video', 'voice', 'news', 'keyword',
	'networktowechat', 'networktolocal', 'towechat', 'tolocal','wechat_upload'))) {
	exit('Access Denied');
}
$result = array(
	'error' => 1,
	'message' => '',
	'data' => ''
);

error_reporting(0);
$type  =  $_GPC['upload_type'];$type = in_array($type, array('image','audio','video')) ? $type : 'image';
$option = array();
$option = array_elements(array('uploadtype', 'global', 'dest_dir'), $_POST);
$option['width'] = intval($option['width']);
$option['global'] = $_GPC['global'];

if (!empty($option['global']) && empty($_W['isfounder'])) {
	$result['message'] = '没有向 global 文件夹上传文件的权限.';
	die(json_encode($result));
}

$dest_dir = $_GPC['dest_dir'];if (preg_match('/^[a-zA-Z0-9_\/]{0,50}$/', $dest_dir, $out)) {
	$dest_dir = trim($dest_dir, '/');
	$pieces = explode('/', $dest_dir);
	if(count($pieces) > 3){
		$dest_dir = '';
	}
} else {
	$dest_dir = '';
}
$module_upload_dir = '';
if($dest_dir != '') {
	$module_upload_dir = sha1($dest_dir);
}

$setting = $_W['setting']['upload'][$type];
$uniacid = intval($_SESSION['admin']['uniacid'] * 10000 + $_SESSION['admin']['store_id']);

//if(isset($_GPC['uniacid'])) {
//    $requniacid = intval($_GPC['uniacid']);
//	attachment_reset_uniacid($requniacid);
//	$uniacid = intval($_W['uniacid']);
//}

if (!empty($option['global'])) {
	$setting['folder'] = "{$type}s/global/";
	if (! empty($dest_dir)) {
		$setting['folder'] .= '' . $dest_dir . '/';
	}
} else {
	$setting['folder'] = "{$type}s/{$uniacid}";
	if (empty($dest_dir)) {
		$setting['folder'] .= '/' . date('Y/m/');
	} else {
		$setting['folder'] .= '/' . $dest_dir . '/';
	}
}


if ($do == 'fetch') {
	$url = trim($_GPC['url']);
	$resp = ihttp_get($url);
	if (is_error($resp)) {
		$result['message'] = '提取文件失败, 错误信息: ' . $resp['message'];
		die(json_encode($result));
	}
	if (intval($resp['code']) != 200) {
		$result['message'] = '提取文件失败: 未找到该资源文件.';
		die(json_encode($result));
	}
	$ext = '';
	if ($type == 'image') {
		switch ($resp['headers']['Content-Type']) {
			case 'application/x-jpg':
			case 'image/jpeg':
				$ext = 'jpg';
				break;
			case 'image/png':
				$ext = 'png';
				break;
			case 'image/gif':
				$ext = 'gif';
				break;
			default:
				$result['message'] = '提取资源失败, 资源文件类型错误.';
				die(json_encode($result));
				break;
		}
	} else {
		$result['message'] = '提取资源失败, 仅支持图片提取.';
		die(json_encode($result));
	}

	if (intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024) {
		$result['message'] = '上传的媒体文件过大(' . sizecount($size) . ' > ' . sizecount($setting['limit'] * 1024);
		die(json_encode($result));
	}
	$originname = pathinfo($url, PATHINFO_BASENAME);
	$filename = file_random_name(ATTACHMENT_ROOT . '/' . $setting['folder'], $ext);
	$pathname = $setting['folder'] . $filename;
	$fullname = ATTACHMENT_ROOT . '/' . $pathname;
	if (file_put_contents($fullname, $resp['content']) == false) {
		$result['message'] = '提取失败.';
		die(json_encode($result));
	}
}


if ($do == 'upload') {
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

	$filename = file_random_name(ATTACHMENT_ROOT . '/' . $setting['folder'], $ext);

	$file = file_upload($_FILES['file'], $type, $setting['folder'] . $filename, true);

	if (is_error($file)) {
		$result['message'] = $file['message'];
		die(json_encode($result));
	}
	$pathname = $file['path'];
	$fullname = ATTACHMENT_ROOT . '/' . $pathname;
}

if ($do == 'fetch' || $do == 'upload') {
	if ($type == 'image') {
		$thumb = empty($setting['thumb']) ? 0 : 1; 		$width = intval($setting['width']);
		if (isset($option['thumb'])) {
			$thumb = empty($option['thumb']) ? 0 : 1;
		}
		if (isset($option['width']) && ! empty($option['width'])) {
			$width = intval($option['width']);
		}
		if ($thumb == 1 && $width > 0) {
			$thumbnail = file_image_thumb($fullname, '', $width);
			@unlink($fullname);
			if (is_error($thumbnail)) {
				$result['message'] = $thumbnail['message'];
				die(json_encode($result));
			} else {
				$filename = pathinfo($thumbnail, PATHINFO_BASENAME);
				$pathname = $thumbnail;
				$fullname = ATTACHMENT_ROOT . '/' . $pathname;
			}
		}
	}

	$info = array(
		'name' => $originname,
		'ext' => $ext,
		'filename' => $pathname,
		'attachment' => $pathname,
		'url' => tomedia($pathname),
		'is_image' => $type == 'image' ? 1 : 0,
		'filesize' => filesize($fullname),
	);
	if ($type == 'image') {
		$size = getimagesize($fullname);
		$info['width'] = $size[0];
		$info['height'] = $size[1];
	} else {
		$size = filesize($fullname);
		$info['size'] = sizecount($size);
	}
	if (!empty($_W['setting']['remote'][$_W['uniacid']]['type'])) {
		$_W['setting']['remote'] = $_W['setting']['remote'][$_W['uniacid']];
	}
	if (!empty($_W['setting']['remote']['type'])) {
		$remotestatus = file_remote_upload($pathname);
		if (is_error($remotestatus)) {
			$result['message'] = '远程附件上传失败，请检查配置并重新上传';
			file_delete($pathname);
			die(json_encode($result));
		} else {
			file_delete($pathname);
			$info['url'] = tomedia($pathname);
		}
	}
	pdo_insert('core_attachment', array(
		'uniacid' => $uniacid,
		'uid' => $_W['uid'],
		'filename' => $originname,
		'attachment' => $pathname,
		'type' => $type == 'image' ? 1 : ($type == 'audio'||$type == 'voice' ? 2 : 3),
		'createtime' => TIMESTAMP,
		'module_upload_dir' => $module_upload_dir
	));
	$info['state'] = 'SUCCESS';	die(json_encode($info));
}

if ($do == 'delete') {
	$id = intval($_GPC['id']);
	$media = pdo_get('core_attachment', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if (empty($media)) {
		exit('文件不存在或已经删除');
	}
	if (empty($_W['isfounder']) && $_W['role'] != ACCOUNT_MANAGE_NAME_MANAGER && $_W['role'] != ACCOUNT_MANAGE_NAME_OWNER) {
		exit('您没有权限删除该文件');
	}
	if (!empty($_W['setting']['remote']['type'])) {
		$status = file_remote_delete($media['attachment']);
	} else {
		$status = file_delete($media['attachment']);
	}
	if (is_error($status)) {
		exit($status['message']);
	}
	pdo_delete('core_attachment', array('uniacid' => $uniacid, 'id' => $id));
	exit('success');
}


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


if ($do == 'wechat_upload') {
	$type = trim($_GPC['upload_type']);
	$mode = trim($_GPC['mode']);
	if($type == 'image' || $type == 'thumb') {
		$type = 'image';
	}
	if( $type == 'audio') {
		$type = 'voice';
	}

	$setting['folder'] = "{$type}s/{$_W['uniacid']}" . '/'.date('Y/m/');

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
	$file = file_wechat_upload($_FILES['file'], $type, $setting['folder'] . $filename, true);
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
		'createtime' => TIMESTAMP,
		'module_upload_dir' => $module_upload_dir
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




$type = $_GPC['type']; $resourceid = intval($_GPC['resource_id']); $uid = intval($_W['uid']);
$acid = intval($_W['acid']);
$url = $_GPC['url'];
$isnetwork_convert = !empty($url);
$islocal = $_GPC['local'] == 'local'; if ($do == 'keyword') {
	$keyword = addslashes($_GPC['keyword']);
	$pindex = max(1, $_GPC['page']);
	$psize = 24;
	$condition = array('uniacid' => $uniacid, 'status' => 1);
	if (!empty($keyword)) {
		$condition['content like'] = '%'.$keyword.'%';
	}
	$keyword_lists = pdo_getslice('rule_keyword', $condition, array($pindex, $psize), $total, array(), 'id');
	$result = array(
		'items' => $keyword_lists,
		'pager' => pagination($total, $pindex, $psize, '', array('before' => '2', 'after' => '3', 'ajaxcallback' => 'null', 'isajax' => 1)),
	);
	iajax(0, $result);
}
if ($do == 'module') {
	$enable_modules = array();
	$installedmodulelist = uni_modules(false);
	foreach ($installedmodulelist as $k => $value) {
		$installedmodulelist[$k]['official'] = empty($value['issystem']) && (strexists($value['author'], 'WeEngine Team') || strexists($value['author'], '微擎团队'));
	}
	foreach ($installedmodulelist as $name => $module) {
		if ($module['issystem']) {
			$path = '/framework/builtin/'.$module['name'];
		} else {
			$path = '../addons/'.$module['name'];
		}
		$cion = $path.'/icon.jpg';
		if (!file_exists($cion)) {
			$cion = $path.'/icon.jpg';
			if (!file_exists($cion)) {
				$cion = './resource/images/nopic-small.jpg';
			}
		}
		$module['icon'] = $cion;
		if ($module['enabled'] == 1) {
			$enable_modules[] = $module;
		} else {
			$unenable_modules[$name] = $module;
		}
	}
	$result = array('items' => $enable_modules, 'pager' => '');
	iajax(0, $result);
}
if ($do == 'video' || $do == 'voice') {
	$server = $islocal ? MATERIAL_LOCAL : MATERIAL_WEXIN;
	$page_index = max(1, $_GPC['page']);
	$page_size = 10;
	$material_news_list = material_list($do, $server, array('page_index' => $page_index, 'page_size' => $page_size));
	$material_list = $material_news_list['material_list'];
	$pager = $material_news_list['page'];
	foreach ($material_list as &$item) {
		$item['url'] = tomedia($item['attachment']);
		unset($item['uid']);
	}
	$result = array('items' => $material_list, 'pager' => $pager);
	iajax(0, $result);
}

if ($do == 'news') {
	$server = $islocal ? MATERIAL_LOCAL : MATERIAL_WEXIN;
	$page_index = max(1, $_GPC['page']);
	$page_size = 24;
	$search = addslashes($_GPC['keyword']);
	$material_news_list = material_news_list($server, $search, array('page_index' => $page_index, 'page_size' => $page_size));

	$material_list = array_values($material_news_list['material_list']);
	$pager = $material_news_list['page'];
	$result = array('items' => $material_list, 'pager' => $pager);
	iajax(0, $result);
}
if ($do == 'image') {
	$page_size = 24;
	if ($islocal) {
		$page = $_GPC['page'];
		$page = max(1, $page);
		$condition = ' WHERE uniacid = :uniacid AND type = :type AND module_upload_dir = :module_upload_dir';
		$params = array(':uniacid' => $uniacid, ':type' => 1, ':module_upload_dir' => $module_upload_dir);

		$year = $_GPC['year'];
		$month = $_GPC['month'];
		if ($year > 0 || $month > 0) {
			$starttime = strtotime("{$year}-{$month}-01");
			$endtime = strtotime('+1 month', $starttime);
			$condition .= ' AND createtime >= :starttime AND createtime <= :endtime';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}
		$sql = 'SELECT * FROM '.tablename('core_attachment')." {$condition} ORDER BY id DESC LIMIT ".(($page - 1) * $page_size).','.$page_size;
		$list = pdo_fetchall($sql, $params);
		foreach ($list as &$item) {
			$item['url'] = tomedia($item['attachment']);
			unset($item['uid']);
		}
		$total = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('core_attachment')." {$condition}", $params);
		$result = array(
			'items' => $list,
			'pager' => pagination($total, $page, $page_size, '', array('before' => '2', 'after' => '3', 'ajaxcallback' => 'null')),
		);
	} else {
		$page = $_GPC['page'];
		$page_index = max(1, $page);
		$conditions['uniacid'] = $uniacid;
		$conditions['type'] = 'image';
		$conditions['module_upload_dir'] = $module_upload_dir;
		$material_list = pdo_getslice('wechat_attachment', $conditions, array($page_index, $page_size), $total, array(), '', 'createtime DESC');
		$pager = pagination($total, $page_index, $page_size,'',$context = array('before' => 5, 'after' => 4, 'isajax' => $_W['isajax']));

		foreach ($material_list as &$meterial) {
			$meterial['attach'] = tomedia($meterial['attachment'], true);
			$meterial['url'] = $meterial['attach'];
		}
		$result = array('items' => $material_list, 'pager' => $pager);
	}
	iajax(0, $result);
}


if ($do == 'tolocal' || $do == 'towechat') {
	if (!in_array($type, array('news', 'image', 'video', 'voice'))) {
		iajax(1, '转换类型不正确');
		return;
	}
}


if ($do == 'networktolocal') {
	$type = $_GPC['type'];
	if (!in_array($type,array('image','video'))) {
		$type = 'image';
	}



	$material = material_network_to_local($url, $uniacid, $uid, $type);
	if (is_error($material)) {
		iajax(1, $material['message']);

		return;
	}
	iajax(0, $material);
}

if ($do == 'tolocal') {
	if ($type == 'news') {
		$material = material_news_to_local($resourceid); 	} else {
		$material = material_to_local($resourceid, $uniacid, $uid, $type); 	}
	if (is_error($material)) {
		iajax(1, $material['message']);
		return;
	}
	iajax(0, $material);
}

if ($do == 'networktowechat') {

	$type = $_GPC['type'];
	if (!in_array($type,array('image','video'))) {
		$type = 'image';
	}

	$material = material_network_to_wechat($url, $uniacid, $uid, $acid, $type); 	if (is_error($material)) {
		iajax(1, $material['message']);

		return;
	}
	iajax(0, $material);

	return;
}


if ($do == 'towechat') {
	$material = null;
	if ($type != 'news') {
		$material = material_to_wechat($resourceid, $uniacid, $uid, $acid, $type); 	} else {
		$material = material_local_news_upload($resourceid);			if (!is_error($material)) {
			$material['items'] = $material['news']; 		}
	}
	if (is_error($material)) {
		iajax(1, $material['message']);

		return;
	}
	iajax(0, $material);
}

function iajax($code = 0, $message = '', $redirect = '') {
	message(error($code, $message), $redirect, 'ajax', false);
}