<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:92:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/order/index.html";i:1553589089;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/header.html";i:1554967557;s:94:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/pub/order-nav.html";i:1553589074;s:88:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/copyright.html";i:1553776206;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/footer.html";i:1554883865;}*/ ?>
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
<!--提示-->
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
            订单管理
        </div>
        <div class="navbar-nav-nav">
            <ul>
                <li>
                    <a href="<?php echo url('boguan/platform.order/index'); ?>" <?php if($ctrl == 'Platform.order' && $act == 'index' || $act == 'detail'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-dingdan"></i>
                    </span>
                        <span class="nav-title">
                      所有订单
                    </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo url('boguan/platform.after/index'); ?>" <?php if($ctrl == 'Platform.after'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-libao"></i>
                    </span>
                        <span class="nav-title">
                      退款维权
                    </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo url('boguan/platform.comment/index'); ?>" <?php if($ctrl == 'Platform.comment'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-pingjia"></i>
                    </span>
                        <span class="nav-title">
                      评价管理
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
                    <h5>所有订单</h5>
                </div>
                <div class="main-con order-main">
                    <form action="" enctype="multipart/form-data">
                        <div class="order_screening">
                            <ul class="order_conditions clearit">
                                <li>
                                    <div class="" style="display: inline-block;float: left;margin-right: 5px;width: 164px;">
                                        <select class="control-chosen control-input" data-placeholder="" name="type">
                                            <option value="1" <?php if(input('type') == '1'): ?>selected<?php endif; ?>>订单号</option>
                                            <option value="2" <?php if(input('type') == '2'): ?>selected<?php endif; ?>>用户名</option>
                                            <option value="3" <?php if(input('type') == '3'): ?>selected<?php endif; ?>>收货人姓名/电话/地址</option>

                                        </select>
                                    </div>
                                    <div class="input_box">
                                        <input class="control-input" type="text" autocomplete="off" name="keyword" value="<?php echo input('keyword'); ?>">
                                    </div>
                                </li>
                            </ul>
                            <ul class="order_conditions clearit">
                                <li>
                                    <label class="control-label" style="float: left;">
                                        <span class="text-title">下单时间</span>
                                        <span class="text-danger2">:</span>
                                    </label>

                                    <div class="order_screening-time clearit" style="display: inline-block">
                                        <div class="date_control" style="margin-left:4px">
                                            <div class="input-daterange input-group" id="datepicker">
                                                <input type="text" class="form-control" name="start_time" id="new_start_time" placeholder="开始日期" value="<?php echo input('start_time'); ?>">
                                                <span class="input-group-addon">至</span>
                                                <input type="text" class="form-control" name="end_time" id="new_end_time" placeholder="结束日期" value="<?php echo input('end_time'); ?>">
                                            </div>
                                        </div>
                                        <ul>
                                            <li>
                                                <span>昨天</span>
                                            </li>
                                            <li>
                                                <span>近7天</span>
                                            </li>
                                            <li>
                                                <span>近30天</span>
                                            </li>
                                        </ul>
                                    </div>

                                </li>
                            </ul>
                            <ul class="order_conditions clearit">
                                <li>
                                    <label class="control-label">
                                        <span class="text-title">商品名称</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="input_box">
                                        <input class="control-input" type="text" autocomplete="off" placeholder="请输入商品名称" name="product"  value="<?php echo input('product'); ?>">
                                    </div>
                                </li>

                                <li>
                                    <label class="control-label">
                                        <span class="text-title">订单类型</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="input_box">
                                        <select class="control-chosen control-input" data-placeholder="Please select..." name="order_type">
                                            <option value="" <?php if(input('order_type') == ''): ?>selected<?php endif; ?>>全部</option>
                                            <option value="1" <?php if(input('order_type') == '1'): ?>selected<?php endif; ?>>商城订单</option>
                                            <option value="2" <?php if(input('order_type') == '2'): ?>selected<?php endif; ?>>同城订单</option>
                                            <option value="3" <?php if(input('order_type') == '3'): ?>selected<?php endif; ?>>自提订单</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                            <ul class="order_conditions clearit">
                                <li>
                                    <label class="control-label">
                                        <span class="text-title">付款方式</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="input_box">
                                        <select class="control-chosen control-input" data-placeholder="Please select..." name="pay_type">
                                            <option value="" <?php if(input('pay_type') == ''): ?>selected<?php endif; ?>>全部</option>
                                            <option value="1" <?php if(input('pay_type') == '1'): ?>selected<?php endif; ?>>微信支付</option>
                                        </select>
                                    </div>
                                </li>

                                <li>
                                    <label class="control-label">
                                        <span class="text-title">订单来源</span>
                                        <span class="text-danger2">:</span>
                                    </label>
                                    <div class="input_box">
                                        <select class="control-chosen control-input" data-placeholder="Please select..." name="source">
                                            <option value="" <?php if(input('source') == ''): ?>selected<?php endif; ?>>全部</option>
                                            <option value="1" <?php if(input('source') == '1'): ?>selected<?php endif; ?>>微信-小程序</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                            <div class="screening_control-box">
                                <button href="javascript:;" class="btn" type="submit">搜索</button>
                                <a href="<?php echo url('boguan/platform.order/export',['keyword'=> input('keyword'),'type'=> input('type'),'start_time'=> input('start_time'),'end_time'=> input('end_time'),'product'=> input('product'),'pay_type'=> input('pay_type'),'source'=> input('source'),'order_type'=> input('order_type'),'status'=> input('status'),'is_send'=> input('is_send'),'is_cancel'=> input('is_cancel'),'is_delete'=> input('is_delete'),'is_confirm'=> input('is_confirm')]); ?>" class="btn">批量导出</a>
                            </div>
                        </div>
                    </form>
                        <ul class="nav-contral clearit nav nav-tabs" role="tablist">
                            <li role="presentation" class="nav-tabs-li <?php if($ctrl == 'Platform.order' && input('status') == '' && !input('is_delete') && !input('is_cancel')): ?>active<?php endif; ?>"><a href="<?php echo url('boguan/platform.order/index'); ?>" >全部</a></li>
                            <li role="presentation" class="nav-tabs-li <?php if($ctrl == 'Platform.order' && input('status') == '0'): ?>active<?php endif; ?>"><a href="<?php echo url('boguan/platform.order/index',array('status'=> 0)); ?>">未付款</a></li>
                            <li role="presentation" class="nav-tabs-li <?php if($ctrl == 'Platform.order' && input('status') == '1' && input('is_send') == '0'): ?>active<?php endif; ?>"><a href="<?php echo url('boguan/platform.order/index',array('status'=> 1,'is_send'=> 0)); ?>">待发货</a></li>
                            <li role="presentation" class="nav-tabs-li <?php if($ctrl == 'Platform.order' && input('status') == '2' && input('is_send') == '1' && input('is_confirm') == '0'): ?>active<?php endif; ?>"><a href="<?php echo url('boguan/platform.order/index',array('status'=> 2,'is_send'=> 1,'is_confirm'=> 0)); ?>">待收货</a></li>
                            <li role="presentation" class="nav-tabs-li <?php if($ctrl == 'Platform.order' && input('status') == '3' && input('is_confirm') == '1'): ?>active<?php endif; ?>"><a href="<?php echo url('boguan/platform.order/index',array('status'=> 3,'is_confirm'=> 1)); ?>">已完成</a></li>
                            <li role="presentation" class="nav-tabs-li <?php if($ctrl == 'Platform.order' && input('is_cancel') == '1'): ?>active<?php endif; ?>"><a href="<?php echo url('boguan/platform.order/index',array('is_cancel'=> 1)); ?>">已取消</a></li>
                            <li role="presentation" class="nav-tabs-li <?php if($ctrl == 'Platform.order' && input('is_delete') == '1'): ?>active<?php endif; ?>"><a href="<?php echo url('boguan/platform.order/index',array('is_delete'=> 1)); ?>">回收站</a></li>
                        </ul>
                        <div class="main-table table-responsive">
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th class="order-tab-30">商品信息</th>
                                    <th class="order-tab-10" style="text-align:right">单价/数量</th>
                                    <th class="order-tab-20">买家信息</th>
                                    <th class="order-tab-20">金额</th>
                                    <th class="order-tab-10">实际付款</th>
                                    <th class="order-tab-20">状态/操作</th>
                                </tr>
                                </thead>
                                <?php if($order->isEmpty()): ?><tbody></tbody><?php endif; ?>
                            </table>

                            <!--未付款-->
                            <?php if(is_array($order) || $order instanceof \think\Collection || $order instanceof \think\Paginator): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <div class="order-item order-paying del-<?php echo $vo['id']; ?>" data-styleid="<?php if($vo['order_type'] == 1): ?>physical_commodity<?php elseif($vo['order_type'] == 2): ?>city_distribution<?php else: ?>pickup_order<?php endif; ?>">
                                <table class="table table-bordered bg-white">
                                    <tr>
                                        <td colspan="5" class="sanji-order">
                                            <ul class="order-address">
                                                <li>订单号：<span><?php echo $vo['old_order_no']; ?></span></li>
                                                <li>下单时间：<span><?php echo $vo['create_time']; ?></span></li>
                                                <li>用户：<span><?php echo $vo['user']['nickname']; ?></span></li>
                                                <li>订单类型：<?php if($vo['order_type'] == 1): ?><span class="label label-warning">商城订单</span><?php elseif($vo['order_type'] == 2): ?><span class="label label-primary">同城订单</span><?php else: ?><span class="label label-danger">自提订单</span><?php endif; ?></li>

                                                <li class="pull-right">
                                                    <a href="<?php echo url('boguan/platform.order/detail',['id'=> $vo['id']]); ?>">详情</a>
                                                </li>
                                                <li class="pull-right">-</li>
                                                <li class="pull-right">
                                                    <a href="javascript:;" onclick="remark('<?php echo $vo['id']; ?>','<?php echo $vo['old_order_no']; ?>')">备注</a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr data-id="<?php echo $vo['id']; ?>">
                                        <td class="sanji-pro order-tab-40">
                                            <ul>
                                                <?php if(is_array($vo['snap_info']) || $vo['snap_info'] instanceof \think\Collection || $vo['snap_info'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['snap_info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                                <li data-toggle="tooltip" data-placement="top" title="<?php echo $v['name']; ?>">
                                                    <div class="min-img"><img src="<?php echo $v['image']; ?>" ondragstart="return false" alt="" title=""></div>
                                                    <div class="min-title">
                                                        <div class="name"><span><?php echo $v['name']; ?></span></div>
                                                        <div class="guige">规格：<span><?php if(!empty($v['attr_id_list']) && !empty($v['attr_name'])): ?><?php echo implode(',',$v['attr_name']); else: ?>-<?php endif; ?></span></div>
                                                    </div>
                                                    <div class="min-price">
                                                        <div class="sum"><span>￥ <?php echo $v['price']; ?></span></div>
                                                        <div class="num"><span><?php echo $v['num']; ?>件</span></div>
                                                        <div class="num"><span>小计：￥ <?php echo $v['price'] * $v['num']; ?></span></div>
                                                    </div>
                                                </li>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </ul>
                                        </td>
                                        <td class="order-tab-20">
                                            <ul class="order-address">
                                                <?php if($vo['order_type'] == 3): ?>
                                                    <li><span>提货人：<?php echo $vo['pick_info']['name']; ?></span></li>
                                                    <li><span>手机号码：<?php echo $vo['pick_info']['phone']; ?></span></li>
                                                    <li><span>提货地址：<?php echo $vo['pick_info']['address']; ?></span></li>
                                                    <li><span>提货时间：<?php if($vo['pick_info']['time']): ?><?php echo $vo['pick_info']['time']; else: ?>尽快到店<?php endif; ?></span></li>
                                                <?php else: ?>
                                                    <li><span>收货人：<?php echo $vo['userinfo']['name']; ?></span></li>
                                                    <li><span>手机号码：<?php echo $vo['userinfo']['phone']; ?></span></li>
                                                    <li><span>收货地址：<?php echo $vo['userinfo']['address']; ?></span></li>
                                                <?php endif; ?>
                                            </ul>
                                        </td>

                                        <td class="order-tab-20 order-price">
                                            <ul>
                                                <li class="price">
                                                    金额：￥ <span><?php echo $vo['amount']; ?></span>
                                                </li>
                                                <li><?php if($vo['order_type'] == 2): ?>(配送费：￥ <span><?php echo $vo['delivery_price']; ?></span>)<?php else: ?>(运费：￥ <span style="font-weight: bold"><?php echo $vo['express_price']; ?></span>)<?php endif; ?></li>
                                                <li><?php if($vo['coupon_price'] != ''): ?>优惠券优惠：￥ <span style="font-weight: bold;color: red;"><?php echo $vo['coupon_price']; ?></span><?php endif; ?></li>
                                                <li><?php if($vo['is_integral'] == 1 && $vo['discount'] >0): ?>使用<span style="font-weight: bold"><?php echo $vo['integral']; ?></span>积分抵扣￥ <span style="font-weight: bold;color: red;"><?php echo $vo['discount']; ?></span><?php endif; ?></li>
                                                <li><?php if($vo['is_change'] == 1): if($vo['change_price'] >0): ?>后台加价￥ <span style="font-weight: bold;"><?php echo $vo['change_price']; ?></span><?php elseif($vo['change_price'] <0): ?>后台优惠￥ <span style="font-weight: bold;color: red;"><?php echo str_replace('-','',$vo['change_price']); ?></span><?php endif; endif; ?></li>

                                                <?php if($vo['status'] == '0' && $vo['is_cancel'] == '0'): ?>
                                                <li>
                                                    <a class="order-a-refused" href="javascript:;" onclick="order_modifyPrice(this)" data-toggle="modal" data-target=".order_modifyPrice-modal">修改价格</a>
                                                </li>
                                                <?php endif; ?>
                                            </ul>
                                        </td>
                                        <td class="order-tab-10  order-price">
                                            <ul>
                                                <li class="price">
                                                    ￥ <span><?php echo $vo['o_amount']; ?></span>
                                                    <?php if($vo['is_change'] == 1): ?><img src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/gai.png" ondragstart="return false" alt="" title=""><?php endif; ?>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="order-tab-20 order-control">
                                            <?php if($vo['status'] == 0 && $vo['is_cancel'] == 0 && $vo['is_delete'] == 0): ?>
                                                <span>等待买家付款</span>
                                                <div>
                                                    <a class="order-a" href="javascript:;" onclick="del('<?php echo $vo['id']; ?>','del-<?php echo $vo['id']; ?>')">移入回收站</a>
                                                </div>
                                            <?php elseif($vo['status'] == 1 && $vo['is_send'] == '0'): ?>
                                                <span>等待商家发货</span>
                                                <div>
                                                    <a class="order-a" href="javascript:;" onclick="order_delivery(this)" data-toggle="modal" data-target=".order_delivery-modal"data-state="<?php if($vo['order_type'] == 3 || $vo['order_type'] == 2): ?>takeOrders<?php else: endif; ?>"><?php if($vo['order_type'] == 2): ?>接单<?php else: ?>发货<?php endif; ?></a>
                                                </div>
                                            <?php elseif($vo['status'] == 2 && $vo['is_send'] == '1'): ?>
                                            <span>商家已发货</span>
                                            <div>
                                                <a class="order-a" href="javascript:;" onclick="order_delivery(this)" data-toggle="modal" data-target=".order_delivery-modal" data-state="modifyLogistics">修改物流</a>
                                                <!--<?php if($vo['order_type'] == 3): ?>
                                                <a class="order-a" href="javascript:;" onclick="orderConfirm('<?php echo $vo['id']; ?>')" data-toggle="modal" data-target=".order_delivery-modal" data-state="modifyLogistics">确认收货</a>
                                                <?php endif; ?>-->
                                            </div>
                                            <?php elseif($vo['status'] == 3): ?>
                                            <span>交易已完成</span>
                                            <?php endif; if($vo['is_cancel'] == 1): ?>
                                            <span>买家已取消</span></li>
                                            <div>
                                                <a class="order-a" href="javascript:;" onclick="del('<?php echo $vo['id']; ?>','del-<?php echo $vo['id']; ?>')">移入回收站</a>
                                            </div>
                                            <?php endif; if($vo['is_delete'] == 1): ?>
                                            <div>
                                                <a class="order-a" href="javascript:;" onclick="cancelDel('<?php echo $vo['id']; ?>','del-<?php echo $vo['id']; ?>')">移出回收站</a>
                                            </div>
                                            <div>
                                                <a class="order-a" href="javascript:;" onclick="realDel('<?php echo $vo['id']; ?>','del-<?php echo $vo['id']; ?>')">永久删除</a>
                                            </div>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>

                        </div>
                        <?php echo $page; ?>
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

<!--时间插件-->
<link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/datetime/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/datetime/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/datetime/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<!--多选插件-->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/chosen.jquery.js"></script>
<!--提示弹窗-->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/toast.script.js"></script>
<script>
    var specExArrTabl= {};
    var logisticsCompany= <?php echo $express; ?>;

    function getOrderInfo(id,type) {

        $.ajax({
            type: "post",
            async:false,
            url: "<?php echo url('boguan/platform.order/getOrderInfo'); ?>",

            data:{
                "id": id,
                "type": type,
            },
            beforeSend:function(){
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;

                    layer.load(1);

                });
            },
            success: function(data) {
                //console.log(data.data)
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;

                    layer.close(layer.index);

                });
                specExArrTable= data.data;

            },
            error: function (data) {
                console.log(data.responseText);
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;

                    layer.close(layer.index);

                });
            }
        });
    }

    function saveOrderInfo(id,data,type) {
        $.ajax({
            type: "post",
            async:false,
            url: "<?php echo url('boguan/platform.order/saveOrderInfo'); ?>",

            data:{
                "id": id,
                "data": data,
                "type": type,
            },
            beforeSend:function(){
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;

                    layer.load(1);

                });
            },
            success: function(data) {
                console.log(data)
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;

                    layer.close(layer.index);

                });
                if(data.errorCode == 1){
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;

                        layer.msg(data.msg, {icon: 1, time:1000}, function(){
                            //window.history.go(-1);location.reload();
                            window.location.reload();
                        });
                    });

                }else {
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;;

                        layer.msg(data.msg, {icon: 2, time:1000});
                    });
                }

            },
            error: function (data) {
                console.log(data.responseText);
                layui.use(['layer','form'], function(){
                    var layer = layui.layer,form = layui.form;
                    layer.msg(data.msg, {icon: 2, time:1000});
                    layer.close(layer.index);

                });
            }
        });
    }
    //自提订单确认收货
    function orderConfirm(id){

        layui.use(['layer','form'], function(){
            var layer = layui.layer,form = layui.form;;

            layer.confirm('请确认用户已到店提货，确认吗？', {btn:['确认'], yes:function(index){
                //按钮【按钮一】的回调
                //此处请求后台程序，下方是成功后的前台处理……
                $.ajax({
                    type: 'POST',
                    url: '<?php echo url("boguan/platform.order/orderConfirm"); ?>',
                    data:{'id':id},
                    success: function(data) {
                        console.log(data);
                        if (data.errorCode == 1) {

                            layer.msg(data.msg,{icon: 1})

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

    //商品数据

    //备注
    function remark(id,no) {

        layui.use(['layer','form'], function(){
            var layer = layui.layer,form = layui.form;
            //alert(id);
            layer.open({
                type: 2,
                title: "备注（订单号："+ no + '）',
                shadeClose: true,
                shade: 0.5,
                area: ['30%','42%'],
                content: '<?php echo url("boguan/Platform.order/remark"); ?>?id='+ id,
                /*end: function () {
                    window.location.reload();
                }*/

            });
        });
    }
    /*删除*/
    function del(id,key){

        layui.use(['layer','form'], function(){
            var layer = layui.layer,form = layui.form;;

            layer.confirm('确认移入回收站吗？', {btn:['确认'], yes:function(index){
                    //按钮【按钮一】的回调
                    //此处请求后台程序，下方是成功后的前台处理……
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo url("boguan/platform.order/del"); ?>',
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

    function cancelDel(id,key){

        layui.use(['layer','form'], function(){
            var layer = layui.layer,form = layui.form;;

            layer.confirm('确认移出回收站吗？', {btn:['确认'], yes:function(index){
                    //按钮【按钮一】的回调
                    //此处请求后台程序，下方是成功后的前台处理……
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo url("boguan/platform.order/cancelDel"); ?>',
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

    function realDel(id,key){

        layui.use(['layer','form'], function(){
            var layer = layui.layer,form = layui.form;;

            layer.confirm('确认永久删除吗？', {btn:['确认'], yes:function(index){
                    //按钮【按钮一】的回调
                    //此处请求后台程序，下方是成功后的前台处理……
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo url("boguan/platform.order/realDel"); ?>',
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

    function getRootPath() {
        var curWwwPath = window.document.location.href;
        var pathName = window.document.location.pathname;
        var pos = curWwwPath.indexOf(pathName);
        var localhostPath= curWwwPath.substring(0,pos);

        return localhostPath;
    }
</script>