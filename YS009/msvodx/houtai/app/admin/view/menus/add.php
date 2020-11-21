<form class="layui-form layui-form-pane" action="" method="post" id="editForm">
    <div class="layui-form-item">
        <label class="layui-form-label">所属菜单</label>
        <div class="layui-input-inline">
            <select name="pid" class="field-pid" type="select" lay-filter="pai">
                <option value="0" level="0">顶级菜单</option>
                {volist name="fclass" id="v" }
                <option value="{$v['id']}" level="{$v['id']}" {if condition="$v['id'] eq $pid"} selected {/if}>{$v['name']}</option>
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
            <input type="text" class="layui-input field-title" name="name" lay-verify="required" autocomplete="off" value="" placeholder="请输入菜单名称">
        </div>
        <div class="layui-form-mid layui-word-aux">
            必填，长度限制3-24个字节(1个汉字等于3个字节)
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-inline" style="width:120px;">
            <input type="radio" name="type" value="1"   checked id="outlink_radio" title="绑定链接">
        </div>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-title" name="url" lay-verify="required" autocomplete="off" value="http://" placeholder="http://">
        </div>
        <div class="layui-input-inline" style="width:120px;">
            <input type="radio" name="type" value="2" id="outlink_radio" title="绑定分类">
        </div>
            <div class="layui-input-inline">
            <select name="class">
                <option value="">请选择</option>
                <option value="video"  level="video"  >视频</option>
                {volist name="classlist" id="v" }
                {if condition="$v['type'] eq 1"}
                <option value="{$v['id']}" level="{$v['id']}"  >|-{$v['name']}</option>
                {volist name="v['childs']" id="vv" }
                <option value="{$vv['id']}" level="{$vv['id']}" >|&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                {/volist}
                {/if}
                {/volist}

                <option value="images"  level="images"  >图片</option>
                {volist name="classlist" id="v" }
                {if condition="$v['type'] eq 2"}
                <option value="{$v['id']}" level="{$v['id']}"  >|-{$v['name']}</option>
                {volist name="v['childs']" id="vv" }
                <option value="{$vv['id']}" level="{$vv['id']}" >|&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                {/volist}
                {/if}
                {/volist}

                <option value="novel"  level="novel"  >资讯</option>
                {volist name="classlist" id="v" }
                {if condition="$v['type'] eq 3"}
                <option value="{$v['id']}" level="{$v['id']}"  >|-{$v['name']}</option>
                {volist name="v['childs']" id="vv" }
                <option value="{$vv['id']}" level="{$vv['id']}" >|&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                {/volist}
                {/if}
                {/volist}
            </select>
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
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
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
