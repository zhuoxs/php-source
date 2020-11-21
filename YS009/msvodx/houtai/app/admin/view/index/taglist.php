<div class="layui-tab-item layui-show">

<!--
+----------------------------------------------------------------------
| 列表页实例模板，Ctrl+A 可直接复制以下代码使用
+----------------------------------------------------------------------
-->
<form class="page-list-form">
<div class="layui-collapse page-tips">
  <div class="layui-colla-item">
      <div class="layui-btn-group fl">
          <a href="{:url('admin/index/taglist',array('t'=>'add','type'=>$type))}" class="layui-btn layui-btn-primary layui-bg-green"><i class="aicon ai-tianjia"></i>添加</a>
      </div>
  </div>
</div>
<div class="page-toolbar">

    <div class="page-filter fr">
       <form class="layui-form layui-form-pane" action="" method="get">
        <div class="layui-form-item">
            <label class="layui-form-label">搜索</label>
            <div class="layui-input-inline">
                <input type="text" name="keys" lay-verify="required" placeholder="请输入关键词搜索"  value="{$keys}" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-btn-group fl">
                <input class="layui-btn layui-btn-primary layui-bg-green" type="submit" value="搜索"/>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="layui-form">
    <table class="layui-table mt10" lay-even="" lay-skin="row">
        <colgroup>
            <col width="50">
            <col width="150">
            <col width="200">
            <col width="300">
            <col width="100">
            <col width="80">
            <col>
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th>ID</th>
                <th>标 签</th>
                <th>标签类型</th>
                <th>排序</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>

            {volist name="data_list" id="vo"}
            <tr>
                <td><input type="checkbox" class="layui-checkbox checkbox-ids" name="ids[]" value="{$vo['id']}" lay-skin="primary"></td>
                <td>{$vo['id']}</td>
                <td>{$vo['name']}</td>
                <td>{if condition="$vo['type'] eq 1"} 视频标签{elseif condition="$vo['type'] eq 2"/}图片标签{elseif condition="$vo['type'] eq 3"/}资讯标签{/if}</td>
                <td>
                    <input type="text" class="layui-input j-ajax-input input-sort" onkeyup="value=value.replace(/[^\d]/g,'')"
                           value="{$vo['sort']}" data-value="{$vo['sort']}" data-href="{:url('khsort?table=tag&ids='.$vo['id'])}">
                </td>
                <td>
                    <input type="checkbox" name="status" {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('khstatus?table=tag&ids='.$vo['id'])}">
                </td>
                <td>
                    <div class="layui-btn-group">
                        <div class="layui-btn-group">
                        <a href="{:url('admin/index/taglist',array('t'=>'edit','id'=>$vo['id'],'type'=>$type))}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                            {if condition="$vo['type'] eq 1"}
                            <a href="{:url('video/deleteTag',['table'=>'tag','id'=>$vo['id']])}" class="layui-btn layui-btn-primary layui-btn-small "><i class="layui-icon">&#xe640;</i>删除</a>
                            {elseif condition="$vo['type'] eq 2"/}
                            <a href="{:url('image/deleteTag',['table'=>'tag','id'=>$vo['id']])}" class="layui-btn layui-btn-primary layui-btn-small "><i class="layui-icon">&#xe640;</i>删除</a>
                            {elseif condition="$vo['type'] eq 3"/}
                            <a href="{:url('novel/deleteTag',['table'=>'tag','id'=>$vo['id']])}" class="layui-btn layui-btn-primary layui-btn-small "><i class="layui-icon">&#xe640;</i>删除</a>
                            {/if}
                        </div>
                    </div>
                </td>
            </tr>
            {/volist}
        </tbody>
    </table>
</div>
</form>
    {$pages}
</div>
