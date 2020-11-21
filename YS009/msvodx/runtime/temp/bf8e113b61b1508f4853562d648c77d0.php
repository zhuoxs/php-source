<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:30:"./tpl/peixun/images/lists.html";i:1555750365;s:31:"./tpl/peixun/common/header.html";i:1555469934;s:31:"./tpl/peixun/common/footer.html";i:1555570480;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php $menu = getMenu();$register_validate = empty(get_config('register_validate')) ? 0 : get_config('register_validate');?>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="renderer" content="webkit">
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="csrf-param" content="_csrf-frontend">
<title><?php echo (isset($page_title) && ($page_title !== '')?$page_title:""); ?>_<?php echo $seo['site_title']; ?></title>
<meta name="keywords" lang="zh-CN" content="<?php echo $seo['site_keywords']; ?>"/>
<meta name="description" lang="zh-CN" content="<?php echo $seo['site_description']; ?>" />
<script type="text/javascript" src="__ROOT__/tpl/peixun/static/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="__ROOT__/tpl/peixun/static/js/layer/layer.js"></script>
<script type="text/javascript" src="__ROOT__/tpl/peixun/static/js/common.js"></script>
<script type="text/javascript" charset="utf-8" src="__ROOT__/tpl/peixun/static/js/layui/layui.js"></script>
<link rel="stylesheet" href="__ROOT__/tpl/peixun/static/js/layui/css/layui.css">
<link href="__ROOT__/tpl/peixun/peixin/css/msvod.css" rel="stylesheet">
<link href="__ROOT__/tpl/peixun/peixin/awesome/css/font-awesome.css" rel="stylesheet">
<script>
layui.use(['form', 'layedit', 'laydate'], function(){
});
if(!!window.ActiveXObject || "ActiveXObject" in window){
location.href="<?php echo url('index/remind'); ?>"
}
</script>
  <style>
    #qrcode img{margin: auto;}.ads_b .advert img{width: auto !important;}
  </style>
