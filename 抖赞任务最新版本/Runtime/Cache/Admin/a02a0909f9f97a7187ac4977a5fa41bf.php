<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo sp_cfg('website');?></title>
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
    任务审核
</div>
<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs">
    <li class="active">
        <a href="javascript:">任务审核</a>
    </li>
</ul>

<form class="form-search form-inline" method="get" action="" style="padding: 10px 0; ">
    状态：
    <div class="input-group">
        <select name="status">
            <option value="">所有状态</option>
            <?php $_result=C('APPLY_STATUS');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $get['status'] and $get['status'] != ''): ?>selected<?php endif; ?> ><?php echo ($vv); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>

    时间段：
    <div class="input-group">
        <input type="text" name="start_date" value="<?php echo ($get["start_date"]); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" placeholder="起始日期" autocomplete="off">
        <input type="text" name="end_date" value="<?php echo ($get["end_date"]); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" placeholder="截止日期" autocomplete="off">
    </div>

    <div class="input-group">
        <button type="submit" class="btn btn-info btn-sm">
            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
            搜索
        </button>
    </div>
</form>

<form id="form1" action="<?php echo U('batch_set_task_apply_status');?>" method="post">
    <?php if($get['status'] == '1'): ?><div style="padding-bottom: 10px;">
            <input type="hidden" name="status" id="status" value="">
            <button type="button" class="btn btn-info btn-xs sh_btn" data-status="2">通过审核</button>
            <button type="button" class="btn btn-info btn-xs sh_btn" data-status="-1">审核不通过</button>
        </div><?php endif; ?>
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
            <?php if($get['status'] == '1'): ?><th width="60"><input type="checkbox" name="checkAll" onclick="selectAll(this, 'id[]')" style="height: inherit" />全选</th><?php endif; ?>
            <th width="60">ID</th>
            <th>任务名称</th>
            <th>金额</th>
            <th>类型</th>
            <th>任务级别</th>
            <th>用户</th>
            <th>申请日期</th>
            <th>状态</th>
            <th>审核</th>
        </tr>
        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
                <?php if($get['status'] == '1'): ?><td><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" style="height: inherit" /></td><?php endif; ?>
                <td><?php echo ($vo["id"]); ?></td>
                <td><?php echo ($vo["title"]); ?></td>
                <td><?php echo ($vo["price"]); ?></td>
                <td>
                    <?php if($vo['type'] == 0): ?>供应信息
                    <?php else: ?>
                        需求信息<?php endif; ?>
                </td>
                <td><?php echo ($vo["level_text"]); ?></td>
                <td><?php echo ($vo["username"]); ?></td>
                <td><?php echo (date("Y-m-d H:i",$vo["create_time"])); ?></td>
                <td><span class="status<?php echo ($vo["status"]); ?>"><?php echo ($vo["status_text"]); ?></span></td>
                <td>
                    <?php if($vo['status'] == 0): ?><!--<a href="<?php echo U('handle',array('id'=>$vo['id']));?>" class="btn btn-default btn-xs">审核</a>-->
                        <a class="btn btn-default btn-xs layer-dialog" title="<?php echo ($vo["title"]); ?>" href="<?php echo U('handle',['id'=>$vo['id']]);?>">
                            审核
                        </a>
                    <?php else: ?>
                        <a class="btn btn-default btn-xs layer-dialog" title="<?php echo ($vo["title"]); ?>" href="<?php echo U('handle',['id'=>$vo['id']]);?>">
                            查看
                        </a><?php endif; ?>
                </td>
            </tr><?php endforeach; endif; ?>
    </table>
</form>

<?php echo ($Page); ?>
<br><br><br>

</body>
</html>

<script>
    $(function(){
        $('.sh_btn').click(function(){
            var status = $(this).attr('data-status');
            if( status=='2' || status=='-1' ) {
                var tip = status==2?'确定设置为审核通过吗？':'确定设置为审核失败吗？';
                layer.confirm(tip, {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $('#status').val(status);
                    $('#form1').submit();
                }, function(){

                });
            }
        })
    })
</script>