<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/js/XCommon.js"></script>
<style>
 .layui-table[lay-skin=row] td, .layui-table[lay-skin=row] th{
        text-align: left;
    }
</style>
<form id="pageListForm" class="layui-form layui-form-pane" method="get">
    <div class="layui-btn-group">
        <a data-href="{:url('status?table=comment&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>通过</a>
        <a data-href="{:url('status?table=comment&val=2')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>拒绝</a>
        <a data-href="{:url('khdel?table=comment')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div>
    <div class="layui-form">
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <colgroup>
                <col width="50">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th width="40px;">ID</th>
                <th width="70px;">所属会员</th>
                <th width="300px;">内容</th>
                <th width="90px;">资源</th>
                <th width="90px;">更新时间</th>
                <th width="70px;">状态</th>
                <th width="70px;">操作</th>
            </tr>
            </thead>
            <tbody>
            {volist name="list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td class="font12">{$vo['id']}</td>
                <td class="font12">{$vo['username']}</td>
                <td class="font12">{$vo['content']}</td>
                <td class="font12">
                        类型：
                        {if condition="$vo['resources_type'] eq 1"}
                        视频
                        {/if}
                        {if condition="$vo['resources_type'] eq 2"}
                        图片
                        {/if}
                        {if condition="$vo['resources_type'] eq 3"}
                        资讯
                        {/if}
                        </br>
                        名称：{$vo['title']}
                </td>
                <td class="font12">{:date('Y-m-d H:i',$vo['last_time'])}</td>
                <td class="font12">
                    {if condition="$vo['status'] eq 1"}
                    <span style="color:green">已通过</span>
                    {/if}
                    {if condition="$vo['status'] eq 0"}
                    <span style="color:red">未处理</span>
                    {/if}
                    {if condition="$vo['status'] eq 2"}
                    <span style="color:blue">已拒绝</span>
                    {/if}
                </td>
                <td class="font12">
                    <div class="layui-btn-group">
                        <a data-href="{:url('khdel?table=comment&id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                    </div>
                </td>
            </tr>
            {/volist}
            </tbody>
        </table>

        {$pages}
    </div>
</form>