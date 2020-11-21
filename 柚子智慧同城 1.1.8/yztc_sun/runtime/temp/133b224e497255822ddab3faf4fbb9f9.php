<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:92:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/ccategory/edit.html";i:1553823426;s:89:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit.html";i:1553823405;}*/ ?>
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
            
<link rel="stylesheet" href="/addons/yztc_sun/public/static/bower_components/layui/extend/cascader.css">
<!--
<div class="layui-form-item">
    <label class="layui-form-label">上级分类</label>
    <div class="layui-input-block">
        <input type="text" id="parent_name" placeholder="无上级分类" class="layui-input" readonly="readonly" value="<?php echo isset($info['parent_name'])?$info['parent_name']:''; ?>">
        <input type="hidden" name="parent_id" id="parent_id" value="<?php echo isset($info['parent_id'])?$info['parent_id']:''; ?>">
        <div class="layui-form-mid layui-word-aux">前端只显示到 3 级，3 级之后不显示，请不要添加超过 3 级</div>
    </div>
</div>-->
<script>
    layui.config({
        base: "/addons/yztc_sun/public/static/bower_components/layui/extend/"
    }).use(['form',"jquery","cascader"], function(){
        var $ = layui.jquery;
        var cascader = layui.cascader;

        $.post('<?php echo adminurl("get_list","Ccategory"); ?>',function (res) {
            if(typeof res == "string") {
                res = JSON.parse(res);
            }
            if (!res.code) {
                var data = res.data;
                var data_new = [];

                for(var i in data){
                    var item = data[i];
                    item['value'] = item['id'];
                    item['label'] = item['name'];
                    var isroot = true;
                    for(var j in data){
                        if (item['parent_id'] == data[j]['id']){
                            if (!data[j]['children']){
                                data[j]['children'] = [];
                            }
                            data[j]['children'].push(item);
                            isroot = false;
                        }
                    }
                    if (isroot){
                        data_new.push(item);
                    }
                }
                for(var i in data_new){
                    for(var j in data[i]['children']){
                        delete data[i]['children'][j]['children'];
                    }
                }

                cascader({
                    elem: "#parent_name",
                    data: data_new,
                    // url: "/aa",
                    // type: "post",
                    triggerType: "change",
                    showLastLevels: true,
                    parentchecked:true,
                    // where: {
                    //     a: "aaa"
                    // },
                    // value: ["B", "BB2", "BBB4"],
                    success: function (valData,labelData) {
                        var id = valData[valData.length-1];
                        $('#parent_id').val(id);
                    },
                });
            }
        })



    });
</script>
<div class="layui-form-item">
    <label class="layui-form-label">分类名称</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="name" lay-verify="required" placeholder="请输入名称" class="layui-input" value="<?php echo isset($info['name'])?$info['name']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">排序</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="index" placeholder="请输入排序" class="layui-input" value="<?php echo isset($info['index'])?$info['index']:''; ?>">
    </div>
</div>
<?php if(!$_SESSION['admin']['store_id']): ?>
<div class="layui-form-item">
    <label class="layui-form-label">图标</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('icon', isset($info['icon'])?$info['icon']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：170*170</div>
    </div>
</div>
<?php endif; ?>
<script>
    require(['select2'], function () {
        $('.select2').select2();
        $.get("<?php echo adminurl('select_root'); ?>", function (ret) {
            if (typeof ret == "string"){
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '无上级分类'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if(obj.id == "<?php echo isset($info['parent_id'])?$info['parent_id']:''; ?>"){
                    obj.selected = true;
                }
                return obj;
            });
            $('#parent_id').select2({
                data: ret,
            })
        })
    })
</script>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="">立即提交</button>
                    <button class="layui-btn layui-btn-primary" id="btnCancel">取消</button>
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
console.log(data);
var url = "<?php echo adminurl('save'); ?>";
$.post(url,data,function(res){
if (typeof res == 'string'){
res = $.parseJSON(res);
}
if (res.code == 0) {
var index=parent.layer.getFrameIndex(window.name);
parent.layer.close(index);
parent.layer.msg('保存成功',{icon: 6,anim: 6});
parent.location.reload();
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