<?php if (!defined('THINK_PATH')) exit(); $title = "修改密码";?>
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
    <!-- 头部部分 开始 -->
    <!-- 主体部分 开始 -->
    <div class="body_main mt" style="margin-top: 0;">
        <form class="submit-ajax" action="<?php echo U('password');?>">
            <div class="form_reg">
                <p>
                    <input type="password" name="old_password" id="old_password" placeholder="请输入当前密码" class="input-text" />
                </p>
                <p>
                    <input type="password" name="password" id="password" placeholder="请输入新密码" class="input-text" />
                </p>
                <p class="code-box">
                    <input type="password" name="repassword" id="repassword" placeholder="请再次输入新密码" class="input-text" />
                </p>
            </div>
            <div class="reg_btn">
                <button type="submit" id="submit" class="" disabled>确认修改</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<script>
    $(function(){
        $('.input-text').keyup(function(){
            if( $('#phone').val() != '' && $('#password').val() != '' && $('#code').val() != '' ) {
                $('#submit').addClass('active');
                $('#submit').removeAttr("disabled");
            } else {
                $('#submit').removeClass('active');
                $('#submit').attr("disabled","disabled");
            }
        })
    });
</script>