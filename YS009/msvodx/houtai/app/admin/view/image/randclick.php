<!DOCTYPE html>
<html>
<head>
    <title>{$_admin_menu_current['title']}-后台首页</title>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css">
    <link rel="stylesheet" href="__ADMIN_CSS__/style.css?v={:time()}">
</head>
<body class="pb50">
<form class="layui-form" style="margin-top: 20px;" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">操作分类：</label>
        <div class="layui-input-inline">
            <select name="class" class="field-pid" type="select" lay-filter="pai">
                <option value="0" level="0" >所有图集</option>
                {volist name="classlist" id="v" }
                <option value="{$v['id']}" level="{$v['id']}" >|-{$v['name']}</option>
                {volist name="v['childs']" id="vv" }
                <option value="{$vv['id']}" level="{$vv['id']}" >|&nbsp;&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                {/volist}
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">添加类型：</label>
            <input type="radio"   name="type" value="1" title="随机数" checked>
            <input type="radio"  name="type" value="2"  title="固定追加数" >
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label  layui-bg-gray">随机点击范围</label>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="text" name="min_num" placeholder="0" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid">-</div>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="text" name="max_num" placeholder="1000" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux "><span style="color: #FF5722;">*添加类型为“固定追加数”，此项不需要填写！</span></div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">追加点击数：</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="num" value="0" autocomplete="off" placeholder="请填写">
        </div>
        <div class="layui-form-mid layui-word-aux "><span style="color: #FF5722;">*添加类型为“随机数”，此项不需要填写！</span></div>
    </div>
    <input type="hidden" value="{$callback}">
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" class="layui-btn"/>
        </div>
    </div>
</form>
<script src="__ADMIN_JS__/layui/layui.js"></script>
<script>
    layui.config({
        base: '__ADMIN_JS__/'
    }).use('global');
    layui.use(['jquery'], function(){
        var $ = layui.jquery;
        $('#popConfirm').click(function() {
            var data = new Array(), json = '';
            if ($('input[name="ids[]"]:checked').length <= 0) {
                layui.layer.msg('请选择数据！');
                return false;
            }
            $('input[name="ids[]"]:checked').each(function(i) {
                json = eval('(' + $(this).attr('data-json') + ')');
                data[i] = json;
            });
            // 触发父级页面函数
            parent.{$callback}(data);
            parent.layer.closeAll();
        });

    });
</script>
</body>
</html>