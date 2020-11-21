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
<style type="text/css">
	.zhuyi{
		width: 100%;
		height: 2rem;
		float: left;
		line-height: 2rem;
		padding: 0 4%;
		box-sizing: border-box;
		font-size: 14px;
		font-weight: bold;
		color: red;
	}
</style>
<body class="gray_bg" style="background: #fff;">
<!-- 头部部分 开始 -->

<div class="task_index_topa">
	<p class="task_index_syss">平台已发放收益（元）</p>
	<p class="task_index_sssp">6958478.64元</p>
	<p class="task_index_wcrw">完成任务时间 46秒/个</p>
	<img src="/tpl/Public/images/lic.png"/>
</div>

<div class="task_index_rwsl">
	<p class="task_index_rwslll">
		<a href="#">已完成</a>
		<span>1</span>
		<span>3</span>
		<span>8</span>
		<span>7</span>
		<span>9</span>
		<a href="#">件任务</a>
	</p>
</div>

<div class="task_index_rwflll">
	<a href="<?php echo U('Task/lists_lb',array('lb'=>1));?>" style="background: #228aff;">抖音任务</a>
	<a href="<?php echo U('Task/lists_lb',array('lb'=>2));?>" style="float: right;">快手任务</a>
	<a href="<?php echo U('lists_sub',array('level'=>1));?>">网红任务</a>
	<a href="<?php echo U('lists_sub',array('level'=>2));?>" style="float: right;">明星任务</a>
	<a href="<?php echo U('lists_sub',array('level'=>0));?>" style="width: 100%;">普通任务</a>
</div>

<ul class="task_index_rwlbfl">
	<?php if(is_array($task_list)): $i = 0; $__LIST__ = $task_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
				
				<div class="index_rw_xqqs">
					<!--头像-->
					<div class="index_rw_log">
						<img src="/tpl/Public/images/yyy.png"/>
					</div>
					<!--标题与内容-->
					<div class="index_rw_msss">
						<p class="index_rw_ms_bt"> 抖音点赞并且关注米粒小屋米粒小屋米粒小屋</p>
						<p class="index_rw_ms_xqq">抖抖网红做任务的账号达到要求才可领取的任务，相应的要求比较高，获得佣金也会增加。
</p>
					</div>
					
					<!--领取-->
					<div class="index_rw_lqqq">
						<a href="#">+0.88元</a>
					</div>
				</div>
				
				<div class="index_rw_zxmss">
					<p>任务分类：抖音</p>
					<p>任务名额：100/1000</p>
				</div>
				
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
			
			
			
		</ul>
		
		<p class="zhuyi">此页面已发放收益与完成任务时间和已完成数量为静态数据 介意请勿拍下</p>







<footer class="footer">
	<ul>
		<a href="<?php echo U('Index/index');?>">
		<li>
			<img src="/tpl/Public/images/home_a.png"/>
			<p style="color: #b5b5b5;font-size: 12px;">首页</p>
		</li>
		</a>
		
		<a href="<?php echo U('Task/index');?>">
		<li>
			<img src="/tpl/Public/images/task_b.png"/>
			<p style="color: #228aff;font-size: 12px;">大厅</p>
		</li>
		</a>
		
		<a href="<?php echo U('Member/vip');?>">
		<li class="task_shop">
			<img class="foot_shop" src="/tpl/Public/images/shop_a.png"/>
		</li>
		</a>
		
		<a href="<?php echo U('Page/index');?>">
		<li>
			<img src="/tpl/Public/images/page_a.png"/>
			<p style="color: #b5b5b5;font-size: 12px;">消息</p>
		</li>
		</a>
		
		<a href="<?php echo U('Member/index');?>">
		<li>
			<img src="/tpl/Public/images/user_a.png"/>
			<p style="color: #b5b5b5;font-size: 12px;">我的</p>
		</li>
		</a>
		
	</ul>
</footer>







</body>
</html>