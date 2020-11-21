<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:95:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/delivery/index.html";i:1553589105;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/header.html";i:1554967557;s:96:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/pub/setting-nav.html";i:1555405428;s:88:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/copyright.html";i:1553776206;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/footer.html";i:1554883865;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="stylesheet icon" href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/favicon.ico">-->

    <title>管理控制台</title>

    <!-- Bootstrap core CSS -->
    <link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/bootstrap.css" rel="stylesheet">
    <link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/iconfont.css" rel="stylesheet">
    <link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/jquery-ui.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/ie10-viewport-bug-workaround.css" rel="stylesheet"> -->

    <!-- CSS DESIGN BY cHen. -->

    <link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/component-chosen.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//layui/css/layui.css" rel="stylesheet">
    <script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//layui/layui.js"></script>
    <script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/iconfont.js"></script>

    <!--ueditor-->
    <script type="text/javascript" charset="utf-8" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//plugins/ueditor/ueditor.all.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

    <script type="text/javascript" charset="utf-8" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/xiumi-ue-dialog-v5.js"></script>
    <link rel="stylesheet" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/xiumi-ue-v5.css">

    <link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/style_chen.css" rel="stylesheet">
    <script type="text/javascript">
        function cache(){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type: 'POST',
                url: '<?php echo url("boguan/base/cache"); ?>',
                //data:{'id':id},
                success: function(data){
                    console.log(data)
                    if(data.errorCode == 1){
                        layui.use(['layer','form'], function(){
                            var layer = layui.layer,form = layui.form;

                            layer.msg(data.msg, {icon: 1, time:1000}, function(){
                                //window.history.go(-1);location.reload();
                                //window.location=document.referrer;
                            });
                        });
                    }else{
                        layui.use(['layer','form'], function(){
                            var layer = layui.layer,form = layui.form;

                            layer.msg(data.msg, {icon: 2, time:1000}, function(){
                                //window.history.go(-1);location.reload();
                                //window.location=document.referrer;
                            });
                        });
                    }
                },
                error:function(data) {
                    console.log(data.responseText)
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;

                        layer.msg(data.msg, {icon: 2, time:1000}, function(){
                            //window.history.go(-1);location.reload();
                            //window.location=document.referrer;
                        });
                    });
                },
            });

            //$(obj).parents(".imgpreview").remove();
            //layer.msg('已删除！',{icon:1,time:3000});
        }

    </script>
</head>

<body>

<!-- Static navbar -->
<nav class="navbar navbar_ob" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar_logo" href="<?php echo url('boguan/platform.index/index'); ?>">
                <!--<img src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/logo.png" ondragstart="return false" alt="logo" title="logo">-->
                <span>
                管理控制台
            </span>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse collapse_ob" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="navbar_user navbar-info-dropdown">
                    <a href="javascript:;;" class="dropdown-toggle">消息<?php if(count($getMessage) > 0): ?><span class="navbar-notice-num"><?php if($getMessageCount >= 99): ?>99+<?php else: ?><?php echo $getMessageCount; endif; ?></span><?php endif; ?></a>
                    <?php if(count($getMessage) > 0): ?>
                    <div class="navbar-info-dropdown-memu navbar-info-dropdown-memu-list">
                        <div class="navbar-notice-body">
                            <ul class="navbar-notice-list">
                                <?php if(is_array($getMessage) || $getMessage instanceof \think\Collection || $getMessage instanceof \think\Paginator): $i = 0; $__LIST__ = $getMessage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <li class="">
                                    <a class="clearfix" rel="noopener noreferrer" data-spm-anchor-id="">
                                        <p class="navbar-notice-item-name" title="<?php if($vo['type'] == 1): ?>用户：<?php echo $vo['user']['nickname']; ?> 支付了一个订单<?php elseif($vo['type'] == 2): ?>用户：<?php echo $vo['user']['nickname']; ?> 提交了一个售后订单<?php elseif($vo['type'] == 3): ?>系统消息<?php else: ?>其他消息<?php endif; ?>">
                                            <?php if($vo['type'] == 1): ?>用户：<?php echo $vo['user']['nickname']; ?> 支付了一个订单<?php elseif($vo['type'] == 2): ?>用户：<?php echo $vo['user']['nickname']; ?> 提交了一个售后订单<?php elseif($vo['type'] == 3): ?>系统消息<?php else: ?>其他消息<?php endif; ?>
                                        </p>
                                        <p class="navbar-notice-item-time">
                                            <?php echo $vo['create_time']; ?>
                                        </p>
                                    </a>
                                </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>

                        <div class="navbar-notice-foot">
                            <a class="navbar-notice-more" rel="noopener noreferrer" href="<?php echo url('boguan/platform.message/index'); ?>"
                               data-spm-anchor-id="">
                                查看更多
                            </a>
                        </div>


                    </div>
                    <?php endif; ?>
                </li>
                <!--<li class="dropdown navbar_user">
                    <a href="#" class="dropdown-toggle" data-hover="dropdown"><i class="glyphicon glyphicon-bell"></i><span class="badge">42</span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>-->
                <li class="dropdown navbar_user">
                    <a href="javascript:;" onclick="cache()" class="dropdown-toggle" title="更新缓存"><i class="iconfont icon-shuaxin"></i></a>

                </li>

                <li class="dropdown navbar_user">
                    <a href="#" class="dropdown-toggle" data-hover="dropdown"><img src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/default_handsome.jpg" ondragstart="return false" alt="" title=""></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if(session('we7')): ?>
                        <li><a><?php echo session('name'); ?> (管理员)</a></li>
                        <li class="divider"></li>

                        <li><a href="javascript:;" onclick="returnSystem()">返回系统</a></li>
                        <?php else: ?>
                        <li><a><?php echo session('name'); ?> (操作员)</a></li>
                        <li><a href="<?php echo url('boguan/platform.setting/edit',array('id'=> session('aid'))); ?>">修改密码</a></li>
                        <li><a href="javascript:;" onclick="logout()">退出系统</a></li>
                        <?php endif; ?>
                    </ul>
                </li>


            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<script>
    function logout() {
        layui.use(['layer','form'], function(){
            var layer = layui.layer,form = layui.form;;

            layer.confirm('确认退出吗？', {btn:['确认'], yes:function(index){
                    //按钮【按钮一】的回调
                    //此处请求后台程序，下方是成功后的前台处理……
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo url("boguan/login/logout"); ?>',

                        success: function(data) {
                            //console.log(data);
                            if (data.errorCode == 1) {

                                layer.msg(data.msg,{icon: 1})
                                window.location.href= data.url;
                            } else {
                                layer.msg(data.msg,{icon: 2})
                            }
                        },
                        error: function (data) {

                            layer.msg(data.msg,{icon: 2})
                        }
                    });
                    layer.close(index);
                }});
        })

    }

    function returnSystem() {
        layui.use(['layer','form'], function(){
            var layer = layui.layer,form = layui.form;;

            layer.confirm('确认返回系统吗？', {btn:['确认'], yes:function(index){
                    //按钮【按钮一】的回调
                    //此处请求后台程序，下方是成功后的前台处理……
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo url("boguan/login/returnSystem"); ?>',

                        success: function(data) {
                            //console.log(data);
                            if (data.errorCode == 1) {

                                //layer.msg(data.msg,{icon: 1})
                                window.location.href= data.url;
                            } else {
                                //  layer.msg(data.msg,{icon: 2})
                            }
                        },
                        error: function (data) {

                            // layer.msg(data.msg,{icon: 2})
                        }
                    });
                    //layer.close(index);
                }});
        })

    }
