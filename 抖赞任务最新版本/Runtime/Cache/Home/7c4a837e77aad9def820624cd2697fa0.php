<?php if (!defined('THINK_PATH')) exit(); $title = "修改地址";?>
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
<!-- 头部部分 开始 -->
<header class="top_header">
    <div class="left"><a href="javascript:" data-url="<?php echo U('info');?>" class="return go-back"></a></div>
    <div class="title"><?php echo ($title); ?></div>
</header>
<div class="mt">
    <section class="with-main">
        <form class="submit-ajax" data-callback="1" id="form1" name="form1" method="post" action="<?php echo U('info_edit');?>">
            <input type="hidden" name="f" value="<?php echo ($_GET['f']); ?>">
            <div class="search address">
                <style>
                    .address select{width: 100%;float: left;height: 40px;-webkit-box-sizing: border-box;
                        -moz-box-sizing: border-box;
                        box-sizing: border-box;
                        border-radius: 5px;
                        border: 1px #ccc solid;}
                </style>
                <?php echo W('Area/index',array($city_ids['0'],$city_ids['1'],$city_ids['2'],'selectArea'));?>
            </div>
            <div class="search">
                <input type="hidden" name="field" value="<?php echo ($field); ?>">
                <input style="width: 100%; height: 40px; line-height: 40px;" type="text" name="value" value="<?php echo ($value); ?>" placeholder="<?php echo ($info); ?>">
            </div>
            <div class="btn">
                <button type="submit">确定</button>
            </div>
        </form>
    </section>
</div>

</body>
</html>

<script>
    $(function(){
        $('.btn_small').click(function(){
            $('#form1').submit();
        })

    })

    function submit_callback(data){
        if( data.status == 1 ) {
            window.location.href = data.url;
        } else {
            sp_tip(data.info);
        }
    }
</script>