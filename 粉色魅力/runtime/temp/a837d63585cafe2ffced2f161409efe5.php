<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:66:"/www/wwwroot/ys01.testx.vip/application/admin/view/admin/info.html";i:1526883874;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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
    <form class="layui-form layui-form-pane" method="post" action="">
        <input id="admin_id" name="admin_id" type="hidden" value="<?php echo $info['admin_id']; ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">账号：</label>
            <div class="layui-input-block  ">
                <input type="text" class="layui-input" value="<?php echo $info['admin_name']; ?>" placeholder="" id="admin_name" name="admin_name">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码：</label>
            <div class="layui-input-block">
                <input type="password" class="layui-input" value="<?php echo $info['admin_pwd']; ?>" placeholder="" id="admin_pwd" name="admin_pwd">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                    <input name="admin_status" type="radio" id="rad-1" value="0" title="禁用" <?php if($info['admin_status'] != 1): ?>checked <?php endif; ?>>
                    <input name="admin_status" type="radio" id="rad-2" value="1" title="启用" <?php if($info['admin_status'] == 1): ?>checked <?php endif; ?>>
            </div>
        </div>

        <div class="layui-form-item ">
            <label class="layui-form-label">权限：</label>
            <div class="layui-input-block">
                <blockquote class="layui-elem-quote layui-quote-nm">
                    提示：<br>
                    1.权限控制精准到每个操作，创始人ID为1的管理员拥有所有权限。
                    2.--开头的是页面内按钮操作选项。
                </blockquote>


                <div class="role-list-form ">
                    <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $k1 = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k1 % 2 );++$k1;?>
                    <dl class="role-list-form-top permission-list">
                        <dt>
                            <input type="checkbox" value="" <?php echo $vo['ck']; ?> lay-skin="primary" data-id="<?php echo $k1; ?>" lay-filter="roleAuth1" title="<?php echo $vo['name']; ?>">
                        </dt>
                        <dd>
                            <?php if(is_array($vo['sub']) || $vo['sub'] instanceof \think\Collection || $vo['sub'] instanceof \think\Paginator): $k2 = 0; $__LIST__ = $vo['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($k2 % 2 );++$k2;?>
                                <input type="checkbox" value="<?php echo $sub['controller']; ?>/<?php echo $sub['action']; ?>" name="admin_auth[]" <?php echo $sub['ck']; ?> data-pid="<?php echo $k1; ?>" title="<?php echo $sub['name']; ?>" lay-skin="primary" lay-filter="roleAuth2">
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </dd>
                    </dl>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

            </div>
        </div>

        <div class="layui-form-item center">
            <div class="layui-input-block">
                <button type="button" class="layui-btn layui-btn-normal formCheckAll" lay-filter="formCheckAll" >全选</button>
                <button type="button" class="layui-btn layui-btn-normal formCheckOther" lay-filter="formCheckOther">反选</button>

                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" data-child="true">保 存</button>
                <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
            </div>
        </div>
    </form>

</div>
<script type="text/javascript" src="/static/js/admin_common.js"></script>

<script type="text/javascript">
    layui.use(['form', 'layer'], function () {
        // 操作对象
        var form = layui.form
                , layer = layui.layer
                , $ = layui.jquery;

        // 验证
        form.verify({
            admin_name: function (value) {
                if (value == "") {
                    return "请输入管理员名称";
                }
            },
            admin_pwd: function (value) {
                if (value == "") {
                    return "请输入管理员密码";
                }
            }
        });

        form.on('checkbox(roleAuth1)', function(data) {
            var child = $(data.elem).parent('dt').siblings('dd').find('input');
            /* 自动选中子节点 */
            child.each(function(index, item) {
                if(item.disabled == true){

                }
                else {
                    item.checked = data.elem.checked;
                }
            });
            form.render('checkbox');
        });

        form.on('checkbox(roleAuth2)', function(data) {
            var child = $(data.elem).parent().find('input');
            var parent = $(data.elem).parent('dd').siblings('dt').find('input');
            var parent_ck= true;
            /* 自动选中子节点 */
            child.each(function(index, item) {
                if(!item.checked){
                    parent_ck = false;
                }
            });
            parent.each(function(index, item) {
                item.checked = parent_ck;
            });
            form.render('checkbox');
        });


        $('.formCheckAll').click(function(){
            var child = $('.role-list-form-top').find('input');
            /* 自动选中子节点 */
            child.each(function(index, item) {
                item.checked = true;
            });
            form.render('checkbox');
        });
        $('.formCheckOther').click(function(){
            var child = $('.role-list-form-top').find('input');
            /* 自动选中子节点 */
            child.each(function(index, item) {
                item.checked = (item.checked  ? false : true);
            });
            form.render('checkbox');
        });

    });




</script>

</body>
</html>