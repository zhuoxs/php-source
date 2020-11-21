<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>添加礼物</legend>
        </fieldset>


        <div class="layui-form-item">
            <label class="layui-form-label">礼物名字</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="name" autocomplete="off" placeholder="请填写礼物名字">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">礼物图标</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload" id="upload_images_chose_btn">更改图标</button>
                <input type="hidden" class="upload-input" name="images" id="images" >
                <img id="img_ico" onmouseover="imgTips(this,{width:100,className:'imgTips'})" style="border-radius:5px;border:1px solid #ccc" width="36" height="36">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="sort" autocomplete="off" placeholder="请填写排序值">
            </div>
            <div class="layui-form-mid layui-word-aux">数值越大越靠前</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">价格</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="price" autocomplete="off" placeholder="请填写套餐价格">
            </div>
            <div class="layui-form-mid layui-word-aux">金币</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-inline">
                <textarea rows="6" class="layui-textarea" name="info" autocomplete="off" placeholder="请填写描述"></textarea>
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
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
</style>

<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/plupload-2.3.6/js/plupload.full.min.js"></script><script src="/static/plupload-2.3.6/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>

<script>
    function afterUpImages(resp){
        $('#img_ico').attr('src',resp.filePath);
        $('#images').val(resp.filePath);
        layer.msg('上传完成',{time:500});
    }

    $(function(){
        //函数调用说明  createWebUploader(选择上传的对象id,上传按钮id,指定文件名称,文件类型,上传完成回调)
        createWebUploader('upload_images_chose_btn','','','image',afterUpImages);
    });
</script>