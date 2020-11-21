<?php
	global $_W,$_GPC;
	
	$members=$_GPC['members'];	
	$message=$_GPC['message'];
	
	
	$url ='http://123.56.233.239:8080/msg-core-web/msg/sendMsg';
	$post_data['sn'] ='SDK_BBB_00003';
	$post_data['password'] ='EE8QMm';
	$post_data['mobile'] =$members;
	$post_data['content'] =$message;
	$post_data['content'] =$message;
	$post_data['ext'] ='';
	
	$res =request_post($url, $post_data);
	

        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$res));
        }else{
            echo json_encode(array('status'=>0,'log'=>$res));
        }
	

?>