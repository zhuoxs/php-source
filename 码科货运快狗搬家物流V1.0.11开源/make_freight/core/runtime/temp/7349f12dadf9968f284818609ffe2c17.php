<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:107:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\public/../application/admin\view\vehicle\add.html";i:1562722700;s:100:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\layout\default.html";i:1562722712;s:97:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\common\meta.html";i:1562722738;s:99:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\common\script.html";i:1562722738;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/we30/addons/make_freight/core/public/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/we30/addons/make_freight/core/public/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/we30/addons/make_freight/core/public/assets/js/html5shiv.js"></script>
  <script src="/we30/addons/make_freight/core/public/assets/js/respond.min.js"></script>
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
                                
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
    input[type="number"]{
        -moz-appearance: textfield;
    }
</style>
<form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Load_capacity'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group no-border no-padding">
                <input id="c-load_capacity" data-rule="required" class="form-control" size="50" name="row[load_capacity]" type="number">
                <span class="input-group-addon">kg</span>
                <span class="msg-box n-right" for="c-load_capacity"></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">车身:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-length" placeholder="长" style="width: 30%" data-msg="&nbsp" data-target="#showmsg"   data-rule="required" class="form-control" name="row[length]" type="number">
                <input id="c-width"  placeholder="宽" style="width: 30%" data-msg="&nbsp" data-target="#showmsg"  data-rule="required" class="form-control" name="row[width]"  type="number">
                <input id="c-height" placeholder="高" style="width: 40%"  data-rule="required" data-target="#showmsg"  class="form-control" name="row[height]" type="number">
            </div>
            <span id="showmsg"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Icon'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-icon" data-rule="required" class="form-control" size="50" name="row[icon]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-icon" class="btn btn-danger plupload" data-input-id="c-icon" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-icon"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-icon" class="btn btn-primary fachoose" data-input-id="c-icon" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-icon"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-icon"></ul>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">选中图标:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-select_icon" data-rule="required" class="form-control" size="50" name="row[s_icon]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-select_icon" class="btn btn-danger plupload" data-input-id="c-select_icon" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-select_icon"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-select_icon" class="btn btn-primary fachoose" data-input-id="c-select_icon" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-select_icon"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-select_icon"></ul>
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-image" data-rule="required" class="form-control" size="50" name="row[image]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-image" class="btn btn-primary fachoose" data-input-id="c-image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-2 col-sm-2"><?php echo __('Starting_price'); ?>:</label>
        <div class="col-xs-3 col-sm-3">
            <div class="input-group">
                <input id="c-starting_price" data-rule="required" data-target="#start_pr" class="form-control" step="0.01" name="row[starting_price]" data-msg="请输入起步价格" type="number">
                <span class="input-group-addon" >元</span>
            </div>
            <span id="start_pr"></span>
        </div>
        <label class="control-label col-xs-2 col-sm-2"><?php echo __('Starting_km'); ?>:</label>
        <div class="col-xs-3 col-sm-3">
            <div class="input-group">
                <input  id="c-starting_km" data-rule="required" data-target="#starting_km" class="form-control" step="0.01" data-msg="请输入起步公里" name="row[starting_km]" type="number">
                <span class="input-group-addon">km</span>

            </div>
            <span id="starting_km"></span>
        </div>

    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Beyond_price'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-beyond_price" data-rule="required" class="form-control" name="row[beyond_price]" type="number">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">状态:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <label>
                    <input  name="row[status]" type="radio" value="0" />隐藏
                </label>
                <label>
                    <input  name="row[status]" type="radio" value="1" />显示
                </label>
            </div>

        </div>

    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">排序:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-sort" data-rule="required" class="form-control" name="row[sort]" type="number" data-tip="数值越大排序越靠前">
        </div>
    </div>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/we30/addons/make_freight/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/we30/addons/make_freight/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>