<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:92:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/crecharge/edit.html";i:1553823385;s:95:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit_table.html";i:1553823402;}*/ ?>
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
    <link href="/web/resource//css/common.css" rel="stylesheet">
    <script>

        window.sysinfo = {
            'siteroot': '<?php echo isset($_W['siteroot'])?$_W['siteroot']:''; ?>',
            'siteurl': '<?php echo isset($_W['siteurl'])?$_W['siteurl']:''; ?>',
            'attachurl': '<?php echo isset($_W['attachurl'])?$_W['attachurl']:''; ?>',
            'attachurl_local': '<?php echo isset($_W['attachurl_local'])?$_W['attachurl_local']:''; ?>',
            'attachurl_remote': '<?php echo isset($_W['attachurl_remote'])?$_W['attachurl_remote']:''; ?>',
            'cookie' : {'pre': '<?php echo isset($_W['config']['cookie']['pre'])?$_W['config']['cookie']['pre']:''; ?>'},
            'account' : <?php  echo json_encode($_W['account']) ?>
        };
    </script>
    <script src="/web/resource//js/app/util.js"></script>
    <script src="/web/resource//js/app/common.min.js"></script>
    <script>var require = { urlArgs: 'v=20161011' };</script>
    <script src="/web/resource//js/require.js"></script>
    <script src="/web/resource//js/app/config.js"></script>
    <script>
        requireConfig.baseUrl = "/web/resource/js/app";
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
        .select2{
            width: 100%;
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

        .layui-form-item .layui-form-label{
            width: 180px;
        }
        .layui-form-item .layui-input-block{
            margin-left: 210px;
        }
        /*修改表单页面样式*/
        .layui-table-view .layui-form-checkbox{
            margin-top: 0!important;
        }
        /*laytable 选中样式*/
        .layui-table-check{
            background-color: #e0f7de;
        }
        /*修改列表页面样式*/
        .tool-box{
            margin-top: 10px;
            padding: 6px;
            background: #fff;
            border: 1px #ddd solid;
            border-radius: 3px;
        }
    </style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div style="padding: 15px;">
        <form class="layui-form" method="post" action="<?php echo adminurl('save'); ?>">
            <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''; ?>">
            
<div class="layui-form-item">
    <label class="layui-form-label">是否开启自定义充值</label>
    <div class="layui-input-block">
        <input type="radio" name="state" value="1" title="开启" <?php if($info['state']==1 || empty($info['state'])): ?>checked="checked"<?php endif; ?>>
        <input type="radio" name="state" value="0" title="关闭" <?php if($info['state']===0): ?>checked="checked"<?php endif; ?>>
    </div>
</div>
<div class="layui-form-item" id="lowestdiv">
    <label class="layui-form-label">最低充值金额</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="recharge_lowest" placeholder="请输入最低充值金额,最低为0.01元" class="layui-input" value="<?php echo isset($info['recharge_lowest'])?$info['recharge_lowest']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">充值卡优惠活动</label>
    <div class="layui-input-block">
        <!--工具栏-->
        <div class="tool-box">
            <div class="layui-btn-group">
                <a href="javascript:;" id="btnAdd" class="layui-btn layui-btn-primary layui-btn-sm">新增</a>
                <a href="javascript:;" id="btnBatchDelete" class="layui-btn layui-btn-danger layui-btn-sm">删除</a>
            </div>
        </div>
        <!--数据表-操作列-->
        <script type="text/html" id="dataTool">
            <!--<a href="javascript:;" lay-event="del" class="layui-btn layui-btn-danger layui-btn-xs">删除</a>-->
            <a href="javascript:;" lay-event="edit" class="layui-btn layui-btn-xs">编辑</a>
        </script>
        <!--数据表-->
        <div class="table-box">
            <table class="layui-hide" id="laytable"></table>
        </div>
    </div>
</div>
<style>
    .choose ul{
        height: 530px;
        overflow: auto;
    }
    .choose li{
        position: relative;
    }
    .choose label{
        height: 35px;
        line-height: 35px;
        width: 100%;
        position: relative;
        color: #666;
        cursor: pointer;
        border-bottom: 1px solid #ddd;
        padding: 0px 30px;
    }
    .choose .disabled{
        cursor: pointer;
        color: #aaa;
    }
    .choose input{
        height: 20px;
        width: 20px;
        position: absolute;
        top: 4px;
        right: 30px;
    }
</style>
<script>
    function rechSetting(){
        var state = $('[name=state]:checked').val();
        if (state == 1) {
            $("#lowestdiv").show();

        }else{
            $("#lowestdiv").hide();
        }
    }
    rechSetting();
            layui.use(['table','form'],function () {
                var table = layui.table;
                var form = layui.form;
                form.on('radio', function(data){
                    if($(data.elem).is('[name=state]')) {
                        rechSetting();
                    }
                });
                table.render({
                    elem: '#laytable'
                    , data: <?php echo (isset($info['details']) && $info['details']) ? ($info['details']):"[]" ?>
                    , cols: [[
                    {type: 'numbers', fixed: 'left'},
                    {type: 'checkbox', fixed: 'left'},
                    {field: 'money', fixed: 'left', width: 250, title: '充值金额', sort: true, edit: true},
                    {field: 'send_money', width: 250, title: '赠送金额', sort: true, edit: true},
                    // {field: 'o', fixed: 'right', width: 200, title: '操作', toolbar: '#dataTool'},
                ]]
                    // , page: true
                    , limit: 90
                    // , height: 'full-420',
                });

                $('#btnAdd').click(function () {
                    var data = [];
                    data = layui.table.data.laytable;
                    data.push({
                        'money':'',
                        'send_money':'',
                    });
                    table.reload('laytable', {
                        data: data,
                    });
                })
                //        批量删除
                $('#btnBatchDelete').click(function () {
                    var data = [];
                    data = layui.table.data.laytable;
                    if (data.length > 0) {
                        var new_data = [];
                        for (var i in data) {
                            if (!data[i]['LAY_CHECKED']) {
                                new_data.push(data[i]);
                            }
                        }
                        table.reload('laytable', {
                            data: new_data,
                        });
                    } else {
                        layer.msg('请选择记录');
                    }
                })

                // 新增界面、保存、取消事件
                form.on('submit', function(data){
                    if(!$(data.elem).is('button')){
                        return false;
                    }
                    var data = data.field;
                    data.details = JSON.stringify(table.data.laytable);
                    var url = "<?php echo adminurl('save'); ?>";
                    $.post(url,data,function(res){
                        if (typeof res == 'string'){
                            res = $.parseJSON(res);
                        }
                        if (res.code == 0) {
                            // var index=parent.layer.getFrameIndex(window.name);
                            // parent.layer.close(index);
                            layer.msg('保存成功',{icon: 6,anim: 6});
                            layui.table.reload('laytable',{});
                        }else{
                            layer.msg(res.msg,{icon: 5,anim: 6});
                        }
                    });
                    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                });
                form.on('radio(type)', function(data){
                    table.reload('laytable',{
                        cols: [[
                            {type: 'numbers', fixed: 'left'},
                            {type: 'checkbox', fixed: 'left'},
                            {field: 'money', fixed: 'left', width: 250, title: '充值金额', sort: true, edit: true},
                            {field: 'send_money', width: 250, title: '赠送金额', sort: true, edit: true},
                            // {field: 'o', fixed: 'right', width: 200, title: '操作', toolbar: '#dataTool'},
                        ]]
                    });
                });
            })

</script>

            
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="">立即提交</button>
                    <button class="layui-btn layui-btn-primary" id="btnCancel">取消</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element','form','table'], function(){
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;

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

        $('#btnCancel').click(function(e){
            var index=parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        })
    })
</script>
</body>
</html>