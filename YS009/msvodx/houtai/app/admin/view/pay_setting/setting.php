<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <input type="hidden" name="id" value="{$payBaseInfo['id']}">
        <div class="layui-form-item">
            <label class="layui-form-label">支付名称</label>
            <div class="layui-input-inline">
                <div class="layui-input-inline w200">
                    <input type="text" class="layui-input" name="pay_name" lay-verify="title" value="{$payBaseInfo['pay_name']}" readonly>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">支付方式代码</label>
            <div class="layui-input-inline">
                <div class="layui-input-inline w200">
                    <input type="text" class="layui-input" name="pay_code" lay-verify="title" value="{$payBaseInfo['pay_code']}" readonly>
                </div>
            </div>
        </div>
        {volist name="payParams" id="param"}
        <div class="layui-form-item">
            <label class="layui-form-label">{$param['desc']}</label>
            <div class="layui-input-inline">
                <div class="layui-input-inline w200">
                    {if in_array($param['type'],['string','int'])}
                        <input type="text" class="layui-input" name="{$param['name']}" lay-verify="title" value="{$param['value']}">
                    {else/}
                        <textarea class="layui-input" name="{$param['name']}" lay-verify="title" style="height:300px;">{$param['value']}</textarea>
                    {/if}
                </div>
            </div>
            <div class="layui-form-mid layui-word-aux"> {$param['name']}</div>
        </div>
        {/volist}

        <div class="layui-form-item">
            <div class="layui-input-inline">
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