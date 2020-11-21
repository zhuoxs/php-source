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

<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    系统参数设置
</div>
<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs">
   <li class="active">
        <a href="javascript:">系统参数设置</a>
    </li>
</ul>
<form class="form-inline" method="post">
    <table class="table table-bordered table-hover" style="max-width: 800px;">
        <tr>
            <th width="150">
                系统名称
            </th>
            <td>
                <input type="text" name="website" value="<?php echo ($info["website"]); ?>" class="form-control"/>
            </td>
        </tr>
        <tr>
            <th width="150">
                公司名称
            </th>
            <td>
                <input type="text" name="company" value="<?php echo ($info["company"]); ?>" class="form-control"/>
            </td>
        </tr>
        <tr>
            <th width="150">
                客服电话
            </th>
            <td>
                <input type="text" name="tel" value="<?php echo ($info["tel"]); ?>" class="form-control"/>
            </td>
        </tr>
        <!--<tr>
            <th width="150">
                微信登录
            </th>
            <td>
                <input type="checkbox" name="open_wx_login" value="1" <?php if($info['open_wx_login'] == 1): ?>checked<?php endif; ?> style="height: inherit;" />使用微信登录
            </td>
        </tr>-->
        <tr>
            <th width="150">
                微信客服
            </th>
            <td>
                <input type="text" name="wx_kf" value="<?php echo ($info["wx_kf"]); ?>" class="form-control"/>
            </td>
        </tr>
        <tr>
            <th width="150">
                安卓下载地址
            </th>
            <td>
                <input class="input col-xs-12 col-sm-12" type="text" name="app_android" value="<?php echo ($info["app_android"]); ?>" class="form-control"/>
            </td>
        </tr>
        <tr>
            <th width="150">
                安卓版本
            </th>
            <td>
                <input class="input col-xs-12 col-sm-12" type="text" name="app_android_version" value="<?php echo ($info["app_android_version"]); ?>" class="form-control"/>
            </td>
        </tr>
        <tr>
            <th width="150">
                IOS下载地址
            </th>
            <td>
                <input class="input col-xs-12 col-sm-12" type="text" name="app_ios" value="<?php echo ($info["app_ios"]); ?>" class="form-control"/>
            </td>
        </tr>
        <tr>
            <th width="150">
                IOS版本
            </th>
            <td>
                <input class="input col-xs-12 col-sm-12" type="text" name="app_ios_version" value="<?php echo ($info["app_ios_version"]); ?>" class="form-control"/>
            </td>
        </tr>
        <!--<tr>
            <th width="150">
                开通VIP会员短信提示
            </th>
            <td>
                <input class="input col-xs-12 col-sm-12"  type="text" name="vip_msg" value="<?php echo ($info["vip_msg"]); ?>" class="form-control"/>
            </td>
        </tr>
        <tr>
            <th width="150">
                99元微信收款二维码
            </th>
            <td>
                <input name="wxpay_99" id="wxpay99" type="text" class="input col-xs-12 col-sm-5" size="40" value="<?php echo ($info["wxpay_99"]); ?>" /> <input type="button" class="btn btn-info"  onclick="flashupload('wxpay99', '上传文件', 'wxpay99', return_value, '<?php echo CONTROLLER_NAME;?>');" value="浏览..">
            </td>
        </tr>
        <tr>
            <th width="150">
                999元微信收款二维码
            </th>
            <td>
                <input name="wxpay_999" id="wxpay999" type="text" class="input col-xs-12 col-sm-5" size="40" value="<?php echo ($info["wxpay_999"]); ?>" /> <input type="button" class="btn btn-info"  onclick="flashupload('wxpay999', '上传文件', 'wxpay999', return_value, '<?php echo CONTROLLER_NAME;?>');" value="浏览..">
            </td>
        </tr>-->
        <!--<tr>
            <th width="150">
                微信分享显示的logo
            </th>
            <td>
                <input name="share_logo" id="sharelogo" type="text" class="input col-xs-12 col-sm-5" size="40" value="<?php echo ($info["share_logo"]); ?>" /> <input type="button" class="btn btn-info"  onclick="flashupload('sharelogo', '上传文件', 'sharelogo', return_value, '<?php echo CONTROLLER_NAME;?>');" value="浏览..">
            </td>
        </tr>
        <tr>
            <th width="150">
                公众号二维码
            </th>
            <td>
                <input name="qrcode" id="qrcode" type="text" class="input col-xs-12 col-sm-5" size="40" value="<?php echo ($info["qrcode"]); ?>" /> <input type="button" class="btn btn-info"  onclick="flashupload('qrcode', '上传文件', 'qrcode', return_value, '<?php echo CONTROLLER_NAME;?>');" value="浏览..">
            </td>
        </tr>-->
    </table>
    <table class="table table-bordered " style="max-width: 800px; margin-top: 10px;">
        <thead>
            <tr>
                <th colspan="2">奖励设置</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td width="150">
                开启等级高低返佣规则
            </td>
            <td>
                <input type="checkbox" name="open_level_rule" value="1" <?php if($info['open_level_rule'] == 1): ?>checked<?php endif; ?> style="height: inherit;" /> 开启后VIP等级低的会员拿不到等级比他高的会员任务返佣，同级可拿。
            </td>
        </tr>
        <tr>
            <td width="150">
                一级返利
            </td>
            <td>
                <input class="form-control" style="width: 80px;" name="bfb_1" value="<?php echo ($info["bfb_1"]); ?>"> %
            </td>
        </tr>
        <tr>
            <td>
                二级返利
            </td>
            <td>
                <input class="form-control" style="width: 80px;" name="bfb_2" value="<?php echo ($info["bfb_2"]); ?>"> %
            </td>
        </tr>
        <tr>
            <td>
                三级返利
            </td>
            <td>
                <input class="form-control" style="width: 80px;" name="bfb_3" value="<?php echo ($info["bfb_3"]); ?>"> %
            </td>
        </tr>
        </tbody>

        <thead>
        <tr>
            <th colspan="2">其他参数设置</th>
        </tr>
        </thead>
        <tr>
            <td>提现手续费</td>
            <td><input class="form-control" style="width: 80px;" name="charge" value="<?php echo ($info["charge"]); ?>"> %</td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input class="btn btn-success" type="submit" value="提交">
            </td>
        </tr>
    </table>
</form>

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