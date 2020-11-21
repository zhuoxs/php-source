<div class="page-toolbar" >
    <div class="layui-btn-group fl">

    </div>
</div>
<form id="pageListForm">
    <div class="layui-form">
        <div class="layui-btn-group">
            <a title="广告添加" href="{:url('admin/poster/add_poster')}" height="600" class="layui-btn layui-btn-primary j-iframe-poq"><i class="aicon ai-tianjia"></i>添加</a>
        </div>
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <colgroup>
                <col width="60">
            </colgroup>
            <thead>
            <tr>
                <th>ID</th>
                <th>广告信息</th>
                <th>广告位置</th>
                <th>广告起止时间及外链</th>
                <th>广告添加信息</th>
                <th>开启状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            {volist name="data_list" id="vo"}
            <tr>
                <td class="font12">
                  {$vo['id']}
                </td>
                <td class="font12">
                    <img src="{if condition="$vo['content']"}{$vo['content']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="60" height="60" class="fl">
                    <p class="ml10 fl"><strong class="mcolor">广告位标题：{$vo['titles']} </strong><br>类型：{if condition="$vo['type'] eq 2 "}用户自定义{/if}{if condition="$vo['type'] eq 1 "}广告代码{/if}<br>说明：{$vo['info']}</p>
                </td>
                <td class="font12">{$vo['title']}</td>
                <td class="font12">
                    <p class="ml10 fl"><strong class="mcolor">{:date('Y-m-d H:i:s', $vo['begin_time'])}-至-{:date('Y-m-d H:i:s', $vo['end_time'])}</strong>      <br>广告外链：{$vo['url']}<br></p>
                </td>
                <td class="font12">添加时间：{:date('Y-m-d H:i:s', $vo['add_time'])}
                    <br>所属域名：{$vo['host']}<br></p>
                </td>
                <td class="font12">
                    <input type="checkbox"  {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('status?table=advertisement&ids='.$vo['id'])}">
                </td>
                <td class="font12">
                    <a href="{:url('del?table=advertisement&id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                    <a href="{:url('admin/poster/edit_poster',['id'=>$vo['id']])}"  height="600" title="编辑" class="layui-btn layui-btn-primary layui-btn-small j-iframe-poq"><i class="layui-icon">&#xe642;</i></a>
                </td>
            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
</form>
