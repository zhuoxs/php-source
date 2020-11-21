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
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    <fieldset class="layui-elem-field layui-field-title">
                        <legend>商品列表</legend>
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
            ,url:'/Mao_admin/api.php?mod=list_commodity'
            ,page:true
            ,cols: [[
                {field:'id',title: 'ID', width:80}
                ,{field:'name', title: '商品名称', width:120}
                ,{field:'img', title: '商品图片'}
                ,{field:'type', title: '所属分类', width:100}
                ,{field:'tj', title: '是否推荐', width:100}
                ,{field:'price', title: '商品价格', edit: 'text', width:100}
                ,{field:'yf_price', title: '商品运费', edit: 'text', width:100}
                ,{field:'kucun', title: '当前库存', edit: 'text', width:100}
                ,{field:'xiaoliang', title: '商品销量', edit: 'text', width:100}
                ,{field:'slxd', title: '数量下单', width:100}
                ,{field:'rwzl', title: '入网资料', width:100}
                ,{field:'shangjia', title: '是否上架', width:100}
                ,{field:'set', title: '操作', width:120}
            ]]
        });
        form.on('switch(tj)', function(data){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    mod: "tj_commodity",
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
        form.on('switch(slxd)', function(data){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    mod: "slxd_commodity",
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
        form.on('switch(rwzl)', function(data){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    mod: "rwzl_commodity",
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
        form.on('switch(shangjia)', function(data){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    mod: "shangjia_commodity",
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
        table.on('tool(list)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定要删除该商品?<br/>删除之后此商品旗下订单可能会访问异常,建议下架处理！', {
                    btn: ['删除','取消']
                }, function(){
                    var loading = layer.load();
                    $.ajax({
                        url: '/Mao_admin/api.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            mod: "del_commodity",
                            id: data.id
                        },
                        success: function (a) {
                            layer.close(loading);
                            if (a.code == 0) {
                                layer.msg(a.msg, function() {
                                    obj.del();
                                    layer.close(index);
                                });
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
            }
        });
        table.on('edit(list)', function(obj){
            var value = obj.value
                ,data = obj.data
                ,field = obj.field;
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    mod: "xiugai_commodity",
                    id: data.id,
                    type: field,
                    value: value
                },
                success: function (a) {
                    layer.close(loading);
                    if (a.code == 0) {
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