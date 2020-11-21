<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        {volist name="loginList" id="v" }
        <fieldset class="layui-elem-field layui-field-title">
            <legend>{$v['login_name']}设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">开启状态</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="config[{$v['login_code']}][status]" lay-skin="switch" lay-text="开启|关闭" {if
                       condition="$v['status'] eq 1" }checked="" {/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">请设置为开启状态，否则不显示该登录方式</div>
        </div>
        {volist name="$v['config']" id="vv" }
     <div class="layui-form-item">
         <label class="layui-form-label">{$vv['desc']}</label>
         <div class="layui-input-inline">
             <input type="text" class="layui-input" name="config[{$v['login_code']}][{$vv['name']}]" value="{$vv['value']}"
                    autocomplete="off" placeholder="请填写{$vv['desc']}">
         </div>
     </div>
        {/volist}
 {/volist}
        <div class="layui-form-item">
            <div class="layui-input-inline">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
            </div>
        </div>
<div>&#25042;&#20154;&#28304;&#30721;&#119;&#119;&#119;&#46;&#108;&#97;&#110;&#114;&#101;&#110;&#122;&#104;&#105;&#106;&#105;&#97;&#46;&#99;&#111;&#109;&#32;&#20840;&#31449;&#36164;&#28304;&#50;&#48;&#22359;&#20219;&#24847;&#19979;&#36733;</div>
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
    function afterUpLogo(resp){
        $('#img_logo').attr('src',resp.filePath);
        $('#site_logo').val(resp.filePath);
        layer.msg('上传Logo完成',{time:500});
    }

    function afterUpIcon(resp){
        $('#img_ico').attr('src',resp.filePath);
        $('#site_favicon').val(resp.filePath);
        layer.msg('上传图标完成',{time:500});
    }

    $(function(){
        //函数调用说明  createWebUploader(选择上传的对象id,上传按钮id,指定文件名称,文件类型,上传完成回调)
        createWebUploader('upload_logo_chose_btn','','','image',afterUpLogo);
        createWebUploader('upload_ico_chose_btn','','','ico',afterUpIcon);
    });
</script>