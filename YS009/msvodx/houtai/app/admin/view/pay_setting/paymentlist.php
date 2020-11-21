<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/js/XCommon.js"></script>

<style>
    td{
        border-right: dashed 1px #c7c7c7;
        text-align:center;
    }
</style>
<form id="pageListForm" class="layui-form layui-form-pane" method="get">
    <div class="layui-form">
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <thead>
            <tr>
                <th width="">支付方式代码</th>
                <th width="">支付方式名称</th>
                <th width="">状态</th>
                <th width="">添加时间</th>
                <th width="">最后配置时间</th>
                <th width="">支付性质</th>
                <th width="">操作</th>
            </tr>
            </thead>
            <tbody>
            {volist name="paymentList" id="payment"}
            <tr>
                <td>{$payment['pay_code']}</td>
                <td>{$payment['pay_name']}</td>
                <td>
                    <input type="checkbox" name="status" {if condition="$payment['status'] eq 1"}checked=""{/if} value="{$payment['status']}" lay-skin="switch" lay-filter="switchStatus" lay-text="开启|禁用" data-href="{:url('status?table=payment&ids='.$payment['id'])}">
                    <!--{if condition="$payment['status'] eq 0"}<span style="color: #c1c1c1;"><i class="layui-icon">&#x1006;</i> 已禁用</span>{else}<span style="color:green"><i class="layui-icon">&#x1005;</i> 已启用</span>{/if}-->
                </td>
                <td>{if !empty($payment['add_time'])}{$payment['add_time']|date="Y/m/d H:i:s",###}{else} / {/if}</td>
                <td>{if !empty($payment['update_time'])}{$payment['update_time']|date="Y/m/d H:i:s",###}{else} / {/if}</td>
                <td style="text-align: left">{if condition="$payment['is_third_payment'] eq 1"}<span style="color:green;"><i class="layui-icon">&#xe857;</i>  第三方支付</span>{else}<span style="color:#ff913c;"><i class="layui-icon">&#xe617;</i>  原生支付</span>{/if}</td>
                <td>
                    <div class="layui-btn-group">
                        <a href="{:url('setting',array('id'=>$payment['id']))}" title="支付参数配置" class="layui-btn layui-btn-primary layui-btn-small "><i class="layui-icon">&#xe642;</i>参数配置</a>
                    </div>
                </td>
            </tr>
            {/volist}
            </tbody>
        </table>

        {$pages}
    </div>
</form>