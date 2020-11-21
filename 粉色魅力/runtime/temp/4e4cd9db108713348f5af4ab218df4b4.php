<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:62:"/www/wwwroot/testxt.com/application/admin/view/role/index.html";i:1528765766;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/head.html";i:1522628860;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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
        <?php if($param['select'] != 1): ?>
        <div class="center mb10">
            <form class="layui-form " method="post">
                <input type="hidden" value="<?php echo $param['select']; ?>" name="select">
                <input type="hidden" value="<?php echo $param['input']; ?>" name="input">
                <div class="layui-input-inline w150">
                    <select name="status">
                        <option value="">选择状态</option>
                        <option value="0" <?php if($param['status'] == '0'): ?>selected <?php endif; ?>>未审核</option>
                        <option value="1" <?php if($param['status'] == '1'): ?>selected <?php endif; ?>>已审核</option>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="level">
                        <option value="">选择推荐</option>
                        <option value="9" <?php if($param['level'] == '9'): ?>selected <?php endif; ?>>推荐9-幻灯</option>
                        <option value="1" <?php if($param['level'] == '1'): ?>selected <?php endif; ?>>推荐1</option>
                        <option value="2" <?php if($param['level'] == '2'): ?>selected <?php endif; ?>>推荐2</option>
                        <option value="3" <?php if($param['level'] == '3'): ?>selected <?php endif; ?>>推荐3</option>
                        <option value="4" <?php if($param['level'] == '4'): ?>selected <?php endif; ?>>推荐4</option>
                        <option value="5" <?php if($param['level'] == '5'): ?>selected <?php endif; ?>>推荐5</option>
                        <option value="6" <?php if($param['level'] == '6'): ?>selected <?php endif; ?>>推荐6</option>
                        <option value="7" <?php if($param['level'] == '7'): ?>selected <?php endif; ?>>推荐7</option>
                        <option value="8" <?php if($param['level'] == '8'): ?>selected <?php endif; ?>>推荐8</option>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="pic">
                        <option value="">选择图片</option>
                        <option value="1" <?php if($param['pic'] == '1'): ?>selected<?php endif; ?>>无图片</option>
                        <option value="2" <?php if($param['pic'] == '2'): ?>selected<?php endif; ?>>远程图片</option>
                        <option value="3" <?php if($param['pic'] == '3'): ?>selected<?php endif; ?>>同步出错图</option>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="order">
                        <option value="">选择排序</option>
                        <option value="role_time" <?php if($param['order'] == 'role_time'): ?>selected<?php endif; ?>>更新时间</option>
                        <option value="role_id" <?php if($param['order'] == 'role_id'): ?>selected<?php endif; ?>>编号</option>
                        <option value="role_hits" <?php if($param['order'] == 'role_hits'): ?>selected<?php endif; ?>>总人气</option>
                        <option value="role_hits_month" <?php if($param['order'] == 'role_hits_month'): ?>selected<?php endif; ?>>月人气</option>
                        <option value="role_hits_week" <?php if($param['order'] == 'role_hits_week'): ?>selected<?php endif; ?>>周人气</option>
                        <option value="role_hits_day" <?php if($param['order'] == 'role_hits_day'): ?>selected<?php endif; ?>>日人气</option>
                    </select>
                </div>

                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" placeholder="请输入搜索条件" class="layui-input" name="wd" value="<?php echo $param['wd']; ?>">
                </div>
                <button class="layui-btn mgl-20 j-search" >查询</button>
            </form>
        </div>
        <?php endif; ?>

        <div class="layui-btn-group">
            <?php if($param['select'] == 1 && $param['rid'] != ''): ?>
            <a data-href="<?php echo url('info'); ?>?tab=<?php echo $param['tab']; ?>&rid=<?php echo $param['rid']; ?>" data-full="" class="layui-btn layui-btn-primary j-iframe"><i class="layui-icon">&#xe654;</i>添加</a>
            <?php endif; ?>
            <a data-href="<?php echo url('del'); ?>" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="layui-icon">&#xe640;</i>删除</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=role&col=role_level&tpl=select_level&url=role/field" data-width="270" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>推荐</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=role&col=role_hits&tpl=select_hits&url=role/field" data-width="470" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>点击</a>
            <a data-href="<?php echo url('index/select'); ?>?tab=role&col=role_status&tpl=select_status&url=role/field" data-width="470" data-height="100" data-checkbox="1" class="layui-btn layui-btn-primary j-select"><i class="layui-icon">&#xe620;</i>状态</a>
            <a class="layui-btn layui-btn-primary j-iframe" data-href="<?php echo url('images/opt?tab=role'); ?>" href="javascript:;" title="同步远程图片"><i class="layui-icon">&#xe620;</i>同步图片</a>
        </div>

    </div>


    <form class="layui-form " method="post" id="pageListForm">
        <table class="layui-table" lay-size="sm">
            <thead>
            <tr>
                <th width="25"><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th width="50">编号</th>
                <th >视频名称</th>
                <th width="150">角色名称</th>
                <th width="150">演员名称</th>
                <th width="40">排序</th>
                <th width="40">人气</th>
                <th width="40">推荐</th>
                <th width="120">更新时间</th>
                <th width="80">操作</th>
            </tr>
            </thead>

            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $vo['role_id']; ?>" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td><?php echo $vo['role_id']; ?></td>
                <td><a target="_blank" class="layui-badge-rim " href="<?php echo mac_url_vod_detail($vo['data']); ?>">[<?php echo $vo['data']['vod_name']; ?>]</a></td>
                <td> <a target="_blank" class="layui-badge-rim " href="<?php echo mac_url_role_detail($vo); ?>"><?php echo $vo['role_name']; ?></a> <?php if($vo['role_status'] == 0): ?> <span class="layui-badge">未审</span><?php endif; if($vo['role_lock'] == 1): ?> <span class="layui-badge">锁定</span><?php endif; ?></td>
                <td><?php echo $vo['role_actor']; ?></td>
                <td><?php echo $vo['role_sort']; ?></td>
                <td><?php echo $vo['role_hits']; ?></td>
                <td><a data-href="<?php echo url('index/select'); ?>?tab=role&col=role_level&tpl=select_level&url=role/field&ids=<?php echo $vo['role_id']; ?>" data-width="270" data-height="100" class=" j-select"><span class="layui-badge layui-bg-orange"><?php echo $vo['role_level']; ?></span></a></td>
                <td><?php echo mac_day($vo['role_time'],color); ?></td>
                <td>
                    <a class="layui-badge-rim j-iframe" data-full="" data-href="<?php echo url('info?id='.$vo['role_id']); ?>" href="javascript:;" title="编辑">编辑</a>
                    <a class="layui-badge-rim j-tr-del" data-href="<?php echo url('del?ids='.$vo['role_id']); ?>" href="javascript:;" title="删除">删除</a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div id="pages" class="center"></div>
    </form>
</div>




<script type="text/javascript" src="/static/js/admin_common.js"></script>

<script type="text/javascript">
    var curUrl="<?php echo url('role/data',$param); ?>";
    layui.use(['laypage', 'layer','form'], function() {
        var laypage = layui.laypage
                , layer = layui.layer,
                form = layui.form;

        laypage.render({
            elem: 'pages'
            ,count: <?php echo $total; ?>
            ,limit: <?php echo $limit; ?>
            ,curr: <?php echo $page; ?>
            ,layout: ['count', 'prev', 'page', 'next', 'limit', 'skip']
            ,jump: function(obj,first){
                if(!first){
                    location.href = curUrl.replace('%7Bpage%7D',obj.curr).replace('%7Blimit%7D',obj.limit);
                }
            }
        });


    });
</script>
</body>
</html>