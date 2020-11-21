<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:92:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/product/add.html";i:1555405429;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/header.html";i:1554967557;s:96:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/pub/product-nav.html";i:1553589073;s:88:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/copyright.html";i:1553776206;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/footer.html";i:1554883865;}*/ ?>
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
<link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/fileinput.min.css" rel="stylesheet">
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
            商品管理
        </div>
        <div class="navbar-nav-nav">
            <ul>
                <li>
                    <a href="<?php echo url('boguan/platform.product/index'); ?>?type=1" <?php if($ctrl == 'Platform.product' && (input('type') == '1' || input('type') == '')): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-chuhuo"></i>
                    </span>
                        <span class="nav-title">
                      出售中
                    </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.product/index'); ?>?type=2" <?php if($ctrl == 'Platform.product' && input('type') == '2'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-shouhuo"></i>
                    </span>
                    <span class="nav-title">
                      已售罄
                    </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.product/index'); ?>?type=3" <?php if($ctrl == 'Platform.product' && input('type') == '3'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-wupin"></i>
                    </span>
                        <span class="nav-title">
                      仓库中
                    </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.category/index'); ?>" <?php if($ctrl == 'Platform.category' && ($act == 'index' || $act == 'add' || $act == 'edit')): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-lanmu"></i>
                    </span>
                        <span class="nav-title">
                      分类
                    </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('boguan/platform.category/style'); ?>" <?php if($ctrl == 'Platform.category' && $act == 'style'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-shezhi"></i>
                    </span>
                    <span class="nav-title">
                      分类样式
                    </span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
        <div class="main_mbody">
            <div class="col-xs-12">
                <div class="main_mbody-title">
                    <h5>添加商品</h5>
                    <a href="javascript:history.go(-1)" class="goback"><span class="label label-info btn"><i class="iconfont icon-zuojiantou"></i>返回</span></a>
                </div>
                <div class="main-con product-con" data-styleid="physical_commodity">
                    <form action="">

                        <div class="pro-head">
                            <h5>商品类型</h5>
                        </div>
                        <div class="group1 clearit">
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <!-- <span class="text-title">商品类型</span>
                                    <span class="text-danger2">:</span> -->
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="radio-box magic-radio commodity_type-radio">
                                        <label class="selected">
                                            <div class="imgbox">
                                                <div class="content">
                                                    实物商品
                                                    <span>(物流发货)</span>
                                                </div>
                                            </div>
                                            <input class="selct-checkbox" type="radio" name="product_type" data-styleid="physical_commodity" value="0" checked="checked">
                                        </label>
                                        <!-- <label class="">
                                          <div class="imgbox">
                                            <div class="content">
                                              虚拟商品
                                              <span>(无需物流)</span>
                                            </div>
                                          </div>
                                          <input class="selct-checkbox" type="radio" name="launch_time" value="1">
                                        </label> -->
                                        <label class="">
                                            <div class="imgbox">
                                                <div class="content">
                                                    自营配送
                                                    <span>(同城配送或自提)</span>
                                                </div>
                                            </div>
                                            <input class="selct-checkbox" type="radio" name="product_type" data-styleid="city_distribution" value="1">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro-head">
                            <h5>基本信息</h5>
                        </div>
                        <div class="group1 clearit">
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">商品分类</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <select class="control-chosen control-input" name="cate_id" id="cate_id">
                                        <option value="-1">请选择商品分类</option>
                                        <?php if(is_array($categories) || $categories instanceof \think\Collection || $categories instanceof \think\Paginator): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['id']; ?>" ><?php echo $vo['name']; ?></option>
                                        <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $k = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>
                                        <option value="<?php echo $v['id']; ?>" ><?php if(count($vo['child']) == $k): ?>&nbsp;&nbsp;&nbsp;└─ <?php echo $v['name']; else: ?>&nbsp;&nbsp;&nbsp;├─ <?php echo $v['name']; endif; ?></option>
                                        <?php if(is_array($v['child']) || $v['child'] instanceof \think\Collection || $v['child'] instanceof \think\Paginator): $kk = 0; $__LIST__ = $v['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($kk % 2 );++$kk;?>
                                        <option value="<?php echo $vv['id']; ?>" ><?php if(count($v['child']) == $kk): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─ <?php echo $vv['name']; else: ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─ <?php echo $vv['name']; endif; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">商品名称</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <input class="control-input" type="text" autocomplete="off" name="name" id="name">
                                </div>

                            </div>

                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">商品主图</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row">
                                    <ul id="sortable" class="pro-img" data-maxvalue="8">
                                       <!-- <li class="ui-state-default" data-id="1">
                                            <img src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/img01.jpg" ondragstart="return false" alt="" title="">
                                            <a href="javascript:;" class="pro-img-remove" onclick="deleteimg(this)"><i class="iconfont icon-tubiao39"></i></a>
                                        </li>-->
                                    </ul>
                                    <a href="javascript:;" class="pro-img-add" onclick="iconLibrary(this)" data-laymodal="product_img" data-toggle="modal" data-target=".icon-lib"><img src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/default_add.png" ondragstart="return false" alt="" title=""></a>

                                    <div class="clearit"></div>
                                    <span class="control-tips">第一张图为缩略图；图片可拖拽改变顺序；图片尺寸建议750*750px</span>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">主图视频</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="radio-box shangpin_video">
                                        <!-- <br> -->
                                        <label class="radio-checkbox-label selected">
                                            <input class="selct-checkbox" type="radio" name="video_type" value="1" checked>粘贴视频地址
                                        </label>
                                        <label class="radio-checkbox-label">
                                            <input class="selct-checkbox" type="radio" name="video_type" value="0">选择视频
                                        </label>
                                    </div>

                                    <div class="shangpin_video-radio" data-editid="1"  data-parent="proBox"><!--0:选择视频;1:粘贴视频地址-->
                                        <div class="radio-one">
                                            <div class="input-group video_upload">
                                                <input class="control-input video_input" type="text" value="" autocomplete="off" readonly data-target="proBox" data-id="">
                                                <a href="javascript:" class="btn input-group-addon add-attr-btn" onclick="videoLibrary(this)" data-toggle="modal" data-target=".video-lib">上传视频</a>
                                            </div>
                                            <span class="control-tips">支持的视频文件类型包括：mp4</span>
                                        </div>
                                        <div class="radio-two">
                                            <input class="control-input" type="text" autocomplete="off" placeholder="请输入视频地址">
                                            <span class="control-tips">仅支持.mp4格式的视频源地址</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">服务内容</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box addselect-set">
                                    <select class="control-chosen control-input" data-placeholder="请选择服务内容" multiple name="promise" id="promise">
                                        <?php if(is_array($promise) || $promise instanceof \think\Collection || $promise instanceof \think\Paginator): $i = 0; $__LIST__ = $promise;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    <div class="addselect">
                                        <a href="<?php echo url('boguan/platform.promise/index'); ?>" class="addselect-add" target="_blank">新建</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">商品卖点</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <input class="control-input" type="text" autocomplete="off" name="summary">
                                    <span class="control-tips">在商品标题下面展示卖点信息，建议60字以内</span>
                                </div>
                            </div>

                        </div>
                        <div class="pro-head">
                            <h5>规格库存</h5>
                        </div>
                        <div class="group clearit">

                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">商品规格</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="pro-more-control">
                                        <div class="pro-more-spec">
                                        </div>
                                        <div class="pro-more-addspec">
                                            <a href="javascript:void(0);" class="addspec-add addselect-add"><i class="iconfont icon-jia"></i>添加规格</a>
                                            <div class="addspec-box">
                                                <input class="control-input" type="text" autocomplete="off" placeholder="输入规格组名称，例如颜色、尺码、套餐">
                                                <div class="control">
                                                    <a href="javascript:void(0);" class="btn control-save">保存</a>
                                                    <a href="javascript:void(0);" class="btn control-cancel">取消</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="control-tips">如有颜色、尺码等多种规格，请添加商品规格</span>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <!-- <span class="text-title">价格&库存</span>
                                    <span class="text-danger2">:</span> -->
                                </label>
                                <div class="col-xs-6 col-sm-8 row pro-more-showbox">
                                    <!-- <div class="alert alert-info pro-more-alert" role="alert">请先填写规格组和规格值！</div> -->
                                    <div class="pro-more-table">
                                        <div class="main-table table-responsive table-condensed">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="th_img">规格图片</th>
                                                    <th>价格</th>
                                                    <th>库存</th>
                                                    <th>商品编码</th>
                                                    <th>条形码</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- <tr>
                                                  <td class="min-img"><img src="images/img01.jpg" ondragstart="return false" alt="" title=""></td>
                                                  <td class="price"><input type="number" class="control-input"></td>
                                                  <td class="stock"><input type="number" class="control-input"></td>
                                                  <td class="code"><input type="number" class="control-input"></td>
                                                </tr> -->
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td class="min-img-all"></td>
                                                    <td>
                                                        <div class="input-group table-input">
                                                            <!-- <span class="input-group-addon">批量</span> -->
                                                            <input type="text" class="control-input" onkeyup="decimalPoint(this)">
                                                            <a index="1" href="javascript:" class="btn input-group-addon add-attr-btn" data-editid="price" onclick="batchSet(this)">设置</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group table-input">
                                                            <!-- <span class="input-group-addon">批量</span> -->
                                                            <input type="text" class="control-input" onkeyup="positiveInteger(this)">
                                                            <a index="1" href="javascript:" class="btn input-group-addon add-attr-btn" data-editid="stock" onclick="batchSet(this)">设置</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group table-input">
                                                            <!-- <span class="input-group-addon">批量</span> -->
                                                            <input type="text" class="control-input">
                                                            <a index="1" href="javascript:" class="btn input-group-addon add-attr-btn" data-editid="code" onclick="batchSet(this)">设置</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group table-input">
                                                            <!-- <span class="input-group-addon">批量</span> -->
                                                            <input type="text" class="control-input">
                                                            <a index="1" href="javascript:" class="btn input-group-addon add-attr-btn" data-editid="barcode" onclick="batchSet(this)">设置</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">售价</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="input-group min-input">
                                        <span class="input-group-addon" style="line-height:18px;">￥</span>
                                        <input class="control-input shangpin-price" type="text" autocomplete="off" value="" onkeyup="decimalPoint(this)" name="price" id="price">

                                    </div>
                                    <span class="control-tips">该价格为商品售卖价</span>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">商品原价</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="input-group min-input">
                                        <span class="input-group-addon" style="line-height:18px;">￥</span>
                                        <input class="control-input" type="text" autocomplete="off" value="" onkeyup="decimalPoint(this)" name="o_price" id="o_price">
                                    </div>
                                    <span class="control-tips">当商品有优惠的情况下，商品原价在商品详情会以划线形式显示。</span>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">库存</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="input-group min-input">
                                        <input class="control-input shangpin-inventory" type="number" autocomplete="off" value="" onkeyup="positiveInteger(this)" name="stock" id="stock">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row input_box">
                                <label class="control-label col-xs-6 col-sm-4">
                                   <!-- <span class="text-danger">*</span>-->
                                    <span class="text-title">重量</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="input-group min-input">
                                    <input class="control-input shangpin-code" type="number" autocomplete="off" value="" name="weight" id="weight" onkeyup="decimalPoint(this)" style="width:100px">
                                    <span class="input-group-addon" style="line-height:15px;">g</span>
                                </div>

                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">基本销量</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="input-group min-input">
                                        <input class="control-input" type="number" autocomplete="off" value="" name="sales" onkeyup="positiveInteger(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">商品编码</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <input class="control-input shangpin-code" type="text" autocomplete="off" name="no">
                                </div>
                            </div>
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">条形码</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <input class="control-input shangpin-code" type="text" autocomplete="off" name="bar_code">
                                </div>
                            </div>


                        </div>


                        <div class="pro-head">
                            <h5>其他信息</h5>
                        </div>
                        <div class="group clearit">
                            <div class="form-group col-xs-12 row form-stock_up">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">配送方式</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="checkbox-box">
                                        <label class="selct-checkbox-label">
                                            <input class="selct-checkbox" type="checkbox" name="send_type" value="2" id="send_type">同城配送
                                        </label>
                                        <br>
                                        <label class="selct-checkbox-label">
                                            <input class="selct-checkbox" type="checkbox" name="send_type" value="3">到店自提
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="form-group col-xs-12 row form-stock_up">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">备货时间</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="checkbox-box stock_up">
                                        <label class="selct-checkbox-label">
                                            <input class="selct-checkbox" type="checkbox" name="distribution_type" value="0">需要预留备货时间
                                        </label>
                                        <div class="stock_up-box">
                                            <select class="control-chosen control-input stock_up-day" data-styleid="day" data-placeholder="天数">
                                                <option></option>
                                            </select>
                                            <span>天</span>
                                            <select class="control-chosen control-input stock_up-hour" data-styleid="hour" data-placeholder="小时">
                                                <option></option>
                                            </select>
                                            <span>时</span>
                                            <select class="control-chosen control-input stock_up-minute" data-styleid="minute" data-placeholder="分钟">
                                                <option></option>
                                            </select>
                                            <span>分</span>
                                        </div>
                                        &lt;!&ndash; <label class="selct-checkbox-label">
                                          <input class="selct-checkbox" type="checkbox" name="distribution_type" value="1">到店自提
                                        </label> &ndash;&gt;
                                    </div>
                                </div>
                            </div>-->
                            <div class="form-group col-xs-12 row form-commodity">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-danger">*</span>
                                    <span class="text-title">快递运费</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row">
                                    <div class="radio-box radio-shangpin">
                                        <label class="radio-checkbox-label hasinput_label selected">
                                            <input class="selct-checkbox" type="radio" name="is_unify" data-styleid="all" value="1" checked="checked">统一运费
                                            <div class="radio-input">
                                                <div class="input-group min-input">
                                                    <span class="input-group-addon" style="line-height:15px;">￥</span>
                                                    <input class="control-input" type="text" autocomplete="off" value="" name="unify_express" onkeyup="decimalPoint(this)">
                                                </div>
                                            </div>
                                        </label>
                                        <label class="radio-checkbox-label hasinput_label">
                                            <input class="selct-checkbox" type="radio" name="is_unify" value="0">运费模板
                                            <div class="radio-input">
                                                <select class="control-chosen control-input" name="freight_id">
                                                    <?php if(is_array($freight) || $freight instanceof \think\Collection || $freight instanceof \think\Paginator): $i = 0; $__LIST__ = $freight;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                                    <option value="<?php echo $vo['id']; ?>"  data-freight="<?php if($vo['type'] == 2): ?>piece<?php else: ?>weight<?php endif; ?>"><?php echo $vo['name']; ?>（<?php if($vo['type'] == 2): ?>按件数<?php else: ?>按重量<?php endif; ?>）</option>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                            </div>
                                            <div class="help-inline">

                                                <a href="<?php echo url('boguan/platform.freight/index'); ?>" rel="noopener noreferrer" target="_blank">新建</a>

                                            </div>
                                        </label>
                                        <div class="form-group col-xs-12 row pro_weight_group">
                                            <label class="control-label col-xs-6 col-sm-4" style="width:90px">
                                                <span class="text-title">物流重量</span>
                                                <span class="text-danger2">:</span>
                                            </label>
                                            <div class="col-xs-6 col-sm-8 row">
                                                <div class="radio-box radio_weight">
                                                    <label class="radio-checkbox-label hasinput_label selected">
                                                        <input class="selct-checkbox" type="radio" name="weight_group" data-styleid="all" value="0" checked="checked">所有商品规格统一重量
                                                        <div class="radio-input" style="width:140px">
                                                            <div class="input-group min-input">
                                                                <input class="control-input" type="text" autocomplete="off" value="0" name="weight_num" onkeyup="decimalPoint(this)" style="width:100px">
                                                                <span class="input-group-addon" style="line-height:15px;">g</span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                    <label class="radio-checkbox-label">
                                                        <input class="selct-checkbox input_weight" type="radio" data-styleid="single" name="weight_group" value="1">不同商品规格单独设置重量
                                                    </label>
                                                </div>
                                                <div class="table_weight">
                                                </div>
                                                <span class="control-tips">运费模版支持按地区设置运费，按购买件数计算运费，按重量计算运费等</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <span class="control-tips">运费模版支持按地区设置运费，按购买件数计算运费，按重量计算运费等</span> -->
                                </div>
                            </div>

                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <!-- <span class="text-danger">*</span> -->
                                    <span class="text-title">上架时间</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="radio-box">
                                        <label class="radio-checkbox-label selected">
                                            <input class="selct-checkbox" type="radio" name="status" value="1" checked="checked">立即上架售卖
                                        </label>
                                        <br>
                                        <label class="radio-checkbox-label">
                                            <input class="selct-checkbox" type="radio" name="status" value="0">暂不售卖，放入仓库
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">限购</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="checkbox-box checkbox_shangpin">
                                        <label class="selct-checkbox-label">
                                            <input class="selct-checkbox" type="checkbox" name="is_limit" value="1">限制每人可购买数量
                                        </label>
                                        <div class="cheakbox-input">
                                            <div class="input-group min-input">
                                                <span style="line-height:34px;">每个买家用户累计限购</span>
                                                <input class="control-input" type="number" autocomplete="off" name="limit_num" value="" onkeyup="decimalPoint(this)">
                                                <span class="input-group-addon" style="line-height:15px;margin-top: 2px;">件</span>
                                            </div>
                                        </div>
                                        <label class="selct-checkbox-label">
                                          <input class="selct-checkbox" type="checkbox" name="launch_time" value="1">暂不售卖，放入仓库
                                        </label>
                                    </div>
                                </div>
                            </div>-->
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <!-- <span class="text-danger">*</span> -->
                                    <span class="text-title">积分抵扣</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row input_box">
                                    <div class="checkbox-box checkbox_shangpin">
                                        <label class="selct-checkbox-label">
                                            <input class="selct-checkbox" type="checkbox" name="is_integral" value="1">允许积分抵扣

                                        </label>
                                        <div class="cheakbox-input">
                                            <div class="input-group min-input">
                                                <span style="line-height:34px;">单件商品最多抵扣</span>
                                                <input class="control-input" type="number" autocomplete="off" value="" name="forehead" placeholder="请输入正整数" onkeyup="decimalPoint(this)">
                                                <span class="input-group-addon" style="line-height:15px;margin-top: 2px;">元</span>
                                            </div>
                                            <div class="checkbox-box">
                                                <label class="selct-checkbox-label">
                                                    <input class="selct-checkbox" type="checkbox" name="more" value="1">允许多件累计抵扣
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="pro-head">
                            <h5>图文详情</h5>
                        </div>
                        <div class="group clearit">
                            <div class="form-group col-xs-12 row">
                                <label class="control-label col-xs-6 col-sm-4">
                                    <span class="text-title">图文详情</span>
                                    <span class="text-danger2">:</span>
                                </label>
                                <div class="col-xs-6 col-sm-8 row">
                                    <script id="editor" type="text/plain" style="width:450px;height:500px;"></script>
                                </div>
                            </div>
                        </div>


                        <div class="main_mbody-footer">
                            <!-- <div class="form-group col-xs-12 row">
                              <label class="control-label col-xs-6 col-sm-4">
                              </label>
                              <div class="col-xs-6 col-sm-8 row">
                                <input class="btn control-submit" type="button" value="保存">
                              </div>
                            </div> -->
                        </div>
                        <div class="layout-bottom">
                            <input class="btn control-submit" type="submit" value="保存">
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


<!--头像插件-->
<link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/cropper.min.css" rel="stylesheet">
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/cropper.min.js"></script>
<!--翻页插件-->
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/jquery.paginate.js"></script>
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/jquery.yhhDataTable.js"></script>

<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/jquery-ui.js"></script>
<!--多选插件-->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/chosen.jquery.js"></script>
<!--提示弹窗-->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/toast.script.js"></script>
<!--翻页-->
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/pageNav.js"></script>
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/fileinput.js"></script>

<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/Sortable.min.js"></script>

<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/sitelogo.js"></script>

<script>
    function getUrl() {
        var url = '<?php echo WE7_PATH; ?>public/boguan/';
        return url;
    }
    //视频
    var videoList=<?php if($videoList != ''): ?><?php echo $videoList; else: ?>[]<?php endif; ?>;

    var product_img = [];
    //规格组和属性
    var specMsg= [];
    //规格值
    var specExArrTable = [];

        var ue = UE.getEditor('editor', {
            serverUrl: "<?php echo url('boguan/base/UeImgUpload'); ?>" ,
        });
  //图标库
      var iconLib={
          wedding:[],
          ktv:[

          ],

        };
      var iconLibCE={wedding:'未分组',ktv:'KTV',};
      var imageLib={
          wedding:<?php if($imageList != ''): ?><?php echo $imageList; else: ?>[]<?php endif; ?>,

        };
      var imageLibCE={wedding:'未分组'};
    function videoFtnPart(){

        /*文件上传*/
        $("#video_fileinput").fileinput({
            'language': 'zh',
            'uploadUrl': "<?php echo url('boguan/base/videoUpload'); ?>",
            /*'uploadExtraData': {
                'name': name,
                'thumb': thumb,

            },*/

            'allowedFileExtensions': ['mp4'],
            'maxFileSize':35600,
            'overwriteInitial': false,
            'deleteUrl': '#',
            'deleteExtraData': {'url':''},


        });
        $("#video_fileinput").on("fileuploaded", function(event, data, previewId, index) {
            var id= data.response.data.id;
            var url= data.response.data.url;
            console.log(id)
            $('.video-lib .video_confirm').removeClass('disabled');
            $('.video-lib .video_confirm').attr('data-id',id).attr('data-url',url);

        });
    }
    $( function() {
        //多选
        $('.control-chosen').chosen({
            allow_single_deselect: true
        });
        $('.popover-service').popover({
            trigger : 'hover',
            html:true,
            content:$(this).data('content')
        });

        var layoutShow = Sortable.create(sortable,{
            group:{
                name: 'layout_sort',
                pull: false,
                put: true
            },
            onUpdate: function (evt) {
                console.log("手机触发")
                var order = layoutShow.toArray();
                // layoutTypeset.sort(order.slice());
                console.log(order)
            },
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

        var select = document.getElementById("promise");
        var str = [];
        for(i=0;i<select.length;i++){
            if(select.options[i].selected){
                str.push(select[i].value);
            }
        }
        d['promise']= str;

        var send_select = document.getElementsByName("send_type");
        var sendType = [];
        for(i=0;i<send_select.length;i++){
            if(send_select[i].checked){
                sendType.push(send_select[i].value);
            }
        }
        d['send_type']= sendType;

        if($('.shangpin_video-radio').attr('data-editid') == '1'){
            d['video_url'] = $('.shangpin_video-radio .radio-two').find('input').val();

        }else {
            d['video_url'] = $('.shangpin_video-radio .radio-one').find('input').val();
            d['video_id']= $('.video_input').attr('data-id');
        }

        //var video_url = $('.video_input').attr('data-video');
        //d['video_url']= video_url;
        console.log(specExArrTable);
        console.log(product_img);
        console.log(d);
        $.ajax({
            type: "post",
            url: "<?php echo url('boguan/platform.product/add'); ?>",
            //dataType:"json",
            data:{
                'data': d,
                'image': product_img,
                'attrGroup': specMsg,
                'attrValue': specExArrTable,
            },
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
                            window.location=document.referrer;

                        });

                    });

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
                });
            }
        });

    });

</script>