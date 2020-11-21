<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:94:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/share/setting.html";i:1553776202;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/header.html";i:1554254463;s:94:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/pub/share-nav.html";i:1553589071;s:88:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/copyright.html";i:1553776206;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/footer.html";i:1554254463;}*/ ?>
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
            <div class="sidebar-title  <?php if($ctrl == 'Platform.user' && $act != 'postclerk'): ?>action<?php endif; ?>">
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
            <div class="sidebar-title  <?php if($ctrl == 'Platform.setting' || $ctrl == 'Platform.admin' || $ctrl == 'Platform.delivery' || $ctrl == 'Platform.freight' || $ctrl == 'Platform.pickpoint' || $ctrl == 'Platform.promise' || $ctrl == 'Platform.message'): ?>action<?php endif; if($ctrl == 'Platform.user' && $act == 'postclerk'): ?>action<?php endif; ?>">
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
            推广员
        </div>
        <div class="navbar-nav-nav">
            <ul>

                <li>
                    <a href="<?php echo url('boguan/platform.share/index'); ?>" <?php if($ctrl == 'Platform.share' && $act == 'index'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-zuanshi"></i>
                    </span>
                        <span class="nav-title">
                      分销商列表
                    </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo url('boguan/platform.withdraw/index'); ?>"<?php if($ctrl == 'Platform.withdraw'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-libao"></i>
                    </span>
                        <span class="nav-title">
                      提现列表
                    </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo url('boguan/platform.share/order'); ?>" <?php if($ctrl == 'Platform.share' && $act == 'order'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-dingdan"></i>
                    </span>
                        <span class="nav-title">
                      分销订单
                    </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo url('boguan/platform.share/setting'); ?>" <?php if($ctrl == 'Platform.share' && $act == 'setting'): ?>class="action"<?php endif; ?>">
                    <span class="nav-icon">
                      <i class="iconfont icon-shezhi"></i>
                    </span>
                        <span class="nav-title">
                      分销设置
                    </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo url('boguan/platform.share/poster'); ?>" <?php if($ctrl == 'Platform.share' && $act == 'poster'): ?>class="action"<?php endif; ?>">
                    <span class="nav-icon">
                      <i class="iconfont icon-tupian"></i>
                    </span>
                        <span class="nav-title">
                      分销海报
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
                    <h5>分销设置</h5>
                </div>
                <div class="main-con set-sanji">
                    <form action="">
                        <ul class="set-sanji-box">
                            <li class="clearit">
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-danger">*</span>
                                        <span class="text-title">开启分销功能</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box" style="padding-top: 2px;">
                                        <input type="checkbox" class="switch-state hide" />
                                        <input type="hidden" name="switch" id="switch" value="<?php echo $setting['switch']; ?>"/>
                                    </div>
                                </div>
                            </li>
                            <li class="clearit">
                                <div class="title"><h5>佣金设置</h5></div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-danger">*</span>
                                        <span class="text-title">分销商名称</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <input class="control-input" type="text" autocomplete="off" name="name" id="name" value="<?php echo $setting['name']; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-title">分销层级</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <div class="radio-box set-level">
                                            <label class="radio-checkbox-label <?php if($setting['level']): if($setting['level'] == 1): ?>selected<?php endif; else: ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="level" value="1" <?php if($setting['level']): if($setting['level'] == 1): ?>checked<?php endif; else: ?>checked<?php endif; ?>>一级分销</label>
                                            <label class="radio-checkbox-label <?php if($setting['level'] == 2): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="level" value="2" <?php if($setting['level'] == 2): ?>checked<?php endif; ?>>二级分销</label>
                                            <label class="radio-checkbox-label <?php if($setting['level'] == 3): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="level" value="3" <?php if($setting['level'] == 3): ?>checked<?php endif; ?>>三级分销</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="radio-show <?php if($setting['scale_type']): if($setting['scale_type'] == 1): ?>set-type2<?php else: ?>set-type1<?php endif; else: ?>set-type2<?php endif; ?>" style="display: block">
                                    <div class="form-group col-xs-12 row">
                                        <label class="control-label col-xs-6 col-sm-4">
                                            <span class="text-title">分销佣金类型</span>
                                            <span class="text-danger2">:</span>
                                        </label>
                                        <div class="col-xs-6 col-sm-8 row input_box">
                                            <div class="radio-box set-type">
                                                <label class="radio-checkbox-label <?php if($setting['scale_type']): if($setting['scale_type'] == 1): ?>selected<?php endif; else: ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="scale_type" value="false" <?php if($setting['scale_type']): if($setting['scale_type'] == 1): ?>checked<?php endif; else: ?>checked<?php endif; ?>>固定金额</label>
                                                <label class="radio-checkbox-label <?php if($setting['scale_type'] == 2): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="scale_type" value="true" <?php if($setting['scale_type'] == 2): ?>checked<?php endif; ?>>百分比</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 row radio-show-box" <?php if($setting['level']): if($setting['level'] >= 1): ?>style="display: block"<?php endif; else: ?>style="display: block"<?php endif; ?>>
                                        <label class="control-label col-xs-6 col-sm-4">
                                            <span class="text-danger">*</span>
                                            <span class="text-title">一级分销商比例</span>
                                            <span class="text-danger2">:</span>
                                        </label>
                                        <div class="col-xs-6 col-sm-8 row input_box">
                                            <div class="input-group">
                                                <div class="input-group-addon addon2">￥</div>
                                                <input class="control-input" type="text" autocomplete="off" name="first_scale" id="first_scale" value="<?php echo $setting['first_scale']; ?>">
                                                <div class="input-group-addon addon1">%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 row radio-show-box" <?php if($setting['level'] >= 2): ?>style="display: block"<?php endif; ?>>
                                        <label class="control-label col-xs-6 col-sm-4">
                                            <span class="text-danger">*</span>
                                            <span class="text-title">二级分销商比例</span>
                                            <span class="text-danger2">:</span>
                                        </label>
                                        <div class="col-xs-6 col-sm-8 row input_box">
                                            <div class="input-group">
                                                <div class="input-group-addon addon2">￥</div>
                                                <input class="control-input" type="text" autocomplete="off" name="second_scale" id="second_scale" value="<?php echo $setting['second_scale']; ?>">
                                                <div class="input-group-addon addon1">%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12 row radio-show-box" <?php if($setting['level'] == 3): ?>style="display: block"<?php endif; ?>>
                                        <label class="control-label col-xs-6 col-sm-4">
                                            <span class="text-danger">*</span>
                                            <span class="text-title">三级分销商比例</span>
                                            <span class="text-danger2">:</span>
                                        </label>
                                        <div class="col-xs-6 col-sm-8 row input_box">
                                            <div class="input-group">
                                                <div class="input-group-addon addon2">￥</div>
                                                <input class="control-input" type="text" autocomplete="off" name="third_scale" id="third_scale" value="<?php echo $setting['third_scale']; ?>">
                                                <div class="input-group-addon addon1">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="clearit">
                                <div class="title"><h5>条件设置</h5></div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-title">成为下线条件</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <div class="radio-box">
                                            <label class="radio-checkbox-label <?php if($setting['subordinate_condition']): if($setting['subordinate_condition'] == 1): ?>selected<?php endif; else: ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="subordinate_condition" value="1" <?php if($setting['subordinate_condition']): if($setting['subordinate_condition'] == 1): ?>checked<?php endif; else: ?>checked<?php endif; ?>>首次点击分享链接</label>
                                            <label class="radio-checkbox-label <?php if($setting['subordinate_condition'] == 2): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="subordinate_condition" value="2" <?php if($setting['subordinate_condition'] == 2): ?>checked<?php endif; ?>>首次下单</label>
                                            <label class="radio-checkbox-label <?php if($setting['subordinate_condition'] == 3): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="subordinate_condition" value="3" <?php if($setting['subordinate_condition'] == 3): ?>checked<?php endif; ?>>首次付款</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-title">成为分销商条件</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <div class="radio-box sanji_term1">
                                            <label class="radio-checkbox-label <?php if($setting['distributor_condition']): if($setting['distributor_condition'] == 1): ?>selected<?php endif; else: ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="distributor_condition" value="1" <?php if($setting['distributor_condition']): if($setting['distributor_condition'] == 1): ?>checked<?php endif; else: ?>checked<?php endif; ?>>申请即通过</label>
                                            <label class="radio-checkbox-label <?php if($setting['distributor_condition'] == 2): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="distributor_condition" value="2" <?php if($setting['distributor_condition'] == 2): ?>checked<?php endif; ?>>申请需审核</label>
                                            <label class="radio-checkbox-label <?php if($setting['distributor_condition'] == 3): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="distributor_condition" value="3" <?php if($setting['distributor_condition'] == 3): ?>checked<?php endif; ?> data-msg="次">消费次数</label>
                                            <label class="radio-checkbox-label <?php if($setting['distributor_condition'] == 4): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="radio" name="distributor_condition" value="4" <?php if($setting['distributor_condition'] == 4): ?>checked<?php endif; ?> data-msg="金额">消费金额</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="term-show" <?php if($setting['distributor_condition'] == 3 || $setting['distributor_condition'] == 4): ?>style="display:block;"<?php endif; ?>>
                                    <div class="form-group col-xs-12 row">
                                        <label class="control-label col-sm-4">
                                        </label>
                                        <div class="col-xs-12 col-sm-8 row">
                                            <div class="input-group">
                                                <div class="input-group-addon">消费达到</div>
                                                <input class="control-input" type="text" autocomplete="off"  name="condition" id="condition" value="<?php echo $setting['condition']; ?>">
                                                <div class="input-group-addon addon-msg"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="clearit">
                                <div class="title"><h5>基础设置</h5></div>
                                <!-- <div class="form-group col-xs-12 row">
                                  <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">推广海报图</span>
                                    <span class="text-danger2">:</span>
                                  </label>
                                  <div class="col-xs-6 col-sm-8 row">
                                    <a href="javascript:;" class="share_posters"  onclick="sharePosters(this)" data-toggle="modal" data-target=".share_posters-modal"><span class="label label-primary">修改</span></a>
                                  </div>
                                </div> -->
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-danger">*</span>
                                        <span class="text-title">提现方式</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <div class="checkbox-box withdraw_type">
                                            <label class="selct-checkbox-label <?php if(in_array(1,$setting['withdraw_type'])): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="checkbox" name="withdraw_type" value="1" <?php if(in_array(1,$setting['withdraw_type'])): ?>checked<?php endif; ?>>微信</label>
                                            <label class="selct-checkbox-label <?php if(in_array(2,$setting['withdraw_type'])): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="checkbox" name="withdraw_type" value="2" <?php if(in_array(2,$setting['withdraw_type'])): ?>checked<?php endif; ?>>支付宝</label>
                                            <label class="selct-checkbox-label <?php if(in_array(3,$setting['withdraw_type'])): ?>selected<?php endif; ?>"><input class="selct-checkbox" type="checkbox" name="withdraw_type" value="3" <?php if(in_array(3,$setting['withdraw_type'])): ?>checked<?php endif; ?>>银行卡</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-danger">*</span>
                                        <span class="text-title">最少提现额度</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <div class="input-group">
                                            <div class="input-group-addon">￥</div>
                                            <input class="control-input" type="text" autocomplete="off" name="min_withdraw" id="min_withdraw" value="<?php echo $setting['min_withdraw']; ?>" data-minvalue="1" onkeyup="decimalPointLimit(this)">
                                        </div><span class="control-tips">注意：最少提现额度不能小于1元</span>

                                    </div>
                                </div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-danger">*</span>
                                        <span class="text-title">每日提现上限</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <div class="input-group">
                                            <div class="input-group-addon">￥</div>
                                            <input class="control-input" type="text" autocomplete="off"  name="day_withdraw" id="day_withdraw" value="<?php echo $setting['day_withdraw']; ?>">
                                        </div>
                                        <span class="control-tips">注意：0元表示不限制</span>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-title">用户须知</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <div class="control-box">
                                            <textarea class="control-input control-textarea" rows="5" name="notice" id="notice"><?php echo $setting['notice']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-title">申请协议</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <div class="control-box">
                                            <textarea class="control-input control-textarea" rows="5" name="agree" id="agree"><?php echo $setting['agree']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="clearit">
                                <div class="title"><h5>背景图片</h5></div>
                                <div class="form-group col-xs-12 row">
                                    <label class="control-label col-xs-6 col-sm-4">
                                        <span class="text-title">申请页面</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="col-xs-6 col-sm-8 row input_box">
                                        <ul class="pro-img" data-maxvalue="1">
                                        </ul>
                                        <a href="javascript:;" class="pro-img-add" onclick="iconLibrary(this)" data-laymodal="product_img" data-toggle="modal" data-target=".icon-lib">
                                            <img src="<?php if(checkImage($setting['apply_image'])): ?><?php echo $setting['apply_image']; else: ?>//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/default_add.png<?php endif; ?>" ondragstart="return false" alt="" title=""></a>
                                        <div class="clearit"></div>
                                    </div>
                                </div>

                            </li>


                        </ul>
                        <div class="main_mbody-footer">
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-3">
                                </label>
                                <div class="col-xs-6 col-sm-9 row">
                                    <input type="hidden" name="id" id="id" value="<?php echo $setting['id']; ?>" />
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
    </div>
</section>

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

<!--翻页-->
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/pageNav.js"></script>
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/toast.script.js"></script>
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/switch.js"></script>
<script>
    var product_img;
    //console.log(product_img);

    //实例化编辑器
    //图标库
    var iconLib={};
    var imageLib={
        wedding:<?php if($imageList != ''): ?><?php echo $imageList; else: ?>[]<?php endif; ?>,

    };
    var imageLibCE={wedding:'婚礼',ktv:'KTV',ktv2:'KTV2'};

</script>
<script>

    var switches = {};
    var switchConfig = {
        'switch-state': {
            checked: <?php if($setting): ?><?php echo $setting['switch']; else: ?>0<?php endif; ?>,
            showText: true,
            onText: '开启',
            offText: '关闭',
            onChange: function (i) {
                console.log(i)
                if (i == true){
                    $('#switch').val(1);
                }else {
                    $('#switch').val(0);
                }
            }
        }
    };

    Object.keys(switchConfig).forEach(function (key) {
        switches[key] = new Switch(document.querySelector('.' + key),switchConfig[key]);
    });

    var saveJson=[
        {
            id:'posters',
            link:'',
            width:'423',
            top:'523',
            left:'163',
        },
    ];
</script>
<script>
    $("form").submit(function(e){
        e.preventDefault();//阻止默认提交,表单不写method="post"这个可以不要
        //$("#editor").val(CKEDITOR.instances.content.getData());
//获取form表单中所提交 的内容
        var d = {};
        var t = $('form').serializeArray();
        $.each(t, function() {
            d[this.name] = this.value;
        });

        var select = document.getElementsByName("withdraw_type");
        var str = [];
        for(i=0;i<select.length;i++){
            if(select[i].checked){
                str.push(select[i].value);
            }
        }
        //var vals = str.join(",");
        var  image= $('.pro-img li img').attr('src');


        $.ajax({
            type: "post",
            url: "<?php echo url('boguan/platform.share/setting'); ?>",
            //dataType:"json",
            data:{
                'data': d,
                'withdraw_type': str,
                'apply_image': image
            },
            success: function(data) {
                console.log(data);
                if (data.errorCode == 1) {
                    //alert(data.msg);
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;

                        layer.msg(data.msg, {icon: 1, time:1000}, function(){
                            //window.history.go(-1);location.reload();
                           // window.location=document.referrer;

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