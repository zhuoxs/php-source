<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27
 * Time: 9:49
 */

defined('IN_IA') or exit('Access Denied');
global $_W;
global $_GPC;



if($_W['ispost']){
    $file = $_FILES['file'];
    //前缀
    $pre = date("Ymd",time()).'_'.substr(md5(microtime()),rand(0,32-8),8);
    //后缀
    $ext = strrchr($file['name'],'.');
    $name= $pre.$ext;

    // 文件目录
    $path = ATTACHMENT_ROOT;
  	//p($path);die;
    //创建文件夹
    if(!is_dir($path)){
        mkdir($path,777,true);
    }
  	
  	// 移动文件
  	$filePath = $path.$name;
    $res=move_uploaded_file($file['tmp_name'],$filePath);
  	//p($filePath);die;
    
    $ip = $_SERVER['HTTP_HOST'] ;
    $a = 'https://'.$ip.'/attachment'.'/'.$name;
    //p($a);die;
    if($res){
        //存入数据库
        $return = ['code'=>'1','msg'=>'上传成功','url'=>$a];
    }else{
        $return = ['code'=>'0','msg'=>'上传失败','url'=>''];
    }
    echo json_encode($return);

}