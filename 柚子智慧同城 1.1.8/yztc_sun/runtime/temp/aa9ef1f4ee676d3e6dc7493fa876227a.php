<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:92:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/cstore/setting.html";i:1553823376;s:90:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit2.html";i:1553823404;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layui</title>
    <link rel="stylesheet" href="/addons/yztc_sun/public/static/bower_components/layui/src/css/layui.css">
    <script src="/addons/yztc_sun/public/static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/addons/yztc_sun/public/static/bower_components/layui/src/layui.js"></script>

    <link href="/addons/yztc_sun/public/static/bower_components/select2/dist/css/select2.css" rel="stylesheet" />
    <script src="/addons/yztc_sun/public/static/custom/pinyin.js"></script>

    <link href="/web/resource//css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="/web/resource//css/font-awesome.min.css" rel="stylesheet">-->
    <link href="/web/resource//css/common.css" rel="stylesheet">
    <script>

        window.sysinfo = {
            'siteroot': '<?php echo isset($_W['siteroot'])?$_W['siteroot']:''; ?>',
            'siteurl': '<?php echo isset($_W['siteurl'])?$_W['siteurl']:''; ?>',
            'attachurl': '<?php echo isset($_W['attachurl'])?$_W['attachurl']:''; ?>',
            'attachurl_local': '<?php echo isset($_W['attachurl_local'])?$_W['attachurl_local']:''; ?>',
            'attachurl_remote': '<?php echo isset($_W['attachurl_remote'])?$_W['attachurl_remote']:''; ?>',
            'cookie' : {'pre': '<?php echo isset($_W['config']['cookie']['pre'])?$_W['config']['cookie']['pre']:''; ?>'},
            'account' : <?php  echo json_encode($_W['account']) ?>
        };
    </script>
    <script src="/web/resource//js/app/util.js"></script>
    <script src="/web/resource//js/app/common.min.js"></script>
    <script>var require = { urlArgs: 'v=20161011' };</script>
    <script src="/web/resource//js/require.js"></script>
    <script src="/web/resource//js/app/config.js"></script>
    <script>
        requireConfig.baseUrl = "/web/resource/js/app";
        requireConfig.paths.select2 = "/addons/yztc_sun/public/static/bower_components/select2/dist/js/select2";
        require.config(requireConfig);

        require(['select2','bootstrap'], function () {
            $.fn.select2.defaults.set("matcher",function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (data.keywords && data.keywords.indexOf(params.term) > -1 || data.text.indexOf(params.term) > -1) {
                    return data;
                }
                return null;
            });
        });
    </script>
    <style>
        body{
            min-width: 0px !important;
        }
        .select2{
            width: 100%;
        }
        .select2 .select2-selection{
            height: 38px;
            border-radius: 2px;
            /*border-color: rgb(230,230,230);*/
        }
        .select2 .select2-selection__rendered{
            line-height: 38px!important;
        }
        .select2 .select2-selection__arrow{
            height: 36px!important;
        }

        .layui-form-item .layui-form-label{
            width: 180px;
        }
        .layui-form-item .layui-input-block{
            margin-left: 210px;
        }
        .layui-form-item .layui-input-inline{
            margin-left: 30px;
        }
    </style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div style="padding: 15px;">
        <form class="layui-form" method="post" action="<?php echo adminurl('save'); ?>">
            <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''; ?>">
            
<div class="layui-form-item">
    <label class="layui-form-label">商品新增审核</label>
    <div class="layui-input-block">
        <input type="radio" name="goods_insert_check" value="1" title="开启" <?php echo !empty($info['goods_insert_check'])?"checked" :""; ?>>
        <input type="radio" name="goods_insert_check" value="0" title="关闭" <?php echo !empty($info['goods_insert_check'])?"" : "checked"; ?>>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">商品编辑审核</label>
    <div class="layui-input-block">
        <input type="radio" name="goods_update_check" value="1" title="开启" <?php echo !empty($info['goods_update_check'])?"checked" :""; ?>>
        <input type="radio" name="goods_update_check" value="0" title="关闭" <?php echo !empty($info['goods_update_check'])?"" : "checked"; ?>>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商品入驻开关</label>
    <div class="layui-input-block">
        <input type="radio" name="entering_switch" value="1" title="开启" <?php echo !empty($info['entering_switch'])?"checked" :""; ?>>
        <input type="radio" name="entering_switch" value="0" title="关闭" <?php echo !empty($info['entering_switch'])?"" : "checked"; ?>>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">入驻申请banner图</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('merchants_settled_in', isset($info['merchants_settled_in'])?$info['merchants_settled_in']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：750*340</div>
    </div>
</div>



<!--
<div class="layui-form-item">
    <label class="layui-form-label">多商户开关</label>
    <div class="layui-input-block">
        <input type="radio" name="mstore_switch" value="1" title="开启" <?php echo !empty($info['mstore_switch'])?"checked" :""; ?>>
        <input type="radio" name="mstore_switch" value="0" title="关闭" <?php echo !empty($info['mstore_switch'])?"" : "checked"; ?>>
    </div>
</div>-->

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="">立即提交</button>
                    <!--<button class="layui-btn layui-btn-primary" id="btnCancel">取消</button>-->
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element','form'], function(){
        var element = layui.element;
        var form = layui.form;
        
// 新增界面、保存、取消事件
form.on('submit', function(data){
if(!$(data.elem).is('button')){
return false;
}
var data = data.field;
var url = "<?php echo adminurl('setting_save'); ?>";
$.post(url,data,function(res){
if (typeof res == 'string'){
res = $.parseJSON(res);
}
if (res.code == 0) {
layer.msg('保存成功',{icon: 6,anim: 6});
location.reload();
}else{
layer.msg(res.msg,{icon: 5,anim: 6});
}
});
return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
});


        $('#btnCancel').click(function(e){
            var index=parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        })
    })
</script>
</body>
</html>