<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:91:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/coupon/add.html";i:1553589107;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/header.html";i:1554254463;s:88:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/copyright.html";i:1553776206;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/footer.html";i:1554254463;}*/ ?>
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
<!--多选-->
<link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/component-chosen.min.css" rel="stylesheet">
<link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/toast.style.min.css" rel="stylesheet">
<!--main-body-->
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
                    营销中心
                </div>
                <div class="navbar-nav-nav">
                    <ul>
                        <li>
                            <a href="<?php echo url('boguan/platform.coupon/index'); ?>" class="action">
                    <span class="nav-icon">
                      <i class="iconfont icon-youhuiquan"></i>
                    </span>
                                <span class="nav-title">
                      优惠券
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
                    <h5>新增优惠券</h5>
                    <a href="javascript:history.go(-1)" class="goback"><span class="label label-info btn"><i class="iconfont icon-zuojiantou"></i>返回</span></a>
                </div>
                <div class="main-con coupons-con">
                    <form class="avatar-form" action="" enctype="multipart/form-data" method="post">

                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-danger">*</span>
                                <span class="text-title">优惠券名称</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row input_box">
                                <input class="control-input" type="text" autocomplete="off" name="name" id="name">
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-danger">*</span>
                                <span class="text-title">生成数量</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="radio-box radio-control">
                                    <label class="radio-checkbox-label selected"><input class="selct-checkbox" type="radio" checked name="sum_type" value="0">不限制</label>
                                    <label class="radio-checkbox-label"><input class="selct-checkbox" type="radio" name="sum_type" value="1">限制</label>
                                </div>
                                <div class="radio-related">
                                    <div class="superform_times-box" data-stylediy="true">
                                    </div>
                                    <div class="superform_times-box" data-stylediy="false">
                                        <div class="input-group" style="max-width: 210px;margin:10px 0;">
                                            <input class="control-input" type="text" autocomplete="off" name="sum" value="1" onkeyup="superformInput(this,&quot;positiveInteger&quot;)">
                                            <span class="input-group-addon">
                            张
                          </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-danger">*</span>
                                <span class="text-title">优惠类型</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="radio-box radio-control">
                                    <label class="radio-checkbox-label selected"><input class="selct-checkbox" type="radio" checked name="type" value="1">减价</label>
                                    <label class="radio-checkbox-label"><input class="selct-checkbox" type="radio" name="type" value="2">打折</label>
                                </div>
                                <div class="radio-related">
                                    <div class="superform_times-box" data-stylediy="true">
                                        <div class="input-group" style="max-width: 210px;margin:10px 0;">
                          <span class="input-group-addon">
                            减免
                          </span>
                                            <input class="control-input add_daytimes" type="text" autocomplete="off" name="sub_price" id="sub_price" value="" placeholder="请输入正数" onkeyup="positiveInteger(this)">
                                            <span class="input-group-addon">
                            元
                          </span>
                                        </div>
                                    </div>
                                    <div class="superform_times-box" data-stylediy="false">
                                        <div class="input-group" style="max-width: 210px;margin:10px 0;">
                                            <input class="control-input add_daytimes" type="text" autocomplete="off" name="discount" id="discount" placeholder="请输入正数" data-maxvalue="9.9" data-minvalue="1" onkeyup="decimalPointLimit_coupon(this)">
                                            <span class="input-group-addon">折</span>

                                        </div>
                                        <span class="control-tips">折扣数大于等于1, 且最大不能超过9.9</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-danger">*</span>
                                <span class="text-title">使用门槛</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="radio-box radio-control">
                                    <label class="radio-checkbox-label selected"><input class="selct-checkbox" type="radio" checked name="min_price_type" value="true">不限制</label>
                                    <label class="radio-checkbox-label"><input class="selct-checkbox" type="radio" name="min_price_type" value="false">满减条件</label>
                                </div>
                                <div class="radio-related">
                                    <div class="superform_times-box" data-stylediy="true"></div>
                                    <div class="superform_times-box" data-stylediy="false">
                                        <div class="input-group" style="max-width: 210px;margin:10px 0;">
                          <span class="input-group-addon">
                            满
                          </span>
                                            <input class="control-input add_daytimes" type="text" autocomplete="off" name="min_price" value="" placeholder="请输入正数" onkeyup="superformInput(this,&quot;decimalPoint&quot;)">
                                            <span class="input-group-addon">
                            元
                          </span>
                                        </div>
                                        <span class="control-tips">除去运费</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-danger">*</span>
                                <span class="text-title">使用有效期</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="radio-box radio-control">

                                    <label class="radio-checkbox-label selected"><input class="selct-checkbox" type="radio" name="expire_type" checked value="2">指定天数有效</label>
                                    <label class="radio-checkbox-label"><input class="selct-checkbox" type="radio" name="expire_type" value="1">固定范围</label>
                                </div>
                                <div class="radio-related">
                                    <div class="superform_times-box" data-stylediy="true">
                                        <div class="input-group" style="max-width: 210px;margin:10px 0;">
                          <span class="input-group-addon">
                            领取后
                          </span>
                                            <input class="control-input add_daytimes" type="text" autocomplete="off" name="days" value="" placeholder="请输入正数" onkeyup="positiveInteger(this)">
                                            <span class="input-group-addon">
                            天有效
                          </span>
                                        </div>

                                    </div>
                                    <div class="superform_times-box" data-stylediy="false">
                                        <div class="input-daterange input-group" id="datepicker" style="margin-top: 10px;">
                                            <input type="text" class="form-control" name="start_time" id="new_start_time">
                                            <span class="input-group-addon">至</span>
                                            <input type="text" class="form-control" name="end_time" id="new_end_time">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">活动范围</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="radio-box radio-control">
                                    <label class="radio-checkbox-label selected"><input class="selct-checkbox" type="radio" checked name="apply" value="0">全店参与</label>
                                    <label class="radio-checkbox-label"><input class="selct-checkbox" type="radio" name="apply" value="2">自选商品</label>
                                    <label class="radio-checkbox-label"><input class="selct-checkbox" type="radio" name="apply" value="1">选择分类</label>
                                </div>
                                <div class="radio-related">
                                    <div class="superform_times-box" data-stylediy="true"></div>
                                    <div class="superform_times-box" data-stylediy="">
                                        <div class="massage-box input_box" data-parent="proBox" data-prostyle="couponsSel" data-pagenav="pageNavBasis" data-pagenavtype="couponsSel">
                                            <input class="btn control-add" id="lay_imgAdd" type="button" value="添加商品" data-toggle="modal" data-target=".service-select-modal" onclick="proSelection(this)">
                                            <div class="activity-pro pro-more-table" data-limit="" data-target="proBox" style="display:none;margin-top:15px">
                                                <div class="main-table table-responsive">
                                                    <table class="table table-hover table-condensed">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 80%;">商品名称</th>
                                                            <th style="width: 20%;">操作</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <!-- <tr>
                                                          <td class="sanji-pro min-pro">
                                                            <ul>
                                                              <li data-toggle="tooltip" data-placement="top" title="" data-original-title="原创2017欧美风保暖黄绿拼色棉衣外套宽松大码长款大口袋棉服冬新">
                                                                <div class="min-img"><img src="images/img01.jpg" ondragstart="return false" alt="" title=""></div>
                                                                <div class="min-title">
                                                                  <div class="name"><span>原创2017欧美风保暖黄绿拼色棉衣外套宽松大码长款大口袋棉服冬新</span></div>
                                                                  <div class="guige">规格：<span>默认</span></div>
                                                                </div>
                                                              </li>
                                                            </ul>
                                                          </td>
                                                          <td>
                                                              <a href="javascript:;" onclick="deleteit(this)" class="table-a">删除</a>
                                                          </td>
                                                        </tr> -->
                                                        </tbody>
                                                        <tfoot>
                                                          <tr>
                                                            <td colspan="2" style="text-align: left;">
                                                              <div class="pull-right page-box">
                                                                  <nav aria-label="Page navigation"class="page-nav-outer"id="PageNavId_basis"></nav>
                                                              </div>
                                                            </td>
                                                          </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="superform_times-box" data-stylediy="">
                                        <div class="massage-box input_box">
                                            <select class="control-chosen control-input" data-placeholder="请选择分类" data-value="" multiple id="cate_id" name="cate_id">
                                                <option></option>
                                                <?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                                <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                                                    <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $k = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>
                                                <option value="<?php echo $v['id']; ?>"><?php if(count($vo['child']) == $k): ?>&nbsp;&nbsp;&nbsp;└─ <?php echo $v['name']; else: ?>&nbsp;&nbsp;&nbsp;├─ <?php echo $v['name']; endif; ?></option>
                                                        <?php if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $kk = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($kk % 2 );++$kk;?>

                                                <option value="<?php echo $vv['id']; ?>"><?php if(count($v['child']) == $kk): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─ <?php echo $vv['name']; else: ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─ <?php echo $vv['name']; endif; ?></option>

                                                        <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">每人领取限制</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="radio-box radio-control">
                                    <label class="radio-checkbox-label selected"><input class="selct-checkbox" type="radio" checked name="receive_limit" value="false">不设限</label>
                                    <label class="radio-checkbox-label"><input class="selct-checkbox" type="radio" name="receive_limit" value="true">限制</label>
                                </div>
                                <div class="radio-related">
                                    <div class="superform_times-box" data-stylediy="true"></div>
                                    <div class="superform_times-box" data-stylediy="false">
                                        <div class="input-group" style="max-width: 210px;margin:10px 0;">
                                            <input class="control-input add_daytimes" type="text" autocomplete="off" name="receive_num" value="" placeholder="请输入正数" onkeyup="positiveInteger(this)">
                                            <span class="input-group-addon">
                            张
                          </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">是否加入领券中心</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row">
                                <div class="radio-box set-type">
                                    <label class="radio-checkbox-label"><input class="selct-checkbox" type="radio" name="is_join" value="1">是</label>
                                    <label class="radio-checkbox-label selected"><input class="selct-checkbox" type="radio" name="is_join" checked value="0">否</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 row">
                            <label class="control-label col-xs-6 col-sm-4">
                                <span class="text-title">使用须知</span>
                                <span class="text-danger2">:</span>
                            </label>
                            <div class="col-xs-6 col-sm-8 row input_box">
                                <textarea class="control-input control-textarea input_box" style="height: 80px;" placeholder="建议填写券的优惠规则、领取门槛及使用门槛，如不填写则不会在小程序中显示" name="remark"></textarea>
                            </div>
                        </div>

                        <div class="main_mbody-footer">
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4"></label>
                                <div class="col-xs-6 col-sm-8 row">
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

