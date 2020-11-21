<?php
require '../../Mao/common.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='login.php';</script>");
if( $_SERVER['HTTP_REFERER'] == "" ){
    exit('404');
}
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] :null;
$cha_1 = $DB->get_row("select * from mao_gd where M_id='{$mao['id']}' and id='{$id}' limit 1");
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
                        <legend>工单操作</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">所属订单</label>
                            <div class="layui-input-block">
                                <input type="text" class="layui-input layui-disabled" value="<?php echo $cha_1['ddh']?>" disabled>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">卡号</label>
                            <div class="layui-input-block">
                                <input type="text" class="layui-input layui-disabled" value="<?php echo $cha_1['kh']?>" disabled>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">工单类型</label>
                            <?php
                            if($cha_1['type'] == 1){
                                $type = '不能上网';
                            }elseif($cha_1['type'] == 2){
                                $type = '其他问题';
                            }else{
                                $type = '其他问题';
                            }
                            ?>
                            <div class="layui-input-block">
                                <input type="text" class="layui-input layui-disabled" value="<?php echo $type?>" disabled>
                            </div>
                        </div>
                        <blockquote class="layui-elem-quote">
                            <p>描述的问题</p>
                            <p style="color: #ff0000;"><?php if($cha_1['wt'] == "" || $cha_1['wt'] == null){echo '未提交描述~';}else{echo $cha_1['wt'];}?></p>
                            <p id="layer-photos-demo">
                                <?php
                                if($cha_1['img'] == "" || $cha_1['img'] == null){
                                    echo '<span style="color: #ff0000;">未上传图片~</span>';
                                }else{
                                    $pieces = explode("<br>", $cha_1['img']);
                                    foreach($pieces as $val){
                                        echo '<img style="height: 50px;width: 80px;margin-right: 3px;" layer-src="'.$val.'" src="'.$val.'" alt="问题描述图片">';
                                    }
                                }
                                ?>
                            </p>
                        </blockquote>
                        <div class="layui-form-item">
                            <textarea id="chuli" placeholder="工单处理内容"><?php if($cha_1['msg'] == "" || $cha_1['msg'] == null){echo '请填写工单处理内容';}else{echo $cha_1['msg'];}?></textarea>
                        </div>
                    </form>
                    <button class="layui-btn site-demo-layedit" data-type="set"><i class="layui-icon">&#xe642;</i> 保 存</button>
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
    }).use(['index','layer','layedit'], function(){
        var layer = layui.layer
            ,layedit = layui.layedit;
        layer.photos({
            photos: '#layer-photos-demo'
        });
        layedit.set({
            uploadImage: {
                url: '/api/api.php?mod=upload&type=1'
                ,type: 'post'
            }
        });
        var index = layedit.build('chuli');
        var active = {
            set: function(){
                var loading = layer.load();
                $.ajax({
                    url: '/Mao_admin/api.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mod: "set_survey",
                        id: "<?php echo $cha_1['id']?>",
                        value: layedit.getContent(index)
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
