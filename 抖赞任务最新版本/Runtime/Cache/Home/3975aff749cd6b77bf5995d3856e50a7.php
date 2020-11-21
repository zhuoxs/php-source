<?php if (!defined('THINK_PATH')) exit(); $title = "任务记录";?>
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

<body class="gray_bg">
<!-- 头部部分 开始 -->
<header class="top_header">
    <div class="left"><a href="javascript:" class="return go-back"></a></div>
    <div class="title">提交任务</div>
</header>

<!--主体部分 开始-->
<div class="body_main mt tline">
    <div class="apply_list">
        <!--<div class="apply_nav">
            <span class="active">
                <a href="">供应信息</a>
            </span>
            <span>
                <a href="">需求信息</a>
            </span>
        </div>-->
        <?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item">
                    <a href="<?php echo U('apply_show',array('id'=>$vo['id']));?>">
                        <h6><?php echo ($vo["title"]); ?> <span class="status<?php echo ($vo["status"]); ?>"><?php echo $apply_status[$vo['status']];?></span></h6>
                        <p>任务收益：￥<?php echo (floatval($vo["price"])); ?></p>
                        <p>申请时间：<?php echo (date("Y-m-d",$vo["create_time"])); ?></p>
                    </a>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php else: ?>
            <div class="none">
                <div class="none_box">
                    <img src="/tpl/Public/images/none.png" alt="">
                    <span>暂无信息</span>
                </div>
            </div><?php endif; ?>
    </div>
    <?php echo ($Page); ?>
</div>


</body>
</html>