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

<body class="gray_bg">
<div class="body_main">
    <!-- 头部部分 开始 -->
    <div class="page_index_tz">
    	<p class="page_index_xttz">系统消息：2019/07/09 16:30:58</p>
    	<p class="page_index_tznr">尊敬的各位会员：赞多多平台将向各位会员郑重承诺：赞多多平台有自己的抖音推广团队，励志构建一个电商生态，不存在跑路。平台将在2019年7月8日00:00:00--2019年7月10日23:59:59进行升级。</p>
    	<a class="page_index_ckxxnr" href="#">查看详细内容</a>
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
 
     
     <footer class="footer">
     	<ul>
     		<a href="<?php echo U('Index/index');?>">
     			<li>
     				<img src="/tpl/Public/images/home_a.png" />
     				<p style="color: #b5b5b5;font-size: 12px;">首页</p>
     			</li>
     		</a>
     
     		<a href="<?php echo U('Task/index');?>">
     			<li>
     				<img src="/tpl/Public/images/task_a.png" />
     				<p style="color: #b5b5b5;font-size: 12px;">大厅</p>
     			</li>
     		</a>
     
     		<a href="<?php echo U('Member/vip');?>">
     			<li class="task_shop">
     				<img class="foot_shop" src="/tpl/Public/images/shop_a.png" />
     			</li>
     		</a>
     
     		<a href="<?php echo U('Page/index');?>">
     			<li>
     				<img src="/tpl/Public/images/page_b.png" />
     				<p style="color: #228aff;font-size: 12px;">消息</p>
     			</li>
     		</a>
     
     		<a href="<?php echo U('Member/index');?>">
     			<li>
     				<img src="/tpl/Public/images/user_a.png" />
     				<p style="color: #b5b5b5;font-size: 12px;">我的</p>
     			</li>
     		</a>
     
     	</ul>
     </footer>
     
</div>
</body>
</html>