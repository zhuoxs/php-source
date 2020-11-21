<?php if (!defined('THINK_PATH')) exit(); $title = "个人中心";?>
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
<style type="text/css">
		.me_wd_yue{
			width: 92%;
			height: 5rem;
			line-height: 5rem;
			background: #fff;
			margin: 0.5rem auto;
			border-radius: 0.5rem;
			box-shadow:0px 1px 10px #ccc ;
		}
		.me_wd_yue p{
			width: 50%;
			height: 5rem;
			color: #228aff;
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			float: left;
		}
	</style>

<body class="gray_bg" style="background: #fff;">
	
	
	<div class="me_index_top">
		<div class="me_index_tlo">
			<img src="/tpl/Public/images/lo.jpg"/>
			<p class="me_index_t_bt"><?php echo ($data["username"]); ?></p>
			<p class="me_index_t_idhhy">ID:<?php echo ($member["id"]); ?> <span style="background: ;width: 5em;display: inline-block;height: 2rem;float: right;margin-right: 4.55rem;overflow: hidden;">等级：<?php echo ($level_name); ?></span></p>
			<a class="me_index_t_szz" href="<?php echo U('password');?>">
				<img src="/tpl/Public/images/me_sz.png"/>
			</a>
		</div>
	</div>
	
	<div class="me_index_rwwcd">
		<ul>
			<li>
				<a href="<?php echo U('Task/submission_task');?>">
					<img src="/tpl/Public/images/p1.png"/>
					<p class="me_index_dtj">待提交</p>
				</a>
			</li>
			<li>
				<a href="<?php echo U('Member/apply');?>">
					<img src="/tpl/Public/images/p2.png"/>
					<p class="me_index_dtj">审核中</p>
				</a>
			</li>
			<li>
				<a href="<?php echo U('Member/apply');?>">
					<img src="/tpl/Public/images/p3.png"/>
					<p class="me_index_dtj">已审核</p>
				</a>
			</li>
		</ul>
	</div>
	
	
	<div class="me_wd_yue">
		 <p> <?php echo ($data["price"]); ?></p>
		 <p style="font-size: 16px;color: #228aff;"><a href="<?php echo U('Member/tixian');?>" style="color: #228aff;;">立即提现</a></p>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<div class="me_index_dhnav">
		<ul>
			<a href="<?php echo U('sale');?>">
			<li>
				<img src="/tpl/Public/images/me1.png"/>
				<p>资金明细</p>
				<img class="me_index_dhnav_r" src="/tpl/Public/images/me10.png"/>
			</li>
			</a>
			
			
			<a href="<?php echo U('team');?>">
			<li>
				<img src="/tpl/Public/images/me2.png"/>
				<p>我的好友</p>
				<img class="me_index_dhnav_r" src="/tpl/Public/images/me10.png"/>
			</li>
			
			
			<a href="<?php echo U('Public/share');?>">
			<li>
				<img src="/tpl/Public/images/me3.png"/>
				<p>邀请好友</p>
				<img class="me_index_dhnav_r" src="/tpl/Public/images/me10.png"/>
			</li>
			
			
			<a href="/index.php/Home/Page/show/id/13.html">
			<li>
				<img src="/tpl/Public/images/me4.png"/>
				<p>常见问题</p>
				<img class="me_index_dhnav_r" src="/tpl/Public/images/me10.png"/>
			</li>
			
			
			<a href="#">
			<li>
				<img src="/tpl/Public/images/me5.png"/>
				<p>推广素材</p>
				<img class="me_index_dhnav_r" src="/tpl/Public/images/me10.png"/>
			</li>
			
			
			<a href="/index.php/Home/Page/show/id/12.html">
			<li>
				<img src="/tpl/Public/images/me6.png"/>
				<p>联系客服</p>
				<img class="me_index_dhnav_r" src="/tpl/Public/images/me10.png"/>
			</li>
			
			<a href="<?php echo U('Public/logout');?>">
			<li>
				<img src="/tpl/Public/images/me6.png"/>
				<p>退出登录</p>
				<img class="me_index_dhnav_r" src="/tpl/Public/images/me10.png"/>
			</li>
			</a>
			
		</ul>
	</div>
	
	<div class="me_index_bott" style="margin-bottom:5rem;">
		<a href="<?php echo U('Public/share');?>"><img src="/tpl/Public/images/me_tk.png"/></a>
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
     				<img src="/tpl/Public/images/page_a.png" />
     				<p style="color: #b5b5b5;font-size: 12px;">消息</p>
     			</li>
     		</a>
     
     		<a href="<?php echo U('Member/index');?>">
     			<li>
     				<img src="/tpl/Public/images/user_b.png" />
     				<p style="color: #228aff;font-size: 12px;">我的</p>
     			</li>
     		</a>
     
     	</ul>
     </footer>
	
	

</body>
</html>