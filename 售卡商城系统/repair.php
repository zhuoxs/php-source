<?php
require './Mao/common.php';
$cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and ddh='{$_SESSION['ddh']}' limit 1");
$cha_2 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$cha_1['M_sp']}' limit 1");
if(!$cha_1 || !$cha_2 || $cha_1['zt'] != 1){
    sysmsg("订单或商品不存在！");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>补齐信息-<?php echo $mao['title']?></title>
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.min.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.diy.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/dz.css">
    <link rel="stylesheet" href="/Mao_Public/layui/css/layui.css">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
    <script src="/Mao_Public/layer/layer.js"></script>
    <script src="/Mao_Public/js/Mao.js"></script>
</head>
<body>
<div class="fui-page-group statusbar">
    <div class="fui-page fui-page-current order-pay-page">
        <div class="fui-header jb">
            <div class="fui-header-left">
                <a onclick="goBack()" class="back" style="color: #f7f7f7;"></a>
            </div>
            <div class="title">补齐订单信息</div>
            <div class="fui-header-right">
            </div>
        </div>
        <div class="fui-content navbar" style="bottom: 0rem;padding-bottom: 0rem;">
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-label">收件人姓名</div>
                    <div class="fui-cell-info c000">
                        <input type="text" class="fui-input" id="xm" placeholder="请输入收件人姓名">
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">收件人手机</div>
                    <div class="fui-cell-info c000">
                        <input type="text" class="fui-input" placeholder="请输入收件人手机号" value="<?php echo $_SESSION['shouji']?>" disabled="disabled">
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">收件人地址</div>
                    <div class="fui-cell-info c000">
                        <input type="text" class="fui-input" id="dz" placeholder="请选择收件地址">
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">详细地址</div>
                    <div class="fui-cell-info c000">
                        <input type="text" class="fui-input" id="xxdz" placeholder="请输入详细街道地址">
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">买家留言</div>
                    <div class="fui-cell-info c000">
                        <input type="text" class="fui-input" id="ly" placeholder="可以为空">
                    </div>
                </div>
            </div>
            <?php
            if($cha_2['rwzl_zt'] == 0){
                ?>
                <div class="fui-cell-group">
                    <div class="fui-cell-title" style="height: 2.45rem;font-size:.7rem;color:#666;line-height: 1.425rem">补齐入网资料</div>
                    <div class="fui-cell">
                        <div class="fui-cell-label">机主姓名</div>
                        <div class="fui-cell-info c000">
                            <input type="text" class="fui-input" id="jzxm" placeholder="请输入机主姓名">
                        </div>
                    </div>
                    <div class="fui-cell">
                        <div class="fui-cell-label">身份证号</div>
                        <div class="fui-cell-info c000">
                            <input type="text" class="fui-input" id="sfzh" placeholder="请输入机主身份证号码">
                        </div>
                    </div>
                    <div class="fui-cell">
                        <div class="fui-cell-label">免冠照</div>
                        <div class="fui-cell-info c000">
                            <input type="text" class="fui-input" id="mgz" placeholder="请上传免冠照" disabled="disabled">
                        </div>
                        <div class="fui-cell-remark noremark">
                            <button type="button" class="layui-btn layui-btn-xs jb" id="test1">
                                <i class="layui-icon">&#xe67c;</i>上传
                            </button>
                        </div>
                    </div>
                    <div class="fui-cell">
                        <div class="fui-cell-label">身份证/正</div>
                        <div class="fui-cell-info c000">
                            <input type="text" class="fui-input" id="sfz1" placeholder="请上传身份证正面照" disabled="disabled">
                        </div>
                        <div class="fui-cell-remark noremark">
                            <button type="button" class="layui-btn layui-btn-xs jb" id="test2">
                                <i class="layui-icon">&#xe67c;</i>上传
                            </button>
                        </div>
                    </div>
                    <div class="fui-cell">
                        <div class="fui-cell-label">身份证/反</div>
                        <div class="fui-cell-info c000">
                            <input type="text" class="fui-input" id="sfz2" placeholder="请上传身份证反面照" disabled="disabled">
                        </div>
                        <div class="fui-cell-remark noremark">
                            <button type="button" class="layui-btn layui-btn-xs jb" id="test3">
                                <i class="layui-icon">&#xe67c;</i>上传
                            </button>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="fui-cell-group fui-cell-click transparent">
                <a class="fui-cell external btn-mao" onclick="submit()">
                    <div class="fui-cell-text jb" style="text-align: center;">
                        <p>保 存</p>
                    </div>
                </a>
            </div><br>
        </div>
    </div>
</div>
<script src="/Mao_Public/js/city.js"></script>
<script src="/Mao_Public/js/address.js"></script>
<script src="/Mao_Public/layui/layui.js"></script>
<script>
    layui.use('upload', function(){
        var upload = layui.upload;
        upload.render({
            elem: '#test1'
            ,url: '../api/api.php?mod=upload&type=1'
            ,done: function(res){
                layer.msg(res.msg, function(){
                    if(res.code == 0){
                        $('#mgz').val(res.name)
                    }
                });
            }
            ,error: function(){
                layer.msg('~连接服务器失败！', {icon: 5});
            }
        });
        upload.render({
            elem: '#test2'
            ,url: '../api/api.php?mod=upload&type=1'
            ,done: function(res){
                layer.msg(res.msg, function(){
                    if(res.code == 0){
                        $('#sfz1').val(res.name)
                    }
                });
            }
            ,error: function(){
                layer.msg('~连接服务器失败！', {icon: 5});
            }
        });
        upload.render({
            elem: '#test3'
            ,url: '../api/api.php?mod=upload&type=1'
            ,done: function(res){
                layer.msg(res.msg, function(){
                    if(res.code == 0){
                        $('#sfz2').val(res.name)
                    }
                });
            }
            ,error: function(){
                layer.msg('~连接服务器失败！', {icon: 5});
            }
        });
    });
    !function() {
        var $target = $('#dz');
        $target.citySelect();
        $target.on('click', function(event) {
            event.stopPropagation();
            $target.citySelect('open');
        });
        $target.on('done.ydui.cityselect', function(ret) {
            $(this).val(ret.provance + ' ' + ret.city + ' ' + ret.area);
        });
    }();
    function submit() {
        var loading = layer.load();
        $.ajax({
            url: '../api/api.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mod: "repair",
                ddh: "<?php echo $cha_1['ddh']?>",
                xm: $("#xm").val(),
                dz: $("#dz").val(),
                xxdz: $("#xxdz").val(),
                ly: $("#ly").val(),
                jzxm: $("#jzxm").val(),
                sfzh: $("#sfzh").val(),
                mgz: $("#mgz").val(),
                sfz1: $("#sfz1").val(),
                sfz2: $("#sfz2").val()
            },
            success: function (a) {
                layer.close(loading);
                if (a.code == 0) {
                    window.location.href="/orderpay.php";
                } else {
                    layer.msg(a.msg);
                }
            },
            error: function() {
                layer.close(loading);
                layer.msg('~连接服务器失败！', {icon: 5});
            }
        });
    }
</script>
</body>
</html>
