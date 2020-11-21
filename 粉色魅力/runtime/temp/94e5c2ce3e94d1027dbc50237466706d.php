<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"/www/wwwroot/ys01.testx.vip/application/admin/view/database/sql.html";i:1517368472;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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

<div class="page-container">
    <form class="layui-form layui-form-pane" action="">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">执行sql语句</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">

                    <div class="layui-input-block" >
                    <blockquote class="layui-elem-quote layui-quote-nm">
                        常用语句对照：<br>
                        1.查询数据
                        SELECT * FROM {pre}vod   查询所有数据<br>
                        SELECT * FROM {pre}vod WHERE vod_id=1000   查询指定ID数据
                        <br>
                        2.删除数据
                        DELETE FROM {pre}vod   删除所有数据<br>
                        DELETE FROM {pre}vod WHERE vod_id=1000   删除指定的第几条数据<br>
                        DELETE FROM {pre}vod WHERE vod_actor LIKE '%刘德华%'   vod_actor"刘德华"的数据
                        <br>
                        3.修改数据
                        UPDATE {pre}vod SET vod_hits=1   将所有vod_hits字段里的值修改成"1"<br>
                        UPDATE {pre}vod SET vod_hits=1 WHERE vod_id=1000  指定的第几条数据把vod_hits字段里的值修改成"1"
                        <br>
                        4.替换图片地址
                        UPDATE {pre}vod SET vod_pic=REPLACE(vod_pic, '原始字符串', '替换成其他字符串')
                        <br>
                        5.清空数据ID重新从1开始
                        TRUNCATE {pre}vod
                    </blockquote>
                    </div>

                <div class="layui-form-item">
                    <div class="layui-input-block" >
                        <textarea name="sql" class="layui-textarea" rows="10" placeholder="请输入sql语句" ></textarea>
                    </div>
                </div>

            </div>
            </div>
        </div>
        <div class="layui-form-item center">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">确认执行</button>
                <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="/static/js/admin_common.js"></script>
<script type="text/javascript">

</script>

</body>
</html>