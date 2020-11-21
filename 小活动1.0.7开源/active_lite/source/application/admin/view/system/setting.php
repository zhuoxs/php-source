<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">系统设置</div>
                    </div>
                    <div class="widget-body am-fr">
                        <form id="my-form" class="am-form tpl-form-line-form"
                              action=""  method="post">
                            <div class="am-form-group">
                                <label for="cate-name" class="am-u-sm-3 am-form-label">小程序名称</label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="Wxapp[app_name]"
                                           value="<?= $wxapp->app_name ?>"
                                           placeholder="请输入小程序名称"
                                           required="required">
                                    <p class="tpl-form-line-small-info">
                                        <small>显示在小程序端标题</small>
                                    </p>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="cate-name" class="am-u-sm-3 am-form-label">小程序AppID</label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="Wxapp[app_id]"
                                           value="<?= $wxapp->app_id ?>"
                                           placeholder="请输入小程序AppID"
                                           required="required">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="cate-name" class="am-u-sm-3 am-form-label">小程序AppSecret</label>
                                <div class="am-u-sm-9">
                                    <input type="password" class="tpl-form-input"
                                           name="Wxapp[app_secret]"
                                           value="<?= $wxapp->app_secret ?>"
                                           placeholder="请输入小程序AppSecret"
                                           required="required">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="cate-name" class="am-u-sm-3 am-form-label">简述</label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="Wxapp[description]"
                                           value="<?= $wxapp->description ?>"
                                           placeholder="">
                                    <p class="tpl-form-line-small-info">
                                        <small>显示在意见与反馈页面</small>
                                    </p>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <button type="submit"
                                            class="am-btn am-btn-primary tpl-btn-bg-color-success j-submit">提交
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(function () {
        /**
         * 表单验证提交
         * @type {*}
         */
        var $my_form = $('#my-form');
        $my_form.validator({
            submit: function () {
                if (this.isFormValid() === true) {
                    // 禁用按钮, 防止二次提交
                    $('.j-submit').attr('disabled', true);

                    // 表单提交
                    $my_form.ajaxSubmit({
                        type: "post",
                        dataType: "json",
                        success: function (data) {
                            laymsg(data);
                            $('.j-submit').attr('disabled', false);
                        }
                    });
                }
                return false;
            }
        });
    });
</script>
