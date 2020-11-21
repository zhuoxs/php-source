<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:91:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/cdingtalk/set.html";i:1553823422;s:90:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit2.html";i:1553823404;}*/ ?>
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
    <label class="layui-form-label">是否开启钉钉机器人</label>
    <div class="layui-input-block">
        <input type="radio" name="is_open" value="1" title="开启" <?php echo $info['is_open']==1?"checked":""; ?>>
        <input type="radio" name="is_open" value="0" title="关闭" <?php echo $info['is_open']==0?"checked":""; ?>>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">群机器人token</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="token"  placeholder="" class="layui-input" value="<?php echo isset($info['token'])?$info['token']:''; ?>">
        <div class="layui-form-mid layui-word-aux">* </div>
    </div>
</div>


<div class="layui-form-item ytx253">
    <label class="layui-form-label">新订单提醒</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="content"  placeholder="" class="layui-input" value="<?php echo isset($info['content'])?$info['content']:''; ?>">
        <div class="layui-form-mid layui-word-aux"> *输入内容:【XX商户】您有新的订单，请登录商家管理页面查看
            <br>模板内容：您有新的订单，请登录商家管理页面查看
            <br>为空不发送</div>
    </div>
</div>

<div class="layui-form-item ytx253">
    <label class="layui-form-label">退款订单提醒</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="contentrefund"  placeholder="" class="layui-input" value="<?php echo isset($info['contentrefund'])?$info['contentrefund']:''; ?>">
        <div class="layui-form-mid layui-word-aux">  *输入内容:【XX商户】您有退款订单待处理，请登录商家管理页面处理
            <br>模板内容：您有退款订单待处理，请登录商家管理页面处理
            <br>为空不发送</div>
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


    function setshow(){
        var  smstype= $('[name=smstype]:checked').val();
        if(smstype==1){
            $('.ytx253').show();
            $('.jhsj').hide();
            $('.aldy').hide();
        }else if(smstype==2){
            $('.ytx253').hide();
            $('.jhsj').show();
            $('.aldy').hide();

        }else if(smstype==3){
            $('.ytx253').hide();
            $('.aldy').show();
            $('.jhsj').hide();
        }
    }
    layui.use(['table','form'],function () {
        var table = layui.table;
        var form = layui.form;
        form.on('radio', function (data) {
            if ($(data.elem).is('[name=smstype]')) {
                setshow();
            }
        });
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
            var url = "<?php echo adminurl('save'); ?>";
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