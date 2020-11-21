<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css">
    <link rel="stylesheet" href="__ADMIN_CSS__/style.css?v={:time()}">
    <style>
       span{
            display: none;
        }
    </style>
</head>
<body>
<form  class="page-list-form layui-form layui-form-pane" style=" margin: 20px;" method="post" id="saveImgForm">

    <div class="layui-form-item">
        <div class="layui-word-aux"><b>说明</b>：添加站点</div>

    </div>


    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">站群域名：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" required  lay-verify="required" name="domain" value="" autocomplete="off" >
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">站群标题：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" required  lay-verify="required" name="site_title" value="" autocomplete="off" >
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">站点描述：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" required  lay-verify="required" name="site_description" value="" autocomplete="off" >
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">关键词：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" required  lay-verify="required" name="site_keywords" value="" autocomplete="off" >
            </div>
        </div>
    </div>
    <div class="layui-form-item code1">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">PC logo：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" required  lay-verify="required" name="logo_url"  id="titlepic"  value="" autocomplete="off" >
            </div>
            <div class="layui-input-inline">
                <img onmouseout="layer.closeAll();"  onmouseover="imgTips(this,{width:220})" style="border-radius:5px;border:1px solid #ccc;"  height="36" id="img_video_thumb" src="/static/images/images_default.png">
                &nbsp;&nbsp; <a id="video_thumb_up_btn" href="javascript:" class="layui-btn layui-btn-primary" style="background-color: #fff;">上传</a>
            </div>
        </div>
    </div>
    <div class="layui-form-item code1">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">WAP logo：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" required  lay-verify="required" name="site_logo_mobile"  id="titlepic_m"  value="" autocomplete="off" >
            </div>
            <div class="layui-input-inline">
                <img onmouseout="layer.closeAll();"  onmouseover="imgTips(this,{width:220})" style="border-radius:5px;border:1px solid #ccc;"  height="36" id="img_video_thumb_m" src="/static/images/images_default.png">
                &nbsp;&nbsp; <a id="video_thumb_up_btn_m" href="javascript:" class="layui-btn layui-btn-primary" style="background-color: #fff;">上传</a>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">友情链接</label>
        <div class="layui-input-block">
            <textarea rows="6" class="layui-textarea" name="friend_link" autocomplete="off" placeholder="请填写友情链接"></textarea>
        </div>
    </div>
    <blockquote class="layui-elem-quote layui-text">
        1. 每行一条友情链接,以回车链换行</br>2. 单条规则：链接名称|网址,例：YM源码|https://www.ymyuanma.com
    </blockquote>
    <div class="layui-form-item">
        <label class="layui-form-label">统计代码</label>
        <div class="layui-input-block">
            <textarea rows="6" class="layui-textarea" name="site_statis" autocomplete="off" placeholder="请填写站点统计代码"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">备案信息：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" required  lay-verify="required" name="site_icp" value="" autocomplete="off" >
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" class="layui-btn"/>
            <button  style="background-color:#c2c2c2;" class="layui-btn" id="colse" >关闭</button>
        </div>
    </div>

</form>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="__ADMIN_JS__/layui/layui.js"></script>
<script src="/static/plupload-2.3.6/js/plupload.full.min.js"></script><script src="/static/plupload-2.3.6/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>

<script>
    function afterUpThumb(resp){
        $('#img_video_thumb').attr('src',resp.filePath);
        $('#titlepic').val(resp.filePath);
        layer.msg('上传缩略图完成',{time:500});
    }
    $(function(){
        createWebUploader('video_thumb_up_btn','','','image',afterUpThumb);
        createWebUploader('video_thumb_up_btn_m','','','image',afterUpThumbM);
    });

    function afterUpThumbM(resp){
        $('#img_video_thumb_m').attr('src',resp.filePath);
        $('#titlepic_m').val(resp.filePath);
        layer.msg('上传缩略图完成',{time:500});
    }

    var fileCount=0;
    var curCount=0;
    layui.config({
        base: '__ADMIN_JS__/'
    }).use('global');
    layui.use(['jquery'], function(){
        var laydate = layui.laydate;
        var $ = layui.jquery;
        $('#colse').click(function() {
            parent.layer.closeAll();
        });


    });
    layui.use('laydate', function() {
        var laydate = layui.laydate;
        //日期范围
        laydate.render({
            elem: '#test6'
            , range: true
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