<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>帮帮</title>
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
        <link rel="stylesheet" href="/Public/statics/iCheck-1.0.2/skins/all.css">

    <?php
 if($info['id'] > 0) { $handle_type = "查看"; } else { $handle_type = "添加"; } ?>
</head>
<body>

<div style="margin: 20px;">
        <form class="form-inline submit-ajax" data-refresh="3" action="<?php echo U('handle');?>" role="form" method="post">
            <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
            <table class="table table-hover">
                <tr>
                    <th width="120">任务名称</th>
                    <td>
                        <?php echo ($info["task_title"]); ?>
                    </td>
                </tr>
                <tr>
                    <th>任务人</th>
                    <td>
                        <?php echo ($info["username"]); ?>
                    </td>
                </tr>
                <tr>
                    <th>任务截图：</th>
                    <td>
                        <?php if(!empty($info['file'])): ?><a href="<?php echo ($info["file"]); ?>" target="_blank"><img src="<?php echo ($info["file"]); ?>" style="max-width: 80%;"></a>
                            <?php else: ?>
                            未上传<?php endif; ?>

                    </td>
                </tr>

                <tr>
                    <th>任务金额(元)：</th>
                    <td>
                        <?php echo ($info["price"]); ?>
                    </td>
                </tr>
                <tr>
                    <th>提交时间：</th>
                    <td>
                        <?php echo (date('Y-m-d H:i',$info["create_time"])); ?>
                    </td>
                </tr>
                <?php if($info['status'] != 2): ?><tr>
                        <th>审核状态：</th>
                        <td>
                            <select name="status" id="status" class="form-control input col-xs-12 col-sm-2">
                                <option value="">请选择审核状态</option>
                                <?php $_result=C('APPLY_STATUS');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $info['status']): ?>selected<?php endif; ?> ><?php echo ($vv); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <th>审核状态：</th>
                        <td>
                            <span class="status<?php echo ($info["status"]); ?>">
                            已完成
                            </span>
                        </td>
                    </tr><?php endif; ?>

                <tr>
                    <th>管理员备注：</th>
                    <td>
                        <textarea class="input col-xs-12 col-sm-5" style="padding: 10px; height: 80px;" name="admin_remark"><?php echo ($info["admin_remark"]); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input class="btn btn-success" type="submit" value="提交">
                        &nbsp; &nbsp;
                        <input class="btn btn-default" type="button" onclick="window.history.go(-1)" value="返回">
                    </td>
                </tr>
            </table>
        </form>
</div>


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

<script src="/Public/statics/iCheck-1.0.2/icheck.min.js"></script>
<script>
$(document).ready(function(){
    $('.xb-icheck').iCheck({
        checkboxClass: "icheckbox_minimal-blue",
        radioClass: "iradio_minimal-blue",
        increaseArea: "20%"
    });
});
</script>
</body>
</html>