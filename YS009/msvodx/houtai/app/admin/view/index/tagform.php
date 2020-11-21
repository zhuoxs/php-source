<form class="layui-form layui-form-pane" action="" method="post" id="editForm">
<div class="layui-tab-item layui-show layui-form-pane">
    <div class="layui-form-item">
        <label class="layui-form-label">标签类型</label>
        <div class="layui-input-inline">
<input value="{$type}" name="type" type="hidden"/>
                <input type="text" class="layui-input field-username"  lay-verify="required" autocomplete="off" disabled value="{if condition="$type eq 1"}视频标签{elseif condition="$type eq 2"}图片标签{elseif condition="$type eq 3"}资讯标签{/if}">

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">标&nbsp;&nbsp;&nbsp;&nbsp;签</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="name" lay-verify="required" autocomplete="off" placeholder="请输入标签">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排&nbsp;&nbsp;&nbsp;&nbsp;序</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-nick" name="sort" lay-verify="required" autocomplete="off" value="0">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">状&nbsp;&nbsp;&nbsp;&nbsp;态</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="status" value="1" title="启用" checked>
            <input type="radio" class="field-status" name="status" value="0" title="禁用">
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
        <a href="{:url('index/taglist',['t'=>'list'])}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
    </div>
</div>
</form>
<script>
var formData = {:json_encode($data_info)};
layui.use(['form'], function() {
    var $ = layui.jquery, form = layui.form;
    /* 有BUG 待完善*/
    form.on('checkbox(roleAuth)', function(data) {
        var child = $(data.elem).parent('dt').siblings('dd').find('input');
        /* 自动选中父节点 */
        var check_parent = function (id) {
            var self = $('.role-list-form input[value="'+id+'"]');
            var pid = self.attr('data-pid') || '';
            self.prop('checked', true);
            if (pid == '') {
                return false;
            }
            check_parent(pid);
        };
        /* 自动选中子节点 */
        child.each(function(index, item) {
            item.checked = data.elem.checked;
        });
        check_parent($(data.elem).attr('data-pid'));
        form.render('checkbox');
    });

    /* 权限赋值 */
    if (formData) {
        for(var i in formData['auth']) {
            $('.role-list-form input[value="'+formData['auth'][i]+'"]').prop('checked', true);
        }
        form.render('checkbox');
    }
});
</script>
<script src="__ADMIN_JS__/footer.js"></script>