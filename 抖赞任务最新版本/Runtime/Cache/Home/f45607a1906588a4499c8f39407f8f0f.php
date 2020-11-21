<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		 <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="description" content=""/>

    <!--JQ-->
    <script type="text/javascript" src="/tpl/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/tpl/Public/js/jquery-form.js"></script>
    <script type="text/javascript" src="/tpl/Public/js/layer_mobile2/layer.js?<?php echo ($version); ?>"></script>
    <script type="text/javascript" src="/tpl/Public/js/swiper.3.1.7.min.js"></script>

    <script src="/tpl/Public/js/jquery.simplesidebar.js"></script>
    <script src="/tpl/Public/js/jquery.SuperSlide.2.1.1.js"></script>
    <script src="/tpl/Public/js/TouchSlide.1.0.js"></script>

    <script type="text/javascript" src="/tpl/Public/js/func.js"></script>

    <link rel="stylesheet" href="/tpl/Public/css/share.css?3"/>
    <link rel="stylesheet" href="/tpl/Public/css/font.css?3"/>
	</head>
	<body>
		
		
<style type="text/css">
	.footer li{
		width: 20%;
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
                <p>任务</p>
            </a>
        </li>
        
        
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