<?php
require '../../Mao/common.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='login.php';</script>");
if( $_SERVER['HTTP_REFERER'] == "" ){
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
                        <legend>添加商品</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品名称</label>
                            <div class="layui-input-block">
                                <input type="text" id="name" autocomplete="off" placeholder="如：某某卡" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item" id="img">
                            <label class="layui-form-label">商品图片</label>
                            <div class="layui-input-inline">
                                <input type="text" id="img_url" placeholder="请上传商品图片！" class="layui-input">
                            </div>
                            <button type="button" class="layui-btn layui-btn-danger" id="test"><i class="layui-icon"></i>上传图片</button>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品分类</label>
                            <div class="layui-input-block">
                                <select id="type">
                                    <option value="">请选择商品分类</option>
                                    <option value="1">中国电信</option>
                                    <option value="2">中国移动</option>
                                    <option value="3">中国联通</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">商品推荐</label>
                            <div class="layui-input-block">
                                <input type="radio" name="tj" value="0" title="推荐">
                                <input type="radio" name="tj" value="1" title="不推荐" checked="">
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">批量购买</label>
                            <div class="layui-input-block">
                                <input type="radio" name="sl" value="0" title="开启">
                                <input type="radio" name="sl" value="1" title="关闭" checked="">
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">入网资料</label>
                            <div class="layui-input-block">
                                <input type="radio" name="rwzl" value="0" title="需要">
                                <input type="radio" name="rwzl" value="1" title="不需要" checked="">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品价格</label>
                            <div class="layui-input-block">
                                <input type="number" id="price" autocomplete="off" placeholder="支持设置0元" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品运费</label>
                            <div class="layui-input-block">
                                <input type="number" id="yf_price" autocomplete="off" placeholder="填0则免运费" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">优惠达到</label>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <input type="number" id="youhui_zhang" placeholder="填0则不启用优惠功能" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid">张 -</div>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <input type="number" id="youhui_price" placeholder="￥" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid">元/张</div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品库存</label>
                            <div class="layui-input-block">
                                <input type="number" id="kucun" autocomplete="off" placeholder="请填写商品当前库存" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品销量</label>
                            <div class="layui-input-block">
                                <input type="number" id="xiaoliang" autocomplete="off" placeholder="自定义商品销量" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">禁止地区</label>
                            <div class="layui-input-inline" style="width: 50%;">
                                <input type="text" id="dqpb" autocomplete="off" placeholder="入：北京|广东|上海" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">禁止部分地区下单</div>
                        </div>
                        <div class="layui-form-item">
                            <textarea id="spsm" placeholder="商品说明">商品说明</textarea>
                        </div>
                    </form>
                    <button class="layui-btn site-demo-layedit" data-type="add"><i class="layui-icon">&#xe61f;</i> 添 加 商 品</button>
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
            add: function(){
                var loading = layer.load();
                $.ajax({
                    url: '/Mao_admin/api.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mod: "add_commodity",
                        name: $('#name').val(),
                        img_url: $('#img_url').val(),
                        type: $('#type').val(),
                        tj: $('input[name="tj"]:checked').val(),
                        slxd: $('input[name="sl"]:checked').val(),
                        rwzl: $('input[name="rwzl"]:checked').val(),
                        price: $('#price').val(),
                        yf_price: $('#yf_price').val(),
                        youhui_zhang: $('#youhui_zhang').val(),
                        youhui_price: $('#youhui_price').val(),
                        kucun: $('#kucun').val(),
                        xiaoliang: $('#xiaoliang').val(),
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