<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:88:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/cinfo/edit.html";i:1553823410;s:89:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit.html";i:1553823405;}*/ ?>
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
    <label class="layui-form-label">分类</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" lay-verify="required" readonly="readonly"  class="layui-input" value="<?php echo isset($info['cat_name'])?$info['cat_name']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">联系人</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" lay-verify="required" readonly="readonly"  class="layui-input" value="<?php echo isset($info['name'])?$info['name']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">联系电话</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" lay-verify="required" readonly="readonly"  class="layui-input" value="<?php echo isset($info['phone'])?$info['phone']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">地址</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" lay-verify="required" readonly="readonly"  class="layui-input" value="<?php echo isset($info['address'])?$info['address']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <textarea  placeholder="内容" name="content" class="layui-textarea"><?php echo isset($info['content'])?$info['content']:''; ?></textarea>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">图片</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_multi_image('pic', isset($info['pic'])?$info['pic']:''); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：750*500</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">审核状态</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" readonly="readonly"  class="layui-input" value="<?php echo isset($info['check_status_z'])?$info['check_status_z']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">审核失败原因</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" readonly="readonly"  class="layui-input" value="<?php echo isset($info['fail_reason'])?$info['fail_reason']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">审核时间</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" readonly="readonly"  class="layui-input" value="<?php echo isset($info['check_time_d'])?$info['check_time_d']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">置顶申请状态</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text"  readonly="readonly"  class="layui-input" value="<?php echo isset($info['top_status_z'])?$info['top_status_z']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">置顶支付状态</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" readonly="readonly"  class="layui-input" value="<?php echo isset($info['pay_status_z'])?$info['pay_status_z']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">置顶时间</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text"  readonly="readonly"  class="layui-input" value="<?php echo isset($info['topping_time_z'])?$info['topping_time_z']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">创建时间</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" readonly="readonly"  class="layui-input" value="<?php echo isset($info['create_time'])?$info['create_time']:''; ?>">
    </div>
</div>



<script>
    layui.use('laydate',function () {
        var laydate = layui.laydate;
        laydate.render({
            elem: '#end_time'
            ,type: 'datetime'
            ,format: 'yyyy-MM-dd HH:mm:ss'
        });
    })
    require(['select2'], function () {
        $('.select2').select2();

        //广告类型
        var ret = [
            {id:1,text:'首页轮播图'},
            {id:2,text:'首页中部广告'},
        ];
        ret.unshift({id: '', text: '请选择类型'});
        ret.map(function (obj) {
            obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
            if(obj.id == "<?php echo isset($info['type'])?$info['type']:''; ?>"){
                obj.selected = true;
            }
            return obj;
        });
        $('#type').select2({
            data: ret,
        })
        //商圈
        $.get("<?php echo adminurl('selectrules','Cstoredistrict'); ?>", function (ret) {
            if (typeof ret == "string") {
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择商圈'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if (obj.id == "<?php echo isset($info['district_id'])?$info['district_id']:''; ?>") {
                    obj.selected = true;
                }
                return obj;
            });
            $('#district_id').select2({
                data: ret,
            })
        })
        //分类
        $.get("<?php echo adminurl('selectrules','Cstorecategory'); ?>", function (ret) {
            if (typeof ret == "string") {
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择分类'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if (obj.id == "<?php echo isset($info['cat_id'])?$info['cat_id']:''; ?>") {
                    obj.selected = true;
                }
                return obj;
            });
            $('#cat_id').select2({
                data: ret,
            })
        })


        layui.use('laydate',function () {
            var laydate = layui.laydate;
            laydate.render({
                elem: '#business_range'
                ,type: 'time'
                ,range: true
            });
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
                    parent.layui.table.reload('laytable',{});
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