<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 15:40
 */
defined('YII_ENV') or exit('Access Denied');
/* @var $sms \app\models\SmsSetting */
$urlManager = Yii::$app->urlManager;
$this->title = '短信设置';
$this->params['active_nav_group'] = 1;
?>

<div class="panel">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">
        <form method="post" class="auto-form">
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">手机号(手动授权)</label>
                </div>
                <div class="col-sm-6">
                    <label class="radio-label">
                        <input id="radio2" <?= $option == 'off' ? 'checked' : null ?>
                               value=off
                               name="switch" type="radio" class="custom-control-input">
                        <span class="label-icon"></span>
                        <span class="label-text">关闭</span>
                    </label>
                    <label class="radio-label">
                        <input id="radio1" <?= $option == 'on' ? 'checked' : null ?>
                               value=on
                               name="switch" type="radio" class="custom-control-input">
                        <span class="label-icon"></span>
                        <span class="label-text">开启</span>
                    </label>
                </div>
            </div>


            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                </div>
            </div>

        </form>
    </div>
</div>
