<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>邮件设置</legend>
        </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">邮箱服务器</label>
            <div class="layui-input-inline">
                <div class="layui-input-inline">
                    <input type="text"  class="layui-input" name="email_host" value="{$config['email_host']}" autocomplete="off" placeholder="邮箱服务器">
                </div>
                <div class="layui-form-mid layui-word-aux" >如 smtp.163.com</div>

            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" >发送邮箱</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="send_email" value="{$config['send_email']}" autocomplete="off" placeholder="发送邮箱">
            </div>
            <div class="layui-form-mid layui-word-aux" >发送者163邮箱账号</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" >授权密码</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="email_password" value="{$config['email_password']}" autocomplete="off" placeholder="发送邮箱">
            </div>
            <div class="layui-form-mid layui-word-aux">发送者邮箱授权密码</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" >端口号</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="email_port" value="{$config['email_port']}" autocomplete="off" placeholder="端口号">
            </div>
            <div class="layui-form-mid layui-word-aux">邮箱服务器端口号,一般为25</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" >邮件地址</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="from_email" value="{$config['from_email']}" autocomplete="off" placeholder="发送者email地址">
            </div>
            <div class="layui-form-mid layui-word-aux">发送者email地址</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" >发件人名称</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="email_from_name" value="{$config['email_from_name']}" autocomplete="off" placeholder="发件人名称">
            </div>
            <div class="layui-form-mid layui-word-aux">发件人名称</div>
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

