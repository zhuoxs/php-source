<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:57:"/www/wwwroot/msvodx/houtai/app/admin/view/index/index.php";i:1555470614;s:52:"/www/wwwroot/msvodx/houtai/app/admin/view/layout.php";i:1527499864;s:58:"/www/wwwroot/msvodx/houtai/app/admin/view/block/header.php";i:1542788814;s:58:"/www/wwwroot/msvodx/houtai/app/admin/view/block/footer.php";i:1556030858;}*/ ?>
<?php if(input('param.hisi_iframe') || cookie('hisi_iframe') || $tab_type==='no_menu'): ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_admin_menu_current['title']; ?> -  Powered by Msvodx版</title>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css">
    <link rel="stylesheet" href="__ADMIN_CSS__/style.css">
    <link rel="stylesheet" href="__STATIC__/fonts/typicons/min.css">
    <link rel="stylesheet" href="__STATIC__/fonts/font-awesome/min.css">
    <script src="__ADMIN_JS__/layui/layui.js"></script>
    <script>
        var ADMIN_PATH = "<?php echo $_SERVER['SCRIPT_NAME']; ?>", LAYUI_OFFSET = 0;
        layui.config({
            base: '__ADMIN_JS__/',
            version: '<?php echo config("hisiphp.version"); ?>'
        }).use('global');
    </script>
</head>
<body>
<div style="padding:0 10px;" class="mcolor"><?php echo runhook('system_admin_tips'); ?></div>
<?php else: ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php if($_admin_menu_current['url'] == 'admin/index/index'): ?>管理控制台<?php else: ?><?php echo $_admin_menu_current['title']; endif; ?> -   Powered by Msvodx版</title>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css">
    <link rel="stylesheet" href="__ADMIN_CSS__/style.css">
    <link rel="stylesheet" href="__STATIC__/fonts/typicons/min.css">
    <link rel="stylesheet" href="__STATIC__/fonts/font-awesome/min.css">
    <script src="__ADMIN_JS__/layui/layui.js"></script>
    <script>
        var ADMIN_PATH = "<?php echo $_SERVER['SCRIPT_NAME']; ?>", LAYUI_OFFSET = 60;
        layui.config({
            base: '__ADMIN_JS__/',
            version: '<?php echo config("hisiphp.version"); ?>'
        }).use('global');
    </script>
