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
                        <legend>订单列表</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <input type="text" id="ddh" placeholder="请输入订单号" class="layui-input">
                        </div>
                        <a class="layui-btn" onclick="search_Order()" lay-filter="search_user"><i class="layui-icon">&#xe615;</i></a>
                    </div>
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
            ,url:'/Mao_admin/api.php?mod=list_dindan'
            ,page:true
            ,cols: [[
                {field:'id',title: 'ID', width:80}
				,{field:'mid',title: 'M_id', width:80}
                ,{field:'ddh', title: '订单号', width:180}
                ,{field:'name', title: '商品名称'}
                ,{field:'sl', title: '购买数量', width:100}
                ,{field:'dj_price', title: '商品单价', width:100}
                ,{field:'yf_price', title: '商品运费', width:100}
                ,{field:'price', title: '总收入', width:100}
                ,{field:'time', title: '购买时间', width:180}
                ,{field:'zt', title: '订单状态', width:100}
                ,{field:'set', title: '操作', width:120}
            ]]
        });
        table.on('tool(list)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定要删除该订单?', {
                    btn: ['删除','取消']
                }, function(){
                    var loading = layer.load();
                    $.ajax({
                        url: '/Mao_admin/api.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            mod: "del_dindan",
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
    });
    function search_Order() {
        var table = layui.table;
        table.reload('list',
            {
                page: {curr: 1 }
                , where: { ddh: $('#ddh').val()}
                , url:'/Mao_admin/api.php?mod=list_dindan'
                , method: 'post'
            }
        );
    }
</script>
</body>
</html>