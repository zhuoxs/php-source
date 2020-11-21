<?php
require '../../Mao/common.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='login.php';</script>");
if( $_SERVER['HTTP_REFERER'] == "" ){
    exit('404');
}
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] :null;
if($mao['id'] == 1){
	$cha_1 = $DB->get_row("select * from mao_dindan where id='{$id}' limit 1");
}else{
	$cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and id='{$id}' limit 1");
}
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
                        <legend>订单操作</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">订单号</label>
                            <div class="layui-input-block">
                                <input type="text" class="layui-input layui-disabled" value="<?php echo $cha_1['ddh']?>" disabled>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品名称</label>
                            <div class="layui-input-block">
                                <input type="text" class="layui-input layui-disabled" value="<?php echo $cha_1['name']?>" disabled>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">购买数量</label>
                            <div class="layui-input-block">
                                <input type="text" class="layui-input layui-disabled" value="<?php echo $cha_1['sl']?>" disabled>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">是否发货</label>
                            <div class="layui-input-block">
                                <select id="type" lay-filter="zt">
                                    <option>否</option>
                                    <option value="2" <?php if($cha_1['zt'] == 2){ echo 'selected=""';}else{}?>>发货</option>
                                    <option value="3" <?php if($cha_1['zt'] == 3){ echo 'selected=""';}else{}?>>异常</option>
                                </select>
                            </div>
                        </div>
                        <div id="zt2" style="display:none;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">快递公司</label>
                                <div class="layui-input-block">
                                    <input type="text" id="kdgs" autocomplete="off" placeholder="请输入快递公司(如：圆通速递)" class="layui-input" value="<?php echo $cha_1['kdgs']?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">运单号</label>
                                <div class="layui-input-block">
                                    <input type="text" id="ydh" autocomplete="off" placeholder="请输入运单号" class="layui-input" value="<?php echo $cha_1['ydh']?>">
                                </div>
                            </div>
                        </div>
                        <div id="zt3" style="display:none;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">异常信息</label>
                                <div class="layui-input-block">
                                    <input type="text" id="msg" autocomplete="off" placeholder="请输入订单异常信息(返回给用户)" class="layui-input" value="<?php echo $cha_1['msg']?>">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="layui-form-item">
                        <button class="layui-btn" onclick="set()"><i class="layui-icon">&#xe609;</i> 确 定</button>
                    </div>
                    <div class="layui-form-item">
                        <blockquote class="layui-elem-quote">
                            <p style="color: #ff0000;font-weight: 700;">收件人信息</p>
                            <p>
                                姓名：<?php echo $cha_1['xm']?><br>
                                手机：<?php echo $cha_1['sjh']?><br>
                                地址：<?php echo $cha_1['dz']?> <?php echo $cha_1['xxdz']?><br>
                                购买留言：<?php echo $cha_1['ly']?>
                            </p>
                            <br>
                            <p style="color: #ff0000;font-weight: 700;">入网信息资料</p>
                            <p>
                                机主姓名：<?php echo $cha_1['jzxm']?><br>
                                身份证号：<?php echo $cha_1['sfzh']?><br>
                                资料图片：
                            </p>
                            <p id="layer-photos-demo">
                                <?php
                                if($cha_1['mgz'] != ""){
                                    ?><img style="height: 50px;width: 80px;margin-right: 3px;" layer-src="<?php echo $cha_1['mgz']?>" src="<?php echo $cha_1['mgz']?>" alt="免冠照"><?php
                                }else{

                                }
                                if($cha_1['sfz1'] != ""){
                                    ?><img style="height: 50px;width: 80px;margin-right: 3px;" layer-src="<?php echo $cha_1['sfz1']?>" src="<?php echo $cha_1['sfz1']?>" alt="身份证正面"><?php
                                }else{

                                }
                                if($cha_1['sfz2'] != ""){
                                    ?><img style="height: 50px;width: 80px;margin-right: 3px;" layer-src="<?php echo $cha_1['sfz2']?>" src="<?php echo $cha_1['sfz2']?>" alt="身份证反面"><?php
                                }else{

                                }
                                ?>
                            </p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../layui/layui.js"></script>
<script>
    <?php
    if($cha_1['zt'] == 2){
    ?>
    $('#zt2').show();
    $('#zt3').hide();
    <?php
    }elseif($cha_1['zt'] == 3){
    ?>
    $('#zt3').show();
    $('#zt2').hide();
    <?php
    }
    ?>
    layui.config({
        base: '../' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','layer','form'], function(){
        var layer = layui.layer,
            form = layui.form;
        layer.photos({
            photos: '#layer-photos-demo'
        });
        form.on('select(zt)', function(data){
            if(data.value == 2){
                $('#zt2').show();
                $('#zt3').hide();
            } else if(data.value == 3){
                $('#zt3').show();
                $('#zt2').hide();
            }
        })
    });
    function set() {
        var loading = layer.load();
        $.ajax({
            url: '/Mao_admin/api.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mod: "set_dindan",
                id: "<?php echo $cha_1['id']?>",
                type: $('#type').val(),
                kdgs: $('#kdgs').val(),
                ydh: $('#ydh').val(),
                msg: $('#msg').val()
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
</script>
</body>
</html>
