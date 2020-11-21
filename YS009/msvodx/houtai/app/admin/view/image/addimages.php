<!DOCTYPE html>
<html>
<head>
    <title>{$_admin_menu_current['title']}-后台首页</title>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css">
    <link rel="stylesheet" href="__ADMIN_CSS__/style.css?v={:time()}">
</head>
<body class="pb50">
<form class="layui-form" style="margin: 10px;" method="post" id="saveImgForm">

    <div class="layui-form-item">
        <div class="layui-word-aux"><b>说明</b>：可同时上传多张</div>
        <div id="upload_proccess"></div>
        <div style="margin-top: 20px; width:100%">
            <div class="layui-progress" lay-showpercent="true" id="up_percent_div" style="display: none;">
                <div class="layui-progress-bar" id="up_percent"></div>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            <div class="" style="display: inline-block;width:100%;">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload"  id="upload_img_chose_btn"">选择图片上传</button>
                <button type="button"  class="layui-btn layui-btn-primary" id="upload_img_up_btn">上传</button>

                <input style="float: right;background-color: grey;" id="save_btn" type="submit" disabled="disabled" value="保存" lay-submit="" lay-filter="formSubmit" class="layui-btn"/>
            </div>
        </div>
    </div>
    <div class="layui-form-item" id="img_list"></div>
    <div id="chsoe_info"></div>

    <input type="hidden"  name="atlas_id" value="{$id}">
    <input type="hidden" value="{$callback}">
</form>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/plupload-2.3.6/js/plupload.full.min.js"></script><script src="/static/plupload-2.3.6/js/i18n/zh_CN.js"></script>
<script src="/static/plupload-2.3.6/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>
<script src="__ADMIN_JS__/layui/layui.js"></script>
<script>
    var fileCount=0;
    var curCount=0;

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

    function afterUpImg(resp){
        var html='<div class="img_thumb"><img src="'+resp.filePath+'" /><div class="uploaded">上传完成</div></div><input type="hidden" class="upload-input" name="url[]" value="'+resp.filePath+'">';
        $('#img_list').append(html);
        ++curCount;
        //var proccessInfo='上传完成:'+curCount+'/'+fileCount;
        var percent=parseInt(curCount/fileCount*100)+"%";
        $("#up_percent").attr('lay-percent', percent).css({"width":percent}).find('.layui-progress-text').html(percent);
        if(percent=='100%'){
            $('#save_btn').removeAttr('disabled').css({"background-color":"#009688"});
            layer.msg('所有图片已全部上传完成，系统将自动保存.',{icon:1,time:2000,anim: 5});
            setTimeout("$('#save_btn').click()",3000);
        }
        console.log(percent);
    }

    function aferChose(resp){
        //console.log("--------------->",resp);
        $("#save_btn").hide();
        $("#up_percent_div").show('slow').find('.layui-progress-text').html('0%');
        var html="<blockquote class=\"layui-elem-quote\">您共选择了<span class='layui-badge'>"+resp.fileCount+"</span>张图片";
        var table="<table class='layui-table'><tr><td>文件名称</td><td>文件大小</td></tr>";

        for(var i=0;i<resp.fileList.length;i++){
            //console.log(resp.fileList[i]);
            var item=resp.fileList[i];
            table+="<tr><td>"+item.name+"</td><td>"+item.size/1000+"kb</td></tr>";
        }

        table+="</table>"
        html+=table;
        html+='</blockquote>';
        fileCount=resp.fileCount;
        $("#chsoe_info").html(html);

    }
    $(function(){
        createWebUploader('upload_img_chose_btn','upload_img_up_btn','','image',afterUpImg,true,aferChose);
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