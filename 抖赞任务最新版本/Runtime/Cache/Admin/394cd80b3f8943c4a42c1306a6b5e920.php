<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo sp_cfg('website');?></title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />

    <!--[if IE 7]>
        <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/ace.min.css" />
    <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/ace-skins.min.css" />
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/tpl/Admin/Public/aceadmin/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
        <script src="/tpl/Admin/Public/aceadmin/js/html5shiv.js"></script>
        <script src="/tpl/Admin/Public/aceadmin/js/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="/tpl/Public/css/base.css" />
    <link rel="stylesheet" href="/tpl/Public/js/artDialog/skins/default.css" />
    <style>
        .status0{}
        .status1{color: #39B9E4}
        .status-1{color: red}
    </style>
</head>
<body>
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    后台管理
    &gt;
    平台流水
</div>
<ul id="myTab" class="nav nav-tabs">
    <li class="active">
        <a href="javascript:">平台流水</a>
    </li>
</ul>
<form class="form-search form-inline" method="get" action="" style="padding: 10px 0; ">
    支付渠道：
    <div class="input-group">
        <select name="payment_type">
            <option value="">所有渠道</option>
            <?php if(is_array($payment_type)): $i = 0; $__LIST__ = $payment_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $get['payment_type'] and $get['payment_type'] != ''): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
    流水号：
    <div class="input-group">
        <input type="text" name="platform_no" value="<?php echo ($get["platform_no"]); ?>" class="input-sm search-query" placeholder="平台流水号">
    </div>
    时间段：
    <div class="input-group">
        <input type="text" name="start_date" value="<?php echo ($get["start_date"]); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="起始日期">
        <input type="text" name="end_date" value="<?php echo ($get["end_date"]); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="截止日期">
    </div>

    <div class="input-group">
        <button type="submit" class="btn btn-info btn-sm">
            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
            搜索
        </button>
    </div>
</form>
<div style="padding-bottom: 10px;">
    <div class="btn btn-xs btn-danger">总金额：￥<?php echo ($total_price); ?></div>
</div>
<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th>时间</th>
        <th>会员ID</th>
        <th>会员账号</th>
        <th>会员昵称</th>
        <!--<th>业务类型</th>-->
        <th>充值金额</th>
        <th>支付渠道</th>
        <th>平台流水号</th>
    </tr>
    <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
            <td><?php echo (date('Y-m-d H:i',$vo["create_time"])); ?></td>
            <td><?php echo ($vo["member_id"]); ?></td>
            <td><?php echo ($vo["username"]); ?></td>
            <td><?php echo ($vo["nickname"]); ?></td>
            <!--<td><?php echo ($vo["type_text"]); ?></td>-->
            <td><?php echo ($vo["price"]); ?></td>
            <td><?php echo ($vo["payment_type_text"]); ?></td>
            <td><?php echo ($vo["platform_no"]); ?></td>
        </tr><?php endforeach; endif; ?>
</table>
<?php echo ($Page); ?>

<!-- 修改菜单模态框开始 -->
<div class="modal fade" id="apply-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <input type="hidden" name="id" value="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    提现审核
                </h4>
            </div>
            <div class="modal-body">
                <form id="bjy-form" class="form-inline" action="<?php echo U('tixian_do');?>" method="post">
                    <input type="hidden" name="id">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th>申请人：</th>
                            <td>
                                <input class="form-control" type="text" name="title" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>提现金额：</th>
                            <td>
                                <input class="form-control" type="text" name="price" value="" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>处理状态：</th>
                            <td>
                                <select name="tixian_status" id="tixian_status" class="form-control">
                                    <?php if(is_array($tixian_status)): $i = 0; $__LIST__ = $tixian_status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>添加备注：</th>
                            <td>
                                <textarea class="form-control" name="admin_remark" id="admin_remark"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <input class="btn btn-success" type="submit" value="修改">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 修改菜单模态框结束 -->

<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/artDialog/artDialog.js"></script>
<script src="/tpl/Public/js/artDialog/iframeTools.js"></script>
<script src="/tpl/Public/js/bootbox.js"></script>
<script src="/tpl/Public/js/base.js"></script>

<link rel="stylesheet" href="/tpl/Public/js/datepicker/css/bootstrap-datepicker3.min.css" />
<link rel="stylesheet" href="/tpl/Public/js/datepicker/css/bootstrap-datetimepicker.min.css" />
<script src="/tpl/Public/js/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/tpl/Public/js/datepicker/js/bootstrap-timepicker.min.js"></script>

<script src="/Public/statics/layer/layer.js"></script>
<script src="/Public/statics/layer/extend/layer.ext.js"></script>

</body>
</html>

<script>
    function edit(obj){
        var id=$(obj).attr('data-id');
        var title=$(obj).attr('data-title');
        var price=$(obj).attr('data-price');
        var admin_remark=$(obj).attr('data-admin_remark');
        var tixian_status=$(obj).attr('data-status');
        $("input[name='id']").val(id);
        $("input[name='title']").val(title);
        $("input[name='price']").val(price);
        $("#tixian_status").val(tixian_status);
        $("#admin_remark").val(admin_remark);
        $('#apply-edit').modal('show');
    }
</script>