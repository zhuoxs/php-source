<style type="text/css">
    .layui-form-item .layui-input-inline{max-width:80%;width:auto;min-width:260px;}
    .layui-form-mid{padding:0!important;}
    .layui-form-mid code{color:#5FB878;}
    dl.layui-anim.layui-anim-upbit{z-index:1000;}
</style>
<div style="display:block;width:100%;overflow:hidden;">
    {:runhook('system_admin_index')}
</div>
<form action="#" class="page-list-form layui-form layui-form-pane" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">图集标题：</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="image[title]" value="" autocomplete="off" placeholder="请填写标题">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">观看金币：</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="image[gold]" value="" placeholder="0" autocomplete="off" >
        </div>
        <div class="layui-form-mid layui-word-aux"> *非会员观看需要支付金币</div>
    </div>
<!--    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">关键字：</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="image[key_word]" value="" autocomplete="off" placeholder="请填写关键字">
        </div>
    </div>-->
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">上传图片</label>
        <div class="layui-input-inline upload">
            <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload"  id="upload_logo_chose_btn"">请上传图片</button>
            <input type="hidden" class="upload-input" name="image[cover]" id="site_logo" value="/static/images/images_default.png">
            <img src="/static/images/images_default.png" id="img_logo" onmouseover="imgTips(this,{width:200,className:'imgTips'})" style="display:block;border-radius:5px;border:1px solid #ccc;max-width: 200px;margin-top: 5px;">
        </div>
        <div class="layui-form-mid layui-word-aux"> 上传图片缩略图</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">图集标签</label>
        <div class="layui-input-inline" style="width: 50%;">
            {volist name="tag_result" id="v"}
            <input type="checkbox" class="layui-checkbox checkbox-ids"  name="tag[]"  value="{$v['id']}" title="{$v['name']}">
            {/volist}
        </div>
    </div>
    <div class="layui-form-item">

        <label class="layui-form-label layui-bg-gray">图集分类：</label>
        <div class="layui-input-inline">
            <select name="image[class]" class="field-pid" type="select" lay-filter="pai">

                {volist name="classlist" id="v" }

                <option value="{$v['id']}" level="{$v['id']}" >|-{$v['name']}</option>
                {volist name="v['childs']" id="vv" }
                <option value="{$vv['id']}" level="{$vv['id']}" >|&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                {/volist}
                {/volist}
            </select>
        </div>
    </div>
<!--    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">摘要</label>
        <div class="layui-input-inline">
            <textarea rows="6"  class="layui-textarea" name="image[short_info]" autocomplete="off" placeholder="请填写视频说明"></textarea>
        </div>
    </div>-->
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" class="layui-btn"/>
        </div>
    </div>
</form>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/plupload-2.3.6/js/plupload.full.min.js"></script>
<script src="/static/plupload-2.3.6/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>
<script>
    function afterUpLogo(resp){
        $('#img_logo').attr('src',resp.filePath);
        $('#site_logo').val(resp.filePath);
        layer.msg('上传完成',{time:500});
    }

    $(function(){
        createWebUploader('upload_logo_chose_btn','','','image',afterUpLogo);
    });

</script>

