<?php if (!defined('THINK_PATH')) exit(); $title = "购买会员";?>

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
	.vip_car{
		width: 100%;
		height: 7rem;
		background: -webkit-linear-gradient(#fff, #e2e2e2); 
        background: -o-linear-gradient(#fff, #e2e2e2); 
        background: -moz-linear-gradient#fff(, #e2e2e2); 
        background: linear-gradient(#fff, #ededed); 
        /*border-bottom: 2px red solid;*/
	}
	.vip_car_xx{
		width: 92%;
		height: 6rem;
		background: url(/tpl/Public/images/vip_bg.png) no-repeat;
		background-size: 100% 100%;
		margin-left: 4%;
		margin-top: 1rem;
		float: left;
		border-radius: 0.5rem 0.5rem 0 0;
		position: relative;
		
	}
	.vip_car_logo{
		width: 4rem;
		height: 4rem;
		border-radius: 3rem;
		margin-top: 1rem;
		margin-left: 1rem;
		float: left;
	}
	.vip_car_logo_name{
		width: 40%;
		height: 2.5rem;
		/*background: red;*/
		float: left;
		margin-top: 1rem;
		padding-left: 0.5rem;
		line-height: 2.5rem;
		font-size: 18px;
		font-weight: bold;
		color: #fff;
		
	}
	.vip_car_logo_rw{
		/*background: red;*/
		float: left;
		height: 1.5rem;
		line-height: 1rem;
		padding-left: 0.5rem;
		color: #fff;
		font-size: 14px;
	}
	.vip_car_hyxq{
		background: #cfa55d;
		float: right;
		height: 1.5rem;
		line-height: 1.5rem;
		display: inline-block;
		position: absolute;
		top: 1.75rem;
		right: 0rem;
		padding: 0 1rem;
		border-radius: 1.5rem 0 0 1.5rem;
		color: #997030;
	}
	.vip_car_hyjj{
		width: 100%;
		height: 3rem;
		background: rgba(255,255,255,.25);
		float: left;
		margin-top: 0.5rem;
		padding: 0 1rem;
		box-sizing: border-box;
	}
	.vip_car_hytq{
		height: 1.5rem;
		line-height: 1.5rem;
		
	}
	.vip_car_hytq span{
		width: 50%;
		height: 1.5rem;
		line-height: 1.5rem;
		display: inline-block;
		text-align: center;
		color: #997030;
	}
	.vip_car_yjsl span{
		text-align: center;
		/*background: red;*/
		display: inline-block;
		width: 50%;
		font-size: 16px;
		color: #fff;
	}
	.vip_xxjss{
		width: 92%;
		height: 6rem;
		margin: 0.5rem 4% 0;
	}
	.vip_xxjss li{
		width: 33.33%;
		height: 6rem;
		float: left;
	}
	.vip_tequan{
		width: 100%;
		height: 2rem;
		line-height: 2rem;
		font-size: 16px;
		font-weight: bold;
		padding: 0 0.5rem;
		box-sizing: border-box;
		text-align: left;
		float: left;
		margin-bottom: 0.25rem;
		text-align: center;
		margin: 0.5rem 0;
		
	}
	.vip_tequan span{
		width: 35%;
		height: 0.02rem;
		background: #ccc;
		display: inline-block;
		/*margin-top: 1rem;*/
		float: left;
		margin-top: 0.95rem;
	}
	.vip_tequan a{
		width: 60%;
		height: 2rem;
		display: inline-block;
		line-height: 2.2rem;
		color: #228aff;
	}
	.vip_xxjss li img{
		width: 4rem;
		height: 4rem;
		display: block;
		margin: 0.25rem auto;
	}
	.vip_xxjss li p{
		width: 100%;
		height: 2rem;
		margin-top: -01rem;
		text-align: center;
		line-height: 2rem;
		font-size: 14px;
		color: #febb35;
	}
	.vio_rwktlb{
		width: 92%;
		height: 8rem;
		margin-left: 4%;
	}
	.vio_rwktlb li{
		width: 30%;
		height: 7.5rem;
		border: 1px #f5f5f5 solid;
		border-radius: 0.5rem;
		float: left;
		box-sizing: border-box;
		margin-left: 2.5%;
		/*box-shadow: 0 1px 1px #228aff;*/
		
	}
	.vip_hylss{
		width: 100%;
		height: 2rem;
		line-height: 2rem;
		text-align: center;
		font-size: 16px;
		margin-top: 0.5rem;
		color: #000;
	}
	.vip_hyjg{
		width: 100%;
		height: 2rem;
		line-height: 2rem;
		text-align: center;
		font-size: 20px;
		font-weight: bold;
		margin-top: 0.5rem;
		color: #228aff;
	}
	.vip_hyjg span{
		font-size: 12px;
		font-weight: normal;
		margin-left: 0.25rem;
	}
	.vip_yuanjia{
		width: 100%;
		height: 2rem;
		line-height: 2rem;
		text-align: center;
		/*text-decoration:line-through;*/
		font-size: 12px;
		color:#a6a6a6;
	}
	.vio_rwktlb .active{
		width: 30%;
		height: 7.5rem;
		border: 1px #228aff solid;
		border-radius: 0.5rem;
		float: left;
		box-sizing: border-box;
		margin-left: 2.5%;
		background: #228aff;
	}
	.vio_rwktlb .active p{
		color: #fff;
	}
	.recharge_box{
		width: 84%;
		margin-left: 8%;
		height: 4rem;
		padding: 0;
		margin-bottom: 0;
	}
	.vip_lijisj{
		width: 84%;
		height: 2.5rem;
		background: #228aff;
		margin: 0.5rem 8%;
		border-radius: 0.5rem;
		color: #fff;
	}
</style>



<body style="background-color:#ffffff;">

<!-- 头部部分 开始 -->
                 
                 
        
        <div class="vip_car">
        	
        	<div class="vip_car_xx">
        		<img class="vip_car_logo" src="/tpl/Public/images/lo.jpg"/>
        		<p class="vip_car_logo_name">普通会员</p>
        		<p class="vip_car_logo_rw">每天可领取：2(任务)</p>
        		<a class="vip_car_hyxq" href="#">会员详情</a>
        		
        		
        		<!--<div class="vip_car_hyjj">
        			<p class="vip_car_hytq"><span>下级任务佣金</span> <span style="float: right;">下级会员佣金</span> </p>
        			<p class="vip_car_yjsl"><span>10%</span> <span style="float: right;">20%</span> </p>
        		</div>-->
        		
        		
        	</div>
        	
        	
        	
        	
        	
        	
        </div>
        
        
        <div class="vip_xxjss">
        	<ul>
        		<li>
        			<img src="/tpl/Public/images/v1.png"/>
        			<p>佣金加成</p>
        		</li>
        		
        		<li>
        			<img src="/tpl/Public/images/v2.png"/>
        			<p style="color: #e65a69;">任务增多</p>
        		</li>
        		
        		<li>
        			<img src="/tpl/Public/images/v3.png"/>
        			<p style="color: #33cdf8;">专属客服</p>
        		</li>
        		
        	</ul>
        </div>
        
        <form id="form1" class="" data-callback="1" name="form1" method="post" action="<?php echo U('vip');?>" >
        	
        	<input type="hidden" name="price" id="price" value="" />
        <input type="hidden" name="level" id="level" value="" />
        	
        <div class="vio_rwktlb" id="vip_sel">
        	<!--<p class="vip_tequan">  <a href="#">抖个赞会员开通</a></p>-->
        	<ul>
        		
        		<?php if(is_array($member_level)): $i = 0; $__LIST__ = $member_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="sub <?php if($vo['level'] > $member['level']): ?>lv<?php endif; ?>" data-id="<?php echo ($vo["level"]); ?>" data-price="<?php echo ($vo["price"]); ?>" >
        			<p class="vip_hylss"><?php echo ($vo["name"]); ?></p>
        			<p class="vip_hyjg"><?php echo ($vo["price"]); ?><span>元</span></p>
        			<p class="vip_yuanjia">会员永久有效</p>
        		</li><?php endforeach; endif; else: echo "" ;endif; ?>
        		
        	</ul>
        </div>
        
        

        
        
        
        <div class="recharge_box" style="margin-top: 0;border-top: 0; padding-bottom: 40px;">
                <input type="hidden" name="payment_type" id="payment_type" value="">
                <!--<p>选择支付方式：</p>-->
                <label data-key="alipay">
                    <i class="alipay"></i> 支付宝支付 <span></span>
                </label>
                <label data-key="wxpay">
                    <i class="wxpay"></i> 微信支付 <span></span>
                </label>
            </div>
        
        <button type="submit" id="submit" class="vip_lijisj">立即升级<span id="show_price_1"></span></button>
        
        </form>























  
  
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
						<img src="/tpl/Public/images/user_a.png" />
						<p style="color: #b5b5b5;font-size: 12px;">我的</p>
					</li>
				</a>
		
			</ul>
		</footer>

</body>

</html>



<script>
    $(document).ready(function(){
        $('.recharge_box label').click(function(){
            $('.recharge_box label span').removeClass('active');
            $(this).find('span').addClass('active');
            var payment_type = $(this).attr('data-key');
            $('#payment_type').val(payment_type);
        });

        $('#vip_sel .sub.lv').click(function(){
            var price = $(this).attr('data-price');
            var level = $(this).attr('data-id');
            $(this).addClass('active').siblings().removeClass('active');
            $('#show_price_1').html("（￥" +price+"）");
            $('#price').val(price);
            $('#level').val(level);
        });

        $('#submit').click(function(){
            var payment_type = $('#payment_type').val();
            var level = $('#level').val();

            if( level == '' ) {
                sp_tip('请选择要升级的级别.');
                return false;
            }
            if( payment_type == '' ) {
                sp_tip('请选择支付渠道.');
                return false;
            }
        })
        $('#form1').submit();
    });

    function submit_callback(data){
        if( data.status == 1 ) {
            window.location.href = data.url;
        } else {
            sp_tip(data.info);
        }
    }
</script>