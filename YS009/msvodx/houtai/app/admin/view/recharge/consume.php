<style>
    .layui-table[lay-skin=row] td, .layui-table[lay-skin=row] th{
        text-align: left;
    }
</style>
<div class="page-toolbar" >
    <div class="layui-btn-group fl">

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
                <th>ID</th>
                <th>会员</th>
                <th>消费金币</th>
                <th>消费内容</th>
                <th>消费时间</th>
            </tr>
            </thead>
            <tbody>
            {volist name="data_list" id="vo"}

            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td class="font12">
                {$vo['id']}
                </td>
                <td class="font12">
                    <img src="{if condition="$vo['headimgurl']"}{$vo['headimgurl']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="60" height="60" class="fl">
                    <p class="ml10 fl"><strong class="mcolor">昵称：{$vo['nickname']} </strong><br>手机：{$vo['tel']}<br>邮箱：{$vo['email']}</p>
                </td>
                <td class="font12">{$vo['gold']}</td>
                <td class="font12">
                    <p class="ml10 fl"><strong class="mcolor">{$title}：{$vo['title']} </strong><br>分类：{$vo['name']}<br></p>
                </td>
                <td class="font12">{:date('Y-m-d H:i:s', $vo['view_time'])}</td>
            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
</form>
