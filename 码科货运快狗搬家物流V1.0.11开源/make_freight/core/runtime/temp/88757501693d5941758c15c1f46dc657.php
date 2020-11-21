<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:111:"/www/wwwroot/wushanw.com/addons/make_freight/core/public/../application/admin/view/general/config/activity.html";i:1562722721;s:92:"/www/wwwroot/wushanw.com/addons/make_freight/core/application/admin/view/layout/default.html";i:1562722713;s:89:"/www/wwwroot/wushanw.com/addons/make_freight/core/application/admin/view/common/meta.html";i:1562722739;s:91:"/www/wwwroot/wushanw.com/addons/make_freight/core/application/admin/view/common/script.html";i:1562722738;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/addons/make_freight/core/public/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/addons/make_freight/core/public/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/addons/make_freight/core/public/assets/js/html5shiv.js"></script>
  <script src="/addons/make_freight/core/public/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
        input[type="number"]{
            -moz-appearance: textfield;
        }
    </style>
    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#user" data-toggle="tab">优惠券活动设置</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="user">
                <div class="box box-success">
                    <form id="activity-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/activity">
                        <div class="panel-heading"><span class="heading-span">新人优惠券活动</span></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label" style="">可获得优惠券：</label>
                                <div class="col-sm-3">
                                    <select id="c-coupons" data-rule="required" class="form-control" name="row[coupon_id]">
                                        <option value="0" <?php if(isset($setting['coupon_id'])): if($setting['coupon_id'] == '0'): ?> selected <?php endif; endif; ?>>关闭活动</option>
                                        <?php foreach($coupons as $k=>$v): ?>
                                        <option value="<?php echo $v['id']; ?>" <?php if(isset($setting['coupon_id'])): if($setting['coupon_id'] == $v['id']): ?> selected <?php endif; endif; ?> ><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-1">背景图:</label>
                                <div class="col-xs-12 col-sm-3">
                                    <div class="input-group">
                                        <input id="c-coupon_back" data-rule="required" class="form-control" size="50" name="row[coupon_back]" type="text" <?php if(isset($setting['coupon_back'])): ?> value="<?php echo $setting['coupon_back']; ?>" <?php endif; ?>>
                                        <div class="input-group-addon no-border no-padding">
                                            <span><button type="button" id="plupload-coupon_back" class="btn btn-danger plupload" data-input-id="c-coupon_back" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-coupon_back"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                                            <span><button type="button" id="fachoose-coupon_back" class="btn btn-primary fachoose" data-input-id="c-coupon_back" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                                        </div>
                                        <span class="msg-box n-right" for="c-coupon_back"></span>
                                    </div>
                                    <ul class="row list-inline plupload-preview" id="p-coupon_back"></ul>
                                </div>
                            </div>

                        </div>

                        <div class="form-group layer-footer">
                            <label class="control-label col-xs-12 col-sm-2"></label>
                            <div class="col-xs-12 col-sm-8">
                                <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
                                <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>








                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/addons/make_freight/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_freight/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>