<script src="/static/js/XCommon.js"></script>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<style>
    td{
        border-right: dashed 1px #c7c7c7;
        text-align:center;
    }
</style>
<form id="pageListForm" class="layui-form layui-form-pane" method="get">

        <div class="layui-colla-item">

                <table class="layui-table mt5" lay-even="" lay-skin="row">
                    <thead>
                    <tr>
                        <td>(当前图册)图集封面</td>
                        <td>图集标题</td>
                        <td>图集说明</td>
                    </tr>
                    </thead>
                    <tbody>
                    <td>
                        <a href="{$atlas['cover']}" target="pic">
                            <img height="30" src="{$atlas['cover']}" onmouseover="imgTips(this,{width:200,className:'imgTips',bgColor:'#fff'})">
                        </a>
                    </td>
                    <td>{$atlas['title']}</td>
                    <td>{$atlas['short_info']}</td>
                    </tbody>

                </table>

        </div>

    <div class="layui-btn-group">
        <a title="添加图片" href="{:url('admin/image/addimages?callback=rand',['id'=>$id])}" class="layui-btn layui-btn-primary j-iframe-pop"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('image_status?table=image&val=1')}" class="layui-btn layui-btn-primary j-page-btns "><i class="aicon ai-qiyong"></i>启用</a>
        <a data-href="{:url('image_status?table=image&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        <a data-href="{:url('image_del?table=image')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
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
                <th width="70px;">预览图</th>
                <th width="300px;">图片标题</th>
                <th width="90px;">添加时间</th>
                <th width="70px;">排序</th>
                <th width="70px;">显示状态</th>
                <th width="200px;" style="text-align: center">操作</th>
            </tr>
            </thead>
            <tbody>
            {volist name="data_list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td>{$vo['id']}</td>
                <td>
                        <a href="{$vo['url']}" target="pic">
                        <img height="30" src="{$vo['url']}" onmouseover="imgTips(this,{width:200,className:'imgTips',bgColor:'#fff'})">
                        </a>
                </td>
                <td>{$vo['title']}</td>
                <td>{:date('Y-m-d',$vo['add_time'])}</td>
                <td >
                <input type="text" class="menu-sort j-ajax-input" style="width: 20px;" name="sort" onkeyup="value=value.replace(/[^\d]/g,'')" value="{$vo['sort']}" data-value="{$vo['sort']}" data-href="{:url('image_sort?table=image&ids='.$vo['id'])}">
                </td>
                <td>
                    <input type="checkbox" name="status" {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('image_status?table=image&ids='.$vo['id'])}">
                </td>
                <td>
                    <div class="layui-btn-group">
             <!--           <a href="{:url('admin/image/imageedit',['id'=>$vo['id']])}"  title="编辑" class="layui-btn layui-btn-primary layui-btn-small j-iframe-pop"><i class="layui-icon">&#xe642;</i></a>
                    -->   <a data-href="{:url('image_del?table=image&id='.$vo['id'])}"  title="删除" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                    </div>
                </td>
            </tr>
            {/volist}
            {if empty($data_list)}<td colspan="12">赶快上传第一张图片吧！</td>{/if}
            </tbody>
        </table>
       <div class="pagination" style="float: left;">
            <a href="{:url('admin/image/randclick?callback=rand')}" class="layui-btn layui-btn-primary j-iframe-pop fl">随机点击</a>
       </div>
        {$pages}
    </div>
</form>