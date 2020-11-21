<div class="page-toolbar" >
    <div class="layui-btn-group fl">

    </div>
</div>
<form id="pageListForm">
    <div class="layui-btn-group">
        <a title="广告位添加" href="{:url('admin/poster/add')}" class="layui-btn layui-btn-primary j-iframe-poq"><i class="aicon ai-tianjia"></i>添加</a>
    </div>
    <div class="layui-form">
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <colgroup>
                <col width="50">
            </colgroup>
            <thead>
            <tr>
                <th>ID</th>
                <th>广告标题</th>
                <th>广告宽×高</th>

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
                    <p class="ml10 fl"><strong class="mcolor">广告位标题：{$vo['title']} </strong></p>
                </td>

                <td class="font12">
                    {$vo['width']}×{$vo['height']}
                </td>
                <td class="font12">
                    <a href="{:url('del?table=advertisement_position&id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                    <a href="{:url('admin/poster/edit',['id'=>$vo['id']])}"  title="编辑"   class="layui-btn layui-btn-primary layui-btn-small j-iframe-pop"><i class="layui-icon">&#xe642;</i></a>
                    <a   class="layui-btn layui-btn-primary layui-btn-small show" data-id="{$vo['id']}" title="查看代码"><i class="layui-icon">&#xe609;</i></a>
                </td>
            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
</form>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="__ADMIN_JS__/layui/layui.js"></script>
<script>
    $('.show').click(function(){
        var id=$(this).data('id');
        var html='<script language="javascript" src="/poster/index/pid/'+id+'"><'+'/script>';
        layer.prompt({
            formType: 2,
            value: html,
            title: '复制代码到你的广告位中',
            area: ['500px', '200px'] //自定义文本域宽高
        });
    })
</script>