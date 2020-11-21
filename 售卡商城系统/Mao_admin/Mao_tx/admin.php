<?php
require '../../Mao/common.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='login.php';</script>");
if( $_SERVER['HTTP_REFERER'] == "" || $mao['id'] != 1){
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
                        <legend>提现管理</legend>
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
    }).use(['index','table','form'], function(){
        var table = layui.table,
            form = layui.form;
        table.render({
            elem: '#list'
            ,url:'/Mao_admin/api.php?mod=list_tx_admin'
            ,page:true
            ,cols: [[
                {field:'id',title: 'ID', width:80}
                ,{field:'mid', title: 'M_id', width:100}
                ,{field:'zh', title: '提现帐号', width:200}
                ,{field:'sm', title: '帐号实名', width:100}
                ,{field:'price', title: '提现金额', width:100}
                ,{field:'time', title: '提现时间', width:200}
                ,{field:'zt', title: '是否已提现', width:150}
            ]]
        });
        form.on('switch(zt)', function(data){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    mod: "tx_set",
                    id: data.value
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
        });
    });
</script>
</body>
</html>