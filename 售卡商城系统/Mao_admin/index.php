<?php
require '../Mao/common.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $mao['title']?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="./layui/css/layui.css" media="all">
    <link rel="stylesheet" href="./css/admin.css" media="all">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
</head>
<body class="layui-layout-body"> 
    <div id="LAY_app">
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header">
                <!-- 头部区域 -->
                <ul class="layui-nav layui-layout-left">
                    <li class="layui-nav-item layadmin-flexible" lay-unselect>
                        <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                            <i class="layui-icon layui-icon-spread-left" id="LAY_app_flexible"></i>
                        </a>
                    </li>
                    <li class="layui-nav-item layui-hide-xs" lay-unselect>
                        <a href="/index.php" title="前台">
                            <i class="layui-icon layui-icon-website"></i>
                        </a>
                    </li>
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;" layadmin-event="refresh" title="刷新">
                            <i class="layui-icon layui-icon-refresh"></i>
                        </a>
                    </li>
                </ul>
                <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                    <li class="layui-nav-item" lay-unselect>
                        <a layadmin-event="message" lay-text="消息中心">
                            <i class="layui-icon layui-icon-notice"></i>  
                            <span class="layui-badge-dot"></span>
                        </a>
                    </li>
                    <li class="layui-nav-item layui-hide-xs" lay-unselect>
                        <a href="javascript:;" layadmin-event="theme">
                            <i class="layui-icon layui-icon-theme"></i>
                        </a>
                    </li>
                    <li class="layui-nav-item layui-hide-xs" lay-unselect>
                        <a href="javascript:;" layadmin-event="note">
                            <i class="layui-icon layui-icon-note"></i>
                        </a>
                    </li>
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;">
                            <cite><?php echo $mao['user']?></cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd style="text-align: center;"><a href="javascript:;" onclick="logout()">退出</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item layui-hide-xs" lay-unselect>
                        <a href="javascript:;" layadmin-event=""><i class="layui-icon layui-icon-more-vertical"></i></a>
                    </li>
                    <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                        <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
                    </li>
                </ul>
            </div>
            <!-- 侧边菜单 -->
            <div class="layui-side layui-side-menu">
                <div class="layui-side-scroll">
                    <div class="layui-logo" href="/index.php">
                        <span><?php echo $mao['title']?></span>
                    </div>
                    <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                        <li data-name="home" class="layui-nav-item">
                            <a href="javascript:;" lay-tips="主页" lay-direction="2">
                                <i class="layui-icon layui-icon-set"></i>
                                <cite>系统设置</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd data-name="console">
                                    <a lay-href="Mao_set/set.php">网站配置</a>
                                </dd>
                            </dl>
                            <dl class="layui-nav-child">
                                <dd data-name="console">
                                    <a lay-href="Mao_set/dx.php">短信配置</a>
                                </dd>
                            </dl>
                            <dl class="layui-nav-child">
                                <dd data-name="console">
                                    <a lay-href="Mao_set/pay.php">支付接口配置</a>
                                </dd>
                            </dl>
                        </li>
                        <li data-name="new" class="layui-nav-item">
                            <a href="javascript:;" lay-tips="商品" lay-direction="2">
                                <i class="layui-icon layui-icon-cart"></i>
                                <cite>商品管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd data-name="button">
                                    <a lay-href="Mao_commodity/add.php">添加商品</a>
                                </dd>
                            </dl>
                            <dl class="layui-nav-child">
                                <dd data-name="button">
                                    <a lay-href="Mao_commodity/list.php">商品列表</a>
                                </dd>
                            </dl>
                        </li>
                        <li data-name="url" class="layui-nav-item">
                            <a href="javascript:;" lay-tips="工单" lay-direction="2">
                                <i class="layui-icon">&#xe6b2;</i>
                                <cite>工单管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd data-name="button">
                                    <a lay-href="Mao_survey/list.php">工单列表</a>
                                </dd>
                            </dl>
                        </li>
                        <li data-name="url" class="layui-nav-item">
                            <a href="javascript:;" lay-tips="订单" lay-direction="2">
                                <i class="layui-icon layui-icon-template-1"></i>
                                <cite>订单管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd data-name="button">
                                    <a lay-href="Mao_Order/list.php">订单列表</a>
                                </dd>
                            </dl>
                        </li>
                        <li data-name="sj" class="layui-nav-item">
                            <a href="javascript:;" lay-tips="分站" lay-direction="2">
                                <i class="layui-icon">&#xe7ae;</i>
                                <cite>分站管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd data-name="button">
                                    <a lay-href="Mao_sub/add.php">添加分站</a>
                                </dd>
                            </dl>
                            <dl class="layui-nav-child">
                                <dd data-name="button">
                                    <a lay-href="Mao_sub/list.php">分站列表</a>
                                </dd>
                            </dl>
                        </li>
                        <?php
                        if($mao['id'] == 1 || $mao['yzf_type'] == 1){
                            ?>
                            <li data-name="sj" class="layui-nav-item">
                                <a href="javascript:;" lay-tips="提现" lay-direction="2">
                                    <i class="layui-icon">&#xe62c;</i>
                                    <cite>提现管理</cite>
                                </a>
                                <?php
                                if($mao['id'] == 1){
                                    ?>
                                    <dl class="layui-nav-child">
                                        <dd data-name="button">
                                            <a lay-href="Mao_tx/admin.php">提现管理</a>
                                        </dd>
                                    </dl>
                                    <dl class="layui-nav-child">
                                        <dd data-name="button">
                                            <a lay-href="Mao_tx/list.php">我的提现</a>
                                        </dd>
                                    </dl>
                                    <?php
                                }else{
                                    ?>
                                    <dl class="layui-nav-child">
                                        <dd data-name="button">
                                            <a lay-href="Mao_tx/list.php">我的提现</a>
                                        </dd>
                                    </dl>
                                    <?php
                                }
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                        <li data-name="logout" class="layui-nav-item">
                            <a href="javascript:;" onclick="logout()" lay-tips="退出" lay-direction="2">
                                <i class="layui-icon layui-icon-auz"></i>
                                <cite>退出</cite>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 页面标签 -->
            <div class="layadmin-pagetabs" id="LAY_app_tabs">
                <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
                <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
                <!-- <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div> -->
                <div class="layui-icon layadmin-tabs-control layui-icon-down">
                    <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                        <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                        </li>
                    </ul>
                </div>
                <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                    <ul class="layui-tab-title" id="LAY_app_tabsheader">
                        <li lay-id="mao.php" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
                    </ul>
                </div>
            </div>
            <!-- 主体内容 -->
            <div class="layui-body" id="LAY_app_body">
                <div class="layadmin-tabsbody-item layui-show">
                    <iframe src="mao.php" frameborder="0" class="layadmin-iframe"></iframe>
                </div>
            </div>
            <!-- 辅助元素，一般用于移动设备下遮罩 -->
            <div class="layadmin-body-shade" layadmin-event="shade"></div>
        </div>
    </div>
    <script src="./layui/layui.js"></script>
    <script>
    layui.config({
        base: './' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');
    function logout() {
        var loading = layer.load();
        $.ajax({
            url: '/Mao_admin/login.php',
            type: 'POST',
            dataType: 'json',
            data: {mod: 'logout'},
            success: function (a) {
                layer.close(loading);
                if(a.code == 0){
                    layer.msg(a.msg, function() {window.open("/Mao_admin/login.php", "_self");});
                } else {
                    layer.msg(a.msg, function() {});
                }
            },
            error: function() {
                layer.close(loading);
                layer.msg('连接服务器失败！', {icon: 5},function(){});
            }
        });
    }
    </script>
</body>
</html>


