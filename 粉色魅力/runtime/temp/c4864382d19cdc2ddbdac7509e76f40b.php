<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"/www/wwwroot/ys01.testx.vip/application/admin/view/database/rep.html";i:1521419348;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/head.html";i:1522628860;s:67:"/www/wwwroot/ys01.testx.vip/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
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
<style>
    .layui-form-select ul {max-height:200px}
    .layui-btn+.layui-btn{margin-left:0px; }
</style>
<div class="page-container">
    <form class="layui-form layui-form-pane" action="">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">批量替换</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">

                <div class="layui-form-item">
                    <label class="layui-form-label">选择数据表：</label>
                    <div class="layui-input-inline w400" >
                        <select name="table" lay-filter="table" lay-verify="table">
                            <option value="">请选择表</option>
                            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo['Name']; ?>"><?php echo $vo['Name']; ?>【<?php echo $vo['Comment']; ?>】</option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item row-fields">
                    <label class="layui-form-label">选择字段：</label>
                    <div class="layui-input-block fields" >

                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">要替换的字段：</label>
                    <div class="layui-input-block" >
                        <input type="text" id="field" name="field" placeholder="请选择字段" lay-verify="field" class="layui-input">
                    </div>
                </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">被替换的内容：</label>
                        <div class="layui-input-block" >
                            <textarea name="findstr" placeholder="请输入" lay-verify="findstr" class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">替换为内容：</label>
                        <div class="layui-input-block" >
                            <textarea name="tostr" placeholder="请输入" lay-verify="tostr" class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">替换条件：</label>
                        <div class="layui-input-block" >
                            <input type="text" name="where" placeholder="请输入" value="" class="layui-input">
                        </div>
                    </div>

                <div class="layui-form-item">

                </div>
            </div>
            </div>
        </div>
        <div class="layui-form-item center">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">保 存</button>
                <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="/static/js/admin_common.js"></script>
<script type="text/javascript">
    layui.use(['form', 'layer'], function(){
        // 操作对象
        var form = layui.form
                , layer = layui.layer,
                $ = layui.jquery;

        form.on('select(table)', function(data){
            $('.fields').html('');
            if(data.value !=''){
                $.post("<?php echo url('columns'); ?>", {table:data.value}, function(res) {
                    if (res.code == 1) {
                        $.each(res.data,function(index,row){
                            $(".fields").append('<a class="layui-btn layui-btn-xs w80" href="javascript:setfield(\''+row.Field+'\')">'+row.Field+'</a>&nbsp;&nbsp;');
                            if(index>0 && index%5==0){
                                //$(".fields").append('<br>');
                            }

                        });
                    }
                    layer.msg(res.msg);
                });
            }
        });


        // 验证
        form.verify({
            table: function (value) {
                if (value == "") {
                    return "请选择数据表";
                }
            },
            field: function (value) {
                if (value == "") {
                    return "请选择字段";
                }
            },
            findstr: function (value) {
                if (value == "") {
                    return "请输入需要替换的内容";
                }
            },
            tostr: function (value) {
                if (value == "") {
                    return "请输入替换为内容";
                }
            }
        });

    });

    function setfield(v){
        $('#field').val(v);
    }

</script>

</body>
</html>