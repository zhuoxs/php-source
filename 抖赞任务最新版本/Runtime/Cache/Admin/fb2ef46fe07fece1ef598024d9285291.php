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
        <link rel="stylesheet" href="/Public/statics/iCheck-1.0.2/skins/all.css">
</head>
<body>
<div class="m20">
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-12">

                <form class="form-inline submit-ajax" data-refresh="3" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
                    <input type="hidden" name="role" value="<?php echo ($info["role"]); ?>">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <th>账号</th>
                            <td>
                                <?php echo ($info["username"]); ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="120">姓名</th>
                            <td>
                                <input class="col-xs-12 col-sm-5" type="text" name="nickname" value="<?php echo ($info["nickname"]); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>电话</th>
                            <td>
                                <input class="col-xs-12 col-sm-5" type="text" name="phone" value="<?php echo ($info["phone"]); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>性别</th>
                            <td>
                                <select name="sex" class="col-xs-12 col-sm-5">
                                    <option value="">请选择</option>
                                    <option value="0" <?php if($info['sex'] == '0'): ?>selected<?php endif; ?> >男</option>
                                    <option value="1" <?php if($info['sex'] == '1'): ?>selected<?php endif; ?> >女</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>详细地址：</th>
                            <td>
                                <p><?php echo ($info["province"]); ?> <?php echo ($info["city"]); ?> <?php echo ($info["area"]); ?></p>
                                <input class="col-xs-12 col-sm-5" type="text" name="address" value="<?php echo ($info["address"]); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>密码</th>
                            <td>
                                <input class="col-xs-12 col-sm-5" type="text" name="password" value=""> <p style="color: #999;">不修改密码请留空</p>
                            </td>
                        </tr>
                        <tr>
                            <th>关注时间：</th>
                            <td>
                                <?php echo (date("Y-m-d H:i",$info["create_time"])); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>最后登陆时间：</th>
                            <td>
                                <?php echo (date("Y-m-d H:i",$info["last_login_time"])); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>余额：</th>
                            <td>
                                <?php echo ($info["price"]); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>历史总收入：</th>
                            <td>
                                <?php echo ($info["total_price"]); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>已提现：</th>
                            <td>
                                <?php echo ($info["tixian_price"]); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>银行卡：</th>
                            <td>
                                卡户银行：<?php echo ($info["bank_name"]); ?><br>开户人：<?php echo ($info["bank_user"]); ?><br>卡号：<?php echo ($info["bank_number"]); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>VIP会员等级：</th>
                            <td>
                                <select name="level" class="input col-xs-12 col-sm-2">
                                    <?php if(is_array($member_level)): $i = 0; $__LIST__ = $member_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $info['level']): ?>selected<?php endif; ?> ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>备注：</th>
                            <td>
                                <textarea class="input" style="height: 100px; width: 400px;" name="remark"><?php echo ($info["remark"]); ?></textarea>
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

            </div><!-- /.col -->

            <div class="col-sm-6">

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.col -->
</div><!-- /.row -->

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