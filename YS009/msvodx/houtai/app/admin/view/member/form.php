<form class="layui-form layui-form-pane" action="{:url()}" method="post" id="editForm">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="username"  autocomplete="off" placeholder="请输入用户名">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">昵&nbsp;&nbsp;&nbsp;&nbsp;称</label>
        <div class="layui-input-inline">
            <input type="text" data-disabled class="layui-input field-nick" name="nickname" autocomplete="off" placeholder="请输入昵称">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登陆密码</label>
        <div class="layui-input-inline">
            <input type="password" class="layui-input" name="password" autocomplete="off" placeholder="请输入密码">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系邮箱</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-email" name="email" autocomplete="off" placeholder="请输入邮箱地址">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系手机</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-mobile" name="tel" autocomplete="off" placeholder="请输入手机号码">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">会员有效期</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-expire_time" name="out_time" autocomplete="off" placeholder="请设置会员有效期" onclick="layui.laydate({elem: this,format:'YYYY-MM-DD'})" readonly>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">永久会员</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="is_permanent" value="1" title="是" >
            <input type="radio" class="field-status" name="is_permanent" value="0" title="否" checked>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否是代理</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="is_agent" value="1" title="是" >
            <input type="radio" class="field-status" name="is_agent" value="0" title="否" checked>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="status" value="1" title="启用" checked>
            <input type="radio" class="field-status" name="status" value="0" title="禁用">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" class="field-id" name="id">
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