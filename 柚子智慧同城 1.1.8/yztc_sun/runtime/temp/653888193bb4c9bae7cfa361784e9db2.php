<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:94:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/csystem/smallapp.html";i:1553823374;s:90:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit2.html";i:1553823404;}*/ ?>
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
    <label class="layui-form-label">小程序appid</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="appid" lay-verify="required" placeholder="请输入小程序appid" class="layui-input" value="<?php echo isset($info['appid'])?$info['appid']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">小程序appsecret</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="appsecret" lay-verify="required" placeholder="请输入appsecret" class="layui-input" value="<?php echo isset($info['appsecret'])?$info['appsecret']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">商户号</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="mchid" lay-verify="required" placeholder="请输入mchid" class="layui-input" value="<?php echo isset($info['mchid'])?$info['mchid']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">商户号密钥</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="wxkey" lay-verify="required" placeholder="请输入wxkey" class="layui-input" value="<?php echo isset($info['wxkey'])?$info['wxkey']:''; ?>">
        <div class="layui-form-mid layui-word-aux">*请输入微信支付商户后台32位API密钥</div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">apiclient_cert.pem</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn layui-btn-normal" id="apiclient_cert_btn"><i class="layui-icon"></i><span><?php echo !empty($info['apiclient_cert'])?"重新上传":'上传文件';; ?></span></button>
        <input type="hidden" name="apiclient_cert" value="<?php echo isset($info['apiclient_cert'])?$info['apiclient_cert']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">apiclient_key.pem</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn layui-btn-normal" id="apiclient_key_btn"><i class="layui-icon"></i><span><?php echo !empty($info['apiclient_key'])?"重新上传":'上传文件';; ?></span></button>
        <input type="hidden" name="apiclient_key" value="<?php echo isset($info['apiclient_key'])?$info['apiclient_key']:''; ?>">
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">过审开关</label>
    <div class="layui-input-block">
        <input type="radio" name="showcheck" value="1" title="开启" <?php  if($info['showcheck']==1) echo "checked"; ?>>
        <input type="radio" name="showcheck" value="0" title="关闭" <?php  if($info['showcheck']==0) echo "checked"; ?>>
    </div>
    <div class="layui-form-mid layui-word-aux">*提交小程序前端微信审核的时候打开</div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">过审小程序版本号</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="version" lay-verify="required" placeholder="请输入版本号" class="layui-input" value="<?php echo isset($info['version'])?$info['version']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">首页菜单显示</label>
    <div class="layui-input-block">
        <input type="radio" name="show_type" value="1" title="功能" <?php  if($info['show_type']==1) echo "checked"; ?>>
        <input type="radio" name="show_type" value="2" title="圈子" <?php  if($info['show_type']==2) echo "checked"; ?>>
        <input type="radio" name="show_type" value="3" title="商家" <?php  if($info['show_type']==3) echo "checked"; ?>>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">首页天气图标</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('weather_icon', isset($info['weather_icon'])?$info['weather_icon']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：40*40</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">我的页面顶部背景图</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('mine_bg', isset($info['mine_bg'])?$info['mine_bg']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：750 * 410</div>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">腾讯地图key</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="map_key" placeholder="请输入地图key" class="layui-input" value="<?php echo isset($info['map_key'])?$info['map_key']:''; ?>">
        <div class="layui-form-mid layui-word-aux">申请地址：<a href=" ">https://lbs.qq.com/console/key.html</a></div>
        <div style="clear: both;color: #FF5722;">
            <p>1、申请开发者密钥</p>
            <p>2、启用产品，选择WebServiceAPI</p>
            <p>3、设置安全域名，在"微信公众平台|小程序"->"设置"->"开发设置"->"服务器域名"中设置request合法域名添加https://apis.map.qq.com</p>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">百度开放平台key(获取当前天气使用)</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="ak" placeholder="请输入key" class="layui-input" value="<?php echo isset($info['ak'])?$info['ak']:''; ?>">
        <div class="layui-form-mid layui-word-aux">申请地址：<a href=" ">http://lbsyun.baidu.com/</a></div>
        <div style="clear: both;color: #FF5722;">
            <p>1、申请成为开发者</p>
            <p>2、创建应用，选择微信小程序(请填写对应小程序appid否则不生效)</p>
            <p>3、设置安全域名，在"微信公众平台|小程序"->"设置"->"开发设置"->"服务器域名"中设置request合法域名添加https://api.map.baidu.com</p>
        </div>
    </div>
</div>


<script>
    layui.use('upload', function() {
        var upload = layui.upload;
        //指定允许上传的文件类型
        upload.render({
            elem: '#apiclient_cert_btn'
            ,url: '<?php echo adminurl("upload"); ?>'
            ,accept: 'file' //普通文件
            ,done: function(res){
                if (typeof res == "string"){
                    res = JSON.parse($res);
                }
                layer.msg('上传成功',{icon: 6,anim: 6});
                $('input[name=apiclient_cert]').val(res.data.src);
                $('#apiclient_cert_btn span').html('重新上传');
            }
        });
        upload.render({
            elem: '#apiclient_key_btn'
            ,url: '<?php echo adminurl("upload"); ?>'
            ,accept: 'file' //普通文件
            ,done: function(res){
                if (typeof res == "string"){
                    res = JSON.parse($res);
                }
                layer.msg('上传成功',{icon: 6,anim: 6});
                $('input[name=apiclient_key]').val(res.data.src);
                $('#apiclient_key_btn span').html('重新上传');
            }
        });
    });
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