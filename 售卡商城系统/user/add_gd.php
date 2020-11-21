<?php
require '../Mao/common.php';
if($_SESSION['Mao_login']==1){}else exit("<script language='javascript'>window.location.href='/login.php';</script>");
$ddh = isset($_GET['ddh']) ? $_GET['ddh'] :null;
$cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && ddh='{$ddh}') limit 1");
if(!$cha_1 || $cha_1['zt'] ==0 || $cha_1['zt'] == 1){
    sysmsg("订单不存在！");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>提交工单-<?php echo $mao['title']?></title>
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.min.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.diy.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/iconfont.css">
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
            <div class="title">提交工单</div>
            <div class="fui-header-right">
            </div>
        </div>
        <div class="fui-content navbar" style="bottom: 0rem;padding-bottom: 0rem;">
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-label">订单编号</div>
                    <div class="fui-cell-info c000">
                        <input type="text" class="fui-input" value="<?php echo $cha_1['ddh']?>" disabled="disabled">
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">卡号</div>
                    <div class="fui-cell-info c000">
                        <input type="text" class="fui-input" id="kh" placeholder="请输入卡号">
                    </div>
                </div>
            </div>
            <div class="fui-cell-group">
                <div class="fui-cell applyradio " style="display: flex;">
                    <div class="fui-cell-info" style="height: 100%">
                        <div class="title">不能上网</div>
                    </div>
                    <div class="fui-cell-remark noremark">
                        <input name="applytype" type="radio" id="type" class="fui-radio fui-radio-danger" value="1" checked>
                    </div>
                </div>
                <div class="fui-cell applyradio " style="display: flex;">
                    <div class="fui-cell-info" style="height: 100%">
                        <div class="title">其他问题</div>
                    </div>
                    <div class="fui-cell-remark noremark">
                        <input name="applytype" type="radio" id="type" class="fui-radio fui-radio-danger" value="2">
                    </div>
                </div>
            </div>
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-info c000">
                        <textarea type="text" class="fui-input" rows="3" id="wt" placeholder="请描述您遇到的问题(100字以内)" style="height: 5em;"></textarea>
                    </div>
                </div>
            </div>
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-label">上传图片</div>
                    <div class="fui-cell-info" id="cs">0/4</div>
                    <div class="fui-cell-remark noremark" style="overflow: hidden;text-overflow:ellipsis;white-space: nowrap;" id="btn">
                        <button type="button" class="layui-btn layui-btn-xs jb" id="test2">图片上传</button>
                    </div>
                </div>
                <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                    <div class="layui-upload-list" id="demo2"></div>
                </blockquote>
                <div style="display:none;">
                    <input type="text" id="img_url" disabled="disabled">
                </div>
            </div>
            <div class="fui-cell-group fui-cell-click transparent">
                <a class="fui-cell external btn-mao" onclick="add()">
                    <div class="fui-cell-text jb" style="text-align: center;">
                        <p>提 交</p>
                    </div>
                </a>
            </div><br>
        </div>
    </div>
</div>
<script src="/Mao_Public/layui/layui.js"></script>
<script>
    var cs = 0;
    layui.use('upload', function(){
        var upload = layui.upload;
        upload.render({
            elem: '#test2'
            ,url: '../api/api.php?mod=upload&type=1'
            ,multiple: true
            ,done: function(res){
                if(res.code == 0){
                    js = (cs + 1);
                    cs = js;
                    $('#cs').html(js+'/4');
                    if(cs >= 4){
                        $('#btn').html('<button type="button" class="layui-btn layui-btn-xs layui-btn-disabled jb">图片上传</button>');
                    }
                    $('#demo2').append('<img src="'+ res.name +'" class="layui-upload-img" style="height: 50px;width: 80px;margin-right: 3px;">')
                    if($('#img_url').val() == "" || $('#img_url').val() == null){
                        img = res.name;
                    }else{
                        img = "<br>"+res.name+"";
                    }
                    $('#img_url').val(""+$('#img_url').val()+""+img+"")
                }else{
                    layer.msg(res.msg);
                }
            }
            ,error: function(){
                layer.msg('~连接服务器失败！', {icon: 5});
            }
        });
    });
    function add() {
        var loading = layer.load();
        $.ajax({
            url: '../api/api.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mod: "add_gd",
                ddh: "<?php echo $cha_1['ddh']?>",
                kh: $("#kh").val(),
                type: $('input[name="applytype"]:checked').val(),
                wt: $("#wt").val(),
                img_url: $("#img_url").val()
            },
            success: function (a) {
                layer.close(loading);
                if (a.code == 0) {
                    layer.msg(a.msg, function(){
                        window.location.href="/user/feedback.php";
                    });
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
