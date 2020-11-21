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
        <label class="layui-form-label layui-bg-gray">标题：</label>
        <div class="layui-input-inline">
                <input type="text" name="title" placeholder="标题" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">显示状态：</label>
            <input type="radio"   name="status" value="1" title="显示" checked>
            <input type="radio"  name="status" value="0"  title="隐藏" >
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label  layui-bg-gray">上传图片</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload"  id="upload_logo_chose_btn"">请上传图片</button>
                <input type="hidden" class="upload-input" name="url" id="site_logo" value="/static/images/images_default.png">
                <img src="/static/images/images_default.png" id="img_logo"  style="display:block;border-radius:5px;border:1px solid #ccc;max-width: 200px;">
            </div>
            <div class="layui-form-mid layui-word-aux"> 上传图片缩略图</div>
        </div>
    </div>
<input type="hidden"  name="atlas_id" value="{$id}">

    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" class="layui-btn"/>
        </div>
    </div>
</form>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/plupload-2.3.6/js/plupload.full.min.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>
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

    function afterUpLogo(resp){

        console.log(resp);

        $('#img_logo').attr('src',resp.filePath);
        $('#site_logo').val(resp.filePath);
        layer.msg('上传完成',{time:500});
    }

    $(function(){
        createWebUploader('upload_logo_chose_btn','','','image',afterUpLogo);
    });

</script>
</body>
</html>