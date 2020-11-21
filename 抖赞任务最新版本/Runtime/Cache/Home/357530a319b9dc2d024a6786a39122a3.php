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
<script type="text/javascript" src="/tpl/Public/js/clipboard.min.js"></script>
<body class="show_bg">
	
	
	<div class="show_top_o">
		
		<!--logo-->
		
		<div class="show_top_logo">
			<img src="/tpl/Public/images/eee.png"/>
			<div class="index_btswz" style="margin-left: 0;width: 50%;">
					<p class="index_bta"><?php echo ($show["title"]); ?></p>
					<p class="index_tag"> <span>优质任务</span> <span>抖音ex</span> </p>
				</div>
				<p class="show_yj">+<?php echo (floatval($show["price"])); ?>元</p>
		</div>
		
		<p class="show_rwlq">亲，请严格按照任务要求做任务哟！</p>
		
		<!--logo结束-->
		
		<a class="show_lqjl" href="<?php echo ($show["info"]); ?>">复制并前往抖音APP <span>>点赞或评论</span>  <span>>上传截图并领奖励</span>   </a>
	</div>
	
	
	<div class="show_rwxq">
		<img src="http://ae01.alicdn.com/kf/HTB1DKieXeT2gK0jSZFvq6xnFXXah.jpg"/>
	</div>
	
	
	
	
	
	
	<div class="show_rwxf">

            <?php if($btn_status == 1): ?><button type="button" class="bala-btn get_task" style="background: #098eff;border: none;float: left;"><?php echo ($status_text); ?></button>
            <?php else: ?>
                <button type="button" class="bala-btna" disabled><?php echo ($status_text); ?></button><?php endif; ?>


        </div>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

<!-- 底部联系部分 开始 -->

</body>
</html>

<script>
    //复制文案
    var clipboard = new ClipboardJS('.copy');
    clipboard.on('success', function(e) {
        sp_alert('复制成功');
    });

    clipboard.on('error', function(e) {
        sp_alert('复制信息出错，请手动复制');
    });

    //领取任务
    $('.get_task').click(function(){
        var task_id = "<?php echo ($show["id"]); ?>";
        var url = "<?php echo U('get_task');?>";
        $.post(url,{id:task_id},function(data){
            if( data.status == 1 ) {
                sp_alert(data.info);
                $('.bala-btn').css('background-color','#ccc').html('任务已领取');
            } else {
                sp_alert(data.info);
            }
        },'json')
    })

    function save_img(){
        var http_host = "http://<?php echo $_SERVER['HTTP_HOST']?>";
        var num = 0;
        $(".content img").each(function(){
            num = num+1;
            var img_path = $(this).attr("src");
            if( img_path.indexOf('http') == -1 ) {
                img_path = http_host+img_path;
            }
            lbuilder.Native.saveImage(img_path, function(message){

            }, function(err){
                sp_alert("save fail"+err);
            })
        });

        sp_alert('图片已经保存到相册，数量（'+num+'张）');

        //保存图片到相册
        /*lbuilder.Native.saveImage(img, function(message){
            sp_alert('二维码已经保存到相册');
        }, function(err){
            sp_alert("save fail"+err);
        });*/
    }

    function test(){
        //保存图片到相册
        /*lbuilder.Native.saveImage("http://www.lbuilder.com/index/assets/images/logo.png", function(message){
            alert("save success");
        }, function(err){
            alert("save fail"+err);
        });*/


        Wechat.share({
            message: {
                title: "Hi, here",
                description: "That is description.",
                thumb: "http://bb.szwangyesheji.com/tpl/Public/images/banner.png",
                mediaTagName: "TEST-TAG-002",
                messageExt: "这是第三方带的测试字段ddd",
                messageAction: "<action>dotalist</action>",
                media: {
                    type: Wechat.Type.WEBPAGE,
                    webpageUrl: "http://bb.szwangyesheji.com/"
                }
            },
            scene: Wechat.Scene.TIMELINE   // share to Timeline
        }, function (data) {
            alert("Success"+JSON.stringify(data));
        }, function (reason) {
            alert("Failed: " + JSON.stringify(reason));
        });

        /*Wechat.share({
            message: {
                title: "Hi, there",
                description: "This is description.",
                thumb: "http://bb.szwangyesheji.com/tpl/Public/images/banner.png",
                mediaTagName: "TEST-TAG-001",
                messageExt: "这是第三方带的测试字段",
                messageAction: "<action>dotalist</action>",
                media:{
                    type:  Wechat.Type.IMAGE,
                    image: "http://bb.szwangyesheji.com/tpl/Public/images/banner.png"
                }
            },
            scene: Wechat.Scene.TIMELINE   // share to Timeline
        }, function (data) {
            alert("Success"+JSON.stringify(data));
        }, function (reason) {
            alert("Failed: " + JSON.stringify(reason));
        });*/

    }
</script>