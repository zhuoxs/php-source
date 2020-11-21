<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">添加封面分类</div>
                    </div>
                    <div class="widget-body am-fr">
                        <form id="my-form" class="am-form tpl-form-line-form"
                              action="" enctype="multipart/form-data" method="post">
                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">分类名称
                                    <span class="tpl-form-line-small-title">Name</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="CoverClass[class_name]"
                                           value=""
                                           placeholder="请输入分类名称"
                                           required="required">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="cate-name" class="am-u-sm-3 am-form-label">排序
                                    <span class="tpl-form-line-small-title">Sort</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="number" class="tpl-form-input"
                                           name="CoverClass[sort]"
                                           value="100"
                                           placeholder="请输入排序"
                                           required="required">
                                    <p class="tpl-form-line-small-info">
                                        <small>数字越小越靠前</small>
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
