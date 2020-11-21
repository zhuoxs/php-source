<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$wx_app.app_name}} 管理后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="apple-mobile-web-app-title" content="{{$wx_app.app_name}} 管理后台"/>
    <link rel="stylesheet" href="//cdn.staticfile.org/amazeui/2.7.2/css/amazeui.min.css"/>
    <link rel="stylesheet" href="./assets/admin/css/app.css">
    <script src="//cdn.staticfile.org/jquery/2.1.4/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>
    <script src="//cdn.staticfile.org/amazeui/2.7.2/js/amazeui.min.js"></script>
</head>
<body data-type="widgets">
<script src="./assets/admin/js/theme.js"></script>
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header>
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <div class="am-fl tpl-header-switch-button am-icon-list">
                <span></span>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="javascript:void(0);">欢迎你, <span>系统管理员</span> </a>
                    </li>

                    <!-- 退出 -->
                    <!--
                   <li class="am-text-sm">
                       <a href="/admin/public/logout">
                           <span class="am-icon-sign-out"></span> 退出
                       </a>
                   </li>
                   -->
                </ul>
            </div>
        </div>
    </header>
    <!-- 风格切换 -->
    <div class="tpl-skiner">
        <div class="tpl-skiner-toggle am-icon-cog">
        </div>
        <div class="tpl-skiner-content">
            <div class="tpl-skiner-content-title">
                选择主题
            </div>
            <div class="tpl-skiner-content-bar">
                <span class="skiner-color skiner-white" data-color="theme-white"></span>
                <span class="skiner-color skiner-black" data-color="theme-black"></span>
            </div>
        </div>
    </div>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar">
        <!-- 管理员信息 -->
        <div class="tpl-sidebar-user-panel">
            <div class="tpl-user-panel-slide-toggleable">
                <div class="tpl-user-panel-profile-picture">
                    <img src="./assets/admin/picture/logo.jpg" alt="">
                </div>
                <span class="user-panel-logged-in-text">
                    <i class="am-icon-circle-o am-text-success tpl-user-panel-status-icon"></i>
                    系统管理员
                </span>
            </div>
        </div>
        <!-- 菜单 -->
        <ul class="sidebar-nav">
            <?php
            $menus = $menus ?: [];  // 菜单
            $current_url = $current_url ?: '';
            ?>
            <?php foreach ($menus as $item): ?>
                <li class="sidebar-nav-link">
                    <?php
                    // 判断子菜单是否激活
                    $submenu_box_active = false;
                    if (isset($item['submenu'])) {
                        if (in_array($current_url, array_column($item['submenu'], 'url'))) {
                            $submenu_box_active = true;
                        } else {
                            array_map(function ($submenu) use (&$submenu_box_active, $current_url) {
                                if (!$submenu_box_active
                                    && isset($submenu['sub_urls'])
                                    && in_array($current_url, $submenu['sub_urls'])) {
                                    $submenu_box_active = true;
                                }
                            }, $item['submenu']);
                        }
                    }
                    ?>
                    <a href="<?= isset($item['url']) ? url($item['url']) : 'javascript:void(0);' ?>"
                       class="sidebar-nav-sub-title
                       <?= isset($item['url']) && $current_url === $item['url'] ? 'active' : '' ?>">
                        <i class="am-icon-<?= $item['icon'] ?> sidebar-nav-link-logo"></i>
                        <?= $item['name']; ?>
                        <?php if (isset($item['submenu'])): ?>
                            <span class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico
                           <?= $submenu_box_active ? 'sidebar-nav-sub-ico-rotate' : '' ?>"> </span>
                        <?php endif; ?>
                    </a>
                    <?php if (isset($item['submenu'])): ?>
                        <ul class="sidebar-nav sidebar-nav-sub"
                            style="<?= $submenu_box_active ? 'display: block;' : '' ?>">
                            <?php foreach ($item['submenu'] as $submenu): ?>
                                <li class="sidebar-nav-link">
                                    <a href="<?= url($submenu['url']) ?>"
                                       class="<?= $current_url === $submenu['url']
                                       || (isset($submenu['sub_urls']) && in_array($current_url, $submenu['sub_urls'])) ? 'active' : '' ?>">
                                        <span class="am-icon-angle-right sidebar-nav-link-logo"></span>
                                        <?= $submenu['name'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- 内容区域 start -->
    {__CONTENT__}
    <!-- 内容区域 end -->
    <div class="we7-footer am-text-center">
        <p class="friend-link">
            <a href="http://www.zheyitianshi.com" target="_blank">微信开发</a>
            <a href="http://s.we7.cc" target="_blank">微信应用</a>
            <a href="http://bbs.we7.cc" target="_blank">微擎论坛</a>
            <a href="http://s.we7.cc" target="_blank">联系客服</a>
        </p>
        <p class="copyright">
            <span>Powered by 微擎 (c) 2014-2019</span>
            <a href="http://www.miitbeian.gov.cn" target="_blank">www.w7.cc</a>
        </p>
    </div>
</div>

<script src="./assets/admin/js/layer/layer.js"></script>
<script src="./assets/admin/js/app.js"></script>
<script src="./assets/admin/js/mytools.js"></script>

</body>

</html>
