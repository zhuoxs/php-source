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
	<body style="background: #fff;">
		
		<div class="shop_index_lbt">
			<img src="/tpl/public/images/sc.png"/>
		</div>
		
		<div class="shop_index_splb">
			<ul>
				<li>
					<img src="/tpl/public/images/chaye.jpg"/>
					<p class="shop_index_shy">赠送网红会员</p>
					<p class="shop_index_spbt">2019新茶美安雅茶 蒙山毛峰绿茶茶叶毛尖绿茶四川蒙顶山茶产区50g</p>
					<p class="shop_index_zlbszz">赞多多自营商品质量保证</p>
					<p class="shop_index_jgg">¥ 120元
						<span>月销：215件</span>
					</p>
				</li>
			</ul>
		</div>
		
		
		<div class="list" id="vip_sel">
                <?php if(is_array($member_level)): $i = 0; $__LIST__ = $member_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="sub <?php if($vo['level'] > $member['level']): ?>lv<?php endif; ?>" data-id="<?php echo ($vo["level"]); ?>" data-price="<?php echo ($vo["price"]); ?>">
                        <p class="img"><img src="/tpl/Public/images/medal_icon_<?php echo ($vo["level"]); ?>.png"  /></p>
                        <p class=""><?php echo ($vo["name"]); ?></p>
                        <span>￥<?php echo ($vo["price"]); ?></span>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		 <div class="list" id="vip_sel">
		  <div class="shop_index_splb" id="vip_sel">
			<ul>
				<?php if(is_array($member_level)): $i = 0; $__LIST__ = $member_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="sub <?php if($vo['level'] > $member['level']): ?>lv<?php endif; ?>" data-id="<?php echo ($vo["level"]); ?>" data-price="<?php echo ($vo["price"]); ?>">
					<img src="/tpl/public/images/chaye.jpg"/>
					<p class="shop_index_shy">赠送<?php echo ($vo["name"]); ?>会员</p>
					<p class="shop_index_spbt">2019新茶美安雅茶 蒙山毛峰绿茶茶叶毛尖绿茶四川蒙顶山茶产区50g</p>
					<p class="shop_index_zlbszz">赞多多自营商品质量保证</p>
					<p class="shop_index_jgg">¥ 120元
						<span>月销：215件</span>
					</p>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
				
			</ul>
		</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<footer class="footer">
			<ul>
				<a href="<?php echo U('Index/index');?>">
					<li>
						<img src="/tpl/public/images/home_a.png" />
						<p style="color: #b5b5b5;font-size: 12px;">首页</p>
					</li>
				</a>
		
				<a href="<?php echo U('Task/index');?>">
					<li>
						<img src="/tpl/public/images/task_a.png" />
						<p style="color: #b5b5b5;font-size: 12px;">大厅</p>
					</li>
				</a>
		
				<a href="<?php echo U('Index/shop');?>">
					<li class="task_shop">
						<img class="foot_shop" src="/tpl/public/images/shop_a.png" />
					</li>
				</a>
		
				<a href="<?php echo U('Page/index');?>">
					<li>
						<img src="/tpl/public/images/page_a.png" />
						<p style="color: #b5b5b5;font-size: 12px;">消息</p>
					</li>
				</a>
		
				<a href="<?php echo U('Member/index');?>">
					<li>
						<img src="/tpl/public/images/user_a.png" />
						<p style="color: #b5b5b5;font-size: 12px;">我的</p>
					</li>
				</a>
		
			</ul>
		</footer>
		
	</body>
</html>