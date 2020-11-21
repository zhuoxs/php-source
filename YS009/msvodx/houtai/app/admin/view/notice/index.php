
<form id="pageListForm" class="layui-form">
    <div class="page-toolbar">
        <div class="layui-btn-group">
            <a href="{:url('add')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
            <a data-href="{:url('khstatus?table=notice&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
            <a data-href="{:url('khstatus?table=notice&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
            <a data-href="{:url('khdel?table=notice')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
        </div>
    </div>
    <table class="layui-table mt10" lay-even="" lay-skin="row">
        <colgroup>
            <col width="50">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th>ID</th>
                <th>标题</th>
                <th>内容</th>
                <th width="80">展示方式</th>
                <th width="100">过期时间</th>
                <th width="40">排序</th>
                <th>状态</th>
                <th width="100">操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids"  value="{$vo['id']}"  lay-skin="primary"></td>
                <td>{$vo['id']}</td>
                <td>{$vo['title']}</td>
                <td>{if condition="$vo['type'] eq 1"}{$vo['content']}{else/}{$vo['url']}{/if} </td>
                <td> {if condition="$vo['type'] eq 1"}弹出层显示{else/}网页转跳{/if} </td>
                <td>{:date('Y-m-d H:i:s',$vo['out_time'])}</td>
                <td>{$vo['sort']}</td>
                <td>
                    <input type="checkbox"  {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('khstatus?table=notice&ids='.$vo['id'])}">
                </td>
                <td> 
                    <div class="layui-btn-group">
                        <a href="{:url('edit?id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small ">编辑</a>
                        <a data-href="{:url('del?table=notice&ids='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del">删除</a>
                    </div>
                </td>
            </tr>
            {/volist}
        </tbody>
    </table>
</form>