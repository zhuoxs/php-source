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
                        <legend>支付配置</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <blockquote class="layui-elem-quote">系统目前只支持对接易支付,不会对接站长可选择系统默认支付,提现0手续费~</blockquote>
                    <hr>
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">支付类型</label>
                            <div class="layui-input-block">
                                <select id="type" lay-filter="yzf">
                                    <option value="0" <?php if($mao['yzf_type'] == 0){ echo 'selected=""';}else{}?>>自定义对接</option>
                                    <option value="1" <?php if($mao['yzf_type'] == 1){ echo 'selected=""';}else{}?>>系统支付</option>
                                    <option value="2" <?php if($mao['yzf_type'] == 2){ echo 'selected=""';}else{}?>>码支付</option>
                                </select>
                            </div>
                        </div>
                        <div id="zf1" style="display:none;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">易支付ID</label>
                                <div class="layui-input-block">
                                    <input type="text" id="yzf_id" autocomplete="off" placeholder="请输入易支付ID" class="layui-input" value="<?php echo $mao['yzf_id']?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">易支付KEY</label>
                                <div class="layui-input-block">
                                    <input type="text" id="yzf_key" autocomplete="off" placeholder="请输入易支付KEY" class="layui-input" value="<?php echo $mao['yzf_key']?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">易支付API</label>
                                <div class="layui-input-block">
                                    <input type="text" id="yzf_url" autocomplete="off" placeholder="请输入易支付API" class="layui-input" value="<?php echo $mao['yzf_url']?>">
                                </div>
                            </div>
                        </div>
                        <div id="zf2" style="display:none;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">提现帐号</label>
                                <div class="layui-input-block">
                                    <input type="text" id="tx_zh" autocomplete="off" placeholder="请输入提现支付宝帐号" class="layui-input" value="<?php echo $mao['tx_zh']?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">帐号实名</label>
                                <div class="layui-input-block">
                                    <input type="text" id="tx_sm" autocomplete="off" placeholder="请输入支付宝帐号实名" class="layui-input" value="<?php echo $mao['tx_sm']?>">
                                </div>
                            </div>
                        </div>
                        <div id="zf3" style="display:none;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">码支付ID</label>
                                <div class="layui-input-block">
                                    <input type="text" id="mzf_id" autocomplete="off" placeholder="码支付ID" class="layui-input" value="<?php echo $mao['mzf_id']?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">码支付KEY</label>
                                <div class="layui-input-block">
                                    <input type="text" id="mzf_key" autocomplete="off" placeholder="码支付秘钥" class="layui-input" value="<?php echo $mao['mzf_key']?>">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">支付宝支付</label>
                            <div class="layui-input-block">
                                <input type="checkbox" <?php if($mao['zfb_zf'] == 0){ echo 'checked=""';}else{}?> name="open" lay-skin="switch" lay-filter="switchTest" lay-text="关闭|开启" value="1">
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">QQ钱包支付</label>
                            <div class="layui-input-block">
                                <input type="checkbox" <?php if($mao['qq_zf'] == 0){ echo 'checked=""';}else{}?> name="open" lay-skin="switch" lay-filter="switchTest" lay-text="关闭|开启" value="2">
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">微信扫码支付</label>
                            <div class="layui-input-block">
                                <input type="checkbox" <?php if($mao['wx_zf'] == 0){ echo 'checked=""';}else{}?> name="open" lay-skin="switch" lay-filter="switchTest" lay-text="关闭|开启" value="3">
                            </div>
                        </div>
                    </form>
                    <button class="layui-btn" onclick="set()"><i class="layui-icon">&#xe609;</i> 保 存</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../layui/layui.js"></script>
<script>
    <?php
        if($mao['yzf_type'] == 0){
            ?>
    $('#zf1').show();
    $('#zf2').hide();
    $('#zf3').hide();
            <?php
        }elseif($mao['yzf_type'] == 1){
            ?>
    $('#zf2').show();
    $('#zf1').hide();
    $('#zf3').hide();
            <?php
        }elseif($mao['yzf_type'] == 2){
            ?>
    $('#zf3').show();
    $('#zf1').hide();
    $('#zf2').hide();
        <?php
}
?>
    layui.config({
        base: '../' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','form'], function(){
        var form = layui.form;
        form.on('select(yzf)', function(data){
            if(data.value == 0){
                $('#zf1').show();
                $('#zf2').hide();
                $('#zf3').hide();
            } else if(data.value == 1){
                $('#zf2').show();
                $('#zf1').hide();
                $('#zf3').hide();
            } else if(data.value == 2){
                $('#zf3').show();
                $('#zf1').hide();
                $('#zf2').hide();
            }
        })
        form.on('switch(switchTest)', function(data){
            var loading = layer.load();
            $.ajax({
                url: '/Mao_admin/api.php',
                type: 'POST',
                dataType: 'json',
                data: {mod: 'zf_zt', type: this.value},
                success: function (a) {
                    layer.close(loading);
                    if(a.code == 0){
                        layer.msg(a.msg);
                    } else {
                        layer.msg(a.msg);
                    }
                },
                error: function() {
                    layer.close(loading);
                    layer.msg('~连接服务器失败！', {icon: 5});
                }
            });
        });
    });
    function set() {
        var loading = layer.load();
        $.ajax({
            url: '/Mao_admin/api.php',
            type: 'POST',
            dataType: 'json',
            data: {mod: "yzf",type: $('#type').val(),mzf_id: $('#mzf_id').val(),mzf_key: $('#mzf_key').val(),yzf_id: $('#yzf_id').val(),yzf_key: $('#yzf_key').val(),yzf_url: $('#yzf_url').val(),tx_zh: $('#tx_zh').val(),tx_sm: $('#tx_sm').val()},
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