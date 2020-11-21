<style>
    .layui-table[lay-skin=row] td, .layui-table[lay-skin=row] th{
       text-align: left;
    }
</style>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<div class="page-toolbar" >
    <div class="layui-btn-group fl">

    </div>
</div>
<form id="pageListForm" class="layui-form layui-form-pane" method="get">
    <div class="layui-btn-group">
        <a href="{:url('add')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('del?table=card_password')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div>
    <div  style="margin-left: 10px; display: inline-block;float: right; ">
        <div class="layui-input-inline">
            <select name="card_type" lay-verify=""  lay-filter="filter" >
                <option value="0">卡密类型</option>
                <option value="1" {if condition="$card_type eq 1"}  selected="selected"{/if}>会员卡</option>
                <option value="2" {if condition="$card_type eq 2"}  selected="selected"{/if}>金币卡</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="status" lay-verify=""  lay-filter="filter">
                <option value="0">使用状态</option>
                <option value="1" {if condition="$status eq 1"}  selected="selected"{/if}>已使用</option>
                <option value="2" {if condition="$status eq 0"}  selected="selected"{/if}>未使用</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <a class="layui-btn layui-btn-primary" href="{:url('export',array('condition'=>urlencode($where)))}" target="_blank">导出当前所有数据</a>
        </div>


        <!--<div class="layui-input-inline">
            <select name="card_type" lay-verify="">
                <option value="0">默认排序</option>
                <option value="1" {if condition="$status eq 1"}  selected="selected"{/if}>过期时间</option>
                <option value="2" {if condition="$status eq 0"}  selected="selected"{/if}>添加时间</option>
            </select>
        </div>-->
    </div>
    <div class="layui-form">
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <colgroup>
                <col width="50">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th>卡号</th>
                <th>卡密类型</th>
                <th>
                    价格
                    <span class="layui-table-sort layui-inline" {if condition="$order eq 'price_desc'"} lay-sort="desc"{/if}  {if condition="$order eq 'price_asc'"} lay-sort="asc"{/if} >
                        <i class="layui-edge layui-table-sort-asc" sort="price_asc"></i>
                        <i class="layui-edge layui-table-sort-desc" sort="price_desc"></i>
                    </span>
                </th>
                <th>内容</th>
                <th>状态</th>
                <th>
                    过期时间
                    <span class="layui-table-sort layui-inline" {if condition="$order eq 'out_time_desc'"} lay-sort="desc"{/if}  {if condition="$order eq 'out_time_asc'"} lay-sort="asc"{/if} >
                        <i class="layui-edge layui-table-sort-asc" sort="out_time_asc"></i>
                        <i class="layui-edge layui-table-sort-desc" sort="out_time_desc"></i>
                    </span>
                </th>
                <th>
                    添加时间
                    <span class="layui-table-sort layui-inline" {if condition="$order eq 'add_time_desc'"} lay-sort="desc"{/if}  {if condition="$order eq 'add_time_asc'"} lay-sort="asc"{/if} >
                        <i class="layui-edge layui-table-sort-asc" sort="add_time_asc"></i>
                        <i class="layui-edge layui-table-sort-desc" sort="add_time_desc"></i>
                    </span>
                </th>
                <th  style="text-align: center">操作</th>
            </tr>
            </thead>
            <tbody>
            {volist name="list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td >
                    {$vo['card_number']}
                </td>
                <td >
                    {if $vo['card_type']==2}
                    金币卡
                    {elseif $vo['card_type']===1}
                    会员卡
                    {/if}
                </td>
                <td >{$vo['price']}元</td>
                <td >
                    {if $vo['card_type']==2}
                    {$vo['gold']}金币
                    {elseif $vo['card_type']===1}
                        {if $vo['vip_time']==999999999}
                        永久vip
                        {else/}
                         vip{$vo['vip_time']}天
                        {/if}
                    {/if}
                </td>

                <td >
                    {if condition="$vo['status'] eq 1"}
                    <span style="color: green">已使用</span>
                    {else/}
                    <span style="color: red">未使用</span>
                    {/if}
                </td>
                <td >{:date('Y-m-d H:i', $vo['out_time'])}</td>
                <td >{:date('Y-m-d H:i', $vo['add_time'])}</td>
                <td style="text-align: center">
                    <div class="layui-btn-group" >
                        <a data-href="{:url('del?table=card_password&id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                    </div>
                </td>
            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
    <input type="hidden" name="order" id="order">
    <script>
        layui.use('form', function(){
            var form = layui.form;
            form.on('select(filter)', function (data) {
                $('#pageListForm').submit();
            });
            $('.layui-table-sort').find('i').click(function(){
                var order = $(this).attr('sort');
                $('#order').val(order);
                $('#pageListForm').submit();
            })
            //各种基于事件的操作，下面会有进一步介绍
        });
    </script>
</form>
