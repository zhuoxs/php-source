<?php if (!defined('THINK_PATH')) exit(); /*a:9:{s:116:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\public/../application/admin\view\general\config\index.html";i:1562722718;s:100:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\layout\default.html";i:1562722712;s:97:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\common\meta.html";i:1562722738;s:105:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\general\config\base.html";i:1562722720;s:114:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\general\config\small_program.html";i:1562722718;s:104:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\general\config\sms.html";i:1562722716;s:107:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\general\config\wechat.html";i:1562722716;s:105:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\general\config\rest.html";i:1562722718;s:99:"D:\phpStudy\PHPTutorial\WWW\we30\addons\make_freight\core\application\admin\view\common\script.html";i:1562722738;}*/ ?>
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
                                

<link href="/we30/addons/make_freight/core/public//assets/libs/color-picker/bootstrap-colorpicker.min.css" rel="stylesheet">



<div class="panel panel-default panel-intro">
    <div class="panel-heading">

        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#base" data-toggle="tab">基础配置</a></li>
            <li><a href="#small_program" data-toggle="tab">小程序配置</a></li>
            <li><a href="#sms" data-toggle="tab">短信配置</a></li>
            <li><a href="#ssl" data-toggle="tab">ssl证书</a></li>
            <li><a href="#wechat" data-toggle="tab">微信配置</a></li>
            <li><a href="#rest" data-toggle="tab">其他配置</a></li>
            <li><a href="#agreement" data-toggle="tab">协议设置</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="base">
                <form id="base" class="form-horizontal" data-toggle="validator" method="POST" action="config/base">
    <?php if(($auth->isSuperAdmin() )): ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">小程序uniacid：</label>
        <div class="col-sm-3">
            <input type="number" data-rule="" class="form-control" name="row[uniacid]"  value="<?php echo $uniacid['uniacid']; ?>" data-tip="微擎平台管理 点击模块的基本消息 消息推送URL地址后面的ID">
        </div>

    </div>
    <?php endif; ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">站点名称：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[admin_name]" <?php if(isset($setting['admin_name'])): ?> value="<?php echo $setting['admin_name']; ?>" <?php endif; ?> data-tip="请填写后台站点名称">
        </div>

    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">后台独立登录入口：</label>
        <div class="col-sm-3">
            <span  style="border: 0px solid #ffffff;" class="form-control" ><?php echo $_SERVER['HTTP_HOST']; ?>/addons/make_freight/core/public/index.php/admin/index/login</span>
        </div>
    </div>


    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

            </div>

            <div class="tab-pane fade" id="small_program">
                <form id="program-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/SmallProgram">
                
    <div class="form-group">
        <label class="col-sm-2 control-label">小程序顶部背景颜色：</label>
        <div class="col-sm-2">
            <div class="input-group"  style="display:inline">
                <input type="text" id='mycp' data-rule="" autocomplete="off" class="form-control" name="row[program_background]" <?php if(isset($setting['program_background'])): ?> value="<?php echo $setting['program_background']; ?>" <?php endif; ?>>
            </div>
        </div>
        <label class="col-sm-1 control-label">字体颜色：</label>
        <div class="col-sm-2">
            <div class="input-group"  style="display:inline">
                <select  id="c-status" data-rule="required" class="form-control selectpicker" style="display: inline-block !important;" name="row[program_font]">
                    <option value="#000000" <?php if(isset($setting['program_font'])): if($setting['program_font'] == '#000000'): ?>selected<?php endif; endif; ?> >黑色</option>
                    <option value="#ffffff" <?php if(isset($setting['program_font'])): if($setting['program_font'] == '#ffffff'): ?>selected<?php endif; endif; ?>>白色</option>
                </select>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>小程序顶部导航颜色</span>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">Logo:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-logo" class="form-control" size="50" name="row[logo]" type="text"  <?php if(isset($setting['logo'])): ?> value="<?php echo $setting['logo']; ?>" <?php endif; ?>>
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-logo" class="btn btn-danger plupload" data-input-id="c-logo" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-logo"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-logo" class="btn btn-primary fachoose" data-input-id="c-logo" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-logo"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-logo"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">分享图:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-share" data-rule="required" class="form-control" size="50" name="row[share]" type="text" <?php if(isset($setting['share'])): ?> value="<?php echo $setting['share']; ?>" <?php endif; ?>>
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-share" class="btn btn-danger plupload" data-input-id="c-share" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-share"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-share" class="btn btn-primary fachoose" data-input-id="c-share" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-share"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-share"></ul>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">小程序首页顶部标题：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[program_title]" <?php if(isset($setting['program_title'])): ?> value="<?php echo $setting['program_title']; ?>" <?php endif; ?> data-tip="请输入小程序首页标题">
        </div>
    </div>

    <hr>

    <div class="form-group">
        <label class="col-sm-2 control-label">AppID：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[appid]" <?php if(isset($setting['appid'])): ?> value="<?php echo $setting['appid']; ?>" <?php endif; ?> data-tip="请输入小程序APPID">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">AppSecret：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[appsecret]" <?php if(isset($setting['appsecret'])): ?> value="<?php echo $setting['appsecret']; ?>" <?php endif; ?> data-tip="请输入小程序秘钥">
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-sm-2 control-label">用户下单成功模板消息通知ID：</label>
        <div class="col-sm-3">
            <input id="user_input_tpl" type="text" data-rule="" class="form-control tplclass"  <?php if(isset($setting['user_msg_tpl'])): ?> value="<?php echo $setting['user_msg_tpl']; ?>" <?php endif; ?>>
        </div>
        <div class="col-xs-12 col-sm-1" style="padding-left:0;">
            <?php if(empty($setting['user_msg_tpl']) || (($setting['user_msg_tpl'] instanceof \think\Collection || $setting['user_msg_tpl'] instanceof \think\Paginator ) && $setting['user_msg_tpl']->isEmpty())): ?>
            <button type="button" class="btn  btn-info start_tpl"  id="user_msg_tpl" data-id="0">启用</button>
            <?php else: ?>
            <button type="button" class="btn  btn-info start_tpl"  id="user_msg_tpl" data-id="0" style="opacity: 0.65;box-shadow: none;">已启用</button>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">提醒司机接单模板消息通知ID：</label>
        <div class="col-sm-3">
            <input id="driver_input_tpl" type="text" data-rule="" class="form-control tplclass"  <?php if(isset($setting['driver_msg_tpl'])): ?> value="<?php echo $setting['driver_msg_tpl']; ?>" <?php endif; ?>>
        </div>
        <div class="col-xs-12 col-sm-1" style="padding-left:0;">
            <?php if(empty($setting['driver_msg_tpl']) || (($setting['driver_msg_tpl'] instanceof \think\Collection || $setting['driver_msg_tpl'] instanceof \think\Paginator ) && $setting['driver_msg_tpl']->isEmpty())): ?>
            <button type="button" class="btn btn-info start_tpl" id="driver_msg_tpl" data-id="1">启用</button>
            <?php else: ?>
            <button type="button" class="btn btn-info start_tpl" id="driver_msg_tpl" data-id="1" style="opacity: 0.65;box-shadow: none;">已启用</button>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-sm-2 control-label">高德地图key：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[amap]" <?php if(isset($setting['amap'])): ?> value="<?php echo $setting['amap']; ?>" <?php endif; ?> data-tip="请输入高德地图KEY">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">腾讯地图key：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[tmap]" <?php if(isset($setting['tmap'])): ?> value="<?php echo $setting['tmap']; ?>" <?php endif; ?> data-tip="请输入腾讯地图KEY">
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

            <div class="tab-pane fade" id="sms">
                <form id="sms" class="form-horizontal" data-toggle="validator" method="POST" action="config/sms">

    <div class="form-group">
        <label class="col-sm-2 control-label">AccessKeyId：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[ali_access]" <?php if(isset($setting['ali_access'])): ?> value="<?php echo $setting['ali_access']; ?>" <?php endif; ?> data-tip="请输入阿里云用户AccessKey ID">
        </div>

    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">AccessKeySecret：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[ali_secret]" <?php if(isset($setting['ali_secret'])): ?> value="<?php echo $setting['ali_secret']; ?>" <?php endif; ?> data-tip="请输入阿里云用户AccessKey Secret">
        </div>

    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">短信签名名称：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[sign_name]" <?php if(isset($setting['sign_name'])): ?> value="<?php echo $setting['sign_name']; ?>" <?php endif; ?>  data-tip="阿里云短信签名名称">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">验证码短信模板code：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[code_sms]" <?php if(isset($setting['code_sms'])): ?> value="<?php echo $setting['code_sms']; ?>" <?php endif; ?>  data-tip="请输入验证码短信模板">
        </div>
    </div>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

            </div>

            <div class="tab-pane fade" id="ssl">
                <form class="form-horizontal" data-toggle="validator" method="POST" action="config/ssl">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">证书KEY：</label>
                        <div class="col-sm-3">
                            <textarea class="form-control" name="row[ssl_key]" style="height:380px;resize: none;" > <?php echo $skey; ?> </textarea>
                        </div>

                        <label class="col-sm-1 control-label">证书PEM：</label>
                        <div class="col-sm-3">
                            <textarea class="form-control" name="row[ssl_pem]" style="height:380px;resize: none;" > <?php echo $spem; ?> </textarea>
                        </div>
                    </div>
                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12 col-sm-2"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="wechat">
                <form id="bse" class="form-horizontal" data-toggle="validator" method="POST" action="config/wechat">


    <div class="form-group">
        <label class="col-sm-1 control-label">商户号ID：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[mchid]" <?php if(isset($setting['mchid'])): ?> value="<?php echo $setting['mchid']; ?>" <?php endif; ?> data-tip="微信支付商户号">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">支付秘钥：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[pay_secret]" <?php if(isset($setting['pay_secret'])): ?> value="<?php echo $setting['pay_secret']; ?>" <?php endif; ?> data-tip="微信支付秘钥">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">商户证书cert：</label>
        <div class="col-sm-3">
            <textarea class="form-control" name="row[mch_cert]" style="height:380px;resize: none;" <?php if(isset($setting['mch_cert'])): ?>  placeholder="已保存" <?php endif; ?>  ></textarea>
        </div>

        <label class="col-sm-1 control-label">商户证书key：</label>
        <div class="col-sm-3">
            <textarea class="form-control" name="row[mch_key]" style="height:380px;resize: none;"  <?php if(isset($setting['mch_key'])): ?> value="<?php echo $setting['mch_key']; ?>" placeholder="已保存" <?php endif; ?> data-tip="复制apiclient_key证书内容粘贴"></textarea>
        </div>
    </div>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

            </div>

            <div class="tab-pane fade" id="rest">
                <form id="rest" class="form-horizontal" data-toggle="validator" method="POST" action="config/rest">
    <div class="form-group">
    <label class="control-label col-sm-2 ">小程序客服电话:</label>
    <div class="col-sm-3">
        <input type="number" class="form-control" name="row[service_tel]"  data-tip="小程序客服电话"  <?php if(isset($setting['service_tel'])): ?> value="<?php echo $setting['service_tel']; ?>" <?php endif; ?>>
    </div>
