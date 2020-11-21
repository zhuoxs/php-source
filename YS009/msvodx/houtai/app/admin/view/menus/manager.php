<div class=" layui-form menu-dl ">
<form class="page-list-form">
    <div class="page-toolbar">
        <div class="layui-btn-group fl">
            <a href="{:url('add')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加菜单</a>
            <a data-href="{:url('status?table=menu&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
            <a data-href="{:url('status?table=menu&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        </div>
    </div>
    <dl class="menu-dl1 menu-hd mt10">
        <dt>菜单名称</dt>
        <dd>
            <span class="hd">排序</span>
            <span class="hd2">状态</span>
            <span class="hd3">操作</span>
        </dd>
    </dl>
    {volist name="classlist" id="vv" key="kk"}
    <dl class="menu-dl1">
        <dt>
            <input type="checkbox" name="ids[{$kk}]" value="{$vv['id']}" class="checkbox-ids" lay-skin="primary" title="{$vv['name']}">
            <input type="text" class="menu-sort j-ajax-input" name="sort[{$kk}]" onkeyup="value=value.replace(/[^\d]/g,'')" value="{$vv['sort']}" data-value="{$vv['sort']}" data-href="{:url('sort?table=menu&ids='.$vv['id'])}">
            <input type="checkbox" name="status" value="{$vv['status']}" {if condition="$vv['status'] eq 1"}checked=""{/if} lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('status?table=menu&ids='.$vv['id'])}">
            <div class="menu-btns">
                <a href="{:url('edit',['id'=>$vv['id']])}" title="编辑"><i class="layui-icon">&#xe642;</i></a>
                <a href="{:url('add',['id'=>$vv['id']])}" title="添加子菜单"><i class="layui-icon">&#xe654;</i></a>
                <a href="{:url('del?table=menu&ids='.$vv['id'])}" class="j-dt-del" title="删除"><i class="layui-icon">&#xe640;</i></a>
            </div>
        </dt>
        <dd>
            {php}
            $kk++;
            {/php}
            {volist name="vv['childs']" id="vvv" key="kkk"}
            {php}
            $kk++;
            {/php}
            <dl class="menu-dl2">
                <dt>
                    <input type="checkbox" name="ids[{$kk}]" value="{$vvv['id']}" class="checkbox-ids" lay-skin="primary" title="{$vvv['name']}">
                    <input type="text" class="menu-sort j-ajax-input" name="sort[{$kk}]" onkeyup="value=value.replace(/[^\d]/g,'')" value="{$vvv['sort']}" data-value="{$vvv['sort']}" data-href="{:url('sort?table=menu&ids='.$vvv['id'])}">
                    <input type="checkbox" name="status" value="{$vvv['status']}" {if condition="$vvv['status'] eq 1"}checked=""{/if} lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('status?table=menu&ids='.$vvv['id'])}">
                    <div class="menu-btns">
                        <a href="{:url('edit',['id'=>$vvv['id']])}" title="编辑"><i class="layui-icon">&#xe642;</i></a>
                        <a href="{:url('del?table=menu&ids='.$vvv['id'])}" class="j-dt-del" title="删除"><i class="layui-icon">&#xe640;</i></a>
                    </div>
                </dt>
                {php}
                $kk++;
                {/php}
            </dl>
            {/volist}
        </dd>
    </dl>
    {php}
    $kk++;
    {/php}
    {/volist}
</form>
</div>

</div>