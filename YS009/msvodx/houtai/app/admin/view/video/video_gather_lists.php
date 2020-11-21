<!DOCTYPE html>
<html>
<head>
    <title>{$_admin_menu_current['title']}-后台首页</title>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css">
    <link rel="stylesheet" href="__ADMIN_CSS__/style.css?v={:time()}">
</head>
<body class="pb50">
<style>
    td{
        border-right: dashed 1px #c7c7c7;
        text-align:center;
    }
</style>
<form id="pageListForm" class="layui-form layui-form-pane" method="get">
    <div class="layui-collapse page-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">温馨提示</h2>
            <div class="layui-colla-content  layui-show ">
                <p style="color: red;">1.已经添加的视频不在当前显示。2.一个视频只能绑定到一个视频集</p>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label" style="color: #5FB878;">搜索：</label>
        <div class="layui-input-inline">
            <input type="hidden" name="isget" value="yes"/>
            <input type="text" class="layui-input field-title" name="name"  autocomplete="off" value="{$name}" placeholder="请输入视频名称">
        </div>
        <div class="layui-input-inline">
            <select name="class" class="field-pid" type="select" lay-filter="pai">
                <option value="0">请选择分类</option>
                {volist name="classlist" id="v" }
                <option value="{$v['id']}" level="{$v['id']}"  >|-{$v['name']}</option>
                {volist name="v['childs']" id="vv" }
                <option value="{$vv['id']}" level="{$vv['id']}" >&nbsp;&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                {/volist}
                {/volist}
            </select>
        </div>
        <div class="layui-input-inline" style="width: 80px;">
            <input class="layui-btn"  type="submit"  value="搜索视频"/>
        </div>
        <div class="layui-input-inline" style="width: 80px;">
            <input class="layui-btn"  type="submit" lay-submit="" lay-filter="formSubmit" style="width: 100%; margin-left: 15px;" value="确认添加"/>
        </div>
    </div>
    <div class="layui-form">
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <colgroup>
                <col width="50">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th width="40px;">ID</th>
                <th width="70px;">缩略图</th>
                <th width="300px;">视频标题</th>
                <th width="70px;">分类</th>
                <th width="90px;">更新时间</th>
            </tr>
            </thead>
            <tbody>
            {volist name="data_list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td>{$vo['id']}</td>
                <td>
                        <a href="{$vo['thumbnail']}" target="pic">
                        <img height="30" src="{$vo['thumbnail']}" >
                        </a>
                </td>
                <td>{$vo['title']}</td>
                <td>{$vo['class']}</td>
                <td>{:date('Y-m-d',$vo['update_time'])}</td>
            </tr>
            {/volist}
            </tbody>
        </table>
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
            parent.layer.closeAll();
        });
    });
</script>
</body>
</html>