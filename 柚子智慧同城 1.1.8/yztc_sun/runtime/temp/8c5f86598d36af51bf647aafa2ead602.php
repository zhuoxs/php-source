<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:95:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/corder/panicorder.html";i:1553823396;s:93:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/baselist.html";i:1553823406;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layui</title>
    <link rel="stylesheet" href="/addons/yztc_sun/public/static/bower_components/layui/src/css/layui.css">
    <script src="/addons/yztc_sun/public/static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/addons/yztc_sun/public/static/bower_components/layui/src/layui.js"></script>

    <link href="/addons/yztc_sun/public/static/bower_components/select2/dist/css/select2.css" rel="stylesheet" />
    <script src="/addons/yztc_sun/public/static/custom/pinyin.js"></script>

    <link href="/web/resource//css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="/web/resource//css/font-awesome.min.css" rel="stylesheet">-->
    <script src="/web/resource//js/app/util.js"></script>
    <script>var require = { urlArgs: 'v=20161011' };</script>
    <script src="/web/resource//js/require.js"></script>
    <script src="/web/resource//js/app/config.js"></script>
    <script>
        // requireConfig.baseUrl = "/web/resource/js/app";
        requireConfig.paths.select2 = "/addons/yztc_sun/public/static/bower_components/select2/dist/js/select2";
        require.config(requireConfig);

        require(['select2','bootstrap'], function () {
            $.fn.select2.defaults.set("matcher",function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (data.keywords && data.keywords.indexOf(params.term) > -1 || data.text.indexOf(params.term) > -1) {
                    return data;
                }
                return null;
            });
        });
    </script>

    <style>
        body{
            min-width: 0px !important;
        }
        /*修改列表页面样式*/
        .tool-box{
            margin-top: 10px;
            padding: 6px;
            background: #fff;
            border: 1px #ddd solid;
            border-radius: 3px;
        }
        /*laytable 选中样式*/
        .layui-table-check{
            background-color: #e0f7de;
        }
        .select2 .select2-selection{
            height: 38px;
            border-radius: 2px;
            /*border-color: rgb(230,230,230);*/
        }
        .select2 .select2-selection__rendered{
            line-height: 38px!important;
        }
        .select2 .select2-selection__arrow{
            height: 36px!important;
        }
    </style>
