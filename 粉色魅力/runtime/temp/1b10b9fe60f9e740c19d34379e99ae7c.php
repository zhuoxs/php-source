<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:35:"template/RX03/html/gbook/index.html";i:1552059838;s:62:"/www/wwwroot/testxt.com/template/RX03/html/public/include.html";i:1553153526;s:59:"/www/wwwroot/testxt.com/template/RX03/html/public/head.html";i:1563779151;s:59:"/www/wwwroot/testxt.com/template/RX03/html/public/left.html";i:1549128216;s:61:"/www/wwwroot/testxt.com/template/RX03/html/public/paging.html";i:1540443312;s:59:"/www/wwwroot/testxt.com/template/RX03/html/public/foot.html";i:1554795880;}*/ ?>
<!DOCTYPE html>
<html lang="en">
 <head> 
  <meta charset="utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
  <title>留言求片 - <?php echo $maccms['site_name']; ?></title> 
  <meta name="description" content="<?php echo $obj['type_des']; ?>" /> 
  <meta name="keywords" content="<?php echo $obj['type_key']; ?>" /> 
  <meta name="author" content="<?php echo $maccms['site_name']; ?>" /> 
  <!-- Favicon Icon --> 
  <link rel="icon" type="image/png" href="<?php echo $maccms['path_tpl']; ?>html/style/images/favicon.png" /> 
  <!-- Bootstrap core CSS--> 
  <link href="<?php echo $maccms['path_tpl']; ?>html/style/css/bootstrap.min.css" rel="stylesheet" /> 
  <!-- Custom fonts for this template--> 
  <link href="<?php echo $maccms['path_tpl']; ?>html/style/css/all.min.css" rel="stylesheet" type="text/css" /> 
  <!-- Custom styles for this template--> 
  <link href="<?php echo $maccms['path_tpl']; ?>html/style/css/osahan.css" rel="stylesheet" /> 
  <!-- Owl Carousel --> 
  <link rel="stylesheet" href="<?php echo $maccms['path_tpl']; ?>html/style/css/owl.carousel.css" /> 
  <link rel="stylesheet" href="<?php echo $maccms['path_tpl']; ?>html/style/css/owl.theme.css" /> 
  <link href="<?php echo $maccms['path_tpl']; ?>html/style/css/sweetalert.css" rel="stylesheet" type="text/css" /> 
  <script src="<?php echo $maccms['path_tpl']; ?>html/style/js/sweetalert.min.js" type="text/javascript"></script> 
  <script src="<?php echo $maccms['path_tpl']; ?>html/style/js/jquery.min.js"></script> 
  <script src="<?php echo $maccms['path_tpl']; ?>html/style/js/jquery.lazyload.min.js"></script> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