</div>
    <div class="form-group">
        <label class="control-label col-sm-2 ">订单抽成比例:</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" class="form-control" name="row[order_ratio]"  data-tip="平台抽成订单金额百分比" data-target="#commission" <?php if(isset($setting['order_ratio'])): ?> value="<?php echo $setting['order_ratio']; ?>" <?php endif; ?>>
                <span class="input-group-addon">%</span>
            </div>
        </div>
        <span class="help-block" id="commission"></span>

    </div>
    <div class="form-group">
        <label class="control-label col-sm-2 ">提现条件:</label>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon">满</span>
                <input type="number" class="form-control" name="row[withdrawal_condition]"  <?php if(isset($setting['withdrawal_condition'])): ?> value="<?php echo $setting['withdrawal_condition']; ?>" <?php endif; ?>>
                <span class="input-group-addon">元</span>
            </div>
        </div>
        <span class="help-block" id="withdrawal"></span>

    </div>
    <div class="form-group">
        <label class="control-label col-sm-2 ">订单推送范围:</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" class="form-control" name="row[scope]" placeholder="默认十公里内" data-tip="推送订单地址多少公里范围内的司机" data-target="#scope" <?php if(isset($setting['scope'])): ?> value="<?php echo $setting['scope']; ?>" <?php endif; ?>>
                <span class="input-group-addon">km</span>
            </div>
        </div>
        <span class="help-block" id="scope"></span>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2 ">取货、收货范围:</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" class="form-control" name="row[get_scope]" placeholder="默认五公里内" data-tip="司机直线距离取货地、收货地多少范围内才能取货或收货，注意不要设置小于1" data-target="#get_scope" <?php if(isset($setting['get_scope'])): ?> value="<?php echo $setting['get_scope']; ?>" <?php endif; ?>>
                <span class="input-group-addon">km</span>
            </div>
        </div>
        <span class="help-block" id="get_scope"></span>
    </div>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

            </div>
            <div class="tab-pane fade" id="agreement">
                <form id="agreement-form" class="form-horizontal"  role="form" data-toggle="validator" method="POST" action="general/config/agreement">
                    <div class="form-group">
                        <label class="control-label col-sm-2 ">用户协议:</label>
                        <div class="col-sm-8">
                            <textarea id="c-user_agm" data-rule="required" class="form-control editor form-control" rows="5" name="row[user_agm]" cols="50"><?php if(isset($setting['user_agm'])): ?> <?php echo $setting['user_agm']; endif; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 ">司机协议:</label>
                        <div class="col-sm-8">
                            <textarea id="c-driver_agm" data-rule="required" class="form-control editor form-control" rows="5" name="row[driver_agm]" cols="50"><?php if(isset($setting['driver_agm'])): ?> <?php echo $setting['driver_agm']; endif; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12 col-sm-2"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="/we30/addons/make_freight/core/public//assets/libs/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="/we30/addons/make_freight/core/public//assets/libs/color-picker/bootstrap-colorpicker.min.js"></script>
<script>

    $('#mycp').colorpicker({
        useAlpha: false
    });
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/we30/addons/make_freight/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/we30/addons/make_freight/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>