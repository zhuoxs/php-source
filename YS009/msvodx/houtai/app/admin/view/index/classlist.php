<style>
    .menu-bt {
        left: 896px;
        position: absolute;
        top: 3px;
    }
</style>
<div class=" layui-form menu-dl ">
<form class="page-list-form">
    <div class="page-toolbar">
        <div class="layui-btn-group fl">
            <a href="{:url('classadd',['type'=>$type])}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
            <a data-href="{:url('khstatus?table=class&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
            <a data-href="{:url('khstatus?table=class&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
            <!--<a data-href="{:url('khdel?table=class')}" class="layui-btn layui-btn-primary j-page-btns confir m"><i class="aicon ai-jinyong"></i>删除</a>-->

        </div>
    </div>
    <dl class="menu-dl1 menu-hd mt10">
        <dt>菜单名称</dt>
        <dd>
            <span class="hd">排序</span>
            <span class="hd2">状态</span>
            <span class="hd3">显示在首页</span>
            <span style="top: -26px;    left: 910px;position: absolute;">操作</span>
        </dd>
    </dl>
    {volist name="classlist" id="vv" key="kk"}
    <dl class="menu-dl1">
        <dt>
            <input type="checkbox" name="ids[{$kk}]" value="{$vv['id']}" class="checkbox-ids" lay-skin="primary" title="{$vv['name']}">
            <input type="text" class="menu-sort j-ajax-input" name="sort[{$kk}]" onkeyup="value=value.replace(/[^\d]/g,'')" value="{$vv['sort']}" data-value="{$vv['sort']}" data-href="{:url('khsort?table=class&ids='.$vv['id'])}">
            <input type="checkbox" name="status" value="{$vv['status']}" {if condition="$vv['status'] eq 1"}checked=""{/if} lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('khstatus?table=class&ids='.$vv['id'])}">
           {if empty($vv['childs'])}
            <div class="menu-btns" style=" left: 198px;">
                <input type="checkbox" name="status" value="{$vv['home_dispay']}" {if condition="$vv['home_dispay'] eq 1"}checked=""{/if} lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('khstatus?table=class&field=home_dispay&ids='.$vv['id'])}">
            </div>
            {/if}
            <div class="menu-bt">
                <a href="{:url('classedit',['id'=>$vv['id'],'type'=>$type])}" title="编辑"><i class="layui-icon">&#xe642;</i></a>
                <a href="{:url('classadd',['id'=>$vv['id'],'type'=>$type])}" title="添加子菜单"><i class="layui-icon">&#xe654;</i></a>
                {if condition="$vv['type'] eq 1"}
                <a href="{:url('video/deleteClass',['table'=>'class','id'=>$vv['id']])}"  class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe640;</i>删除</a>
                {elseif condition="$vv['type'] eq 2"/}
                <a href="{:url('image/deleteClass',['table'=>'class','id'=>$vv['id']])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe640;</i>删除</a>
                {elseif condition="$vv['type'] eq 3"/}
                <a href="{:url('novel/deleteClass',['table'=>'class','id'=>$vv['id']])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe640;</i>删除</a>
                {/if}
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
                    <input type="text" class="menu-sort j-ajax-input" name="sort[{$kk}]" onkeyup="value=value.replace(/[^\d]/g,'')" value="{$vvv['sort']}" data-value="{$vvv['sort']}" data-href="{:url('khsort?table=class&ids='.$vvv['id'])}">
                    <input type="checkbox" name="status" value="{$vvv['status']}" {if condition="$vvv['status'] eq 1"}checked=""{/if} lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('khstatus?table=class&ids='.$vvv['id'])}">
                    <div class="menu-btns" style="left: 198px;">
                        <input type="checkbox" name="statu" value="{$vvv['home_dispay']}" {if condition="$vvv['home_dispay'] eq 1"}checked=""{/if} lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('khstatus?table=class&field=home_dispay&ids='.$vvv['id'])}">
                   </div>
                    <div class="menu-bt">
                        <a href="{:url('classedit',['id'=>$vvv['id'],'type'=>$type])}" title="编辑"><i class="layui-icon">&#xe642;</i></a>
                        {if condition="$vvv['type'] eq 1"}
                        <a href="{:url('video/deleteClass',['table'=>'class','id'=>$vvv['id']])}" class="layui-btn layui-btn-primary layui-btn-small "><i class="layui-icon">&#xe640;</i>删除</a>
                        {elseif condition="$vvv['type'] eq 2"/}
                        <a href="{:url('image/deleteClass',['table'=>'class','id'=>$vvv['id']])}" class="layui-btn layui-btn-primary layui-btn-small "><i class="layui-icon">&#xe640;</i>删除</a>
                        {elseif condition="$vvv['type'] eq 3"/}
                        <a href="{:url('novel/deleteClass',['table'=>'class','id'=>$vvv['id']])}" class="layui-btn layui-btn-primary layui-btn-small "><i class="layui-icon">&#xe640;</i>删除</a>
                        {/if}
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