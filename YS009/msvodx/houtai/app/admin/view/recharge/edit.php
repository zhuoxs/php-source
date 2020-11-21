<style type="text/css">
    .layui-form-item .layui-input-inline{max-width:80%;width:auto;min-width:260px;}
    .layui-form-mid{padding:0!important;}
    .layui-form-mid code{color:#5FB878;}
</style>
<div style="display:block;width:100%;overflow:hidden;">
    {:runhook('system_admin_index')}
</div>
<form action="#" class="page-list-form layui-form layui-form-pane" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">资讯标题：</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="novel[title]" value="{$novelinfo['title']}" autocomplete="off" placeholder="请填写标题">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">观看金币：</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="novel[gold]" value="{$novelinfo['gold']}" placeholder="0" autocomplete="off" >
        </div>
        <div class="layui-form-mid layui-word-aux "><br><span style="color: #FF5722;">*非会员观看需要支付金币</span></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">关键字：</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" name="novel[key_word]" value="{$novelinfo['key_word']}" autocomplete="off" placeholder="请填写关键字">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">上传图片</label>
        <div class="layui-input-inline upload">
            <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload"  id="upload_logo_chose_btn"">请上传图片</button>
            <input type="hidden" class="upload-input" name="novel[thumbnail]" id="site_logo" value="{$novelinfo['thumbnail']}">
            <img src="{$novelinfo['thumbnail']}" id="img_logo" onmouseover="imgTips(this,{ width:200,className:'imgTips',bgColor:'#fff' })" style="display:block;border-radius:5px;border:1px solid #ccc;max-width: 200px;">
        </div>
        <div class="layui-form-mid layui-word-aux"> 上传图片缩略图</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">视频标签</label>
        <div class="layui-input-inline" style="width: 50%;">
            {volist name="tag_result" id="v"}
            <input type="checkbox" class="layui-checkbox checkbox-ids"  name="tag[]"  {if in_array($v['id'],$novelinfo['tag'])}checked="checked" {/if}  value="{$v['id']}" title="{$v['name']}">
            {/volist}
        </div>
    </div>
    <div class="layui-form-item">

        <label class="layui-form-label layui-bg-gray">资讯分类：</label>
        <div class="layui-input-inline">
            <select name="novel[class]" class="field-pid" type="select" lay-filter="pai">
                {volist name="classlist" id="v" }
                <option value="{$v['id']}" level="{$v['id']}" {if condition="$v['id'] eq $novelinfo['class']"} selected="selected" {/if} >|-{$v['name']}</option>
                {volist name="v['childs']" id="vv" }
                <option value="{$vv['id']}" level="{$vv['id']}" {if condition="$vv['id'] eq $novelinfo['class']"} selected="selected" {/if} >|&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                {/volist}
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label layui-bg-gray">摘要</label>
        <div class="layui-input-inline">
            <textarea rows="6"  class="layui-textarea" name="novel[short_info]" autocomplete="off" placeholder="请填写视频说明">{$novelinfo['short_info']}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label  layui-bg-gray">内容:</label>
        <div class="layui-input-block">
            <textarea id="UEditor1" name="novel[content]" style="width: 60%;">{$novelinfo['content']}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" class="layui-btn"/>
        </div>
    </div>
</form>

{:editor(['UEditor1'], 'ueditor','/Xuploader.php?&from=ueditor')}

<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/plupload3/js/plupload.min.js"></script>
<script src="/static/plupload3/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>
<script>
    function afterUpLogo(resp){
        var resp=JSON.parse(resp);
        $('#img_logo').attr('src',resp.filePath);
        $('#site_logo').val(resp.filePath);
        layer.msg('上传完成',{time:500});
    }

    $(function(){
        createWebUploader('upload_logo_chose_btn','','novel','image',afterUpLogo);
    });

</script>

