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
                        <legend>分站列表</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="list" lay-filter="list"></table>
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
    }).use(['index','table'], function(){
        var table = layui.table;
        table.render({
            elem: '#list'
            ,url:'/Mao_admin/api.php?mod=list_sub'
            ,page:true
            ,cols: [[
                {field:'id',title: 'ID', width:80}
                ,{field:'title', title: '网站名称', width:200}
                ,{field:'user', title: '所属用户', width:180}
                ,{field:'url', title: '网站域名', width:180}
                ,{field:'price', title: '后台余额', width:100}
                ,{field:'time', title: '到期时间', width:180}
                ,{field:'set', title: '操作', width:150}
            ]]
        });
    });
    function jk(id) {
        layer.prompt({title: '[M_id:'+id+']加款', formType: 0}, function(price, index){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    mod: 'jiakuan_sub',
                    id: id,
                    price: price
                },
                success: function (a) {
                    layer.close(loading);
                    if(a.code == 0){
                        layer.msg(a.msg, function() {
                            window.location.reload();
                        });
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
    }
    function xf(id) {
        layer.prompt({title: '[M_id:'+id+']续费单位/月', formType: 0}, function(time, index){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    mod: 'xufei_sub',
                    id: id,
                    time: time
                },
                success: function (a) {
                    layer.close(loading);
                    if(a.code == 0){
                        layer.msg(a.msg, function() {
                            window.location.reload();
                        });
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
    }
</script>
</body>
</html>