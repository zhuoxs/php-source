<?php
defined('YII_RUN') or exit('Access Denied');

use app\models\AdminPermission;

/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/6/19
 * Time: 16:52
 * @var \yii\web\View $this
 * @var \app\models\Admin $admin
 */
$urlManager = Yii::$app->urlManager;
$this->params['active_nav_group'] = isset($this->params['active_nav_group']) ? $this->params['active_nav_group'] : 0;
$version = $this->context->getVersion();
$is_auth = Yii::$app->cache->get('IS_AUTH');

$admin = null;
$admin_permission_list = [];
if (!Yii::$app->admin->isGuest) {
    $admin = Yii::$app->admin->identity;
    $admin_permission_list = json_decode($admin->permission, true);
    if (!$admin_permission_list)
        $admin_permission_list = [];
} else {
    $admin = true;
    $admin_permission_list = $this->context->we7_user_auth;
}
try {
    $plugin_list = \app\hejiang\CloudPlugin::getInstalledPluginList();
} catch (Exception $e) {
    $plugin_list = [];
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <title><?= $this->title ?></title>
    <link href="//cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="//at.alicdn.com/t/font_353057_h7xlg5vw5qaor.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet">
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/css/flex.css?version=<?= $version ?>" rel="stylesheet">
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/css/common.css?version=<?= $version ?>" rel="stylesheet">
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/mch/css/common.v2.css?version=<?= $version ?>"
          rel="stylesheet">

    <script>var _csrf = "<?=Yii::$app->request->csrfToken?>";</script>
    <script>var _upload_url = "<?=Yii::$app->urlManager->createUrl(['upload/file'])?>";</script>
    <script>var _upload_file_list_url = "<?=Yii::$app->urlManager->createUrl(['mch/store/upload-file-list'])?>";</script>
    <script src="//cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/vue/2.3.4/vue.js"></script>
    <script src="//cdn.bootcss.com/tether/1.4.0/js/tether.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/plupload/2.3.0/plupload.full.min.js"></script>
    <script src="//cdn.bootcss.com/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/js/common.js?version=<?= $version ?>"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/common.v2.js?version=<?= $version ?>"></script>
    <script src="https://cdn.bootcss.com/clipboard.js/1.7.1/clipboard.js"></script>
    <script charset="utf-8" src="<?= Yii::$app->request->baseUrl ?>/statics/mch/vendor/layer/layer.js"></script>
    <script charset="utf-8" src="<?= Yii::$app->request->baseUrl ?>/statics/mch/vendor/laydate/laydate.js"></script>
</head>
<body>
<?= $this->render('/components/pick-link.php') ?>
<?= $this->render('/components/pick-file.php') ?>
<!-- 文件选择模态框 Modal -->
<div class="modal fade" id="file_select_modal" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="panel">
            <div class="panel-header">
                <span>选择文件</span>
                <a href="javascript:" class="panel-close" data-dismiss="modal">&times;</a>
            </div>
            <div class="panel-body">
                <div class="file-list"></div>
                <div class="file-loading text-center" style="display: none">
                    <img style="height: 1.14286rem;width: 1.14286rem"
                         src="<?= Yii::$app->request->baseUrl ?>/statics/images/loading-2.svg">
                </div>
                <div class="text-center">
                    <a style="display: none" href="javascript:" class="file-more">加载更多</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$menu_list = $this->context->getMenuList();
$route = Yii::$app->requestedRoute;
$current_menu = getCurrentMenu($menu_list, $route);
function activeMenu($item, $route)
{
    if (isset($item['route']) && $item['route'] == $route)
        return 'active';
    if (isset($item['list']) && is_array($item['list'])) {
        foreach ($item['list'] as $sub_item) {
            $active = activeMenu($sub_item, $route);
            if ($active != '')
                return $active;
        }
    }
    return '';
}

function getCurrentMenu($menu_list, $route)
{
    foreach ($menu_list as $item) {
        if (isset($item['route']) && $item['route'] == $route)
            return $item;
        if (isset($item['list']) && is_array($item['list'])) {
            foreach ($item['list'] as $sub_item) {
                if (isset($sub_item['route']) && $sub_item['route'] == $route)
                    return $item;
                if (isset($sub_item['list']) && is_array($sub_item['list'])) {
                    foreach ($sub_item['list'] as $sub_sub_item) {
                        if (isset($sub_sub_item['route']) && $sub_sub_item['route'] == $route)
                            return $item;
                    }
                }
            }
        }
    }
    return null;
}

?>
<div class="sidebar <?= $current_menu ? 'sidebar-sub' : null ?>">
    <div class="sidebar-1">
        <div class="logo">
            <a class="home-link"
               href="<?= $urlManager->createUrl(['mch/default/index']) ?>"><?= $this->context->store->name ?></a>
        </div>
        <div>
            <?php foreach ($menu_list as $item): ?>
                <a class="nav-item <?= activeMenu($item, $route) ?>"
                   href="<?= $urlManager->createUrl($item['route']) ?>">
                    <span class="nav-icon iconfont <?= $item['icon'] ?>"></span>
                    <span><?= $item['name'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if ($current_menu): ?>
        <div class="sidebar-2">
            <div class="current-menu-name"><?= $current_menu['name'] ?></div>
            <div class="sidebar-content">
                <?php foreach ($current_menu['list'] as $item): ?>
                    <?php if (isset($item['list']) && is_array($item['list']) && count($item['list']) > 0): ?>
                        <a class="nav-item <?= activeMenu($item, $route) ?>"
                           href="javascript:">
                            <span class="nav-pointer iconfont icon-play_fill"></span>
                            <span><?= $item['name'] ?></span>
                        </a>
                        <div class="sub-item-list">
                            <?php foreach ($item['list'] as $sub_item): ?>
                                <a class="nav-item <?= activeMenu($sub_item, $route) ?>"
                                   href="<?= $urlManager->createUrl($sub_item['route']) ?>">
                                    <span><?= $sub_item['name'] ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <a class="nav-item <?= activeMenu($item, $route) ?>"
                           href="<?= $urlManager->createUrl($item['route']) ?>">
                            <span><?= $item['name'] ?></span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="main">
    <div class="main-header">

    </div>
    <div class="main-body">
        <?= $content ?>
    </div>
</div>

<script>
    /*
     * 获取浏览器竖向滚动条宽度
     * 首先创建一个用户不可见、无滚动条的DIV，获取DIV宽度后，
     * 再将DIV的Y轴滚动条设置为永远可见，再获取此时的DIV宽度
     * 删除DIV后返回前后宽度的差值
     *
     * @return    Integer     竖向滚动条宽度
     **/
    function getScrollWidth() {
        var noScroll, scroll, oDiv = document.createElement("DIV");
        oDiv.style.cssText = "position:absolute; top:-1000px; width:100px; height:100px; overflow:hidden;";
        noScroll = document.body.appendChild(oDiv).clientWidth;
        oDiv.style.overflowY = "scroll";
        scroll = oDiv.clientWidth;
        document.body.removeChild(oDiv);
        return noScroll - scroll;
    }

    if ($('.sidebar-content')) {
        $('.sidebar-content').css('width', ($('.sidebar-content').width() + getScrollWidth()) + 'px');
    }


    $(document).on("click", "body > .sidebar .sidebar-2 .nav-item", function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(document).on("click", ".input-hide .tip-block", function () {
        $(this).hide();
    });


    $(document).on("click", ".input-group .dropdown-item", function () {
        var val = $.trim($(this).text());
        $(this).parents(".input-group").find(".form-control").val(val);
    });
</script>
<?php if ($is_auth == -1): ?>
    <script>
        (function () {
            var _html = '<div id="_auth_alert" style="border:1px solid rgba(0,0,0,.75);opacity: .5;pointer-events:none;z-index:2000;position: fixed;top: 30%;left: 50%;width: 400px;margin-left: -200px;background: rgba(0,0,0,.8);border-radius:3px;text-align: center;color: #fff;text-shadow:0 1px 0 #000;font-size: 1.2rem;">\n' +
                '    <div style="position: relative;padding: 40px;">\n' +
                '        <a id="_auth_alert_close" style="display: none; position: absolute;right: -5px;top: -5px;width: 20px;height: 20px;line-height: 20px;text-align: center;background: #ff4544;color: #fff;border-radius: 999px;cursor: pointer">×</a>\n' +
                '        <div>您的域名尚未授权，请联系管理员处理！</div>\n' +
                '    </div>\n' +
                '</div>';
            $("body").append(_html);
            $(document).on("click", "#_auth_alert #_auth_alert_close", function () {
                $("#_auth_alert").hide();
            });
        })();
        $.myLoading();
        setTimeout(function () {
            $.myLoadingHide();
        }, 100);
    </script>
<?php endif; ?>
</body>
</html>