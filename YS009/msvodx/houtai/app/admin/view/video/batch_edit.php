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
    <table class="layui-table mt10" lay-even="" lay-skin="row">
        <tr>

            <td>
                <div class="layui-form-item">
                    <div style="float: left; "onclick="xua(11)">
                        <input type="radio" name="con" class="layui-checkbox checkbox-ids" value="id" lay-skin="primary" title="按ID操作："  checked>
                    </div>
                </div>
            </td>
            <td>
                <div class="layui-form-item">
                    <div style="float: left;"onclick="xua(22)">
                        <input type="radio" name="con"  class="layui-checkbox checkbox-ids" value="clas" lay-skin="primary" title="按分类操作：">
                    </div>
                </div>
            </td>
        </tr>
        <tr id="ide">
            <td colspan="2">
                <div class="layui-form-item"  >
                    <label class="layui-form-label">ID号码:</label>
                    <input type="text" style="width: 50%; float: left;" class="layui-input" name="id" value="{$ids}" style="float: right" autocomplete="off" placeholder="0" >
                </div>
            </td>
        </tr>
        <tr style="display: none;" id="cls" >
        <td colspan="2" >
            <div class="layui-form-item">
                <label class="layui-form-label">分类:</label>
                <div class="layui-input-inline">
                <select name="clas" class="field-pid" type="select"  style="width: 30%; float: left;"  lay-filter="pai">
                    {volist name="classlist" id="v" }
                    <option value="{$v['id']}" level="{$v['id']}" >|-{$v['name']}</option>
                    {volist name="v['childs']" id="vv" }
                    <option value="{$vv['id']}" level="{$vv['id']}" >&nbsp;&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                    {/volist}
                    {/volist}
                </select>
                </div>
            </div>
        </td>
        </tr>
        <tr>
<tr>
    <td>
        <div class="layui-form-item">
            <div style="float: left;width: 113px;" onclick="xuan(1)">
                <input type="checkbox" name="idse[]" class="layui-checkbox checkbox-ids" value="click" lay-skin="primary" title="人气：">
            </div>
            <div class="layui-input-inline">
                <input type="text" class="layui-input xuan1" name="click" value="1" style="float: right" autocomplete="off" disabled placeholder="0" >
            </div>
        </div>
    </td>
    <td>
        <div class="layui-form-item">
            <div style="float: left;width: 113px;" onclick="xuan(2)">
                <input type="checkbox" name="idse[]" class="layui-checkbox checkbox-ids" value="good"  lay-skin="primary" title="点赞：">
            </div>
            <div class="layui-input-inline">
                <input type="text" class="layui-input xuan2" name="good" value="" style="float: right" autocomplete="off" placeholder="0" disabled>
            </div>
        </div>
    </td>
</tr>
        <tr>
            <td>
                <div class="layui-form-item">
                    <div style="float: left;width: 113px;" onclick="xuan(3)">
                        <input type="checkbox" name="idse[]" class="layui-checkbox checkbox-ids" value="gold" lay-skin="primary" title="观看金币：">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input xuan3" name="gold" value="" style="float: right" autocomplete="off" placeholder="0" disabled>
                    </div>
                </div>
            </td>
            <td>
                <div class="layui-form-item">
                    <div style="float: left;width: 113px;" onclick="xuan(4)">
                        <input type="checkbox" name="idse[]" class="layui-checkbox checkbox-ids" value="class" lay-skin="primary" title="分类：">
                    </div>
                    <div class="layui-input-inline">
                        <select name="class" class="field-pid" type="select"  style="width: 30%; float: left;"  lay-filter="pai">
                            {volist name="classlist" id="v" }
                            <option value="{$v['id']}" level="{$v['id']}" >|-{$v['name']}</option>
                            {volist name="v['childs']" id="vv" }
                            <option value="{$vv['id']}" level="{$vv['id']}" >&nbsp;&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                            {/volist}
                            {/volist}
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="layui-form-item">
                    <div style="float: left;width: 113px;" onclick="xuan(5)">
                        <input type="checkbox" name="idse[]" class="layui-checkbox checkbox-ids" value="reco" lay-skin="primary" title="视频推荐：">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input xuan5" name="reco" value="" style="float: right" autocomplete="off" placeholder="0" disabled>
                    </div>
                </div>
            </td>
            <td>
                <div class="layui-form-item">
                    <div style="float: left;width: 113px;">
                        <input type="checkbox" name="idse[]" class="layui-checkbox checkbox-ids"  value="status" lay-skin="primary" title="显示状态：">
                    </div>
                    <div class="layui-input-inline">
                        <input type="radio" class="field-status xuan6" name="status" value="1" title="启用" checked  >
                        <input type="radio" class="field-status xuan6" name="status" value="0" title="禁用"  >
                    </div>
                </div>
            </td>
        </tr>
    </table>
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
            parent.layer.closeAll();
        });
    });

    function xuan(a){
        var $ = layui.jquery;
        var is_display =$(".xuan"+a).prop("disabled") ;
       if(is_display){
           $(".xuan"+a).attr("disabled",false);
       }else {
           $(".xuan"+a).attr("disabled",true);
       }
    }
    function xua(b){
        var $ = layui.jquery;
if(b==11){
    $("#ide").show();
    $("#cls").hide();
}else if(b==22){
    $("#ide").hide();
    $("#cls").show();
}
    }</script>
</body>
</html>