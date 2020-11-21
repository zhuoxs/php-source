<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:95:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/ccoupon/addcoupon.html";i:1553823425;s:94:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/editnosub.html";i:1553823404;}*/ ?>
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
        

<form class="layui-form" method="post" action="<?php echo adminurl('save'); ?>&modelName=Coupon">
    <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''; ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">所属商家</label>
        <div class="layui-input-block">
            <select name="store_id" id="store_id" class="select2" lay-verify="required" lay-ignore></select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">优惠券名称</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="name" lay-verify="required" placeholder="请输入优惠券名称" class="layui-input" value="<?php echo isset($info['name'])?$info['name']:''; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">封面图</label>
        <div class="layui-input-block">
            <?php echo tpl_form_field_image('pic', isset($info['pic'])?$info['pic']:'','/web/resource/images/nopic.jpg'); ?>
            <div class="layui-form-mid layui-word-aux">建议尺寸：250*180</div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">活动推荐图</label>
        <div class="layui-input-block">
            <?php echo tpl_form_field_image('indexpic', isset($info['indexpic'])?$info['indexpic']:'','/web/resource/images/nopic.jpg'); ?>
            <div class="layui-form-mid layui-word-aux">建议尺寸：710*400</div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">满多少可用</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="full" placeholder="0为无门槛" class="layui-input" value="<?php echo isset($info['full'])?$info['full']:''; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">库存</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" name="num"  min="0" class="layui-input" value="<?php echo isset($info['num'])?$info['num']:''; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">每人限领</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" name="limit_num" placeholder="0为不限量" min="0" class="layui-input" value="<?php echo isset($info['limit_num'])?$info['limit_num']:''; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">领取方式</label>
        <div class="layui-input-block">
            <input type="radio" name="gettype" value="1" title="付费领取" <?php echo $info['gettype']==1?"checked":""; ?>>
            <input type="radio" name="gettype" value="2" title="转发领取" <?php echo $info['gettype']==2?"checked":""; ?>>
            <input type="radio" name="gettype" value="3" title="免费领取" <?php echo $info['gettype']==3?"checked":""; ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">付费领取金额</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="getmoney" placeholder="领取方式为付费领取时填写" class="layui-input" value="<?php echo isset($info['getmoney'])?$info['getmoney']:''; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">仅限会员领取使用</label>
        <div class="layui-input-block">
            <input type="radio" name="only_vip" value="1" title="开启" <?php echo $info['only_vip']==1?"checked":""; ?>>
            <input type="radio" name="only_vip" value="0" title="关闭" <?php echo $info['only_vip']==0?"checked":""; ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开始使用时间</label>
        <div class="layui-input-block">
            <input type="text" name="use_starttime" id="use_starttime" value="<?php echo $info['use_starttime']; ?>"  placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">到期时间</label>
        <div class="layui-input-block">
            <input type="text" name="end_time" id="end_time" value="<?php echo $info['end_time']; ?>"  placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">虚拟关注数</label>
            <div class="layui-input-block">
                <input autocomplete="off" type="number" min="0" name="read_num_virtual" class="layui-input" value="<?php echo isset($info['read_num_virtual'])?$info['read_num_virtual']:''; ?>">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">虚拟领取数</label>
            <div class="layui-input-block">
                <input autocomplete="off" type="number" min="0" name="sales_num_virtua" class="layui-input" value="<?php echo isset($info['sales_num_virtua'])?$info['sales_num_virtua']:''; ?>">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">使用说明</label>
        <div class="layui-input-block">
            <?php echo tpl_ueditor('instructions', $info['instructions']); ?>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="">立即提交</button>
            <button class="layui-btn layui-btn-primary" id="btnCancel">取消</button>
        </div>
    </div>
</form>

<script>
    //JavaScript代码区域
    layui.use(['element','form','laydate'], function(){
        var element = layui.element;
        var form = layui.form;
        var laydate = layui.laydate;
        laydate.render({
            elem: '#end_time'
            , type: 'datetime'
            , format: 'yyyy-MM-dd HH:mm:ss'
        });
        laydate.render({
            elem: '#use_starttime'
            , type: 'datetime'
            , format: 'yyyy-MM-dd HH:mm:ss'
        });

        // 新增界面、保存、取消事件
        form.on('submit', function(data){
            if(!$(data.elem).is('button')){
                return false;
            }
            var data = data.field;
            console.log(data);
            var url = "<?php echo adminurl('save'); ?>&modelName=Coupon";
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
<script>
    require(['select2'], function () {
        $('.select2').select2();
        $.get("<?php echo adminurl('selectrules','Cstore'); ?>", function (ret) {
            if (typeof ret == "string"){
                ret = JSON.parse(ret);
            }
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if(obj.id == "<?php echo isset($info['id'])?$info['id']:''; ?>"){
                    obj.selected = true;
                }
                return obj;
            });
            $('#store_id').select2({
                data: ret,
            })
        })
    })
</script>

    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element','form'], function(){
        var element = layui.element;
        var form = layui.form;


    })
</script>
</body>
</html>