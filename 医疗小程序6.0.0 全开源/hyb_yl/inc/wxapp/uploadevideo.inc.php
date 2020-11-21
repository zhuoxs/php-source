<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];    
$op = $_GPC['op'];
$uptypes = array('video/mp4','video/mp3','audio/mpeg');
$max_file_size = 2000000;
$destination_folder = '../attachment/';
if (!is_uploaded_file($_FILES['upfile']['tmp_name'])) {
    echo '图片不存在!';
    die;
}
$file = $_FILES['upfile'];
if ($max_file_size < $file['size']) {
    echo '文件太大!';
    die;
}
if (!in_array($file['type'], $uptypes)) {
    echo '文件类型不符!' . $file['type'];
    die;
}
$filename = $file['tmp_name'];
$image_size = getimagesize($filename);
$pinfo = pathinfo($file['name']);
$ftype = $pinfo['extension'];
$destination = $destination_folder . str_shuffle(time() . rand(111111, 999999)) . '.' . $ftype;
if (file_exists($destination) && $overwrite != true) {
    echo '同名文件已经存在了';
    die;
}
if (!move_uploaded_file($filename, $destination)) {
    echo '移动文件出错';
    die;
}
$pinfo = pathinfo($destination);
$fname = $pinfo['basename'];
echo $fname;
@(require_once IA_ROOT . '/framework/function/file.func.php');
@($filename = $fname);
@file_remote_upload($filename);