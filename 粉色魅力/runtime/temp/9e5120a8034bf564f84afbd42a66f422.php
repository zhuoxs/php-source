<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:63:"/www/wwwroot/testxt.com/application/admin/view/index/index.html";i:1545658158;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/head.html";i:1522628860;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?> - 苹果CMS</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/admin_style.css">
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/layui/layui.js"></script>
    <script>
        var ROOT_PATH="",ADMIN_PATH="<?php echo $_SERVER['SCRIPT_NAME']; ?>", MAC_VERSION='v10';
    </script>
</head>
<body>

<style type="text/css">
    .hs-iframe{width:100%;height:100%;}
    .layui-tab{position:absolute;left:0;top:0;height:100%;width:100%;z-index:10;margin:0;border:none;overflow:hidden;}
    .layui-tab-title li:first-child > i {
        display: none;
    }
    .layui-tab-content{padding:0 0 0 10px;height:100%;}
    .layui-tab-item{height:100%;}
    .layui-nav-tree .layui-nav-child a{height:38px;line-height: 38px;}
    .footer{position:fixed;left:0;bottom:0;z-index:998;}
</style>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="fl header-logo">苹果CMS控制台</div>
        <div class="fl header-fold"><a href="javascript:;" title="打开/关闭左侧导航" class="aicon ai-caidan" id="foldSwitch"><i class="layui-icon">&#xe65f;</i></a></div>
        <ul class="layui-nav fl nobg main-nav">
            <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(($i == 1)): ?>
            <li class="layui-nav-item layui-this">
                <?php else: ?>
            <li class="layui-nav-item">
                <?php endif; ?>
                <a href="javascript:;"><?php echo $vo['name']; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <ul class="layui-nav fr nobg head-info" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:void(0);"><?php echo \think\Cookie::get('admin_name'); ?>&nbsp;&nbsp;</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:void(0);" id="lockScreen">锁屏</a></dd>
                    <dd><a href="<?php echo url('index/logout'); ?>">退出登陆</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="http://www.maccms.com/" target="_blank">官网</a></li>
            <li class="layui-nav-item"><a href="http://bbs.maccms.com/" target="_blank">论坛</a></li>

            <li class="layui-nav-item"><a href="/" target="_blank">前台</a></li>
            <li class="layui-nav-item"><a href="<?php echo url('index/clear'); ?>" class="j-ajax" refresh="yes">清缓存</a></li>

        </ul>
    </div>
    <div class="layui-side layui-bg-black" id="switchNav">
        <div class="layui-side-scroll">
            <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if(($i == 1)): ?>
            <ul class="layui-nav layui-nav-tree">
                <?php else: ?>
                <ul class="layui-nav layui-nav-tree" style="display:none;">
                    <?php endif; ?>
                    <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;"><i class="<?php echo $v['icon']; ?>"></i><?php echo $v['name']; ?><span class="layui-nav-more"></span></a>

                    <dl class="layui-nav-child">
                        <?php if(is_array($v['sub']) || $v['sub'] instanceof \think\Collection || $v['sub'] instanceof \think\Paginator): $kk = 0; $__LIST__ = $v['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($kk % 2 );++$kk;?>
                        <dd><a class="admin-nav-item" data-id="<?php echo $key; ?><?php echo $kk; ?>" href="<?php echo $vv['url']; ?>"><i class="<?php echo $vv['icon']; ?>"></i> <?php echo $vv['name']; ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                    </li>
                </ul>
                <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="layui-body" id="switchBody">
        <div class="layui-tab layui-tab-card" lay-filter="macTab" lay-allowClose="true">
            <ul class="layui-tab-title">
                <li lay-id="111" class="layui-this">欢迎页面</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe lay-id="111" src="<?php echo url('index/welcome'); ?>" width="100%" height="100%" frameborder="0" scrolling="yes" class="hs-iframe"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-footer footer">
        <div class="fl"></div>
        <div class="fr"> © 2008-2019 <a href="http://www.maccms.com/" target="_blank">MacCMS.COM.</a> All Rights Reserved.</div>
    </div>
</div>

<script type="text/javascript" src="/static/js/admin_common.js"></script>
<!--请在下方写此页面业务相关的脚本-->
<script>
    window.localStorage.clear();
    var LAYUI_OFFSET = 60;
</script>

<script type="text/javascript">
    layui.use(['element', 'layer'], function() {
        var $ = layui.jquery, element = layui.element, layer = layui.layer;
        $('.layui-tab-content').height($(window).height() - 145);
        var tab = {
            add: function(title, url, id) {
                element.tabAdd('macTab', {
                        title: title,
                        content: '<iframe width="100%" height="100%" lay-id="'+id+'" frameborder="0" src="'+url+'" scrolling="yes" class="x-iframe"></iframe>',
                        id: id
            });
            }, change: function(id) {
                element.tabChange('macTab', id);
            }
        };
        $('.admin-nav-item').click(function(event) {
            var that = $(this);
            var id = that.attr('data-id');
            if ($('iframe[lay-id="'+id+'"]')[0]) {
                tab.change(id);
                event.stopPropagation();
                $("iframe[lay-id='"+id+"']")[0].contentWindow.location.reload(true);//切换后刷新框架
                return false;
            }
            if ($('iframe').length == 10) {
                layer.msg('最多可打开10个标签页');
                return false;
            }
            that.css({color:'#fff'});
            tab.add(that.text(), that.attr('href'), that.attr('data-id'));
            tab.change(that.attr('data-id'));
            event.stopPropagation();
            return false;
        });
        $(document).on('click', '.layui-tab-close', function() {
            $('.layui-nav-child a[data-id="'+$(this).parent('li').attr('lay-id')+'"]').css({color:'rgba(255,255,255,.7)'});
        });
    });
</script>

</body>
</html>