<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/pageNav.js"></script>
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/chosen.jquery.js"></script>
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/toast.script.js"></script>
<script>
    var productList=<?php if(!empty($productList) || $productList != ''): ?><?php echo $productList; else: ?>[]<?php endif; ?>;

    var productListCE=<?php if(!empty($categoryList) || $categoryList != ''): ?><?php echo $categoryList; else: ?>[]<?php endif; ?>;
            proListChange(productListCE);
    var productSel=[];
    $(function () {
        /*$('#member-birthday').datetimepicker({
            locale: moment.locale('zh-cn'),
            viewMode: 'years',
            format: 'YYYY-MM-DD'
        });*/


        //多选
        $('.control-chosen').chosen({
            allow_single_deselect: true
        });
    });
    $("form").submit(function(e){
        e.preventDefault();//阻止默认提交,表单不写method="post"这个可以不要
        //$("#editor").val(CKEDITOR.instances.content.getData());
//获取form表单中所提交 的内容
        var d = {};
        var t = $('form').serializeArray();
        $.each(t, function() {
            d[this.name] = this.value;
        });

        var select = document.getElementById("cate_id");
        var str = [];
        for(i=0;i<select.length;i++){
            if(select.options[i].selected){
                str.push(select[i].value);
            }
        }

        $.ajax({
            type: "post",
            url: "<?php echo url('boguan/platform.coupon/add'); ?>",
            //dataType:"json",
            data:{
                'data': d,
                'product': productSel,
                'cateId': str
            },
            success: function(data) {
                console.log(data);
                if (data.errorCode == 1) {
                    //alert(data.msg);
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;

                        layer.msg(data.msg, {icon: 1, time:1000}, function(){
                            //window.history.go(-1);location.reload();
                            window.location=document.referrer;

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
    /*删除*/
    function del(id,key){

        layui.use(['layer','form'], function(){
            var layer = layui.layer,form = layui.form;;

            layer.confirm('确认删除吗？', {btn:['确认'], yes:function(index){
                    //按钮【按钮一】的回调
                    //此处请求后台程序，下方是成功后的前台处理……
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo url("boguan/platform.pickpoint/del"); ?>',
                        data:{'id':id},
                        success: function(data) {
                            console.log(data);
                            if (data.errorCode == 1) {

                                layer.msg(data.msg,{icon: 1})
                                $('.'+key).remove();
                            } else {
                                layer.msg(data.msg,{icon: 2})
                            }
                        },
                        error: function (data) {
                            console.log(data.responseText);
                            layer.msg(data.msg,{icon: 2})
                        }
                    });
                    layer.close(index);
                }});
        })

    }

</script>