</script>

<!--first sidebar-->
<!--
<nav class="first_sidebar sidebar-part">
    <div class="sidebar-content">
        <div class="sidebar-fold first_sidebar-unfold">
            <i class="iconfont icon-icon-test"></i>
        </div>
        <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="sidebar-nav">
            <div class="sidebar-title
            <?php if($ctrl == $vo['control_name']): ?>action<?php endif; if($vo['control_name'] == 'Platform.product' && $ctrl == 'Platform.category'): ?>action<?php endif; if($vo['control_name'] == 'Platform.order' && $ctrl == 'Platform.after'): ?>action<?php endif; if($vo['control_name'] == 'Platform.order' && $ctrl == 'Platform.comment'): ?>action<?php endif; if($vo['control_name'] == 'Platform.user' && $ctrl == 'Platform.vip'): ?>action<?php endif; if($vo['control_name'] == 'Platform.market' && $ctrl == 'Platform.coupon'): ?>action<?php endif; if($vo['control_name'] == 'Platform.market' && $ctrl == 'Platform.share'): ?>action<?php endif; if($vo['control_name'] == 'Platform.market' && $ctrl == 'Platform.withdraw'): ?>action<?php endif; if($vo['control_name'] == 'Platform.market' && $ctrl == 'Platform.content'): ?>action<?php endif; if($vo['control_name'] == 'Platform.market' && $ctrl == 'Platform.contentcate'): ?>action<?php endif; if($vo['control_name'] == 'Platform.market' && $ctrl == 'Platform.integral'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.pickpoint'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.freight'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.admin'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.role'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.delivery'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.promise'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.message'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.address'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.printer'): ?>action<?php endif; if($vo['control_name'] == 'Platform.setting' && $ctrl == 'Platform.user' && $act == 'postclerk'): ?>action<?php endif; if($vo['control_name'] == 'Platform.user' && $act == 'postclerk'): ?>action<?php endif; ?>
">
                <a href="<?php echo $vo['url']; ?>">
                    <span class="sidebar-title-icon <?php if($vo['control_name'] != 'Platform.market'): ?>iconfont <?php echo $vo['icon']; endif; ?>">
                        <?php if($vo['control_name'] == 'Platform.market'): ?>
                        <svg class="icon" aria-hidden="true">
                            <use xlink:href="#icon-yingxiao"></use>
                        </svg>
                        <?php endif; ?>
                    </span>
                    <span class="sidebar-title-text"><?php echo $vo['node_name']; ?></span>
                </a>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>


    </div>
</nav>-->
<nav class="first_sidebar sidebar-part">
    <div class="sidebar-content">
        <div class="sidebar-fold first_sidebar-unfold">
            <i class="iconfont icon-icon-test"></i>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-title <?php if($ctrl == 'Platform.index'): ?>action<?php endif; ?>">
                <a href="<?php echo url('boguan/platform.index/index'); ?>">
                    <span class="sidebar-title-icon iconfont icon-shangdian">
                                            </span>
                    <span class="sidebar-title-text">概况</span>
                </a>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-title  <?php if($ctrl == 'Platform.product' || $ctrl == 'Platform.category'): ?>action<?php endif; ?>">
                <a href="<?php echo url('boguan/platform.product/index'); ?>">
                    <span class="sidebar-title-icon iconfont icon-wupin">
                                            </span>
                    <span class="sidebar-title-text">商品</span>
                </a>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-title  <?php if($ctrl == 'Platform.order' || $ctrl == 'Platform.after' || $ctrl == 'Platform.comment'): ?>action<?php endif; ?>">
                <a href="<?php echo url('boguan/platform.order/index'); ?>">
                    <span class="sidebar-title-icon iconfont icon-dingdanliebiao">
                                            </span>
                    <span class="sidebar-title-text">订单</span>
                </a>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-title  <?php if($ctrl == 'Platform.home'): ?>action<?php endif; ?>">
                <a href="<?php echo url('boguan/platform.home/index'); ?>">
                    <span class="sidebar-title-icon iconfont icon-zhuye">
                                            </span>
                    <span class="sidebar-title-text">页面</span>
                </a>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-title  <?php if($ctrl == 'Platform.user' && $act != 'postclerk' || $ctrl == 'Platform.vip'): ?>action<?php endif; ?>">
                <a href="<?php echo url('boguan/platform.user/index'); ?>">
                    <span class="sidebar-title-icon iconfont icon-yonghu">
                                            </span>
                    <span class="sidebar-title-text">用户</span>
                </a>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-title  <?php if($ctrl == 'Platform.market'  || $ctrl == 'Platform.share'  || $ctrl == 'Platform.withdraw'|| $ctrl == 'Platform.content' || $ctrl == 'Platform.contentcate'  || $ctrl == 'Platform.integral' || $ctrl == 'Platform.coupon'): ?>action<?php endif; ?>">
                <a href="<?php echo url('boguan/platform.market/index'); ?>">
                    <span class="sidebar-title-icon ">
                                                <svg class="icon" aria-hidden="true">
                            <use xlink:href="#icon-yingxiao"></use>
                        </svg>
                                            </span>
                    <span class="sidebar-title-text">营销</span>
                </a>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-title  <?php if($ctrl == 'Platform.setting' || $ctrl == 'Platform.admin' || $ctrl == 'Platform.delivery' || $ctrl == 'Platform.freight' || $ctrl == 'Platform.pickpoint' || $ctrl == 'Platform.promise' || $ctrl == 'Platform.message' || $ctrl == 'Platform.official' || $ctrl == 'Platform.printer'): ?>action<?php endif; if($ctrl == 'Platform.user' && $act == 'postclerk'): ?>action<?php endif; ?>">
                <a href="<?php echo url('boguan/platform.setting/index'); ?>">
                    <span class="sidebar-title-icon iconfont icon-shezhi">
                                            </span>
                    <span class="sidebar-title-text">设置</span>
                </a>
            </div>
        </div>


    </div>
</nav>
<link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/toast.style.min.css" rel="stylesheet">

<!--main-body-->
<section class="main-body">
    <div class="main_content">
        <!--second sidebar-->
        <nav class="main_navbar">
    <div class="main_navbar-button">
        <a href="javascript:;" class="middle_center">
            <i class="iconfont icon-richtextoutdent"></i>
        </a>
    </div>
    <div class="main_navbar-nav">
        <div class="navbar-nav-title">
            系统设置
        </div>
        <div class="navbar-nav-nav">
            <ul>
                <li>
                    <a href="<?php echo url('boguan/platform.setting/index'); ?>" <?php if($ctrl == 'Platform.setting' && $act == 'index' || $ctrl == 'Platform.address'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-shezhi"></i>
                    </span>
                        <span class="nav-title">
                      店铺信息
                    </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.setting/general'); ?>" <?php if($ctrl == 'Platform.setting' && $act == 'general'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-shezhi"></i>
                    </span>
                        <span class="nav-title">
                      通用设置
                    </span>
                    </a>
                </li>
                <li class="nav-showchild <?php if($ctrl == 'Platform.setting' && ($act == 'weixin' || $act == 'template')): ?>sidebar-nav-active<?php endif; ?>">
                    <div class="nav-showchild-a">
                    <span class="nav-icon">
                      <i class="iconfont icon-right"></i>
                    </span>
                        <span class="nav-title" title="微信小程序">
                      微信小程序
                    </span>
                    </div>
                    <ul class="sidebar-trans">
                        <li>
                            <a href="<?php echo url('boguan/platform.setting/weixin'); ?>"  <?php if($ctrl == 'Platform.setting' && $act == 'weixin'): ?>class="action"<?php endif; ?>>
                        <span class="nav-icon">
                          <i class="iconfont icon-shezhi"></i>
                        </span>
                                <span class="nav-title">
                          微信配置
                        </span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo url('boguan/platform.setting/template'); ?>" <?php if($ctrl == 'Platform.setting' && $act == 'template'): ?>class="action"<?php endif; ?>>
                        <span class="nav-icon">
                          <i class="iconfont icon-xinxi"></i>
                        </span>
                                <span class="nav-title">
                          模板消息
                        </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-showchild <?php if($ctrl == 'Platform.official' && ($act == 'index' || $act == 'template')): ?>sidebar-nav-active<?php endif; ?>">
                    <div class="nav-showchild-a">
                    <span class="nav-icon">
                      <i class="iconfont icon-right"></i>
                    </span>
                        <span class="nav-title" title="微信公众号">
                      微信公众号
                    </span>
                    </div>
                    <ul class="sidebar-trans">
                        <li>
                            <a href="<?php echo url('boguan/platform.official/index'); ?>"  <?php if($ctrl == 'Platform.official' && $act == 'index'): ?>class="action"<?php endif; ?>>
                            <span class="nav-icon">
                          <i class="iconfont icon-shezhi"></i>
                        </span>
                            <span class="nav-title">
                          公众号配置
                        </span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo url('boguan/platform.official/template'); ?>" <?php if($ctrl == 'Platform.official' && $act == 'template'): ?>class="action"<?php endif; ?>>
                            <span class="nav-icon">
                          <i class="iconfont icon-xinxi"></i>
                        </span>
                            <span class="nav-title">
                          模板消息
                        </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.setting/sms'); ?>" <?php if($ctrl == 'Platform.setting' && $act == 'sms'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-shouji"></i>
                    </span>
                        <span class="nav-title">
                      短信通知
                    </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo url('boguan/platform.setting/email'); ?>" <?php if($ctrl == 'Platform.setting' && $act == 'email'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-youxiang1"></i>
                    </span>
                        <span class="nav-title">
                      邮箱通知
                    </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo url('boguan/platform.pickpoint/index'); ?>" <?php if($ctrl == 'Platform.pickpoint'|| $ctrl == 'Platform.pickpoint' || $ctrl == 'Platform.delivery' || $ctrl == 'Platform.freight'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-huabankaobei-"></i>
                    </span>
                        <span class="nav-title">
                      订单设置
                    </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.promise/index'); ?>" <?php if($ctrl == 'Platform.promise'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-fuwushouquan"></i>
                    </span>
                    <span class="nav-title">
                      服务承诺
                    </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.admin/index'); ?>" <?php if($ctrl == 'Platform.admin' || $ctrl == 'Platform.role'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-renyuan"></i>
                    </span>
                        <span class="nav-title">
                      员工管理
                    </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.message/index'); ?>" <?php if($ctrl == 'Platform.message'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-shijian"></i>
                    </span>
                    <span class="nav-title">
                      消息管理
                    </span>
                    </a>
                </li>

               <li>
                    <a href="<?php echo url('boguan/platform.printer/index'); ?>" <?php if($ctrl == 'Platform.printer'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-daiziti"></i>
                    </span>
                    <span class="nav-title">
                      打印方案
                    </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
        <!--main body content-->
        <div class="main_mbody">
            <div class="col-xs-12">
                <div class="main_mbody-title">
                    <h5>订单设置</h5>
                </div>
                <div class="main-con door_to_door-con city_distribution-con">
                    <form action="">
                        <ul class="nav-contral clearit nav nav-tabs" role="tablist">
                            <li role="presentation" class="nav-tabs-li "><a href="<?php echo url('boguan/platform.pickpoint/index'); ?>">上门提货</a></li>
                            <li role="presentation" class="nav-tabs-li active"><a href="<?php echo url('boguan/platform.delivery/index'); ?>">同城配送</a></li>
                            <li role="presentation" class="nav-tabs-li}"><a href="<?php echo url('boguan/platform.freight/index'); ?>">快递发货</a></li>

                        </ul>
                        <ul class="set-sanji-box">
                            <li>
                                <div class="title"><h5>同城配送功能</h5></div>
                                <div class="promise_control middle_center">
                                    <input type="checkbox" class="switch-main hide"/>
                                </div>
                                <div class="content">
                                    启用后，买家下单可以选择同城配送，由你提供上门配送服务。
                                    <br>
                                    <br>
                                    <!--查看【同城配送】功能使用教程-->
                                </div>
                            </li>
                        </ul>

                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">取货地址</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row" style="max-width:210px;">
                                <div class="massage-box">
                                    <?php if($platform['latitude'] == '' || $platform['latitude'] == ''): ?>无法获取地址信息<a href="<?php echo url('boguan/platform.setting/index'); ?>">去设置</a><?php else: ?><?php echo $platform['address']; endif; ?>

                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-danger">*</span>
                                <span class="text-title">配送方式</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="checkbox-box">
                                    <label class="selct-checkbox-label disabled selected"><input class="selct-checkbox" checked disabled type="checkbox" name="presentation_mode ">商家自配送</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-danger">*</span>
                                <span class="text-title">配送区域设置</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="radio-box">
                                    <label class="radio-checkbox-label disabled selected"><input class="selct-checkbox" checked disabled type="radio" name="kind ">不同距离不同配送费</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">最低起送价</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row" style="max-width:210px;">
                                <input class="control-input" type="text" autocomplete="off" name="min_price" id="min_price" value="<?php echo $delivery['min_price']; ?>">
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">距离商家</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row" style="max-width:750px;">
                                <div class="input-group xitong_order-group">
                                    <input class="control-input" type="text" autocomplete="off" onkeyup="decimalPoint(this)"  name="first_km" id="first_km" value="<?php echo $delivery['first_km']; ?>">
                                    <span class="input-group-addon">公里内</span>
                                    <input class="control-input" type="text" autocomplete="off" onkeyup="decimalPoint(this)" name="first_price" id="first_price" value="<?php echo $delivery['first_price']; ?>">
                                    <span class="input-group-addon">元</span><br>
                                    <span class="input-group-addon">增加</span>
                                    <input class="control-input" type="text" autocomplete="off" onkeyup="decimalPoint(this)" name="second_km" id="second_km" value="<?php echo $delivery['second_km']; ?>">
                                    <span class="input-group-addon">公里</span><br>
                                    <span class="input-group-addon">配送费增加</span>
                                    <input class="control-input" type="text" autocomplete="off" onkeyup="decimalPoint(this)" name="second_price" id="second_price" value="<?php echo $delivery['second_price']; ?>">
                                    <span class="input-group-addon">元</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">配送范围设置</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <!--地图-->
                                <div id="gaodemap"></div>
                                <div class="button-group ditu-button-group">
                                    <input type="button" class="button" value="开始地图编辑" onClick="openEditPolygon();"/>
                                    <input type="button" class="button" style="display: none;" value="地图编辑完成" onClick="closeEditPolygon();"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">定时达</span>
                                <span class="text-danger2">:</span>
                            </label>

                            <div class="col-xs-6 col-sm-8 row">
                                <div class="checkbox-box city_timing">
                                    <label class="selct-checkbox-label <?php if($delivery['is_timing'] == 1): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="checkbox" name="is_timing" id="is_timing" <?php if($delivery['is_timing'] == 1): ?>checked<?php endif; ?>>开启定时达功能</label>
                                </div>
                            </div>
                        </div>

                        <div class="city_timingbox"<?php if($delivery['is_timing'] == 1): ?>style="display:block;"<?php endif; ?> >

                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">配送时段</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="time_quantum-box" data-parent="reception">
                                        <ul>
                                        </ul>
                                        <a href="javascript:;" class="addnew_li">新增时间段</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">时段细分</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="radio-box shangpin_video">

                                        <!-- <br> -->
                                        <label class="radio-checkbox-label <?php if(!$delivery || $delivery['type'] == 1): ?>selected<?php endif; ?>">
                                            <input class="selct-checkbox" type="radio" name="type" value="1" <?php if(!$delivery || $delivery['type'] == 1): ?>checked<?php endif; ?>>半小时
                                        </label>
                                        <label class="radio-checkbox-label <?php if($delivery['type'] == 2): ?>selected<?php endif; ?>">
                                            <input class="selct-checkbox" type="radio" name="type" value="2" <?php if($delivery['type'] == 2): ?>checked<?php endif; ?>>小时
                                        </label>
                                        <label class="radio-checkbox-label <?php if($delivery['type'] == 3): ?>selected<?php endif; ?>">
                                            <input class="selct-checkbox" type="radio" name="type" value="3" <?php if($delivery['type'] == 3): ?>checked<?php endif; ?>>上午下午晚上（12:00和18:00为分界点）
                                        </label>
                                        <label class="radio-checkbox-label <?php if($delivery['type'] == 4): ?>selected<?php endif; ?>">
                                            <input class="selct-checkbox" type="radio" name="type" value="4" <?php if($delivery['type'] == 4): ?>checked<?php endif; ?>>天
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">预约配送</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="radio-box pickup_appointment">
                                        <label class="radio-checkbox-label <?php if(!$delivery || $delivery['advance'] == 0): ?>selected<?php endif; ?>">
                                            <input class="selct-checkbox" type="radio" name="advance" value="0" <?php if(!$delivery || $delivery['advance'] == '0'): ?>checked<?php endif; ?>>无需提前
                                        </label>
                                        <br>
                                        <label class="radio-checkbox-label <?php if($delivery['advance'] == 1): ?>selected<?php endif; ?>">
                                            <input class="selct-checkbox" type="radio" name="advance" value="1"  <?php if($delivery['advance'] == 1): ?>checked<?php endif; ?>>
                                            <span>提前</span>
                                            <div class="input-group">
                                                <select class="control-chosen control-input select-day" data-placeholder="请选择天数" data-value="<?php if($delivery['advance'] == '1'): ?><?php echo $delivery['advance_time']; else: ?>1<?php endif; ?>">
                                                </select>
                                                <span class="input-group-addon">天</span>
                                            </div>
                                        </label>
                                        <br>
                                        <label class="radio-checkbox-label <?php if($delivery['advance'] == 2): ?>selected<?php endif; ?>">
                                            <input class="selct-checkbox" type="radio" name="advance" value="2"  <?php if($delivery['advance'] == 2): ?>checked<?php endif; ?>>
                                            <span>提前</span>
                                            <div class="input-group">
                                                <select class="control-chosen control-input select-hour" data-placeholder="请选择小时" data-value="<?php if($delivery['advance'] == '2'): ?><?php echo $delivery['advance_time']; else: ?>1<?php endif; ?>">
                                                </select>
                                                <span class="input-group-addon">小时</span>
                                            </div>
                                        </label>
                                        <br>
                                        <label class="radio-checkbox-label <?php if($delivery['advance'] == 3): ?>selected<?php endif; ?>">
                                            <input class="selct-checkbox" type="radio" name="advance" value="3"  <?php if($delivery['advance'] == 3): ?>checked<?php endif; ?>>
                                            <span>提前</span>
                                            <div class="input-group">
                                                <input class="control-input" type="number" autocomplete="off" onkeyup="decimalPoint(this)" name="minute" id="minute" value="<?php if($delivery['advance'] == '3'): ?><?php echo $delivery['advance_time']; endif; ?>">
                                                <span class="input-group-addon" style="line-height:18px;">分钟</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">最长预约</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="input-group" style="width:250px;">
                                        <span class="input-group-addon">可预约</span>
                                        <select class="control-chosen control-input select-day2" data-placeholder="请选择天数" data-value="<?php if($delivery['booking_time']): ?><?php echo $delivery['booking_time']; else: ?>1<?php endif; ?>">
                                        </select>
                                        <span class="input-group-addon">天内订单</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="main_mbody-footer">
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                </label>
                                <div class="col-xs-6 col-sm-8 row">
                                    <input type="hidden" name="id" id="id" value="<?php echo $delivery['id']; ?>" />
                                    <input class="btn control-submit" type="submit" value="保存">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        <div class="copyright" style="text-align: center;margin-bottom: 15px;"><?php if(!session('footerleft')): ?>Powered by <a href="http://www.lanrenzhijia.com"><b>微擎</b></a> v<?php echo session('IMS_VERSION'); ?> (c) 2014-2015 <a href="http://www.lanrenzhijia.com">www.lanrenzhijia.com</a><?php else: ?><?php echo session('footerleft'); endif; ?></div>
<?php if(!empty($_W['setting']['copyright']['icp'])): ?><div>备案号：<a href="http://www.miitbeian.gov.cn" target="_blank"><?php echo $_W['setting']['copyright']['icp']; ?></a></div><?php endif; ?>

        </div>
    </div>
</section>
<!--翻页-->

</body>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets///www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/vendor/jquery.min.js"><\/script>')</script>-->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/jquery.min.js"></script>
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/bootstrap.js"></script>
<!--时间插件-->
<link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/datetime/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/datetime/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/datetime/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/ie10-viewport-bug-workaround.js"></script>
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/operating.js"></script>
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/iconfont.js"></script>

<script language="JavaScript" type="text/javascript">
    function clearNoNum(obj) {
        obj.value = obj.value.replace(/[^\d.]/g, "");  //清除“数字”和“.”以外的字符
        obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个. 清除多余的
        obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3');//只能输入两个小数
        if (obj.value.indexOf(".") < 0 && obj.value != "") {
            //以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
            obj.value = parseFloat(obj.value);
        }
    }
</script>
<script>
    function getWxlist(type){
        if (type == 'wxSel'){
            var post_url= '<?php echo url("boguan/base/userList"); ?>';
        } else {
            var post_url= '<?php echo url("boguan/base/officialUserList"); ?>';
        }
        $.ajax({
            type: 'POST',
            url: post_url,
            async: false,
            data: {

            },
            success: function (data) {
                console.log(data);
                if (data){
                     productList= data;

                } else {
                     productList= [];
                }

            },
            error: function (data) {
                console.log(data.responseText);

            }
        });
    }

    function imageUpload() {
        //imgUploadDel();
        var formdata = new FormData();
        // 将文件追加到 formdata对象中。
        formdata.append("image",document.getElementById('file').files[0]);
        console.log(formdata);
        $.ajax({
            type: "post",
            url: "<?php echo url('boguan/base/imgUpload'); ?>",
            dataType:"json",
            contentType: false,
            /**
             * 必须false才会避开jQuery对 formdata 的默认处理
             * XMLHttpRequest会对 formdata 进行正确的处理
             */
            processData: false,

            data: formdata,
            beforeSend:function(){
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;

                    layer.load(1);

                });
            },
            success: function(data) {
                console.log(data);
                if (data.errorCode == 1) {
                    //alert(data.msg);
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;
                        layer.close(layer.index);
                        layer.msg(data.msg, {icon: 1, time:1000}, function(){
                            //window.history.go(-1);location.reload();
                            //window.location=document.referrer;
                            var imageName,imageUrl;
                            imageUrl = data.data.url;
                            imageName = data.data.url.split("/");
                            imageName = imageName[imageName.length-1];
                            var obj={};
                            obj['id'] = data.data.id;
                            obj['name'] = data.data.name;
                            obj['url'] = imageUrl;
                            obj['url_adr'] = data.data.url;
                            imageLib['wedding'].unshift(obj);
                            console.log(imageLib)

                            var obj = iconAll(imageLib);
                            iconPageShow(obj,1,pageDisplayIcon);
                            var pageNavObj = null;//用于储存分页对象
                            pageCou = Math.ceil(obj.length/pageDisplay);
                            pageJson = obj;
                            pageNavObj = new PageNavCreate("PageNavId",{
                                pageCount:pageCou,
                                currentPage:1,
                                perPageNum:5,
                            });
                            pageNavObj.afterClick(pageNavCallBack);
                        });

                    });

                    $('#img_id').val(data.data.id);
                    $('#img_url').val(data.data.url);
                    //window.location.reload()
                } else {
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;;
                        layer.close(layer.index);
                        layer.msg(data.msg, {icon: 2, time:1000});
                    });
                }
            },
            error: function (data) {
                console.log(data.responseText);
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;;
                    layer.close(layer.index);
                    layer.msg(data.msg, {icon: 2, time:1000});
                });
            }
        });
    }
    function imgUploadDel() {
        var protocol = window.location.protocol;
        var host = window.location.host;
        imgUpload_find(protocol, host);
        console.log(imgUpload_find(protocol, host))

        $.each(imgUpload_find(protocol, host), function (i, item) {
            console.log(item)
            var url = item.url;
            var id = item.id;
            $.ajax({
                type: 'POST',
                url: '<?php echo url("boguan/base/imgUploadDel"); ?>',
                data: {
                    'id': id,
                    'url': url
                },
                success: function (data) {
                    console.log(data);
                    if (data.errorCode == 1) {
                        layui.use(['layer', 'form'], function () {
                            var layer = layui.layer, form = layui.form;

                            layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                                $('.icon-lib .icon-show .icon-main li.active').remove();
                              	$('.icon-lib .modal-footer .btn-primary').addClass('disabled');
                            });

                        });

                    } else {
                        //  layer.msg(data.msg,{icon: 2})
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                    //  layer.msg(data.msg,{icon: 2})
                }
            });

        })
    }

    function videoDel(id,url) {

        $.ajax({
            type: 'POST',
            url: '<?php echo url("boguan/base/videoDel"); ?>',
            data: {
                'id': id,
                'url': url
            },
            success: function (data) {
                console.log(data);

            },
            error: function (data) {
                console.log(data.responseText);

            }
        });


    }
    function getVideoList() {

        $.ajax({
            type: 'POST',
            url: '<?php echo url("boguan/base/videoList"); ?>',
            async: false,
            data: {

            },
            success: function (data) {
                console.log(data);
                videoList = data;

            },
            error: function (data) {
                console.log(data.responseText);

            }
        });
    }
    function getImageList() {

        $.ajax({
            type: 'POST',
            url: '<?php echo url("boguan/base/imageList"); ?>',
            async: false,
            data: {

            },
            success: function (data) {
                if (data){

                    var res= data;
                } else {
                    var res= [];
                }
                imageLib={
                    wedding:res,

                };
            },
            error: function (data) {
                console.log(data.responseText);

            }
        });


    }
    function videoUpload() {
        //imgUploadDel();
        var formdata = new FormData();

        console.log(document.getElementById('video').files[0])
        // 将文件追加到 formdata对象中。
        formdata.append("video",document.getElementById('video').files[0]);
        console.log(formdata);
        $.ajax({
            type: "post",
            url: "<?php echo url('boguan/base/videoUpload'); ?>",
            dataType:"json",
            contentType: false,
            /**
             * 必须false才会避开jQuery对 formdata 的默认处理
             * XMLHttpRequest会对 formdata 进行正确的处理
             */
            processData: false,

            data: formdata,
            beforeSend:function(){
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;

                    layer.load(1);

                });
            },
            success: function(data) {
                console.log(data);
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;

                    layer.close(layer.index);

                });
                if (data.errorCode == 1) {
                    //alert(data.msg);


                } else {
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;;

                        layer.msg(data.msg, {icon: 2, time:1000});
                    });
                }
            },
            error: function (data) {
                console.log(data.responseText);
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;;
                    layer.close(layer.index);
                    layer.msg(data.msg, {icon: 2, time:1000});
                });
            }
        });
    }
