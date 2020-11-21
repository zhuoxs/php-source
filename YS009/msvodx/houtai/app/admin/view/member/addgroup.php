<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <!--
        <fieldset class="layui-elem-field layui-field-title">
            <legend>添加banner</legend>
        </fieldset>-->
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="name" value="" autocomplete="off" placeholder="请填写名称">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input field-nick" name="sort" lay-verify="required" autocomplete="off" value="0">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label layui-bg-gray">说明</label>
            <div class="layui-input-inline">
                <textarea rows="6"  class="layui-textarea" name="intro" autocomplete="off" placeholder="请填写说明"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
            </div>
        </div>
    </form>
</div>
<style type="text/css">
    .layui-form-item .layui-form-label{width:150px;}
    .layui-form-item .layui-input-inline{max-width:80%;width:auto;min-width:320px;}
    .layui-field-title:not(:first-child){margin: 30px 0}
    td{
        border-right: dashed 1px #c7c7c7;
        text-align:center;
    }
    .layui-layer-tips{
        width: 830px!important;
    }

</style>

<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/plupload3/js/plupload.js"></script>
<script src="/static/plupload3/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script>
    function afterUpLogo(resp){
        var resp=JSON.parse(resp);
        $('#img_banner').attr('src',resp.filePath);
        $('#images_url').val(resp.filePath);
    }

    $(function(){
        createWebUploader('banner_chose_btn','','','logo_test','image',afterUpLogo);
    });

</script>