</head>
<body>
<?php 
$ca = strtolower(request()->controller().'/'.request()->action());
 ?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header" style="z-index:999!important;">
        <div class="fl header-logo">管理控制台</div>
        <div class="fl header-fold"><a href="javascript:;" title="打开/关闭左侧导航" class="aicon ai-caidan" id="foldSwitch"></a></div>
        <ul class="layui-nav fl nobg main-nav">
            <?php if(is_array($_admin_menu) || $_admin_menu instanceof \think\Collection || $_admin_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $_admin_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(($_admin_menu_parents['pid'] == $vo['id'] and $ca != 'plugins/run') or ($ca == 'plugins/run' and $vo['id'] == 3)): ?>
               <li class="layui-nav-item layui-this">
                <?php else: ?>
                <li class="layui-nav-item">
                <?php endif; ?>
                <a href="javascript:;"><?php echo $vo['title']; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <ul class="layui-nav fr nobg head-info">
            <li class="layui-nav-item">
                <a href="javascript:void(0);"><?php echo $admin_user['version']; ?>&nbsp;&nbsp;</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo url('admin/user/info'); ?>">个人设置</a></dd>
                    <dd><a href="<?php echo url('admin/user/iframe?val=1'); ?>" class="j-ajax" refresh="1">框架布局</a></dd>
                    <dd><a href="<?php echo url('admin/publics/logout'); ?>">退出登陆</a></dd>
                </dl>
            </li>
            <!--<li class="layui-nav-item">
                <a href="javascript:void(0);"><?php echo $languages[cookie('admin_language')]['name']; ?>&nbsp;&nbsp;</a>
                <dl class="layui-nav-child">
                    <?php if(is_array($languages) || $languages instanceof \think\Collection || $languages instanceof \think\Paginator): $i = 0; $__LIST__ = $languages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['pack']): ?>
                        <dd><a href="<?php echo url('admin/index/index'); ?>?lang=<?php echo $vo['code']; ?>"><?php echo $vo['name']; ?></a></dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    <dd><a href="<?php echo url('admin/language/index'); ?>">语言包管理</a></dd>
                </dl>
            </li>-->
            <li class="layui-nav-item"><a href="<?php echo url('admin/index/clear'); ?>" class="j-ajax">清缓存</a></li>
            <li class="layui-nav-item"><a href="javascript:void(0);" id="lockScreen">锁屏</a></li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black" id="switchNav">
        <div class="layui-side-scroll">
            <?php if(is_array($_admin_menu) || $_admin_menu instanceof \think\Collection || $_admin_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $_admin_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if(($_admin_menu_parents['pid'] == $v['id'] and $ca != 'plugins/run') or ($ca == 'plugins/run' and $v['id'] == 3)): ?>
            <ul class="layui-nav layui-nav-tree">
            <?php else: ?>
            <ul class="layui-nav layui-nav-tree" style="display:none;">
            <?php endif; if(is_array($v['childs']) || $v['childs'] instanceof \think\Collection || $v['childs'] instanceof \think\Paginator): $kk = 0; $__LIST__ = $v['childs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($kk % 2 );++$kk;?>
                <li class="layui-nav-item <?php if($kk == 1): ?>layui-nav-itemed<?php endif; ?>">
                    <a href="javascript:;"><i class="<?php echo $vv['icon']; ?>"></i><?php echo $vv['title']; ?><span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        <?php if($vv['title'] == '快捷菜单'): ?>
                            <dd><a class="admin-nav-item" href="<?php echo url('admin/index/index'); ?>">后台首页</a></dd>
                            <?php if(is_array($vv['childs']) || $vv['childs'] instanceof \think\Collection || $vv['childs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vv['childs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?>
                            <dd><a class="admin-nav-item" href="<?php echo url($vvv['url'].'?'.$vvv['param']); ?>"><?php echo $vvv['title']; ?></a><i data-href="<?php echo url('menu/del?ids='.$vvv['id']); ?>" class="layui-icon j-del-menu">&#xe640;</i></dd>
                            <?php endforeach; endif; else: echo "" ;endif; else: if(is_array($vv['childs']) || $vv['childs'] instanceof \think\Collection || $vv['childs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vv['childs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?>
                            <dd><a class="admin-nav-item" href="<?php if(strpos('http', $vvv['url']) === false): ?><?php echo url($vvv['url'].'?'.$vvv['param']); else: ?><?php echo $vvv['url']; endif; ?>"> <?php echo $vvv['title']; ?></a></dd>
                            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </dl>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="layui-body" id="switchBody">
        <ul class="bread-crumbs">
            <?php if(is_array($_bread_crumbs) || $_bread_crumbs instanceof \think\Collection || $_bread_crumbs instanceof \think\Paginator): $i = 0; $__LIST__ = $_bread_crumbs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($key > 0 && $i != count($_bread_crumbs)): ?>
                    <li>></li>
                    <li><a href="<?php echo url($v['url'].'?'.$v['param']); ?>"><?php echo $v['title']; ?></a></li>
                <?php elseif($i == count($_bread_crumbs)): ?>
                    <li>></li>
                    <li><a href="javascript:void(0);"><?php echo $v['title']; ?></a></li>
                <?php else: ?>
                    <li><a href="javascript:void(0);"><?php echo $v['title']; ?></a></li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            <!--<li><a href="<?php echo url('admin/menu/quick?id='.$_admin_menu_current['id']); ?>" title="添加到首页快捷菜单" class="j-ajax">[+]</a></li>-->
        </ul>
        <div style="padding:0 10px;" class="mcolor"><?php echo runhook('system_admin_tips'); ?></div>
        <div class="page-body">
<?php endif; switch($tab_type): case "1": ?>
    
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <?php if(is_array($tab_data['menu']) || $tab_data['menu'] instanceof \think\Collection || $tab_data['menu'] instanceof \think\Paginator): $i = 0; $__LIST__ = $tab_data['menu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['url'] == $_admin_menu_current['url'] or (url($vo['url']) == $tab_data['current'])): ?>
                    <li class="layui-this">
                    <?php else: ?>
                    <li>
                    <?php endif; if(substr($vo['url'], 0, 4) == 'http'): ?>
                        <a href="<?php echo $vo['url']; ?>" target="_blank"><?php echo $vo['title']; ?></a>
                    <?php else: ?>
                        <a href="<?php echo url($vo['url']); ?>"><?php echo $vo['title']; ?></a>
                    <?php endif; ?>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="tool-btns">
                    <a href="javascript:location.reload();" title="刷新当前页面" class="aicon ai-shuaxin2 font18"></a>
                    <a href="javascript:;" class="aicon ai-quanping1 font18" id="fullscreen-btn" title="打开/关闭全屏"></a>
                </div>
            </ul>
            <div class="layui-tab-content page-tab-content">
                <div class="layui-tab-item layui-show">
                    ﻿<div style="display:block;width:100%;overflow:hidden;">
    <?php echo runhook('system_admin_index'); ?>
</div>

<style>
    .panel {
        float: left;
        text-align: center;
        padding: 0;
        min-width: 152px;
        max-width: 152px;
        margin-bottom: 30px;
        background-color: #f2f2f2;
        margin: 10px 5px;
        border-radius: 10px;
        margin-right:30px;
    }

    .panel_icon {
        width: 40%;
        display: inline-block;
        padding: 22px 0;
        float: left;
        color:#fff;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .panel_word {
        width: 60%;
        display: inline-block;
        float: right;
        margin-top: 22px;
        
        text-align: center;
    }

    .panel_word h3{
        font-size:26px;
        display: inline-block;
        color:#333;
    }
    .panel_word p{
        color:#333;
        margin-top:5px;
    }
    .panel_word p a{
        color:#ff5722;
    }
    .col-md6{
        width:45%;
        main-width:400px;
        float: left;
        height: 300px;
        border:1px solid #c1c1c1;margin-top:50px;
        margin-left: 10px;
        padding-top:10px;
    }
</style>

<div class="layui-row layui-col-space10">
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FF5722">
            <p><i class="fa fa-film" style="font-size:30px;"></i><br/></p><p>视频</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/video/lists"><?php echo $data['videocount']; ?></a></h3>/部
            <p><a title="去审核" href="/admin/video/videocheck"><?php echo $data['videoshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #54ade8;">
            <p><i class="fa fa-file-image-o" style="font-size:30px;"></i></p><p>图册</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/image/lists"><?php echo $data['atlascount']; ?></a></h3>/个
            <p><a title="去审核" href="/admin/image/imgcheck"><?php echo $data['atlasshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FFB800">
            <p><i class="fa fa-file-text" style="font-size:30px;"></i><br/></p><p>资讯</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/novel/lists"><?php echo $data['novelcount']; ?></a></h3>/条
            <p><a title="去审核" href="/admin/novel/novelcheck"><?php echo $data['novelshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #5FB878;">
            <p><i class="fa fa-users" style="font-size:30px;"></i></p><p>会员</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/member/index"><?php echo $data['membercount']; ?></a></h3>/个
		   <br/>
           <p><a title="去查看" href="/admin/member/index">禁用/<?php echo $data['membershenhe']; ?>/个</a></p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #F8113C;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>支付</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/recharge/index"><?php echo $data['ordershenhey']; ?></a></h3>/笔成功<br/>
           <p><a title="去审核" href="/admin/recharge/index"><?php echo $data['ordershenhe']; ?>/</a>笔失败</p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #074AF6;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>评论</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/comment/index"><?php echo $data['commentcount']; ?></a></h3>/条<br/>
           <p><a title="去审核" href="/admin/comment/index"><?php echo $data['commentshenhe']; ?>/条待核</a></p>
        </div>
    </div>
</div>
<!-- 新增会员走势 start -->
<div id="container" class="col-md6"></div>
<div id="viewVideoMonthCharts" class="col-md6"></div>
<div id="viewAtlasMonthCharts" class="col-md6"></div>
<div id="viewNovelMonthCharts" class="col-md6"></div>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-gl/echarts-gl.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/simplex.js"></script>

<?php if(isset($data['memberMonthList'])): ?>
<script type="text/javascript">
    function createMemberCharts(){
        var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月新增会员走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['memberMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['memberMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createMemberCharts,100);
</script>
<?php endif; if(isset($data['viewVideoMonthList'])): ?>
<script type="text/javascript">
    function createViewVideoCharts(){
    var dom = document.getElementById("viewVideoMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月视频消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewVideoMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewVideoMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewVideoCharts,1000);
</script>
<?php endif; if(isset($data['viewAtlasMonthList'])): ?>
<script type="text/javascript">
    function createViewAtlasCharts(){
    var dom = document.getElementById("viewAtlasMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月图册消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewAtlasMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewAtlasMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewAtlasCharts,1500);
</script>
<?php endif; if(isset($data['viewNovelMonthList'])): ?>
<script type="text/javascript">
    function createViewNovelCharts(){
    var dom = document.getElementById("viewNovelMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月资讯消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewNovelMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewNovelMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewNovelCharts,2000);
</script>
<?php endif; ?>

<!-- Powered by Msvodx版系统信息 start -->
<!--<a href="/1.xls">test Download</a>-->
<div class="fr" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th colspan="2">产品信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>产品名称</td>
            <td>MsvodX</td>
        </tr>
        <tr>
            <td>官方网站</td>
            <td><a target="_blank" rel="noreferrer">MSVOD魅思CMS</a></td>
        </tr>
        <tr>
            <td>联系QQ</td>
            <td><a href="http://wpa.qq.com/msgrd?v=3&uin=1919134557&site=qq&menu=yes" target="_blank" rel="noreferrer">1919134557</a></td>
        </tr>
        <tr>
            <td>联系邮箱</td>
            <td>ym@ymyuanma.com</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="fl" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
            <tr>
                <th colspan="2">系统信息</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <td>系统版本</td>
                <td>开源版</td>
            </tr>
            <tr>
                <td>服务器环境</td>
                <td><?php echo PHP_OS; ?> / <?php echo $_SERVER["SERVER_SOFTWARE"]; ?></td>
            </tr>
            <tr>
                <td>PHP/MySql版本</td>
                <td>PHP <?php echo PHP_VERSION; ?> / MySql <?php echo db()->query('select version() as version')[0]['version']; ?></td>
            </tr>
            <tr>
                <td>ThinkPHP版本</td>
                <td><?php echo THINK_VERSION; ?></td>
            </tr>
        </tbody>
    </table>
</div>

                </div>
            </div>
        </div>
    <?php break; case "2": ?>
    
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <?php if(is_array($tab_data['menu']) || $tab_data['menu'] instanceof \think\Collection || $tab_data['menu'] instanceof \think\Paginator): $k = 0; $__LIST__ = $tab_data['menu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;if($k == 1): ?>
                    <li class="layui-this">
                    <?php else: ?>
                    <li>
                    <?php endif; ?>
                    <a href="javascript:;"><?php echo $vo['title']; ?></a>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="tool-btns">
                    <a href="javascript:location.reload();" title="刷新当前页面" class="aicon ai-shuaxin2 font18"></a>
                    <a href="javascript:;" class="aicon ai-quanping1 font18" id="fullscreen-btn" title="打开/关闭全屏"></a>
                </div>
            </ul>
            <div class="layui-tab-content page-tab-content">
                ﻿<div style="display:block;width:100%;overflow:hidden;">
    <?php echo runhook('system_admin_index'); ?>
</div>

<style>
    .panel {
        float: left;
        text-align: center;
        padding: 0;
        min-width: 152px;
        max-width: 152px;
        margin-bottom: 30px;
        background-color: #f2f2f2;
        margin: 10px 5px;
        border-radius: 10px;
        margin-right:30px;
    }

    .panel_icon {
        width: 40%;
        display: inline-block;
        padding: 22px 0;
        float: left;
        color:#fff;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .panel_word {
        width: 60%;
        display: inline-block;
        float: right;
        margin-top: 22px;
        
        text-align: center;
    }

    .panel_word h3{
        font-size:26px;
        display: inline-block;
        color:#333;
    }
    .panel_word p{
        color:#333;
        margin-top:5px;
    }
    .panel_word p a{
        color:#ff5722;
    }
    .col-md6{
        width:45%;
        main-width:400px;
        float: left;
        height: 300px;
        border:1px solid #c1c1c1;margin-top:50px;
        margin-left: 10px;
        padding-top:10px;
    }
</style>

<div class="layui-row layui-col-space10">
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FF5722">
            <p><i class="fa fa-film" style="font-size:30px;"></i><br/></p><p>视频</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/video/lists"><?php echo $data['videocount']; ?></a></h3>/部
            <p><a title="去审核" href="/admin/video/videocheck"><?php echo $data['videoshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #54ade8;">
            <p><i class="fa fa-file-image-o" style="font-size:30px;"></i></p><p>图册</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/image/lists"><?php echo $data['atlascount']; ?></a></h3>/个
            <p><a title="去审核" href="/admin/image/imgcheck"><?php echo $data['atlasshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FFB800">
            <p><i class="fa fa-file-text" style="font-size:30px;"></i><br/></p><p>资讯</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/novel/lists"><?php echo $data['novelcount']; ?></a></h3>/条
            <p><a title="去审核" href="/admin/novel/novelcheck"><?php echo $data['novelshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #5FB878;">
            <p><i class="fa fa-users" style="font-size:30px;"></i></p><p>会员</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/member/index"><?php echo $data['membercount']; ?></a></h3>/个
		   <br/>
           <p><a title="去查看" href="/admin/member/index">禁用/<?php echo $data['membershenhe']; ?>/个</a></p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #F8113C;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>支付</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/recharge/index"><?php echo $data['ordershenhey']; ?></a></h3>/笔成功<br/>
           <p><a title="去审核" href="/admin/recharge/index"><?php echo $data['ordershenhe']; ?>/</a>笔失败</p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #074AF6;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>评论</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/comment/index"><?php echo $data['commentcount']; ?></a></h3>/条<br/>
           <p><a title="去审核" href="/admin/comment/index"><?php echo $data['commentshenhe']; ?>/条待核</a></p>
        </div>
    </div>
</div>
<!-- 新增会员走势 start -->
<div id="container" class="col-md6"></div>
<div id="viewVideoMonthCharts" class="col-md6"></div>
<div id="viewAtlasMonthCharts" class="col-md6"></div>
<div id="viewNovelMonthCharts" class="col-md6"></div>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-gl/echarts-gl.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/simplex.js"></script>

<?php if(isset($data['memberMonthList'])): ?>
<script type="text/javascript">
    function createMemberCharts(){
        var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月新增会员走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['memberMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['memberMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createMemberCharts,100);
</script>
<?php endif; if(isset($data['viewVideoMonthList'])): ?>
<script type="text/javascript">
    function createViewVideoCharts(){
    var dom = document.getElementById("viewVideoMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月视频消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewVideoMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewVideoMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewVideoCharts,1000);
</script>
<?php endif; if(isset($data['viewAtlasMonthList'])): ?>
<script type="text/javascript">
    function createViewAtlasCharts(){
    var dom = document.getElementById("viewAtlasMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月图册消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewAtlasMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewAtlasMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewAtlasCharts,1500);
</script>
<?php endif; if(isset($data['viewNovelMonthList'])): ?>
<script type="text/javascript">
    function createViewNovelCharts(){
    var dom = document.getElementById("viewNovelMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月资讯消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewNovelMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewNovelMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewNovelCharts,2000);
</script>
<?php endif; ?>

<!-- Powered by Msvodx版系统信息 start -->
<!--<a href="/1.xls">test Download</a>-->
<div class="fr" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th colspan="2">产品信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>产品名称</td>
            <td>MsvodX</td>
        </tr>
        <tr>
            <td>官方网站</td>
            <td><a target="_blank" rel="noreferrer">MSVOD魅思CMS</a></td>
        </tr>
        <tr>
            <td>联系QQ</td>
            <td><a href="http://wpa.qq.com/msgrd?v=3&uin=1919134557&site=qq&menu=yes" target="_blank" rel="noreferrer">1919134557</a></td>
        </tr>
        <tr>
            <td>联系邮箱</td>
            <td>ym@ymyuanma.com</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="fl" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
            <tr>
                <th colspan="2">系统信息</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <td>系统版本</td>
                <td>开源版</td>
            </tr>
            <tr>
                <td>服务器环境</td>
                <td><?php echo PHP_OS; ?> / <?php echo $_SERVER["SERVER_SOFTWARE"]; ?></td>
            </tr>
            <tr>
                <td>PHP/MySql版本</td>
                <td>PHP <?php echo PHP_VERSION; ?> / MySql <?php echo db()->query('select version() as version')[0]['version']; ?></td>
            </tr>
            <tr>
                <td>ThinkPHP版本</td>
                <td><?php echo THINK_VERSION; ?></td>
            </tr>
        </tbody>
    </table>
</div>

            </div>
        </div>
    <?php break; case "3": ?>
    
        ﻿<div style="display:block;width:100%;overflow:hidden;">
    <?php echo runhook('system_admin_index'); ?>
</div>

<style>
    .panel {
        float: left;
        text-align: center;
        padding: 0;
        min-width: 152px;
        max-width: 152px;
        margin-bottom: 30px;
        background-color: #f2f2f2;
        margin: 10px 5px;
        border-radius: 10px;
        margin-right:30px;
    }

    .panel_icon {
        width: 40%;
        display: inline-block;
        padding: 22px 0;
        float: left;
        color:#fff;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .panel_word {
        width: 60%;
        display: inline-block;
        float: right;
        margin-top: 22px;
        
        text-align: center;
    }

    .panel_word h3{
        font-size:26px;
        display: inline-block;
        color:#333;
    }
    .panel_word p{
        color:#333;
        margin-top:5px;
    }
    .panel_word p a{
        color:#ff5722;
    }
    .col-md6{
        width:45%;
        main-width:400px;
        float: left;
        height: 300px;
        border:1px solid #c1c1c1;margin-top:50px;
        margin-left: 10px;
        padding-top:10px;
    }
</style>

<div class="layui-row layui-col-space10">
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FF5722">
            <p><i class="fa fa-film" style="font-size:30px;"></i><br/></p><p>视频</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/video/lists"><?php echo $data['videocount']; ?></a></h3>/部
            <p><a title="去审核" href="/admin/video/videocheck"><?php echo $data['videoshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #54ade8;">
            <p><i class="fa fa-file-image-o" style="font-size:30px;"></i></p><p>图册</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/image/lists"><?php echo $data['atlascount']; ?></a></h3>/个
            <p><a title="去审核" href="/admin/image/imgcheck"><?php echo $data['atlasshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FFB800">
            <p><i class="fa fa-file-text" style="font-size:30px;"></i><br/></p><p>资讯</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/novel/lists"><?php echo $data['novelcount']; ?></a></h3>/条
            <p><a title="去审核" href="/admin/novel/novelcheck"><?php echo $data['novelshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #5FB878;">
            <p><i class="fa fa-users" style="font-size:30px;"></i></p><p>会员</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/member/index"><?php echo $data['membercount']; ?></a></h3>/个
		   <br/>
           <p><a title="去查看" href="/admin/member/index">禁用/<?php echo $data['membershenhe']; ?>/个</a></p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #F8113C;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>支付</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/recharge/index"><?php echo $data['ordershenhey']; ?></a></h3>/笔成功<br/>
           <p><a title="去审核" href="/admin/recharge/index"><?php echo $data['ordershenhe']; ?>/</a>笔失败</p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #074AF6;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>评论</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/comment/index"><?php echo $data['commentcount']; ?></a></h3>/条<br/>
           <p><a title="去审核" href="/admin/comment/index"><?php echo $data['commentshenhe']; ?>/条待核</a></p>
        </div>
    </div>
</div>
<!-- 新增会员走势 start -->
<div id="container" class="col-md6"></div>
<div id="viewVideoMonthCharts" class="col-md6"></div>
<div id="viewAtlasMonthCharts" class="col-md6"></div>
<div id="viewNovelMonthCharts" class="col-md6"></div>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-gl/echarts-gl.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/simplex.js"></script>

<?php if(isset($data['memberMonthList'])): ?>
<script type="text/javascript">
    function createMemberCharts(){
        var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月新增会员走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['memberMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['memberMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createMemberCharts,100);
</script>
<?php endif; if(isset($data['viewVideoMonthList'])): ?>
<script type="text/javascript">
    function createViewVideoCharts(){
    var dom = document.getElementById("viewVideoMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月视频消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewVideoMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewVideoMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewVideoCharts,1000);
</script>
<?php endif; if(isset($data['viewAtlasMonthList'])): ?>
<script type="text/javascript">
    function createViewAtlasCharts(){
    var dom = document.getElementById("viewAtlasMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月图册消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewAtlasMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewAtlasMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewAtlasCharts,1500);
</script>
<?php endif; if(isset($data['viewNovelMonthList'])): ?>
<script type="text/javascript">
    function createViewNovelCharts(){
    var dom = document.getElementById("viewNovelMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月资讯消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewNovelMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewNovelMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewNovelCharts,2000);
</script>
<?php endif; ?>

<!-- Powered by Msvodx版系统信息 start -->
<!--<a href="/1.xls">test Download</a>-->
<div class="fr" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th colspan="2">产品信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>产品名称</td>
            <td>MsvodX</td>
        </tr>
        <tr>
            <td>官方网站</td>
            <td><a target="_blank" rel="noreferrer">MSVOD魅思CMS</a></td>
        </tr>
        <tr>
            <td>联系QQ</td>
            <td><a href="http://wpa.qq.com/msgrd?v=3&uin=1919134557&site=qq&menu=yes" target="_blank" rel="noreferrer">1919134557</a></td>
        </tr>
        <tr>
            <td>联系邮箱</td>
            <td>ym@ymyuanma.com</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="fl" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
            <tr>
                <th colspan="2">系统信息</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <td>系统版本</td>
                <td>开源版</td>
            </tr>
            <tr>
                <td>服务器环境</td>
                <td><?php echo PHP_OS; ?> / <?php echo $_SERVER["SERVER_SOFTWARE"]; ?></td>
            </tr>
            <tr>
                <td>PHP/MySql版本</td>
                <td>PHP <?php echo PHP_VERSION; ?> / MySql <?php echo db()->query('select version() as version')[0]['version']; ?></td>
            </tr>
            <tr>
                <td>ThinkPHP版本</td>
                <td><?php echo THINK_VERSION; ?></td>
            </tr>
        </tbody>
    </table>
</div>

    <?php break; default: ?>
    
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <li class="layui-this">
                    <a href="javascript:;" id="curTitle"><?php echo $_admin_menu_current['title']; ?></a>
                </li>
                <div class="tool-btns">
                    <a href="javascript:location.reload();" title="刷新当前页面" class="aicon ai-shuaxin2 font18"></a>
                    <a href="javascript:;" class="aicon ai-quanping1 font18" id="fullscreen-btn" title="打开/关闭全屏"></a>
                </div>
            </ul>
            <div class="layui-tab-content page-tab-content">
                <div class="layui-tab-item layui-show">
                    ﻿<div style="display:block;width:100%;overflow:hidden;">
    <?php echo runhook('system_admin_index'); ?>
</div>

<style>
    .panel {
        float: left;
        text-align: center;
        padding: 0;
        min-width: 152px;
        max-width: 152px;
        margin-bottom: 30px;
        background-color: #f2f2f2;
        margin: 10px 5px;
        border-radius: 10px;
        margin-right:30px;
    }

    .panel_icon {
        width: 40%;
        display: inline-block;
        padding: 22px 0;
        float: left;
        color:#fff;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .panel_word {
        width: 60%;
        display: inline-block;
        float: right;
        margin-top: 22px;
        
        text-align: center;
    }

    .panel_word h3{
        font-size:26px;
        display: inline-block;
        color:#333;
    }
    .panel_word p{
        color:#333;
        margin-top:5px;
    }
    .panel_word p a{
        color:#ff5722;
    }
    .col-md6{
        width:45%;
        main-width:400px;
        float: left;
        height: 300px;
        border:1px solid #c1c1c1;margin-top:50px;
        margin-left: 10px;
        padding-top:10px;
    }
</style>

<div class="layui-row layui-col-space10">
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FF5722">
            <p><i class="fa fa-film" style="font-size:30px;"></i><br/></p><p>视频</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/video/lists"><?php echo $data['videocount']; ?></a></h3>/部
            <p><a title="去审核" href="/admin/video/videocheck"><?php echo $data['videoshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #54ade8;">
            <p><i class="fa fa-file-image-o" style="font-size:30px;"></i></p><p>图册</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/image/lists"><?php echo $data['atlascount']; ?></a></h3>/个
            <p><a title="去审核" href="/admin/image/imgcheck"><?php echo $data['atlasshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FFB800">
            <p><i class="fa fa-file-text" style="font-size:30px;"></i><br/></p><p>资讯</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/novel/lists"><?php echo $data['novelcount']; ?></a></h3>/条
            <p><a title="去审核" href="/admin/novel/novelcheck"><?php echo $data['novelshenhe']; ?>/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #5FB878;">
            <p><i class="fa fa-users" style="font-size:30px;"></i></p><p>会员</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/member/index"><?php echo $data['membercount']; ?></a></h3>/个
		   <br/>
           <p><a title="去查看" href="/admin/member/index">禁用/<?php echo $data['membershenhe']; ?>/个</a></p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #F8113C;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>支付</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/recharge/index"><?php echo $data['ordershenhey']; ?></a></h3>/笔成功<br/>
           <p><a title="去审核" href="/admin/recharge/index"><?php echo $data['ordershenhe']; ?>/</a>笔失败</p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #074AF6;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>评论</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/comment/index"><?php echo $data['commentcount']; ?></a></h3>/条<br/>
           <p><a title="去审核" href="/admin/comment/index"><?php echo $data['commentshenhe']; ?>/条待核</a></p>
        </div>
    </div>
</div>
<!-- 新增会员走势 start -->
<div id="container" class="col-md6"></div>
<div id="viewVideoMonthCharts" class="col-md6"></div>
<div id="viewAtlasMonthCharts" class="col-md6"></div>
<div id="viewNovelMonthCharts" class="col-md6"></div>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-gl/echarts-gl.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/simplex.js"></script>

<?php if(isset($data['memberMonthList'])): ?>
<script type="text/javascript">
    function createMemberCharts(){
        var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月新增会员走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['memberMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['memberMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createMemberCharts,100);
</script>
<?php endif; if(isset($data['viewVideoMonthList'])): ?>
<script type="text/javascript">
    function createViewVideoCharts(){
    var dom = document.getElementById("viewVideoMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月视频消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewVideoMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewVideoMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewVideoCharts,1000);
</script>
<?php endif; if(isset($data['viewAtlasMonthList'])): ?>
<script type="text/javascript">
    function createViewAtlasCharts(){
    var dom = document.getElementById("viewAtlasMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月图册消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewAtlasMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewAtlasMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewAtlasCharts,1500);
</script>
<?php endif; if(isset($data['viewNovelMonthList'])): ?>
<script type="text/javascript">
    function createViewNovelCharts(){
    var dom = document.getElementById("viewNovelMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月资讯消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [<?php echo $data['viewNovelMonthList']['month']; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [<?php echo $data['viewNovelMonthList']['count']; ?>],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewNovelCharts,2000);
</script>
<?php endif; ?>

<!-- Powered by Msvodx版系统信息 start -->
<!--<a href="/1.xls">test Download</a>-->
<div class="fr" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th colspan="2">产品信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>产品名称</td>
            <td>MsvodX</td>
        </tr>
        <tr>
            <td>官方网站</td>
            <td><a target="_blank" rel="noreferrer">MSVOD魅思CMS</a></td>
        </tr>
        <tr>
            <td>联系QQ</td>
            <td><a href="http://wpa.qq.com/msgrd?v=3&uin=1919134557&site=qq&menu=yes" target="_blank" rel="noreferrer">1919134557</a></td>
        </tr>
        <tr>
            <td>联系邮箱</td>
            <td>ym@ymyuanma.com</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="fl" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
            <tr>
                <th colspan="2">系统信息</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <td>系统版本</td>
                <td>开源版</td>
            </tr>
            <tr>
                <td>服务器环境</td>
                <td><?php echo PHP_OS; ?> / <?php echo $_SERVER["SERVER_SOFTWARE"]; ?></td>
            </tr>
            <tr>
                <td>PHP/MySql版本</td>
                <td>PHP <?php echo PHP_VERSION; ?> / MySql <?php echo db()->query('select version() as version')[0]['version']; ?></td>
            </tr>
            <tr>
                <td>ThinkPHP版本</td>
                <td><?php echo THINK_VERSION; ?></td>
            </tr>
        </tbody>
    </table>
</div>

                </div>
            </div>
        </div>
<?php endswitch; if(input('param.hisi_iframe') || cookie('hisi_iframe')): ?>
</body>
</html>
<?php else: ?>
        </div>
    </div>
    <div class="layui-footer footer">
      	<span class="fl" style="color: #ff0072 !important;font-weight: 700 !important;font-size: 16px !important; display:block !important;"> 更多X站模板，百度：YM源码</span>
        <span class="fr"> © 2017-2018 MsvodX All Rights Reserved</span>
    </div>
</div>
</body>
</html>
<?php endif; ?>