</script>

</html>

<!--提示弹窗-->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/toast.script.js"></script>
<!--多选插件-->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/chosen.jquery.js"></script>
<script>
    var area= [];
    /*接待时间*/
    var reception= <?php if($delivery['time']): ?><?php echo $delivery['time']; else: ?>[]<?php endif; ?>;

    var  pickup= [];
    $("form").submit(function(e){
        e.preventDefault();//阻止默认提交,表单不写method="post"这个可以不要
        var $parent=$('.time_quantum-box[data-parent=reception]');
        reception = [];
        $parent.children('ul').children('li').each(function(){
            var obj={};
            obj['startTime']=$(this).find('.new_start_time').val();
            obj['endTime']=$(this).find('.new_end_time').val();
            obj['week']=$(this).find('.curr-weeks').text();
            reception.push(obj);
        });
        console.log(reception);
        console.log(area);


        //$("#editor").val(CKEDITOR.instances.content.getData());

        var  id= $('#id').val();
        var  min_price= $('#min_price').val();
        var  first_km= $('#first_km').val();
        var  first_price= $('#first_price').val();
        var  second_km= $('#second_km').val();
        var  second_price= $('#second_price').val();
        var is_timing= $(".checkbox-box input[name=is_timing]:checked").val();
        var type= $(".radio-box input[name=type]:checked").val();
        var advance= $(".radio-box input[name=advance]:checked").val();
        var  hour= $('.select-hour').children('option:selected').val();
        var  day= $('.select-day').children('option:selected').val();
        var minute= $('#minute').val();
        var  booking_time= $('.select-day2').children('option:selected').val();


        console.log(is_timing);
       if (is_timing == 'on'){
           var timing= 1;
       }else {
           var timing= 0;
       }



        $.ajax({
            type: "post",
            url: "<?php echo url('boguan/platform.delivery/index'); ?>",
            //dataType:"json",
            data:{
                "id": id,
                "min_price": min_price,
                "first_km": first_km,
                "first_price": first_price,
                "second_km": second_km,
                "second_price": second_price,
                "time": reception,
                "is_timing": timing,
                "delivery_area": area,
                "type": type,
                "advance": advance,
                "hour": hour,
                "day": day,
                "minute": minute,
                "booking_time": booking_time,
            },

            success: function(data) {
                console.log(data);
                if (data.errorCode == 1) {
                    //alert(data.msg);
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;

                        layer.msg(data.msg, {icon: 1, time:1000}, function(){
                            //window.history.go(-1);location.reload();
                            //window.location=document.referrer;
                        });
                    });

                    //window.location.reload()
                } else {
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;;

                        layer.msg(data.msg, {icon: 2, time:1000});
                    });
                }
            },
            error: function (data) {
                console.log(data.responseText);
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;;

                    layer.msg(data.msg, {icon: 2, time:1000});
                });
            }
        });

    });
    </script>


