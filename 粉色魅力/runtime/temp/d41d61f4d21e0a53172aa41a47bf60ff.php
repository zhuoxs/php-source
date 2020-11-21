<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:34:"template/RX03/html/user/index.html";i:1551423960;s:64:"/www/wwwroot/ys01.testx.vip/template/RX03/html/user/include.html";i:1553153546;s:61:"/www/wwwroot/ys01.testx.vip/template/RX03/html/user/head.html";i:1553071466;s:61:"/www/wwwroot/ys01.testx.vip/template/RX03/html/user/menu.html";i:1551366038;s:61:"/www/wwwroot/ys01.testx.vip/template/RX03/html/user/foot.html";i:1554795970;}*/ ?>
<!DOCTYPE html>
<html lang="en">
 <head> 
  <meta charset="UTF-8" /> 
  <meta http-equiv="Cache-Control" content="max-age=60" /> 
  <meta http-equiv="Cache-Control" content="no-siteapp" /> 
  <meta http-equiv="Cache-Control" content="no-transform" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
  <meta name="renderer" content="webkit" /> 
  <meta name="viewport" content="initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" /> 
  <meta name="apple-mobile-web-app-title" content="<?php echo $maccms['site_name']; ?>" /> 
  <title>个人中心 - <?php echo $maccms['site_name']; ?></title> 
  <meta name="keywords" content="个人中心,<?php echo $maccms['site_keywords']; ?>" /> 
  <meta name="description" content="<?php echo $maccms['site_description']; ?>" />
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
<script>var maccms={"path":"","mid":"<?php echo $maccms['mid']; ?>","url":"<?php echo $maccms['site_url']; ?>","wapurl":"<?php echo $maccms['site_wapurl']; ?>","mob_status":"<?php echo $maccms['mob_status']; ?>"};</script>
<script src="<?php echo $maccms['path']; ?>static/js/home.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/formValidator-4.0.1.js" type="text/javascript"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.imageupload.js"></script>
<link href="<?php echo $maccms['path_tpl']; ?>html/style/css/orang.css" rel="stylesheet" type="text/css" /> 
<style>.table.table-sm .div-pc {display: table-row-group;vertical-align: middle;border-color: inherit;}.table.table-sm ul {padding-left: 0;display: table-row;vertical-align: inherit;border-color: inherit;}.ui-slide-block li {float: left;border-bottom: 1px solid #dee2e6;list-style-type: none;width: 25%;padding: .3rem;overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}.ui-slide-block-pc li,.ui-slide-block-pc-down li,.ui-slide-block-pc-down2 li{width: 120px;font-size: 14px;line-height: 25px !important;padding: .3rem;vertical-align: top;float: left;border-bottom: 1px solid #dee2e6;list-style-type: none;overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}@media (max-width: 768px){body.sidebar-toggled #block-slide{display: block !important}.navbar-brand{width:8rem;margin-right: 0rem!important;}.table.table-sm ul{display:block;overflow:hidden;}}</style>  
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
 </head>
 <body id="page-top" class="fed-min-width">
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
  <div class="fed-main-info fed-min-width"> 
   <div class="fed-part-case"> 
    <div class="fed-user-head fed-margin-top fed-back-whits"> 
     <div class="fed-list-pics fed-lazy fed-part-5by2 fed-part-rows" style="background:url(<?php echo $maccms['path_tpl']; ?>html/style/images/user.jpg);"> 
      <div class="fed-part-core fed-text-center"> 
       <div class="fed-user-image" data-role="<?php echo mac_url('user/portrait'); ?>"> 
        <img class="face fed-user-avat fed-part-roun" src="<?php echo mac_url_img(mac_default($obj['user_portrait'],'static/images/touxiang.png')); ?>?v=<?php echo time(); ?>" /> 
       </div> 
       <span class="fed-visible fed-text-white fed-padding"><?php echo $obj['user_name']; ?></span> 
      </div> 
     </div> 
     <div class="fed-padding fed-part-rows fed-back-whits fed-hide-md"> 
      <ul class="fed-user-brief fed-part-rows fed-back-whits"> 
       <li class="fed-padding-x fed-text-center fed-col-xs4"> <span class="fed-visible fed-text-gules"><?php echo $obj['user_points']; ?></span> <span class="fed-visible">我的积分</span> </li> 
       <li class="fed-padding-x fed-text-center fed-line-left fed-col-xs4"> <span class="fed-visible fed-text-gules"><?php echo $obj['group']['group_name']; ?></span> <span class="fed-visible">我的等级</span> </li> 
       <li class="fed-padding-x fed-text-center fed-line-left fed-col-xs4"> <span class="fed-visible fed-text-gules"><?php echo $obj['user_login_num']; ?></span> <span class="fed-visible">登录次数</span> </li> 
      </ul> 
     </div> 
    </div> 
    <div class="fed-part-rows"> 
     <div class="fed-main-left fed-col-xs12 fed-col-md4 fed-col-lg3 fed-hide-sm fed-show-md-block">
       <div class="fed-part-layout fed-back-whits fed-margin-right fed-hide-xs fed-hide-sm fed-show-md-block"> 
   <ul class="fed-user-brief fed-part-rows fed-back-whits"> 
    <li class="fed-padding-x fed-text-center fed-col-xs4"> <span class="fed-visible fed-text-gules"><?php echo $obj['user_points']; ?></span> <span class="fed-visible">我的积分</span> </li> 
    <li class="fed-padding-x fed-text-center fed-line-left fed-col-xs4"> <span class="fed-visible fed-text-gules"><?php echo $obj['group']['group_name']; ?></span> <span class="fed-visible">我的等级</span> </li> 
    <li class="fed-padding-x fed-text-center fed-line-left fed-col-xs4"> <span class="fed-visible fed-text-gules"><?php echo $obj['user_login_num']; ?></span> <span class="fed-visible">登录次数</span> </li> 
   </ul> 
  </div> 
  <div class="fed-part-layout fed-back-whits fed-margin-right"> 
   <ul class="fed-user-list fed-part-rows fed-back-whits"> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom fed-hide-md"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/ajax_info'); ?>"> <span class="fed-col-xs4 fed-part-eone">我的资料</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom fed-hide fed-show-md-block"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/index'); ?>"> <span class="fed-col-xs4 fed-part-eone">我的资料</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/info'); ?>"> <span class="fed-col-xs4 fed-part-eone">修改资料</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/favs'); ?>"> <span class="fed-col-xs4 fed-part-eone">我的收藏</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/plays'); ?>"> <span class="fed-col-xs4 fed-part-eone">播放记录</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li>  
    <li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/popedom'); ?>"> <span class="fed-col-xs4 fed-part-eone">我的权限</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/buy'); ?>"> <span class="fed-col-xs4 fed-part-eone">充值中心</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/orders'); ?>"> <span class="fed-col-xs4 fed-part-eone">充值记录</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/reward'); ?>"> <span class="fed-col-xs4 fed-part-eone">三级分销</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
	<li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/plog'); ?>"> <span class="fed-col-xs4 fed-part-eone">积分记录</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li>
	<li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/cash'); ?>"> <span class="fed-col-xs4 fed-part-eone">提现记录</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <li class="fed-padding-x fed-part-rows fed-line-bottom"> <a class="fed-tabs-title fed-visible fed-font-xvi fed-part-rows" href="<?php echo mac_url('user/upgrade'); ?>"> <span class="fed-col-xs4 fed-part-eone">升级会员</span> <span class="fed-col-xs8 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> </a> </li> 
    <div class="fed-part-rows fed-padding-top"></div> 
    <li class="fed-padding-x fed-part-rows"> <a class="fed-rims-info fed-btns-info fed-btns-green fed-col-xs12" href="<?php echo mac_url('user/logout'); ?>">退出</a> </li> 
   </ul> 
  </div> 
     </div> 
     <div class="fed-main-right fed-col-xs12 fed-col-md8 fed-col-lg9 fed-hide-xs fed-hide-sm fed-show-md-block"> 
      <div class="fed-part-layout fed-back-whits"> 
       <div class="fed-user-title fed-list-head fed-part-rows fed-padding fed-line-bottom"> 
        <h2 class="fed-font-xvi fed-padding">我的资料</h2> 
        <ul class="fed-part-tips fed-padding"> 
         <li class="fed-padding"> <a class="fed-more" href="<?php echo mac_url('user/index'); ?>">刷新</a> </li> 
        </ul> 
       </div> 
       <ul class="fed-user-list fed-part-rows fed-back-whits"> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">用户名</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo $obj['user_name']; ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">所属会员组</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo $obj['group']['group_name']; ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">到期时间</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo mac_default(mac_day($obj['user_end_time']),'无限期'); ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">账户积分</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo $obj['user_points']; ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">QQ号码</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo mac_default($obj['user_qq'],'未填写'); ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">邮件地址</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo mac_default($obj['user_email'],'未填写'); ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">联系手机</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo mac_default($obj['user_phone'],'未填写'); ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">注册时间</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo mac_default(mac_day($obj['user_reg_time']),'未知'); ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">登录时间</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo mac_day($obj['user_login_time']); ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">登录IP</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo long2ip($obj['user_login_ip']); ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">登录次数</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><?php echo $obj['user_login_num']; ?></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
		<?php if($GLOBALS['config']['user']['invite_reg_points'] > 0): ?>
        <li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">推广注册链接</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><input id="url" class="fed-visible" value="<?php echo $maccms['http_type']; ?><?php echo $maccms['site_url']; ?><?php echo mac_url('user/reg'); ?>?uid=<?php echo $obj['user_id']; ?>" /></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li> 
		<?php endif; if($GLOBALS['config']['user']['invite_visit_points'] > 0): ?>
		<li class="fed-padding-x fed-part-rows fed-line-bottom"> 
         <div class="fed-user-input fed-visible fed-font-xvi fed-part-rows"> 
          <span class="fed-col-xs4 fed-col-sm3 fed-part-eone">推广访问链接</span> 
          <span class="fed-col-xs7 fed-col-sm8 fed-part-eone"><input id="url2" class="fed-visible" value="<?php echo $maccms['http_type']; ?><?php echo $maccms['site_url']; ?><?php echo mac_url('user/visit'); ?>?uid=<?php echo $obj['user_id']; ?>" /></span> 
          <span class="fed-col-xs1 fed-col-sm1 fed-part-eone fed-text-right"><i class="fed-icon-font fed-icon-you"></i></span> 
         </div> </li>
		<?php endif; ?>
       </ul> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div> 
  <footer class="sticky-footer" style="margin-left: initial; margin-top: 30px;"> 
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
  <a class="scroll-to-top rounded" href="#page-top"> <i class="fas fa-angle-up"></i> </a> 
  <!-- Logout Modal--> 
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
   <div class="modal-dialog modal-sm modal-dialog-centered" role="document"> 
    <div class="modal-content"> 
     <div class="modal-header"> 
      <h5 class="modal-title" id="exampleModalLabel">确定要退出?</h5> 
      <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> 
     </div> 
     <div class="modal-body">
      真的要退出登录吗
     </div> 
     <div class="modal-footer"> 
      <button class="btn btn-secondary" type="button" data-dismiss="modal">取消</button> 
      <a class="btn btn-primary" href="<?php echo url('user/logout'); ?>" > 退出 </a> 
     </div> 
    </div> 
   </div> 
  </div>
  <script>
	$(".face").imageUpload({
		formAction: "<?php echo url('user/portrait'); ?>",
		inputFileName:'file',
		browseButtonValue: '',
		browseButtonClass:'btn btn-default btn-xs fed-user-alter fed-part-roun fed-icon-font fed-icon-xiugai',
		automaticUpload: true,
		hideDeleteButton: true,
		hover:true
	})
	$(".jQuery-image-upload-controls").mouseenter(function(){
    $(".jQuery-image-upload-controls").css("display","block");
	});
	$(".jQuery-image-upload-controls").mouseleave(function(){
    $(".jQuery-image-upload-controls").css("display","none");
	});
	$(".face").on("imageUpload.uploadFailed", function (ev, err) {
		alert(err);
	});
</script>  
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
</script> 
 </body>
</html>