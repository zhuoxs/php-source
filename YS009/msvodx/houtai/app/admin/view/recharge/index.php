<style>
    .layui-table[lay-skin=row] td, .layui-table[lay-skin=row] th{
       text-align: left;
    }
</style>
<div class="page-toolbar" >
    <div class="layui-btn-group fl">

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
                <th>会员信息</th>
                <th>订单号</th>
                <th>购买类型</th>
                <th>描述</th>
                <th>价格</th>
                <th>订单时间</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
            {volist name="data_list" id="vo"}
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['order_sn']}" lay-skin="primary"></td>
                <td class="font12">
                    <img src="{if condition="$vo['headimgurl']"}{$vo['headimgurl']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="60" height="60" class="fl">
                    <p class="ml10 fl"><strong class="mcolor">昵称：{$vo['nickname']} </strong><br>手机：{$vo['tel']}<br>邮箱：{$vo['email']}</p>
                </td>
                <td class="font12">{$vo['order_sn']}</td>
                <td class="font12">{if $vo['buy_type']==2}购买VIP{elseif $vo['buy_type']===1}充值金币{/if}</td>
                <td class="font12">
                    <!--充值描述 start-->
                    {if $vo['buy_type']==2}
                        <div>
                            套餐名称: <span class="layui-badge layui-bg-black">{$vo.buy_vip_info.name}</span> <br />
                            会员期限: <span class="layui-badge layui-bg-black">{if $vo['buy_vip_info']['permanent']===1}永久{else/}{$vo['buy_vip_info']['days']}天{/if}</span> <br />
                            套餐价格: <span class="layui-badge layui-bg-black">{$vo['buy_vip_info']['price']}</span> <br />
                        </div>
                    {elseif $vo['buy_type']===1}
                        充值金币<span class="layui-badge layui-bg-black">{$vo['buy_glod_num']}</span>个
                    {/if}
                    <!--充值描述 end-->
                </td>
                <td class="font12">{$vo['price']}元</td>
                <td class="font12">下单时间：{:date('Y-m-d H:i:s', $vo['add_time'])}{notempty name="$vo['pay_time']"}<br>支付时间：{:date('Y-m-d H:i:s', $vo['pay_time'])}{/notempty}</td>
                <td class="font12">
                    {if condition="$vo['status'] eq 1"}
                    <span style="color: green">已支付</span>
                    {else/}
                    <span style="color: red">未支付</span>
                    {/if}
                </td>
            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
</form>
