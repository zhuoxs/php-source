<?php if (!defined('THINK_PATH')) exit(); $title = "查看详情";?>
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
    <div class="title"><?php echo ($title); ?></div>
</header>
<div class="body_main mt">
    <div class="task_box">
        <div class="submission_task_form">
            <form>
                <input type="hidden" name="id" id="id" value="<?php echo ($apply_data["id"]); ?>">
                <div class="item">
                    <p class="t">任务名称：</p>
                    <p class="c"><?php echo ($apply_data["task_title"]); ?></p>
                </div>
                <div class="item">
                    <p class="t">任务金额：</p>
                    <p class="c">￥<?php echo (floatval($apply_data["price"])); ?></p>
                </div>
                <div class="item">
                    <p class="t">完成状态：</p>
                    <p class="c"><?php echo ($apply_data["apply_status"]); ?></p>
                </div>
                <div class="item">
                    <p class="t">最后更新：</p>
                    <p class="c"><?php echo (date('Y-m-d H:i',$apply_data["update_time"])); ?></p>
                </div>
                <div class="item">
                    <p class="c">
                        <?php if($apply_data['status'] == 0): ?>未提交任务，<a href="<?php echo U('Task/submission_task_do',array('id'=>$apply_data['id']));?>" style="color: #6b3535;text-decoration: underline;">去提交</a>
                        <?php else: ?>
                            <img id="image" src="<?php echo (sp_img($apply_data["file"])); ?>" alt="" style="max-width: 100%" ><?php endif; ?>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>


</body>
</html>