<?php
require '../../Mao/common.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='login.php';</script>");
if( $_SERVER['HTTP_REFERER'] == "" ){
    exit('404');
}
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] :null;
$cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
if(!$cha_1){
    exit('404');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $mao['title']?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../css/admin.css" media="all">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md2"></div>
        <div class="layui-col-md8">
            <div class="layui-card">
                <div class="layui-card-header">
                    <fieldset class="layui-elem-field layui-field-title">
                        <legend>商品修改</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品名称</label>
                            <div class="layui-input-block">
                                <input type="text" id="name" autocomplete="off" placeholder="如：某某卡" class="layui-input" value="<?php echo $cha_1['name']?>">
                            </div>
                        </div>
                        <div class="layui-form-item" id="img">
                            <label class="layui-form-label">商品图片</label>
                            <div class="layui-input-inline">
                                <input type="text" id="img_url" placeholder="请上传商品图片！" class="layui-input" value="<?php echo $cha_1['img']?>">
                            </div>
                            <button type="button" class="layui-btn layui-btn-danger" id="test"><i class="layui-icon"></i>上传图片</button>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品分类</label>
                            <div class="layui-input-block">
                                <select id="type">
                                    <option value="">请选择商品分类</option>
                                    <option value="1" <?php if($cha_1['type'] == 1){ echo 'selected=""';}else{}?>>中国电信</option>
                                    <option value="2" <?php if($cha_1['type'] == 2){ echo 'selected=""';}else{}?>>中国移动</option>
                                    <option value="3" <?php if($cha_1['type'] == 3){ echo 'selected=""';}else{}?>>中国联通</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">优惠达到</label>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <input type="number" id="youhui_zhang" placeholder="填0则不启用优惠功能" autocomplete="off" class="layui-input" value="<?php echo $cha_1['youhui_zhang']?>">
                                </div>
                                <div class="layui-form-mid">张 -</div>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <input type="number" id="youhui_price" placeholder="￥" autocomplete="off" class="layui-input" value="<?php echo $cha_1['youhui_price']?>">
                                </div>
                                <div class="layui-form-mid">元/张</div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">禁止地区</label>
                            <div class="layui-input-inline" style="width: 50%;">
                                <input type="text" id="dqpb" autocomplete="off" placeholder="如：北京|广东|上海" class="layui-input" value="<?php echo $cha_1['dqpb']?>">
                            </div>
                            <div class="layui-form-mid layui-word-aux">禁止部分地区下单</div>
                        </div>
                        <div class="layui-form-item">
                            <textarea id="spsm" placeholder="商品说明"><?php echo $cha_1['xq']?></textarea>
                        </div>
                    </form>
                    <button class="layui-btn site-demo-layedit" data-type="set"><i class="layui-icon">&#xe642;</i> 修 改 商 品</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../layui/layui.js"></script>
<script>
    layui.config({
        base: '../' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','form','upload','layedit'], function(){
        var upload = layui.upload
            ,layedit = layui.layedit;
        upload.render({
            elem: '#test'
            ,url: '/api/api.php?mod=upload&type=1'
            ,done: function(res){
                if(res.code == 0){
                    $('#img').html('<label class="layui-form-label">上传成功</label><div class="layui-input-block"><input type="text" id="img_url" class="layui-input layui-disabled" value="'+res.name+'" disabled></div>');
                } else {
                    layer.msg(a.msg);
                }
            }
        });
        layedit.set({
            uploadImage: {
                url: '/api/api.php?mod=upload&type=1'
                ,type: 'post'
            }
        });
        var index = layedit.build('spsm');
        var active = {
            set: function(){
                var loading = layer.load();
                $.ajax({
                    url: '/Mao_admin/api.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mod: "set_commodity",
                        id: "<?php echo $cha_1['id']?>",
                        name: $('#name').val(),
                        img_url: $('#img_url').val(),
                        type: $('#type').val(),
                        youhui_zhang: $('#youhui_zhang').val(),
                        youhui_price: $('#youhui_price').val(),
                        dqpb: $('#dqpb').val(),
                        spsm: layedit.getContent(index)
                    },
                    success: function (a) {
                        layer.close(loading);
                        if (a.code == 0) {
                            layer.msg(a.msg);
                        }else {
                            layer.msg(a.msg);
                        }
                    },
                    error: function() {
                        layer.close(loading);
                        layer.msg('~连接服务器失败！', {icon: 5});
                    }
                });
            }
        };
        $('.site-demo-layedit').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>