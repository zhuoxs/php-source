<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:66:"/www/wwwroot/ys01.testx.vip/application/admin/view/type/index.html";i:1546138018;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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

    <div class="my-toolbar-box">
        <div class="layui-btn-group">
            <a data-full="1" data-href="<?php echo url('info'); ?>" class="layui-btn layui-btn-primary j-iframe"><i class="layui-icon">&#xe654;</i>添加</a>
            <a data-href="<?php echo url('batch'); ?>" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="layui-icon">&#xe642;</i>修改</a>
            <a data-href="<?php echo url('del'); ?>" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="layui-icon">&#xe640;</i>删除</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=type&col=type_status&tpl=select_status&url=type/field" data-width="470" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>状态</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=type&col=type_status&tpl=select_type&url=type/move" data-width="470" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>转移</a>
        </div>

    </div>

    <form class="layui-form " method="post" id="pageListForm">
        <table class="layui-table" lay-size="sm">
        <thead>
            <tr>
                <th width="25"><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th>名称</th>
                <th width="50">状态</th>
                <th width="40">类型</th>
                <th width="40">排序</th>
                <th width="80">名称</th>
                <th width="120">英文名</th>
                <th width="100">分类页模版</th>
                <th width="100">筛选页模版</th>
                <th width="100">内容页模版</th>
                <th width="130">操作</th>
            </tr>
            </thead>

            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $vo['type_id']; ?>" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td><?php echo $vo['type_id']; ?>、<a target="_blank" class="layui-badge-rim " href="<?php echo mac_url_type($vo); ?>"><?php echo $vo['type_name']; ?></a> <span class="layui-badge"><?php echo $vo['cc']; ?></span></td>
                <td>
                    <input type="checkbox" name="status" <?php if($vo['type_status'] == 1): ?>checked<?php endif; ?> value="<?php echo $vo['type_status']; ?>" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="<?php echo url('field?col=type_status&ids='.$vo['type_id']); ?>">
                </td>
                <td><?php if($vo['type_mid'] == 1): ?> <span class="label label-success radius	">视频</span><?php else: ?><span class="label label-danger radius">文章</span><?php endif; ?></td>
                <td><input type="input" name="type_sort_<?php echo $vo['type_id']; ?>" value="<?php echo $vo['type_sort']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_name_<?php echo $vo['type_id']; ?>" value="<?php echo $vo['type_name']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_en_<?php echo $vo['type_id']; ?>" value="<?php echo $vo['type_en']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_tpl_<?php echo $vo['type_id']; ?>" value="<?php echo $vo['type_tpl']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_tpl_list_<?php echo $vo['type_id']; ?>" value="<?php echo $vo['type_tpl_list']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_tpl_detail_<?php echo $vo['type_id']; ?>" value="<?php echo $vo['type_tpl_detail']; ?>" class="layui-input"></td>
                <td>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('info?id='.$vo['type_id']); ?>" href="javascript:;" title="编辑">编辑</a>
                    <a class="layui-badge-rim j-tr-del" data-href="<?php echo url('del?ids='.$vo['type_id']); ?>" href="javascript:;" title="删除">删除</a>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('info'); ?>?pid=<?php echo $vo['type_id']; ?>" href="javascript:;" title="添加">添加</a>
                </td>
            </tr>
            <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ch): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $ch['type_id']; ?>" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;├&nbsp;<?php echo $ch['type_id']; ?>、<a target="_blank" class="layui-badge-rim " href="<?php echo mac_url_type($ch); ?>"><?php echo $ch['type_name']; ?></a> <span class="layui-badge"><?php echo $ch['cc']; ?></span></td>
                <td>
                    <input type="checkbox" name="status" <?php if($ch['type_status'] == 1): ?>checked<?php endif; ?> value="<?php echo $ch['type_status']; ?>" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="<?php echo url('field?col=type_status&ids='.$ch['type_id']); ?>">
                </td>
                <td><?php if($ch['type_mid'] == 1): ?> <span class="label label-success radius	">视频</span><?php else: ?><span class="label label-danger radius">文章</span><?php endif; ?></td>
                <td><input type="input" name="type_sort_<?php echo $ch['type_id']; ?>" value="<?php echo $ch['type_sort']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_name_<?php echo $ch['type_id']; ?>" value="<?php echo $ch['type_name']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_en_<?php echo $ch['type_id']; ?>" value="<?php echo $ch['type_en']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_tpl_<?php echo $ch['type_id']; ?>" value="<?php echo $ch['type_tpl']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_tpl_list_<?php echo $ch['type_id']; ?>" value="<?php echo $ch['type_tpl_list']; ?>" class="layui-input"></td>
                <td><input type="input" name="type_tpl_detail_<?php echo $ch['type_id']; ?>" value="<?php echo $ch['type_tpl_detail']; ?>" class="layui-input"></td>
                <td>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('info?id='.$ch['type_id']); ?>" href="javascript:;" title="编辑">编辑</a>
                    <a class="layui-badge-rim j-tr-del" data-href="<?php echo url('del?ids='.$ch['type_id']); ?>" href="javascript:;" title="删除">删除</a>
                </td>
            </tr>


            <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>

    </form>
</div>

<script type="text/javascript" src="/static/js/admin_common.js"></script>

<script type="text/javascript">

    layui.use(['laypage', 'layer'], function() {
        var laypage = layui.laypage
                , layer = layui.layer;


    });
</script>
</body>
</html>