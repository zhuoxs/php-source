<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"/www/wwwroot/testxt.com/application/admin/view/template/ads.html";i:1525912390;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/head.html";i:1522628860;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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
    <div class="my-btn-box lh30" >
        <div class="layui-btn-group fl">
            <a data-full="1" data-href="<?php echo url('info'); ?>?fpath=<?php echo $curpath; ?>&fname=" class="layui-btn layui-btn-primary j-iframe"><i class="layui-icon">&#xe654;</i>添加</a>
        </div>
        <div class="page-filter fr" >

        </div>
    </div>

    <form class="layui-form layui-form-pane" action="">
        <table class="layui-table mt10">
        <thead>
        <tr>
            <th>文件名</th>
            <th width="150">文件描述</th>
            <th width="150">文件大小</th>
            <th width="150">修改时间</th>
            <th width="200">调用代码</th>
            <th width="130">操作</th>
        </tr>
        </thead>
            <?php if(is_array($files) || $files instanceof \think\Collection || $files instanceof \think\Paginator): $i = 0; $__LIST__ = $files;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>

                <th><?php echo $vo['name']; ?></a></th>
                <td><?php echo $vo['note']; ?></td>
                <td><?php echo $vo['size']; ?></td>
                <td><?php echo mac_day($vo['time'],color); ?></td>
                <td>
                    <input id="txt<?php echo $key; ?>" type="text" value='<script src="{$maccms.path_ads}<?php echo $vo['name']; ?>"></script>' size="60">
                </td>
                <td>
                    <a class="layui-badge-rim j-clipboard" data-clipboard-target="#txt<?php echo $key; ?>" href="javascript:;" title="复制">复制</a>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('info'); ?>?fpath=<?php echo $vo['path']; ?>&fname=<?php echo $vo['name']; ?>" href="javascript:;" title="编辑">编辑</a>
                    <a class="layui-badge-rim j-tr-del" data-href="<?php echo url('del'); ?>?fname=<?php echo $vo['fullname']; ?>" href="javascript:;" title="删除">删除</a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="6">当前路径：<?php echo str_replace('@','/',$curpath); ?>，共有<b class="red"><?php echo $num_file; ?></b>个文件,占用<b class="red"><?php echo $sum_size; ?></b>空间</td></tr>
        </tfoot>
    </table>
    </form>
</div>
<script type="text/javascript" src="/static/js/admin_common.js"></script>
<script type="text/javascript" src="/static/js/jquery.clipboard.js"></script>
<script type="text/javascript">
    var clipboard = new ClipboardJS('.j-clipboard');
    clipboard.on('success', function(e) {
       layer.msg('复制成功');
    });

    function data_info(path,name)
    {
        var index = layer.open({
            type: 2,
            shade:0.4,
            title: '编辑数据',
            content: "<?php echo url('template/info'); ?>?fpath="+path+'&fname='+name
        });

        layer.full(index);
    }

    function data_del(id)
    {
        if(!id){
            id  = checkIds('fname[]');
        }
        layer.confirm('确认要删除吗？', function (index) {
            location.href = "<?php echo url('template/del'); ?>?fname=" + id;
        });
    }

    $(function(){

    });
</script>
</body>
</html>