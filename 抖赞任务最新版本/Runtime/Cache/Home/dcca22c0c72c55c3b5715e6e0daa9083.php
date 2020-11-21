<?php if (!defined('THINK_PATH')) exit(); $title = "我的团队";?>
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
<div id="body">
    <div class="body_main mt" style="margin-top: 0;">
        <!-- 头部部分 开始 -->
        <!--主体部分 开始-->
        <div class="team_tab">
            <ul>
                <li <?php if($rank == '1'): ?>class="current"<?php endif; ?> ><a href="<?php echo U('team',array('rank'=>1));?>">一级团队<label><?php echo ($count_1); ?>人</label></a></li>
                <li <?php if($rank == '2'): ?>class="current"<?php endif; ?> ><a href="<?php echo U('team',array('rank'=>2));?>">二级团队<label><?php echo ($count_2); ?>人</label></a></li>
            </ul>
        </div>
        <div class="team_con">
            <ul class="team_list">
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <p class="p1"><?php echo ($vo["username"]); ?> <?php if($vo['level'] > 0): ?><span style="color: orange;">(<?php echo ($vo["level_name"]); ?>)</span><?php endif; ?> </p>
                        <p class="p2" style="color: #999;"><?php echo (date("Y-m-d",$vo["create_time"])); ?></p>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>

                <?php if($count == 0): ?><li>
                        暂无信息
                    </li><?php endif; ?>
            </ul>
            <br>
            <?php echo ($Page); ?>
        </div>
    </div>
</div>
</body>
</html>