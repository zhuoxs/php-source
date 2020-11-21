<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"/www/wwwroot/testxt.com/application/admin/view/index/welcome.html";i:1548310390;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/head.html";i:1522628860;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?> - 苹果CMS</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/admin_style.css">
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/layui/layui.js"></script>
    <script>
        var ROOT_PATH="",ADMIN_PATH="<?php echo $_SERVER['SCRIPT_NAME']; ?>", MAC_VERSION='v10';
    </script>
</head>
<body>
<div class="page-container">
    <?php $pass="<strong class='green'>√</strong>";$error="<strong class='red'>×</strong>";?>

    <blockquote class="layui-elem-quote layui-quote-nm mt10">
        <p class="f-20 text-success">欢迎使用苹果CMS，一路陪伴，感恩有你！请不要修改系统文件，以免升级出现故障！</p>
        <p>登录次数：<?php echo $info['admin_login_num']; ?>  上次登录IP：<?php echo long2ip($info['admin_last_login_ip']); ?>  上次登录时间：<?php echo mac_day($info['admin_last_login_time']); ?></p>
    </blockquote>

    <table class="layui-table" >
        <thead>
        <tr>
            <th colspan="4" scope="col">服务器当前日期【<?php echo date('Y-m-d'); ?>】</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="15%">操作系统</td>
            <td width="30%"><?php echo PHP_OS ?></td>
            <td width="15%">脚本解释引擎</td>
            <td width="30%"><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>
        </tr>
        <tr>
            <td>安装目录</td>
            <td><?php echo $_SERVER['DOCUMENT_ROOT'] ?></td>
            <td>服务器 (IP/端口) </td>
            <td><?php echo $_SERVER['HTTP_HOST'] ?></td>
        </tr>
        <tr>
            <td>PHP版本</td>
            <td><?php echo PHP_VERSION ?></td>
            <td>允许最大上传文件</td>
            <td><?php echo get_cfg_var("file_uploads") ? get_cfg_var("upload_max_filesize") : $error;?></td>
        </tr>
        <tr>
            <td>CURL支持</td>
            <td><?php $curl = @curl_version();echo $curl['version'] ? $curl['version'] : $error; ?></td>
            <td>GD图形处理扩展库版本</td>
            <td><?php $gd = @gd_info(); echo $gd['GD Version'] ? $gd['GD Version'] : $error;?></td>
        </tr>
        <tr>
            <td>ThinkPHP框架版本</td>
            <td><?php echo THINK_VERSION; ?></td>
            <td>脚本超时时间</td>
            <td><?php $t = ini_get("max_execution_time"); echo $t;?>秒</td>
        </tr>
        <tr>
            <td colspan="4">当前版本：<span class="layui-badge"><?php echo $version['code']; ?></span> 授权类型：<span class="layui-badge"><?php echo $version['license']; ?></span></td>
        </tr>
        </tbody>
    </table>
    <?php if($update_sql): ?>
    <table class="tbinfo pleft layui-table" ><thead><th colspan="4">更新提示【<a target="_blank" href="http://www.maccms.com/doc/v10/log.html">查看更新记录</a>】</th></thead><tr><td colspan="4"><font class="tif s20">提示，发现本地有数据库升级脚本？是否执行升级操作！执行完毕后将自动删除脚本！</font><a class="j-iframe" title="点击进升级数据库脚本" data-href="../update/step2.html"><font class="tit s20">【点击进升级数据库脚本】</font></a> </td></tr></table>
    <?php endif; ?>
</div>
<script type="text/javascript" src="/static/js/admin_common.js"></script>
</body>
</html>