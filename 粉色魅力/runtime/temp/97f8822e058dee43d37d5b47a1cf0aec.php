<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"/www/wwwroot/ys01.testx.vip/application/admin/view/database/export.html";i:1537344734;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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
<div class="page-container p10">

    <div class="my-toolbar-box" >
        <ul class="layui-tab-title mb10">
            <li class="layui-this"><a href="<?php echo url('index'); ?>">备份数据库</a></li>
            <li><a href="<?php echo url('index'); ?>?group=import">恢复数据库</a></li>
        </ul>

        <div class="layui-btn-group">
            <a data-href="<?php echo url('export'); ?>" class="layui-btn layui-btn-primary j-page-btns"><i class="layui-icon">&#xe62d;</i>备份数据库</a>
            <a data-href="<?php echo url('optimize'); ?>" class="layui-btn layui-btn-primary j-page-btns"><i class="layui-icon">&#xe631;</i>优化数据库</a>
            <a data-href="<?php echo url('repair'); ?>" class="layui-btn layui-btn-primary j-page-btns"><i class="layui-icon">&#xe60c;</i>修复数据库</a>
        </div>
    </div>

    <form id="pageListForm" class="layui-form">
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <colgroup>
                <col width="50">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th>表名</th>
                <th>数据量</th>
                <th>大小</th>
                <th>冗余</th>
                <th>备注</th>
                <th width="90">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><input type="checkbox" name="ids[]" class="layui-checkbox checkbox-ids" value="<?php echo $vo['Name']; ?>" lay-skin="primary"></td>
                <td><?php echo $vo['Name']; ?></td>
                <td><?php echo $vo['Rows']; ?></td>
                <td><?php echo round($vo['Data_length']/1024,2); ?> kb</td>
                <td><?php echo round($vo['Data_free']/1024,2); ?> kb</td>
                <td><?php echo $vo['Comment']; ?></td>
                <td>
                        <a data-href="<?php echo url('optimize?ids='.$vo['Name']); ?>" class="layui-badge-rim j-ajax">优化</a>
                        <a data-href="<?php echo url('repair?ids='.$vo['Name']); ?>" class="layui-badge-rim  j-ajax">修复</a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </form>

</div>
<script type="text/javascript" src="/static/js/admin_common.js"></script>


<script type="text/javascript">
    layui.use(['form', 'layer'], function () {
        // 操作对象
        var form = layui.form
                , layer = layui.layer
                , $ = layui.jquery;



    });
</script>
</body>
</html>