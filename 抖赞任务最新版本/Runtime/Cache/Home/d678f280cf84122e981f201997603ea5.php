<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php echo ($title); ?></title>
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
<body class="index_body">
	
	
	<!--标题内容-->
	<div class="index_bt">
		<p class="index_hyxx">Hi,欢迎来到赞多多APP。</p>
	</div>
	
	<!--头部余额内容-->
	<div class="index_ye">
		<p class="index_ztsy">账户余额</p>
		<p class="index_ztsy_dd"><?php echo ($data["price"]); ?>0元</p>
		<a class="index_tssy" href="	/index.php/Home/Public/share">提升收益</a>
		
		<div class="index_zhyehsy">
			<p class="index_syyys">平台用户：55302人</p>
			<p class="index_syyys">发放收益：6958478.64元</p>
		</div>
	</div>
	
	<!--首页导航内容-->
	<div class="index_xnav">
		<ui>
			<a href="<?php echo U('Task/index');?>">
			<li>
				<img src="/tpl/Public/images/i1.png"/>
				<p>任务列表</p>
			</li>
			</a>
			
			<a href="<?php echo U('Index/shop');?>">
			<li>
				<img src="/tpl/Public/images/i2.png"/>
				<p>成为会员</p>
			</li>
			</a>
			
			<a href="<?php echo U('Public/share');?>">
			<li>
				<img src="/tpl/Public/images/i3.png"/>
				<p>邀请好友</p>
			</li>
			</a>
			
			<a href="/index.php/Home/Page/show/id/12.html">
			<li>
				<img src="/tpl/Public/images/i4.png"/>
				<p>联系客服</p>
			</li>
			</a>
			
		</ui>
		
		<!--成为会员-->
		
		<div class="index_cwhy">
			<a href="<?php echo U('Public/share');?>">
				<p class="index_cw_xrfl">邀请好友送现金</p>
			</a>
		</div>
		
	</div>
	
	
	<!--任务列表-->
	<div class="index_rwalb">
		<p class="index_rw_tjrw">推荐任务 <span><a href="<?php echo U('Task/index');?>">更多></a></span> </p>
		
		<ul>
			<?php if(is_array($task_list)): $i = 0; $__LIST__ = $task_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Task/show',array('id'=>$vo['id']));?>">
			<li>
				
				<div class="index_rw_xqqs">
					<!--头像-->
					<div class="index_rw_log">
						<?php if($vo["tasklb"] == '1'): ?><img src="/tpl/Public/images/dj.png"/><?php else: ?><img src="/tpl/Public/images/ks.png"/><?php endif; ?>
					</div>
					<!--标题与内容-->
					<div class="index_rw_msss">
						<p class="index_rw_ms_bt"> <?php echo ($vo["title"]); ?></p>
						<p class="index_rw_ms_xqq">赞多多做任务的账号达到要求才可领取的任务，相应的要求比较高，获得佣金也会增加。
</p>
					</div>
					
					<!--领取-->
					<div class="index_rw_lqqq">
						<a href="#">+<?php echo (floatval($vo["price"])); ?>元</a>
					</div>
				</div>
				
				<div class="index_rw_zxmss">
					<p>任务分类：<span><?php if($vo["tasklb"] == '1'): ?>抖音任务<?php else: ?>快手任务<?php endif; ?></span> <span class="index_gjrw">
                    
                     <?php if(is_array($level)): $i = 0; $__LIST__ = $level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i; if($vv['level'] == $vo['level']): echo ($vv["name"]); ?>任务<?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    
                       </span></p>
					<p>任务名额：<?php echo ($vo["leftnum"]); ?></p>
				</div>
				
			</li>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
			
		</ul>
		
		
	</div>
	
	
	
	
	
	
	
    <!-- 底部联系部分 开始 -->
    <footer class="footer">
	<ul>
		<a href="<?php echo U('Index/index');?>">
		<li>
			<img src="/tpl/Public/images/home_b.png"/>
			<p style="color: #228aff;font-size: 12px;">首页</p>
		</li>
		</a>
		
		<a href="<?php echo U('Task/index');?>">
		<li>
			<img src="/tpl/Public/images/task_a.png"/>
			<p style="color: #b5b5b5;font-size: 12px;">大厅</p>
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

<script>
    $(document).ready(function () {
        //幻灯片
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            paginationClickable: true,
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: 4000,
            autoplayDisableOnInteraction: false
        });
    });
</script>
<?php if(!empty($page_notice_list)): ?><script>
    //文字向上滚动
    (function($){
        $.fn.FontScroll = function(options){
            var d = {time: 3000,s: 'fontColor',num: 1}
            var o = $.extend(d,options);

            this.children('ul').addClass('line');
            var _con = $('.line').eq(0);
            var _conH = _con.height(); //滚动总高度
            var _conChildH = _con.children().eq(0).height();//一次滚动高度
            var _temp = _conChildH;  //临时变量
            var _time = d.time;  //滚动间隔
            var _s = d.s;  //滚动间隔


            _con.clone().insertAfter(_con);//初始化克隆

            //样式控制
            var num = d.num;
            var _p = this.find('li');
            var allNum = _p.length;

            _p.eq(num).addClass(_s);


            var timeID = setInterval(Up,_time);
            this.hover(function(){clearInterval(timeID)},function(){timeID = setInterval(Up,_time);});

            function Up(){
                _con.animate({marginTop: '-'+_conChildH});
                //样式控制
                _p.removeClass(_s);
                num += 1;
                _p.eq(num).addClass(_s);

                if(_conH == _conChildH){
                    _con.animate({marginTop: '-'+_conChildH},"normal",over);
                } else {
                    _conChildH += _temp;
                }
            }
            function over(){
                _con.attr("style",'margin-top:0');
                _conChildH = _temp;
                num = 1;
                _p.removeClass(_s);
                _p.eq(num).addClass(_s);
            }
        }
    })(jQuery);

    $('#MScroll').FontScroll({time: 3000,num: 1});

</script><?php endif; ?>