</head>
<body onLoad="load()">
<div id="body-container">
<div id="new-header">
  <div class="layout-cont clearfix">
    <div class="fl"><img src="<?php echo $seo['site_logo']; ?>" style="margin-top:7px;"/> <a href="/" title="返回首页"></a></div>
    <div class="nav fl clearfix">
      <!--<div class="nav-list fl design-course"> <a href="/" class="nav-t" >网站首页</a> </div>-->
      <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      <div <?php if($vo['current'] == 1): ?>class="nav-list fl current" <?php else: ?>class="nav-list fl" <?php endif; ?> >
        <a href="<?php echo $vo['url']; ?>" class="nav-t"><?php echo $vo['name']; ?><i class="sj"></i></a>
        <div class="top-con">
          <div class="course-con">
            <div class="head"> <a href="<?php echo url('system_pay/recharge'); ?>"class="charge-button rj-btn fr" target="_blank" rel="nofollow">为自己充值</a>
              <p>高清视频在线观看！</p>
            </div>
            <div class="course-p"> <?php if(!(empty($vo['sublist']) || (($vo['sublist'] instanceof \think\Collection || $vo['sublist'] instanceof \think\Paginator ) && $vo['sublist']->isEmpty()))): ?>
              <p class="tags-list-click"> <?php if(is_array($vo['sublist']) || $vo['sublist'] instanceof \think\Collection || $vo['sublist'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['sublist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?> <a href="<?php echo $v['url']; ?>" class="dx"><?php echo $v['name']; ?></a> <?php endforeach; endif; else: echo "" ;endif; ?> </p>
              <?php endif; ?> 
			  </div>
          </div>
        </div>
      </div>
     <?php endforeach; endif; else: echo "" ;endif; ?> 
	 </div>
    <?php $controller = lcfirst(request()->controller());$memberInfo = get_member_info();$login_status = check_is_login();if($login_status['resultCode'] != 1): ?> <a href="javascript:;" class="in-btn" id="loginBtn">
    <div class="login fr"><span></span>登录</div>
    </a> <?php else: ?>
    <div class="user-info user-nav-info fr hasLoading">
      <div class="user-avatar"><a target="_blank" href="<?php echo url('member/member'); ?>"><img src="<?php if(session('member_info')['headimgurl'] != ''): ?><?php echo session('member_info')['headimgurl']; else: ?>/static/images/user_dafault_headimg.jpg<?php endif; ?>"><i class="sj"></i><i class="jt"></i></a></div>
      <div class="info-m">
        <div class="user-drop">
          <div class="user-i"><a href="<?php echo url('member/member'); ?>" target="_blank"><img src="<?php if(session('member_info')['headimgurl'] != ''): ?><?php echo session('member_info')['headimgurl']; else: ?>/static/images/user_dafault_headimg.jpg<?php endif; ?>"></a>
            <div class="user-r">
              <div class="user-t clearfix">
                <div class="fl user-name"><a href="<?php echo url('member/member'); ?>" target="_blank"><?php echo session('member_info')['nickname']; ?></a></div>
                <div class="fl user-icon clearfix"><i class="phone-icon"></i>
				 <?php if($memberInfo['out_time'] > time()): ?><i class="v-icon"></i><?php else: ?><i class="p-icon"><?php endif; ?></div>
                <?php if(isSign() != '1'): ?> <a href="javascript:void(0);" onClick="sign()" class="day-check-button fl sign-btn-sidebar">立即签到</a> <?php else: ?> 
				<a href="javascript:void(0);" class="day-check-button fl sign-btn-sidebar ed">已签到</a> <?php endif; ?> </div>
              <div class="user-id" style="height:5px;"> </div>
              <?php if($memberInfo['isVip']==false): ?>
              <div class="hkb" style="border-radius:20px;"> 您还不是会员<a href="<?php echo url('system_pay/recharge'); ?>" target="_blank">开通/续费</a></div>
              <?php else: ?>
              <div class="hkb" style="border-radius:20px;">VIP会员 <?php if($memberInfo['is_permanent'] == 1): ?>永久<?php else: if($memberInfo['out_time'] > time()): ?><?php echo safe_date('Y-m-d',$memberInfo['out_time']); ?> 到期 <?php else: ?>已过期<?php endif; endif; ?>
              </div>
              <?php endif; ?> </div>
          </div>
          <div class="vip-info">
            <p>开通VIP可收获更有自信的自己</p>
            <p>海量精彩视频<span>无限观看</span></p>
            <p>海量高清图片<span>无限游览</span></p>
          </div>
          <div class="vip-btn"><a href="<?php echo url('system_pay/recharge'); ?>" target="_blank">充值VIP 会员</a></div>
          <div class="user-bottom"><a href="javascript:void(0);" class="fr" onClick="logout()">退出</a><a href="<?php echo url('member/member'); ?>" target="_blank">账户设置</a></div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <div class="user-news fr"> <a href="<?php echo url('member/video'); ?>" target="_blank">
      <div class="fa fa-cloud-upload fa-2x" style="color:#888;height:14px;margin: 7px auto 15px;"></div>
      <p class="news-txt">上传</p>
      </a> </div>
    <div class="app-d fr">
      <div class="sj"></div>
      <div class="app-icon"></div>
      <p class="app-txt">移动端</p>
      <div class="nav-m app-download">
        <div id="qrcode" class="code-img"></div>
        <!--<div id="qrcode"></div> -->
        <p>扫一扫，手机上浏览</p>
        <!--<a href="" target="_blank">了解详情</a> -->
      </div>
    </div>
    <div class="header-search fr">
        <div class="search-m search-area">
        <form <?php switch($controller): case "images": ?> action="<?php echo url('search/index',array('type'=>'atlas')); ?>"<?php break; case "atlas": ?> action="<?php echo url('search/index',array('type'=>'atlas')); ?>"<?php break; case "novel": ?>action="<?php echo url('search/index',array('type'=>'novel')); ?>"<?php break; case "search": ?>action="<?php echo url('search/index',array('type'=>$type)); ?>"<?php break; default: ?>action="<?php echo url('search/index',array('type'=>'video')); ?>"
        <?php endswitch; ?> method="get">
        <input type="text" value='<?php if(isset($key_word)): ?><?php echo $key_word; endif; ?>' name="key_word" id="search-identify" placeholder="输入关键词..." class="txt">
        <button type="submit" style="border:0px solid #eee;" id="submit-search" class="submit-abtn search-butn"></button>
		</form>
      </div>
    </div>
  </div>
</div>

<script src="/static/js/qrcode.min.js" type="text/javascript"></script>
<script type="text/javascript">
    // 设置 qrcode 参数
    var qrcode = new QRCode('qrcode', {
        text: location.href,
        width: 130,
        height: 130,
        colorDark: '#000000',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });
</script>
<link href="__ROOT__/tpl/peixun/peixin/css/images.css" rel="stylesheet">
<div id="album">
<!--对联-左-->
<div class="ads_dl lrframe-box" id="ads_dl" style="width:200px;float:left;position:fixed;left:0;z-index:1000;top:40%;padding-bottom: 0;border-radius: 0;">
  <span class="frame-close"><a style="width:12px;height:12px;display:block;" onclick="document.getElementById('ads_dl').style.display='none'" href="javascript:void(0);"></a></span>
  <script language="javascript" src="<?php echo url('/poster/index',array('pid'=>2)); ?>"></script>
</div>
<!--对联-右-->
<div class="ads_dr lrframe-box" id="ads_dr" style="width:200px;float:right;position:fixed;right:0;z-index:1000;top:40%;padding-bottom: 0;border-radius: 0;">
  <span class="frame-close"><a style="width:12px;height:12px;display:block;" onclick="document.getElementById('ads_dr').style.display='none'" href="javascript:void(0);"></a></span>
  <script language="javascript" src="<?php echo url('/poster/index',array('pid'=>3)); ?>"></script>
</div>
<!--底部-->
<div class="ads_b lrframe-box" id="ads_b" style="position:fixed;z-index:1000;bottom:0;background:#000000ba;width:100%;text-align:center;padding-bottom: 0;border-radius: 0;">
  <span class="frame-close"><a style="width:12px;height:12px;display:block;" onclick="document.getElementById('ads_b').style.display='none'" href="javascript:void(0);"></a></span>
  <script language="javascript" src="<?php echo url('/poster/index',array('pid'=>4)); ?>"></script>
</div>
<div class="album-list clearfix layout-cont">
  <div class="classify-tiny limit-height" style="margin-top:10px;">
    <div class="tiny-item"> <span class="tiny-name">分类：</span>
      <div class="tiny-list tags-list-click" id="class_box" style="height: auto; overflow: visible;"> <a href="#" data="0" class="<?php if(empty($cid) || (($cid instanceof \think\Collection || $cid instanceof \think\Paginator ) && $cid->isEmpty())): ?>on<?php endif; ?>">全部</a> 
	<?php if(is_array($class_list) || $class_list instanceof \think\Collection || $class_list instanceof \think\Paginator): $i = 0; $__LIST__ = $class_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> <a data="<?php echo $vo['id']; ?>" href="#" class="<?php if($cid == $vo['id']): ?>on<?php endif; ?>"><?php echo $vo['name']; ?></a> <?php endforeach; endif; else: echo "" ;endif; ?> </div>
    </div>
    <?php if(!(empty($class_sublist) || (($class_sublist instanceof \think\Collection || $class_sublist instanceof \think\Paginator ) && $class_sublist->isEmpty()))): ?>
    <div class="tiny-item "> <span class="tiny-name">子类：</span>
      <div class="tiny-list tags-list-click" id="sub_box" style="height: auto; overflow: visible;"> <a href="#" data="0" class="<?php if(empty($sub_cid) || (($sub_cid instanceof \think\Collection || $sub_cid instanceof \think\Paginator ) && $sub_cid->isEmpty())): ?>on<?php endif; ?>">全部</a>
	<?php if(is_array($class_sublist) || $class_sublist instanceof \think\Collection || $class_sublist instanceof \think\Paginator): $i = 0; $__LIST__ = $class_sublist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> <a  data="<?php echo $vo['id']; ?>" href="#" class="<?php if($sub_cid == $vo['id']): ?>on<?php endif; ?>"><?php echo $vo['name']; ?></a> <?php endforeach; endif; else: echo "" ;endif; ?> </div>
    </div>
    <?php endif; ?>
    <div class="tiny-item "> <span class="tiny-name">标签：</span>
      <div class="tiny-list tags-list-click" id="tag_box" style="height: auto; overflow: visible;"> <a href="#" data="0" class="<?php if(empty($tag_id) || (($tag_id instanceof \think\Collection || $tag_id instanceof \think\Paginator ) && $tag_id->isEmpty())): ?>on<?php endif; ?>">全部</a> 
	<?php if(is_array($tag_list) || $tag_list instanceof \think\Collection || $tag_list instanceof \think\Paginator): $i = 0; $__LIST__ = $tag_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> <a data="<?php echo $vo['id']; ?>" href="#" class="<?php if($tag_id == $vo['id']): ?>on<?php endif; ?>"><?php echo $vo['name']; ?></a> <?php endforeach; endif; else: echo "" ;endif; ?> </div>
    </div>
  </div>
  <br>
  <!--图片列表横幅-->
  <div class="ads_01" style="width:1245px;">
    <script language="javascript" src="<?php echo url('/poster/index',array('pid'=>10)); ?>"></script>
  </div>
  <div class="pic-title clearfix" style="margin-top:20px;">
    <div class="pt-left fl" >
      <h3>排序：</h3>
    </div>
    <select id="orderCode" name="orderCode" style="border: 1px solid #eee;color:#6E6E6E;">
      <option value="lastTime" <?php if($orderCode == 'lastTime'): ?>selected="selected"<?php endif; ?>>最新图片</option>
      <option value="hot" <?php if($orderCode == 'hot'): ?>selected="selected"<?php endif; ?>>最热图片</option>
    </select>
  </div>
  <div class="wrap"> 
    <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <div class="list" >
      <!--<span class="tips"></span>-->
      <div class="img"> <a href="<?php echo url('images/show',array('id'=>$vo['id'])); ?>" target="_blank"> <img src="<?php echo $vo['cover']; ?>"> </a> </div>
      <div class="con"> <a href="<?php echo url('images/show',array('id'=>$vo['id'])); ?>" target="_blank"><?php echo $vo['title']; ?></a> </div>
      <div class="con"> <span style=""><i class="fa fa-eye" style="color:#666666;margin-right:5px;"></i><?php echo $vo['click']; ?></span> <span style="margin-left:8px;">
	  <i class="fa fa-dot-circle-o" style="color:#666666;margin-left:10px;"></i> <?php echo $vo['good']; ?></span> <span style="float:right;"><?php echo date('m-d',$vo['update_time']); ?></span> </div>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; else: ?>
    <div align="center" class="not-data">暂时没有数据 ~</div>
    <?php endif; ?> 
	 </div>
    <form action="" method="get" id="forms">
    <input type="hidden" id="current_orderCodes"  name="orderCode" value="<?php echo (isset($orderCode) && ($orderCode !== '')?$orderCode:'0'); ?>" >
    <input type="hidden" id="current_tag_id" name="tag_id"  value="<?php echo (isset($tag_id) && ($tag_id !== '')?$tag_id:'0'); ?>" >
    <input type="hidden" id="current_sub_cid" name="sub_cid"  value="<?php echo (isset($sub_cid) && ($sub_cid !== '')?$sub_cid:'0'); ?>" >
    <input type="hidden" id="current_cid" name="cid"  value="<?php echo (isset($cid) && ($cid !== '')?$cid:'0'); ?>" >
  </form>
</div>
<div class="sort-pager"> <?php echo $pages; ?> </div>
<script>
$(function(){
$('#orderCode').change(function(){
$('#current_orderCodes').val($(this).val());
$('#forms').submit();
})
$('#sub_box').find('a').click(function(){
var sub = $(this).attr('data');
$('#current_sub_cid').val(sub);
$('#forms').submit();
})
$('#class_box').find('a').click(function(){
var cid = $(this).attr('data');
$('#current_cid').val(cid);
$('#current_sub_cid').val(0);
$('#forms').submit();
})
$('#tag_box').find('a').click(function(){
var tag_id = $(this).attr('data');
$('#current_tag_id').val(tag_id);
$('#forms').submit();
})
});
</script>
﻿      <?php 
      $baseConfig = get_config_by_group('base');
      $baseConfig['friend_link'] =  empty($seo['friend_link']) ? $baseConfig['friend_link'] : $seo['friend_link'];
      $baseConfig['site_icp'] = empty($seo['site_icp']) ? $baseConfig['site_icp'] : $seo['site_icp'];
      $baseConfig['site_statis'] = empty($seo['site_statis']) ? $baseConfig['site_statis'] : $seo['site_statis'];
      $linkList=get_friend_link($baseConfig);
       ?>
	  <div class="footer">
        <div class="footer-top">
          <div class="layout-cont">
            <div class="friend-link clearfix">
              <div class="link-left"><b style="color:#FF9900;">友情链接：</b>
			  <?php if(is_array($linkList) || $linkList instanceof \think\Collection || $linkList instanceof \think\Paginator): $i = 0; $__LIST__ = $linkList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?>
			  <a target="_blank" href="<?php echo $link['url']; ?>"><?php echo $link['name']; ?></a> 
              <?php endforeach; endif; else: echo "" ;endif; ?>
			  </div>
            </div>
          </div>
        </div>
        <div class="footer-bot">
          <div class="layout-cont clearfix">
            <div class="copy-l">
              <style>.footer .footer-bot {height: auto;line-height: 30px;padding: 10px 0;text-align: center;}</style>
<p>本站严禁发布淫秽色情等违反国家法律法规的内容，如有发现请联系站长删除！</p>
              <p><a target="_blank" href="http://www.miitbeian.gov.cn" class="gov">ICP备案号:<?php echo $baseConfig['site_icp']; ?></a> <?php echo htmlspecialchars_decode($baseConfig['site_statis']); ?></p>
              <p><span class="info">© Copyright (c) 2017-2018 All Rights Reserved. </span> <a href="#"target="_blank"><img src="__ROOT__/tpl/happy2018/peixin/picture/footer_aqkx.png" alt=""></a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="fixed-bar">
    <!--<div class="active-box"><a href="<?php echo url('system_pay/recharge'); ?>" target="_blank"> <img src="__ROOT__/tpl/peixun/peixin/picture/vip-icon-1.gif" alt="充值VIP"></a></div>
    <div class="fixed-box first-child"> <span class="box-label app-label tran" onclick="window.open('#');pagePositionClick(82);"> <i class="label-icon"></i></span>
      <div class="box-drop">
 -->
      </div>
    </div>
    <div class="fixed-box"><span class="box-label suggess-label tran" onClick="window.open('#');pagePositionClick(84);"><i class="label-icon"></i></span>
    </div>
    <div class="fixed-box"><span class="box-label qqkf-label tran"><i class="label-icon"></i></span>
      <div class="box-drop">
      </div>
    </div>
    </a> </div>
  <div id="login-box" class="hkt-win hide">
    <div class="hkt-mask">
      <div class="hkt-cell">
        <div class="lrframe-box"><span class="frame-close" data-bind-bs="hideModal"></span>
          <div class="tab-head"><span class="t1 active">登录</span><span class="t2">注册</span></div>
          <?php $memberInfo = get_member_info();?>
          <div class="tab-main clerafix" id="loginModal-t1">
            <div class="frame-bd fl">
              <div class="phone-m fl" style="display: block;">
                <br>
                <div class="phone-num"><i class="fa fa-user-o fa-2x" style="color:#eee;width:15px;height: 25px;position: absolute;top: 11px;left: 14px;"></i>
                  <input type="text" id="userName" placeholder="用户名/手机号/邮箱">
                </div>
                <div class="phone-num"><i class="fa fa-unlock-alt fa-2x" style="color:#eee;width:15px;height: 25px;position: absolute;top: 11px;left: 14px;"></i>
                  <input type="password" id="password" placeholder="输入登陆密码">
                </div>
                <?php if(get_config('verification_code_on')): ?>
                <div class="phone-yz">
                  <div class="yz-l fl">
                    <input type="text" name="verifyCode" id="verifyCode" placeholder="请输入验证码">
                  </div>
                  <div class="yz-r fr"> <img src="<?php echo url('api/getCaptcha'); ?>" onClick="this.src='<?php echo url('api/getCaptcha'); ?>?'+Math.random()" id="verifyCodeImg" style="width:120px;height:45px;border: 1px #ffa900 solid;"/> </div>
                </div>
                <?php endif; ?>
                <div class="phone-btn" onclick="login()">立即登陆</div>
                <div class="agree-deal">
                  <div class="forget"><?php if($register_validate != 0): ?><a href="<?php echo url('member/seek_pwd'); ?>">忘记密码？</a> | <?php endif; ?></div>
                </div>
                <div class="frame-bd clearfix">
                  <?php  $longwait=get_sanfanlogin(); if(is_array($longwait) || $longwait instanceof \think\Collection || $longwait instanceof \think\Paginator): if( count($longwait)==0 ) : echo "" ;else: foreach($longwait as $key=>$vo): if($vo['login_code'] == 'qq'): ?>
                  <a href="<?php echo url('open/login',['code'=>'qq']); ?>" class="wk-btn tran qq-login"><i></i>QQ登录</a>
                  <?php endif; if($vo['login_code'] == 'wechat'): ?>
                  <a href="<?php echo url('open/login',['code'=>'wechat']); ?>" class="wk-btn tran wx-login"><i></i>微信登录 </a>
                  <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
              </div>
            </div>
          </div>
          <br>
          <!--注册部分-->
          <div class="tab-main clerafix" style="display: none" id="loginModal-t2">
            <div class="frame-bd fl">
              <div class="phone-m fl" style="display: block;">
                <div class="phone-num"><i class="fa fa-user-o fa-2x" style="color:#eee;width:15px;height: 25px;position: absolute;top: 11px;left: 14px;"></i>
                  <input type="text" id="reg_userName" class="phone" <?php if($register_validate == 1): ?>placeholder="邮箱地址"<?php else: if($register_validate == 2): ?>placeholder="手机号码"<?php else: ?>placeholder="用户名"<?php endif; endif; ?>>
                </div>
                <div class="phone-num"><i class="fa fa-address-book-o fa-2x" style="color:#eee;width:15px;height: 25px;position: absolute;top: 11px;left: 14px;font-size:24px;"></i>
                  <input type="text" id="nickname" class="text" placeholder="用户昵称"/>
                </div>
                <div class="phone-num"><i class="fa fa-unlock-alt fa-2x" style="color:#eee;width:15px;height: 25px;position: absolute;top: 11px;left: 14px;"></i>
                  <input type="password" id="reg_pwd" class="pwd" placeholder="输入密码"/>
                </div>
                <div class="phone-num"><i class="fa fa-unlock-alt fa-2x" style="color:#eee;width:15px;height: 25px;position: absolute;top: 11px;left: 14px;"></i>
                  <input type="password" id="reg_pwd_re" placeholder="确认密码"/>
                </div>
                <?php if($register_validate != 0): ?>
                <div class="phone-yz">
                  <div class="yz-l fl">
                    <input type="text" name="verifyCode" id="codes" placeholder="手机验证码">
                  </div>
                  <div class="yz-r fr" > <span id="register_code" onclick="getCode()" class="yz">获取验证码</span> </div>
                </div>
                <?php else: if(get_config('verification_code_on')): ?>
                <div class="phone-yz">
                  <div class="yz-l fl">
                    <input type="text" name="verifyCode" id="codes" placeholder="请输入验证码">
                  </div>
                  <div class="yz-r fr"> <img src="<?php echo url('api/getCaptcha'); ?>" onClick="this.src='<?php echo url('api/getCaptcha'); ?>?'+Math.random()" id="verifyCodeImg" style="width:120px;height:45px;border: 1px #ffa900 solid;"/> </div>
                </div>
                <?php endif; endif; ?>
                <div class="phone-btn" onclick="register()">立即注册</div>
                <div class="agree-deal">
                  <div class="forget"><?php if($register_validate != 0): ?><a href="<?php echo url('member/seek_pwd'); ?>">忘记密码？</a> | <?php endif; ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      <style>
        .lrframe-box .tab-main .phone-m .frame-bd a{width: 45% !important;}
        .lrframe-box .frame-bd a:last-child{float: right;}
      </style>
<script type="text/javascript">
var disabled = 0;
function login() {
var user = $('#userName').val();
var password = $('#password').val();
var verifyCode=$('#verifyCode');
if (user == '' || password == '') {
layer.msg('用户名或密码不能为空.', {icon: 2, anim: 6, time: 1000});
return false;
}
if(verifyCode.val()==''){
layer.msg('验证码不能为空.', {icon: 2, anim: 6, time: 1000});
verifyCode.focus();
return false;
}
var url = "<?php echo url('api/login'); ?>";
$.post(url, {userName: user, password: password,verifyCode:verifyCode.val()}, function (data) {
if (data.statusCode == 0) {
layer.msg('登陆成功', {time: 1000, icon: 1}, function() {
location.reload();
});
} else {
layer.msg(data.error, {icon: 2, anim: 6, time: 1000});
$("#verifyCodeImg").click();
}
}, 'JSON');
}
    $(document).keyup(function(event){
        if(event.keyCode ==13){
            if($("#login-box").is(":hidden")){
               return null;
            }else{
                login();
            }

        }
    });
function codetTmes() {
var second = $('#register_code').html();
//console.log(second);
second--;
if(second > 0){
$('#register_code').html(second);
setTimeout("codetTmes()",1000);
}else{
$('#register_code').html('获取验证码');
disabled = 0;
}
}
function getCode(){
var user = $('#reg_userName').val();
if(disabled) return false;
if (user == '' || password == '') {
$('#reg_userName').focus();
layer.msg('用户名不能为空.', {icon: 2, anim: 6, time: 1000});
return false;
}
var url = "<?php echo url('api/getRegisterCode'); ?>";
$.post(url, {username: user}, function (data) {
if (data.statusCode == 0) {
disabled = 1;
layer.msg(data.error, {icon: 1, anim: 6, time: 3000});
$('#register_code').html('60');
codetTmes();
}else{
layer.msg(data.error, {icon: 2, anim: 6, time: 1000});
}
}, 'JSON');
}
function register(){
var user = $('#reg_userName').val();
var nickname = $('#nickname').val();
var password = $('#reg_pwd').val();
var confirm_password=$('#reg_pwd_re').val();
var verifyCode=$('#codes').val();
if (user == '') {
    layer.msg('用户名不能为空.', {icon: 2, anim: 6, time: 1000});
    return false;
}
if (nickname == '') {
    layer.msg('用户昵称不能为空.', {icon: 2, anim: 6, time: 1000});
    return false;
}
if (password == '') {
    layer.msg('密码不能为空.', {icon: 2, anim: 6, time: 1000});
    return false;
}
if (password != confirm_password) {
layer.msg('两次密码不一致.', {icon: 2, anim: 6, time: 1000});
return false;
}
if(verifyCode==''){
layer.msg('验证码不能为空.', {icon: 2, anim: 6, time: 1000});
$('#codes').focus();
return false;
}
var url = "<?php echo url('api/register'); ?>";
$.post(url, {username: user,nickname:nickname,  password: password,confirm_password:confirm_password,verifyCode:verifyCode}, function (data) {
if (data.statusCode == 0) {
console.log(data);
layer.msg('注册成功', {time: 1000, icon: 1}, function() {
location.reload();
});
}else{
layer.msg(data.error, {icon: 2, anim: 6, time: 1000});
}
}, 'JSON');
}
function sign(){
var url = "<?php echo url('api/sign'); ?>";
$.post(url, {}, function (data) {
if (data.resultCode == 0) {
$('.sign-btn').find('var').html('+'+data.data['value']);
$('.sign-btn').addClass("signs");
$('.sign-btn').addClass("Completion");
layer.msg('签到成功', {icon: 1, anim: 6, time: 2000},function () {
$('.sign-btn').removeClass("signs");
});
}else{
layer.msg(data.error, {icon: 2, anim: 6, time: 2000});
}
}, 'JSON');
}
function logout(){
var url="<?php echo url('api/logout'); ?>";
$.post(url,{},function(){
layer.msg('退出成功', {time: 1000, icon: 1}, function() {
location.reload();
});
},'JSON');
}
//$.post("",{userName:})
</script>
<script src="__ROOT__/tpl/peixun/peixin/js/msvod.js"></script>
      <?php if($login_status['resultCode'] == 3): ?>
      <script>
          layer.msg('该账号已在其他地方登陆',
              {
                  icon: 5,
                  time: 0,
                  shadeClose: true,
                  shade: 0.8,
                  btn: ['确定'],
                  yes:function (index) {
                      layer.close(index);
                      window.location.reload();
                  },
                  success: function (layero) {
                      var btn = layero.find('.layui-layer-btn');
                      btn.css('text-align', 'center');
                  }
              });
      </script>
      <?php endif; ?> 