<?php
require '../../Mao/common.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='login.php';</script>");
if( $_SERVER['HTTP_REFERER'] == "" ){
    exit('404');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $mao['title']?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../css/admin.css" media="all">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md2"></div>
        <div class="layui-col-md8">
            <div class="layui-card">
                <div class="layui-card-header">
                    <fieldset class="layui-elem-field layui-field-title">
                        <legend>短信配置</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <blockquote class="layui-elem-quote">每条短信会扣取后台余额0.01元,余额不足时不会发送~</blockquote>
                    <hr>
                    <form class="layui-form" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">用户下单</label>
                            <div class="layui-input-inline">
                                <input type="checkbox" <?php if($mao['dx_1'] == 0){ echo 'checked=""';}else{}?> name="open" lay-skin="switch" lay-filter="switchTest" lay-text="关闭|开启" value="1">
                            </div>
                            <div class="layui-form-mid layui-word-aux">用户下单通知站长</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">发货通知</label>
                            <div class="layui-input-inline">
                                <input type="checkbox" <?php if($mao['dx_2'] == 0){ echo 'checked=""';}else{}?> name="open" lay-skin="switch" lay-filter="switchTest" lay-text="关闭|开启" value="2">
                            </div>
                            <div class="layui-form-mid layui-word-aux">发货通知用户</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">用户工单</label>
                            <div class="layui-input-inline">
                                <input type="checkbox" <?php if($mao['dx_3'] == 0){ echo 'checked=""';}else{}?> name="open" lay-skin="switch" lay-filter="switchTest" lay-text="关闭|开启" value="3">
                            </div>
                            <div class="layui-form-mid layui-word-aux">用户提交工单通知站长</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">工单处理</label>
                            <div class="layui-input-inline">
                                <input type="checkbox" <?php if($mao['dx_4'] == 0){ echo 'checked=""';}else{}?> name="open" lay-skin="switch" lay-filter="switchTest" lay-text="关闭|开启" value="4">
                            </div>
                            <div class="layui-form-mid layui-word-aux">工单处理通知用户</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../layui/layui.js"></script>
<script>
    layui.config({
        base: '../' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','form'], function(){
        var form = layui.form;
        form.on('switch(switchTest)', function(data){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {mod: 'dx', type: this.value},
                success: function (a) {
                    layer.close(loading);
                    if(a.code == 0){
                        layer.msg(a.msg);
                    } else {
                        layer.msg(a.msg);
                    }
                },
                error: function() {
                    layer.close(loading);
                    layer.msg('~连接服务器失败！', {icon: 5});
                }
            });
        });
    });
</script>
</body>
</html>