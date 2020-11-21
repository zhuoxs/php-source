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
                        <legend>添加分站</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <blockquote class="layui-elem-quote">添加分站会扣除后台余额,默认开通一个月。</blockquote>
                    <hr>
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">网站标题</label>
                            <div class="layui-input-block">
                                <input type="text" id="title" autocomplete="off" placeholder="如：某某商城" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">管理员帐号</label>
                            <div class="layui-input-block">
                                <input type="text" id="user" autocomplete="off" placeholder="" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">管理员密码</label>
                            <div class="layui-input-block">
                                <input type="text" id="pass" autocomplete="off" placeholder="" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">网站域名</label>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <input type="text" id="qz" placeholder="自定义前缀" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid"> - </div>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <select id="type">
                                        <option value="">请选择后缀</option>
                                        <option value="1"><?php echo $houzhui?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <button class="layui-btn site-demo-layedit" onclick="add()"><i class="layui-icon">&#xe61f;</i> 添 加 分 站</button>
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

    });
    function add() {
        var loading = layer.load();
        $.ajax({
            url: '/Mao_admin/api.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mod: "add_sub",
                title: $('#title').val(),
                user: $('#user').val(),
                pass: $('#pass').val(),
                qz: $('#qz').val(),
                type: $('#type').val()
            },
            success: function (a) {
                layer.close(loading);
                if (a.code == 0) {
                    layer.msg(a.msg);
                }else {
                    layer.msg(a.msg);
                }
            },
            error: function() {
                layer.close(loading);
                layer.msg('~连接服务器失败！', {icon: 5});
            }
        });
    }
</script>
</body>
</html>