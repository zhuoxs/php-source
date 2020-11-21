<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:95:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/cinfosettings/set.html";i:1559123170;s:93:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit_set.html";i:1553823403;}*/ ?>
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
    <label class="layui-form-label">发布是否需要审核</label>
    <div class="layui-input-block">
        <input type="radio" name="is_check" value="1" title="开启" <?php echo !empty($info['is_check'])?"checked" :""; ?>>
        <input type="radio" name="is_check" value="0" title="关闭" <?php echo !empty($info['is_check'])?"" : "checked"; ?>>
    </div>
    <div class="layui-form-mid layui-word-aux">*开启信息需要审核，关闭信息免审核 </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">发贴是否需要收费</label>
    <div class="layui-input-block">
        <input type="radio" name="posting_fee_switch" value="1" title="开启" <?php echo !empty($info['posting_fee_switch'])?"checked" :""; ?>>
        <input type="radio" name="posting_fee_switch" value="0" title="关闭" <?php echo !empty($info['posting_fee_switch'])?"" : "checked"; ?>>
    </div>
    <div class="layui-form-mid layui-word-aux">*开启信息需要审核，关闭信息免审核 </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">每条帖子收费金额</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="posting_fee"  placeholder="" class="layui-input" value="<?php echo isset($info['posting_fee'])?$info['posting_fee']:''; ?>">
        <div class="layui-form-mid layui-word-aux">*发布帖子每条收费金额(发帖收费开关开启有效) </div>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">评论是否需要审核</label>
    <div class="layui-input-block">
        <input type="radio" name="comment_check" value="1" title="开启" <?php echo !empty($info['comment_check'])?"checked" :""; ?>>
        <input type="radio" name="comment_check" value="0" title="关闭" <?php echo !empty($info['comment_check'])?"" : "checked"; ?>>
    </div>
    <div class="layui-form-mid layui-word-aux">*开启评论需要审核，关闭信息免审核 </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">全国版</label>
    <div class="layui-input-block">
        <input type="radio" name="national_status" value="1" title="开启" <?php echo !empty($info['national_status'])?"checked" :""; ?>>
        <input type="radio" name="national_status" value="0" title="关闭" <?php echo !empty($info['national_status'])?"" : "checked"; ?>>
    </div>
    <div class="layui-form-mid layui-word-aux">*开启后显示全部地区帖子,关闭则显示对应区域帖子</div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">发帖地址</label>
    <div class="layui-input-block">
        <input type="radio" name="post_address" value="1" title="开启" <?php echo !empty($info['post_address'])?"checked" :""; ?>>
        <input type="radio" name="post_address" value="0" title="关闭" <?php echo !empty($info['post_address'])?"" : "checked"; ?>>
    </div>
    <div class="layui-form-mid layui-word-aux">*关闭后发帖不用选择地址和帖子列表不会显示地址 </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">帖子附近</label>
    <div class="layui-input-block">
        <input type="radio" name="post_nearby" value="1" title="显示" <?php echo !empty($info['post_nearby'])?"checked" :""; ?>>
        <input type="radio" name="post_nearby" value="0" title="隐藏" <?php echo !empty($info['post_nearby'])?"" : "checked"; ?>>
    </div>
    <div class="layui-form-mid layui-word-aux">*信息列表页显示附近帖子排序 </div>

</div>

<div class="layui-form-item">
    <label class="layui-form-label">虚拟浏览数</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="number" name="post_browse"  placeholder="" class="layui-input" value="<?php echo isset($info['post_browse'])?$info['post_browse']:''; ?>">
        <div class="layui-form-mid layui-word-aux">*首页显示虚拟浏览数+实际浏览数 </div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">发帖限制</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="number" name="post_num"  placeholder="" class="layui-input" value="<?php echo isset($info['post_num'])?$info['post_num']:''; ?>">
        <div class="layui-form-mid layui-word-aux">*用户每天发帖上限,0或者不填为没有上限</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">帖子过滤</label>
    <div class="layui-input-block">
        <textarea name="word_filtering" placeholder="请输入过滤词语" class="layui-textarea"><?php echo isset($info['word_filtering'])?$info['word_filtering']:''; ?></textarea>
        <div class="layui-form-mid layui-word-aux">例子：多个词语用英文逗号<span class="layui-badge layui-bg-black">,</span> 分隔,设置后帖子内容显示过滤后内容 </div>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">免责声明</label>
    <div class="layui-input-block">
        <?php echo tpl_ueditor('disclaimer', $info['disclaimer']); ?>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">发布须知</label>
    <div class="layui-input-block">
        <?php echo tpl_ueditor('release_notice', $info['release_notice']); ?>
    </div>
</div>









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