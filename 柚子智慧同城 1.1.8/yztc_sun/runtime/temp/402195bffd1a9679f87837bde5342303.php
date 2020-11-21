<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:97:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/ccoustomize/editnav.html";i:1553823423;s:89:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit.html";i:1553823405;}*/ ?>
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
            
<input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''; ?>">
<input type="hidden" name="type" value="3">
<div class="layui-form-item">
    <label class="layui-form-label">图标名称</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="title" lay-verify="required" placeholder="请输入图标名称" class="layui-input" value="<?php echo isset($info['title'])?$info['title']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">跳转类型</label>
    <div class="layui-input-block" >
        <input type="radio" name="link_type" value="1" lay-filter="link_type" title="内链" <?php if($info['link_type']==1 || empty($info['link_type'])): ?>checked="checked"<?php endif; ?> >
        <!--<input type="radio" name="link_type" value="2"  lay-filter="link_type"  title="外部小程序" <?php if($info['link_type']==2): ?>checked="checked"<?php endif; ?>>-->
        <input type="radio" name="link_type" value="4"  lay-filter="link_type"  title="分类信息" <?php if($info['link_type']==4): ?>checked="checked"<?php endif; ?>>
        <input type="radio" name="link_type" value="3" lay-filter="link_type"  title="客服消息" <?php if($info['link_type']==3): ?>checked="checked"<?php endif; ?>>
        <input type="radio" name="link_type" value="5" lay-filter="link_type"  title="商家" <?php if($info['link_type']==5): ?>checked="checked"<?php endif; ?>>
    </div>
</div>
<!--<div id="type2">-->
    <!--<div class="layui-form-item">-->
        <!--<label class="layui-form-label">外部小程序APPID</label>-->
        <!--<div class="layui-input-block">-->
            <!--<input autocomplete="off" type="text" name="appid" placeholder="请输入跳转的小程序APPID" class="layui-input" value="<?php echo isset($info['appid'])?$info['appid']:''; ?>">-->
        <!--</div>-->
    <!--</div>-->
    <!--<div class="layui-form-item">-->
        <!--<label class="layui-form-label">外部小程序页面路径</label>-->
        <!--<div class="layui-input-block">-->
            <!--<input autocomplete="off" type="text" name="path"  placeholder="请输入跳转的小程序页面路径" class="layui-input" value="<?php echo isset($info['path'])?$info['path']:''; ?>">-->
        <!--</div>-->
    <!--</div>-->
<!--</div>-->
<div class="layui-form-item" id="type1">
    <label class="layui-form-label">链接</label>
    <div class="layui-input-block">
        <!--1.首页2.分类3.拼团4.购物车5.我的6.快速购买7.分销中心8.附近门店9.预约10.优惠券11.积分商城12.砍价13.视频专区14.多商户15.今日话题16.整点秒杀-->
        <select name="url" class="select2" >
            <?php if(is_array($linkurl) || $linkurl instanceof \think\Collection || $linkurl instanceof \think\Paginator): $i = 0; $__LIST__ = $linkurl;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['value']; ?>" <?php if($vo['value'] == $info['url']): ?> selected="selected" <?php endif; ?>><?php echo $vo['name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
</div>

<div class="layui-form-item" id="type4">
    <label class="layui-form-label">分类信息链接</label>
    <div class="layui-input-block">
        <select name="url1" class="select2" >
            <?php if(is_array($infourl) || $infourl instanceof \think\Collection || $infourl instanceof \think\Paginator): $i = 0; $__LIST__ = $infourl;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo1['value']; ?>" <?php if($vo1['value'] == $info['url']): ?> selected="selected" <?php endif; ?>><?php echo $vo1['name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
</div>

<div class="layui-form-item" id="type5">
    <label class="layui-form-label">商家链接</label>
    <div class="layui-input-block">
        <select name="url2" class="select2" >
            <?php if(is_array($storeurl) || $storeurl instanceof \think\Collection || $storeurl instanceof \think\Paginator): $i = 0; $__LIST__ = $storeurl;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo2['value']; ?>" <?php if($vo2['value'] == $info['url']): ?> selected="selected" <?php endif; ?>><?php echo $vo2['name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">选中前图片</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('clickago_icon', isset($info['clickago_icon'])?$info['clickago_icon']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：40*40</div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">选中后图片</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('clickafter_icon', isset($info['clickafter_icon'])?$info['clickafter_icon']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：40*40</div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">排序</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="number" name="sort" lay-verify="required" placeholder="数字越小排越前" class="layui-input" value="<?php echo isset($info['sort'])?$info['sort']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">启用状态</label>
    <div class="layui-input-block">
        <input type="radio" name="state" value="1" title="启用" <?php if($info['state']==1 || empty($info['state'])): ?>checked="checked"<?php endif; ?>>
        <input type="radio" name="state" value="0" title="禁用" <?php if($info['state']===0): ?>checked="checked"<?php endif; ?>>
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element','form'], function(){
        var element = layui.element;
        var form = layui.form;
        // console.log(form);
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
        });
        var jq = layui.jquery;
        jq(function(){
            var type=$('input[name="link_type"]:checked').val();
            if(type==1){
                $('#type1').show();
                $('#type2').hide();
                $('#type4').hide();
                $('#type5').hide();
            }else if(type==2) {
                $('#type2').show();
                $('#type1').hide();
                $('#type4').hide();
                $('#type5').hide();
            }else if(type==4){
                $('#type4').show();
                $('#type2').hide();
                $('#type1').hide();
                $('#type5').hide();
            }else if(type==5){
                $('#type5').show();
                $('#type2').hide();
                $('#type1').hide();
                $('#type4').hide();
            }else{
                $('#type2').hide();
                $('#type1').hide();
                $('#type4').hide();
                $('#type5').hide();

            }
        })
        form.on('radio(link_type)', function(data){
            // console.log(data.elem); //得到radio原始DOM对象
            console.log(data.value); //被点击的radio的value值
            var type=data.value;
            if(type==1){
                $('#type1').show();
                $('#type2').hide();
                $('#type4').hide();
                $('#type5').hide();
            }else if(type==2) {
                $('#type2').show();
                $('#type1').hide();
                $('#type4').hide();
                $('#type5').hide();
            }else if(type==4){
                $('#type4').show();
                $('#type2').hide();
                $('#type1').hide();
                $('#type5').hide();
            }else if(type==5){
                $('#type5').show();
                $('#type2').hide();
                $('#type1').hide();
                $('#type4').hide();
            }else{
                $('#type2').hide();
                $('#type1').hide();
                $('#type4').hide();
                $('#type5').hide();

            }
        });

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