<script src="<?php echo $maccms['path']; ?>static/js/jquery.autocomplete.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/jquery.superslide.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/jquery.base.js"></script>
<script>var maccms={"path":"","mid":"<?php echo $maccms['mid']; ?>","aid":"<?php echo $maccms['aid']; ?>","url":"<?php echo $maccms['site_url']; ?>","wapurl":"<?php echo $maccms['site_wapurl']; ?>","mob_status":"<?php echo $maccms['mob_status']; ?>"};</script>
<script src="<?php echo $maccms['path']; ?>static/js/home.js"></script>
<style>.table.table-sm .div-pc {display: table-row-group;vertical-align: middle;border-color: inherit;}.table.table-sm ul {padding-left: 0;display: table-row;vertical-align: inherit;border-color: inherit;}.ui-slide-block li {float: left;border-bottom: 1px solid #dee2e6;list-style-type: none;width: 25%;padding: .3rem;overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}.ui-slide-block-pc li,.ui-slide-block-pc-down li,.ui-slide-block-pc-down2 li{width: 120px;font-size: 14px;line-height: 25px !important;padding: .3rem;vertical-align: top;float: left;border-bottom: 1px solid #dee2e6;list-style-type: none;overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}@media (max-width: 768px){body.sidebar-toggled #block-slide{display: block !important}.navbar-brand{width:8rem;margin-right: 0rem!important;}.table.table-sm ul{display:block;overflow:hidden;}}</style>

  <script>
        $(function(){
            MAC.Gbook.Login = <?php echo $gbook['login']; ?>;
            MAC.Gbook.Verify = <?php echo $gbook['verify']; ?>;
            MAC.Gbook.Init();
        });
    </script>
  <style>
        .sidebar .nav-item .dropdown-menu{
            top: -100%!important;
        }
        .shadow_border{border: 1px solid #000;padding: 60px; width:100px;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
            -webkit-box-shadow: #666 0px 0px 10px;
            -moz-box-shadow: #666 0px 0px 10px;
            box-shadow: #666 0px 0px 10px;}


        .shadow_font{text-shadow: #f00 3px 3px 3px;}

        .nav_new{
            position: fixed;

            z-index: 99;
            width: 100%;
        }
        .ui-fix-top{
            position: fixed;
            left:0;
            right:0;
            top:0
        }
        .ui-wrapper{
            margin-top: 58px;
        }
        .ui-slide-block-pc,.ui-slide-block-pc-down2{
            background: linear-gradient(123deg, #ff516b 0%,#8876ea 100%);
            display: none;
            /*position: sticky;*/
            position: fixed;
            z-index: 100;
            margin-left: 14.1rem;
            border-bottom:5px solid #ffbfef;
            border-right:5px solid #ffbfef;
            /*border-left:5px solid #ffbfef;*/
        }


         .ui-slide-block-pc td,.ui-slide-block-pc-down2 td{
             width: 120px;
             font-size: 14px;
             line-height: 25px !important;
         }

        .ui-slide-block-pc-down{
            background: linear-gradient(123deg, #69dccc 0%,#5b4baf 100%);
            display: none;
            /*position: sticky;*/
            position: fixed;
            z-index: 100;
            margin-left: 14.1rem;
            border-bottom:5px solid #a8f7ee;
            border-right:5px solid #a8f7ee;
            /*border-left:5px solid #ffbfef;*/
        }

        .ui-slide-block-pc-down td{
            width: 120px;
            font-size: 14px;
            line-height: 25px !important;
        }

        .ui-slide-block{
            background: linear-gradient(123deg, #ff516b 0%,#8876ea 100%);
            display: none;
            position: sticky;
            position: fixed;
            z-index: 100;
        }

        .no-border{
            border-top: 0px solid #dee2e6 !important;
        }


    </style>
	<style>
.vip-qiupian {
	width: 100%;
	max-width: 900px;
	margin: 10px auto 30px auto;
	background-color: #fff;
}

.vip-qiupian h2 {
	text-align: center;
	padding: 20px 0 10px 0;
	border-bottom: solid 1px #666;
	font-weight: normal;
}

.qiupian-dec {
	line-height: 30px;
	background: #e9ecef;
	color: #333;
	text-align: center;
	padding: 10px 0;
}

.qiupian-list {
	padding: 30px;
}

.qiupian-list li {
	list-style-type: none;
	margin-bottom: 30px;
	border: solid 1px #faa8a8;
	border-radius: 4px;
}

.qiupian-list li .qp-header {
	margin-bottom: 10px;
	padding: 10px;
	background: #f0f0f0;
	border-radius: 4px 4px 0 0;
}

.qiupian-list li .qp-content {
	margin-bottom: 10px;
	padding: 0 20px;
	color: #727272;
	line-height: 30px;
}

.qiupian-list li .qp-content span {
	color: #f66;
	font-size: 16px;
	display: block;
}

.qiupian-list li .qp-content i {
	font-size: 18px;
	display: inline-block;
	padding: 0 5px;
	color: #adacac;
}

.qiupian-list li .qp-zhuantai {
	line-height: 30px;
	padding: 0 10px;
	background: #faa8a8;
	border-radius: 0 0 4px 4px;
	color: #fff;
}

.qp-tongji {
	text-align: center;
	line-height: 40px;
}

.qp-tongji span {
	margin: 0 10px;
}

.qp-tongji span em {
	font-style: normal;
	padding: 0 4px;
	color: #f66;
	font-weight: bold;
}

.qp-qipianvip a {
	display: block;
	padding: 10px 0;
	margin: 0 auto;
	width: 200px;
	color: #fff !important;
	text-align: center;
	font-size: 16px;
	border-color: transparent !important;
    background: #ff516b;
    background: -moz-linear-gradient(-45deg, #ff516b 0%, #826cfd 100%);
    background: -webkit-linear-gradient(-45deg, #ff516b 0%,#826cfd 100%);
    background: linear-gradient(135deg, #ff516b 0%,#826cfd 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff516b', endColorstr='#826cfd',GradientType=1 );
}

form.qp-form {
	margin: 30px;
	border: solid 2px #f66;
	border-radius: 4px;
	display: none;
}

form.qp-form h2 {
	font-size: 16px;
	padding: 5px 0;
	background: #f66;
	color: #fff;
	border: none;
}

form.qp-form p {
	margin: 20px 0;
	line-height: 30px;
}

form.qp-form label {
	width: 150px;
	float: left;
	text-align: right;
}

form.qp-form input {
	height: 30px;
	max-width: 600px;
	width: 90%;
	margin: 0 10px;
}

form.qp-form textarea {
	line-height: 30px;
	max-width: 600px;
	width: 90%;
	margin: 0 10px;
}

.vipqp_btn {
	width: 200px;
	height: 40px;
	border: 0;
	background: #fff;
	color: #fff;
	font-size: 18px;
	border-radius: 2px;
    border-color: #ff516b;
    color: #ff516b;
    border: 1px solid #ff516b;
}

.vipqp_btn:hover {
	border-color: transparent !important;
    background: #ff516b;
    background: -moz-linear-gradient(-45deg, #ff516b 0%, #826cfd 100%);
    background: -webkit-linear-gradient(-45deg, #ff516b 0%,#826cfd 100%);
    background: linear-gradient(135deg, #ff516b 0%,#826cfd 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff516b', endColorstr='#826cfd',GradientType=1 );
}

.qiupian-list .zp_type_1 {
	border-color: #eae6e6;
}

.qiupian-list .zp_type_1 .qp-zhuantai {
	background-color: #9d9d9d;
}

.qiupian-list .zp_type_3 {
	border-color: #ff516b;
}

.qiupian-list .zp_type_3 .qp-zhuantai {
	background-color: #ff516b;
}

.qiupian-list .zp_type_3 .qp-zhuantai a {
	background: #826cfd;
	color: #fff;
	padding: 0 5px;
	border-radius: 3px;
	margin-left: 20px;
	display: inline-block;
	line-height: 25px;
	margin-top: 4px;
}

a.admin-zp {
	background: #2196F3;
	color: #fff;
	padding: 2px 10px;
	border-radius: 4px;
	text-shadow: 1px 1px 1px #505050;
	float: right
}

.qp-type-bg {
	width: 100px;
	float: right;
	height: 25px;
	margin-top: 2px;
}

.qp-form-bg {
	position: fixed;
	top: 0;
	left: 0;
	z-index: 999;
	background: rgba(0,0,0,0.55);
	width: 100%;
	height: 100%;
	display: none;
}

.qp-form-bg form {
	width: 350px;
	margin: 0 auto;
	height: auto;
	background: #fff;
	margin-top: 5%;
	padding-bottom: 10px;
}

.qp-form-bg form p {
	margin: 20px 0;
	padding: 0 10px;
}

.qp-form-bg form p input {
	height: 30px;
	width: 250px;
}

.qp-form-bg form h2 {
	padding: 10px;
	font-size: 16px;
	background: #ff7171;
	border: none;
	color: #fff;
	text-shadow: 1px 1px 1px #3e3e3e;
}

.qp-login {
	width: 100%;
	padding: 30px;
	padding-bottom: 0;
	display: none;
}

.qp-login .login-form {
	width: 100%;
	border: solid 1px #f66;
	border-radius: 4px;
	background: #f0f0f0;
	padding: 20px;
	text-align: center;
}

.qp-login .login-form p {
	line-height: 30px;
	margin: 5px 0;
}

.qp-login .login-form p a {
	display: inline-block;
	padding: 0 20px;
	width: auto;
	font-size: 14px;
	background: #826cfd;
	border-radius: 2px;
	margin-bottom: 5px;
}

.qp-login .login-form p a.re-qp {
	background: #ff516b;
}

.imgbox {
	float: left;
	margin-right: 20px;
	position: relative;
	width: 80px;
	height: 80px;
	border: 5px solid #E4E2E2;
	overflow: hidden;
	margin-bottom: 10px;
}

.imgnum {
	left: 0px;
	top: 0;
	margin: 0px;
	padding: 0px;
	text-align: center;
	line-height: 80px;
}

.img1 {
	font-size: 5em;
	color: #E4E2E2;
	padding-top: 3px;
}

form.qp-form-url {
    border: solid 1px #f66;
    border-radius: 4px;
    background: #f0f0f0;
    padding: 20px;
}

form.qp-form .imgnum input {
	position: absolute;
	width: 80px;
	height: 80px;
	opacity: 0;
	margin: -5px 0 0 -12px;
}

.imgnum img {
	width: 80px;
	height: 80px;
}

.close {
	color: red;
	position: absolute;
	left: 170px;
	top: 0px;
	display: none;
}

.imgbox p code {
	font-family: consolas,'Microsoft Yahei',arial !important;
	padding: 2px 4px;
	color: #c7254e;
	background-color: #f9f2f4;
	border-radius: 4px;
}

.qp-images-list {
	padding: 0 20px 20px 20px;
}

.qp-images-list a {
	display: inline-block;
	margin: 0 10px;
}

.qp-images-list a img {
	opacity: .8
}

.qp-images-list a:hover img {
	opacity: 1;
}

@media (max-width: 575.98px) {
.qiupian-list .zp_type_3 .qp-zhuantai a {
    margin-left: 0;
}
.vipqp_btn {
    width: 60%;
}
.remaining-w {
	margin-top: 1rem;
	float: initial !important;
}
.mac_verify_img {
    margin-top: 1rem;
}
}

</style>
 </head> 
 <body id="page-top" class=""> 
  <nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
       
   <button type="button" class="d-block d-sm-none btn btn-primary border-none btn-sm order-1 order-sm-0" id="sidebarToggle"><i class="fas fa-bars"></i>导航</button> 
   <button class="d-none d-sm-block btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle"> <i class="fas fa-bars"></i> </button> 
   <a class="navbar-brand" href="/" style="margin-right: 1.3rem;"><img class="img-fluid" style="max-width: 65%;" alt="<?php echo $maccms['site_name']; ?>" src="/<?php echo $maccms['site_logo']; ?>" /></a> 
   <button type="button" class="d-none d-sm-block btn btn-primary border-none btn-sm order-1 order-sm-0" id="sidebarTogglePc"><i class="fas fa-bars"></i> 在线视频分类</button> 
   <button type="button" style="margin-left: 20px" class="d-none d-sm-block btn btn-primary border-none btn-sm order-1 order-sm-0" id="sidebarTogglePcDown"><i class="fas fa-bars"></i> 套图专区分类</button> 
   <button type="button" style="margin-left: 20px" class="d-none d-sm-block btn btn-primary border-none btn-sm order-1 order-sm-0" id="sidebarTogglePcDown2"><i class="fas fa-bars"></i> 小说专区分类</button>
   <!-- Navbar Search --> 
   <form id="search" action="<?php echo mac_url('vod/search'); ?>" method="get" onSubmit="return qrsearch();" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search"> 
    <div class="input-group"> 
     <input type="text" id="wd" name="wd" class="form-control" placeholder="输入关键字进行搜索…" /> 
     <div class="input-group-append"> 
      <button class="btn btn-light" type="submit"> <i class="fas fa-search"></i> </button> 
     </div> 
    </div> 
   </form> 
   <!-- Navbar --> 
   <?php if($GLOBALS['user']['user_id']): ?>
   <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar"> 
    <li class="nav-item dropdown no-arrow osahan-right-navbar-user"> <a class="nav-link dropdown-toggle user-dropdown-link" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img alt="Avatar" src="<?php echo mac_get_user_portrait($user['user_id']); ?>" /><span>个人中心</span></a> 
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown"> 
     <a class="dropdown-item" href="#"><i class="fas fa-fw fa-user"></i>   <?php echo $user['user_name']; ?></a> 
     <div class="dropdown-divider"></div> 
     <a class="dropdown-item" href="<?php echo mac_url('user/index'); ?>"><i class="fas fa-fw fa-user-circle"></i>   进入会员中心</a> 
     <a class="dropdown-item" href="<?php echo mac_url('user/upgrade'); ?>"><i class="fas fa-fw fa-money-bill"></i>   升级VIP</a> 
     <div class="dropdown-divider"></div> 
     <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i>   退出</a> 
    </div> </li> 
   </ul>
   <?php else: ?>
   <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar"> 
    <li class="nav-item dropdown no-arrow osahan-right-navbar-user"> <a class="nav-link" href="<?php echo mac_url('user/login'); ?>" style="font-size: 14px"> <i class="fas fa-user-circle fa-fw"></i> 登录 </a> </li> 
    <li class="nav-item dropdown no-arrow osahan-right-navbar-user"> <a class="nav-link" href="<?php echo mac_url('user/reg'); ?>" style="font-size: 14px"> <i class="fas fa-registered fa-fw"></i> 注册 </a> </li> 
   </ul>
   <?php endif; ?>
  </nav> 
  <div class="ui-slide-block" style="font-size: 12px;display: none;" id="block-slide"> 
   <div class="container"> 
    <div class="table table-sm" style="margin-bottom: 0rem;"> 
     <div> 
      <div style="line-height:20px;padding: .3rem;"> 
        <form id="search" method="get" action="<?php echo mac_url('vod/search'); ?>" onSubmit="return qrsearch();" class="form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 "> 
         <div class="input-group"> 
          <input class="form-control border-form-control search-input" style="background-color: white;border: none" id="wd" name="wd" placeholder="输入关键字进行搜索" type="text" /> 
          <button type="submit" class="btn btn-danger border-none"> 搜索 </button> 
         </div> 
        </form> 
	  </div> 
      <span style="color: #ffade8;font-size: 16px" target="_blank"><i class="fas fa-fw fa-video"></i>视频区</span> 
      <ul> 
       <li style="line-height:20px"><a style="color: white;" href="/" target="_blank"><b>首页</b></a></li> 
       <li style="line-height:20px"><a style="color: #f5ff06;" href="<?php echo mac_url('user/upgrade'); ?>" target="_blank"><b>升级VIP</b></a></li> 
	   <li style="line-height:20px"><a style="color: #f5ff06;" href="/index.php/vod/search/by/time_add.html" target="_blank"><b>最近更新</b></a></li>
	   <li style="line-height:20px"><a style="color: #f5ff06;" href="/index.php/vod/search/by/hits.html" target="_blank"><b>最多观看</b></a></li>

	   <?php $__TAG__ = '{"ids":"parent","order":"asc","by":"sort","flag":"vod","id":"vo","key":"key"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
       <li style="line-height:20px"><a style="color: white;" href="<?php echo mac_url_type($vo); ?>" target="_blank"><?php echo $vo['type_name']; ?></a></li> 
	   <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul> 
	  <span style="color: #ffccfa;font-size: 16px;" target="_blank"><i class="fas fa-fw fa-images"></i>套图区</span> 
      <ul> 
	   <?php $__TAG__ = '{"ids":"child","order":"asc","by":"sort","flag":"art","id":"vo","key":"key"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($vo['type_pid'] == 20): ?>
       <li style="line-height:20px"><a style="color: white;" href="<?php echo mac_url_type($vo); ?>" target="_blank"><?php echo $vo['type_name']; ?></a></li>
	   <?php endif; endforeach; endif; else: echo "" ;endif; ?>
      </ul> 
	  <span style="color: #ffccfa;font-size: 16px;" target="_blank"><i class="fas fa-fw fa-book"></i>小说区</span> 
      <ul> 
	   <?php $__TAG__ = '{"ids":"child","order":"asc","by":"sort","flag":"art","id":"vo","key":"key"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($vo['type_pid'] == 21): ?>
       <li style="line-height:20px"><a style="color: white;" href="<?php echo mac_url_type($vo); ?>" target="_blank"><?php echo $vo['type_name']; ?></a></li>
	   <?php endif; endforeach; endif; else: echo "" ;endif; ?>
      </ul> 
     </div> 
    </div> 
   </div> 
  </div>
  <div class="ui-slide-block-pc" id="block-slide-pc"> 
   <div class="container"> 
    <div class="table table-sm" style="width: 480px;margin-bottom: -0.1rem;"> 
	 <div class="div-pc">
      <ul> 
       <li style="line-height:20px"><a style="color: white;" href="/" target="_blank"><b>首页</b></a></li> 
       <li style="line-height:20px"><a style="color: #f5ff06;" href="<?php echo mac_url('user/upgrade'); ?>" target="_blank"><b>升级VIP</b></a></li> 
	   <li style="line-height:20px"><a style="color: #f5ff06;" href="/index.php/vod/search/by/time_add.html" target="_blank"><b>最近更新</b></a></li>
	   <li style="line-height:20px"><a style="color: #f5ff06;" href="/index.php/vod/search/by/hits.html" target="_blank"><b>最多观看</b></a></li>
	   <?php $__TAG__ = '{"ids":"parent","order":"asc","by":"sort","flag":"vod","id":"vo","key":"key"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
       <li style="line-height:20px"><a style="color: white;" href="<?php echo mac_url_type($vo); ?>" target="_blank"><?php echo $vo['type_name']; ?></a></li> 
	   <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul> 
	 </div>
    </div> 
   </div> 
  </div>
  <div class="ui-slide-block-pc-down" id="block-slide-pc-down"> 
   <div class="container"> 
    <div class="table table-sm" style="width: 480px;margin-bottom: -0.1rem;"> 
	 <div class="div-pc">
      <ul> 
       <li style="line-height:20px"><a style="color: white;" href="/" target="_blank"><b>首页</b></a></li> 
       <li style="line-height:20px"><a style="color: #f5ff06;" href="<?php echo mac_url('user/upgrade'); ?>" target="_blank"><b>升级VIP</b></a></li> 
	   <?php $__TAG__ = '{"ids":"child","order":"asc","by":"sort","flag":"art","id":"vo","key":"key"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($vo['type_pid'] == 20): ?>
       <li style="line-height:20px"><a style="color: white;" href="<?php echo mac_url_type($vo); ?>" target="_blank"><?php echo $vo['type_name']; ?></a></li> 
	   <?php endif; endforeach; endif; else: echo "" ;endif; ?>
      </ul> 
	 </div>
    </div> 
   </div> 
  </div> 
  <div class="ui-slide-block-pc-down2" id="block-slide-pc-down2"> 
   <div class="container"> 
    <div class="table table-sm" style="width: 480px;margin-bottom: -0.1rem;"> 
	 <div class="div-pc">
      <ul> 
       <li style="line-height:20px"><a style="color: white;" href="/" target="_blank"><b>首页</b></a></li> 
       <li style="line-height:20px"><a style="color: #f5ff06;" href="<?php echo mac_url('user/upgrade'); ?>" target="_blank"><b>升级VIP</b></a></li> 
	   <?php $__TAG__ = '{"ids":"child","order":"asc","by":"sort","flag":"art","id":"vo","key":"key"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($vo['type_pid'] == 21): ?>
       <li style="line-height:20px"><a style="color: white;" href="<?php echo mac_url_type($vo); ?>" target="_blank"><?php echo $vo['type_name']; ?></a></li>
	   <?php endif; endforeach; endif; else: echo "" ;endif; ?>
      </ul> 
	 </div>
    </div> 
   </div> 
  </div> 
  <div id="wrapper"> 
   <!-- Sidebar --> 
   <ul class="sidebar navbar-nav "> 
    <li class="nav-item active"> <a class="nav-link" href="/"> <i class="fas fa-fw fa-home"></i> <span>首页</span> </a> </li> 
    <li class="nav-item"> <a class="nav-link d-none d-sm-block" id="sidebarTogglePcLeft"> <i class="fas fa-fw fa-bars"></i> <span>视频分类</span> </a> </li>
	<?php if($GLOBALS['user']['user_id']): else: ?>
    <li class="nav-item"> <a class="nav-link" href="<?php echo mac_url('user/login'); ?>"> <i class="fas fa-fw fa-user-circle"></i> <span>登录</span> </a> </li> 
	<?php endif; ?>
    <li class="nav-item"> <a class="nav-link" href="<?php echo mac_url('user/upgrade'); ?>" > <i class="fas fa-fw fa-cart-plus"></i> <span>升级VIP</span> </a> </li> 
    <li class="nav-item"> <a class="nav-link" href="/index.php/vod/search/by/time_add.html"> <i class="fas fa-fw fa-user-alt"></i> <span>最近更新</span> </a> </li> 
    <li class="nav-item"> <a class="nav-link" href="/index.php/vod/search/by/hits.html"> <i class="fas fa-fw fa-fire"></i> <span>热门视频</span> </a> </li> 
    <li class="nav-item"> <a class="nav-link d-none d-sm-block" id="sidebarTogglePcLeftDown"> <i class="fas fa-fw fa-bars"></i> <span>套图专区</span> </a> </li> 
    <li class="nav-item"> <a class="nav-link d-none d-sm-block" id="sidebarTogglePcLeftDown2"> <i class="fas fa-fw fa-bars"></i> <span>小说专区</span> </a> </li>
	<?php if($GLOBALS['user']['user_id']): ?>
    <li class="nav-item channel-sidebar-list"> </li> 
    <li class="nav-item"> <a class="nav-link" href="<?php echo mac_url('user/plays'); ?>"> <i class="fas fa-fw fa-history"></i> <span>最近观看</span> </a> </li> 
    <li class="nav-item"> <a class="nav-link" href="<?php echo mac_url('user/favs'); ?>"> <i class="fas fa-fw fa-heart"></i> <span>我的收藏</span> </a> </li> 
	<?php else: endif; ?>
    <li class="nav-item"> <a class="nav-link" href="<?php echo mac_url('gbook/index'); ?>"> <i class="fas fa-fw fa-clipboard-list"></i> <span>留言求片</span> </a> </li>
   </ul>
   <div id="content-wrapper"> 
    <div class="container-fluid"> 
     <div class="video-block section-padding col-md-12"> 
      <div class="row"> 
       <div class="vip-qiupian cl"> 
   <h2>会员影片需求</h2> 
   <p class="qiupian-dec">还在为找片烦恼吗？注册会员即可发布需求，海量片源等你发掘！</p> 
   <div class="qp-qipianvip"> 
    <a id="qp-qipianvip">我 要 求 片 <i class="fa fa-angle-down"></i></a> 
	<?php if($GLOBALS['user']['user_id']): ?>
	<div class="qp-login qp-form-bd"> 
    <form class="qp-form-url gbook_form" id="qp-form-url" method="post">  
     <p> <label style="font-size: 14px;font-weight: initial;">请输入片名或视频描述：</label> <textarea class="gbook_content qp-posturl" name="gbook_content" style="width:100%;border-radius: 3px;height: 100px;"></textarea> </p> 
	 <div class="msg_code">
		<?php if($gbook['verify'] == 1): ?>
		验证码：<input type="text" name="verify" class="mac_verify" style="width: 90px;margin-right: 10px;">
		<?php endif; ?>
		<div class="remaining-w" style="float:right;">还可输入<span class="gbook_remaining remaining " >200</span></div>
	 </div>
     <p style="text-align: center;margin-top: 1rem;"> <input type="button" class="vipqp_btn gbook_submit submit_btn" value="提交"> </p> 
    </form> 
   </div>
   <?php else: ?>
    <div class="qp-login qp-form-bd"> 
     <div class="login-form"> 
      <p>求片功能仅限会员用户使用，请先登录帐号！</p> 
      <p><a href="<?php echo mac_url('user/login'); ?>">立即登录</a> <a href="<?php echo mac_url('user/reg'); ?>" class="re-qp">注册帐号</a></p> 
     </div> 
    </div> 
	<?php endif; ?>
   </div> 
    
   <ul class="qiupian-list">
    <?php $__TAG__ = '{"num":"10","paging":"yes","order":"desc","by":"id","id":"vo","key":"key"}';$__LIST__ = model("Gbook")->listCacheData($__TAG__);$__PAGING__ = mac_page_param($__LIST__['total'],$__LIST__['limit'],$__LIST__['page'],$__LIST__['pageurl'],$__LIST__['half']); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($vo['gbook_reply_time'] > 0): ?>
    <li class="zp_type_3">
     <div class="qp-header">
      <span class="vip-qp-2"><?php echo $vo['gbook_name']; ?></span> [<?php echo mac_long2ip($vo['gbook_ip']); ?>] 求于 <?php echo date('Y-m-d H:i:s',$vo['gbook_time']); ?>
     </div>
     <div class="qp-content">
      <i class="fa fa-quote-left"></i><?php echo $vo['gbook_content']; ?>
      <i class="fa fa-quote-right"></i>
     </div>
     <div class="qp-images-list"></div>
	 <?php if($vo['gbook_reply'] == 找片失败): ?>
	 <div class="qp-zhuantai" style="background-color: #faa8a8;">
      状态：找片失败
     </div>
	 <?php else: ?>
     <div class="qp-zhuantai">状态：找片成功 <a href="<?php echo $vo['gbook_reply']; ?>" target="_blank">点击查看该影片 <i class="fa fa-caret-right"></i></a></div><?php endif; ?></li>
	 <?php else: ?>
	 <li class="zp_type_1">
     <div class="qp-header">
      <span class="vip-qp-2"><?php echo $vo['gbook_name']; ?></span> [<?php echo mac_long2ip($vo['gbook_ip']); ?>] 求于 <?php echo date('Y-m-d H:i:s',$vo['gbook_time']); ?>
     </div>
     <div class="qp-content">
      <i class="fa fa-quote-left"></i><?php echo $vo['gbook_content']; ?>
      <i class="fa fa-quote-right"></i>
     </div>
     <div class="qp-images-list"></div>
	 <div class="qp-zhuantai">
      状态：正在找片中. . . 
     </div></li>
	 <?php endif; endforeach; endif; else: echo "" ;endif; ?>
   </ul> 
  </div>
      </div> 
      <nav aria-label="Page navigation example"> 
       <ul class="pagination justify-content-center pagination-sm mb-0"> 
        <?php if($__PAGING__['record_total'] > 0): ?>
        <li class="page-item"><a class="page-link" href="<?php echo mac_url_page($__PAGING__['page_url'],$__PAGING__['page_prev']); ?>" title="上一页">上一页</a></li>
        <?php if(is_array($__PAGING__['page_num']) || $__PAGING__['page_num'] instanceof \think\Collection || $__PAGING__['page_num'] instanceof \think\Paginator): if( count($__PAGING__['page_num'])==0 ) : echo "" ;else: foreach($__PAGING__['page_num'] as $key=>$num): if($__PAGING__['page_current'] == $num): ?>
        <li class="page-item active"><a class="page-link" href="javascript:;" title="第<?php echo $num; ?>页"><?php echo $num; ?></a></li>
        <?php else: ?>
        <li class="page-item"><a class="page-link" href="<?php echo mac_url_page($__PAGING__['page_url'],$num); ?>" title="第<?php echo $num; ?>页" ><?php echo $num; ?></a></li>
        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        <li class="page-item"><a class="page-link" href="<?php echo mac_url_page($__PAGING__['page_url'],$__PAGING__['page_next']); ?>" title="下一页">下一页</a></li>
<?php else: ?>
<div class="wrap">
    <h1>没有找到匹配数据</h1>
</div>
<?php endif; ?> 
       </ul> 
      </nav> 
     </div> 
    </div> 
    <!-- /.container-fluid --> 
    <!-- Sticky Footer --> 
	<footer class="sticky-footer"> 
 <div class="container"> 
  <div class="row no-gutters"> 
   <div class="col-lg-6 col-sm-6"> 
	<p class="mt-1 mb-0">© Copyright 2018 <strong class="text-dark"><?php echo $maccms['site_name']; ?></strong>. All Rights Reserved<br /> <small class="mt-0 mb-0">Made with <i class="fas fa-heart text-danger"></i> by <a class="text-primary" target="_blank" href="http://<?php echo $maccms['site_url']; ?>"><?php echo $maccms['site_url']; ?></a> <?php echo $maccms['site_icp']; ?> <?php echo $maccms['site_tj']; ?></small> </p> 
   </div> 
   <div class="col-lg-6 col-sm-6 text-right"> 
	<div class="app"> 
	 <a><img alt="" src="<?php echo $maccms['path_tpl']; ?>html/style/images/google.png" /></a> 
	 <a><img alt="" src="<?php echo $maccms['path_tpl']; ?>html/style/images/apple.png" /></a> 
	</div> 
   </div> 
  </div> 
 </div> 
</footer> 
<div class="m-footer" style="display:none;">
    <a class="navFooter" target="_self" href="/"><i class="fas fa-home"></i>首页</a>
    <button type="button" class="navFooter" id="sidebarToggle"><i class="fas fa-list"></i>分类</button>
    <a class="navFooter" target="_self" href="<?php echo mac_url('user/ajax_info'); ?>"><i class="fas fa-layer-group"></i>推广</a>
    <a class="navFooter" target="_self" href="<?php echo mac_url('gbook/index'); ?>"><i class="fas fa-clipboard-list"></i>求片</a>
    <a class="navFooter" target="_self" href="<?php echo mac_url('user/index'); ?>"><i class="fas fa-user"></i>我的</a>
</div>
   </div> 
   <!-- /.content-wrapper --> 
  </div> 
  <!-- /#wrapper --> 
  <!-- Scroll to Top Button--> 
  <a class="scroll-to-top rounded" href="#page-top"> <i class="fas fa-angle-up"></i> </a> 
  <!-- Logout Modal--> 
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
   <div class="modal-dialog modal-sm modal-dialog-centered" role="document"> 
    <div class="modal-content"> 
     <div class="modal-header"> 
      <h5 class="modal-title" id="exampleModalLabel">确定要退出?</h5> 
      <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> 
     </div> 
     <div class="modal-body">
      真的要退出登录吗
     </div> 
     <div class="modal-footer"> 
      <button class="btn btn-secondary" type="button" data-dismiss="modal">取消</button> 
      <a class="btn btn-primary" href="<?php echo mac_url('user/logout'); ?>" > 退出 </a> 
     </div> 
    </div> 
   </div> 
  </div>  
  <!-- Bootstrap core JavaScript--> 
  <script src="<?php echo $maccms['path_tpl']; ?>html/style/js/bootstrap.bundle.min.js"></script> 
  <!-- Core plugin JavaScript--> 
  <script src="<?php echo $maccms['path_tpl']; ?>html/style/js/jquery.easing.min.js"></script> 
  <!-- Owl Carousel --> 
  <script src="<?php echo $maccms['path_tpl']; ?>html/style/js/owl.carousel.js"></script> 
  <!-- Custom scripts for all pages--> 
  <script src="<?php echo $maccms['path_tpl']; ?>html/style/js/custom.js"></script> 
  <script>

    $(document).on('click','#sidebarTogglePc',function (e) {
        e.preventDefault();
        $("#block-slide-pc").slideToggle("fast")
        if($("#block-slide-pc-down").is(":visible")){
            $("#block-slide-pc-down").slideToggle("fast")
        }
		if($("#block-slide-pc-down2").is(":visible")){
            $("#block-slide-pc-down2").slideToggle("fast")
        }


        // $("#block-slide-pc-down").slideToggle("fast")
    });
    $(document).on('click','#sidebarTogglePcDown',function (e) {
        e.preventDefault();
        $("#block-slide-pc-down").slideToggle("fast")
		if($("#block-slide-pc").is(":visible")){
            $("#block-slide-pc").slideToggle("fast")
        }
        if($("#block-slide-pc-down2").is(":visible")){
            $("#block-slide-pc-down2").slideToggle("fast")
        }


        // $("#block-slide-pc").slideToggle("fast")
    });
	$(document).on('click','#sidebarTogglePcDown2',function (e) {
        e.preventDefault();
        $("#block-slide-pc-down2").slideToggle("fast")
		if($("#block-slide-pc").is(":visible")){
            $("#block-slide-pc").slideToggle("fast")
        }
        if($("#block-slide-pc-down").is(":visible")){
            $("#block-slide-pc-down").slideToggle("fast")
        }

    });
    $(document).on('click','#sidebarTogglePcLeft',function (e) {
        e.preventDefault();
        $("#block-slide-pc").slideToggle("fast")
        if($("#block-slide-pc-down").is(":visible")){
            $("#block-slide-pc-down").slideToggle("fast")
        }
        if($("#block-slide-pc-down2").is(":visible")){
            $("#block-slide-pc-down2").slideToggle("fast")
        }

    });
    $(document).on('click','#sidebarTogglePcLeftDown',function (e) {
        e.preventDefault();
        $("#block-slide-pc-down").slideToggle("fast")
        if($("#block-slide-pc").is(":visible")){
            $("#block-slide-pc").slideToggle("fast")
        }
        if($("#block-slide-pc-down2").is(":visible")){
            $("#block-slide-pc-down2").slideToggle("fast")
        }

    });
    $(document).on('click','#sidebarTogglePcLeftDown2',function (e) {
        e.preventDefault();
        $("#block-slide-pc-down2").slideToggle("fast")
        if($("#block-slide-pc").is(":visible")){
            $("#block-slide-pc").slideToggle("fast")
        }
        if($("#block-slide-pc-down").is(":visible")){
            $("#block-slide-pc-down").slideToggle("fast")
        }

    });


    $(document).ready(function() {
        $("img.lazy").lazyload({
            effect : "fadeIn",
            threshold : 500
        });
        $("img.lazy1").lazyload({
            effect : "fadeIn",
            threshold : 500
        });

    });
	
	$(function(){
		$(".filepath").on("change",function() {
		   var srcs = getObjectURL(style/images/img/this.files5B05D); 
		   $(this).nextAll(".img1").hide(); 
		   $(this).nextAll(".img2").show();
		   $(this).nextAll(".close").show(); 
		   $(this).nextAll(".img2").attr("src",srcs);
		   $(".close").on("click",function() {
				$(this).hide(); 
				$(this).nextAll(".img2").hide();
				$(this).nextAll(".img1").show();
		   });
		 })

		$('#qp-qipianvip').click(function() {
			var _form = $('.qp-form-bd');
			console.log(_form.css('display'));
			if(_form.css('display') == 'block'){
				$(this).html('我 要 求 片 <i class="fa fa-angle-down"></i>');
			}else{
				$(this).html('收 起 <i class="fa fa-angle-up"></i>');
			}
			_form.slideToggle();
			return false;
		});	

		$('.qp-type-bg').change(function() {
			var _ps_id = $(this).data('id');
			$.ajax({
					type: 'POST',
					dataType: 'html',
					url: chenxing.ajax_url,
					async: false,
					data: {
						'action': 'vip-qiupian-admin',
						'id': _ps_id,
						'val':$(this).val(),
					},
					success:function(b) {
						console.log(b);
						if(b == 3){					        		
							$('.qp-form-bg').slideToggle();	
							$('input.qp-postid').val(_ps_id);       		
						}else{
							alert('状态变更成功！');	
							window.location.reload();
						}
					}
				});
		});

	});
</script> 
 </body>
</html>