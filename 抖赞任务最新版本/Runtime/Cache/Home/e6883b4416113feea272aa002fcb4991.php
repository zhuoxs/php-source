<?php if (!defined('THINK_PATH')) exit(); $title = $show['title'];?>
<!DOCTYPE html>
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
<div class="body_main">
    <!-- 头部部分 开始 -->
    <header class="top_header">
        <div class="left"><a href="javascript:" class="return go-back"></a></div>
        <div class="title"><?php echo ($title); ?></div>
    </header>
    <!--主体部分 开始-->
    <div class="page_main tline mt">
        <!--头部部分 开始-->
        <div class="tit">
            <h2><?php echo ($show["title"]); ?></h2>
            <p>最近更新：<?php echo (date('Y-m-d H:i',$show["update_time"])); ?></p>
        </div>
        <div class="txt">
            <?php echo ($show["content"]); ?>
        </div>
    </div>
</div>

<!-- 底部联系部分 开始 -->

<style type="text/css">
	.footer li{
		width: 25%;
	}
</style>

<footer class="footer">
    <ul>
        <li <?php if(CONTROLLER_NAME == 'Index'): ?>class="active"<?php endif; ?> >
            <a href="<?php echo U('Index/index');?>">
                <span><i class="icon_home"></i></span>
                <p>首页</p>
            </a>
        </li>
        <li <?php if(CONTROLLER_NAME == 'Task'): ?>class="active"<?php endif; ?> >
            <a href="<?php echo U('Task/index');?>">
                <span><i class="icon_task"></i></span>
                <p>发现</p>
            </a>
        </li>
        <!--<li <?php if(CONTROLLER_NAME == 'share'): ?>class="active"<?php endif; ?> >
            <a href="javascript:sp_alert('暂未开放')">
                <span><i class="icon_add"></i></span>
                <p>发布</p>
            </a>
        </li>-->
        <li <?php if(CONTROLLER_NAME == 'Page'): ?>class="active"<?php endif; ?> >
            <a href="<?php echo U('Page/index');?>">
                <span><i class="icon_info"></i></span>
                <p>消息</p>
            </a>
        </li>
        <li <?php if(CONTROLLER_NAME == 'Member'): ?>class="active"<?php endif; ?> >
            <a href="<?php echo U('Member/index');?>">
                <span><i class="icon_user"></i></span>
                <p>我的</p>
            </a>
        </li>
    </ul>
</footer>

</body>
</html>