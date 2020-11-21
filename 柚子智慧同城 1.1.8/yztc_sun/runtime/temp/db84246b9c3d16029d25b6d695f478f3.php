<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:89:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/cprints/set.html";i:1553823386;s:93:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit_set.html";i:1553823403;}*/ ?>
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
        <form class="layui-form" method="post" action="<?php echo adminurl('save_set'); ?>">
            <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''; ?>">
            
<div class="layui-form-item">
    <label class="layui-form-label">请选择打印机</label>
    <div class="layui-input-block">
        <select name="prints_id" id="prints_id" class="select2" lay-ignore></select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">订单打印方式</label>
    <div class="layui-input-block">
        <input type="checkbox" name="print_type[]" value="1" <?php if(in_array(1,$info['print_type_z'])) echo "checked"; ?> title="下单打印">
        <input type="checkbox" name="print_type[]" value="2" <?php if(in_array(2,$info['print_type_z'])) echo "checked"; ?> title="付款打印">
        <input type="checkbox" name="print_type[]" value="3" <?php if(in_array(3,$info['print_type_z'])) echo "checked"; ?> title="确认收货打印">
    </div>
</div>

<!--
<div class="layui-form-item" pane="">
    <label class="layui-form-label">原始复选框</label>
    <div class="layui-input-block">
        <input type="checkbox" name="like1[write]" lay-skin="primary" title="写作" checked="">
        <input type="checkbox" name="like1[read]" lay-skin="primary" title="阅读">
        <input type="checkbox" name="like1[game]" lay-skin="primary" title="游戏" disabled="">
    </div>
</div>-->


<div class="layui-form-item">
    <label class="layui-form-label"><?php if($_SESSION['admin']['store_id'] == 0): ?>多商户订单<?php else: ?>打印开关<?php endif; ?></label>
    <div class="layui-input-block">
        <input type="radio" name="print_merch" value="1" title="打印" <?php echo !empty($info['print_merch'])?"checked" :""; ?>>
        <input type="radio" name="print_merch" value="0" title="不打印" <?php echo !empty($info['print_merch'])?"" : "checked"; ?>>
    </div>
</div>

<script>
    require(['select2'], function () {
        $('.select2').select2();
        $.get("<?php echo adminurl('select'); ?>", function (ret) {
            if (typeof ret == "string"){
                ret = JSON.parse(ret);
            }
        //    ret.unshift({id: '', text: '请选择上级分类'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if(obj.id == "<?php echo isset($info['id'])?$info['id']:''; ?>"){
                    obj.selected = true;
                }
                return obj;
            });
            $('#prints_id').select2({
                data: ret,
            })
        })
    })
</script>


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
            var url = "<?php echo adminurl('save_set'); ?>";
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