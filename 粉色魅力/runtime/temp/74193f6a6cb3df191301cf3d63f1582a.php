<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"/www/wwwroot/ys01.testx.vip/application/admin/view/database/import.html";i:1521419348;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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
            <li ><a href="<?php echo url('index'); ?>">备份数据库</a></li>
            <li class="layui-this"><a href="<?php echo url('index'); ?>?group=import">恢复数据库</a></li>
        </ul>
    </div>

    <form id="pageListForm" class="layui-form">
        <table class="layui-table mt10" lay-even="" lay-skin="row">
            <thead>
            <tr>
                <th>备份名称</th>
                <th>备份卷数</th>
                <th>备份压缩</th>
                <th>备份大小</th>
                <th>备份时间</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><?php echo date('Ymd-His', $vo['time']); ?></td>
                <td><?php echo $vo['part']; ?></td>
                <td><?php echo $vo['compress']; ?></td>
                <td><?php echo round($vo['size']/1024, 2); ?> K</td>
                <td><?php echo date('Y-m-d H:i:s', $vo['time']); ?></td>
                <td>
                    <div class="layui-btn-group">
                        <a data-href="<?php echo url('import?id='.strtotime($key)); ?>" class="layui-badge-rim layui-btn-small j-ajax" confirm="确认还原此备份吗？此操作不可恢复">还原</a>
                        <a data-href="<?php echo url('del?id='.strtotime($key)); ?>" class="layui-badge-rim layui-btn-small j-tr-del">删除</a>
                    </div>
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