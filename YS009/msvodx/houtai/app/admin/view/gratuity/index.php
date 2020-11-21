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
                <th>会员</th>
                <th>描述</th>
                <th>打赏时间</th>
            </tr>
            </thead>
            <tbody>
            {volist name="data_list" id="vo"}
            <?php $giftinfo = json_decode($vo['gift_info'],true);?>
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="{$vo['id']}" lay-skin="primary"></td>
                <td class="font12">
                    <img src="{if condition="$vo['headimgurl']"}{$vo['headimgurl']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="60" height="60" class="fl">
                    <p class="ml10 fl"><strong class="mcolor">昵称：{$vo['nickname']} </strong><br>手机：{$vo['tel']}<br>邮箱：{$vo['email']}</p>
                </td>
                <td class="font12">花费了{$giftinfo['price']}金币，打赏了一个{$giftinfo['name']}<img style="width:36px;vertical-align:middle;margin-left: 5px;" src="{$giftinfo['images']}"></td>
                <td class="font12">打赏时间：{:date('Y-m-d H:i:s', $vo['gratuity_time'])}</td>
            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
</form>
