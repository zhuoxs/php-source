<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <?php
 $version = time(); ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="/tpl/Public/css/share.css?<?php echo ($version); ?>">
    <link rel="stylesheet" href="/tpl/Public/css/font.css?<?php echo ($version); ?>" />
    <!--JQ-->
    <script type="text/javascript" src="/tpl/Public/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/tpl/Public/js/jquery-form.js"></script>
    <script type="text/javascript" src="/tpl/Public/js/layer_mobile2/layer.js?<?php echo ($version); ?>"></script>
    <script type="text/javascript" src="/tpl/Public/js/swiper.3.1.7.min.js"></script>

    <script src="/tpl/Public/js/jquery.simplesidebar.js"></script>
    <script src="/tpl/Public/js/jquery.SuperSlide.2.1.1.js"></script>
    <script src="/tpl/Public/js/TouchSlide.1.0.js"></script>

    <script type="text/javascript" src="/tpl/Public/js/func.js?<?php echo ($version); ?>"></script>
    <script>
        var SITE_URL  = 'https:' == document.location.protocol ?'https://' : 'http://' + "<?php echo $_SERVER['HTTP_HOST'];?>";
    </script>
</head>

<body>

<div id="layout">

    <div id="right_nav">

    <div class="user">
        <?php if($is_login == 1): ?><img src="<?php echo ($member["head_img"]); ?>" class="avatar">
            <div class="info">
                <?php echo ($member["nickname"]); ?>
            </div>
        <?php else: ?>
            <img src="/tpl/Public/images/head_bg.png" class="avatar">
            <div class="info">
                <a href="<?php echo U('Public/reg');?>">注册</a> &nbsp; | &nbsp; <a href="<?php echo U('Public/login');?>">登陆</a>
            </div><?php endif; ?>
    </div>
    <div class="menu">
        <div class="link"><a href="<?php echo U('Index/index');?>">首页</a></div>
        <div class="link">信贷产品</div>
        <div class="sub_link">
            <a href="<?php echo U('posts/index',array('cid'=>1));?>">信用贷</a>
            <a href="<?php echo U('posts/index',array('cid'=>2));?>">房贷</a>
            <a href="<?php echo U('posts/index',array('cid'=>3));?>">小额现金贷</a>
            <a href="<?php echo U('posts/index',array('cid'=>4));?>">信用卡</a>
            <a href="<?php echo U('posts/index',array('cid'=>5));?>">理财</a>
        </div>
        <?php if($is_login == 1): ?><div class="link"><a href="<?php echo U('Member/index');?>">个人信息</a></div><?php endif; ?>
        <?php if($member['role'] == 1): ?><div class="link">信贷员入口</div>
            <div class="sub_link">
                <a href="<?php echo U('Member/get_member');?>">获取客户</a>
                <a href="<?php echo U('Member/my_member');?>">管理客户</a>
            </div>
            <?php else: ?>
            <div class="link"><a href="<?php echo U('Public/reg',array('role'=>1));?>">注册为信贷员</a></div><?php endif; ?>
    </div>
    <?php if($is_login == 1): ?><a href="<?php echo U('Public/logout');?>" class="btn_logout">退 出</a><?php endif; ?>
</div>

    <!-- main -->
    <div id="main">
        <div class="content rem8">
            <div class="user_des clearfix item_db">
                <div class="avatar width_le">
                    <img src="<?php echo (sp_img($data["head_img"])); ?>" />
                </div>
                <div class="myinfo width_f">
                    <h3><?php echo ($data["nickname"]); ?></h3>
                    <span class="fl"><?php echo ($data["intro"]); ?></span>
                    <span class="fr"> <a href="<?php echo U('edit_info');?>" class="edit">编辑资料</a></span>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="list_arrow">
                <a class="a_1" href="<?php echo U('read_list');?>"><i class="icon icon_centerBOOK"></i>我的书签</a>
                <a class="a_1" href="<?php echo U('fav_list');?>"><i class="icon icon_centerGZ"></i>我的收藏</a>
                <a class="a_1" href="<?php echo U('comment_list');?>"><i class="icon icon_centerSP"></i>我的评论</a>
                <a class="a_1" href="<?php echo U('reply_comment_list');?>"><i class="icon icon_msg"></i>消息通知<span class="font-gray" style="color: red"> <?php if($data['notice_num'] > 0): ?>(<?php echo ($data["notice_num"]); ?>)<?php endif; ?></span></a>
                <a class="a_1" href="<?php echo U('contribution_list');?>"><i class="icon icon_centerCY"></i>打赏记录</a>
                <a class="a_1" href="<?php echo U('edit_info');?>"><i class="icon icon_centerXZ"></i>个人信息</span></a>
                <!--<a class="a_1" href=""><i class="icon icon_centerPassword"></i>修改密码</a>-->
                <!--<a class="a_1" href=""><i class="icon icon_centerExit"></i>退出登录</a>-->
            </div>
        </div>
    </div>
    <!-- //main -->
</div>

</body>
</html>