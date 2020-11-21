<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">系统使用支付方式</label>
            <div class="layui-input-inline">
                <select name="system_payment_code" class="field-role_id" type="select"  name="look_at_measurement"  lay-skin="switch" lay-filter="look_at_measurement"  >
                    {volist name='paymentList' id='payment'}
                    <option value="{$payment['pay_code']}" {if condition="$payCode eq $payment['pay_code']"}selected=""{/if}>{$payment['pay_name']} ({if condition="$payment['is_third_payment'] eq 1"}第三方支付{else/}原生支付{/if})</option>
                    {/volist}
                    <option value="nativePay" {if condition="$payCode eq 'nativePay'"}selected=""{/if}>原生支付</option> <!--暂时隐藏$dreamer -->
                </select>
            </div>
            <div class="layui-form-mid layui-word-aux"> 原生支付：微信支付，支付宝；第三方支付：除原生支付以外的其他支付。</div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-inline">
                <input type="hidden" class="field-id" name="id">
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