<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>邮件设置</legend>
        </fieldset>
        <div class="layui-collapse page-tips">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">温馨提示<i class="layui-icon layui-colla-icon"></i></h2>
                <div class="layui-colla-content layui-show">
                    <p>平台短信接口为创蓝253短信服务商的接口，如要使用短信功能请先申请短信服务商账号购买短信。服务商网址 http://www.253.com/ </p>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" >短信api账号</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="sms_api_account" value="{$config['sms_api_account']}" autocomplete="off" placeholder="短信api账号">
            </div>
            <div class="layui-form-mid layui-word-aux" >短信api账号</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" >短信api密码</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="sms_api_password" value="{$config['sms_api_password']}" autocomplete="off" placeholder="短信api密码">
            </div>
            <div class="layui-form-mid layui-word-aux" >短信api账号</div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
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

