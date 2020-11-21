<?php if (!defined('THINK_PATH')) exit(); $title = "申请提现";?>
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
<div id="body">
    <!-- 头部部分 开始 -->
    <!--主体部分 开始-->
    <div class="body_main mt" style="margin-top: 0;">
        <div class="tixian_box">
            <form id="form1" class="submit-ajax" action="<?php echo U('tixian');?>" method="post">

                <?php if(empty($data['bank_name']) || empty($data['bank_user']) || empty($data['bank_number']) ): ?><div class="card no">
                        <a href="<?php echo U('Member/info_edit',array('field'=>'bank_number','f'=>'tixian'));?>">
                            <h5>请选完善银行卡信息</h5>
                        </a>
                    </div>

                <?php else: ?>
                    <div class="card">
                        <a href="<?php echo U('Member/info_edit',array('field'=>'bank_number','f'=>'tixian'));?>">
                            <h5><?php echo ($data["bank_name"]); ?></h5>
                            <p>开户人:<?php echo ($data["bank_user"]); ?> &nbsp; 尾号:<?php echo ($data["bank_number_last"]); ?> </p>
                        </a>
                    </div><?php endif; ?>

                <div class="con">
                    <div class="t">提现金额</div>
                    <div class="p">
                        <input type="text" name="price" value="" placeholder="">
                    </div>
                    <div class="info">可用余额 <?php echo ($data["price"]); ?>元 </div>
                </div>

                <div class="b">
                    <button class="btn_type btn_tx">确定</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>