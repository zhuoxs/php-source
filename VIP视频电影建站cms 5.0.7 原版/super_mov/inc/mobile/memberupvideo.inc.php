<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$op = $_GPC['op'] ? $_GPC['op'] : 'video';
load()->func('file');
$pageindex = max(intval($_GPC['page']), 1); // 当前页码
$pagesize = 100; // 设置分页大小
$starttime = empty($_GPC['time']['start']) ? strtotime('-180 days') : strtotime($_GPC['time']['start']);
$endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 86399 : strtotime($_GPC['time']['end']) + 86399;
$where = ' WHERE uniacid = :uniacid AND time >= :starttime AND time <= :endtime AND resources = :resources';
$params = array(
    ':uniacid'=>$_W['uniacid'],
    ':resources'=>$_W['openid'],
    ':starttime' => $starttime,
    ':endtime' => $endtime
);
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_manage') . $where , $params);
$pager = pagination($total, $pageindex, $pagesize);
$sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY sort DESC , time DESC , id DESC LIMIT '.(($pageindex -1) * $pagesize).','. $pagesize;          
$list = pdo_fetchall($sql, $params, 'id');          
$type  =  'video';
$type = in_array($type, array('image','audio','video')) ? $type : 'video';
$setting = $_W['setting']['upload'][$type];
if ($op == 'upload') {
	$uniacid = intval($_W['uniacid']);
	$setting['folder'] = "{$type}s/{$uniacid}";

	if (empty($dest_dir)) {

		$setting['folder'] .= '/' . date('Y/m/');

	} else {

		$setting['folder'] .= '/' . $dest_dir . '/';

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

	$filename = file_random_name(ATTACHMENT_ROOT . '/' . $setting['folder'], $ext);



	$file = file_upload($_FILES['file'], $type, $setting['folder'] . $filename, true);

	

	if (is_error($file)) {

		$result['message'] = $file['message'];

		die(json_encode($result));

	}

	$pathname = $file['path'];

	$fullname = ATTACHMENT_ROOT . '/' . $pathname; 
	$link = $_W['attachurl'] . $pathname;
	$data = array();          
    $data['uniacid'] = $_W['uniacid'];          
    $data['time'] = TIMESTAMP;
    $data['title'] =$_GPC['title'];
    $data['thumb'] =$_GPC['thumb'];
    $data['cid'] = '10';
    $data['pid'] = '';
    $video_url[] = array( 
        'title' => $_GPC['title'],                   
        'link' => $link,        
    );        
    $data['video_url'] = iserializer($video_url); 
    $data['resources'] = $_W['openid'];               
    $res = pdo_insert('cyl_vip_video_manage', $data);
    $id = pdo_insertid();              
	echo $_W['attachurl'] . $pathname;
	exit();
}
if ($op == 'imgupload') { 
	$img = $_POST['imgbase64'];
	if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)) {
	    $type = ".".$result[2];
	    $path = "images/" . $_W['uniacid'] . '/' . date('Y/m/') . date("Y-m-d") . "-" . uniqid() . $type;
	}
	$img =  base64_decode(str_replace($result[1], '', $img));
	@file_put_contents(ATTACHMENT_ROOT . $path, $img);
	// exit('{"src":"'.$path.'"}');
	echo json_encode(array('src'=>tomedia($path),'val'=>$path));
	exit();
	// load()->classs('weixin.account');
 //    $acc = WeiXinAccount::create();        
 //    $media = $acc->downloadMedia($_GPC['mid']);        
 //    echo json_encode(array('src'=>tomedia($media),'val'=>$media));
 //    exit();
}
if ($op == 'del') {
	$id = $_GPC['id'];
    $row = pdo_fetch("SELECT rid FROM ".tablename('cyl_vip_video_manage')." WHERE id = :id", array(':id' => $id));
    $res = pdo_delete('cyl_vip_video_manage', array('id'=>$id));        
    if($res){
        message('删除成功！',$this->createMobileUrl('memberupvideo'),'success');
    }
}
include $this->template('news/memberupvideo');
