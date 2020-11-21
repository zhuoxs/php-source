<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>微信登录</title>
</head>
<body>
<?php
/**App会调用两次此页面，一次post,一次get*/
//第一次是App的POST请求，前端不可见，可在post请求时存储接收到的用户数据（此时不支持session和cookie的存储，不支持页面跳转）
if(!empty($_POST)){
	wl_load()->model('member');
    $token=json_decode($_POST["token"],1);
	checkAppMember($token);
}
//第二次是App的直接打开这个页面，可在此时做跳转处理（可根据POST请求时存储的数据判断如何跳转）。
else{ 
//	//登录成功后读取用户相关信息
   $openid=$_REQUEST["openid"];
   $info = pdo_fetch('select openid,unionid from ' . tablename('tg_member') . ' where appopenid=:appopenid limit 1', array(':appopenid' => $openid));
   
   setcookie('unionid',$info['unionid'],time()+3600*1);
   header("Location: ".app_url("home/index"));
}
?>

    </body>
</html>
  
