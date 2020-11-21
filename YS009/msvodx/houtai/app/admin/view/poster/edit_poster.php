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
<form  class="page-list-form layui-form layui-form-pane" style=" margin-left: 20px;" method="post" id="saveImgForm">

    <div class="layui-form-item">
        <div class="layui-word-aux"><b>说明</b>：添加广告</div>

    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
                <label class="layui-form-label layui-bg-gray">广告位：</label>
                <div class="layui-input-inline">
                    <select name="position" lay-verify="">
                        <option value="">请选择一个广告位</option>
                        {volist name="data_list" id="v"}
                        <option value="{$v['id']}"  {if condition="$data['position_id'] eq $v['id']"}selected="selected"{/if} >{$v['title']}</option>
                        {/volist}

                    </select>
                </div>
            <a class="layui-form-mid layui-word-aux"> 广告位选择</a>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">广告类型：</label>
            <div class="layui-input-inline">
                <input type="button"  id="code1" style="background-color:red;" class="layui-btn" value="自定义" />
                <input  type="button"  id="code2" style="background-color:#c2c2c2;" class="layui-btn"  value="广告代码" />
                <input type="hidden" value="{$data['type']}" name="type" id="code">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">标题：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="titles" value="{$data['titles']}" autocomplete="off" >
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">说明：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="info" value="{$data['info']}" autocomplete="off" >
            </div>

        </div>
    </div>
    <div class="layui-form-item code1">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">图片：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="content"  id="titlepic"  value="{$data['content']}" autocomplete="off" >
            </div>
            <div class="layui-input-inline">
                <img onmouseout="layer.closeAll();"  onmouseover="imgTips(this,{width:320})" style="border-radius:5px;border:1px solid #ccc;"  height="36" id="img_video_thumb" src="/static/images/images_default.png">
                &nbsp;&nbsp; <a id="video_thumb_up_btn" href="javascript:" class="layui-btn layui-btn-primary" style="background-color: #fff;">上传</a>
            </div>
        </div>
    </div>
    <div class="layui-form-item code2" style="display: none;">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">代码：</label>
            <div class="layui-input-inline">
                <textarea type="text" class="layui-input" name="code" value="{$data['content']}" autocomplete="off" ></textarea>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">链接：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="url" value="{$data['url']}" autocomplete="off" >
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label layui-bg-gray">新页打开：</label>
            <div class="layui-input-inline">
                <input type="radio" name="target" value="1" title="是" {if condition="$data['target'] eq 1"}checked{/if}>
                <input type="radio" name="target" value="0" title="否" {if condition="$data['target'] eq 0"}checked{/if}>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">展示日期范围</label>
            <div class="layui-input-inline">
                <input type="text" name="date"  class="layui-input" id="test6" value="{:date('Y-m-d',$data['begin_time'])} - {:date('Y-m-d',$data['end_time'])}"  placeholder="{:date('Y-m-d',$data['begin_time'])} - {:date('Y-m-d',$data['end_time'])}">
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
<script src="/static/plupload-2.3.6/js/plupload.full.min.js"></script><script src="/static/plupload-2.3.6/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>
<script>
    function afterUpThumb(resp){
        $('#img_video_thumb').attr('src',resp.filePath);
        $('#titlepic').val(resp.filePath);
        layer.msg('上传缩略图完成',{time:500});
    }
    $("#code1").click(function(){
        $(this).css("background-color","red");
        $('#code').val('2');
        $("#code2").css("background-color","#c2c2c2");
        $(".code2").hide();
        $(".code1").show();
    });
    $("#code2").click(function(){
        $(this).css("background-color","red");
        $('#code').val('1');
        $("#code1").css("background-color","#c2c2c2");
        $(".code1").hide();
        $(".code2").show();
    });




    $(function(){
        createWebUploader('video_thumb_up_btn','','','image',afterUpThumb);
    });
</script>

<script>
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