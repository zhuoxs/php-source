<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"D:\phpStudy\PHPTutorial\WWW/application/admin\view\collect\union.html";i:1551919886;s:67:"D:\phpStudy\PHPTutorial\WWW\application\admin\view\public\head.html";i:1522628860;s:67:"D:\phpStudy\PHPTutorial\WWW\application\admin\view\public\foot.html";i:1526021730;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?> - 苹果CMS</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/admin_style.css">
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/layui/layui.js"></script>
    <script>
        var ROOT_PATH="",ADMIN_PATH="<?php echo $_SERVER['SCRIPT_NAME']; ?>", MAC_VERSION='v10';
    </script>
</head>
<body>

<div class="page-container p10">

    <div class="my-toolbar-box">
        <div class="layui-btn-group">
            <?php if($collect_break_vod != ''): ?>
            <a href="<?php echo url('load'); ?>?flag=vod" class="layui-btn layui-btn-danger ">【进入视频断点采集】</a>
            <?php endif; if($collect_break_art != ''): ?>
            <a href="<?php echo url('load'); ?>?flag=art" class="layui-btn layui-btn-danger ">【进入文章断点采集】</a>
            <?php endif; ?>
            </div>
    </div>
    <hr>

    <script src="//www.maccms.com/union/xmlutf_2014.js?t=<?php echo time(); ?>" charset="utf-8"></script>

</div>

<script type="text/javascript" src="/static/js/admin_common.js"></script>
<script type="text/javascript">
    layui.use(['laypage', 'layer'], function() {
        var laypage = layui.laypage
                , layer = layui.layer;


    });
</script>
</body>
</html>