</head>
<body class="layui-layout-body" style="background-color: #f2f2f2">
<div class="layui-layout layui-layout-admin">
    <div style="padding: 15px;">
        <script type="text/javascript">
            //JavaScript代码区域
            layui.use(['element','table','form'], function(){
                var element = layui.element;
                var table = layui.table;
                var form = layui.form;
                //        搜索
                $('#btnSearch').click(function () {
                    //执行重载
                    table.reload('laytable', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            key: $('#key').val(),
                        }
                    });
                });
                $('#key').on('keypress', function (e) {
                    if (e.keyCode == 13){
                        //执行重载
                        table.reload('laytable', {
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                            ,where: {
                                key: $('#key').val(),
                            }
                        });
                    }
                })
                //        排序
                table.on('sort', function(obj){
                    table.reload('laytable', {
                        initSort: obj,
                        where: {
                            orderfield: obj.field,
                            ordertype:obj.type
                        },
                        page: {
                            curr: 1 //重新从第 1 页开始
                        },
                    });
                });
                //更新选中状态
                function updateCheckStyle() {
                    var className = "layui-table-check";//"layui-bg-green"
                    $('.layui-table .laytable-cell-checkbox .layui-form-checkbox:not(\'.layui-form-checked\')').parents('tr[data-index]').each(function (i, e) {
                        var $this = $(e);
                        var index = $this.data('index');
                        var $table = $this.parents('.layui-table-view');
                        $('tr[data-index='+index+']',$table).removeClass(className);
                    });
                    $('.layui-table .laytable-cell-checkbox .layui-form-checkbox.layui-form-checked').parents('tr[data-index]').each(function (i, e) {
                        var $this = $(e);
                        var index = $this.data('index');
                        var $table = $this.parents('.layui-table-view');
                        $('tr[data-index='+index+']',$table).addClass(className);
                    })
                }
                //		选中样式 - 单选
                table.on('radio', function(obj){
                    updateCheckStyle();
                });
                //		选中样式 - 多选
                table.on('checkbox', function(obj){
                    var data = obj.data;
                    updateCheckStyle();
                });

                //		选中逻辑
                //		行点击选中
                //		ctrl 多选
                //		拖拉区域选中切换
                var begin_index = 0;
                var begin_clientX = 0;
                var begin_clientY = 0;
                $(document).on('mousedown','.layui-table-body tr', function (e) {
                    begin_index = $(this).data('index');
                    begin_clientX = e.clientX;
                    begin_clientY = e.clientY;
                })
                $(document).on('mouseup','.layui-table-body tr', function (e) {
                    var $table = $(this).parents('.layui-table-view');
                    var end_index = $(this).data('index');
                    var end_clientX = e.clientX;
                    var end_clientY = e.clientY;
                    //          同一行，点击位置不同--说明是在选择文本
                    if (end_index == begin_index && (end_clientX != begin_clientX || end_clientY != begin_clientY)){
                        return false;
                    }
                    //          同一行，点击位置一样--说明是单击
                    if (end_index == begin_index && end_clientX == begin_clientX && end_clientY == begin_clientY){
                        //              点击的是按钮/单选框/多选框/输入框
                        if ($(e.target).parents('.layui-form-switch,.laytable-cell-checkbox,.laytable-cell-radio,.layui-btn,[data-edit=true]').length || $(e.target).is('.layui-btn')){
                            return false;
                        }
                        $('.layui-table-body tr[data-index='+end_index+'] .layui-form-radio:last',$table).click();
                    }

                    if (window.getSelection){
                        window.getSelection().removeAllRanges();
                    }else{
                        document.selection.empty();
                    };

                    // 如果没按住 ctrl 则清空其他选中
                    if (!e.ctrlKey){
                        $('tr[data-index]',$table).each(function (i, e) {
                            var $this = $(e);
                            $('.layui-form-checkbox.layui-form-checked:first',$this).click();
                        })
                        $('.layui-table-main .laytable-cell-checkbox .layui-form-checkbox.layui-form-checked',$table).click();
                    }
                    $('tr[data-index]',$table).each(function (i, e) {
                        var $this = $(e);
                        var index = $this.data('index');
                        if ((index>= begin_index && index<= end_index) || (index<= begin_index && index>= end_index)){
                            $('.layui-form-checkbox:first',$this).click();
                        }
                    })
                    return false;
                })

                // 批量删除
                $('#btnBatchDelete').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    var name=$('#modelName').val();
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        layer.confirm('即将删除 '+data.length+' 条记录', {
                            btn: ['确定','取消'] //按钮
                        }, function(){
                            var url = "<?php echo adminurl('delete'); ?>&modelName="+name;
                            $.post(url, {ids:ids.join(',')}, function(data){
                                if (typeof data == 'string'){
                                    data = $.parseJSON(data);
                                }
                                if (data.code == 0) {
                                    layer.msg('删除成功',{icon: 6,anim: 6});
                                    table.reload('laytable',{});
                                }else{
                                    layer.msg(data.msg,{icon: 5,anim: 6});
                                }
                            });
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                // 删除
                $(document).on('click','.btnDelete',function(e){
                    var id = $(this).data('id');
                    var name=$('#modelName').val();
                    layer.confirm('即将删除 1 条记录', {
                        btn: ['确定','取消'] //按钮
                    }, function(){
                        var url = "<?php echo adminurl('delete'); ?>&modelName="+name;
                        $.post(url, {ids:id}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('删除成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    });
                    return false;
                })
                // 新增
                $('#btnAdd').click(function () {
                    var name=$('#modelName').val();
                    // var urlname='add'+name;
                    // var url1 = "<?php echo adminurl('url'); ?>";
                    // var url = url1.replace("url",urlname);
                    var index = layer.open({
                        type: 2,
                        title: '新增',
                        shadeClose: true,
                        shade: false,
                        maxmin: true, //开启最大化最小化按钮
                        area: ['893px', '600px'],
                        content:  "<?php echo adminurl('add'); ?>&modelName="+name,
                    });
                    layer.full(index);
                    return false;
                })
                // 编辑
                $(document).on('click','.btnEdit',function(e){
                    var id = $(this).data('id');
                    var name=$('#modelName').val();
                    var index = layer.open({
                        type: 2,
                        title: '编辑',
                        shadeClose: true,
                        shade: false,
                        maxmin: true, //开启最大化最小化按钮
                        area: ['893px', '600px'],
                        content: "<?php echo adminurl('edit'); ?>&id="+id+"&modelName="+name,
                    });
                    layer.full(index);
                    return false;
                })
                // 查看
                function see(e) {
                    var id = $(this).data('id')
                    var index = layer.open({
                        type: 2,
                        title: '查看',
                        shadeClose: true,
                        shade: false,
                        maxmin: true, //开启最大化最小化按钮
                        area: ['893px', '600px'],
                        content: "<?php echo adminurl('see'); ?>&id="+id,
                    });
                    layer.full(index);
                    return false;
                }
                $(document).on('click','.btnSee',see);
                // 复制新增
                $(document).on('click','.btnCopy',function(e){
                    var id = $(this).data('id')
                    var index = layer.open({
                        type: 2,
                        title: '复制',
                        shadeClose: true,
                        shade: false,
                        maxmin: true, //开启最大化最小化按钮
                        area: ['893px', '600px'],
                        content: "<?php echo adminurl('copy'); ?>&id="+id,
                    });
                    layer.full(index);
                    return false;
                })
                //审核通过
                $(document).on('click','.btnChecked',function(e){
                    var id = $(this).data('id')
                    var name=$('#modelName').val();
                    var url = "<?php echo adminurl('batchchecked'); ?>&modelName="+name;
                    $.post(url, {ids:id}, function(data){
                        if (typeof data == 'string'){
                            data = $.parseJSON(data);
                        }
                        if (data.code == 0) {
                            layer.msg('审核成功',{icon: 6,anim: 6});
                            table.reload('laytable',{});
                        }else{
                            layer.msg(data.msg,{icon: 5,anim: 6});
                        }
                    });
                    return false;
                })
                //打回
                $(document).on('click','.btnCheckedFail',function(e){
                    var id = $(this).data('id');
                    var name=$('#modelName').val();
                    var url = "<?php echo adminurl('batchcheckedfail'); ?>&modelName="+name;
                    layer.prompt({title:'打回原因',formType:2}, function(value, index, elem){
                        $.post(url, {ids:id,fail_reason:value}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.close(index);
                                layer.msg('打回成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });

                    });
                    return false;
                })

                //监听启用状态切换操作
                form.on('switch(state)', function(obj){
                    var name=$('#modelName').val();
                    if (obj.elem.checked){
                        var url = "<?php echo adminurl('batchenable'); ?>&modelName="+name;
                        var msg = "启用";
                    }else{
                        var url = "<?php echo adminurl('batchunenable'); ?>&modelName="+name;
                        var msg = "禁用";
                    }
                    $.post(url, {ids:obj.value}, function(data){
                        if (typeof data == 'string'){
                            data = $.parseJSON(data);
                        }
                        if (data.code == 0) {
                            layer.msg(msg+'成功',{icon: 6,anim: 6});
                            // table.reload('laytable',{});
                        }else{
                            layer.msg(data.msg,{icon: 5,anim: 6});
                        }
                    });
                    return false;
                });
                //监听推荐状态切换操作
                form.on('switch(hot)', function(obj){
                    var name=$('#modelName').val();
                    if (obj.elem.checked){
                        var url = "<?php echo adminurl('batchhot'); ?>&modelName="+name;
                        var msg = "推荐";
                    }else{
                        var url = "<?php echo adminurl('batchunhot'); ?>&modelName="+name;
                        var msg = "取消";
                    }
                    $.post(url, {ids:obj.value}, function(data){
                        if (typeof data == 'string'){
                            data = $.parseJSON(data);
                        }
                        if (data.code == 0) {
                            layer.msg(msg+'成功',{icon: 6,anim: 6});
                            // table.reload('laytable',{});
                        }else{
                            layer.msg(data.msg,{icon: 5,anim: 6});
                        }
                    });
                    return false;
                });
                //监听商户显示状态切换操作
                form.on('switch(store_show)', function(obj){
                    var name=$('#modelName').val();
                    if (obj.elem.checked){
                        var url = "<?php echo adminurl('batchstoreshow'); ?>&modelName="+name;
                        var msg = "显示";
                    }else{
                        var url = "<?php echo adminurl('batchunstoreshow'); ?>&modelName="+name;
                        var msg = "隐藏";
                    }
                    $.post(url, {ids:obj.value}, function(data){
                        if (typeof data == 'string'){
                            data = $.parseJSON(data);
                        }
                        if (data.code == 0) {
                            layer.msg(msg+'成功',{icon: 6,anim: 6});
                            // table.reload('laytable',{});
                        }else{
                            layer.msg(data.msg,{icon: 5,anim: 6});
                        }
                    });
                    return false;
                });
                //启用
                $('#btnBatchEnable').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    var name=$('#modelName').val();
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchenable'); ?>&modelName="+name;
                        $.post(url, {ids:ids.join(',')}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('启用成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                //禁用
                $('#btnBatchUnEnable').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    var name=$('#modelName').val();
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchunenable'); ?>&modelName="+name;
                        $.post(url, {ids:ids.join(',')}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('禁用成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                //推荐
                $('#btnBatchHot').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    var name=$('#modelName').val();
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchhot'); ?>&modelName="+name;
                        $.post(url, {ids:ids.join(',')}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('推荐成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                //取消推荐
                $('#btnBatchUnHot').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    var name=$('#modelName').val();
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchunhot'); ?>&modelName="+name;
                        $.post(url, {ids:ids.join(',')}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('取消推荐成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                //推荐
                $('#btnBatchRecommend').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchrecommend'); ?>";
                        $.post(url, {ids:ids.join(',')}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('推荐成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                //取消推荐
                $('#btnBatchUnRecommend').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchunrecommend'); ?>";
                        $.post(url, {ids:ids.join(',')}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('取消推荐成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                //监听推荐状态切换操作
                form.on('switch(recommend)', function(obj){
                    if (obj.elem.checked){
                        var url = "<?php echo adminurl('batchrecommend'); ?>";
                        var msg = "推荐";
                    }else{
                        var url = "<?php echo adminurl('batchunrecommend'); ?>";
                        var msg = "取消";
                    }
                    $.post(url, {ids:obj.value}, function(data){
                        if (typeof data == 'string'){
                            data = $.parseJSON(data);
                        }
                        if (data.code == 0) {
                            layer.msg(msg+'成功',{icon: 6,anim: 6});
                            // table.reload('laytable',{});
                        }else{
                            layer.msg(data.msg,{icon: 5,anim: 6});
                        }
                    });
                    return false;
                });
                //商户后台显示
                $('#btnBatchStoreShow').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    var name=$('#modelName').val();
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchstoreshow'); ?>&modelName="+name;
                        $.post(url, {ids:ids.join(',')}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('显示成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })

                //审核通过
                $('#btnBatchChecked').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    var name=$('#modelName').val();
                    if (data.length > 0){
                        for (var i in data){
                            ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchchecked'); ?>&modelName="+name;
                        $.post(url, {ids:ids.join(',')}, function(data){
                            if (typeof data == 'string'){
                                data = $.parseJSON(data);
                            }
                            if (data.code == 0) {
                                layer.msg('审核成功',{icon: 6,anim: 6});
                                table.reload('laytable',{});
                            }else{
                                layer.msg(data.msg,{icon: 5,anim: 6});
                            }
                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                //打回
                $('#btnBatchCheckedFail').click(function () {
                    var checkStatus = table.checkStatus('laytable');
                    var data = checkStatus.data;
                    var ids = [];
                    var name=$('#modelName').val();
                    if (data.length > 0){
                        for (var i in data){
                            if(data[i].state == 1)
                                ids.push(data[i].id);
                        }
                        var url = "<?php echo adminurl('batchcheckedfail'); ?>&modelName="+name;
                        layer.prompt({title:'打回原因',formType:2}, function(value, index, elem){
                            $.post(url, {ids:ids.join(','),fail_reason:value}, function(data){
                                if (typeof data == 'string'){
                                    data = $.parseJSON(data);
                                }
                                if (data.code == 0) {
                                    layer.close(index);
                                    layer.msg('打回成功',{icon: 6,anim: 6});
                                    table.reload('laytable',{});
                                }else{
                                    layer.msg(data.msg,{icon: 5,anim: 6});
                                }
                            });

                        });
                    }else{
                        layer.msg('请选择记录');
                    }
                })
                $('#reloadbtn').click(function () {
                    location.reload();
                })
            })
        </script>
        <div class="reload-btn">
            <div style="margin-top: 20px;">
                <button class="layui-btn layui-btn-normal" id="reloadbtn">点我刷新页面</button>
            </div>
        </div>

        
<!--搜索栏-->
<div class="search-box">
    <div style="margin-top: 20px;">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="请输入订单号查询" autocomplete="off">
        </div>
        <div class="layui-inline">
            <select name="goods_id" id="goods_id" style="width: 200px;" class="select2" lay-ignore></select>
        </div>
        <div class="layui-inline">
            <select name="type" id="type" style="width: 200px;" class="select2" lay-ignore></select>
        </div>
        <button class="layui-btn" id="btnSearch">搜索</button>
    </div>
</div>

        
<!--工具栏-->



        <!--数据表-->
        <div class="table-box">
            <table class="layui-hide" id="laytable"></table>
        </div>
        <script type="text/html" id="dataRecommend">
            <input type="checkbox" name="is_recommend" value="{{d.id}}" lay-skin="switch" lay-text="推荐|取消" lay-filter="recommend" {{ d.is_recommend == 1 ? 'checked' : '' }}>
        </script>
        <script type="text/html" id="dataState">
            <input type="checkbox" name="state" value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="state" {{ d.state == 1 ? 'checked' : '' }}>
        </script>
        <script type="text/html" id="dataCheckState">
            {{# if(d.check_status == 1){ }}
            待审核
            {{# } }}
            {{# if(d.check_status == 2){ }}
            审核通过
            {{# } }}
            {{# if(d.check_status == 3){ }}
            审核失败
            {{# } }}
        </script>
        <script type="text/html" id="dataStoreShow">
            <input type="checkbox" name="store_show" value="{{d.id}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="store_show" {{ d.store_show != 0 ? 'checked' : '' }}>
        </script>

        <script type="text/html" id="dataHot">
            <input type="checkbox" name="is_recommend" value="{{d.id}}" lay-skin="switch" lay-text="推荐|取消" lay-filter="hot" {{ d.is_recommend == 1 ? 'checked' : '' }}>
        </script>

        <script type="text/html" id="dataIcon">
            <i class="{{ d.icon }}"></i>
        </script>

        <script type="text/html" id="dataImg">
            {{# if(d.img){ }}
            <img style="width:28px;" src="{{ d.img }}">
            {{# } }}
        </script>
        <script type="text/html" id="dataPic">
            {{# if(d.pic){ }}
            <img style="width:28px;" src="{{ d.pic }}">
            {{# } }}
        </script>

        
<!--数据表-操作列-->
<script type="text/html" id="dataTool">
    {{# if(d.order_status == 2){ }}
    <a href="javascript:;" data-id="{{ d.id }}" class="layui-btn layui-btn-primary layui-btn-xs btnSend">发货/取货</a>
    {{# } }}
    <a href="javascript:;" data-id="{{ d.id }}" class="layui-btn layui-btn-primary layui-btn-xs btnSeePanic">查看详情</a>
    {{# if( (d.order_status == 20 || d.order_status==30 || d.order_status==40 ) && (d.after_sale==0) ){ }}
    <a href="javascript:;" data-id="{{ d.id }}" class="layui-btn layui-btn-primary layui-btn-xs btnFinish">立即完成</a>
    {{# } }}
    {{# if(d.after_sale == 1){ }}
    <a href="javascript:;" data-id="{{ d.id }}" class="layui-btn layui-btn-primary layui-btn-xs btnRefund">退款</a>
    <a href="javascript:;" data-id="{{ d.id }}" class="layui-btn layui-btn-primary layui-btn-xs btnRefuseRefund">拒绝退款</a>
    {{# } }}
</script>


        
<script type="text/html" id="sincetype">
    {{# if(d.sincetype == 1){ }}物流{{# } }}
    {{# if(d.sincetype == 2){ }}到店自取{{# } }}
</script>
<script type="text/html" id="paytype">
    {{# if(d.pay_type == 1){ }}微信支付{{# } }}
    {{# if(d.pay_type == 2){ }}余额支付{{# } }}
</script>
<script type="text/html" id="orderstatus">
    {{# if(d.order_status == 10){ }}未付款{{# } }}
    {{# if(d.order_status == 20){ }}待核销{{# } }}
    {{# if(d.order_status == 30){ }}待收货{{# } }}
    {{# if(d.order_status == 40){ }}待评价{{# } }}
    {{# if(d.order_status == 60){ }}已完成{{# } }}
</script>
<script type="text/html" id="afterstatus">
    {{# if(d.after_sale ==0 ){ }}未申请{{# } }}
    {{# if(d.after_sale ==1 ){ }}处理中{{# } }}
    {{# if(d.after_sale ==2 ){ }}已处理{{# } }}
</script>
<script type="text/html" id="refundstatus">
    {{# if(d.refund_status ==0 ){ }}未申请{{# } }}
    {{# if(d.refund_status ==1 ){ }}退款中{{# } }}
    {{# if(d.refund_status ==2 ){ }}退款成功{{# } }}
    {{# if(d.refund_status ==3 ){ }}退款失败{{# } }}
    {{# if(d.refund_status ==4 ){ }}拒绝退款{{# } }}
</script>
<script>
    layui.use(['table','form'], function () {
        var table = layui.table;
        var form = layui.form;
        //        表格初始化
        table.render({
            elem: '#laytable'
            ,url:"<?php echo adminurl('get_panic_list'); ?>"
            ,cols: [[
                {type:'numbers',fixed:'left'},
                {type:'checkbox',fixed:'left'},
                {field:'order_no', width:200, title: '订单号'},
                {field:'gname', width:100, title: '商品名称'},
                {field:'attr_list', width:100, title: '规格'},
                {field:'user_id', width:100, title: '用户id',sort:true},
                {field:'order_amount', width:100, title: '订单金额',sort:true},
                // {field:'distribution', width:100, title: '运费',sort:true},
                // {field:'coupon_money', width:100, title: '团长优惠',sort:true},
                {field:'num', width:100, title: '购买数量',sort:true},
                // {field:'sincetype', width:100, title: '配送方式',sort:true,templet:'#sincetype'},
                // {field:'pay_type', width:100, title: '支付方式',sort:true,templet:'#paytype'},
                // {field:'name', width:100, title: '姓名'},
                // {field:'phone', width:100, title: '手机'},
                // {field:'address', width:100, title: '地址'},
                // {field:'remark', width:100, title: '留言'},
                {field:'create_time', width:200, title: '下单时间',sort:true},

                // {field:'transaction_id', width:100, title: '微信单号'},
                {field:'order_status', width:100, title: '订单状态',sort:true,templet:'#orderstatus'},
                {field:'after_sale', width:100, title: '售后状态',sort:true,templet:'#afterstatus'},
                {field:'refund_status', width:100, title: '退款状态',sort:true,templet:'#refundstatus'},
                // {field:'pay_time', width:100, title: '支付时间',sort:true},
                // {field:'fahuo_time', width:200, title: '发货时间',sort:true},
                // {field:'queren_time', width:200, title: '确认收货时间',sort:true},
                // {field:'express_delivery', width:200, title: '快递公司'},
                // {field:'express_orderformid', width:200, title: '快递单号'},
                {field:'o',fixed:'right',width:300, title: '操作',templet: '#dataTool'},
            ]]
            ,page: true,
            height:'full-300',
        });
        //        搜索
        $('#btnSearch').unbind('click').click(function () {
            //执行重载
            table.reload('laytable', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    key: $('#key').val(),
                    goods_id: $('#goods_id').val(),
                    type: $('#type').val(),
                }
            });
        });
        $('#key').unbind().on('keypress', function (e) {
            if (e.keyCode == 13){
                //执行重载
                table.reload('laytable', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        key: $('#key').val(),
                        goods_id: $('#goods_id').val(),
                        type: $('#type').val(),
                    }
                });
            }
        })
        //查看详情
        $(document).on('click','.btnSeePanic',function(e){
            var id = $(this).data('id')
            var index = layer.open({
                type: 2,
                title: '查看详情',
                shadeClose: true,
                shade: false,
                maxmin: true, //开启最大化最小化按钮
                area: ['900px', '600px'],
                content: "<?php echo adminurl('seepanic'); ?>&id="+id,
            });
            // layer.full(index);
            return false;
        })
        //发货/取货
        $(document).on('click','.btnSend',function(e){
            var id = $(this).data('id')
            var index = layer.open({
                type: 2,
                title: '发货/取货',
                shadeClose: true,
                shade: false,
                maxmin: true, //开启最大化最小化按钮
                area: ['900px', '600px'],
                content: "<?php echo adminurl('send'); ?>&id="+id,
            });
            // layer.full(index);
            return false;
        })
        // 批量删除
        $('#btnBatchDeletec').click(function () {
            var checkStatus = table.checkStatus('laytable');
            var data = checkStatus.data;
            var ids = [];
            if (data.length > 0){
                for (var i in data){
                    ids.push(data[i].id);
                }
                layer.confirm('即将删除 '+data.length+' 条记录', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    var url = "<?php echo adminurl('deletegoods'); ?>";
                    $.post(url, {ids:ids.join(',')}, function(data){
                        if (typeof data == 'string'){
                            data = $.parseJSON(data);
                        }
                        if (data.code == 0) {
                            layer.msg('删除成功',{icon: 6,anim: 6});
                            table.reload('laytable',{});
                        }else{
                            layer.msg(data.msg,{icon: 5,anim: 6});
                        }
                    });
                });
            }else{
                layer.msg('请选择记录');
            }
        })
        // 删除
        $(document).on('click','.btnDeletec',function(e){
            var id = $(this).data('id')
            layer.confirm('即将删除 1 条记录', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var url = "<?php echo adminurl('deletegoods'); ?>";
                $.post(url, {ids:id}, function(data){
                    if (typeof data == 'string'){
                        data = $.parseJSON(data);
                    }
                    if (data.code == 0) {
                        layer.msg('删除成功',{icon: 6,anim: 6});
                        table.reload('laytable',{});
                    }else{
                        layer.msg(data.msg,{icon: 5,anim: 6});
                    }
                });
            });
            return false;
        })
        //TODO::立即完成
        $(document).on('click','.btnFinish',function(e){
            var id = $(this).data('id')
            layer.confirm('是否完成此订单', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var url = "<?php echo adminurl('panicFinish'); ?>";
                $.post(url, {id:id}, function(data){
                    if (typeof data == 'string'){
                        data = $.parseJSON(data);
                    }
                    if (data.code == 0) {
                        layer.msg('订单已完成',{icon: 6,anim: 6});
                        table.reload('laytable',{});
                    }else{
                        layer.msg(data.msg,{icon: 5,anim: 6});
                    }
                });
            });
            return false;
        })
        //TODO::退款
        $(document).on('click','.btnRefund',function(e){
            var id = $(this).data('id')
            layer.confirm('是否立即退款', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var url = "<?php echo adminurl('panicRefund'); ?>";
                $.post(url, {id:id}, function(data){
                    table.reload('laytable',{});
                    if (typeof data == 'string'){
                        data = $.parseJSON(data);
                    }
                    table.reload('laytable',{});
                    if (data.code == 0) {

                        layer.msg('退款成功',{icon: 6,anim: 6});

                    }else{
                        layer.msg(data.msg,{icon: 5,anim: 6});
                    }
                });
            });
            return false;
        })
        //TODO::退款拒绝
        $(document).on('click','.btnRefuseRefund',function(e){
            var id = $(this).data('id')
            var url = "<?php echo adminurl('panicRefuseRefund'); ?>";
            layer.prompt({title:'拒绝原因',formType:2}, function(value, index, elem){
                $.post(url, {id:id,fail_reason:value}, function(data){
                    if (typeof data == 'string'){
                        data = $.parseJSON(data);
                    }
                    if (data.code == 0) {
                        layer.close(index);
                        layer.msg('拒绝成功',{icon: 6,anim: 6});
                        table.reload('laytable',{});
                    }else{
                        layer.msg(data.msg,{icon: 5,anim: 6});
                    }
                });

            });
            return false;
        })
    })
    require(['select2'], function () {
        $('.select2').select2();
        $.get("<?php echo adminurl('allpanicgoods'); ?>", function (ret) {
            if (typeof ret == "string"){
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择商品'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                return obj;
            });
            $('#goods_id').select2({
                data: ret,
            })
        })
    })
    require(['select2'], function () {
        $('.select2').select2();
        var ret = [
            {"id":0,"text":"全部订单"},
            {"id":1,"text":"待付款"},
            {"id":2,"text":"待核销"},
            {"id":4,"text":"待评价"},
            {"id":5,"text":"已完成"},
            {"id":6,"text":"售后/退款"},
        ];
        ret.map(function (obj) {
            obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
            return obj;
        });
        $('#type').select2({
            data: ret,
        })

    })
</script>

    </div>
</div>
<script src="/addons/yztc_sun/public/static/custom/tabs-ext.js"></script>
</body>
</html>