<form class="layui-form layui-form-pane" action="" method="post" id="editForm">
    <div class="layui-collapse page-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">温馨提示</h2>
            <div class="layui-colla-content">
                <p>后台权限验证采用白名单方式，而白名单数据均来源于系统菜单。请严格按照系统要求填写菜单链接和扩展参数。</p>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">所属菜单</label>
        <div class="layui-input-inline">
            <select name="pid" class="field-pid" type="select" lay-filter="pai">
                <option value="0" level="0">顶级菜单</option>
                {volist name="fclass" id="v" }
                {if condition="$classinfo['id'] neq $v['id']"}
                <option value="{$v['id']}" level="{$v['id']}" {if condition="$classinfo['pid'] eq $v['id']"}   selected="selected" {/if}>{$v['name']}</option>
                {/if}
                {/volist}
            </select>
        </div>
        <div class="layui-form-mid layui-word-aux">
            尽量选择与所属模块一致的菜单，根据 “[ ]” 里面的内容判断
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-title" name="name" lay-verify="required" autocomplete="off" value="{$classinfo['name']}" placeholder="请输入菜单名称">
        </div>
        <div class="layui-form-mid layui-word-aux">
            必填，长度限制3-24个字节(1个汉字等于3个字节)
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">状态设置</label>
        <div class="layui-input-inline">
            <input type="radio" class="field-status" name="status" value="1" title="启用" checked>
            <input type="radio" class="field-status" name="status" value="0" title="禁用">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" class="field-id" value="{$classinfo['id']}" name="id">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
            <a href="{:url('admin/index/classlist',['type'=>$type])}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
        </div>
    </div>
</form>
<script>
    var formData = {:json_encode($data_info)};
    layui.use(['form'], function() {
        var $ = layui.jquery, form = layui.form;

        if (formData) {
            $('.ass-level').val(parseInt($('.field-pid option:selected').attr('level'))+1);
        }
    });
</script>
<script src="__ADMIN_JS__/footer.js"></script>