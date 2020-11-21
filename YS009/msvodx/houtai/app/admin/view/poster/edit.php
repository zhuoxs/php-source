<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css">
    <link rel="stylesheet" href="__ADMIN_CSS__/style.css?v={:time()}">
</head>
<body>
<form  class="page-list-form layui-form layui-form-pane" style=" margin-left: 20px;" method="post" id="saveImgForm">

    <div class="layui-form-item">
        <div class="layui-word-aux"><b>说明</b>：编辑广告位</div>
    </div>

    <div class="layui-form-item">
        <div class="layui-inline">

                <label class="layui-form-label layui-bg-gray">标题：</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="title" id="playtime" id="playtime" value="{$data['title']}" autocomplete="off" >
                </div>
            <a class="layui-form-mid layui-word-aux"> 广告标题或者说明</a>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">广告宽度：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="width"  value="{$data['width']}" autocomplete="off" >
            </div>
            <a class="layui-form-mid layui-word-aux"> 广告宽度单位px,如25px只需填写25</a>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">广告高度：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="height" value="{$data['height']}" autocomplete="off" >
            </div>
            <a class="layui-form-mid layui-word-aux"> 广告高度单位px,如25px只需填写25</a>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" class="layui-btn"/>
            <button  style="background-color:#c2c2c2;" class="layui-btn" id="colse" >关闭</button>
        </div>
    </div>
    <div class="layui-form-item" id="img_list"></div>
    <div id="chsoe_info"></div>
</form>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="__ADMIN_JS__/layui/layui.js"></script>
<script>
    var fileCount=0;
    var curCount=0;

    layui.config({
        base: '__ADMIN_JS__/'
    }).use('global');
    layui.use(['jquery'], function(){
        var $ = layui.jquery;
        $('#colse').click(function() {
            parent.layer.closeAll();
        });

    });
</script>
<style>
    .img_thumb{
        border:1px solid #c1c1c1;
        border-radius: 5px;
        margin:5px;
        width:150px;
        overflow: hidden;
        float:left;
        height: 150px;
        position: relative;
    }
    .img_thumb img{
        height:100%;
    }
    .uploaded{
        background-color: rgba(0, 0, 0,0.6);
        color:#FFF;
        position: absolute;
        width: 150px;
        bottom: 0px;
        text-align: center;
        padding:5px 0;
    }
</style>
</body>
</html>