<!--开关-->
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/switch.js"></script>
<script type="text/javascript">

    var switches = {};
    var switchConfig = {
        'switch-main': {
            checked: <?php if($platform['is_delivery']): ?><?php echo $platform['is_delivery']; else: ?>0<?php endif; ?>,
            showText: true,
            onText: '已开启',
            offText: '已关闭',
            size: 'large',
            onChange: function (i) {
                console.log(i)
                $.ajax({
                    type: "post",
                    url: "<?php echo url('boguan/platform/updateStatus'); ?>",
                    //dataType:"json",
                    data:{
                        "status": i,
                        "type": 'delivery'
                    },

                    success: function(data) {
                        console.log(data);
                        if (data.errorCode == 1) {
                            //alert(data.msg);
                            layui.use(['layer','form'], function(){
                                var layer = layui.layer,form = layui.form;

                                layer.msg(data.msg, {icon: 1, time:1000}, function(){
                                    //window.history.go(-1);location.reload();
                                    //window.location=document.referrer;
                                });
                            });

                            //window.location.reload()
                        } else {
                            layui.use(['layer','form'], function(){
                                var layer = layui.layer,form = layui.form;;

                                layer.msg(data.msg, {icon: 2, time:1000});
                            });
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                        layui.use(['layer','form'], function(){
                            var layer = layui.layer,form = layui.form;;

                            layer.msg(data.msg, {icon: 2, time:1000});
                        });
                    }
                });
            }
        }
    };

    Object.keys(switchConfig).forEach(function (key) {
        switches[key] = new Switch(document.querySelector('.' + key),switchConfig[key]);
    });

</script>
<!--地图-->
<script src="https://webapi.amap.com/maps?v=1.3&key=688104374a9d33b2a48817d3618ec607&plugin=AMap.PolyEditor"></script>
<script type="text/javascript" src="https://cache.amap.com/lbs/static/addToolbar.js"></script>
<script>

    var defalult_lng= '116.403981';
    var defalult_lat= '39.915544';
    var center_lnglat = new AMap.LngLat(<?php if($platform['longitude']): ?><?php echo $platform['longitude']; if($platform['latitude']): ?>,<?php echo $platform['latitude']; endif; else: ?>116.403981,39.915544<?php endif; ?>);//店铺地址设置
    var editorTool, map = new AMap.Map("gaodemap",{
        resizeEnable: true,
        center: [center_lnglat.lng,center_lnglat.lat],
        zoom: 13//地图显示的缩放级别
    });
    //标识中心点
    var centerMarker = new AMap.Marker({
        position: [center_lnglat.lng,center_lnglat.lat],
        icon: new AMap.Icon({
            size: new AMap.Size(40, 50),  //图标大小
            image: "//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/way_btn2.png",
            imageOffset: new AMap.Pixel(0, -60)
        }),
        offset:new AMap.Pixel(-19, -40)
    });
    centerMarker.setMap(map);

    var beginNum = 0;
    var clickListener;
    var beginPoints;
    var beginMarks;
    var polygonEditor;
    var resPolygon = [];
    var editor =[];
    var resNum = 0;
    var userMarks=[<?php echo $platform['longitude']; if($platform['latitude']): ?>,<?php echo $platform['latitude']; endif; ?>];

    var str =<?php if($delivery['delivery_area']): ?><?php echo $delivery['delivery_area']; else: ?>
        [
            {"lng":center_lnglat.lng-0.02,"lat":center_lnglat.lat+0.02},
            {"lng":center_lnglat.lng+0.02,"lat":center_lnglat.lat+0.02},
            {"lng":center_lnglat.lng+0.02,"lat":center_lnglat.lat-0.02},
            {"lng":center_lnglat.lng-0.02,"lat":center_lnglat.lat-0.02}
        ]<?php endif; ?>;
    area= str;
    var arr = json2arr(str);
    createPolygon(arr);

    //第一次画距离
    $.each(arr,function(idx,obj){
        new AMap.Polyline({
            map:map,
            strokeColor:'red',
            path:[center_lnglat,obj]
        });
        console.log(obj)

        var marker = new AMap.Marker({
            icon:'',
            position: obj,
        });
        marker.setMap(map);
        // 设置鼠标划过点标记显示的文字提示
        marker.setTitle('我是marker的title');

        // 设置label标签
        marker.setLabel();
    })
    function mapOnClick(e) {
        // document.getElementById("lnglat").value = e.lnglat.getLng() + ',' + e.lnglat.getLat()
        beginMarks.push(addMarker(e.lnglat));
        beginPoints.push(e.lnglat);
        beginNum++;
        if (beginNum == 3) {
            AMap.event.removeListener(clickListener);
            var polygon = createPolygon(beginPoints);
            polygonEditor = createEditor(polygon);
            clearMarks();
        }
    }
    function createPolygon(arr) {
        var polygon = new AMap.Polygon({
            map: map,
            path: arr,
            strokeColor: "#0000ff",
            strokeOpacity: 1,
            strokeWeight: 3,
            fillColor: "#f5deb3",
            fillOpacity: 0.35
        });
        return polygon;
    }
    function createEditor(polygon) {
        var polygonEditor = new AMap.PolyEditor(map,polygon);
        polygonEditor.open();
        AMap.event.addListener(polygonEditor, 'end', polygonEnd);
        return polygonEditor;

    }
    function openEditPolygon(e) {
        //清除地图覆盖物
        map.clearMap();

        //标识中心点
        var centerMarker = new AMap.Marker({
            position: [116.403542,39.896882],
            icon: new AMap.Icon({
                size: new AMap.Size(40, 50),  //图标大小
                image: "//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/way_btn2.png",
                imageOffset: new AMap.Pixel(0, -60)
            }),
            offset:new AMap.Pixel(-19, -40)
        });
        centerMarker.setMap(map);

        AMap.event.removeListener(clickListener);
        var polygon = createPolygon(arr);
        polygonEditor = createEditor(polygon);

        polygonEditor.open();

    }
    function closeEditPolygon() {

        area= [];
        polygonEditor.close();
        $.each(editor,function(idx,obj){
            new AMap.Polyline({
                map:map,
                strokeColor:'red',
                path:[center_lnglat,obj]
            });
            var areaObj ={};
            areaObj['lat']= obj['lat'];
            areaObj['lng']= obj['lng'];
            area.push(areaObj);

            console.log(area)

            var marker = new AMap.Marker({
                icon:'',
                position: obj,
            });
            marker.setMap(map);
            // 设置鼠标划过点标记显示的文字提示
            marker.setTitle('我是marker的title');

            // 设置label标签
            marker.setLabel();
        })
    }
    function polygonEnd(res) {
        resPolygon.push(res.target);
        console.log(resPolygon[resNum].contains(userMarks));
        appendHideHtml(resNum, res.target.getPath());
        //多个多边形编辑
        // resNum++;
        // init();
    }
    function appendHideHtml(index, arr) {
        var strify = JSON.stringify(arr);
        var html = '<input type="hidden" id="index' + index + '" name="paths[]" value="' + strify + '">';
        $('body').append(html);
        console.log(html);
        editor = arr;
    }
    function clearMarks() {
        map.remove(beginMarks);
    }
    function json2arr(json){
        var arr = json;
        var res = [];
        for (var i = 0; i < arr.length; i++) {
            var line = [];
            line.push(arr[i].lng);
            line.push(arr[i].lat);
            res.push(line);
        };
        return res;
    }
</script>

