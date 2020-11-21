<style>
    .layui-table[lay-skin=row] td, .layui-table[lay-skin=row] th{
        text-align: left;
    }
</style>
<div class="page-toolbar" style="overflow: visible">
    <div class="layui-btn-group fl">
        <a href="{:url('add')}" class="layui-btn layui-btn-primary"><i class="aicon ai-tianjia"></i>添加</a>
        <a data-href="{:url('status?table=member&val=1')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-qiyong"></i>启用</a>
        <a data-href="{:url('status?table=member&val=0')}" class="layui-btn layui-btn-primary j-page-btns"><i class="aicon ai-jinyong1"></i>禁用</a>
        <a data-href="{:url('del?table=member')}" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="aicon ai-jinyong"></i>删除</a>
    </div>
    <div class="fr">
        <form class="page-list-form">
            <div class="layui-form-item ">
                <div class="layui-input-inline layui-form">
                    <select name="member_type" lay-verify="">
                        <option value="0" >所有用户</option>
                        <option value="1"  {if condition="$member_type eq 1"}selected="selected"{/if} >普通用户</option>
                        <option value="2"  {if condition="$member_type eq 2"}selected="selected"{/if} >所有vip</option>
                        <option value="3"  {if condition="$member_type eq 3"}selected="selected"{/if} >普通vip</option>
                        <option value="4"  {if condition="$member_type eq 4"}selected="selected"{/if}>永久vip</option>
                    </select>
                </div>
                <div class="layui-input-inline layui-form">
                    <select name="key" lay-verify="">
                        <option value="nickname" {if condition="$keys eq 'nickname'"}selected="selected"{/if}>昵称</option>
                        <option value="tel" {if condition="$keys eq 'tel'"}selected="selected"{/if} >手机号</option>
                        <option value="email" {if condition="$keys eq 'email'"}selected="selected"{/if}>邮箱</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="keyword" lay-verify="required" placeholder="请输入关键词搜索" autocomplete="off" class="layui-input" value="{$keyword|default=""}" >
                </div>
                <input class="layui-btn" type="submit" value="搜索">
            </div>
        </form>
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
                <th>会员</th>
                <th>会员类型</th>
                <th>金币</th>
                <th>注册&登陆</th>
                <th>代理商</th>
                <th>状态</th>
                <th>操作</th>
            </tr> 
        </thead>
        <tbody>
            {volist name="data_list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td class="font12">
                    <img src="{if condition="$vo['headimgurl']"}{$vo['headimgurl']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="60" height="60" class="fl">
                    <p class="ml10 fl">{$vo['nickname']} &nbsp; ({$vo['username']})<br>手机：{$vo['tel']|default="-"}<br>邮箱：{$vo['email']}</p>
                </td>
                <td class="font12">{if $vo['is_permanent']==1}永久VIP{elseif $vo['out_time']>time()}VIP{else/}普通用户{/if}</td>
                <td class="font12">余额：{$vo['money']}</td>
                <td class="font12">注册：{:date('Y-m-d H:i:s', $vo['add_time'])}<br>登陆：{:date('Y-m-d H:i:s', $vo['last_time'])}</td>
                <td><input type="checkbox" name="is_agent" {if condition="$vo['is_agent'] eq 1"}checked=""{/if} value="{$vo['is_agent']}" lay-skin="switch" lay-filter="switchStatus" lay-text="是|否" data-href="{:url('isAgent?ids='.$vo['id'])}"></td>
                <td><input type="checkbox" name="status" {if condition="$vo['status'] eq 1"}checked=""{/if} value="{$vo['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="{:url('status?table=member&ids='.$vo['id'])}"></td>
                <td>
                    <div class="layui-btn-group">
                        <div class="layui-btn-group">
                        <a href="{:url('edit?id='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon">&#xe642;</i></a>
                        <a data-href="{:url('del?table=member&ids='.$vo['id'])}" class="layui-btn layui-btn-primary layui-btn-small j-tr-del"><i class="layui-icon">&#xe640;</i></a>
                        </div>
                    </div>
                </td>
            </tr>
            {/volist}
        </tbody>
    </table>
    {$pages}
</div>
</form>
