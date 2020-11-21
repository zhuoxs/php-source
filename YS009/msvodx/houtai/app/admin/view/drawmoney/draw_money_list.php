<div class="page-toolbar" >
    <div class="layui-btn-group fl">

    </div>
</div>
<form id="pageListForm">
    <div class="layui-form">
        <table class="layui-table mt10" lay-even=""  lay-size="lg">
            <colgroup>
                <col width="60">
            </colgroup>
            <thead>
            <tr>
                <th>ID</th>
                <th>用户信息</th>
                <th>提现信息</th>
                <th>提现额度</th>
                <th>提现申请时间</th>
                <th>审核状态</th>
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
                    <img src="{if condition="$vo['headimgurl']"}{$vo['headimgurl']}{else /}__ADMIN_IMG__/avatar.png{/if}" width="60" height="60" class="fl">
                    <p class="ml10 fl"><strong class="mcolor">{$vo['nickname']} </strong><br>{$vo['tel']}<br>{$vo['email']}</p>
                </td>
                <td class="font12">
                    <strong>收款方式：</strong> {if condition="$vo['info']['type'] eq 1"}
                    支付宝  <br>
                    <!--<strong> 标题：</strong>{$vo['info']['title']} <br>-->
                    <strong>收款账号：</strong>{$vo['info']['account']}
                    {elseif condition="$vo['info']['type'] eq 2"}
                       银行卡<br>
                    <!--<strong>标题：</strong>{$vo['info']['title']} <br>-->
                    <strong>账号：</strong>{$vo['info']['account']}<br>
                    <strong>姓名:</strong>{$vo['info']['account_name']}<br>
                    <strong>银行:</strong>{$vo['info']['bank']}
                    {/if}

                </td>
                <td class="font12">
                    <span class="layui-badge layui-bg-black">提现额度：{$vo['money']}元</span> <br />
                    <span class="layui-badge layui-bg-black">兑换金币：{$vo['gold']}个</span> <br />
                </td>
                <td class="font12">
                    {:date('Y-m-d H:i:s', $vo['add_time'])}
                    <!--<br>修改时间：{:date('Y-m-d H:i:s', $vo['update_time'])}<br></p>-->
                </td>
                <td class="font12">
                     {if condition="$vo['status'] eq 0"}
                        <span class="layui-badge layui-bg-orange">待审核</span>
                        {elseif condition="$vo['status'] eq 1"}
                        <span class="layui-badge layui-bg-green">已通过</span>
                        {elseif condition="$vo['status'] eq 2"}
                        <span class="layui-badge layui-bg-red">已拒绝</span>
                    {/if}
                </td>
                <td>
                    {if condition="$vo['status'] eq 2"}
                        <a data-href="#" data-id="{$vo['id']}"  class="layui-btn layui-btn-disabled">已处理</a>
                    {else/}
                        <a data-href="#" data-id="{$vo['id']}" class="layui-btn layui-btn-primary agreen"><i class="aicon ai-qiyong"></i>审核</a>
                    {/if}

                </td>

            </tr>
            {/volist}
            </tbody>
        </table>
        {$pages}
    </div>
</form>
<script>
    layui.use(['jquery', 'laydate'], function() {
        var $ = layui.jquery, laydate = layui.laydate;
        $(".agreen").on('click',function () {
            var id=$(this).data('id');
            var url='agreen';
            layer.confirm('您确定已打款吗？', {
                icon: 0,
                btn: ['确认打款','拒绝申请','取消'] //按钮
            }, function(){
                var data={id:id,type:'1'}
                $.get(url,data,function(){

                },'json');
                layer.msg('审核通成功', {icon: 1,end:function(){
                    location.reload()
                }});
            }, function(){
                var data={id:id,type:'2'}
                $.get(url,data,function(){

                },'json');
                layer.msg('审核成功', {icon: 1,end:function(){
                    location.reload()
                }});
            });

        });
    });
</script>
