<script src="/static/js/jquery.2.1.4.min.js"></script>
<form class="layui-form layui-form-pane" action="{:url()}" method="post" id="editForm">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="username"  autocomplete="off" placeholder="请输入用户名" value="{$info['username']}" readonly>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">昵&nbsp;&nbsp;&nbsp;&nbsp;称</label>
        <div class="layui-input-inline">
            <input type="text" data-disabled class="layui-input field-nick" name="nickname" autocomplete="off" placeholder="请输入昵称" value="{$info['nickname']}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系邮箱</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-email" name="email" autocomplete="off" placeholder="请输入邮箱地址" value="{$info['email']}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系手机</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-mobile" name="tel" autocomplete="off" placeholder="请输入手机号码" value="{$info['tel']}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登录密码</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-mobile" id="password" name="password" autocomplete="off" placeholder="如不需要修改则留空" value="">
        </div>
        <a class="layui-btn layui-btn-primary ml10" onclick="$('#password').val('123456')">设为默认密码</a>
       （PS :  默认密码为123456）
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">会员有效期</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-expire_time" name="out_time" autocomplete="off" placeholder="请设置会员有效期" onclick="layui.laydate({elem: this,format:'YYYY-MM-DD'})" readonly value="{:date('Y-m-d', $info['out_time'])}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">金币数</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-mobile" name="money" autocomplete="off" placeholder="金币数" value="{$info['money']}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">永久会员</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="is_permanent" value="1" title="是" {if condition="$info['is_permanent'] eq 1"}checked=""{/if}  >
            <input type="radio" class="field-status" name="is_permanent" value="0" title="否" {if condition="$info['is_permanent'] neq 1"}checked=""{/if} >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="status" value="1" title="启用"  {if condition="$info['status'] eq 1"}checked=""{/if} >
            <input type="radio" class="field-status" name="status" value="0" title="禁用"  {if condition="$info['status'] neq 1"}checked=""{/if} >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否是代理</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="is_agent" value="1" title="是"  {if condition="$info['is_agent'] eq 1"}checked=""{/if} >
            <input type="radio" class="field-status" name="is_agent" value="0" title="否"  {if condition="$info['is_agent'] neq 1"}checked=""{/if} >
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" class="field-id" name="id"  value="{$info['id']}" >
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
            <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
        </div>
    </div>
</form>
<script>
var formData = {:json_encode($data_info)};

layui.use(['jquery', 'laydate'], function() {
    var $ = layui.jquery, laydate = layui.laydate;
    laydate.render({
        elem: '.field-expire_time',
        min:'0'
    });

    $('#reset_expire').on('click', function(){
        $('input[name="expire_time"]').val(0);
    });
});
</script>
<script src="__ADMIN_JS__/footer.js"></script>