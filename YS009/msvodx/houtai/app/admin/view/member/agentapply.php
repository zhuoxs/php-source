<style>
    .layui-table[lay-skin=row] td, .layui-table[lay-skin=row] th{
        text-align: left;
    }
</style>
<div class="page-toolbar" >
    <div class="layui-btn-group fl">
        <a data-href="{:url('status?table=agent_apply&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>通过</a>
        <a data-href="{:url('status?table=agent_apply&val=2')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>拒绝</a>
        <a data-href="{:url('del?table=agent_apply')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div>
</div>
<form id="pageListForm">
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row">
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th>会员</th>
                <th>申请时间</th>
                <th>最后处理时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td class="font12">
                    <img src="{if condition="$vo['headimgurl']"}{$vo['headimgurl']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="60" height="60" class="fl">
                    <p class="ml10 fl"><strong class="mcolor">昵称：{$vo['nickname']} </strong><br>手机：{$vo['tel']}<br>邮箱：{$vo['email']}</p>
                </td>
                <td>{:date('Y-m-d H:i:s', $vo['apply_time'])}</td>
                <td>{:date('Y-m-d H:i:s', $vo['last_time'])}</td>
                <td>
                    {if condition="$vo['status'] eq 1"}
                    <span style="color:green">已通过</span>
                    {/if}
                    {if condition="$vo['status'] eq 0"}
                    <span style="color:blue">未处理</span>
                    {/if}
                    {if condition="$vo['status'] eq 2"}
                    <span style="color:red">已拒绝</span>
                    {/if}
                </td>
                <td>
                    <div class="layui-btn-group">
                        <div class="layui-btn-group">
                        <a data-href="{:url('del?table=agent_apply&ids='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                        </div>
                    </div>
                </td>
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
</form>
