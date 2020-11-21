<div class="page-toolbar" >
    <div class="layui-btn-group fl">

    </div>
</div>
<form id="pageListForm">
    <div class="layui-form">
        <div class="layui-btn-group">
            <a title="站点添加" href="{:url('admin/websitegroup/add_website')}" height="600" width='600'class="layui-btn layui-btn-primary j-iframe-poq"><i class="aicon ai-tianjia"></i>添加</a>
        </div>
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <colgroup>
                <col width="60">
            </colgroup>
            <thead>
            <tr>
                <th>ID</th>
                <th>站群域名</th>
                <th>站群标题</th>
                <th>网站logo地址</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            {volist name="netlist" id="vo"}
            <tr>
                <td class="font12">
                  {$vo['id']}
                </td>
                <td class="font12">
                    {$vo['domain']}
                </td>
                <td class="font12">{$vo['site_title']}</td>
                <td class="font12">
                    <img src="{if condition="$vo['logo_url']"}{$vo['logo_url']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="60" height="60" class="fl">
                </td>
                <td class="font12">添加时间：{:date('Y-m-d H:i:s', $vo['add_time'])} </td>

                <td class="font12">
                    <a href="{:url('del?table=website_group_setting&id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                    <a href="{:url('admin/websitegroup/edit_website',['id'=>$vo['id']])}" height="500" width='600' title="编辑" class="layui-btn layui-btn-primary layui-btn-small j-iframe-poq"><i class="layui-icon">&#xe642;</i></a>
                </td>
            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
</form>
