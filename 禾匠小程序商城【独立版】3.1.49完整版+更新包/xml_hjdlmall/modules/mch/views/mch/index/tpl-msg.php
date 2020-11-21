<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/12/28
 * Time: 15:53
 */
$this->title = '模板消息';
$url_manager = Yii::$app->urlManager;
?>

<div class="panel mb-3">
    <div class="panel-header">
        <span><?= $this->title ?></span>
    </div>
    <div class="panel-body">
        <form class="auto-form" method="post">
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right required">
                    <label class="col-form-label">入驻审核模板消息</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="apply" value="<?= $model['apply'] ?>">
                    <div class="text-muted fs-sm">管理员审核入驻商入驻申请后用户将收到小程序模板消息的通知，<a data-toggle="modal"
                                                                                  data-target="#tpl1"
                                                                                  href="javascript:">查看模板消息格式</a></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right required">
                    <label class="col-form-label">下单模板消息</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="order" value="<?= $model['order'] ?>">
                    <div class="text-muted fs-sm">用户下单后入驻商户将收到小程序模板消息的通知，<a data-toggle="modal" data-target="#tpl2"
                                                                            href="javascript:">查看模板消息格式</a></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right"></div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tpl1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">模板消息格式</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img style="max-width: 100%" src="<?= Yii::$app->request->baseUrl ?>/statics/images/mch-tpl-1.png">
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tpl2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">模板消息格式</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img style="max-width: 100%" src="<?= Yii::$app->request->baseUrl ?>/statics/images/mch-tpl-2.png">
            </div>
        </div>
    </div>
</div>