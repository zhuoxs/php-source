<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">编辑封面</div>
                    </div>
                    <div class="widget-body am-fr">
                        <form id="my-form" class="am-form tpl-form-line-form"
                              action="" enctype="multipart/form-data" method="post">
                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">封面分类
                                    <span class="tpl-form-line-small-title">Class</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <select data-am-selected="{searchBox: 1}" name="Cover[class_id]"
                                            style="display: none;">
                                        <?php foreach ($class_list as $item) : ?>
                                            <option value="<?= $item['class_id'] ?>"
                                                <?= $item['class_id'] == $model->class_id ? 'selected' : '' ?>>
                                                <?= $item['class_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="am-form-group am-form-file">
                                <label for="cate-name" class="am-u-sm-3 am-form-label">封面图片
                                    <span class="tpl-form-line-small-title">Image</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <button type="button" class="am-btn am-btn-success am-btn-sm">
                                        <i class="am-icon-cloud-upload" style="color: #fff;"></i> 选择要上传的图片
                                    </button>
                                    <input id="doc-form-file" name="uploadFile" type="file"
                                           accept="image/jpeg,image/png,image/gif">
                                    <p class="tpl-form-line-small-info">
                                        <small>请上传2M以内图片格式文件(jpg、png、gif) 推荐尺寸：600 * 400 </small>
                                    </p>
                                    <div id="file-list">
                                        <span class="am-badge"><?= $model->image ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="cate-name" class="am-u-sm-3 am-form-label">排序
                                    <span class="tpl-form-line-small-title">Sort</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="number" class="tpl-form-input"
                                           name="Cover[sort]"
                                           value="<?= $model->sort ?>"
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

        $('#doc-form-file').on('change', function () {
            var fileNames = '';
            $.each(this.files, function () {
                fileNames += '<span class="am-badge">' + this.name + '</span> ';
            });
            $('#file-list').html(fileNames);
        });

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
