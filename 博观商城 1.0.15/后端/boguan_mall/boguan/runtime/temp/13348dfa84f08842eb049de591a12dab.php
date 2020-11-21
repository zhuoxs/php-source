<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:92:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/platform/home/bottom.html";i:1554280556;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/header.html";i:1554967557;s:88:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/copyright.html";i:1553776206;s:85:"/www/wwwroot/we7/addons/boguan_mall/boguan/application/boguan/view/common/footer.html";i:1554883865;}*/ ?>
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
<!--彈窗修改-->
<link href="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//css/popModal.min.css" rel="stylesheet">
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
                    页面管理
                </div>
                <div class="navbar-nav-nav">
                    <ul>
                        <li>
                            <a href="<?php echo url('boguan/platform.home/index'); ?>" <?php if($ctrl == 'Platform.home' && $act != 'bottom'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-bujufangshi"></i>
                    </span>
                                <span class="nav-title">
                      布局排版
                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo url('boguan/platform.home/bottom'); ?>" <?php if($ctrl == 'Platform.home' && $act == 'bottom'): ?>class="action"<?php endif; ?>>
                    <span class="nav-icon">
                      <i class="iconfont icon-dibudaohang"></i>
                    </span>
                                <span class="nav-title">
                      底部菜单
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
                <div class="main_mbody-title main-layout-title">
                    <h5>布局排版</h5>
                </div>
                <div class="main-con laybottom-con">
                    <form action="">
                        <!-- <div class="layout-control">
                          <div class="layout-control-title">组件库</div>
                          <div class="layout-control-con">
                            <ul class="con-box" id="layout_control">

                            </ul>
                          </div>
                        </div>
                        <div class="layout-typeset">
                          <div class="layout-control-title">快速排版</div>
                          <div class="layout-control-con">
                            <ul class="layout-typeset-box" id="layout_typeset">

                            </ul>
                          </div>
                        </div> -->
                        <div class="layout-show layout_bottom-show">
                            <div class="iphone">
                                <div class="iphone-head">
                                    <h1>小程序商城</h1>
                                </div>
                                <div class="iphone-screen">
                                    <ul class="iphone-screen-box">
                                        <!-- <div class="suspension" onclick="stateEdit(this)" data-laymodal="suspension" data-id="b2">
                                          <ul>
                                            <li class="imgbox">
                                              <img src="images/why.png" ondragstart="return false" alt="" title="">
                                            </li>
                                            <li class="imgbox">
                                              <img src="images/why.png" ondragstart="return false" alt="" title="">
                                            </li>
                                          </ul>
                                        </div> -->
                                        <!-- <div class="music" onclick="stateEdit(this)" data-laymodal="music" data-id="b3">
                                          <ul>
                                            <li class="imgbox">
                                              <img src="images/music.png" ondragstart="return false" alt="" title="">
                                            </li>
                                          </ul>
                                        </div> -->
                                    </ul>
                                </div>
                                <div class="iphone-bottom" onclick="stateEdit(this)" data-laymodal="bottomNav" data-id="b1">
                                    <ul class="iphone-screen-bottom" id="layout_bottomnav" >
                                        <!--<li data-id="" data-editid="botnav_li">
                          <span class="icon">
                            <img src="images/default_img.png" ondragstart="return false" alt="" title="">
                          </span>
                                            <span class="name" data-editid="botnav_linkname">导航1</span>
                                        </li>
                                        <li data-id="" data-editid="botnav_li">
                          <span class="icon">
                            <img src="images/default_img.png" ondragstart="return false" alt="" title="">
                          </span>
                                            <span class="name" data-editid="botnav_linkname">导航2</span>
                                        </li>
                                        <li data-id="" data-editid="botnav_li">
                          <span class="icon">
                            <img src="images/default_img.png" ondragstart="return false" alt="" title="">
                          </span>
                                            <span class="name" data-editid="botnav_linkname">导航3</span>
                                        </li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="layout-install layout_bottom-install">


                        </div>

                        <div class="layout-bottom">
                            <div class="layout-saoma-box">
                                <!--<a href="javascript:;" class="bttn layout-saoma">扫码预览</a>
                                <div class="layout-erweima">
                                    <div class="tip-arrow"></div>
                                    <div class="imgbox"></div>
                                    <p class="control-tips">更新后审核期间扫码预览暂不支持查看新功能，审核通过后即可正常显示。</p>
                                </div>-->
                            </div>
                            <input type="hidden" name="id" value="<?php echo $bottom['id']; ?>" id="id">
                            <input class="btn control-submit" type="button" value="保存并发布">
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

<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/toast.script.js"></script>
<!--拾色器-->
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/colpick.js"></script>
<!--翻页-->
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/pageNav.js"></script>
<!--多选插件-->
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/chosen.jquery.js"></script>

<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/Sortable.min.js"></script>
<script src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/operating.js"></script>

<!--地图插件-->
<script src="https://webapi.amap.com/maps?v=1.3&key=c193b7c51e579ad80ec35989db0d8898&plugin=AMap.PolyEditor"></script>
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/MapType.js"></script>
<script type="text/javascript" src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//js/MapGrid.js"></script>

<script>

    function getUrl() {
        var url = '<?php echo WE7_PATH; ?>public/boguan/';
        return url;
    }
    var productList= {};
    var productListCE= [];

        var iconLibCE={wedding:'未分组',};
        //图片库
        var imageLib={
            wedding:<?php if($imageList): ?><?php echo $imageList; else: ?>[]<?php endif; ?>,

        };
        var imageLibCE={wedding:'未分组',};
        var linkToChoose= <?php if($linksList): ?><?php echo $linksList; else: ?>{}<?php endif; ?>;

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

        function getContentByType(type) {
            console.log(type)

            $.ajax({
                type: "post",
                url: "<?php echo url('boguan/base/getContentByType'); ?>",
                //dataType:"json",
                async:false,
                data:{
                    "type": type,
                },

                success: function(data) {
                    console.log(data)
                    if (data.errorCode == 1) {
                        console.log(data.data.lists)
                        console.log(data.data.category)
                        if (data.data.lists) {
                            productList= data.data.lists;
                        }else {
                            productList= {};
                        }

                        if (data.data.category) {

                            productListCE= data.data.category;
                        }else {

                            productListCE= [];
                        }

                        //window.location.reload()
                    } else {

                    }
                },
                error: function (data) {
                    console.log(data.responseText);

                }
            });
        }

        function saveDiyBottomData(data) {
            var id = $('#id').val();
            $.ajax({
                type: "post",
                url: "<?php echo url('boguan/platform.home/bottom'); ?>",
                //dataType:"json",
                data:{
                    "data": data[0],
                    "id": id,
                },
                beforeSend:function(){
                    layui.use(['layer','form'], function(){
                        var layer = layui.layer,form = layui.form;

                        layer.load(1);

                    });
                },
                success: function(data) {
                    console.log(data)
                    if (data.errorCode == 1) {
                        //alert(data.msg);
                        layui.use(['layer','form'], function(){
                            var layer = layui.layer,form = layui.form;
                            layer.close(layer.index);
                            layer.msg(data.msg, {icon: 1, time:1000}, function(){
                                //window.history.go(-1);location.reload();
                               // window.location=document.referrer;

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
        }


    var stepNum=0;
    //记录初始模板
        var lmTemplate= [{
            "lm":'bottomNav',
            "codeEdit":'<div class="edit-box"><div class="title_box"><div class="title"><h5>底部菜单设置</h5></div><a href="javascript:void(0);" class="edit-remove" onclick="resetLBottom(this)" data-toggle="modal" data-target=".del-confirm"><span class="label label-warning">重置</span></a></div><div class="edit-con lay_lbt"><div class="form-group col-xs-12 row clearit"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">底部菜单</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="radio-box"data-editid="bottomnav_navshow"><label class="radio-checkbox-label selected"><input class="selct-checkbox"type="radio"name="lay_navshow"value="1"checked="checked">开启</label><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="lay_navshow"value="0">关闭</label></div></div></div><div class="form-group col-xs-12 row clearit"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">背景颜色</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="input-group"><div class="color-box bottomcolor_bg"data-editid="iphone_bottom"data-original=""data-newcol=""></div></div></div></div><div class="form-group col-xs-12 row clearit"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">默认颜色</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="input-group"><div class="color-box bottomcolor_original"data-editid="botnav_li"data-original=""data-newcol=""></div></div></div></div><div class="form-group col-xs-12 row clearit"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">选中颜色</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="input-group"><div class="color-box bottomcolor_sel"data-editid="botnav_li"data-original=""data-newcol=""></div></div></div></div><div class="clearit"></div><div class="lay_lbt-modal clearit"><ul id="lay_img_editmodal"><li class="lay_img-box lay_fileimg lay_bottomimg"><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-auto"src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/default_add.png"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class="iconfont icon-tupian"title="图标库"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib"></span><span class="iconfont icon-shangchuan"title="本地上传"onclick="inputFileNav(this)"></span></div></div><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-sel"src="//www.lg0578.com/addons/boguan_mall/boguan/public/boguan//images/default_add.png"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class="iconfont icon-tupian"title="图标库"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib"></span><span class="iconfont icon-shangchuan"title="本地上传"onclick="inputFileNav(this)"></span></div></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">文字</span><input type="text"class="control-input form-control text-input"name="navname"value="导航1"data-editid="botnav_linkname"onkeyup="inputChange(this,&quot;bottomName&quot;)"></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly=""value=""><div class="input-group-btn"><button type="button" class="btn btn-default linkchoose_btn" onclick="LinkToChoose(this)" data-toggle="modal" data-target=".link-lib">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="iconfont icon-tubiao39"></i></a></li></ul></div><div class="lay_img-add"><div class="form-group col-xs-12 row clearit"><label class="control-label col-xs-6 col-sm-4"><input class="btn control-add"id="lay_imgAdd"type="button"value="添加导航"></label><div class="col-xs-6 col-sm-8 row"><span class="control-tips"style="margin-top: 5px;padding: 8px 0;">最多可添加六个；当“文字”为空时，则只显示图片</span></div></div></div></div></div>'
        }];
    var layoutModalSelect=<?php if($bottom['detail']): ?>[<?php echo $bottom['detail']; ?>]<?php else: ?>[
        {
            "id":'b1',
            "lm":'bottomNav',
            "title":'底部导航栏',
            "stylediy": 1,
            "bgColor":'#ffffff',
            "original":'#666666',
            "newCol":'#ae0e11',
            "imgGroup":[
                {"name":'首页',"img":'//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm1.png',"img_sel":'//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm1-1.png',"link":"/boguan_mall/pages/Tab/index/index","linkName":"页面:首页","linkType":""},
                {"name":'分类',"img":'//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm2.png',"img_sel":'//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm2-1.png',"link":"/boguan_mall/pages/Tab/category/category","linkName":"页面:商品分类","linkType":""},
                {"name":'购物车',"img":'//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm3.png',"img_sel":'//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm3-1.png',"link":"/boguan_mall/pages/Tab/cart/cart","linkName":"页面:购物车","linkType":""},
                {"name":'我的',"img":'//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm4.png',"img_sel":'//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm4-1.png',"link":"/boguan_mall/pages/Tab/user/user","linkName":"页面:个人中心","linkType":""}
            ]}

    ]<?php endif; ?>;
            var layoutModalSelect_original=[
                {
                    "id": 'b1',
                    "lm": 'bottomNav',
                    "title": '底部导航栏',
                    "stylediy": 1,
                    "bgColor": '#ffffff',
                    "original": '#666666',
                    "newCol": '#ae0e11',
                    "imgGroup": [
                        {
                            "name": '首页',
                            "img": '//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm1.png',
                            "img_sel": '//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm1-1.png',
                            "link": "/boguan_mall/pages/Tab/index/index",
                            "linkName": "页面:首页",
                            "linkType": ""
                        },
                        {
                            "name": '分类',
                            "img": '//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm2.png',
                            "img_sel": '//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm2-1.png',
                            "link": "/boguan_mall/pages/Tab/category/category",
                            "linkName": "页面:商品分类",
                            "linkType": ""
                        },
                        {
                            "name": '购物车',
                            "img": '//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm3.png',
                            "img_sel": '//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm3-1.png',
                            "link": "/boguan_mall/pages/Tab/cart/cart",
                            "linkName": "页面:购物车",
                            "linkType": ""
                        },
                        {
                            "name": '我的',
                            "img": '//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm4.png',
                            "img_sel": '//www.lg0578.com/addons/boguan_mall/boguan/public/boguan/images/lbm4-1.png',
                            "link": "/boguan_mall/pages/Tab/user/user",
                            "linkName": "页面:个人中心",
                            "linkType": ""
                        }
                    ],
                }

    ];

            console.log(layoutModalSelect)

</script>

