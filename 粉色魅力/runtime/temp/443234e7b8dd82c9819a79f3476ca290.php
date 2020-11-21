<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:66:"/www/wwwroot/ys01.testx.vip/application/admin/view/user/index.html";i:1545549382;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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

        <div class="center mb10">
            <form class="layui-form " method="post">
                <div class="layui-input-inline w150">
                    <select name="status">
                        <option value="">选择状态</option>
                        <option value="0" <?php if($param['status'] == '0'): ?>selected <?php endif; ?>>未审核</option>
                        <option value="1" <?php if($param['status'] == '1'): ?>selected <?php endif; ?>>已审核</option>
                    </select>
                </div>
                <div class="layui-input-inline w150">
                    <select name="group">
                        <option value="">选择会员组</option>
                        <?php if(is_array($group_list) || $group_list instanceof \think\Collection || $group_list instanceof \think\Paginator): $i = 0; $__LIST__ = $group_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['group_id']; ?>" <?php if($param['group'] == $vo['group_id']): ?>selected <?php endif; ?>><?php echo $vo['group_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" placeholder="请输入搜索条件" class="layui-input" name="wd" value="<?php echo $param['wd']; ?>">
                </div>
                <button class="layui-btn mgl-20 j-search" >查询</button>
            </form>
        </div>

        <div class="layui-btn-group">
            <a data-href="<?php echo url('info'); ?>" class="layui-btn layui-btn-primary j-iframe"><i class="layui-icon">&#xe654;</i>添加</a>
            <a data-href="<?php echo url('del'); ?>" class="layui-btn layui-btn-primary j-page-btns confirm"><i class="layui-icon">&#xe640;</i>删除</a>
        </div>

    </div>

    <form class="layui-form " method="post" id="pageListForm">
        <table class="layui-table" lay-size="sm">
            <thead>
            <tr>
                <th width="25"><input type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th width="100">编号</th>
                <th >名称</th>
                <th width="100">会员组</th>
                <th width="80">状态</th>
                <th width="80">积分</th>
                <th width="130">上次登录时间</th>
                <th width="130">上次登录IP</th>
                <th width="80">登录次数</th>
                <th width="220">相关数据</th>
                <th width="100">操作</th>
            </tr>
            </thead>

            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $vo['user_id']; ?>" class="layui-checkbox checkbox-ids" lay-skin="primary"></td>
                <td><?php echo $vo['user_id']; ?></td>
                <td><?php echo $vo['user_name']; ?></td>
                <td><?php echo $vo['group_name']; ?></td>
                <td>
                    <input type="checkbox" name="status" <?php if($vo['user_status'] == 1): ?>checked<?php endif; ?> value="<?php echo $vo['user_status']; ?>" lay-skin="switch" lay-filter="switchStatus" lay-text="正常|关闭" data-href="<?php echo url('field?col=user_status&ids='.$vo['user_id']); ?>">
                </td>
                <td><?php echo $vo['user_points']; ?></td>
                <td><?php echo mac_day($vo['user_login_time'],color); ?></td>
                <td><?php echo long2ip($vo['user_login_ip']); ?></td>
                <td><?php echo $vo['user_login_num']; ?></td>
                <td>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('comment/data?uid='.$vo['user_id']); ?>" href="javascript:;" title="评论记录">评论记录</a>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('order/index?uid='.$vo['user_id']); ?>" href="javascript:;" title="订单记录">订单记录</a>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('ulog/index?uid='.$vo['user_id']); ?>" href="javascript:;" title="访问记录">访问记录</a>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('plog/index?uid='.$vo['user_id']); ?>" href="javascript:;" title="积分记录">积分记录</a>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('cash/index?uid='.$vo['user_id']); ?>" href="javascript:;" title="提现记录">提现记录</a>
                    <a class="layui-badge-rim j-iframe" data-full="1" data-href="<?php echo url('user/reward?uid='.$vo['user_id']); ?>" href="javascript:;" title="提现记录">三级分销</a>
                </td>
                <td>
                    <a class="layui-badge-rim j-iframe" data-href="<?php echo url('info?id='.$vo['user_id']); ?>" href="javascript:;" title="编辑">编辑</a>
                    <a class="layui-badge-rim j-tr-del" data-href="<?php echo url('del?ids='.$vo['user_id']); ?>" href="javascript:;" title="删除">删除</a>
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
    var curUrl="<?php echo url('user/data',$param); ?>";
    layui.use(['laypage', 'layer'], function() {
        var laypage = layui.laypage
                , layer = layui.layer;

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