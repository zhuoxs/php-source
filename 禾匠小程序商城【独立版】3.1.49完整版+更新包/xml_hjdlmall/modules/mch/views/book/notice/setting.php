<?php
defined('YII_ENV') or exit('Access Denied');
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/6/19
 * Time: 16:52
 */
$urlManager = Yii::$app->urlManager;
$this->title = '消息通知';
$this->params['active_nav_group'] = 10;
$this->params['is_book'] = 1;
?>
<style>
    .tip-block {
        height: 0;
        overflow: hidden;
        visibility: hidden;
    }

    .tip-block.active {
        height: auto;
        visibility: visible;
    }
</style>
<div class="panel mb-3">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">
        <form class="auto-form" method="post" autocomplete="off">
            <div class="form-group row">
                <div class="col-sm-3 text-right">
                    <label class="col-form-label">预约成功通知模板ID</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" value="<?= $setting['success_notice'] ?>"
                           name="model[success_notice]">
                    <div class="text-muted"><a class="show-tip" href="javascript:" data-tip="tip1">模板消息格式说明</a>
                    </div>
                    <div class="tip-block" id="tip1">
                        <img style="max-width: 100%"
                             src="<?= Yii::$app->request->baseUrl ?>/statics/images/yy_success_notice.png">
                    </div>
                </div>
            </div>

            <div class="form-group row" hidden>
                <div class="col-sm-3 text-right">
                    <label class="col-form-label">预约失败退款通知模板ID</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" value="<?= $model['pintuan_fail_notice'] ?>"
                           name="pintuan_fail_notice">
                    <div class="text-muted"><a class="show-tip" href="javascript:" data-tip="tip2">模板消息格式说明</a>
                    </div>
                    <div class="tip-block" id="tip2">
                        <img style="max-width: 100%"
                             src="<?= Yii::$app->request->baseUrl ?>/statics/images/yy_refund_notice.png">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3 text-right">
                    <label class="col-form-label">预约失败退款通知模板ID</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" value="<?= $setting['refund_notice'] ?>"
                           name="model[refund_notice]">
                    <div class="text-muted"><a class="show-tip" href="javascript:" data-tip="tip3">模板消息格式说明</a>
                    </div>
                    <div class="tip-block" id="tip3">
                        <img style="max-width: 100%"
                             src="<?= Yii::$app->request->baseUrl ?>/statics/images/yy_refund_notice.png">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3 text-right">
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).on('click', '.show-tip', function () {
        var tip = $(this).attr('data-tip');
        if ($('#' + tip).hasClass('active')) {
            $('#' + tip).removeClass('active');
        } else {
            $('#' + tip).addClass('active');
        }
    });
</script>