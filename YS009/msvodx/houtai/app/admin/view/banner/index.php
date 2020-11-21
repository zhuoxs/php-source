<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/js/XCommon.js"></script>
<style>
    td{
        border-right: dashed 1px #c7c7c7;
        text-align:center;
    }
    .layui-layer-tips{
       width: 830px!important;
    }
</style>
<form id="pageListForm">
    <div class="layui-btn-group">
        <a href="{:url('admin/banner/add')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('khstatus?table=banner&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
        <a data-href="{:url('khstatus?table=banner&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        <a data-href="{:url('khdel?table=banner')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
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
                <th width="100px;">缩略图</th>
                <th width="100px;">标题</th>
                <th width="300px;">外链</th>
                <th width="40px;">排序</th>
                <th width="100px;">说明</th>
                <th width="70px;">显示状态</th>
                <th width="100px;" style="text-align: center">操作</th>
            </tr>
            </thead>
            <tbody>
            {volist name="list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td>{$vo['id']}</td>
                <td>
                        <img height="30" src="{$vo['images_url']}" onmouseout="layer.closeAll();"  onmouseover="imgTips(this,{width:800})">
                </td>
                <td>{$vo['name']}</td>
                <td>{$vo['url']}</td>
                <td>
                    <input type="text" class="layui-input j-ajax-input input-sort" onkeyup="value=value.replace(/[^\d]/g,'')"
                           value="{$vo['sort']}" data-value="" data-href="{:url('khsort?table=banner&id='.$vo['id'])}">
                </td>
                <td>{$vo['info']}</td>
                <td>
                    <input type="checkbox" name="status" {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('khstatus?table=banner&ids='.$vo['id'])}">
                </td>
                <td>
                    <div class="layui-btn-group">
                        <a href="{:url('admin/banner/edit',['id'=>$vo['id']])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                        <a data-href="{:url('khdel?table=banner&id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                    </div>
                </td>
            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
</form>